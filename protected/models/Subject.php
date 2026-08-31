<?php

/**
 * This is the model class for table "{{subject}}".
 *
 * The followings are the available columns in table '{{subject}}':
 * @property integer $id
 * @property integer $institution
 * @property integer $class
 * @property integer $teacher
 * @property string $type
 * @property integer $pass_mark
 * @property integer $final_mark
 * @property string $subject
 * @property string $code
 * @property integer $student_group
 * @property string $note
 * @property string $status
 *
 * The followings are the available model relations:
 * @property ExamSchedule[] $examSchedules
 * @property Student[] $students
 * @property Institution $institution0
 * @property Class $class0
 * @property Teacher $teacher0
 * @property StudentGroup $studentGroup
 * @property SubjectMark[] $subjectMarks
 */
class Subject extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{subject}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('institution, class, type, pass_mark, final_mark, subject, code', 'required'),
            array('institution, class, teacher, final_mark, student_group, subject_serial, marge_id', 'numerical', 'integerOnly' => true),
            array('type', 'length', 'max' => 50),
            array('subject', 'length', 'max' => 150),
            array('code', 'length', 'max' => 20),
            array('note', 'length', 'max' => 250),
            array('status, pass_mark', 'length', 'max' => 8),
            array('subject', 'UniqueAttributesValidator', 'with' => 'institution,class', 'message' => 'This subject already exist.'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, institution, class, teacher, type, pass_mark, final_mark, subject, code, subject_serial, marge_id, student_group, note, status', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'examSchedules' => array(self::HAS_MANY, 'ExamSchedule', 'subject'),
            'students' => array(self::HAS_MANY, 'Student', 'optional_subject'),
            'institution0' => array(self::BELONGS_TO, 'Institution', 'institution'),
            'class0' => array(self::BELONGS_TO, 'Class', 'class'),
            'teacher0' => array(self::BELONGS_TO, 'Teacher', 'teacher'),
            'studentGroup' => array(self::BELONGS_TO, 'StudentGroup', 'student_group'),
            'subjectMarks' => array(self::HAS_MANY, 'SubjectMark', 'subject'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'institution' => 'Institution',
            'class' => 'Class Name',
            'teacher' => 'Teacher Name',
            'type' => 'Type',
            'pass_mark' => 'Pass Mark %',
            'final_mark' => 'Final Mark',
            'subject' => 'Subject Name',
            'code' => 'Subject Code',
            'subject_serial' => 'Subject Serial',
            'marge_id' => 'Marge ID',
            'student_group' => 'Student Group',
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
        $criteria->compare('class', $this->class);
        $criteria->compare('teacher', $this->teacher);
        $criteria->compare('type', $this->type, true);
        $criteria->compare('pass_mark', $this->pass_mark);
        $criteria->compare('final_mark', $this->final_mark);
        $criteria->compare('subject', $this->subject, true);
        $criteria->compare('code', $this->code, true);
        $criteria->compare('subject_serial', $this->subject_serial, true);
        $criteria->compare('marge_id', $this->marge_id, true);
        $criteria->compare('student_group', $this->student_group);
        $criteria->compare('note', $this->note, true);
        $criteria->compare('status', $this->status, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => Yii::app()->params['pageSize'],
            ),
            'sort' => array('defaultOrder' => 'class ASC, subject_serial ASC, code ASC')
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Subject the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function getData($id, $field) {
        $model = Subject::model()->findByAttributes(array('id' => $id));
        if (empty($model->$field)) {
            return null;
        } else {
            return $model->$field;
        }
    }

    public static function getSubject($model, $field, $id, $cssClass = 'select2') {
        $parent1 = Subject::model()->findAll(array('condition' => 'status="Active" AND institution=' . Yii::app()->user->institution, 'order' => "code"));
        $option = '<select id="' . $model . '_' . $field . '" name="' . $model . '[' . $field . ']" class="' . $cssClass . '">';
        $option .= '<option value="">Select Subject</option>';
        foreach ($parent1 as $key => $values) {
            if ($id == $values["id"]) {
                $option .= '<option selected="selected" value="' . $values["id"] . '" class="' . $values["class"] . '">' . $values["subject"] . '</option>';
            } else {
                $option .= '<option value="' . $values["id"] . '" class="' . $values["class"] . '">' . $values["subject"] . '</option>';
            }
        }
        $option .= '</select>';

        return $option;
    }

    public static function getOptionalSubject($model, $field, $id, $cssClass = 'select2') {
        $parent1 = Subject::model()->findAll(array('condition' => 'status="Active" AND `type`="CHOOSABLE" AND institution=' . Yii::app()->user->institution, 'order' => "code"));
        $option = '<select id="' . $model . '_' . $field . '" name="' . $model . '[' . $field . ']" class="' . $cssClass . '">';
        $option .= '<option value="">Select Optional Subject</option>';
        foreach ($parent1 as $key => $values) {
            if ($id == $values["id"]) {
                $option .= '<option selected="selected" value="' . $values["id"] . '" class="' . $values["class"] . '">' . $values["subject"] . '</option>';
            } else {
                $option .= '<option value="' . $values["id"] . '" class="' . $values["class"] . '">' . $values["subject"] . '</option>';
            }
        }
        $option .= '</select>';

        return $option;
    }

}
