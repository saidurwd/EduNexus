<?php

/**
 * This is the model class for table "{{grade}}".
 *
 * The followings are the available columns in table '{{grade}}':
 * @property integer $id
 * @property integer $institution
 * @property string $grade_name
 * @property string $grade_point
 * @property integer $mark_from
 * @property integer $mark_upto
 * @property string $Note
 *
 * The followings are the available model relations:
 * @property Institution $institution0
 */
class Grade extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{grade}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('institution, class, grade_name, mark_from, mark_upto', 'required'),
            array('institution, class, mark_from, mark_upto', 'numerical', 'integerOnly' => true),
            array('grade_name', 'length', 'max' => 50),
            array('grade_point', 'length', 'max' => 4),
            array('Note', 'length', 'max' => 250),
            array('grade_name', 'UniqueAttributesValidator', 'with' => 'institution,class', 'message' => 'This grade already exist for this class.'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, institution, class, grade_name, grade_point, mark_from, mark_upto, Note', 'safe', 'on' => 'search'),
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
            'grade_name' => 'Grade Name',
            'grade_point' => 'Grade Point',
            'mark_from' => 'Mark From',
            'mark_upto' => 'Mark Upto',
            'Note' => 'Note',
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
        $criteria->compare('grade_name', $this->grade_name, true);
        $criteria->compare('grade_point', $this->grade_point, true);
        $criteria->compare('mark_from', $this->mark_from);
        $criteria->compare('mark_upto', $this->mark_upto);
        $criteria->compare('Note', $this->Note, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => Yii::app()->params['pageSize'],
            ),
            'sort' => array('defaultOrder' => 'class ASC, grade_point DESC')
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Grade the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function getData($id, $field) {
        $model = Grade::model()->findByAttributes(array('id' => $id));
        if (empty($model->$field)) {
            return null;
        } else {
            return $model->$field;
        }
    }

    public static function getGrade($model, $field, $id) {
        $parent1 = Grade::model()->findAll(array('condition' => 'institution=' . Yii::app()->user->institution, 'order' => "grade_name"));
        $option = '<select id="' . $model . '_' . $field . '" name="' . $model . '[' . $field . ']" class="select2">';
        $option .= '<option value="">Select Grade</option>';
        foreach ($parent1 as $key => $values) {
            if ($id == $values["id"]) {
                $option .= '<option selected="selected" value="' . $values["id"] . '" class="' . $values["class"] . '">' . $values["grade_name"] . '</option>';
            } else {
                $option .= '<option value="' . $values["id"] . '" class="' . $values["class"] . '">' . $values["grade_name"] . '</option>';
            }
        }
        $option .= '</select>';

        return $option;
    }

}
