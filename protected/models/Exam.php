<?php

/**
 * This is the model class for table "{{exam}}".
 *
 * The followings are the available columns in table '{{exam}}':
 * @property integer $id
 * @property integer $institution
 * @property string $exam_name
 * @property string $exam_date
 * @property string $note
 *
 * The followings are the available model relations:
 * @property Institution $institution0
 * @property ExamSchedule[] $examSchedules
 */
class Exam extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{exam}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('institution, class, exam_name, exam_date, academic_year, result, status', 'required'),
            array('institution, class', 'numerical', 'integerOnly' => true),
            array('exam_name', 'length', 'max' => 150),
            array('note', 'length', 'max' => 250),
            array('result, status', 'length', 'max' => 50),
            array('exam_name', 'UniqueAttributesValidator', 'with' => 'institution,class', 'message' => 'This exam already exist for this class.'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, institution, class, exam_name, exam_date, note, academic_year, result, status', 'safe', 'on' => 'search'),
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
            'examSchedules' => array(self::HAS_MANY, 'ExamSchedule', 'exam'),
            'academicYear0' => array(self::HAS_MANY, 'AcademicYear', 'academic_year'),
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
            'exam_name' => 'Exam Name',
            'exam_date' => 'Exam Date',
            'note' => 'Note',
            'academic_year' => 'Academic Year',
            'result' => 'Result',
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
        $criteria->compare('exam_name', $this->exam_name, true);
        $criteria->compare('exam_date', $this->exam_date, true);
        $criteria->compare('note', $this->note, true);
        $criteria->compare('academic_year', $this->academic_year);
        $criteria->compare('result', $this->result, true);
        $criteria->compare('status', $this->status, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => Yii::app()->params['pageSize'],
            ),
            'sort' => array('defaultOrder' => 'class ASC, exam_name ASC')
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Exam the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function getData($id, $field) {
        $model = Exam::model()->findByAttributes(array('id' => $id));
        if (empty($model->$field)) {
            return null;
        } else {
            return $model->$field;
        }
    }

    public static function getExam($model, $field, $id) {
        $parent1 = Exam::model()->findAll(array('condition' => 'institution=' . Yii::app()->user->institution, 'order' => "exam_name"));
        $option = '<select id="' . $model . '_' . $field . '" name="' . $model . '[' . $field . ']" class="select2">';
        $option .= '<option value="">Select Exam</option>';
        foreach ($parent1 as $key => $values) {
            if ($id == $values["id"]) {
                $option .= '<option selected="selected" value="' . $values["id"] . '" class="' . $values["class"] . '">' . $values["exam_name"] . '</option>';
            } else {
                $option .= '<option value="' . $values["id"] . '" class="' . $values["class"] . '">' . $values["exam_name"] . '</option>';
            }
        }
        $option .= '</select>';

        return $option;
    }

    public static function getExamReport($field, $id) {
        $parent1 = Exam::model()->findAll(array('condition' => 'institution=' . Yii::app()->user->institution, 'order' => "exam_name"));
        $option = '<select id="' . $field . '" name="' . $field . '" class="select2">';
        $option .= '<option value="">Select Exam</option>';
        foreach ($parent1 as $key => $values) {
            if ($id == $values["id"]) {
                $option .= '<option selected="selected" value="' . $values["id"] . '" class="' . $values["class"] . '">' . $values["exam_name"] . '</option>';
            } else {
                $option .= '<option value="' . $values["id"] . '" class="' . $values["class"] . '">' . $values["exam_name"] . '</option>';
            }
        }
        $option .= '</select>';

        return $option;
    }

}
