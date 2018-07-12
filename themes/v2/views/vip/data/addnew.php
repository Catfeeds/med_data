<?php
$this->pageTitle = '填表须知';
$this->breadcrumbs = array( $this->pageTitle);
?>
<div class="note note-info">
	<!-- <h4 class="block">Info! Some Header Goes Here</h4> -->
	<p>
		 <?=$pinfo->xmjj?>
	</p>
</div>
<?php $form = $this->beginWidget('HouseForm', array('htmlOptions' => array('class' => 'form-horizontal'))) ?>
<div class="form-group">
    <label class="col-md-2 control-label">患者名字<span class="required" aria-required="true">*</span></label>
    <div class="col-md-4">
        <?php echo $form->textField($article, 'iname', array('class' => 'form-control')); ?>
    </div>
    <div class="col-md-2"><?php echo $form->error($article, 'iname') ?></div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">患者编号<span class="required" aria-required="true">*</span></label>
    <div class="col-md-4">
        <?php echo $form->textField($article, 'ino', array('class' => 'form-control')); ?>
    </div>
    <div class="col-md-2"><?php echo $form->error($article, 'ino') ?></div>
</div>
<div class="form-actions">
    <div class="row">
        <div class="col-md-offset-3 col-md-9">
            <button type="submit" class="btn green">确定</button>
            <?php echo CHtml::link('返回',$this->createUrl('list'), array('class' => 'btn default')) ?>
        </div>
    </div>
</div>
<?php $this->endWidget() ?>

