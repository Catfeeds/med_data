<?php
/**
 * 数据控制器
 */
class IllController extends AdminController{
	
	public $cates = [];

	public $cates1 = [];

	public $controllerName = '';

	public $modelName = 'IllExt';

	public function init()
	{
		parent::init();
		$this->controllerName = '数据';
		// $this->cates = CHtml::listData(LeagueExt::model()->normal()->findAll(),'id','name');
		// $this->cates1 = CHtml::listData(TeamExt::model()->normal()->findAll(),'id','name');
	}
	public function actionList($type='title',$value='',$time_type='created',$time='',$cate='',$cate1='')
	{
		$modelName = $this->modelName;
		$criteria = new CDbCriteria;
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

	public function actionData($iid='',$id='',$pid='',$ppid='')
	{

		// $id = $this
		$modelName = 'DataExt';

		$info = $id ? $modelName::model()->findByPk($id) : new $modelName;

		// $info = $this->company;
		if(Yii::app()->request->getIsPostRequest()) {
			// var_dump($_POST['ids']);exit;
			$vs = $_POST;
			$ids = array_filter($vs['ids']);
			$idarr = [];
			unset($vs['ids']);
			// 格式化id数组
			if($ids) {
				foreach ($ids as $key => $value) {
					list($a,$b) = explode('_', $value);
					$idarr[$a] = $b;
				}
			}
			// 单位先不考虑
			unset($vs['unit']);
			// var_dump($vs['lc9']);exit;
			foreach ($vs as $key => $value) {
				if(strstr($key, 'otag')) {
					// list($tag,$n) = explode('_', $key);
					$num = str_replace('otag', '', $key);
					$obj = isset($idarr[$num]) && $idarr[$num] ? DataExt::model()->findByPk($idarr[$num]) : new DataExt;
					if($value && is_array($value)) {
						foreach ($value as $k => $v) {
							$vv = 'v'.$k;
							$obj->$vv = $v;
						}
					}
					// $v = 'v'.$n;
					// $obj->$v = is_array($value)?json_encode($value):$value;
				} else {
					// 内置标签保存
					$num = str_replace('tag', '', $key);
					$num = str_replace('[]', '', $num);
					$obj = isset($idarr[$num]) && $idarr[$num] ? DataExt::model()->findByPk($idarr[$num]) : new DataExt;
					if(isset($value[0])) {
						$obj->data = $value[0];
						$obj->lcyy = $value[1];
						$obj->nci = $value[2];
						$obj->is_tag = 1;
					}
					
				}

				$taginfo = ProCateTagExt::model()->findByPk($num);
				$obj->iid = $iid;
				$obj->pid = $pid;
				$obj->ppid = $taginfo->ppid;
				$obj->pmid = $taginfo->pcid;
				$obj->ptid = $taginfo->id;
				$obj->did = Yii::app()->user->id;
				$obj->hid = Yii::app()->user->hid;
				$obj->save();
			}
			// $info->attributes = Yii::app()->request->getPost($modelName,[]);
			
			$this->setMessage('操作成功','success');		
		} 

		if(!$ppid) {
			$ppid = Yii::app()->db->createCommand("select id from pro_period where pid=$pid order by sort desc,created asc limit 1")->queryScalar();
		}
		// 数据
		$dataarr = [];
		$datas = DataExt::model()->findAll("pid=$pid and iid=$iid");
		// var_dump(count($datas));exit;
		if($datas) {
			foreach ($datas as $key => $value) {
				// 内置标签
				if($value->is_tag) {
					$dataarr[$value->ppid][$value->pmid][$value->ptid] = ['id'=>$value->id,'data'=>$value->data,'lcyy'=>$value->lcyy,'nci'=>$value->nci];
				} else {
					foreach (range(1, 10) as $n) {
						$nv = 'v'.$n;
						$tmp[$n] = $value->$nv;
						// $dataarr[$value->ppid][$value->pmid][$value->ptid][$n] = ['id'=>$value->id,'data'=>[$n=>$value->$nv]];
					}
					$dataarr[$value->ppid][$value->pmid][$value->ptid] = ['id'=>$value->id,'data'=>$tmp];
				}
			}
		}
		// echo json_encode($dataarr);exit;
		// var_dump($dataarr);exit;
		$this->render('data',['article'=>$info,'ill'=>IllExt::model()->findByPk($iid),'pinfo'=>ProExt::model()->findByPk($pid),'ppid'=>$ppid,'datas'=>$dataarr]);
	}

}