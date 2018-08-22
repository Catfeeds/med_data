<?php
$this->pageTitle = '数据汇总';
$this->breadcrumbs = array($this->pageTitle);
?>
<div class="table-toolbar">
    <div class="btn-group pull-left">
        <form class="form-inline form-horizontal">
            <div class="form-group" style="width: 600px">
                <div class="col-md-12">
                 <?php echo CHtml::dropDownList('type',$type,CHtml::listData(HospitalExt::model()->findAll(),'id','name'), array('style'=>'min-width:200px','class'=>'form-control select2','encode'=>false,'multiple'=>'multiple','placeholder'=>'请选择机构')); ?>
                </div>
            </div>
            <button type="submit" class="btn blue">搜索</button>
            <a class="btn yellow" onclick="removeOptions()"><i class="fa fa-trash"></i>&nbsp;清空</a>
            <input type="hidden" name="mid" value="<?=$mid?>">
            <input type="hidden" name="id" value="<?=$thisid?>">
        </form>
    </div>
    <div class="pull-right">
        <a target="_blank" href="<?php echo $this->createAbsoluteUrl('export',['id'=>$thisid,'op'=>$op]) ?>" class="btn yellow">
            导出数据
        </a>
        <a href="<?php echo $this->createAbsoluteUrl('taglist',['mid'=>$mid]) ?>" class="btn blue">
           返回列表
        </a>
    </div>
</div>
<table class="table table-bordered table-striped table-condensed flip-content table-hover">
    <thead class="flip-content">
    <tr>
        <th class="text-center">患者id</th>
        <?php if($pes) {
          foreach ($pes as $key => $value) {?>
            <th class="text-center"><?=$value?></th>
         <?php  }
          } ?>
    </tr>
    </thead>
    <tbody>
    <?php if($datas) foreach($datas as $k=>$v): ?>
        <tr>
            <td style="text-align:center;vertical-align: middle"><?php echo $k; ?></td>
            <?php if($v)  foreach ($ppids as $key => $value) {?>
              <td class="text-center"><?=isset($v[$value])?$v[$value]:''?></td>
            <?php  } ?>
        </tr>
    <?php endforeach;?>
    </tbody>
</table>


<?php
//Select2
Yii::app()->clientScript->registerScriptFile('/static/global/plugins/select2/select2.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerCssFile('/static/global/plugins/select2/select2.css');
Yii::app()->clientScript->registerCssFile('/static/admin/pages/css/select2_custom.css');

//boostrap datetimepicker
Yii::app()->clientScript->registerCssFile('/static/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css');
Yii::app()->clientScript->registerScriptFile('/static/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile('/static/global/plugins/bootstrap-datetimepicker/js/locales/bootstrap-datetimepicker.zh-CN.js', CClientScript::POS_END, array('charset'=> 'utf-8'));

// Yii::app()->clientScript->registerScriptFile('/static/global/plugins/bootbox/bootbox.min.js', CClientScript::POS_END);

$js = "

    var getHousesAjax =
     {
        url: '".$this->createUrl('/admin/plot/AjaxGetHouse')."',"."
        dataType: 'json',
        delay: 250,
        data: function (params) {
            return {
                kw:params
            };
        },
        results:function(data){
            var items = [];

             $.each(data.results,function(){
                var tmp = {
                    id : this.id,
                    text : this.name
                }
                items.push(tmp);
            });

            return {
                results: items
            };
        },
        processResults: function (data, page) {
            var items = [];
             $.each(data.msg,function(){
                var tmp = {
                    id : this.id,
                    text : this.title
                }
                items.push(tmp);
            });
            return {
                results: items
            };
        }
    }
        $(function(){

           $('.select2').select2({
              placeholder: '请选择',
              allowClear: true
           });

        var houses_edit = $('#plot');
        var data = {};
        if( houses_edit.length && houses_edit.data('houses') ){
          data = eval(houses_edit.data('houses'));
        }

        $('#plot').select2({
          multiple:true,
          ajax: getHousesAjax,
          language: 'zh-CN',
          initSelection: function(element, callback){
            callback(data);
          }
        });

             $('.form_datetime').datetimepicker({
                 autoclose: true,
                 isRTL: Metronic.isRTL(),
                 format: 'yyyy-mm-dd hh:ii',
                 // minView: 'm',
                 language: 'zh-CN',
                 pickerPosition: (Metronic.isRTL() ? 'bottom-right' : 'bottom-left'),
             });

             $('.form_datetime1').datetimepicker({
                 autoclose: true,
                 isRTL: Metronic.isRTL(),
                 format: 'yyyy-mm-dd',
                 minView: 'month',
                 language: 'zh-CN',
                 pickerPosition: (Metronic.isRTL() ? 'bottom-right' : 'bottom-left'),
             });
        });
        ";

Yii::app()->clientScript->registerScript('add',$js,CClientScript::POS_END);
?>
<?php
//Yii::app()->clientScript->registerScriptFile('/static/admin/pages/scripts/union-select.js', CClientScript::POS_END);
//Yii::app()->clientScript->registerScriptFile('/static/admin/pages/scripts/union-select.js', CClientScript::POS_END);
?>
