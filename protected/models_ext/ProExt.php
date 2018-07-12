<?php 
/**
 * 球员类
 * @author steven.allen <[<email address>]>
 * @date(2017.2.12)
 */
class ProExt extends Pro{
    public static $status = [
        '禁用','启用'
    ];
	/**
     * 定义关系
     */
    public function relations()
    {
         return array(
            // 'staff'=>array(self::BELONGS_TO, 'StaffExt', 'sid'),
            // 'doctor'=>array(self::BELONGS_TO, 'DoctorExt', 'did'),
            'periods'=>array(self::HAS_MANY, 'ProPeriodExt', 'pid'),
            'hospital_num'=>array(self::STAT, 'ProHospitalExt', 'pid'),
            'hospitals'=>array(self::MANY_MANY, 'HospitalExt', 'pro_hospital(pid,hid)'),
            'period_num'=>array(self::STAT, 'ProPeriodExt', 'pid'),
            'module_num'=>array(self::STAT, 'ProCateExt', 'pid'),

        );
    }

    public static $tags = [
    'sjlx'=>'',
    'mflx'=>'',
    'xmjc'=>'',
    'xmjj'=>''
    ];

    public function __set($name='',$value='')
    {
        // var_dump($name);
       if (isset(self::$tags[$name])){
            if(is_array($this->data_conf))
                $data_conf = $this->data_conf;
            else
                $data_conf = CJSON::decode($this->data_conf);
            self::$tags[$name] = $value;
            $data_conf[$name] = $value;
            // var_dump(1);exit;
            $this->data_conf = json_encode($data_conf);
        }
        else
            parent::__set($name, $value);
    }

    public function __get($name='')
    {
        if (isset(self::$tags[$name])) {
            if(is_array($this->data_conf))
                $data_conf = $this->data_conf;
            else
                $data_conf = CJSON::decode($this->data_conf);

            if(!isset($data_conf[$name]))
                $value = self::$tags[$name];
            else
                $value = self::$tags[$name] ? self::$tags[$name] : $data_conf[$name];

            return $value;
        } else{
            return parent::__get($name);
        }
    }

    /**
     * @return array 验证规则
     */
    public function rules() {
        $rules = parent::rules();
        return array_merge($rules, array(
             array(implode(',',array_keys(self::$tags)), 'safe'),
            // array('name', 'unique', 'message'=>'{attribute}已存在')
        ));
    }

    /**
     * 返回指定AR类的静态模型
     * @param string $className AR类的类名
     * @return CActiveRecord Admin静态模型
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function afterFind() {
        parent::afterFind();
        // if(!$this->image){
        //     $this->image = SiteExt::getAttr('qjpz','productNoPic');
        // }
    }

    public function beforeValidate() {
        if($this->getIsNewRecord()) {

            // $res = Yii::app()->controller->sendNotice(($this->plot?$this->plot->title:'').'有新举报，举报原因为：'.$this->reason.'，请登陆后台审核','',1);
            
            $this->created = $this->updated = time();
        }
        else {
            // if($this->status==1&&Yii::app()->db->createCommand("select status from report where id=".$this->id)->queryScalar()==0) {
                
            // }
            $this->updated = time();
        }
        return parent::beforeValidate();
    }

    /**
     * 命名范围
     * @return array
     */
    public function scopes()
    {
        $alias = $this->getTableAlias();
        return array(
            'sorted' => array(
                'order' => "{$alias}.sort desc,{$alias}.updated desc",
            ),
            'normal' => array(
                'condition' => "{$alias}.status=1 and {$alias}.deleted=0",
                'order'=>"{$alias}.sort desc,{$alias}.updated desc",
            ),
            'undeleted' => array(
                'condition' => "{$alias}.deleted=0",
                // 'order'=>"{$alias}.sort desc,{$alias}.updated desc",
            ),
        );
    }

    /**
     * 绑定行为类
     */
    public function behaviors() {
        return array(
            'CacheBehavior' => array(
                'class' => 'application.behaviors.CacheBehavior',
                'cacheExp' => 0, //This is optional and the default is 0 (0 means never expire)
                'modelName' => __CLASS__, //This is optional as it will assume current model
            ),
            'BaseBehavior'=>'application.behaviors.BaseBehavior',
        );
    }

}