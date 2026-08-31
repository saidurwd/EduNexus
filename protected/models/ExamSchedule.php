<?php

/**
 * This is the model class for table "{{exam_schedule}}".
 *
 * The followings are the available columns in table '{{exam_schedule}}':
 * @property integer $id
 * @property integer $institution
 * @property integer $exam
 * @property integer $class
 * @property integer $section
 * @property integer $subject
 * @property string $exam_date
 * @property string $time_from
 * @property string $time_to
 * @property string $room
 *
 * The followings are the available model relations:
 * @property Institution $institution0
 * @property Exam $exam0
 * @property Class $class0
 * @property Section $section0
 * @property Subject $subject0
 */
class ExamSchedule extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{exam_schedule}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('institution, exam, class, section, subject, exam_date, time_from, time_to, room', 'required'),
            array('institution, exam, class, section, subject', 'numerical', 'integerOnly' => true),
            array('room', 'length', 'max' => 50),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, institution, exam, class, section, subject, exam_date, time_from, time_to, room', 'safe', 'on' => 'search'),
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
            'exam0' => array(self::BELONGS_TO, 'Exam', 'exam'),
            'class0' => array(self::BELONGS_TO, 'Class', 'class'),
            'section0' => array(self::BELONGS_TO, 'Section', 'section'),
            'subject0' => array(self::BELONGS_TO, 'Subject', 'subject'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'institution' => 'Institution',
            'exam' => 'Exam Name',
            'class' => 'Class',
            'section' => 'Section',
            'subject' => 'Subject',
            'exam_date' => 'Exam Date',
            'time_from' => 'Time From',
            'time_to' => 'Time To',
            'room' => 'Room',
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
        $criteria->compare('exam', $this->exam);
        $criteria->compare('class', $this->class);
        $criteria->compare('section', $this->section);
        $criteria->compare('subject', $this->subject);
        $criteria->compare('exam_date', $this->exam_date, true);
        $criteria->compare('time_from', $this->time_from, true);
        $criteria->compare('time_to', $this->time_to, true);
        $criteria->compare('room', $this->room, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => Yii::app()->params['pageSize'],
            ),
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return ExamSchedule the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function getData($id, $field) {
        $model = ExamSchedule::model()->findByAttributes(array('id' => $id));
        if (empty($model->$field)) {
            return null;
        } else {
            return $model->$field;
        }
    }

}
