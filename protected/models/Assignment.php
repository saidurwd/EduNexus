<?php

/**
 * This is the model class for table "{{assignment}}".
 *
 * The followings are the available columns in table '{{assignment}}':
 * @property integer $id
 * @property integer $institution
 * @property integer $class
 * @property integer $section
 * @property integer $subject
 * @property string $title
 * @property string $description
 * @property string $deadline
 * @property string $file
 * @property string $created_on
 * @property integer $created_by
 *
 * The followings are the available model relations:
 * @property Institution $institution0
 * @property Class $class0
 * @property Section $section0
 * @property Subject $subject0
 * @property User $createdBy
 */
class Assignment extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{assignment}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('institution, class, section, subject, title', 'required'),
            array('institution, class, section, subject, created_by', 'numerical', 'integerOnly' => true),
            array('title', 'length', 'max' => 150),
            array('file', 'length', 'max' => 250),
            array('description, deadline, created_on', 'safe'),
            array('file', 'file', 'types' => 'jpg,jpeg,gif,png,pdf,doc,docx,odt,xls,xlsx', 'allowEmpty' => true, 'minSize' => 2, 'maxSize' => 1024 * 1024 * 5, 'tooLarge' => 'The file was larger than 5MB. Please upload a smaller file.', 'wrongType' => 'File format was not supported.', 'tooSmall' => 'File size was too small or empty.'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, institution, class, section, subject, title, description, deadline, file, created_on, created_by', 'safe', 'on' => 'search'),
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
            'subject0' => array(self::BELONGS_TO, 'Subject', 'subject'),
            'createdBy' => array(self::BELONGS_TO, 'User', 'created_by'),
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
            'subject' => 'Subject',
            'title' => 'Title',
            'description' => 'Description',
            'deadline' => 'Deadline',
            'file' => 'File',
            'created_on' => 'Uploaded By',
            'created_by' => 'Uploader',
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
        $criteria->compare('subject', $this->subject);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('deadline', $this->deadline, true);
        $criteria->compare('file', $this->file, true);
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
     * @return Assignment the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function getData($id, $field) {
        $model = Assignment::model()->findByAttributes(array('id' => $id));
        if (empty($model->$field)) {
            return null;
        } else {
            return $model->$field;
        }
    }

}
