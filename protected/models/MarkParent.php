<?php

/**
 * This is the model class for table "{{mark_parent}}".
 *
 * The followings are the available columns in table '{{mark_parent}}':
 * @property integer $id
 * @property integer $institution
 * @property integer $class
 * @property integer $section
 * @property integer $group
 * @property integer $subject
 * @property integer $exam
 * @property integer $academic_year
 * @property string $created_on
 * @property string $updated_on
 * @property integer $created_by
 * @property integer $updated_by
 *
 * The followings are the available model relations:
 * @property Institution $institution0
 * @property Class $class0
 * @property Section $section0
 * @property StudentGroup $group0
 * @property Subject $subject0
 * @property Exam $exam0
 * @property AcademicYear $academicYear
 */
class MarkParent extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{mark_parent}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('institution, class, section, group, subject, exam, academic_year', 'required'),
            array('institution, class, section, group, subject, exam, academic_year, created_by, updated_by', 'numerical', 'integerOnly' => true),
            array('created_on, updated_on', 'safe'),
            array('subject', 'UniqueAttributesValidator', 'with' => 'institution,class,section,group,exam,academic_year', 'message' => 'Subject mark already exist for this class. Please go for update.'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, institution, class, section, group, subject, exam, academic_year, created_on, updated_on, created_by, updated_by', 'safe', 'on' => 'search'),
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
            'class0' => array(self::BELONGS_TO, 'Class', 'class'),
            'section0' => array(self::BELONGS_TO, 'Section', 'section'),
            'group0' => array(self::BELONGS_TO, 'StudentGroup', 'group'),
            'subject0' => array(self::BELONGS_TO, 'Subject', 'subject'),
            'exam0' => array(self::BELONGS_TO, 'Exam', 'exam'),
            'academicYear' => array(self::BELONGS_TO, 'AcademicYear', 'academic_year'),
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
            'section' => 'Section',
            'group' => 'Group',
            'subject' => 'Subject',
            'exam' => 'Exam',
            'academic_year' => 'Academic Year',
            'created_on' => 'Created On',
            'updated_on' => 'Updated On',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
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
        $criteria->compare('section', $this->section);
        $criteria->compare('group', $this->group);
        $criteria->compare('subject', $this->subject);
        $criteria->compare('exam', $this->exam);
        $criteria->compare('academic_year', $this->academic_year);
        $criteria->compare('created_on', $this->created_on, true);
        $criteria->compare('updated_on', $this->updated_on, true);
        $criteria->compare('created_by', $this->created_by);
        $criteria->compare('updated_by', $this->updated_by);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => Yii::app()->params['pageSize'],
            ),
            'sort' => array('defaultOrder' => 'academic_year DESC, created_on DESC, id DESC')
        ));
    }

    public function search_tabulationsheet() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('institution', Yii::app()->user->institution);
        $criteria->compare('class', $this->class);
        $criteria->compare('section', $this->section);
        $criteria->compare('group', $this->group);
        $criteria->compare('subject', $this->subject);
        $criteria->compare('exam', $this->exam);
        $criteria->compare('academic_year', $this->academic_year);
        $criteria->compare('created_on', $this->created_on, true);
        $criteria->compare('updated_on', $this->updated_on, true);
        $criteria->compare('created_by', $this->created_by);
        $criteria->compare('updated_by', $this->updated_by);
        $criteria->group = '`class`,`section`,`group`,`exam`,`academic_year`';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => Yii::app()->params['pageSize'],
            ),
        ));
    }

    public function search_grandfinal() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('institution', Yii::app()->user->institution);
        $criteria->compare('class', $this->class);
        $criteria->compare('section', $this->section);
        $criteria->compare('group', $this->group);
        $criteria->compare('subject', $this->subject);
        $criteria->compare('exam', $this->exam);
        $criteria->compare('academic_year', $this->academic_year);
        $criteria->compare('created_on', $this->created_on, true);
        $criteria->compare('updated_on', $this->updated_on, true);
        $criteria->compare('created_by', $this->created_by);
        $criteria->compare('updated_by', $this->updated_by);
        $criteria->group = '`class`,`section`,`group`,`academic_year`';

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
     * @return MarkParent the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function getData($id, $field) {
        $model = MarkParent::model()->findByAttributes(array('id' => $id));
        if (empty($model->$field)) {
            return null;
        } else {
            return $model->$field;
        }
    }

}
