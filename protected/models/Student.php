<?php

/**
 * This is the model class for table "{{student}}".
 *
 * The followings are the available columns in table '{{student}}':
 * @property integer $id
 * @property integer $institution
 * @property string $name
 * @property integer $guardian
 * @property string $birth_date
 * @property string $gender
 * @property string $blood_group
 * @property string $religion
 * @property string $email
 * @property string $phone
 * @property string $address
 * @property integer $city
 * @property integer $country
 * @property integer $nationality
 * @property string $sid
 * @property integer $class
 * @property integer $section
 * @property integer $group
 * @property integer $optional_subject
 * @property integer $academic_year
 * @property integer $roll
 * @property string $photo
 * @property string $remarks
 * @property string $created_on
 * @property string $updated_on
 * @property integer $created_by
 * @property integer $updated_by
 *
 * The followings are the available model relations:
 * @property Institution $institution0
 * @property User $createdBy
 * @property User $updatedBy
 * @property Parent $guardian0
 * @property City $city0
 * @property Country $country0
 * @property Country $nationality0
 * @property Class $class0
 * @property Section $section0
 * @property StudentGroup $group0
 * @property Subject $optionalSubject
 */
class Student extends CActiveRecord {

    public $MeritPosition, $exam, $studentid, $Migration, $student_photo;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{student}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('institution, name, academic_year, shift, class, section, group, roll, status', 'required'),
            array('institution, guardian, city, country, nationality, class, section, group, optional_subject, academic_year, shift, roll, created_by, updated_by', 'numerical', 'integerOnly' => true),
            array('name, email, address', 'length', 'max' => 150),
            array('gender', 'length', 'max' => 6),
            array('blood_group', 'length', 'max' => 3),
            array('phone', 'length', 'max' => 10),
            array('religion', 'length', 'max' => 12),
            array('sid, status', 'length', 'max' => 50),
            array('photo, remarks', 'length', 'max' => 250),
            array('birth_date, created_on, updated_on, studentid, Migration', 'safe'),
            array('photo', 'file', 'types' => 'jpg,jpeg,gif,png', 'allowEmpty' => true, 'minSize' => 2, 'maxSize' => 1024 * 1024 * 1, 'tooLarge' => 'The file was larger than 1MB. Please upload a smaller file.', 'wrongType' => 'File format was not supported.', 'tooSmall' => 'File size was too small or empty.'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, institution, name, guardian, birth_date, gender, blood_group, religion, email, phone, address, city, country, nationality, sid, class, section, group, optional_subject, academic_year, shift, roll, photo, remarks, status, created_on, updated_on, created_by, updated_by', 'safe', 'on' => 'search'),
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
            'createdBy' => array(self::BELONGS_TO, 'User', 'created_by'),
            'updatedBy' => array(self::BELONGS_TO, 'User', 'updated_by'),
            'guardian0' => array(self::BELONGS_TO, 'Parent', 'guardian'),
            'city0' => array(self::BELONGS_TO, 'City', 'city'),
            'country0' => array(self::BELONGS_TO, 'Country', 'country'),
            'nationality0' => array(self::BELONGS_TO, 'Country', 'nationality'),
            'class0' => array(self::BELONGS_TO, 'Class', 'class'),
            'section0' => array(self::BELONGS_TO, 'Section', 'section'),
            'group0' => array(self::BELONGS_TO, 'StudentGroup', 'group'),
            'optionalSubject' => array(self::BELONGS_TO, 'Subject', 'optional_subject'),
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
            'name' => 'Name',
            'guardian' => 'Guardian',
            'birth_date' => 'Date of Birth',
            'gender' => 'Gender',
            'blood_group' => 'Blood Group',
            'religion' => 'Religion',
            'email' => 'Email',
            'phone' => 'Phone',
            'address' => 'Address',
            'city' => 'City',
            'country' => 'Country',
            'nationality' => 'Nationality',
            'sid' => 'Student ID',
            'class' => 'Class',
            'section' => 'Section',
            'group' => 'Group',
            'optional_subject' => 'Optional Subject',
            'academic_year' => 'Academic Year',
            'shift' => 'Shift',
            'roll' => 'Roll',
            'roll' => 'Roll',
            'photo' => 'Photo',
            'remarks' => 'Remarks',
            'created_on' => 'Created On',
            'updated_on' => 'Updated On',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'MeritPosition' => 'Merit Position',
            'exam' => 'Exam',
            'Migration' => 'Migration',
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
        $criteria->having = 'status!="PENDING"';
        $criteria->compare('name', $this->name, true);
        $criteria->compare('guardian', $this->guardian);
        $criteria->compare('birth_date', $this->birth_date, true);
        $criteria->compare('gender', $this->gender, true);
        $criteria->compare('blood_group', $this->blood_group, true);
        $criteria->compare('religion', $this->religion, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('phone', $this->phone, true);
        $criteria->compare('address', $this->address, true);
        $criteria->compare('city', $this->city);
        $criteria->compare('country', $this->country);
        $criteria->compare('nationality', $this->nationality);
        $criteria->compare('sid', $this->sid, true);
        $criteria->compare('class', $this->class);
        $criteria->compare('section', $this->section);
        $criteria->compare('`group`', $this->group);
        $criteria->compare('optional_subject', $this->optional_subject);
        $criteria->compare('academic_year', $this->academic_year);
        $criteria->compare('shift', $this->shift);
        $criteria->compare('roll', $this->roll);
//        $criteria->compare('status', $this->status);
        $criteria->compare('photo', $this->photo, true);
        $criteria->compare('remarks', $this->remarks, true);
        $criteria->compare('created_on', $this->created_on, true);
        $criteria->compare('updated_on', $this->updated_on, true);
        $criteria->compare('created_by', $this->created_by);
        $criteria->compare('updated_by', $this->updated_by);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => Yii::app()->params['pageSize'],
            ),
            'sort' => array('defaultOrder' => 'class ASC, section ASC, roll ASC')
        ));
    }

    public function search_admission() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('institution', Yii::app()->user->institution);
        $criteria->compare('status', 'PENDING');
        $criteria->compare('name', $this->name, true);
        $criteria->compare('guardian', $this->guardian);
        $criteria->compare('birth_date', $this->birth_date, true);
        $criteria->compare('gender', $this->gender, true);
        $criteria->compare('blood_group', $this->blood_group, true);
        $criteria->compare('religion', $this->religion, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('phone', $this->phone, true);
        $criteria->compare('address', $this->address, true);
        $criteria->compare('city', $this->city);
        $criteria->compare('country', $this->country);
        $criteria->compare('nationality', $this->nationality);
        $criteria->compare('sid', $this->sid, true);
        $criteria->compare('class', $this->class);
        $criteria->compare('section', $this->section);
        $criteria->compare('`group`', $this->group);
        $criteria->compare('optional_subject', $this->optional_subject);
        $criteria->compare('academic_year', $this->academic_year);
        $criteria->compare('shift', $this->shift);
        $criteria->compare('roll', $this->roll);
//        $criteria->compare('status', $this->status);
        $criteria->compare('photo', $this->photo, true);
        $criteria->compare('remarks', $this->remarks, true);
        $criteria->compare('created_on', $this->created_on, true);
        $criteria->compare('updated_on', $this->updated_on, true);
        $criteria->compare('created_by', $this->created_by);
        $criteria->compare('updated_by', $this->updated_by);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => Yii::app()->params['pageSize'],
            ),
            'sort' => array('defaultOrder' => 'class ASC, section ASC, roll ASC')
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Student the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function getData($id, $field) {
        $model = Student::model()->findByAttributes(array('id' => $id));
        if (empty($model->$field)) {
            return null;
        } else {
            return $model->$field;
        }
    }

    public static function getPhoto($id) {
        $value = Student::model()->findByAttributes(array('id' => $id));
        $filePath = Yii::app()->basePath . '/../uploads/student/' . Yii::app()->user->institution . '/' . $value->photo;
        if ((is_file($filePath)) && (file_exists($filePath))) {
            return CHtml::image(Yii::app()->baseUrl . '/uploads/student/' . Yii::app()->user->institution . '/' . $value->photo, 'Photo', array('alt' => 'Photo', 'class' => 'img-responsive', 'title' => ''));
        } else {
            return CHtml::image(Yii::app()->baseUrl . '/uploads/student/default.png', 'Photo', array('alt' => 'Photo', 'class' => 'img-responsive', 'title' => ''));
        }
    }

    public static function getPhotoAdmitCard($id, $width = 100) {
        $value = Student::model()->findByAttributes(array('id' => $id));
        $filePath = Yii::app()->basePath . '/../uploads/student/' . Yii::app()->user->institution . '/' . $value->photo;
        if ((is_file($filePath)) && (file_exists($filePath))) {
            return CHtml::image(Yii::app()->baseUrl . '/uploads/student/' . Yii::app()->user->institution . '/' . $value->photo, 'Photo', array('alt' => 'Photo', 'class' => 'img-responsive', 'style' => 'width:' . $width . 'px'));
        } else {
            return CHtml::image(Yii::app()->baseUrl . '/uploads/student/default.png', 'Photo', array('alt' => 'Photo', 'class' => 'img-responsive', 'style' => 'width:' . $width . 'px'));
        }
    }

    public static function getPhotoAdmitCardAdmin($id, $width = 100, $institution) {
        $value = Student::model()->findByAttributes(array('id' => $id));
        $filePath = Yii::app()->basePath . '/../uploads/student/' . $institution . '/' . $value->photo;
        if ((is_file($filePath)) && (file_exists($filePath))) {
            return CHtml::image(Yii::app()->baseUrl . '/uploads/student/' . $institution . '/' . $value->photo, 'Photo', array('alt' => 'Photo', 'class' => 'img-responsive', 'style' => 'width:' . $width . 'px'));
        } else {
            return CHtml::image(Yii::app()->baseUrl . '/uploads/student/default.png', 'Photo', array('alt' => 'Photo', 'class' => 'img-responsive', 'style' => 'width:' . $width . 'px'));
        }
    }

    public static function getStudent($model, $field, $id) {
        $parent1 = Student::model()->findAll(array('condition' => 'status="ACTIVE" AND institution=' . Yii::app()->user->institution, 'order' => "name"));
        $option = '<select id="' . $model . '_' . $field . '" name="' . $model . '[' . $field . ']" class="select2">';
        $option .= '<option value="">Select Student</option>';
        foreach ($parent1 as $key => $values) {
            if ($id == $values["id"]) {
                $option .= '<option selected="selected" value="' . $values["id"] . '" class="' . $values["group"] . '">' . $values["name"] . '</option>';
            } else {
                $option .= '<option value="' . $values["id"] . '" class="' . $values["group"] . '">' . $values["name"] . '</option>';
            }
        }
        $option .= '</select>';

        return $option;
    }
    
    public static function getStudentBySection($model, $field, $id) {
        $parent1 = Student::model()->findAll(array('condition' => 'status="ACTIVE" AND institution=' . Yii::app()->user->institution, 'order' => "name"));
        $option = '<select id="' . $model . '_' . $field . '" name="' . $model . '[' . $field . ']" class="form-control">';
        $option .= '<option value="">Select Student</option>';
        foreach ($parent1 as $key => $values) {
            if ($id == $values["id"]) {
                $option .= '<option selected="selected" value="' . $values["id"] . '" class="' . $values["section"] . '">' . $values["name"] . '</option>';
            } else {
                $option .= '<option value="' . $values["id"] . '" class="' . $values["section"] . '">' . $values["name"] . '</option>';
            }
        }
        $option .= '</select>';

        return $option;
    }

    public static function studentAttendanceCount($date) {
        $array = Student::model()->findAll(array('condition' => 'institution=' . Yii::app()->user->institution . ' AND DATE_FORMAT(`attendance_in`, "%Y-%m-%d")=DATE_FORMAT("' . $date . '", "%Y-%m-%d")'));
        return count($array);
    }

}
