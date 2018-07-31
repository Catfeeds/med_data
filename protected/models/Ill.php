<?php

/**
 * This is the model class for table "ill".
 *
 * The followings are the available columns in table 'ill':
 * @property integer $id
 * @property string $name
 * @property string $no
 * @property string $med_no
 * @property string $birth
 * @property integer $sex
 * @property string $height
 * @property string $weight
 * @property string $addr
 * @property string $phone
 * @property integer $time
 * @property integer $pid
 * @property integer $created
 * @property integer $updated
 */
class Ill extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ill';
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
			array('sex, time, pid, created, updated', 'numerical', 'integerOnly'=>true),
			array('name, no, med_no, birth, addr', 'length', 'max'=>100),
			array('height, weight', 'length', 'max'=>10),
			array('phone', 'length', 'max'=>20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, no, med_no, birth, sex, height, weight, addr, phone, time, pid, created, updated', 'safe', 'on'=>'search'),
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
			'no' => 'No',
			'med_no' => 'Med No',
			'birth' => 'Birth',
			'sex' => 'Sex',
			'height' => 'Height',
			'weight' => 'Weight',
			'addr' => 'Addr',
			'phone' => 'Phone',
			'time' => 'Time',
			'pid' => 'Pid',
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
		$criteria->compare('no',$this->no,true);
		$criteria->compare('med_no',$this->med_no,true);
		$criteria->compare('birth',$this->birth,true);
		$criteria->compare('sex',$this->sex);
		$criteria->compare('height',$this->height,true);
		$criteria->compare('weight',$this->weight,true);
		$criteria->compare('addr',$this->addr,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('time',$this->time);
		$criteria->compare('pid',$this->pid);
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
	 * @return Ill the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
