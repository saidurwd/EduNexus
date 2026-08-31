<?php

/**
 * This is the model class for table "{{fee_distribution}}".
 *
 * The followings are the available columns in table '{{fee_distribution}}':
 * @property integer $id
 * @property integer $institution
 * @property integer $fee_type
 * @property integer $class
 * @property integer $section
 * @property string $amount
 * @property string $status
 *
 * The followings are the available model relations:
 * @property Institution $institution0
 * @property FeeType $feeType
 * @property Class $class0
 * @property Section $section0
 */
class FeeDistribution extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{fee_distribution}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('institution, fee_type, class, section, amount', 'required'),
            array('institution, fee_type, class, section', 'numerical', 'integerOnly' => true),
            array('amount', 'length', 'max' => 12),
            array('status', 'length', 'max' => 8),
            array('fee_type', 'UniqueAttributesValidator', 'with' => 'institution,fee_type,class,section', 'message' => 'This distribution already exist.'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, institution, fee_type, class, section, amount, status', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'institution0' => array(self::BELONGS_TO, 'Institution', 'institution'),
            'feeType' => array(self::BELONGS_TO, 'FeeType', 'fee_type'),
            'class0' => array(self::BELONGS_TO, 'Class', 'class'),
            'section0' => array(self::BELONGS_TO, 'Section', 'section'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'institution' => 'Institution',
            'fee_type' => 'Fee Type',
            'class' => 'Class',
            'section' => 'Section',
            'amount' => 'Amount',
            'status' => 'Status',
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
        $criteria->compare('fee_type', $this->fee_type);
        $criteria->compare('class', $this->class);
        $criteria->compare('section', $this->section);
        $criteria->compare('amount', $this->amount, true);
        $criteria->compare('status', $this->status, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => Yii::app()->params['pageSize'],
            ),
            'sort' => array('defaultOrder' => 'class ASC, section ASC')
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return FeeDistribution the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function getData($id, $field) {
        $model = FeeDistribution::model()->findByAttributes(array('id' => $id));
        if (empty($model->$field)) {
            return null;
        } else {
            return $model->$field;
        }
    }

}
