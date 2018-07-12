<?php
/**
 * 项目控制器
 */
class ProController extends AdminController{
	
	public $cates = [];

	public $cates1 = [];

	public $controllerName = '';

	public $modelName = 'ProExt';

	public function init()
	{
		parent::init();
		$this->controllerName = '项目';
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

	public function actionHospitallist($type='title',$value='',$time_type='created',$time='',$cate='',$pid='')
	{
		$modelName = "ProHospitalExt";
		$criteria = new CDbCriteria;
		$criteria->addCondition('pid='.$pid);
		if($value = trim($value))
            if ($type=='title') {
            	$ids = [];
            	$cre = new CDbCriteria;

                $cre->addSearchCondition('name', $value);
                $ress = HospitalExt::model()->findAll($cre);
                if($ress) {
                	foreach ($ress as $res) {
                		$ids[] = $res['id'];
                	}
                }
                $criteria->addInCondition('id',$ids);
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
		$infos = $modelName::model()->getList($criteria,20);
		$this->render('hospitallist',['cate'=>$cate,'infos'=>$infos->data,'cates'=>$this->cates,'pager'=>$infos->pagination,'type' => $type,'value' => $value,'time' => $time,'time_type' => $time_type,'pid'=>$pid]);
	}

	public function actionHospitaledit($id='',$pid='')
	{
		$modelName = "ProHospitalExt";
		$info = $id ? $modelName::model()->findByPk($id) : new $modelName;
		if(Yii::app()->request->getIsPostRequest()) {
			$info->attributes = Yii::app()->request->getPost($modelName,[]);
			$info->pid = $pid;
			if($info->save()) {
				$this->setMessage('操作成功','success',['hospitallist?pid='.$pid]);
			} else {
				$this->setMessage(array_values($info->errors)[0][0],'error');
			}
		} 
		$this->render('hospitaledit',['cates'=>$this->cates,'article'=>$info,'info'=>ProExt::model()->findByPk($pid),'cates1'=>$this->cates1,]);
	}

	public function actionBlindlist($type='title',$value='',$time_type='created',$time='',$cate='',$pid='')
	{
		$modelName = "ProBlindExt";
		$criteria = new CDbCriteria;
		$criteria->addCondition('pid='.$pid);
		if($value = trim($value))
            if ($type=='title') {
            	$ids = [];
            	$cre = new CDbCriteria;

                $cre->addSearchCondition('title', $value);
                $ress = ProExt::model()->findAll($cre);
                if($ress) {
                	foreach ($ress as $res) {
                		$ids[] = $res['id'];
                	}
                }
                $criteria->addInCondition('id',$ids);
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
		$infos = $modelName::model()->getList($criteria,20);
		$this->render('blindlist',['cate'=>$cate,'infos'=>$infos->data,'cates'=>$this->cates,'pager'=>$infos->pagination,'type' => $type,'value' => $value,'time' => $time,'time_type' => $time_type,'pid'=>$pid]);
	}

	public function actionBlindedit($id='',$pid='')
	{
		$modelName = "ProBlindExt";
		$info = $id ? $modelName::model()->findByPk($id) : new $modelName;
		if(Yii::app()->request->getIsPostRequest()) {
			$info->attributes = Yii::app()->request->getPost($modelName,[]);
			$info->pid = $pid;
			if($info->save()) {
				$this->setMessage('操作成功','success',['blindlist?pid='.$pid]);
			} else {
				$this->setMessage(array_values($info->errors)[0][0],'error');
			}
		} 
		$this->render('blindedit',['cates'=>$this->cates,'article'=>$info,'info'=>ProExt::model()->findByPk($pid),'cates1'=>$this->cates1,]);
	}

	public function actionPeriodlist($type='title',$value='',$time_type='created',$time='',$cate='',$pid='')
	{
		$modelName = "ProPeriodExt";
		$criteria = new CDbCriteria;
		$criteria->addCondition('pid='.$pid);
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
		$infos = $modelName::model()->getList($criteria,20);
		$this->render('periodlist',['cate'=>$cate,'infos'=>$infos->data,'cates'=>$this->cates,'pager'=>$infos->pagination,'type' => $type,'value' => $value,'time' => $time,'time_type' => $time_type,'pid'=>$pid]);
	}

	public function actionPeriodedit($id='',$pid='',$ppid='')
	{
		$modelName = "ProPeriodExt";
		$info = $id ? $modelName::model()->findByPk($id) : new $modelName;
		if(Yii::app()->request->getIsPostRequest()) {
			$info->attributes = Yii::app()->request->getPost($modelName,[]);
			$info->pid = $pid;
			if($info->save()) {
				if($ppid) {
					// 复制模块内容
					$oldone = $modelName::model()->findByPk($ppid);
					if($pcs = $oldone->cates) {
						foreach ($pcs as $key => $value) {
							// 新建一个模块
							$newobj = new ProCateExt;
							$pras = $value->attributes;
							unset($pras['id']);
							$newobj->attributes = $pras;
							$newobj->ppid = $info->id;
							if($newobj->save()) {
								// 插入内容
								$tagsold = Yii::app()->db->createCommand("select name,pid,type,ppid,pcid,tid,data_conf,sort from pro_cate_tag where pcid=".$value->id)->queryAll();
								if($tagsold) {
									$t = time();
									$sql = "insert into pro_cate_tag(`name`,pid,type,ppid,pcid,tid,data_conf,sort,created,updated) values ";
									foreach ($tagsold as $k=>$to) {
										$dh = $k==0?'':',';
										$sql .= ("$dh('".$to['name']."',".$to['pid'].",".$to['type'].",".$info->id.",".$newobj->id.",".$to['tid'].",'".$to['data_conf']."',".$to['sort'].",".$t.",".$t.")");
									}
									$sql  = $sql.';';
									Yii::app()->db->createCommand($sql)->execute();
								}
							}
						}
					}
				}
				$this->setMessage('操作成功','success',['periodlist?pid='.$pid]);
			} else {
				$this->setMessage(array_values($info->errors)[0][0],'error');
			}
		} 
		$this->render('periodedit',['cates'=>$this->cates,'article'=>$info,'info'=>ProExt::model()->findByPk($pid),'cates1'=>$this->cates1,'ppid'=>$ppid]);
	}

	public function actionModulelist($type='title',$value='',$time_type='created',$time='',$cate='',$pid='',$ppid='')
	{
		$modelName = "ProCateExt";
		$criteria = new CDbCriteria;
		if($pid)
			$criteria->addCondition('pid='.$pid);
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
			$criteria->addCondition('ppid=:ppid');
			$criteria->params[':ppid'] = $cate;
		}
		$infos = $modelName::model()->getList($criteria,20);
		$this->render('modulelist',['cate'=>$cate,'infos'=>$infos->data,'cates'=>$this->cates,'pager'=>$infos->pagination,'type' => $type,'value' => $value,'time' => $time,'time_type' => $time_type,'pid'=>$pid,'ppid'=>$ppid,'ppinfo'=>ProPeriodExt::model()->findByPk($ppid),'pinfo'=>ProExt::model()->findByPk($pid)]);
	}

	public function actionModuleedit($id='',$pid='',$ppid='')
	{
		$modelName = "ProCateExt";
		$info = $id ? $modelName::model()->findByPk($id) : new $modelName;
		if(Yii::app()->request->getIsPostRequest()) {
			$info->attributes = Yii::app()->request->getPost($modelName,[]);
			$info->pid = $pid;
			// $info->ppid = $ppid;
			if($info->save()) {
				$this->setMessage('操作成功','success',['modulelist?pid='.$pid.'&ppid='.$ppid]);
			} else {
				$this->setMessage(array_values($info->errors)[0][0],'error');
			}
		} 
		$this->render('moduleedit',['cates'=>$this->cates,'article'=>$info,'pid'=>$pid,'cates1'=>$this->cates1,]);
	}

	public function actionTaglist($type='title',$value='',$time_type='created',$time='',$cate='',$mid='')
	{
		$modelName = "ProCateTagExt";
		$criteria = new CDbCriteria;
		if($mid)
			$criteria->addCondition('pcid='.$mid);
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
			$criteria->addCondition('ppid=:ppid');
			$criteria->params[':ppid'] = $cate;
		}
		$infos = $modelName::model()->getList($criteria,20);
		$this->render('taglist',['cate'=>$cate,'infos'=>$infos->data,'cates'=>$this->cates,'pager'=>$infos->pagination,'type' => $type,'value' => $value,'time' => $time,'time_type' => $time_type,'mid'=>$mid,'minfo'=>ProCateExt::model()->findByPk($mid)]);
	}

	public function actionTagedit($id='',$mid='')
	{
		$modelName = "ProCateTagExt";
		$info = $id ? $modelName::model()->findByPk($id) : new $modelName;
		if(Yii::app()->request->getIsPostRequest()) {
			$info->attributes = Yii::app()->request->getPost($modelName,[]);
			$info->pcid = $mid;
			// $info->ppid = $ppid;
			if($info->save()) {
				$this->setMessage('操作成功','success',['taglist?mid='.$mid]);
			} else {
				$this->setMessage(array_values($info->errors)[0][0],'error');
			}
		} 
		$this->render('tagedit',['cates'=>$this->cates,'article'=>$info,'mid'=>$mid,'cates1'=>$this->cates1,]);
	}
}