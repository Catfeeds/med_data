<?php
$this->pageTitle = '项目列表';
$this->breadcrumbs = array( $this->pageTitle);
?>
<?php $infos = $this->hospital->pros;?>
<table class="table table-bordered table-striped table-condensed flip-content table-hover">
    <thead class="flip-content">
    <tr>
        <th class="text-center">项目名</th>
        <th class="text-center">随机/盲法</th>
        <th class="text-center">承担例数</th>
        <th class="text-center">完成例数</th>
        <th class="text-center">最新患者编号</th>
        <th class="text-center">操作</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($infos as $k=>$v): ?>
        <tr>
            <td class="text-center"><?=$v->title?></td>
            <td class="text-center"><?=$v->sjlx.'/'.$v->mflx?></td>
            <td class="text-center"><?=ProHospitalExt::model()->find("hid=".$this->hospital->id." and pid=".$v->id)->num?></td>
            <td class="text-center"><?=DataExt::model()->count("hid=".$this->hospital->id." and pid=".$v->id)?></td>
            <td class="text-center"><?php echo Yii::app()->db->createCommand("select no from ill where pid=".$v->id." order by created desc limit 1")->queryScalar() ?></td>

            <td style="text-align:center;vertical-align: middle">
                
                <a href="<?php echo $this->createUrl('addnew',array('pid'=>$v->id,'referrer'=>Yii::app()->request->url)) ?>" class="btn default btn-xs green"><i class="fa fa-edit"></i> 新增患者 </a>
                <a href="<?php echo $this->createUrl('ilist',array('pid'=>$v->id,'referrer'=>Yii::app()->request->url)) ?>" class="btn default btn-xs blue"> 患者列表 </a>

            </td>
        </tr>
    <?php endforeach;?>
    </tbody>
</table>