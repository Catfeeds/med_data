<?php

/**
 * This is the model class for table "pro_cate_tag".
 *
 * The followings are the available columns in table 'pro_cate_tag':
 * @property integer $id
 * @property string $name
 * @property integer $pid
 * @property integer $type
 * @property integer $ppid
 * @property integer $pcid
 * @property integer $tid
 * @property string $data_conf
 * @property integer $sort
 * @property integer $created
 * @property integer $updated
 */
class ProCateTag extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'pro_cate_tag';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('created', 'required'),
			array('pid, type, ppid, pcid, tid, sort, created, updated', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>100),
			array('data_conf', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, pid, type, ppid, pcid, tid, data_conf, sort, created, updated', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'pid' => 'Pid',
			'type' => 'Type',
			'ppid' => 'Ppid',
			'pcid' => 'Pcid',
			'tid' => 'Tid',
			'data_conf' => 'Data Conf',
			'sort' => 'Sort',
			'created' => 'Created',
			'updated' => 'Updated',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('pid',$this->pid);
		$criteria->compare('type',$this->type);
		$criteria->compare('ppid',$this->ppid);
		$criteria->compare('pcid',$this->pcid);
		$criteria->compare('tid',$this->tid);
		$criteria->compare('data_conf',$this->data_conf,true);
		$criteria->compare('sort',$this->sort);
		$criteria->compare('created',$this->created);
		$criteria->compare('updated',$this->updated);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ProCateTag the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
