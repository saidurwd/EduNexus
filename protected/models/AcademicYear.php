<?php

/**
 * This is the model class for table "{{academic_year}}".
 *
 * The followings are the available columns in table '{{academic_year}}':
 * @property integer $id
 * @property integer $institution
 * @property string $year
 * @property string $title
 * @property string $starting_date
 * @property string $ending_date
 * @property string $default
 *
 * The followings are the available model relations:
 * @property Institution $institution0
 */
class AcademicYear extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{academic_year}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('institution, year, title, starting_date, ending_date', 'required'),
            array('institution', 'numerical', 'integerOnly' => true),
            array('year', 'length', 'max' => 4),
            array('title', 'length', 'max' => 50),
            array('default', 'length', 'max' => 3),
            array('year', 'UniqueAttributesValidator', 'with' => 'institution', 'message' => 'This year already exist.'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, institution, year, title, starting_date, ending_date, default', 'safe', 'on' => 'search'),
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
            'year' => 'Year',
            'title' => 'Year Title',
            'starting_date' => 'Starting Date',
            'ending_date' => 'Ending Date',
            'default' => 'Default',
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
//        $criteria->compare('institution', $this->institution);
        $criteria->compare('institution', Yii::app()->user->institution);
        $criteria->compare('year', $this->year, true);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('starting_date', $this->starting_date, true);
        $criteria->compare('ending_date', $this->ending_date, true);
        $criteria->compare('default', $this->default, true);

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
     * @return AcademicYear the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function getData($id, $field) {
        $model = AcademicYear::model()->findByAttributes(array('id' => $id));
        if (empty($model->$field)) {
            return null;
        } else {
            return $model->$field;
        }
    }

    public static function getAcademicYearReportAdmin($field, $id, $cssClass = 'select2') {
        $parent1 = AcademicYear::model()->findAll(array('condition' => '', 'order' => '`default` DESC'));
        $option = '<select id="' . $field . '" name="' . $field . '" class="' . $cssClass . '">';
        $option .= '<option value="">Select Academic Year</option>';
        foreach ($parent1 as $key => $values) {
            if ($id == $values["id"]) {
                $option .= '<option selected="selected" value="' . $values["id"] . '" class="' . $values["institution"] . '">' . $values["title"] . '</option>';
            } else {
                $option .= '<option value="' . $values["id"] . '" class="' . $values["institution"] . '">' . $values["title"] . '</option>';
            }
        }
        $option .= '</select>';

        return $option;
    }

}
