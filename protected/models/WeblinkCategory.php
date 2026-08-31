<?php

/**
 * This is the model class for table "{{weblink_category}}".
 *
 * The followings are the available columns in table '{{weblink_category}}':
 * @property integer $id
 * @property integer $institution
 * @property integer $parent
 * @property string $title
 * @property string $details
 * @property string $status
 * @property integer $created_by
 * @property string $created_on
 *
 * The followings are the available model relations:
 * @property Weblink[] $weblinks
 */
class WeblinkCategory extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{weblink_category}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('institution, title, created_by, created_on', 'required'),
            array('institution, parent, created_by', 'numerical', 'integerOnly' => true),
            array('title, path', 'length', 'max' => 255),
            array('deletable, status', 'length', 'max' => 8),
            array('details', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, institution, parent, title, details, path, deletable, status, created_by, created_on', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'weblinks' => array(self::HAS_MANY, 'Weblink', 'category'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'institution' => 'Institution',
            'parent' => 'Parent',
            'title' => 'Category Name',
            'details' => 'Details',
            'path' => 'Path',
            'deletable' => 'Deletable',
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

        $criteria->compare('id', $this->id);
        $criteria->addInCondition('institution', array(0, Yii::app()->user->institution));
        $criteria->compare('parent', $this->parent);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('details', $this->details, true);
        $criteria->compare('path', $this->path, true);
        $criteria->compare('deletable', $this->deletable);
        $criteria->compare('status', $this->status, true);
        $criteria->compare('created_by', $this->created_by);
        $criteria->compare('created_on', $this->created_on, true);

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
     * @return WeblinkCategory the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function update_path($id) {
        $model = WeblinkCategory::model()->findByPk($id);
        if ($model->parent == 0 || $model->parent === null) {
            $model->path = '0.' . $model->id;
            $model->save();
        } else {
            $parent = WeblinkCategory::model()->findByAttributes(array('id' => $model->parent));
            $model->path = $parent->path . '.' . $model->id;
            $model->save();
        }
    }

    public static function get_full_path($id) {
        $model = WeblinkCategory::model()->findByPk($id);
        $array = explode('.', $model->path);
        $total = count($array);
        $data = null;
        $i = 1;
        foreach ($array as $key => $value) {
            if ($value > 0) {
                if ($total != $i) {
                    $data .= WeblinkCategory::getData($value, 'title') . ' <i class="fa fa-angle-double-right text-info"></i> ';
                } else {
                    $data .= WeblinkCategory::getData($value, 'title');
                }
            }
            $i++;
        }
        return $data;
    }

    public static function getCategory($model, $field, $id) {
        $parent1 = WeblinkCategory::model()->findAll(array('condition' => '(parent=0 OR parent IS NULL) AND (institution=0 OR institution=' . Yii::app()->user->institution . ')', 'order' => "title"));
        $option = '<select id="' . $model . '_' . $field . '" name="' . $model . '[' . $field . ']" class="select2">';
        $option .= '<option value="">Select a Category</option>';
        foreach ($parent1 as $key => $values1) {
            $option .= '<optgroup label="' . $values1["title"] . '">';
            $parent2 = WeblinkCategory::model()->findAll(array('condition' => 'parent=' . (int) $values1["id"], 'order' => 'title'));
            foreach ($parent2 as $key => $values2) {
                if ($id == $values2["id"]) {
                    $option .= '<option selected="selected" value="' . $values2["id"] . '">' . $values2["title"] . '</option>';
                } else {
                    $option .= '<option value="' . $values2["id"] . '">' . $values2["title"] . '</option>';
                }
            }
            $option .= '</optgroup>';
        }
        $option .= '</select>';

        return $option;
    }

    public static function getCategorySearch($id) {
        $parent1 = WeblinkCategory::model()->findAll(array('condition' => '(parent=0 OR parent IS NULL) AND (institution=0 OR institution=' . Yii::app()->user->institution . ')', 'order' => 'title'));
        $option = '<select id="category" name="category" class="select2">';
        $option .= '<option value="">All Categories</option>';
        foreach ($parent1 as $key => $values1) {
            if ($id == $values1["id"]) {
                $option .= '<option selected="selected" value="' . $values1["id"] . '">' . $values1["title"] . '</option>';
            } else {
                $option .= '<option value="' . $values1["id"] . '">' . $values1["title"] . '</option>';
            }
            $parent2 = WeblinkCategory::model()->findAll(array('condition' => 'parent=' . (int) $values1["id"], 'order' => 'title'));
            foreach ($parent2 as $key => $values2) {
                if ($id == $values2["id"]) {
                    $option .= '<option selected="selected" value="' . $values2["id"] . '" class="text-success">&nbsp;&nbsp;' . $values2["title"] . '</option>';
                } else {
                    $option .= '<option value="' . $values2["id"] . '" class="text-success">&nbsp;&nbsp;' . $values2["title"] . '</option>';
                }
            }
        }
        $option .= '</select>';

        return $option;
    }

    public static function getCategoryForm($model, $field, $id) {
        $parent1 = WeblinkCategory::model()->findAll(array('condition' => '(parent=0 OR parent IS NULL) AND (institution=0 OR institution=' . Yii::app()->user->institution . ')', "order" => "title"));
        $option = '<select id="' . $model . '_' . $field . '" name="' . $model . '[' . $field . ']" class="select2">';
        $option .= '<option value="">Select a Category</option>';
        foreach ($parent1 as $key => $values1) {
            if ($id == $values1["id"]) {
                $option .= '<option selected="selected" value="' . $values1["id"] . '">' . $values1["title"] . '</option>';
            } else {
                $option .= '<option value="' . $values1["id"] . '">' . $values1["title"] . '</option>';
            }
            $parent2 = WeblinkCategory::model()->findAll(array('condition' => 'parent=' . (int) $values1["id"], 'order' => 'title'));
            foreach ($parent2 as $key => $values2) {
                if ($id == $values2["id"]) {
                    $option .= '<option selected="selected" value="' . $values2["id"] . '" class="text-success space-left-30">' . $values2["title"] . '</option>';
                } else {
                    $option .= '<option value="' . $values2["id"] . '" class="text-success space-left-30">' . $values2["title"] . '</option>';
                }
                $parent3 = WeblinkCategory::model()->findAll(array('condition' => 'parent=' . (int) $values2["id"], 'order' => 'path'));
                foreach ($parent3 as $key => $values3) {
                    if ($id == $values3["id"]) {
                        $option .= '<option selected="selected" value="' . $values3["id"] . '" class="text-success space-left-60">' . $values3["title"] . '</option>';
                    } else {
                        $option .= '<option value="' . $values3["id"] . '" class="text-success space-left-60">' . $values3["title"] . '</option>';
                    }
                    $parent4 = WeblinkCategory::model()->findAll(array('condition' => 'parent=' . (int) $values3["id"], 'order' => 'path'));
                    foreach ($parent4 as $key => $values4) {
                        if ($id == $values4["id"]) {
                            $option .= '<option selected="selected" value="' . $values4["id"] . '" class="text-success space-left-90">' . $values4["title"] . '</option>';
                        } else {
                            $option .= '<option value="' . $values4["id"] . '" class="text-success space-left-90">' . $values4["title"] . '</option>';
                        }
                    }
                }
            }
        }
        $option .= '</select>';

        return $option;
    }

    public static function getData($id, $field) {
        $model = WeblinkCategory::model()->findByAttributes(array('id' => $id));
        if (empty($model->$field)) {
            return null;
        } else {
            return $model->$field;
        }
    }

}
