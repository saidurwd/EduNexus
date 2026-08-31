<?php

/**
 * This is the model class for table "{{class}}".
 *
 * The followings are the available columns in table '{{class}}':
 * @property integer $id
 * @property integer $institution
 * @property string $class
 * @property integer $class_numeric
 * @property integer $teacher
 * @property string $note
 * @property string $status
 *
 * The followings are the available model relations:
 * @property Institution $institution0
 * @property Teacher $teacher0
 * @property ExamSchedule[] $examSchedules
 * @property Section[] $sections
 * @property Student[] $students
 * @property Subject[] $subjects
 * @property SubjectMark[] $subjectMarks
 */
class Classs extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{class}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('institution, class', 'required'),
            array('institution, class_numeric, teacher', 'numerical', 'integerOnly' => true),
            array('class', 'length', 'max' => 150),
            array('note', 'length', 'max' => 250),
            array('status', 'length', 'max' => 8),
            array('class', 'UniqueAttributesValidator', 'with' => 'institution', 'message' => 'This class already exist.'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, institution, class, class_numeric, teacher, note, status', 'safe', 'on' => 'search'),
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
            'teacher0' => array(self::BELONGS_TO, 'Teacher', 'teacher'),
            'examSchedules' => array(self::HAS_MANY, 'ExamSchedule', 'class'),
            'sections' => array(self::HAS_MANY, 'Section', 'class'),
            'students' => array(self::HAS_MANY, 'Student', 'class'),
            'subjects' => array(self::HAS_MANY, 'Subject', 'class'),
            'subjectMarks' => array(self::HAS_MANY, 'SubjectMark', 'class'),
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
            'class_numeric' => 'Class Numeric',
            'teacher' => 'Teacher',
            'note' => 'Note',
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
        $criteria->compare('class', $this->class, true);
        $criteria->compare('class_numeric', $this->class_numeric);
        $criteria->compare('teacher', $this->teacher);
        $criteria->compare('note', $this->note, true);
        $criteria->compare('status', $this->status, true);

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
     * @return Classs the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function getData($id, $field) {
        $model = Classs::model()->findByAttributes(array('id' => $id));
        if (empty($model->$field)) {
            return null;
        } else {
            return $model->$field;
        }
    }

    public static function getClassReportAdmin($field, $id, $cssClass = 'select2') {
        $parent1 = Classs::model()->findAll(array('condition' => 'status="Active"', 'order' => 'class_numeric'));
        $option = '<select id="' . $field . '" name="' . $field . '" class="' . $cssClass . '">';
        $option .= '<option value="">Select a Class</option>';
        foreach ($parent1 as $key => $values) {
            if ($id == $values["id"]) {
                $option .= '<option selected="selected" value="' . $values["id"] . '" class="' . $values["institution"] . '">' . $values["class"] . '</option>';
            } else {
                $option .= '<option value="' . $values["id"] . '" class="' . $values["institution"] . '">' . $values["class"] . '</option>';
            }
        }
        $option .= '</select>';

        return $option;
    }

}
