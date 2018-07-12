<?php
/**
 * 门店控制器
 */
class DataController extends VipController{
	public $controllerName = '';
	public $hospital = '';
	public $modelName = 'DataExt';

	public function init()
	{
		parent::init();
		$this->controllerName = '数据';
		// $this->hospital = HospitalExt::model()->findByPk(Yii::app()->user->hid);
		// $this->cates = CHtml::listData(LeagueExt::model()->normal()->findAll(),'id','name');
		// $this->cates1 = CHtml::listData(TeamExt::model()->normal()->findAll(),'id','name');
	}
	public function actionIlist($type='title',$value='',$time_type='created',$time='',$cate='',$pid='')
	{
		// $this->render('list',['hospital'=>$this->hospital]);
		$modelName = $this->modelName;
		$criteria = new CDbCriteria;
		$criteria->addCondition('pid='.$pid.' and hid='.$this->hospital->id);
		if($value = trim($value))
            if ($type=='title') {
                $criteria->addSearchCondition('iname', $value);
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
			$criteria->addCondition('type=:cid');
			$criteria->params[':cid'] = $cate;
		}
		$infos = $modelName::model()->getList($criteria,20);
		$this->render('ilist',['cate'=>$cate,'infos'=>$infos->data,'pager'=>$infos->pagination,'type' => $type,'value' => $value,'time' => $time,'time_type' => $time_type,'pid'=>$pid]);
	}
	public function actionList()
	{
		$this->render('list',['hospital'=>$this->hospital]);
		// $modelName = $this->modelName;
		// $criteria = new CDbCriteria;
		// if($value = trim($value))
  //           if ($type=='title') {
  //               $criteria->addSearchCondition('name', $value);
  //           } 
  //       //添加时间、刷新时间筛选
  //       if($time_type!='' && $time!='')
  //       {
  //           list($beginTime, $endTime) = explode('-', $time);
  //           $beginTime = (int)strtotime(trim($beginTime));
  //           $endTime = (int)strtotime(trim($endTime));
  //           $criteria->addCondition("{$time_type}>=:beginTime");
  //           $criteria->addCondition("{$time_type}<:endTime");
  //           $criteria->params[':beginTime'] = TimeTools::getDayBeginTime($beginTime);
  //           $criteria->params[':endTime'] = TimeTools::getDayEndTime($endTime);

  //       }
		// if($cate) {
		// 	$criteria->addCondition('type=:cid');
		// 	$criteria->params[':cid'] = $cate;
		// }
		// $infos = $modelName::model()->undeleted()->getList($criteria,20);
		// $this->render('list',['cate'=>$cate,'infos'=>$infos->data,'pager'=>$infos->pagination,'type' => $type,'value' => $value,'time' => $time,'time_type' => $time_type,]);
	}

	public function actionEdit($id='',$pid='',$ppid='')
	{
		// $id = $this
		$modelName = 'DataExt';

		$info = $id ? $modelName::model()->findByPk($id) : new $modelName;
		// $info = $this->company;
		if(Yii::app()->request->getIsPostRequest()) {
			// $info->attributes = Yii::app()->request->getPost($modelName,[]);
			
					
		} 
		if(!$ppid) {
			$ppid = Yii::app()->db->createCommand("select id from pro_period where pid=$pid order by sort desc,created asc limit 1")->queryScalar();
		}
		$this->render('edit',['article'=>$info,'pinfo'=>ProExt::model()->findByPk($pid),'ppid'=>$ppid]);
	}

	public function actionSetCode($id='')
	{
		if($id) {
			$info = CompanyExt::model()->findByPk($id);
			if($info->code) {
				$this->setMessage('门店码已存在','error');
				return ;
			}

			$code = $info->type==1 ? 800000 + rand(0,99999) :  600000 + rand(0,99999) ;
			// var_dump($code);exit;
			while (CompanyExt::model()->find('code='.$code)) {
				$code = $info->type==1 ? 800000 + rand(0,99999) :  600000 + rand(0,99999) ;
			}
			$info->code = $code;
			$info->save();
			$this->setMessage('操作成功','success');
		}
	}

	// 密码md5 判断新增患者是否完成
	public function actionAddnew($pid)
	{
		$info = new DataExt;
		if(Yii::app()->request->getIsPostRequest()) {
			$info->attributes = Yii::app()->request->getPost('DataExt',[]);
			$info->did = Yii::app()->user->id;
			$info->pid = $pid;
			$info->hid = $this->hospital->id;
			if($info->save()) {
				$this->setMessage('操作成功','success',['edit?id='.$info->id.'&pid='.$pid]);
			} else {
				$this->setMessage(current(current($info->getErrors())),'error');
			}
		} 

		$this->render('addnew',['pinfo'=>ProExt::model()->findByPk($pid),'article'=>$info]);
	}
}