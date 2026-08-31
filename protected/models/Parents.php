<?php

/**
 * This is the model class for table "{{parent}}".
 *
 * The followings are the available columns in table '{{parent}}':
 * @property integer $id
 * @property integer $institution
 * @property string $guardian_name
 * @property string $father
 * @property string $mother
 * @property string $father_profession
 * @property string $mother_profession
 * @property string $email
 * @property string $phone
 * @property string $address
 * @property string $photo
 * @property string $status
 *
 * The followings are the available model relations:
 * @property Institution $institution0
 * @property Student[] $students
 */
class Parents extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{parent}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('institution, guardian_name', 'required'),
            array('institution', 'numerical', 'integerOnly' => true),
            array('guardian_name, father, mother, father_profession, mother_profession, email', 'length', 'max' => 150),
            array('address, photo', 'length', 'max' => 250),
            array('status', 'length', 'max' => 8),
            array('phone', 'length', 'max' => 10),
            array('photo', 'file', 'types' => 'jpg,jpeg,gif,png', 'allowEmpty' => true, 'minSize' => 2, 'maxSize' => 1024 * 1024 * 1, 'tooLarge' => 'The file was larger than 1MB. Please upload a smaller file.', 'wrongType' => 'File format was not supported.', 'tooSmall' => 'File size was too small or empty.'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, institution, guardian_name, father, mother, father_profession, mother_profession, email, phone, address, photo, status', 'safe', 'on' => 'search'),
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
            'students' => array(self::HAS_MANY, 'Student', 'guardian'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'institution' => 'Institution',
            'guardian_name' => 'Guardian Name',
            'father' => 'Father\'s Name',
            'mother' => 'Mother\'s Name',
            'father_profession' => 'Father\'s Profession',
            'mother_profession' => 'Mother\'s Profession',
            'email' => 'Email',
            'phone' => 'Phone',
            'address' => 'Address',
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
        $criteria->compare('guardian_name', $this->guardian_name, true);
        $criteria->compare('father', $this->father, true);
        $criteria->compare('mother', $this->mother, true);
        $criteria->compare('father_profession', $this->father_profession, true);
        $criteria->compare('mother_profession', $this->mother_profession, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('phone', $this->phone, true);
        $criteria->compare('address', $this->address, true);
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
     * @return Parents the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function getData($id, $field) {
        $model = Parents::model()->findByAttributes(array('id' => $id));
        if (empty($model->$field)) {
            return null;
        } else {
            return $model->$field;
        }
    }

    public static function getPhoto($id) {
        $value = Parents::model()->findByAttributes(array('id' => $id));
        $filePath = Yii::app()->basePath . '/../uploads/parents/' . Yii::app()->user->institution . '/' . $value->photo;
        if ((is_file($filePath)) && (file_exists($filePath))) {
            return CHtml::image(Yii::app()->baseUrl . '/uploads/parents/' . Yii::app()->user->institution . '/' . $value->photo, 'Photo', array('alt' => 'Photo', 'class' => 'img-responsive', 'title' => ''));
        } else {
            return CHtml::image(Yii::app()->baseUrl . '/uploads/parents/default.png', 'Photo', array('alt' => 'Photo', 'class' => 'img-responsive', 'title' => ''));
        }
    }

}
