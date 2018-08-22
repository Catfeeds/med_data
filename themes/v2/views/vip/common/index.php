<?php
$this->pageTitle = '常州制药厂病例数据录入系统欢迎您！';
?>
<div class="alert alert-info">
   <center><strong><?=Yii::app()->user->username?></strong> 您好，您上次登录的时间为<?=date("Y-m-d H:i:s",$this->user->last_login)?>。常州制药厂病例数据录入系统欢迎您！</center>
</div>
<div class="row">
    <?php if($pros = $this->hospital->pros) foreach ($pros as $key => $value) {?>
        <div class="col-md-6">
            <ul class="ver-inline-menu tabbable margin-bottom-25">
                        <li class="active">
                            <a href="#tab_1"  aria-expanded="false">
                            <i class="fa fa-briefcase"></i> <?=$value->title?> </a>
                            <span class="after">
                            </span>
                        </li>
                        <li class="">
                            <a href="#tab_2"  aria-expanded="false">
                            <i class="fa fa-group"></i> 总例数：<?=$value->num?> </a>
                        </li>
                        <li class="">
                            <a href="#tab_1"  aria-expanded="false">
                            <i class="fa fa-info-circle"></i> 随机类型：<?=$value->sjlx?> </a>
                        </li>

                        <li class="">
                            <a href="#tab_3"  aria-expanded="false">
                            <i class="fa fa-tasks"></i> 盲法类型：<?=$value->mflx?> </a>
                        </li>
                    </ul>
                    <div class="portlet-body">
                                        <div class="row number-stats margin-bottom-30">
                                            <div class="col-md-6 col-sm-6 col-xs-6">
                                                <div class="stat-left">
                                                    <div class="stat-chart">
                                                        <!-- do not line break "sparkline_bar" div. sparkline chart has an issue when the container div has line break -->
                                                        <div id="sparkline_bar"><canvas width="90" height="45" style="display: inline-block; width: 90px; height: 45px; vertical-align: top;"></canvas></div>
                                                    </div>
                                                    <div class="stat-number">
                                                        <div class="title">
                                                             总例数
                                                        </div>
                                                        <div class="number">
                                                             <?=$value->num?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6 col-xs-6">
                                                <div class="stat-right">
                                                    <div class="stat-chart">
                                                        <!-- do not line break "sparkline_bar" div. sparkline chart has an issue when the container div has line break -->
                                                        <div id="sparkline_bar2"><canvas width="90" height="45" style="display: inline-block; width: 90px; height: 45px; vertical-align: top;"></canvas></div>
                                                    </div>
                                                    <div class="stat-number">
                                                        <div class="title">
                                                             已完成
                                                        </div>
                                                        <div class="number">
                                                             <?=DataExt::model()->count('pid='.$value->id)?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="table-scrollable table-scrollable-borderless">
                                            <table class="table table-hover table-light">
                                            <thead>
                                            <tr class="uppercase">
                                                <th>
                                                     机构名
                                                </th>
                                                <th>
                                                     承担例数
                                                </th>
                                                <th>
                                                     完成例数
                                                </th>
                                                <th>
                                                     完成率
                                                </th>
                                                <th>
                                                     身份
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php if($hs = $value->hospitals) foreach ($hs as $h) { $proh = ProHospitalExt::model()->find("hid=".$h->id." and pid=".$value->id);  ?>
                                                <tr>
                                                    <td>
                                                        <?=$h->name?>
                                                    </td>
                                                    <td>
                                                        <?php $hisall = $proh->num;echo $hisall;?>
                                                    </td>
                                                    <td>
                                                         <?php $hisf = DataExt::model()->count("hid=".$h->id." and pid=".$value->id);echo $hisf;?>
                                                    </td>
                                                    <td>
                                                         <span class="bold theme-font"><?=$hisall?(int)$hisf/$hisall:0?>%</span>
                                                    </td>
                                                    <td>
                                                         <?=$proh->is_major?'组长':'组员'?>
                                                    </td>
                                                </tr>
                                           <?php  } ?>
                                                
                                           
                                            </tbody></table>
                                        </div>
                                    </div>
        </div>
    <?php } ?>
</div>