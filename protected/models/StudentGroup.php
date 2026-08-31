<?php

/**
 * This is the model class for table "{{student_group}}".
 *
 * The followings are the available columns in table '{{student_group}}':
 * @property integer $id
 * @property integer $institution
 * @property string $title
 * @property string $status
 *
 * The followings are the available model relations:
 * @property Student[] $students
 * @property Institution $institution0
 * @property Subject[] $subjects
 */
class StudentGroup extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{student_group}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('institution, class, title', 'required'),
            array('institution, class', 'numerical', 'integerOnly' => true),
            array('title', 'length', 'max' => 150),
            array('status', 'length', 'max' => 8),
            array('title', 'UniqueAttributesValidator', 'with' => 'institution,class', 'message' => 'This group already exist.'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, institution, class, title, status', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'students' => array(self::HAS_MANY, 'Student', 'group'),
            'institution0' => array(self::BELONGS_TO, 'Institution', 'institution'),
            'subjects' => array(self::HAS_MANY, 'Subject', 'student_group'),
            'class0' => array(self::BELONGS_TO, 'Classs', 'class'),
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
            'title' => 'Group',
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
        $criteria->compare('title', $this->title, true);
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
     * @return StudentGroup the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function getData($id, $field) {
        $model = StudentGroup::model()->findByAttributes(array('id' => $id));
        if (empty($model->$field)) {
            return null;
        } else {
            return $model->$field;
        }
    }

    public static function getStudentGroup($model, $field, $id, $default = 'Select Group', $cssClass = 'select2') {
        $parent1 = StudentGroup::model()->findAll(array('condition' => 'status="Active" AND institution=' . Yii::app()->user->institution, 'order' => "title"));
        $option = '<select id="' . $model . '_' . $field . '" name="' . $model . '[' . $field . ']" class="' . $cssClass . '">';
        $option .= '<option value="">' . $default . '</option>';
        foreach ($parent1 as $key => $values) {
            if ($id == $values["id"]) {
                $option .= '<option selected="selected" value="' . $values["id"] . '" class="' . $values["class"] . '">' . $values["title"] . '</option>';
            } else {
                $option .= '<option value="' . $values["id"] . '" class="' . $values["class"] . '">' . $values["title"] . '</option>';
            }
        }
        $option .= '</select>';

        return $option;
    }

}
