<?php

/**
 * This is the model class for table "{{teacher}}".
 *
 * The followings are the available columns in table '{{teacher}}':
 * @property integer $id
 * @property integer $institution
 * @property string $teacher_name
 * @property string $designation
 * @property string $birth_date
 * @property string $gender
 * @property string $religion
 * @property string $email
 * @property integer $phone
 * @property string $Address
 * @property string $joining_date
 * @property string $photo
 * @property string $status
 *
 * The followings are the available model relations:
 * @property Class[] $classes
 * @property Section[] $sections
 * @property Subject[] $subjects
 * @property Institution $institution0
 */
class Teacher extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{teacher}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('institution, teacher_name, designation', 'required'),
            array('institution, phone', 'numerical', 'integerOnly' => true),
            array('teacher_name, designation, religion, email', 'length', 'max' => 150),
            array('gender', 'length', 'max' => 6),
            array('Address, photo', 'length', 'max' => 250),
            array('status', 'length', 'max' => 8),
            array('birth_date, joining_date', 'safe'),
            array('photo', 'file', 'types' => 'jpg,jpeg,gif,png', 'allowEmpty' => true, 'minSize' => 2, 'maxSize' => 1024 * 1024 * 1, 'tooLarge' => 'The file was larger than 1MB. Please upload a smaller file.', 'wrongType' => 'File format was not supported.', 'tooSmall' => 'File size was too small or empty.'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, institution, teacher_name, designation, birth_date, gender, religion, email, phone, Address, joining_date, photo, status', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'classes' => array(self::HAS_MANY, 'Class', 'teacher'),
            'sections' => array(self::HAS_MANY, 'Section', 'teacher'),
            'subjects' => array(self::HAS_MANY, 'Subject', 'teacher'),
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
            'teacher_name' => 'Teacher Name',
            'designation' => 'Designation',
            'birth_date' => 'Date of Birth',
            'gender' => 'Gender',
            'religion' => 'Religion',
            'email' => 'Email',
            'phone' => 'Phone',
            'Address' => 'Address',
            'joining_date' => 'Joining Date',
            'photo' => 'Photo',
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
        $criteria->compare('teacher_name', $this->teacher_name, true);
        $criteria->compare('designation', $this->designation, true);
        $criteria->compare('birth_date', $this->birth_date, true);
        $criteria->compare('gender', $this->gender, true);
        $criteria->compare('religion', $this->religion, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('phone', $this->phone);
        $criteria->compare('Address', $this->Address, true);
        $criteria->compare('joining_date', $this->joining_date, true);
        $criteria->compare('photo', $this->photo, true);
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
     * @return Teacher the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function getData($id, $field) {
        $model = Teacher::model()->findByAttributes(array('id' => $id));
        if (empty($model->$field)) {
            return null;
        } else {
            return $model->$field;
        }
    }

    public static function getPhoto($id) {
        $value = Teacher::model()->findByAttributes(array('id' => $id));
        $filePath = Yii::app()->basePath . '/../uploads/teacher/' . Yii::app()->user->institution . '/' . $value->photo;
        if ((is_file($filePath)) && (file_exists($filePath))) {
            return CHtml::image(Yii::app()->baseUrl . '/uploads/teacher/' . Yii::app()->user->institution . '/' . $value->photo, 'Photo', array('alt' => 'Photo', 'class' => 'img-responsive', 'title' => ''));
        } else {
            return CHtml::image(Yii::app()->baseUrl . '/uploads/teacher/default.png', 'Photo', array('alt' => 'Photo', 'class' => 'img-responsive', 'title' => ''));
        }
    }

}
