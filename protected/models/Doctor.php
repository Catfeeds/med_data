<?php

/**
 * This is the model class for table "doctor".
 *
 * The followings are the available columns in table 'doctor':
 * @property integer $id
 * @property integer $hid
 * @property string $phone
 * @property string $name
 * @property integer $last_login
 * @property string $code
 * @property integer $status
 * @property integer $created
 * @property integer $updated
 */
class Doctor extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'doctor';
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
			array('hid, last_login, status, created, updated', 'numerical', 'integerOnly'=>true),
			array('phone', 'length', 'max'=>20),
			array('name, code', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, hid, phone, name, last_login, code, status, created, updated', 'safe', 'on'=>'search'),
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
			'hid' => 'Hid',
			'phone' => 'Phone',
			'name' => 'Name',
			'last_login' => 'Last Login',
			'code' => 'Code',
			'status' => 'Status',
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
		$criteria->compare('hid',$this->hid);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('last_login',$this->last_login);
		$criteria->compare('code',$this->code,true);
		$criteria->compare('status',$this->status);
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
	 * @return Doctor the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
