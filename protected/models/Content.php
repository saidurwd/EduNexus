<?php

/**
 * This is the model class for table "{{content}}".
 *
 * The followings are the available columns in table '{{content}}':
 * @property integer $id
 * @property string $title
 * @property string $details
 * @property integer $category
 * @property string $image
 * @property string $featured
 * @property integer $ordering
 * @property string $status
 * @property string $metakey
 * @property string $metadesc
 * @property integer $hits
 * @property integer $created_by
 * @property string $created_on
 *
 * The followings are the available model relations:
 * @property Category $category0
 */
class Content extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{content}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('institution, title, category, created_on', 'required'),
            array('institution, category, ordering, hits, created_by', 'numerical', 'integerOnly' => true),
            array('title', 'length', 'max' => 255),
            array('image', 'length', 'max' => 250),
            array('featured', 'length', 'max' => 3),
            array('status', 'length', 'max' => 8),
            array('image', 'file', 'types' => 'jpg,jpeg,gif,png', 'allowEmpty' => true, 'minSize' => 2, 'maxSize' => 1024 * 1024 * 5, 'tooLarge' => 'The file was larger than 5MB. Please upload a smaller file.', 'wrongType' => 'File format was not supported.', 'tooSmall' => 'File size was too small or empty.'),
            array('details, metakey, metadesc', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, institution, title, details, category, image, featured, ordering, status, metakey, metadesc, hits, created_by, created_on', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'category0' => array(self::BELONGS_TO, 'Category', 'category'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'institution' => 'Institution',
            'title' => 'Title',
            'details' => 'Details',
            'category' => 'Category',
            'image' => 'Image',
            'featured' => 'Featured',
            'ordering' => 'Ordering',
            'status' => 'Status',
            'metakey' => 'Meta Key',
            'metadesc' => 'Meta Description',
            'hits' => 'Hits',
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
        $criteria->compare('t.title', $this->title, true);
        $criteria->compare('t.details', $this->details, true);
        $criteria->compare('t.category', $this->category);
        $criteria->compare('t.image', $this->image, true);
        $criteria->compare('t.featured', $this->featured, true);
        $criteria->compare('t.ordering', $this->ordering);
        $criteria->compare('t.status', $this->status, true);
        $criteria->compare('t.metakey', $this->metakey, true);
        $criteria->compare('t.metadesc', $this->metadesc, true);
        $criteria->compare('t.hits', $this->hits);
        $criteria->compare('t.created_by', $this->created_by);
        $criteria->compare('t.created_on', $this->created_on, true);
        $criteria->with = array('category0');
        $criteria->compare('category0.title', $this->category, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => Yii::app()->params['pageSize'],
            ),
            'sort' => array('defaultOrder' => 'ordering DESC')
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Content the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function getData($id, $field) {
        $model = Content::model()->findByAttributes(array('id' => $id));
        if (empty($model->$field)) {
            return null;
        } else {
            return $model->$field;
        }
    }

    /**
     * Limit the number of characters in a string.
     *
     * @param  string  $value
     * @param  int     $limit
     * @param  string  $end
     * @return string
     */
    public static function limit($value, $limit = 100, $end = '...') {
        if (mb_strwidth($value, 'UTF-8') <= $limit) {
            return $value;
        }

        return rtrim(mb_strimwidth($value, 0, $limit, '', 'UTF-8')) . $end;
    }

    /**
     * Limit the number of words in a string.
     *
     * @param  string  $value
     * @param  int     $words
     * @param  string  $end
     * @return string
     */
    public static function words($value, $words = 100, $end = '...') {
        preg_match('/^\s*+(?:\S++\s*+){1,' . $words . '}/u', $value, $matches);

        if (!isset($matches[0]) || static::length($value) === static::length($matches[0])) {
            return $value;
        }

        return rtrim($matches[0]) . $end;
    }

    /**
     * Generate a more truly "random" alpha-numeric string.
     *
     * @param  int  $length
     * @return string
     */
    public static function random($length = 16) {
        $string = '';

        while (($len = strlen($string)) < $length) {
            $size = $length - $len;

            $bytes = random_bytes($size);

            $string .= substr(str_replace(['/', '+', '='], '', base64_encode($bytes)), 0, $size);
        }

        return $string;
    }

}
