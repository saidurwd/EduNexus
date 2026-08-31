<?php

/**
 * This is the model class for table "{{document}}".
 *
 * The followings are the available columns in table '{{document}}':
 * @property integer $id
 * @property integer $category
 * @property string $title
 * @property string $document_file
 * @property string $document_type
 * @property string $document_size
 * @property string $details
 * @property string $status
 * @property integer $created_by
 * @property string $created_on
 *
 * The followings are the available model relations:
 * @property DocumentCategory $category0
 */
class Document extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{document}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('institution, category, title', 'required'),
            array('institution, category, created_by', 'numerical', 'integerOnly' => true),
            array('title, document_file', 'length', 'max' => 255),
            array('document_type, document_size', 'length', 'max' => 100),
            array('status', 'length', 'max' => 8),
            array('document_file', 'file', 'types' => 'jpg,jpeg,gif,png,pdf,doc,docx,odt,rtf,tex,txt,ppt,pptx,txt,xlsx,xls,csv,zip,rar,7z,bzip2,gzip,tar,aif,iff,m3u,m4a,mid,mp3,mpa,ra,wav,wma,3g2,3gp,asf,asx,avi,flv,mov,mp4,mpg,rm,srt,swf,vob,wmv', 'allowEmpty' => true, 'minSize' => 2, 'maxSize' => 1024 * 1024 * 50, 'tooLarge' => 'The file was larger than 50MB. Please upload a smaller file.', 'wrongType' => 'File format was not supported.', 'tooSmall' => 'File size was too small or empty.'),
            array('details, created_on', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, institution, category, title, document_file, document_type, document_size, details, status, created_by, created_on', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'category0' => array(self::BELONGS_TO, 'DocumentCategory', 'category'),
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
            'document_file' => 'Document',
            'document_type' => 'Type',
            'document_size' => 'Size',
            'details' => 'Details',
            'status' => 'Status',
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
        $criteria->compare('t.document_file', $this->document_file, true);
        $criteria->compare('t.document_type', $this->document_type, true);
        $criteria->compare('t.document_size', $this->document_size, true);
        $criteria->compare('t.details', $this->details, true);
        $criteria->compare('t.status', $this->status, true);
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
     * @return Document the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function byteToMbyte($a_bytes) {
        if ($a_bytes < 1024) {
            return $a_bytes . ' B';
        } elseif ($a_bytes < 1048576) {
            return round($a_bytes / 1024, 2) . ' KiB';
        } elseif ($a_bytes < 1073741824) {
            return round($a_bytes / 1048576, 2) . ' MiB';
        } elseif ($a_bytes < 1099511627776) {
            return round($a_bytes / 1073741824, 2) . ' GiB';
        } elseif ($a_bytes < 1125899906842624) {
            return round($a_bytes / 1099511627776, 2) . ' TiB';
        } elseif ($a_bytes < 1152921504606846976) {
            return round($a_bytes / 1125899906842624, 2) . ' PiB';
        } elseif ($a_bytes < 1180591620717411303424) {
            return round($a_bytes / 1152921504606846976, 2) . ' EiB';
        } elseif ($a_bytes < 1208925819614629174706176) {
            return round($a_bytes / 1180591620717411303424, 2) . ' ZiB';
        } else {
            return round($a_bytes / 1208925819614629174706176, 2) . ' YiB';
        }
    }

    public static function getData($id, $field) {
        $model = Document::model()->findByAttributes(array('id' => $id));
        if (empty($model->$field)) {
            return null;
        } else {
            return $model->$field;
        }
    }

}
