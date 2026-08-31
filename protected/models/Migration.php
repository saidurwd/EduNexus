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
 * @property integer $shift
 * @property integer $roll
 * @property string $photo
 * @property string $remarks
 * @property string $status
 * @property string $created_on
 * @property string $updated_on
 * @property integer $created_by
 * @property integer $updated_by
 *
 * The followings are the available model relations:
 * @property Attendance[] $attendances
 * @property Mark[] $marks
 * @property MeritPosition[] $meritPositions
 * @property Institution $institution0
 * @property User $createdBy
 * @property User $updatedBy
 * @property Shift $shift0
 * @property Parent $guardian0
 * @property City $city0
 * @property Country $country0
 * @property Country $nationality0
 * @property Class $class0
 * @property Section $section0
 * @property StudentGroup $group0
 * @property Subject $optionalSubject
 * @property StudentLeave[] $studentLeaves
 */
class Migration extends CActiveRecord {

    public $studentid, $Migration, $student_photo;

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
            array('institution, name, class, section, group, shift, academic_year, roll', 'required'),
            array('institution, guardian, city, country, nationality, class, section, group, optional_subject, academic_year, shift, roll, created_by, updated_by', 'numerical', 'integerOnly' => true),
            array('name, email, address', 'length', 'max' => 150),
            array('gender', 'length', 'max' => 6),
            array('blood_group', 'length', 'max' => 3),
            array('religion', 'length', 'max' => 12),
            array('phone', 'length', 'max' => 10),
            array('sid', 'length', 'max' => 50),
            array('photo, remarks', 'length', 'max' => 250),
            array('status', 'length', 'max' => 11),
            array('birth_date, created_on, updated_on, studentid, Migration', 'safe'),
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
            'attendances' => array(self::HAS_MANY, 'Attendance', 'student'),
            'marks' => array(self::HAS_MANY, 'Mark', 'student'),
            'meritPositions' => array(self::HAS_MANY, 'MeritPosition', 'student'),
            'institution0' => array(self::BELONGS_TO, 'Institution', 'institution'),
            'createdBy' => array(self::BELONGS_TO, 'User', 'created_by'),
            'updatedBy' => array(self::BELONGS_TO, 'User', 'updated_by'),
            'shift0' => array(self::BELONGS_TO, 'Shift', 'shift'),
            'guardian0' => array(self::BELONGS_TO, 'Parent', 'guardian'),
            'city0' => array(self::BELONGS_TO, 'City', 'city'),
            'country0' => array(self::BELONGS_TO, 'Country', 'country'),
            'nationality0' => array(self::BELONGS_TO, 'Country', 'nationality'),
            'class0' => array(self::BELONGS_TO, 'Class', 'class'),
            'section0' => array(self::BELONGS_TO, 'Section', 'section'),
            'group0' => array(self::BELONGS_TO, 'StudentGroup', 'group'),
            'optionalSubject' => array(self::BELONGS_TO, 'Subject', 'optional_subject'),
            'studentLeaves' => array(self::HAS_MANY, 'StudentLeave', 'student'),
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
            'photo' => 'Photo',
            'remarks' => 'Remarks',
            'status' => 'Status',
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
        $criteria->compare('group', $this->group);
        $criteria->compare('optional_subject', $this->optional_subject);
        $criteria->compare('academic_year', $this->academic_year);
        $criteria->compare('shift', $this->shift);
        $criteria->compare('roll', $this->roll);
        $criteria->compare('photo', $this->photo, true);
        $criteria->compare('remarks', $this->remarks, true);
        $criteria->compare('status', $this->status, true);
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
     * @return Migration the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
