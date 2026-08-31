<?php

/**
 * This is the model class for table "{{attendance_teacher}}".
 *
 * The followings are the available columns in table '{{attendance_teacher}}':
 * @property string $id
 * @property integer $institution
 * @property integer $teacher
 * @property string $attendance_in
 * @property string $attendance_out
 * @property string $attendance
 * @property string $created_on
 * @property string $created_by
 *
 * The followings are the available model relations:
 * @property Institution $institution0
 * @property Teacher $teacher0
 */
class AttendanceTeacher extends CActiveRecord {

    public $teacherid;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{attendance_teacher}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('institution, teacher, attendance_in, created_on, created_by', 'required'),
            array('institution, teacher', 'numerical', 'integerOnly' => true),
            array('attendance', 'length', 'max' => 24),
            array('attendance_in, attendance_out, teacherid', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, institution, teacher, attendance_in, attendance_out, attendance, created_on, created_by, teacherid', 'safe', 'on' => 'search'),
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
            'teacher0' => array(self::BELONGS_TO, 'Teacher', 'teacher'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'institution' => 'Institution',
            'teacher' => 'Teacher',
            'attendance_in' => 'Attendance Date',
            'attendance_out' => 'Out',
            'attendance' => 'Attendance',
            'created_on' => 'Created On',
            'created_by' => 'Created By',
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

        $criteria->compare('id', $this->id, true);
        $criteria->compare('institution', Yii::app()->user->institution);
        $criteria->compare('teacher', $this->teacher);
        $criteria->compare('attendance_in', $this->attendance_in, true);
        $criteria->compare('attendance_out', $this->attendance_out, true);
        $criteria->compare('attendance', $this->attendance, true);
        $criteria->compare('created_on', $this->created_on, true);
        $criteria->compare('created_by', $this->created_by, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => Yii::app()->params['pageSize'],
            ),
            'sort' => array('defaultOrder' => 'attendance_in DESC, teacher ASC')
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return AttendanceTeacher the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function getData($id, $field) {
        $model = AttendanceTeacher::model()->findByAttributes(array('id' => $id));
        if (empty($model->$field)) {
            return null;
        } else {
            return $model->$field;
        }
    }

    public static function teacherAttendanceCount($date) {
        $array = AttendanceTeacher::model()->findAll(array('condition' => 'institution=' . Yii::app()->user->institution . ' AND DATE_FORMAT(`attendance_in`, "%Y-%m-%d")=DATE_FORMAT("' . $date . '", "%Y-%m-%d")'));
        return count($array);
    }

}
