<?php 
/**
 * 球员类
 * @author steven.allen <[<email address>]>
 * @date(2017.2.12)
 */
class ProBlindUserExt extends ProBlindUser{
    public static $status = [
        '未破盲','已破盲'
    ];
	/**
     * 定义关系
     */
    public function relations()
    {
         return array(
            'user'=>array(self::BELONGS_TO, 'DoctorExt', 'uid'),
            'blind'=>array(self::BELONGS_TO, 'ProBlindExt', 'pbid'),
            'pro'=>array(self::BELONGS_TO, 'ProExt', 'pid'),
            'ill'=>array(self::BELONGS_TO, 'IllExt', 'did'),
        );
    }

    public static $types = [
        '实验组','对照组'
    ];

    /**
     * @return array 验证规则
     */
    public function rules() {
        $rules = parent::rules();
        return array_merge($rules, array(
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
        if($this->pid && $this->ill && !$this->pbid) {
            $no = $this->ill->no;
            $obj = ProBlindExt::model()->find("no=$no and pid=".$this->pid);
            $obj && $this->pbid = $obj->id;
        }
        if($this->getIsNewRecord()) {
            $this->created = $this->updated = time();
        }
        else {
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