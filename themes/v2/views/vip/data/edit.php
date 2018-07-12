<?php
$this->pageTitle = '数据录入';
$this->breadcrumbs = array( $this->pageTitle);
?>
<style type="text/css">
	.w1{
		width: 100px
	}
</style>
<div class="alert alert-info">
   <p>项目信息：<?=$pinfo->title?> </p>
   <p>患者编号：<?=$article->ino?> </p>
   <p>患者姓名：<?=$article->iname?></p>
</div>
<div class="tabbable tabbable-tabdrop">
    <ul class="nav nav-tabs">
        <!-- <li class="dropdown pull-right tabdrop"><a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-ellipsis-v"></i>&nbsp;<i class="fa fa-angle-down"></i> <b class="caret"></b></a>
            <ul class="dropdown-menu">
                <li class="">
                    <a href="#tab8" data-toggle="tab" aria-expanded="false">Section 8</a>
                </li>
            </ul>
        </li> -->
        <?php  if($pps = $pinfo->periods) foreach ($pps as $key => $value) {?>
        	<li class="<?=$value->id==$ppid?'active':''?>">
        	<?php $g = $_GET;
        	unset($g['ppid']);
        	$g['ppid'] = $value->id;
        	?>
            <a href="<?=$this->createUrl('edit',$g)?>"  aria-expanded="<?=!$key?'true':'false'?>"><?=$value->name?></a>
        </li>
        <?php  } ?>
    </ul>
    <div class="tab-content">
    <?php if($pps) foreach ($pps as $key => $value) {?>
    	<div class="tab-pane <?=$value->id==$ppid?'active':''?>" id="tab<?=$key+1?>">
            <div class="portlet-body">
				<div class="panel-group accordion" id="accordion1">
				<?php if($cates = $value->cates) foreach ($cates as $k => $v) {?>
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">
							<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion1" href="#collapse_<?=$k+1?>" aria-expanded="false">
							<?=$v->name?> </a>
							</h4>
						</div>
						<div id="collapse_<?=$k+1?>" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
							<div class="panel-body">
							<!-- 不是量表 -->
								<?php if($v->lid==0): ?>
									<table class="table table-bordered table-striped">
							
							<tbody>
							<?php if($ms = $v->tags) foreach ($ms as $m) {?>
								<tr>
									<td style="width: 300px">
										 <?=$m->name?>
									</td>
									<td>
									<!-- 内置标签 -->
										<?php if($m->tid): $tag = $m->tag;  ?>
											<?=$tag->name?>：<input type="text" name="" class="form-inline w1" > <?=CHtml::dropDownList('unit','',explode(' ', $tag->unit))?>
											临床意义：<input type="text" name="" class="form-inline w1" > NCI分级：<input type="text" name="" class="form-inline w1" >
										<?php else:?>
											<?php foreach (range(1, 10) as $n) { $nam = 'n'.$n;$no = 'o'.$n;$ns = 's'.$n;$nt = 't'.$n; ?>
												<?php if($m->$nam): ?>
													<?php switch ($m->$nt) {
														case '1':?>
															<?=$m->$nam?> <input type="text" name="" class="form-inline w1" ><br style="margin-top: 30px">
															<?php break;
														case '2':?>
														<?php $arr = []; if($m->$no) {
															$noarr = array_filter(explode(' ', $m->$no));
															$nsarr = array_values(explode(' ', $m->$ns));
															// var_dump($noarr,$nsarr);exit;
															$arr = array_combine($nsarr, $noarr);
															// foreach (explode(' ', $m->no) as $key => $value) {
															// 	# code...
															// }
															} ?>
														<?=$m->$nam?> <?=CHtml::radioButtonList('op','',$arr,['separator'=>' '])?><br style="margin-top: 30px">
														<?php break;
														case '3': ?>
															<?php $arr = []; if($m->$no) {
															$noarr = array_filter(explode(' ', $m->$no));
															$nsarr = array_values(explode(' ', $m->$ns));
															// if(count($noarr)!=count($nsarr)) {
															// 	var_dump($noarr,$nsarr);exit;
															// }
															$arr = array_combine($nsarr, $noarr);
															// foreach (explode(' ', $m->no) as $key => $value) {
															// 	# code...
															// }
															} ?>
															<?=$m->$nam?> <?=CHtml::checkBoxList('op','',$arr,['separator'=>' '])?><br style="margin-top: 30px">
															<?php break;
													} ?>
												<?php else: break;?>
												<?php endif; ?>
											<?php } ?>
										<?php endif;?>
									</td>
								</tr>
							<?php } ?>
							
							</tbody>
							</table>
									<?php?>
								<?php else:?>

								<?php endif;?>
							</div>
						</div>
					</div>
				<?php } ?>
					
				</div>
			</div>
        </div>
   <?php  } ?>
    </div>
</div>