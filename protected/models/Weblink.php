<?php

/**
 * This is the model class for table "{{weblink}}".
 *
 * The followings are the available columns in table '{{weblink}}':
 * @property integer $id
 * @property integer $institution
 * @property integer $category
 * @property string $title
 * @property string $details
 * @property string $click_url
 * @property string $picture
 * @property string $status
 * @property string $created_on
 * @property integer $created_by
 *
 * The followings are the available model relations:
 * @property Institution $institution0
 * @property WeblinkCategory $category0
 */
class Weblink extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{weblink}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('institution, category, title, click_url', 'required'),
            array('institution, category, created_by', 'numerical', 'integerOnly' => true),
            array('title', 'length', 'max' => 255),
            array('click_url, picture', 'length', 'max' => 250),
            array('status', 'length', 'max' => 8),
            array('details, created_on', 'safe'),
            array('picture', 'file', 'types' => 'jpg,jpeg,gif,png', 'allowEmpty' => true, 'minSize' => 2, 'maxSize' => 1024 * 1024 * 5, 'tooLarge' => 'The file was larger than 5MB. Please upload a smaller file.', 'wrongType' => 'File format was not supported.', 'tooSmall' => 'File size was too small or empty.'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, institution, category, title, details, click_url, picture, status, created_on, created_by', 'safe', 'on' => 'search'),
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
            'category0' => array(self::BELONGS_TO, 'WeblinkCategory', 'category'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'institution' => 'Institution',
            'category' => 'Category',
            'title' => 'Title',
            'details' => 'Details',
            'click_url' => 'URL',
            'picture' => 'Picture',
            'status' => 'Status',
            'created_on' => 'Created By',
            'created_by' => 'Created On',
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
        $criteria->addInCondition('institution', array(0, Yii::app()->user->institution));
        $criteria->compare('category', $this->category);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('details', $this->details, true);
        $criteria->compare('click_url', $this->click_url, true);
        $criteria->compare('picture', $this->picture, true);
        $criteria->compare('status', $this->status, true);
        $criteria->compare('created_on', $this->created_on, true);
        $criteria->compare('created_by', $this->created_by);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => Yii::app()->params['pageSize'],
            ),
            'sort' => array('defaultOrder' => 'title')
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Weblink the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function getData($id, $field) {
        $model = Weblink::model()->findByAttributes(array('id' => $id));
        if (empty($model->$field)) {
            return null;
        } else {
            return $model->$field;
        }
    }

}
