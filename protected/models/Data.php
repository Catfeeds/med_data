<?php

/**
 * This is the model class for table "data".
 *
 * The followings are the available columns in table 'data':
 * @property integer $id
 * @property integer $pid
 * @property integer $ppid
 * @property integer $pmid
 * @property integer $sid
 * @property integer $did
 * @property integer $hid
 * @property string $iname
 * @property integer $ino
 * @property integer $time
 * @property string $data_conf
 * @property integer $created
 * @property integer $updated
 */
class Data extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'data';
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
			array('pid, ppid, pmid, sid, did, hid, ino, time, created, updated', 'numerical', 'integerOnly'=>true),
			array('iname', 'length', 'max'=>100),
			array('data_conf', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, pid, ppid, pmid, sid, did, hid, iname, ino, time, data_conf, created, updated', 'safe', 'on'=>'search'),
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
			'pid' => 'Pid',
			'ppid' => 'Ppid',
			'pmid' => 'Pmid',
			'sid' => 'Sid',
			'did' => 'Did',
			'hid' => 'Hid',
			'iname' => 'Iname',
			'ino' => 'Ino',
			'time' => 'Time',
			'data_conf' => 'Data Conf',
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
		$criteria->compare('pid',$this->pid);
		$criteria->compare('ppid',$this->ppid);
		$criteria->compare('pmid',$this->pmid);
		$criteria->compare('sid',$this->sid);
		$criteria->compare('did',$this->did);
		$criteria->compare('hid',$this->hid);
		$criteria->compare('iname',$this->iname,true);
		$criteria->compare('ino',$this->ino);
		$criteria->compare('time',$this->time);
		$criteria->compare('data_conf',$this->data_conf,true);
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
	 * @return Data the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
