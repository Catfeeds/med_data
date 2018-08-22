<?php

/**
 * This is the model class for table "case_data".
 *
 * The followings are the available columns in table 'case_data':
 * @property integer $id
 * @property integer $cid
 * @property integer $did
 * @property integer $hid
 * @property string $image
 * @property string $data_conf
 * @property string $name
 * @property string $addr
 * @property integer $time
 * @property string $phone
 * @property string $birth
 * @property integer $sex
 * @property integer $created
 * @property integer $updated
 */
class CaseData extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'case_data';
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
			array('cid, did, hid, time, sex, created, updated', 'numerical', 'integerOnly'=>true),
			array('image', 'length', 'max'=>255),
			array('name, addr', 'length', 'max'=>100),
			array('phone', 'length', 'max'=>20),
			array('birth', 'length', 'max'=>10),
			array('data_conf', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, cid, did, hid, image, data_conf, name, addr, time, phone, birth, sex, created, updated', 'safe', 'on'=>'search'),
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
			'cid' => 'Cid',
			'did' => 'Did',
			'hid' => 'Hid',
			'image' => 'Image',
			'data_conf' => 'Data Conf',
			'name' => 'Name',
			'addr' => 'Addr',
			'time' => 'Time',
			'phone' => 'Phone',
			'birth' => 'Birth',
			'sex' => 'Sex',
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
		$criteria->compare('cid',$this->cid);
		$criteria->compare('did',$this->did);
		$criteria->compare('hid',$this->hid);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('data_conf',$this->data_conf,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('addr',$this->addr,true);
		$criteria->compare('time',$this->time);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('birth',$this->birth,true);
		$criteria->compare('sex',$this->sex);
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
	 * @return CaseData the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
