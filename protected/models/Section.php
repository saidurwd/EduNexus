<?php

/**
 * This is the model class for table "{{section}}".
 *
 * The followings are the available columns in table '{{section}}':
 * @property integer $id
 * @property integer $institution
 * @property string $section
 * @property string $category
 * @property integer $class
 * @property integer $capacity
 * @property integer $teacher
 * @property string $note
 * @property string $status
 *
 * The followings are the available model relations:
 * @property ExamSchedule[] $examSchedules
 * @property Institution $institution0
 * @property Class $class0
 * @property Teacher $teacher0
 * @property Student[] $students
 */
class Section extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{section}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('institution, section, class, shift, capacity', 'required'),
            array('institution, class, shift, capacity, teacher', 'numerical', 'integerOnly' => true),
            array('section, category', 'length', 'max' => 150),
            array('note', 'length', 'max' => 250),
            array('status', 'length', 'max' => 8),
            array('section', 'UniqueAttributesValidator', 'with' => 'institution,class', 'message' => 'This section already exist.'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, institution, section, category, class, shift, capacity, teacher, note, status', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'examSchedules' => array(self::HAS_MANY, 'ExamSchedule', 'section'),
            'institution0' => array(self::BELONGS_TO, 'Institution', 'institution'),
            'class0' => array(self::BELONGS_TO, 'Class', 'class'),
            'teacher0' => array(self::BELONGS_TO, 'Teacher', 'teacher'),
            'students' => array(self::HAS_MANY, 'Student', 'section'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'institution' => 'Institution',
            'section' => 'Section',
            'category' => 'Category',
            'class' => 'Class',
            'shift' => 'Shift',
            'capacity' => 'Capacity',
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
        $criteria->compare('section', $this->section, true);
        $criteria->compare('category', $this->category, true);
        $criteria->compare('class', $this->class);
        $criteria->compare('shift', $this->shift);
        $criteria->compare('capacity', $this->capacity);
        $criteria->compare('teacher', $this->teacher);
        $criteria->compare('note', $this->note, true);
        $criteria->compare('status', $this->status, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => Yii::app()->params['pageSize'],
            ),
            'sort' => array('defaultOrder' => 'class ASC, shift ASC, section ASC')
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Section the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function getData($id, $field) {
        $model = Section::model()->findByAttributes(array('id' => $id));
        if (empty($model->$field)) {
            return null;
        } else {
            return $model->$field;
        }
    }

    public static function getSection($model, $field, $id, $cssClass = 'select2') {
        $parent1 = Section::model()->findAll(array('condition' => 'status="Active" AND institution=' . Yii::app()->user->institution, 'order' => "section"));
        $option = '<select id="' . $model . '_' . $field . '" name="' . $model . '[' . $field . ']" class="' . $cssClass . '">';
        $option .= '<option value="">Select Section</option>';
        foreach ($parent1 as $key => $values) {
            if ($id == $values["id"]) {
                $option .= '<option selected="selected" value="' . $values["id"] . '" class="' . $values["class"] . '">' . Shift::getData($values["shift"], 'title') . '-' . $values["section"] . '</option>';
            } else {
                $option .= '<option value="' . $values["id"] . '" class="' . $values["class"] . '">' . Shift::getData($values["shift"], 'title') . '-' . $values["section"] . '</option>';
            }
        }
        $option .= '</select>';

        return $option;
    }

    public static function getSectionReport($field, $id, $cssClass = 'select2') {
        $parent1 = Section::model()->findAll(array('condition' => 'status="Active" AND institution=' . Yii::app()->user->institution, 'order' => "section"));
        $option = '<select id="' . $field . '" name="' . $field . '" class="' . $cssClass . '">';
        $option .= '<option value="">Select Section</option>';
        foreach ($parent1 as $key => $values) {
            if ($id == $values["id"]) {
                $option .= '<option selected="selected" value="' . $values["id"] . '" class="' . $values["class"] . '">' . Shift::getData($values["shift"], 'title') . '-' . $values["section"] . '</option>';
            } else {
                $option .= '<option value="' . $values["id"] . '" class="' . $values["class"] . '">' . Shift::getData($values["shift"], 'title') . '-' . $values["section"] . '</option>';
            }
        }
        $option .= '</select>';

        return $option;
    }

    public static function getSectionReportAdmin($field, $id, $cssClass = 'select2') {
        $parent1 = Section::model()->findAll(array('condition' => 'status="Active"', 'order' => "section"));
        $option = '<select id="' . $field . '" name="' . $field . '" class="' . $cssClass . '">';
        $option .= '<option value="">Select a Section</option>';
        foreach ($parent1 as $key => $values) {
            if ($id == $values["id"]) {
                $option .= '<option selected="selected" value="' . $values["id"] . '" class="' . $values["class"] . '">' . Shift::getData($values["shift"], 'title') . '-' . $values["section"] . '</option>';
            } else {
                $option .= '<option value="' . $values["id"] . '" class="' . $values["class"] . '">' . Shift::getData($values["shift"], 'title') . '-' . $values["section"] . '</option>';
            }
        }
        $option .= '</select>';

        return $option;
    }

}
