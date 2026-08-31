<?php

/**
 * This is the model class for table "{{invoice_payment}}".
 *
 * The followings are the available columns in table '{{invoice_payment}}':
 * @property integer $id
 * @property integer $invoice
 * @property string $payment_method
 * @property string $amount
 * @property string $note
 * @property integer $created_by
 * @property string $created_on
 *
 * The followings are the available model relations:
 * @property Invoice $invoice0
 */
class InvoicePayment extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{invoice_payment}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('invoice, created_on', 'required'),
			array('invoice, created_by', 'numerical', 'integerOnly'=>true),
			array('payment_method', 'length', 'max'=>6),
			array('amount', 'length', 'max'=>18),
			array('note', 'length', 'max'=>250),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, invoice, payment_method, amount, note, created_by, created_on', 'safe', 'on'=>'search'),
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
			'invoice0' => array(self::BELONGS_TO, 'Invoice', 'invoice'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'invoice' => 'Invoice',
			'payment_method' => 'Payment Method',
			'amount' => 'Amount',
			'note' => 'Note',
			'created_by' => 'Created By',
			'created_on' => 'Created On',
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
		$criteria->compare('invoice',$this->invoice);
		$criteria->compare('payment_method',$this->payment_method,true);
		$criteria->compare('amount',$this->amount,true);
		$criteria->compare('note',$this->note,true);
		$criteria->compare('created_by',$this->created_by);
		$criteria->compare('created_on',$this->created_on,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return InvoicePayment the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
