<?php
/**
 * 病例数据控制器
 */
class CaseController extends VipController{
	
	public $cates = [];

	public $cates1 = [];

	public $controllerName = '';

	public $modelName = 'CaseDataExt';

	public function init()
	{
		parent::init();
		$this->controllerName = '病例数据';
		// $this->cates = CHtml::listData(LeagueExt::model()->normal()->findAll(),'id','name');
		// $this->cates1 = CHtml::listData(TeamExt::model()->normal()->findAll(),'id','name');
	}
	public function actionList($type='title',$value='',$time_type='created',$time='',$cate='')
	{
		$modelName = $this->modelName;
		$criteria = new CDbCriteria;
		$criteria->addCondition("did=".Yii::app()->user->id);
		if($value = trim($value))
            if ($type=='title') {
            	$cre = new CDbCriteria;

                $cre->addSearchCondition('name', $value);
                $ids = [];
                if($ress = CaseExt::model()->findAll($criteria)) {
                	foreach ($ress as $res) {
                		$ids[] = $res['id'];
                	}
                }
                $criteria->addInCondition('cid',$ids);
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
			$criteria->addCondition('status=:cid');
			$criteria->params[':cid'] = $cate;
		}
		$infos = $modelName::model()->getList($criteria,20);
		// 能添加的病例
		$cases = Yii::app()->db->createCommand("select c.id,c.name from `case` c left join case_hospital h on c.id=h.pid where h.id=".Yii::app()->user->hid)->queryAll();
		$this->render('list',['cate'=>$cate,'infos'=>$infos->data,'cates'=>$this->cates,'pager'=>$infos->pagination,'type' => $type,'value' => $value,'time' => $time,'time_type' => $time_type,'cases'=>$cases]);
	}

	public function actionEdit($id='',$type='')
	{
		$caseinfo = '';
		if($type) {
			$caseinfo = CaseExt::model()->findByPk($type);
		}
		$modelName = 'CaseDataExt';
		$info = $id ? $modelName::model()->findByPk($id) : new $modelName;
		if(Yii::app()->request->getIsPostRequest()) {
			$info->attributes = Yii::app()->request->getPost('CaseDataExt',[]);
			// var_dump($info->attributes);exit;
			$info->cid = $type;
			$info->did = Yii::app()->user->id;
			// $info->time =  is_numeric($info->time)?$info->time : strtotime($info->time);
			if($info->save()) {
				$this->setMessage('操作成功','success',['list']);
			} else {
				$this->setMessage(array_values($info->errors)[0][0],'error');
			}
		} 
		$datas = [];

		$this->render('edit',['cates'=>$this->cates,'article'=>$info,'cates1'=>$this->cates1,'type'=>$type,'datas'=>$datas]);
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
}