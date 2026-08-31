<?php

/**
 * This is the model class for table "{{invoice_parent}}".
 *
 * The followings are the available columns in table '{{invoice_parent}}':
 * @property integer $id
 * @property integer $institution
 * @property integer $class
 * @property integer $section
 * @property integer $shift
 * @property integer $student
 * @property string $invoice_date
 * @property string $invoice_number
 * @property integer $invoice_by
 * @property string $total_amount
 * @property string $total_discount
 * @property string $payment_status
 * @property string $created_on
 * @property integer $created_by
 *
 * The followings are the available model relations:
 * @property Invoice[] $invoices
 * @property Institution $institution0
 * @property Class $class0
 * @property Section $section0
 * @property Shift $shift0
 * @property Student $student0
 */
class InvoiceParent extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{invoice_parent}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('institution, class, section, shift, student, invoice_date, invoice_number, invoice_by', 'required'),
			array('institution, class, section, shift, student, invoice_by, created_by', 'numerical', 'integerOnly'=>true),
			array('invoice_number', 'length', 'max'=>100),
			array('total_amount, total_discount', 'length', 'max'=>18),
			array('payment_status', 'length', 'max'=>14),
			array('created_on', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, institution, class, section, shift, student, invoice_date, invoice_number, invoice_by, total_amount, total_discount, payment_status, created_on, created_by', 'safe', 'on'=>'search'),
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
			'invoices' => array(self::HAS_MANY, 'Invoice', 'parent'),
			'institution0' => array(self::BELONGS_TO, 'Institution', 'institution'),
			'class0' => array(self::BELONGS_TO, 'Class', 'class'),
			'section0' => array(self::BELONGS_TO, 'Section', 'section'),
			'shift0' => array(self::BELONGS_TO, 'Shift', 'shift'),
			'student0' => array(self::BELONGS_TO, 'Student', 'student'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'institution' => 'Institution',
			'class' => 'Class',
			'section' => 'Section',
			'shift' => 'Shift',
			'student' => 'Student',
			'invoice_date' => 'Date',
			'invoice_number' => 'Invoice No.',
			'invoice_by' => 'Invoice By',
			'total_amount' => 'Amount',
			'total_discount' => 'Discount',
			'payment_status' => 'Payment Status',
			'created_on' => 'Created On',
			'created_by' => 'Created By',
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
		$criteria->compare('institution',$this->institution);
		$criteria->compare('class',$this->class);
		$criteria->compare('section',$this->section);
		$criteria->compare('shift',$this->shift);
		$criteria->compare('student',$this->student);
		$criteria->compare('invoice_date',$this->invoice_date,true);
		$criteria->compare('invoice_number',$this->invoice_number,true);
		$criteria->compare('invoice_by',$this->invoice_by);
		$criteria->compare('total_amount',$this->total_amount,true);
		$criteria->compare('total_discount',$this->total_discount,true);
		$criteria->compare('payment_status',$this->payment_status,true);
		$criteria->compare('created_on',$this->created_on,true);
		$criteria->compare('created_by',$this->created_by);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return InvoiceParent the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
