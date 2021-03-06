<?php
$this->pageTitle = $this->controllerName.'新建/编辑';
$this->breadcrumbs = array($this->controllerName.'管理', $this->pageTitle);
// $casee = CaseExt::model()->findByPk($type);
?>
<?php $this->widget('ext.ueditor.UeditorWidget',array('id'=>'UserExt_content','options'=>"toolbars:[['fullscreen','source','undo','redo','|','customstyle','paragraph','fontfamily','fontsize'],
        ['bold','italic','underline','fontborder','strikethrough','superscript','subscript','removeformat',
        'formatmatch', 'autotypeset', 'blockquote', 'pasteplain','|',
        'forecolor','backcolor','insertorderedlist','insertunorderedlist','|',
        'rowspacingtop','rowspacingbottom', 'lineheight','|',
        'directionalityltr','directionalityrtl','indent','|'],
        ['justifyleft','justifycenter','justifyright','justifyjustify','|','link','unlink','|',
        'insertimage','emotion','scrawl','insertvideo','music','attachment','map',
        'insertcode','|',
        'horizontal','inserttable','|',
        'print','preview','searchreplace']]")); ?>
<?php $form = $this->beginWidget('HouseForm', array('htmlOptions' => array('class' => 'form-horizontal'))) ?>
<?php if($infos) foreach ($infos as $key => $article) { $casee = $article->case; ?>
<div class="note note-info">
    <!-- <h4 class="block">Info! Some Header Goes Here</h4> -->
    <center>    <p>
         病例名：<strong><?=$casee->name?></strong> 
    </p></center>
</div>
  <div class="form-group">
    <label class="col-md-2 control-label">患者姓名</label>
    <div class="col-md-4">
        <?php echo $form->textField($article, 'name', array('class' => 'form-control')); ?>
    </div>
    <div class="col-md-2"><?php echo $form->error($article, 'name') ?></div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">患者联系方式</label>
    <div class="col-md-4">
        <?php echo $form->textField($article, 'phone', array('class' => 'form-control')); ?>
    </div>
    <div class="col-md-2"><?php echo $form->error($article, 'phone') ?></div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">患者地址</label>
    <div class="col-md-4">
        <?php echo $form->textField($article, 'addr', array('class' => 'form-control')); ?>
    </div>
    <div class="col-md-2"><?php echo $form->error($article, 'addr') ?></div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">性别</label>
    <div class="col-md-4">
        <?php echo $form->radioButtonList($article, 'sex', ['1'=>'男','2'=>'女'], array('separator' => '')); ?>
    </div>
    <div class="col-md-2"><?php echo $form->error($article, 'sex') ?></div>
</div>
<div class="form-group">
      <label class="col-md-2 control-label text-nowrap">附件图</label>
      <div class="col-md-4">
          <div id="uploader" class="wu-example">
              <div class="btns">
                  <!--<div id="cover_img">选择文件</div>-->
                  <?php $this->widget('FileUpload',array('model'=>$article,'attribute'=>'image','inputName'=>'image','width'=>'300','removeCallback'=>"$('#image').html('')")); ?>
              </div>
          </div>
          <div id="singlePicyw1"></div>
      </div>
      <div class="col-md-12"><?php echo $form->error($article, 'image'); ?></div>
  </div>
  
    <!-- <table class="table table-bordered table-striped">
    <tbody> -->
    <?php foreach (range(1, 10) as $n) { $nam = 'n'.$n;$no = 'o'.$n;$ns = 's'.$n;$nt = 't'.$n; $lt = 'l'.$n;$nv = 'v'.$n;?>
    <?php if($casee->$nam): ?>

      <?php switch ($casee->$nt) {
        case '1':?>
          <div class="form-group"><label class="col-md-2 control-label"><?=$casee->$nam?></label> <div class="col-md-4"><input type="text" value="<?=$article->$nv?>" name="CaseDataExt[v<?=$n?>]" class="form-inline w1" ></div></div>
          <?php break;
        case '2':?>
        <?php $arr = []; if($casee->$no) {
          $noarr = array_filter(explode(' ', $casee->$no));
          $nsarr = array_values(explode(' ', $casee->$ns));
          // var_dump($noarr,$nsarr);exit;
          $arr = array_combine($nsarr, $noarr);
          // foreach (explode(' ', $casee->no) as $key => $value) {
          //  # code...
          // }
          } ?>
        <div class="form-group"><label class="col-md-2 control-label"><?=$casee->$nam?></label> <div class="col-md-4"><?=CHtml::radioButtonList('CaseDataExt[v'.$n.']',$article->$nv,$arr,['separator'=>' '])?></div></div>
        <?php break;
        case '3': ?>
          <?php $arr = []; if($casee->$no) {
          $noarr = array_filter(explode(' ', $casee->$no));
          $nsarr = array_values(explode(' ', $casee->$ns));
          // if(count($noarr)!=count($nsarr)) {
          //  var_dump($noarr,$nsarr);exit;
          // }
          $arr = array_combine($nsarr, $noarr);
          // foreach (explode(' ', $casee->no) as $key => $value) {
          //  # code...
          // }
          } ?>
          <div class="form-group"><label class="col-md-2 control-label"><?=$casee->$nam?></label> <div class="col-md-4"><?=CHtml::checkBoxList('CaseDataExt[v'.$n.']',$article->$nv,$arr,['separator'=>' '])?></div></div>
          <?php break;
          case '4':?>
          <?php $tag = BasicTagExt::model()->findByPk($casee->$lt); if(!$tag) break; ?>
            <div class="form-group"><label class="col-md-2 control-label"><?=$casee->$nam?></label><div class="col-md-4"><input type="text" name="CaseDataExt[v<?=$n?>]" class="form-inline w1" value="<?=$article->$nv?>" > <?=CHtml::dropDownList('unit','',explode(' ', $tag->unit))?></div></div>
            <?php break;

      } ?>
    <?php else: break;?>

    <?php endif; ?>
  <?php } ?>
<?php } ?>

    <!-- </tbody>
    </table> -->
  <!-- </div> -->
  
<div class="form-actions">
    <div class="row">
        <div class="col-md-offset-3 col-md-9">
            <!-- <button type="submit" class="btn green">保存</button> -->
            <?php echo CHtml::link('返回',$this->createUrl('caselist'), array('class' => 'btn default')) ?>
        </div>
    </div>
</div>

<?php $this->endWidget() ?>

<?php
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
Yii::app()->clientScript->registerScriptFile('/static/global/plugins/select2/select2.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile('/static/global/plugins/select2/select2_locale_zh-CN.js', CClientScript::POS_END);
Yii::app()->clientScript->registerCssFile('/static/global/plugins/select2/select2.css');
Yii::app()->clientScript->registerCssFile('/static/admin/pages/css/select2_custom.css');

Yii::app()->clientScript->registerScriptFile('/static/admin/pages/scripts/addCustomizeDialog.js', CClientScript::POS_END);
Yii::app()->clientScript->registerCssFile('/static/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css');
Yii::app()->clientScript->registerScriptFile('/static/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile('/static/global/plugins/bootstrap-datetimepicker/js/locales/bootstrap-datetimepicker.zh-CN.js', CClientScript::POS_END, array('charset'=> 'utf-8'));
Yii::app()->clientScript->registerScriptFile('/static/global/plugins/bootbox/bootbox.min.js', CClientScript::POS_END);
?>
