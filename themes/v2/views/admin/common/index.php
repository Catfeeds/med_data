<?php
$this->pageTitle = $this->siteName.'后台欢迎您';
?>
<style type="text/css">
    .page-content{
       background: #F1F3FA;
    }
    </style>
<div class="alert alert-info">
   <center><strong><?=Yii::app()->user->username?></strong> 您好，欢迎登录常州制药厂数据系统后台！</center>
</div>
<div class="row">
    <div class="col-lg-4 col-md-4">
        <div class="dashboard-stat blue-madison">
            <div class="visual">
                <i class="fa fa-comments"></i>
            </div>
            <div class="details">
                <div class="number">
                    <?php echo ProExt::model()->count() ?>
                </div>
                <div class="desc">
                    项目总数
                </div>
            </div>
            <a class="more" href="<?php echo $this->createUrl('pro/list')?>">
                查看更多 <i class="m-icon-swapright m-icon-white"></i>
            </a>
        </div>
    </div>
    <div class="col-lg-4 col-md-4">
        <div class="dashboard-stat red-intense">
            <div class="visual">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="details">
                <div class="number">
                    <?php echo HospitalExt::model()->count() ?>
                </div>
                <div class="desc">
                    合作机构总数
                </div>
            </div>
            <a class="more" href="<?php echo $this->createUrl('hospital/list')?>">
                查看更多 <i class="m-icon-swapright m-icon-white"></i>
            </a>
        </div>
    </div>
    <div class="col-lg-4 col-md-4">
        <div class="dashboard-stat green-haze">
            <div class="visual">
                <i class="fa fa-shopping-cart"></i>
            </div>
            <div class="details">
                <div class="number">
                    <?php echo DoctorExt::model()->count() ?>
                </div>
                <div class="desc">
                    医职人员总数
                </div>
            </div>
            <a class="more" href="<?php echo $this->createUrl('doctor/list')?>">
                查看更多 <i class="m-icon-swapright m-icon-white"></i>
            </a>
        </div>
    </div>
</div>
<div class="row">
	<div class="col-md-6 col-sm-6">
					<div class="portlet light ">
						<div class="portlet-title">
							<div class="caption">
								<i class="icon-share font-blue-steel hide"></i>
								<span class="caption-subject font-blue-steel bold uppercase">最近的事件</span>
							</div>
							<div class="actions">
							</div>
						</div>
						<div class="portlet-body">
							<div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 300px;"><div class="scroller" style="height: 300px; overflow: hidden; width: auto;" data-always-visible="1" data-rail-visible="0" data-initialized="1">
								<ul class="feeds">
									<li>
										<div class="col1">
											<div class="cont">
												<!-- <div class="cont-col1">
													<div class="label label-sm label-info">
														<i class="fa fa-check"></i>
													</div>
												</div> -->
												<div class="cont-col2">
													<div class="desc">
														 <strong>项目1</strong> 有了新的数据录入 
														</span>
													</div>
												</div>
											</div>
										</div>
										<div class="col2" style="width:108px;margin-left: -116px">
											<div class="date">
												 <?=date('m-d H:i',time())?>
											</div>
										</div>
									</li>
									<?php if($ress = DataExt::model()->findAll(['order'=>'created desc','limit'=>20])) foreach ($ress as $key => $value) {?>
										<li>
										<div class="col1">
											<div class="cont">
												<!-- <div class="cont-col1">
													<div class="label label-sm label-info">
														<i class="fa fa-check"></i>
													</div>
												</div> -->
												<div class="cont-col2">
													<div class="desc">
														 <strong><?=$value->pro->xmjc?></strong> 有了新的数据录入 
														</span>
													</div>
												</div>
											</div>
										</div>
										<div class="col2" style="width:108px;margin-left: -116px">
											<div class="date">
												 <?=date('m-d H:i',time())?>
											</div>
										</div>
									</li>
									<?php } ?>
								</ul>
							</div><div class="slimScrollBar" style="background: rgb(187, 187, 187); width: 7px; position: absolute; top: 0px; opacity: 0.4; display: block; border-radius: 7px; z-index: 99; right: 1px; height: 187.11px;"></div><div class="slimScrollRail" style="width: 7px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; background: rgb(234, 234, 234); opacity: 0.2; z-index: 90; right: 1px;"></div></div>
							<div class="scroller-footer">
								<div class="btn-arrow-link pull-right">
									<a href="javascript:;">查看更多</a>
									<i class="icon-arrow-right"></i>
								</div>
							</div>
						</div>
					</div>
				</div>
</div>