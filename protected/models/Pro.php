<?php

/**
 * This is the model class for table "pro".
 *
 * The followings are the available columns in table 'pro':
 * @property integer $id
 * @property string $title
 * @property integer $num
 * @property string $url
 * @property string $kw
 * @property string $sjzzs
 * @property string $dis
 * @property integer $area
 * @property integer $ks
 * @property string $data_conf
 * @property integer $type
 * @property integer $uid
 * @property integer $status
 * @property integer $created
 * @property integer $updated
 */
class Pro extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'pro';
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
			array('num, area, ks, type, uid, status, created, updated', 'numerical', 'integerOnly'=>true),
			array('title, kw', 'length', 'max'=>255),
			array('url, sjzzs, dis', 'length', 'max'=>100),
			array('data_conf', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, title, num, url, kw, sjzzs, dis, area, ks, data_conf, type, uid, status, created, updated', 'safe', 'on'=>'search'),
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
			'title' => 'Title',
			'num' => 'Num',
			'url' => 'Url',
			'kw' => 'Kw',
			'sjzzs' => 'Sjzzs',
			'dis' => 'Dis',
			'area' => 'Area',
			'ks' => 'Ks',
			'data_conf' => 'Data Conf',
			'type' => 'Type',
			'uid' => 'Uid',
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
		$criteria->compare('title',$this->title,true);
		$criteria->compare('num',$this->num);
		$criteria->compare('url',$this->url,true);
		$criteria->compare('kw',$this->kw,true);
		$criteria->compare('sjzzs',$this->sjzzs,true);
		$criteria->compare('dis',$this->dis,true);
		$criteria->compare('area',$this->area);
		$criteria->compare('ks',$this->ks);
		$criteria->compare('data_conf',$this->data_conf,true);
		$criteria->compare('type',$this->type);
		$criteria->compare('uid',$this->uid);
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
	 * @return Pro the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
