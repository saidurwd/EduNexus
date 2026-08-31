<?php

/**
 * This is the model class for table "{{fee_type}}".
 *
 * The followings are the available columns in table '{{fee_type}}':
 * @property integer $id
 * @property integer $institution
 * @property string $title
 * @property string $note
 * @property string $monthly
 * @property string $status
 *
 * The followings are the available model relations:
 * @property FeeDistribution[] $feeDistributions
 * @property Institution $institution0
 */
class FeeType extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{fee_type}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('institution, title', 'required'),
            array('institution', 'numerical', 'integerOnly' => true),
            array('title, note', 'length', 'max' => 250),
            array('monthly', 'length', 'max' => 3),
            array('status', 'length', 'max' => 8),
            array('title', 'UniqueAttributesValidator', 'with' => 'institution', 'message' => 'This fee type already exist.'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, institution, title, note, monthly, status', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'feeDistributions' => array(self::HAS_MANY, 'FeeDistribution', 'fee_type'),
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
            'title' => 'Fee Type',
            'note' => 'Note',
            'monthly' => 'Monthly',
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
        $criteria->compare('title', $this->title, true);
        $criteria->compare('note', $this->note, true);
        $criteria->compare('monthly', $this->monthly, true);
        $criteria->compare('status', $this->status, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => Yii::app()->params['pageSize'],
            ),
            'sort' => array('defaultOrder' => 'title ASC')
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return FeeType the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public static function getData($id, $field) {
        $model = FeeType::model()->findByAttributes(array('id' => $id));
        if (empty($model->$field)) {
            return null;
        } else {
            return $model->$field;
        }
    }

}
