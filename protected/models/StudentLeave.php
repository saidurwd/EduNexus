<?php

/**
 * This is the model class for table "{{student_leave}}".
 *
 * The followings are the available columns in table '{{student_leave}}':
 * @property integer $id
 * @property integer $institution
 * @property integer $class
 * @property integer $section
 * @property integer $student
 * @property string $reason
 * @property string $start_date
 * @property string $end_date
 * @property string $message
 * @property string $status
 *
 * The followings are the available model relations:
 * @property Institution $institution0
 * @property Class $class0
 * @property Section $section0
 * @property Student $student0
 */
class StudentLeave extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{student_leave}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('institution, class, section, student, reason, start_date, end_date', 'required'),
            array('institution, class, section, student', 'numerical', 'integerOnly' => true),
            array('reason', 'length', 'max' => 250),
            array('status', 'length', 'max' => 8),
            array('message, application_date', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, institution, class, section, student, reason, start_date, end_date, message, status, application_date', 'safe', 'on' => 'search'),
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
            'class0' => array(self::BELONGS_TO, 'Class', 'class'),
            'section0' => array(self::BELONGS_TO, 'Section', 'section'),
            'student0' => array(self::BELONGS_TO, 'Student', 'student'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'institution' => 'Institution',
            'class' => 'Class',
            'section' => 'Section',
            'student' => 'Student',
            'reason' => 'Reason',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'message' => 'Leave Message',
            'status' => 'Status',
            'application_date' => 'Application Date',
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
        $criteria->compare('t.institution', Yii::app()->user->institution);
        $criteria->compare('class', $this->class);
        $criteria->compare('section', $this->section);
        $criteria->compare('student', $this->student);
        $criteria->compare('reason', $this->reason, true);
        $criteria->compare('start_date', $this->start_date, true);
        $criteria->compare('end_date', $this->end_date, true);
        $criteria->compare('message', $this->message, true);
        $criteria->compare('status', $this->status, true);
        $criteria->compare('application_date', $this->application_date, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => Yii::app()->params['pageSize'],
            ),
            'sort' => array('defaultOrder' => 'application_date DESC')
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return StudentLeave the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function getData($id, $field) {
        $model = StudentLeave::model()->findByAttributes(array('id' => $id));
        if (empty($model->$field)) {
            return null;
        } else {
            return $model->$field;
        }
    }

}
