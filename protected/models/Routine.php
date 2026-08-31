<?php

/**
 * This is the model class for table "{{routine}}".
 *
 * The followings are the available columns in table '{{routine}}':
 * @property integer $id
 * @property integer $institution
 * @property integer $academic_year
 * @property integer $class
 * @property integer $section
 * @property integer $subject
 * @property string $day
 * @property integer $teacher
 * @property string $starting_time
 * @property string $ending_time
 * @property string $room
 * @property string $created_on
 * @property integer $created_by
 *
 * The followings are the available model relations:
 * @property Institution $institution0
 * @property AcademicYear $academicYear
 * @property Class $class0
 * @property Section $section0
 * @property Subject $subject0
 * @property Teacher $teacher0
 */
class Routine extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{routine}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('institution, academic_year, class, section, subject, day, teacher, starting_time, ending_time, room', 'required'),
            array('institution, academic_year, class, section, subject, teacher, created_by', 'numerical', 'integerOnly' => true),
            array('day', 'length', 'max' => 9),
            array('room', 'length', 'max' => 50),
            array('created_on', 'safe'),            
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, institution, academic_year, class, section, subject, day, teacher, starting_time, ending_time, room, created_on, created_by', 'safe', 'on' => 'search'),
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
            'academicYear' => array(self::BELONGS_TO, 'AcademicYear', 'academic_year'),
            'class0' => array(self::BELONGS_TO, 'Class', 'class'),
            'section0' => array(self::BELONGS_TO, 'Section', 'section'),
            'subject0' => array(self::BELONGS_TO, 'Subject', 'subject'),
            'teacher0' => array(self::BELONGS_TO, 'Teacher', 'teacher'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'institution' => 'Institution',
            'academic_year' => 'Academic Year',
            'class' => 'Class',
            'section' => 'Section',
            'subject' => 'Subject',
            'day' => 'Day',
            'teacher' => 'Teacher',
            'starting_time' => 'Starting Time',
            'ending_time' => 'Ending Time',
            'room' => 'Room',
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
        $criteria->compare('academic_year', $this->academic_year);
        $criteria->compare('class', $this->class);
        $criteria->compare('section', $this->section);
        $criteria->compare('subject', $this->subject);
        $criteria->compare('day', $this->day, true);
        $criteria->compare('teacher', $this->teacher);
        $criteria->compare('starting_time', $this->starting_time, true);
        $criteria->compare('ending_time', $this->ending_time, true);
        $criteria->compare('room', $this->room, true);
        $criteria->compare('created_on', $this->created_on, true);
        $criteria->compare('created_by', $this->created_by);

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
     * @return Routine the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function getData($id, $field) {
        $model = Routine::model()->findByAttributes(array('id' => $id));
        if (empty($model->$field)) {
            return null;
        } else {
            return $model->$field;
        }
    }

}
