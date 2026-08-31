<?php

/**
 * This is the model class for table "{{merit_position}}".
 *
 * The followings are the available columns in table '{{merit_position}}':
 * @property integer $institution
 * @property integer $student
 * @property integer $class
 * @property integer $section
 * @property integer $group
 * @property integer $exam
 * @property integer $academic_year
 * @property string  $sid
 * @property integer $roll
 * @property string $total_mark
 * @property string $letter_grade
 * @property string $gpa
 * @property integer $class_position
 * @property integer $section_position
 * @property integer $group_position
 *
 * The followings are the available model relations:
 * @property Institution $institution0
 * @property Student $student0
 * @property Class $class0
 * @property Section $section0
 * @property StudentGroup $group0
 * @property Exam $exam0
 * @property AcademicYear $academicYear
 */
class MeritPosition extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{merit_position}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('institution, student, class, section, group, exam, academic_year', 'required'),
            array('institution, student, class, section, group, exam, academic_year, roll, class_position, section_position, group_position, failed_subject', 'numerical', 'integerOnly' => true),
            array('total_mark, gpa', 'length', 'max' => 6),
            array('letter_grade', 'length', 'max' => 10),
            array('sid', 'length', 'max' => 50),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('institution, student, class, section, group, exam, academic_year, sid, roll, total_mark, letter_grade, gpa, class_position, section_position, group_position, failed_subject', 'safe', 'on' => 'search'),
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
            'student0' => array(self::BELONGS_TO, 'Student', 'student'),
            'class0' => array(self::BELONGS_TO, 'Class', 'class'),
            'section0' => array(self::BELONGS_TO, 'Section', 'section'),
            'group0' => array(self::BELONGS_TO, 'StudentGroup', 'group'),
            'exam0' => array(self::BELONGS_TO, 'Exam', 'exam'),
            'academicYear' => array(self::BELONGS_TO, 'AcademicYear', 'academic_year'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'institution' => 'Institution',
            'student' => 'Student',
            'class' => 'Class',
            'section' => 'Section',
            'group' => 'Group',
            'exam' => 'Exam',
            'academic_year' => 'Academic Year',
            'sid' => 'Student ID',
            'roll' => 'Roll',
            'total_mark' => 'Total Marks',
            'letter_grade' => 'Letter Grade',
            'gpa' => 'GPA',
            'class_position' => 'Class Position',
            'section_position' => 'Section Position',
            'group_position' => 'Group Position',
            'failed_subject' => 'Failed Subject',
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
    public function search_class() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('institution', Yii::app()->user->institution);
        $criteria->compare('student', $this->student);
        $criteria->compare('class', $this->class);
        $criteria->compare('section', $this->section);
        $criteria->compare('group', $this->group);
        $criteria->compare('exam', $this->exam);
        $criteria->compare('academic_year', $this->academic_year);
        $criteria->compare('sid', $this->sid);
        $criteria->compare('roll', $this->roll);
        $criteria->compare('total_mark', $this->total_mark, true);
        $criteria->compare('letter_grade', $this->letter_grade, true);
        $criteria->compare('gpa', $this->gpa, true);
        $criteria->compare('class_position', $this->class_position);
        $criteria->compare('section_position', $this->section_position);
        $criteria->compare('group_position', $this->group_position);
        $criteria->compare('failed_subject', $this->failed_subject);
        $criteria->group = '`class`,`exam`,`academic_year`';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => Yii::app()->params['pageSize'],
            ),
        ));
    }

    public function search_section() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('institution', Yii::app()->user->institution);
        $criteria->compare('student', $this->student);
        $criteria->compare('class', $this->class);
        $criteria->compare('section', $this->section);
        $criteria->compare('group', $this->group);
        $criteria->compare('exam', $this->exam);
        $criteria->compare('academic_year', $this->academic_year);
        $criteria->compare('sid', $this->sid);
        $criteria->compare('roll', $this->roll);
        $criteria->compare('total_mark', $this->total_mark, true);
        $criteria->compare('letter_grade', $this->letter_grade, true);
        $criteria->compare('gpa', $this->gpa, true);
        $criteria->compare('class_position', $this->class_position);
        $criteria->compare('section_position', $this->section_position);
        $criteria->compare('group_position', $this->group_position);
        $criteria->compare('failed_subject', $this->failed_subject);
        $criteria->group = '`class`,`section`,`exam`,`academic_year`';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => Yii::app()->params['pageSize'],
            ),
        ));
    }

    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('institution', Yii::app()->user->institution);
        $criteria->compare('student', $this->student);
        $criteria->compare('class', $this->class);
        $criteria->compare('section', $this->section);
        $criteria->compare('group', $this->group);
        $criteria->compare('exam', $this->exam);
        $criteria->compare('academic_year', $this->academic_year);
        $criteria->compare('sid', $this->sid);
        $criteria->compare('roll', $this->roll);
        $criteria->compare('total_mark', $this->total_mark, true);
        $criteria->compare('letter_grade', $this->letter_grade, true);
        $criteria->compare('gpa', $this->gpa, true);
        $criteria->compare('class_position', $this->class_position);
        $criteria->compare('section_position', $this->section_position);
        $criteria->compare('group_position', $this->group_position);
        $criteria->compare('failed_subject', $this->failed_subject);
        $criteria->group = '`class`,`section`,`group`,`exam`,`academic_year`';

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
     * @return MeritPosition the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function getMeritPosition($institution, $student, $class, $section, $group, $exam, $year, $field) {
        $model = MeritPosition::model()->findByAttributes(array('institution' => $institution, 'student' => $student, 'class' => $class, 'section' => $section, 'group' => $group, 'exam' => $exam, 'academic_year' => $year));
        if (empty($model->$field)) {
            return 0;
        } else {
            return $model->$field;
        }
    }

}
