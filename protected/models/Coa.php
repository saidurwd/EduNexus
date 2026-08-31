<?php

/**
 * This is the model class for table "{{coa}}".
 *
 * The followings are the available columns in table '{{coa}}':
 * @property integer $id
 * @property integer $institution
 * @property integer $parent
 * @property string $account_code
 * @property string $account_title
 * @property string $status
 *
 * The followings are the available model relations:
 * @property Institution $institution0
 * @property Expense[] $expenses
 * @property Income[] $incomes
 */
class Coa extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{coa}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('institution, account_code, account_title', 'required'),
            array('institution, parent', 'numerical', 'integerOnly' => true),
            array('account_code', 'length', 'max' => 100),
            array('account_title, path', 'length', 'max' => 250),
            array('status', 'length', 'max' => 8),
            array('account_code', 'UniqueAttributesValidator', 'with' => 'institution', 'message' => 'This account code already exist.'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, institution, parent, account_code, account_title, path, status', 'safe', 'on' => 'search'),
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
            'expenses' => array(self::HAS_MANY, 'Expense', 'coa'),
            'incomes' => array(self::HAS_MANY, 'Income', 'coa'),
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
            'account_code' => 'Account Code',
            'account_title' => 'Account Title',
            'path' => 'Path',
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
        $criteria->compare('parent', $this->parent);
        $criteria->compare('account_code', $this->account_code, true);
        $criteria->compare('account_title', $this->account_title, true);
        $criteria->compare('path', $this->path, true);
        $criteria->compare('status', $this->status, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => Yii::app()->params['pageSize'],
            ),
            'sort' => array('defaultOrder' => 'path ASC')
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Coa the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function getData($id, $field) {
        $model = Coa::model()->findByAttributes(array('id' => $id));
        if (empty($model->$field)) {
            return null;
        } else {
            return $model->$field;
        }
    }

    public static function getCOASearch($id) {
        $parent1 = Coa::model()->findAll(array('condition' => 'parent=0 OR parent IS NULL', 'order' => 'account_title'));
        $option = '<select id="Coa_parent" name="Coa[parent]" class="form-control">';
        $option .= '<option value="">All</option>';
        foreach ($parent1 as $key => $values1) {
            if ($id == $values1["id"]) {
                $option .= '<option selected="selected" value="' . $values1["id"] . '">' . $values1["account_title"] . '</option>';
            } else {
                $option .= '<option value="' . $values1["id"] . '">' . $values1["account_title"] . '</option>';
            }
            $parent2 = Coa::model()->findAll(array('condition' => 'parent=' . (int) $values1["id"], 'order' => 'account_title'));
            foreach ($parent2 as $key => $values2) {
                if ($id == $values2["id"]) {
                    $option .= '<option selected="selected" value="' . $values2["id"] . '" class="text-success">&nbsp;&nbsp;' . $values2["account_title"] . '</option>';
                } else {
                    $option .= '<option value="' . $values2["id"] . '" class="text-success">&nbsp;&nbsp;' . $values2["account_title"] . '</option>';
                }
            }
        }
        $option .= '</select>';

        return $option;
    }

    public static function getCOAForm($model, $field, $id) {
        $parent1 = Coa::model()->findAll(array('condition' => 'parent=0 OR parent IS NULL', "order" => "account_title"));
        $option = '<select id="' . $model . '_' . $field . '" name="' . $model . '[' . $field . ']" class="select2">';
        $option .= '<option value="">Select a COA</option>';
        foreach ($parent1 as $key => $values1) {
            if ($id == $values1["id"]) {
                $option .= '<option selected="selected" value="' . $values1["id"] . '">' . $values1["account_title"] . '</option>';
            } else {
                $option .= '<option value="' . $values1["id"] . '">' . $values1["account_title"] . '</option>';
            }
            $parent2 = Coa::model()->findAll(array('condition' => 'parent=' . (int) $values1["id"], 'order' => 'account_title'));
            foreach ($parent2 as $key => $values2) {
                if ($id == $values2["id"]) {
                    $option .= '<option selected="selected" value="' . $values2["id"] . '" class="text-success space-left-30">' . $values2["account_title"] . '</option>';
                } else {
                    $option .= '<option value="' . $values2["id"] . '" class="text-success space-left-30">' . $values2["account_title"] . '</option>';
                }
            }
        }
        $option .= '</select>';

        return $option;
    }

    public static function update_path($id) {
        $model = Coa::model()->findByPk($id);
        if ($model->parent == 0 || $model->parent === null) {
            $model->path = '0.' . $model->id;
            $model->save();
        } else {
            $parent = Coa::model()->findByAttributes(array('id' => $model->parent));
            $model->path = $parent->path . '.' . $model->id;
            $model->save();
        }
    }

    public static function get_full_path($id) {
        $model = Coa::model()->findByPk($id);
        $array = explode('.', @$model->path);
        $total = count($array);
        $data = null;
        $i = 1;
        foreach ($array as $key => $value) {
            if ($value > 0) {
                if ($total != $i) {
                    $data .= Coa::getData($value, 'account_title') . ' <i class="fa fa-angle-double-right text-info"></i> ';
                } else {
                    $data .= Coa::getData($value, 'account_title');
                }
            }
            $i++;
        }
        return $data;
    }

}
