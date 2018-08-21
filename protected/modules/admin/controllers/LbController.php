<?php
/**
 * 量表控制器
 */
class LbController extends AdminController{
	
	public $cates = [];

	public $cates1 = [];

	public $controllerName = '';

	public $modelName = 'LbExt';

	public function init()
	{
		parent::init();
		$this->controllerName = '量表';
		// $this->cates = CHtml::listData(LeagueExt::model()->normal()->findAll(),'id','name');
		// $this->cates1 = CHtml::listData(TeamExt::model()->normal()->findAll(),'id','name');
	}
	public function actionList($type='title',$value='',$time_type='created',$time='',$cate='',$cate1='')
	{
		$modelName = $this->modelName;
		$criteria = new CDbCriteria;
		if($value = trim($value))
            if ($type=='title') {
                $criteria->addSearchCondition('name', $value);
            } 
        //添加时间、刷新时间筛选
        if($time_type!='' && $time!='')
        {
            list($beginTime, $endTime) = explode('-', $time);
            $beginTime = (int)strtotime(trim($beginTime));
            $endTime = (int)strtotime(trim($endTime));
            $criteria->addCondition("{$time_type}>=:beginTime");
            $criteria->addCondition("{$time_type}<:endTime");
            $criteria->params[':beginTime'] = TimeTools::getDayBeginTime($beginTime);
            $criteria->params[':endTime'] = TimeTools::getDayEndTime($endTime);

        }
		if($cate) {
			$criteria->addCondition('lid=:cid');
			$criteria->params[':cid'] = $cate;
		}
		if($cate1) {
			$criteria->addCondition('tid=:cid');
			$criteria->params[':cid'] = $cate1;
		}
		$infos = $modelName::model()->getList($criteria,20);
		$this->render('list',['cate'=>$cate,'cate1'=>$cate1,'infos'=>$infos->data,'cates'=>$this->cates,'cates1'=>$this->cates1,'pager'=>$infos->pagination,'type' => $type,'value' => $value,'time' => $time,'time_type' => $time_type,]);
	}

	public function actionEdit($id='')
	{
		$modelName = $this->modelName;
		$info = $id ? $modelName::model()->findByPk($id) : new $modelName;
		if(Yii::app()->request->getIsPostRequest()) {
			$info->attributes = Yii::app()->request->getPost($modelName,[]);

			if($info->save()) {
				$this->setMessage('操作成功','success',['list']);
			} else {
				$this->setMessage(array_values($info->errors)[0][0],'error');
			}
		} 
		$this->render('edit',['cates'=>$this->cates,'article'=>$info,'cates1'=>$this->cates1,]);
	}

	public function actionOplist($type='title',$value='',$time_type='created',$time='',$cate='',$cate1='',$lid='')
	{
		$modelName = 'LbOptionExt';
		$criteria = new CDbCriteria;
		if($lid)
			$criteria->addCondition("lid=$lid");
		if($value = trim($value))
            if ($type=='title') {
                $criteria->addSearchCondition('name', $value);
            } 
        //添加时间、刷新时间筛选
        if($time_type!='' && $time!='')
        {
            list($beginTime, $endTime) = explode('-', $time);
            $beginTime = (int)strtotime(trim($beginTime));
            $endTime = (int)strtotime(trim($endTime));
            $criteria->addCondition("{$time_type}>=:beginTime");
            $criteria->addCondition("{$time_type}<:endTime");
            $criteria->params[':beginTime'] = TimeTools::getDayBeginTime($beginTime);
            $criteria->params[':endTime'] = TimeTools::getDayEndTime($endTime);

        }
		if($cate1) {
			$criteria->addCondition('tid=:cid');
			$criteria->params[':cid'] = $cate1;
		}
		$infos = $modelName::model()->getList($criteria,20);
		$this->render('oplist',['cate'=>$cate,'cate1'=>$cate1,'infos'=>$infos->data,'cates'=>$this->cates,'cates1'=>$this->cates1,'pager'=>$infos->pagination,'type' => $type,'value' => $value,'time' => $time,'time_type' => $time_type,'lid'=>$lid]);
	}

