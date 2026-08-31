<?php

/**
 * This is the model class for table "{{institution}}".
 *
 * The followings are the available columns in table '{{institution}}':
 * @property integer $id
 * @property string $institution
 * @property string $sub_title
 * @property string $phone
 * @property string $email
 * @property string $address
 * @property string $logo
 * @property string $banner
 * @property string $signature
 * @property string $footer
 *
 * The followings are the available model relations:
 * @property AcademicYear[] $academicYears
 * @property Class[] $classes
 * @property Exam[] $exams
 * @property ExamSchedule[] $examSchedules
 * @property Grade[] $grades
 * @property Parent[] $parents
 * @property Section[] $sections
 * @property Student[] $students
 * @property StudentGroup[] $studentGroups
 * @property Subject[] $subjects
 * @property SubjectMark[] $subjectMarks
 * @property Teacher[] $teachers
 */
class Institution extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{institution}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('institution', 'required'),
            array('institution, sub_title, address, logo, banner, signature, footer, menu_logo, special_logo', 'length', 'max' => 250),
            array('phone, institute_code, mpo_code, eiin, eastablished', 'length', 'max' => 50),
            array('email, twitter, facebook, instagram, youtube', 'length', 'max' => 150),
            array('map, footer', 'length', 'max' => 600),
            array('institution', 'unique'),
            array('logo', 'file', 'types' => 'jpg,jpeg,gif,png', 'allowEmpty' => true, 'minSize' => 2, 'maxSize' => 1024 * 1024 * 1, 'tooLarge' => 'The file was larger than 1MB. Please upload a smaller file.', 'wrongType' => 'File format was not supported.', 'tooSmall' => 'File size was too small or empty.'),
            array('signature', 'file', 'types' => 'jpg,jpeg,gif,png', 'allowEmpty' => true, 'minSize' => 2, 'maxSize' => 1024 * 1024 * 1, 'tooLarge' => 'The file was larger than 1MB. Please upload a smaller file.', 'wrongType' => 'File format was not supported.', 'tooSmall' => 'File size was too small or empty.'),
            array('menu_logo', 'file', 'types' => 'jpg,jpeg,gif,png', 'allowEmpty' => true, 'minSize' => 2, 'maxSize' => 1024 * 1024 * 1, 'tooLarge' => 'The file was larger than 1MB. Please upload a smaller file.', 'wrongType' => 'File format was not supported.', 'tooSmall' => 'File size was too small or empty.'),
            array('special_logo', 'file', 'types' => 'jpg,jpeg,gif,png', 'allowEmpty' => true, 'minSize' => 2, 'maxSize' => 1024 * 1024 * 1, 'tooLarge' => 'The file was larger than 1MB. Please upload a smaller file.', 'wrongType' => 'File format was not supported.', 'tooSmall' => 'File size was too small or empty.'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, institution, sub_title, phone, email, address, logo, banner, signature, map, footer, institute_code, mpo_code, eiin, eastablished, menu_logo, special_logo', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'academicYears' => array(self::HAS_MANY, 'AcademicYear', 'institution'),
            'classes' => array(self::HAS_MANY, 'Class', 'institution'),
            'exams' => array(self::HAS_MANY, 'Exam', 'institution'),
            'examSchedules' => array(self::HAS_MANY, 'ExamSchedule', 'institution'),
            'grades' => array(self::HAS_MANY, 'Grade', 'institution'),
            'parents' => array(self::HAS_MANY, 'Parent', 'institution'),
            'sections' => array(self::HAS_MANY, 'Section', 'institution'),
            'students' => array(self::HAS_MANY, 'Student', 'institution'),
            'studentGroups' => array(self::HAS_MANY, 'StudentGroup', 'institution'),
            'subjects' => array(self::HAS_MANY, 'Subject', 'institution'),
            'subjectMarks' => array(self::HAS_MANY, 'SubjectMark', 'institution'),
            'teachers' => array(self::HAS_MANY, 'Teacher', 'institution'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'institution' => 'Institution',
            'sub_title' => 'Sub Title',
            'phone' => 'Phone',
            'email' => 'Email',
            'address' => 'Address',
            'logo' => 'Logo',
            'banner' => 'Banner',
            'signature' => 'Signature',
            'footer' => 'Footer',
            'map' => 'Google Map',
            'institute_code' => 'Institute ID',
            'mpo_code' => 'MPO Code',
            'eiin' => 'EIIN NO.',
            'eastablished' => 'Established',
            'menu_logo' => 'Menu Logo',
            'special_logo' => 'Special Logo',
            'twitter' => 'Twitter',
            'facebook' => 'Facebook',
            'instagram' => 'Instagram',
            'youtube' => 'Youtube',
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
        $criteria->compare('institution', $this->institution, true);
        $criteria->compare('sub_title', $this->sub_title, true);
        $criteria->compare('phone', $this->phone, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('address', $this->address, true);
        $criteria->compare('logo', $this->logo, true);
        $criteria->compare('banner', $this->banner, true);
        $criteria->compare('signature', $this->signature, true);
        $criteria->compare('footer', $this->footer, true);
        $criteria->compare('map', $this->map, true);
        $criteria->compare('institute_code', $this->institute_code, true);
        $criteria->compare('mpo_code', $this->mpo_code, true);
        $criteria->compare('eiin', $this->eiin, true);
        $criteria->compare('eastablished', $this->eastablished, true);
        $criteria->compare('menu_logo', $this->menu_logo, true);
        $criteria->compare('special_logo', $this->special_logo, true);

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
     * @return Institution the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function getData($id, $field) {
        $model = Institution::model()->findByAttributes(array('id' => $id));
        if (empty($model->$field)) {
            return null;
        } else {
            return $model->$field;
        }
    }

    public static function getAlertInfo($slug, $note) {
        return '<div class="alert alert-info fade in"><i class="fa-fw fa fa-info"></i><strong>' . $slug . '</strong> ' . $note . '</div>';
    }

    public static function getAlertWarning($slug, $note) {
        return '<div class="alert alert-warning fade in"><i class="fa-fw fa fa-info"></i><strong>' . $slug . '</strong> ' . $note . '</div>';
    }

    public static function getPhoto($id, $field, $width = 100) {
        $value = Institution::model()->findByAttributes(array('id' => $id));
        $filePath = Yii::app()->basePath . '/../uploads/institution/' . Yii::app()->user->institution . '/' . $value->$field;
        if ((is_file($filePath)) && (file_exists($filePath))) {
            return CHtml::image(Yii::app()->baseUrl . '/uploads/institution/' . Yii::app()->user->institution . '/' . $value->$field, 'Photo', array('alt' => 'Photo', 'class' => 'img-responsive', 'style' => 'width:' . $width . 'px'));
        } else {
            return CHtml::image(Yii::app()->baseUrl . '/uploads/institution/default.png', 'Photo', array('alt' => 'Photo', 'class' => 'img-responsive', 'style' => 'width:' . $width . 'px'));
        }
    }

    public static function getPhotoResponsive($id, $field) {
        $value = Institution::model()->findByAttributes(array('id' => $id));
        $filePath = Yii::app()->basePath . '/../uploads/institution/' . Yii::app()->user->institution . '/' . $value->$field;
        if ((is_file($filePath)) && (file_exists($filePath))) {
            return CHtml::image(Yii::app()->baseUrl . '/uploads/institution/' . Yii::app()->user->institution . '/' . $value->$field, 'Photo', array('alt' => 'Photo', 'class' => 'img-responsive'));
        } else {
            return CHtml::image(Yii::app()->baseUrl . '/uploads/institution/default.png', 'Photo', array('alt' => 'Photo', 'class' => 'img-responsive'));
        }
    }

}
