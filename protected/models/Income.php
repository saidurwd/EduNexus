<?php

/**
 * This is the model class for table "{{income}}".
 *
 * The followings are the available columns in table '{{income}}':
 * @property integer $id
 * @property integer $institution
 * @property integer $coa
 * @property string $expense_date
 * @property string $amount
 * @property string $note
 * @property string $file
 * @property string $created_on
 * @property integer $created_by
 *
 * The followings are the available model relations:
 * @property Coa $coa0
 * @property Institution $institution0
 */
class Income extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{income}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('institution, coa, expense_date, amount', 'required'),
            array('institution, coa, created_by', 'numerical', 'integerOnly' => true),
            array('amount', 'length', 'max' => 18),
            array('note, file', 'length', 'max' => 250),
            array('created_on', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, institution, coa, expense_date, amount, note, file, created_on, created_by', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'coa0' => array(self::BELONGS_TO, 'Coa', 'coa'),
            'institution0' => array(self::BELONGS_TO, 'Institution', 'institution'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'institution' => 'Institution',
            'coa' => 'Chart of accounts',
            'expense_date' => 'Date',
            'amount' => 'Amount',
            'note' => 'Note',
            'file' => 'File',
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
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('institution', Yii::app()->user->institution);
        $criteria->compare('coa', $this->coa);
        $criteria->compare('expense_date', $this->expense_date, true);
        $criteria->compare('amount', $this->amount, true);
        $criteria->compare('note', $this->note, true);
        $criteria->compare('file', $this->file, true);
        $criteria->compare('created_on', $this->created_on, true);
        $criteria->compare('created_by', $this->created_by);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => Yii::app()->params['pageSize'],
            ),
            'sort' => array('defaultOrder' => 'expense_date DESC')
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Income the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function getData($id, $field) {
        $model = Income::model()->findByAttributes(array('id' => $id));
        if (empty($model->$field)) {
            return null;
        } else {
            return $model->$field;
        }
    }

}