	public function actionOpedit($id='',$lid='')
	{
		$modelName = 'LbOptionExt';
		$info = $id ? $modelName::model()->findByPk($id) : new $modelName;
		if(Yii::app()->request->getIsPostRequest()) {
			$info->attributes = Yii::app()->request->getPost($modelName,[]);
			$info->lid = $lid;
			if($info->save()) {
				$this->setMessage('操作成功','success',['oplist?lid='.$lid]);
			} else {
				$this->setMessage(array_values($info->errors)[0][0],'error');
			}
		} 
		$this->render('opedit',['cates'=>$this->cates,'article'=>$info,'cates1'=>$this->cates1,'lid'=>$lid]);
	}

	public function actionTest()
	{
		$t = time();
		$sql = "insert into lb_option(`name`,type,lid,o,s,created,updated) values ";
		$s = "('长距离行走对您来说有困难吗？',2,2,'没有	有点	很多	非常','1 2 3 4',$t,$t),
('户外短距离行走对您来说有困难吗？',2,2,'没有	有点	很多	非常','1 2 3 4',$t,$t),
('您白天需要呆在床上或轮椅里吗？',2,2,'没有	有点	很多	非常','1 2 3 4',$t,$t),
('您在吃饭、穿衣、洗澡或上厕所时需要他人帮忙吗？',2,2,'没有	有点	很多	非常','1 2 3 4',$t,$t),
('您在工作和日常活动中是否受到限制？',2,2,'没有	有点	很多	非常','1 2 3 4',$t,$t),
('过去的一星期内，您在从事您的爱好或休闲活动时是否受到限制',2,2,'没有	有点	很多	非常','1 2 3 4',$t,$t),
('过去的一星期内，您有气短吗？',2,2,'没有	有点	很多	非常','1 2 3 4',$t,$t),
('过去的一星期内，您有疼痛吗？',2,2,'没有	有点	很多	非常','1 2 3 4',$t,$t),
('过去的一星期内，您需要休息吗？',2,2,'没有	有点	很多	非常','1 2 3 4',$t,$t),
('过去的一星期内，您睡眠有困难吗？',2,2,'没有	有点	很多	非常','1 2 3 4',$t,$t),
('过去的一星期内，您觉得虚弱吗？',2,2,'没有	有点	很多	非常','1 2 3 4',$t,$t),
('过去的一星期内，您食欲不振（没有胃口）吗？',2,2,'没有	有点	很多	非常','1 2 3 4',$t,$t),
('过去的一星期内，您觉得恶心吗？',2,2,'没有	有点	很多	非常','1 2 3 4',$t,$t),
('过去的一星期内，您有呕吐吗？',2,2,'没有	有点	很多	非常','1 2 3 4',$t,$t),
('过去的一星期内，您有便秘吗？',2,2,'没有	有点	很多	非常','1 2 3 4',$t,$t),
('过去的一星期内，您有腹泻吗？',2,2,'没有	有点	很多	非常','1 2 3 4',$t,$t),
('过去的一星期内，您觉得累吗？',2,2,'没有	有点	很多	非常','1 2 3 4',$t,$t),
('过去的一星期内，疼痛影响您的日常活动吗？',2,2,'没有	有点	很多	非常','1 2 3 4',$t,$t),
('过去的一星期内，您集中精力做事有困难吗，如读报纸或看电视？',2,2,'没有	有点	很多	非常','1 2 3 4',$t,$t),
('过去的一星期内，您觉得紧张吗？',2,2,'没有	有点	很多	非常','1 2 3 4',$t,$t),
('过去的一星期内，您觉得忧虑吗？',2,2,'没有	有点	很多	非常','1 2 3 4',$t,$t),
('过去的一星期内，您觉得脾气急躁吗？',2,2,'没有	有点	很多	非常','1 2 3 4',$t,$t),
('过去的一星期内，您觉得压抑（情绪低落）吗？',2,2,'没有	有点	很多	非常','1 2 3 4',$t,$t),
('过去的一星期内，您感觉记忆有困难过吗？',2,2,'没有	有点	很多	非常','1 2 3 4',$t,$t),
('过去的一星期内，您的身体状况或治疗干扰了您的家庭生活吗？',2,2,'没有	有点	很多	非常','1 2 3 4',$t,$t),
('过去的一星期内，您的身体状况或治疗干扰了您的社交活动吗？',2,2,'没有	有点	很多	非常','1 2 3 4',$t,$t),
('过去的一星期内，您的身体状况或治疗导致您经济困难吗？',2,2,'没有	有点	很多	非常','1 2 3 4',$t,$t);";
// Yii::app()->db->createCommand($sql.$s)->execute();
	}
}