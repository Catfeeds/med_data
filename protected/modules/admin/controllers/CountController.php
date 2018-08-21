<?php
/**
 * 数据统计控制器
 */
class CountController extends AdminController{
	
	public $cates = [];

	public $cates1 = [];

	public $controllerName = '';

	public $modelName = 'CountExt';

	public function init()
	{
		parent::init();
		$this->controllerName = '数据统计';
		// $this->cates = CHtml::listData(LeagueExt::model()->normal()->findAll(),'id','name');
		// $this->cates1 = CHtml::listData(TeamExt::model()->normal()->findAll(),'id','name');
	}
	public function actionList($type='title',$value='',$time_type='created',$time='',$ks='',$area='',$dis='')
	{
		$modelName = 'ProExt';
		$diss = [];
		$ress = Yii::app()->db->createCommand("select dis from pro where status=1 group by dis")->queryAll();
		if($ress) {
			foreach ($ress as $key => $value) {
				$diss[$value['dis']] = $value['dis'];
			}
		}
		// var_dump($diss);exit;
		$criteria = new CDbCriteria;
		$criteria->addCondition('status=1');
		// if($value = trim($value))
  //           if ($type=='title') {
  //               $criteria->addSearchCondition('reason', $value);
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
		if($ks) {
			$criteria->addCondition('ks=:ks');
			$criteria->params[':ks'] = $ks;
		}
		if($area) {
			$criteria->addCondition('area=:area');
			$criteria->params[':area'] = $area;
		}
		if($dis) {
			$criteria->addCondition('dis=:dis');
			$criteria->params[':dis'] = $dis;
		}
		$ksarr = $areaarr = $disarr = [];
		
		$infos = $modelName::model()->findAll($criteria);
		$pids = [];
		if($infos) {
			foreach ($infos as $key => $value) {
				!$ks && $value->ks and $ksarr[$value->ks][] = $value['id'];
				!$area && $value->area and $areaarr[$value->area][] = $value['id'];
				!$dis && $value->dis and $disarr[$value->dis][] = $value['id'];
				$pids[] = $value->id;
				// if($ks && $area && $dis) {
				// 	$pids[] = $value->id;
				// }
			}
		}
		// var_dump($areaarr);exit;
		$ksres = $areares = $disres = [];
		$kskey = $areakey = $diskey = [];
		if($ksarr) {
			foreach ($ksarr as $key => $value) {
				$kskey[] = TagExt::model()->findByPk($key)->name;
				$cre = new CDbCriteria;
				$cre->addInCondition('pid',$value);
				$cre->select = "count(id) as id";
				$res = IllExt::model()->find($cre);
				$ksres[] = $res?$res->id:0;
			}
		}
		if($areaarr) {
			foreach ($areaarr as $key => $value) {
				$areakey[] = TagExt::model()->findByPk($key)->name;
				$cre = new CDbCriteria;
				$cre->addInCondition('pid',$value);
				$cre->select = "count(id) as id";
				$res = IllExt::model()->find($cre);
				$areares[] = $res?$res->id:0;
			}
		}
		if($disarr) {
			foreach ($disarr as $key => $value) {
				$diskey[] = $key;
				$cre = new CDbCriteria;
				$cre->addInCondition('pid',$value);
				$cre->select = "count(id) as id";
				$res = IllExt::model()->find($cre);
				$disres[] = $res?$res->id:0;
			}
		}
		// var_dump($areakey);exit;
		$detail = 0;
		// if($ks && $area && $dis) {
		$cre = new CDbCriteria;
		$cre->addInCondition('pid',$pids);
		$cre->select = "count(id) as id";
		$res = IllExt::model()->find($cre);
		$allnum = $res?$res->id:0;
		// }
		$this->render('list',['cates'=>$this->cates,'type' => $type,'value' => $value,'time' => $time,'time_type' => $time_type,'diss'=>$diss,'ks'=>$ks,'area'=>$area,'dis'=>$dis,'allnum'=>$allnum,'ksarr'=>['key'=> $kskey,'value'=> $ksres],'areaarr'=>['key'=> $areakey,'value'=> $areares],'disarr'=>['key'=> $diskey,'value'=> $disres]]);
	}

	public function actionEdit($id='')
	{
		$modelName = $this->modelName;
		$info = $id ? $modelName::model()->findByPk($id) : new $modelName;
		if(Yii::app()->request->getIsPostRequest()) {
			$info->attributes = Yii::app()->request->getPost($modelName,[]);
			// $info->time =  is_numeric($info->time)?$info->time : strtotime($info->time);
			if($info->save()) {
				$this->setMessage('操作成功','success',['list']);
			} else {
				$this->setMessage(array_values($info->errors)[0][0],'error');
			}
		} 
		$this->render('edit',['cates'=>$this->cates,'article'=>$info,'cates1'=>$this->cates1,]);
	}

	public function actionAjaxStatus($kw='',$ids='')
	{
		if(!is_array($ids))
			if(strstr($ids,',')) {
				$ids = explode(',', $ids);
			} else {
				$ids = [$ids];
			}
		foreach ($ids as $key => $id) {
			$model = SubExt::model()->findByPk($id);
			$model->status = $kw;
			if(!$model->save())
				$this->setMessage(current(current($model->getErrors())),'error');
		}
		$this->setMessage('操作成功','success');	
	}

	public function actionRecall($msg='',$id='')
    {
        if($id) {
            $info = ReportExt::model()->findByPk($id);
            if($msg && $info && $user = $info->user) {
                $user->qf_uid && Yii::app()->controller->sendNotice($msg,$user->qf_uid);
                $info->status = 1;
                $info->save();
                $this->setMessage('操作成功');
            } else {
                $this->setMessage('操作失败');
            }
            $this->redirect('list');
            
        }
    }
}