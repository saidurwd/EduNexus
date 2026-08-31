<?php

/**
 * This is the model class for table "{{subject_mark}}".
 *
 * The followings are the available columns in table '{{subject_mark}}':
 * @property integer $id
 * @property integer $institution
 * @property integer $class
 * @property integer $subject
 * @property integer $written
 * @property integer $mcq
 * @property integer $practical
 * @property integer $class_assessment
 * @property integer $full_mark
 * @property string $with_class_assessment
 * @property string $passed_separately
 * @property integer $calculate_percent
 * @property string $created_on
 * @property string $updated_on
 * @property integer $created_by
 * @property integer $updated_by
 * @property string $status
 *
 * The followings are the available model relations:
 * @property Institution $institution0
 * @property Class $class0
 * @property Subject $subject0
 * @property User $createdBy
 * @property User $updatedBy
 */
class SubjectMark extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{subject_mark}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('institution, class, subject, written, mcq, practical, class_assessment, full_mark, with_class_assessment, passed_separately', 'required'),
            array('institution, class, subject, written, mcq, practical, class_assessment, full_mark, calculate_percent, created_by, updated_by', 'numerical', 'integerOnly' => true),
            array('with_class_assessment, passed_separately', 'length', 'max' => 3),
            array('status', 'length', 'max' => 8),
            array('created_on, updated_on', 'safe'),
            array('subject', 'UniqueAttributesValidator', 'with' => 'institution,class', 'message' => 'This mark distribution already exist.'),
            array('full_mark', 'checkTotalMarks'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, institution, class, subject, written, mcq, practical, class_assessment, full_mark, with_class_assessment, passed_separately, calculate_percent, created_on, updated_on, created_by, updated_by, status', 'safe', 'on' => 'search'),
        );
    }

    public function checkTotalMarks($attribute, $params) {
        $full_mark = $this->full_mark;
        if ($this->with_class_assessment == 'Yes') {
            $total_mark = (int) $this->written + (int) $this->mcq + (int) $this->practical + (int) $this->class_assessment;
        } else {
            $total_mark = (int) $this->written + (int) $this->mcq + (int) $this->practical;
        }
        if ($full_mark < $total_mark) {
            $this->addError($attribute, 'Sorry! Full mark should be equal with all input marks');
        }
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
            'subject0' => array(self::BELONGS_TO, 'Subject', 'subject'),
            'createdBy' => array(self::BELONGS_TO, 'User', 'created_by'),
            'updatedBy' => array(self::BELONGS_TO, 'User', 'updated_by'),
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
            'subject' => 'Subject',
            'written' => 'Written',
            'mcq' => 'MCQ',
            'practical' => 'Practical',
            'class_assessment' => 'Class Assessment',
            'full_mark' => 'Full Marks',
            'with_class_assessment' => 'Percentage(%) With CA',
            'passed_separately' => 'Passed Separately',
            'calculate_percent' => 'Percent',
            'created_on' => 'Created On',
            'updated_on' => 'Updated On',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
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
        $criteria->compare('subject', $this->subject);
        $criteria->compare('written', $this->written);
        $criteria->compare('mcq', $this->mcq);
        $criteria->compare('practical', $this->practical);
        $criteria->compare('class_assessment', $this->class_assessment);
        $criteria->compare('full_mark', $this->full_mark);
        $criteria->compare('with_class_assessment', $this->with_class_assessment, true);
        $criteria->compare('passed_separately', $this->passed_separately, true);
        $criteria->compare('calculate_percent', $this->calculate_percent);
        $criteria->compare('created_on', $this->created_on, true);
        $criteria->compare('updated_on', $this->updated_on, true);
        $criteria->compare('created_by', $this->created_by);
        $criteria->compare('updated_by', $this->updated_by);
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
     * @return SubjectMark the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function getData($id, $field) {
        $model = SubjectMark::model()->findByAttributes(array('id' => $id));
        if (empty($model->$field)) {
            return null;
        } else {
            return $model->$field;
        }
    }

    public static function getMark($institution, $class, $subject, $field) {
        if (!empty($institution) && !empty($class) && !empty($subject)) {
            $criteria = new CDbCriteria;
            $criteria->select = $field;
            $criteria->condition = 'class=' . $class . ' AND subject=' . $subject . ' AND institution=' . $institution;
            $model = SubjectMark::model()->find($criteria);
            if (empty($model->$field)) {
                return 0;
            } else {
                return $model->$field;
            }
        } else {
            return 0;
        }
    }

}
