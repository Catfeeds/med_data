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
	public function actionList($type='title',$value='',$time_type='created',$time='',$cate='',$cate1='',$ks='',$area='')
	{
		$modelName = $this->modelName;
		$criteria = new CDbCriteria;
		if($value = trim($value))
            if ($type=='title') {
                $criteria->addSearchCondition('name', $value);
            } elseif ($type=='dis') {
            	$criteria->addSearchCondition('dis', $value);
            } elseif ($type='kw') {
            	$criteria->addSearchCondition('kw', $value);
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
		if($ks) {
			$criteria->addCondition('ks=:ks');
			$criteria->params[':ks'] = $ks;
		}
		if($area) {
			$criteria->addCondition('area=:area');
			$criteria->params[':area'] = $area;
		}
		if($cate1) {
			$criteria->addCondition('tid=:cid');
			$criteria->params[':cid'] = $cate1;
		}
		$infos = $modelName::model()->getList($criteria,20);
		$this->render('list',['cate'=>$cate,'cate1'=>$cate1,'infos'=>$infos->data,'cates'=>$this->cates,'cates1'=>$this->cates1,'pager'=>$infos->pagination,'type' => $type,'value' => $value,'time' => $time,'time_type' => $time_type,'ks'=>$ks,'area'=>$area]);
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
			$url = Yii::app()->request->getPost('url','');
			if($url) {
				$ress = ExcelHelper::read($url);
				if(isset($ress[0]) && $ress[0]) {
					foreach ($ress[0] as $res) {
						if($res) {
							$res = array_values($res);
							// var_dump($res);exit;
							$obj = new ProBlindExt;
							$obj->no = $res[0];
							$obj->name = $res[1];
							$obj->pid = $pid;
							$obj->save();
						}
						
					}
				}
				$this->setMessage('操作成功','success',['blindlist?pid='.$pid]);
			} else {
				$info->attributes = Yii::app()->request->getPost($modelName,[]);
				$info->pid = $pid;
				if($info->save()) {
					$this->setMessage('操作成功','success',['blindlist?pid='.$pid]);
				} else {
					$this->setMessage(array_values($info->errors)[0][0],'error');
				}
			}
				
		} 
		$this->render('blindedit',['cates'=>$this->cates,'article'=>$info,'info'=>ProExt::model()->findByPk($pid),'cates1'=>$this->cates1,]);
	}

	public function actionApplylist($type='title',$value='',$time_type='created',$time='',$cate='',$pid='',$hid='')
	{
		$modelName = "HospitalApplyExt";
		$criteria = new CDbCriteria;
		$criteria->addCondition("pid=$pid and hid=$hid");
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
		$this->render('applylist',['cate'=>$cate,'infos'=>$infos->data,'cates'=>$this->cates,'pager'=>$infos->pagination,'type' => $type,'value' => $value,'time' => $time,'time_type' => $time_type,'pid'=>$pid,'hid'=>$hid]);
	}

	public function actionApplyedit($id='',$pid='',$hid='')
	{
		$modelName = "HospitalApplyExt";
		$info = $id ? $modelName::model()->findByPk($id) : new $modelName;
		if(Yii::app()->request->getIsPostRequest()) {
			$info->attributes = Yii::app()->request->getPost($modelName,[]);
			$info->pid = $pid;
			$info->hid = $hid;

			if($info->save()) {
				$this->setMessage('操作成功','success',['applylist?pid='.$pid.'&hid='.$hid]);
			} else {
				$this->setMessage(array_values($info->errors)[0][0],'error');
			}
		} 
		$this->render('applyedit',['cates'=>$this->cates,'article'=>$info,'info'=>ProExt::model()->findByPk($pid),'cates1'=>$this->cates1,'pid'=>$pid,'hid'=>$hid]);
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
								$sql = $sql = "insert into pro_cate_tag(`name`,pid,type,tid,data_conf,sort,created,updated)  select name,pid,type,tid,data_conf,sort,created,updated from pro_cate_tag where pcid=".$value->id;
								// 插入内容
								// $tagsold = Yii::app()->db->createCommand("select name,pid,type,ppid,pcid,tid,data_conf,sort from pro_cate_tag where pcid=".$value->id)->queryAll();
								// if($tagsold) {
								// 	$t = time();
								// 	$sql = "insert into pro_cate_tag(`name`,pid,type,ppid,pcid,tid,data_conf,sort,created,updated) values ";
								// 	foreach ($tagsold as $k=>$to) {
								// 		$dh = $k==0?'':',';
								// 		$sql .= ("$dh('".$to['name']."',".$to['pid'].",".$to['type'].",".$info->id.",".$newobj->id.",".$to['tid'].",'".$to['data_conf']."',".$to['sort'].",".$t.",".$t.")");
								// 	}
									$sql  = $sql.';';
									Yii::app()->db->createCommand($sql)->execute();
									Yii::app()->db->createCommand("update pro_cate_tag set ppid=$info->id where ppid=0")->execute();
									Yii::app()->db->createCommand("update pro_cate_tag set pcid=$newobj->id where pcid=0")->execute();
								// }
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

	public function actionPlist($id='',$mid='',$op='')
	{
		$type = Yii::app()->request->getQuery('type',[]);
		$criteria = new CDbCriteria;

		$tag = ProCateTagExt::model()->findByPk($id);
		// 所有jieduan
		$pro = $tag->pro;
		$criteria->addCondition("t.pid=".$pro->id);
		
		if($type) {
			$criteria->addInCondition('hid',$type);
		}
		$ottags = Yii::app()->db->createCommand("select ppid,id from pro_cate_tag where name='".$tag->name."' and pid=".$pro->id)->queryAll();
		// var_dump(count($ottags));exit;
		$petarr = [];
		$ppidarr = [];
		if($ottags) {
			foreach ($ottags as $key => $value) {
				$petarr[$value['id']] = $value['ppid'];
				$ppidarr[] = $value['ppid'];
			}
		}
		// var_dump($petarr);exit;
		$data = [];
		$pes = [];
		$datas = DataExt::model()->with('period')->findAll($criteria);
		// var_dump(count($datas));exit;
		if($ppidarr && $datas)
			foreach ($datas as $key => $value) {
				if(!in_array($value->period->name, $pes) && in_array($value->ppid, $ppidarr))
					$pes[] = $value->period->name;
				foreach ($ppidarr as $ppid) {
					if($value->ppid==$ppid) {
						$op && $nn = 'v'.$op;
						$data[$value->iid][$value->ppid] = $op?$value->$nn:$value->data;
					} 
				}
				// if(in_array($value->ptid, array_keys($petarr))) {

				// 	$data[$value->iid][] = [$value->period->name=>$value->data];
				// }
			}
		// var_dump($data);exit;
		$this->render('plist',['datas'=>$data,'pes'=>$pes,'ppids'=>$ppidarr,'mid'=>$mid,'thisid'=>$id,'type'=>$type,'op'=>$op]);
	}

	public function actionExport($id='',$op='')
	{
		$type = Yii::app()->request->getQuery('type',[]);
		$criteria = new CDbCriteria;

		$tag = ProCateTagExt::model()->findByPk($id);
		// 所有jieduan
		$pro = $tag->pro;
		$criteria->addCondition("t.pid=".$pro->id);
		
		if($type) {
			$criteria->addInCondition('hid',$type);
		}
		$ottags = Yii::app()->db->createCommand("select ppid,id from pro_cate_tag where name='".$tag->name."' and pid=".$pro->id)->queryAll();
		$petarr = [];
		$ppidarr = [];
		if($ottags) {
			foreach ($ottags as $key => $value) {
				$petarr[$value['id']] = $value['ppid'];
				$ppidarr[] = $value['ppid'];
			}
		}
		// var_dump($petarr);exit;
		$data = [];
		$pes = [];
		$pes[] = '患者id';
		$datas = DataExt::model()->with('period')->findAll($criteria);
		// var_dump(count($datas));exit;
		if($ppidarr && $datas)
			foreach ($datas as $key => $value) {
				if(!in_array($value->period->name, $pes) && in_array($value->ppid, $ppidarr))
					$pes[] = $value->period->name;
				foreach ($ppidarr as $ppid) {
					if($value->ppid==$ppid) {
						$op && $nn = 'v'.$op;
						$data[$value->iid][$value->ppid] = $op?$value->$nn:$value->data;
					} 
				}
				// if(in_array($value->ptid, array_keys($petarr))) {

				// 	$data[$value->iid][] = [$value->period->name=>$value->data];
				// }
			}

		$edata = [];
		if($data) {
			foreach ($data as $key => $value) {
				
					$tmp[] = $key;
				foreach ($ppidarr as $ppid) {
					$tmp[] = isset($value[$ppid])?$value[$ppid]:'';
				}
				$edata[] = $tmp;
				unset($tmp);
			}
		}
		// var_dump($edata);exit;
		ExcelHelper::cvs_write_browser(date("YmdHis",time()),$pes,$edata); 
	}

	public function actionChangeLockStatus($id)
	{
		$obj = ProExt::model()->findByPk($id);
		$obj->is_lock = $obj->is_lock?0:1;
		$obj->save();
		$this->setMessage('操作成功');
	}

}