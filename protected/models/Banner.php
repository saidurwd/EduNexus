<?php

/**
 * This is the model class for table "{{banner}}".
 *
 * The followings are the available columns in table '{{banner}}':
 * @property integer $id
 * @property integer $category
 * @property string $title
 * @property string $banner
 * @property string $clickurl
 * @property string $details
 * @property string $status
 * @property string $sticky
 * @property integer $ordering
 * @property integer $created_by
 * @property string $created_on
 *
 * The followings are the available model relations:
 * @property BannerCategory $category0
 */
class Banner extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{banner}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('institution, category, title', 'required'),
            array('institution, category, ordering, created_by', 'numerical', 'integerOnly' => true),
            array('title, banner, clickurl', 'length', 'max' => 255),
            array('status', 'length', 'max' => 8),
            array('sticky', 'length', 'max' => 3),
            array('banner', 'file', 'types' => 'jpg,jpeg,gif,png', 'allowEmpty' => true, 'minSize' => 2, 'maxSize' => 1024 * 1024 * 5, 'tooLarge' => 'The file was larger than 5MB. Please upload a smaller file.', 'wrongType' => 'File format was not supported.', 'tooSmall' => 'File size was too small or empty.'),
            array('details, created_on', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, institution, category, title, banner, clickurl, details, status, sticky, ordering, created_by, created_on', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'category0' => array(self::BELONGS_TO, 'BannerCategory', 'category'),
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
            'banner' => 'Banner',
            'clickurl' => 'Click URL',
            'details' => 'Details',
            'status' => 'Status',
            'sticky' => 'Sticky',
            'ordering' => 'Ordering',
            'created_by' => 'Created By',
            'created_on' => 'Created On',
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

        $criteria->compare('t.id', $this->id);        
        $criteria->compare('t.institution', Yii::app()->user->institution);
        $criteria->compare('t.category', $this->category);
        $criteria->compare('t.title', $this->title, true);
        $criteria->compare('t.banner', $this->banner, true);
        $criteria->compare('t.clickurl', $this->clickurl, true);
        $criteria->compare('t.details', $this->details, true);
        $criteria->compare('t.status', $this->status, true);
        $criteria->compare('t.sticky', $this->sticky, true);
        $criteria->compare('t.ordering', $this->ordering);
        $criteria->compare('t.created_by', $this->created_by);
        $criteria->compare('t.created_on', $this->created_on, true);
        $criteria->with = array('category0');
        $criteria->compare('category0.title', $this->category, true);

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
     * @return Banner the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function getData($id, $field) {
        $model = Banner::model()->findByAttributes(array('id' => $id));
        if (empty($model->$field)) {
            return null;
        } else {
            return $model->$field;
        }
    }
    
}
