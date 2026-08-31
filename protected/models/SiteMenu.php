<?php

/**
 * This is the model class for table "{{site_menu}}".
 *
 * The followings are the available columns in table '{{site_menu}}':
 * @property integer $id
 * @property string $parent
 * @property string $title
 * @property string $component
 * @property string $action
 * @property integer $identity
 * @property integer $ordering
 * @property integer $status
 */
class SiteMenu extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{site_menu}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('institution, title, component, action, identity', 'required'),
            array('institution, identity, ordering, status', 'numerical', 'integerOnly' => true),
            array('parent', 'length', 'max' => 10),
            array('title', 'length', 'max' => 150),
            array('component, action, menu_class', 'length', 'max' => 100),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, institution, parent, title, component, action, identity, ordering, menu_class, status', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
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
            'title' => 'Menu Name',
            'component' => 'Component',
            'action' => 'Action',
            'identity' => 'Identity',
            'ordering' => 'Ordering',
            'menu_class' => 'Menu Class',
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
        $criteria->compare('parent', $this->parent, true);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('component', $this->component, true);
        $criteria->compare('action', $this->action, true);
        $criteria->compare('identity', $this->identity);
        $criteria->compare('ordering', $this->ordering);
        $criteria->compare('menu_class', $this->menu_class, true);
        $criteria->compare('status', $this->status);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => Yii::app()->params['pageSize20'],
            ),
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return SiteMenu the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function get_category_new($model, $field) {
        $parent1 = Yii::app()->db->createCommand()
                ->select('id,parent,title')
                ->from('{{site_menu}}')
                ->where('(parent=0 OR parent IS NULL) AND status=1 AND institution=' . Yii::app()->user->institution)
                ->order('ordering')
                ->queryAll();
        $option = '<select id="' . $model . '_' . $field . '" name="' . $model . '[' . $field . ']" class="select2">';
        $option .= '<option value="">Select a Parent</option>';
        foreach ($parent1 as $key => $values1) {
            $option .= '<option value="' . $values1["id"] . '" class="text-primary">&Hopf; ' . $values1["title"] . '</option>';
            $parent2 = Yii::app()->db->createCommand()
                    ->select('id,parent,title')
                    ->from('{{site_menu}}')
                    ->where('parent=' . $values1["id"] . ' AND status=1 AND institution=' . Yii::app()->user->institution)
                    ->order('ordering')
                    ->queryAll();
            foreach ($parent2 as $key => $values2) {
                $option .= '<option value="' . $values2["id"] . '" class="text-success">&rAarr; ' . $values2["title"] . '</option>';
                $parent3 = Yii::app()->db->createCommand()
                        ->select('id,parent,title')
                        ->from('{{site_menu}}')
                        ->where('parent=' . $values2["id"] . ' AND status=1 AND institution=' . Yii::app()->user->institution)
                        ->order('ordering')
                        ->queryAll();
                foreach ($parent3 as $key => $values3) {
                    $option .= '<option value="' . $values3["id"] . '" class="text-danger">&DoubleRightArrow; ' . $values3["title"] . '</option>';
                    $parent4 = Yii::app()->db->createCommand()
                            ->select('id,parent,title')
                            ->from('{{site_menu}}')
                            ->where('parent=' . $values3["id"] . ' AND status=1 AND institution=' . Yii::app()->user->institution)
                            ->order('ordering')
                            ->queryAll();
                    foreach ($parent4 as $key => $values4) {
                        $option .= '<option value="' . $values4["id"] . '" class="text-warning">&srarr; ' . $values4["title"] . '</option>';
                    }
                }
            }
        }
        $option .= '</select>';

        return $option;
    }

    public static function get_category_update($model, $field, $id) {
        $parent1 = Yii::app()->db->createCommand()
                ->select('id,parent,title')
                ->from('{{site_menu}}')
                ->where('(parent=0 OR parent IS NULL) AND status=1 AND institution=' . Yii::app()->user->institution)
                ->order('ordering')
                ->queryAll();
        $option = '<select id="' . $model . '_' . $field . '" name="' . $model . '[' . $field . ']" class="select2">';
        $option .= '<option value="">Select a Parent</option>';
        foreach ($parent1 as $key => $values1) {
            if ($id == $values1["id"]) {
                $option .= '<option selected="selected" value="' . $values1["id"] . '" class="text-primary">&Hopf; ' . $values1["title"] . '</option>';
            } else {
                $option .= '<option value="' . $values1["id"] . '" class="text-primary">&Hopf; ' . $values1["title"] . '</option>';
            }
            $parent2 = Yii::app()->db->createCommand()
                    ->select('id,parent,title,ordering')
                    ->from('{{site_menu}}')
                    ->where('parent=' . $values1["id"] . ' AND status=1 AND institution=' . Yii::app()->user->institution)
                    ->order('ordering')
                    ->queryAll();
            foreach ($parent2 as $key => $values2) {
                if ($id == $values2["id"]) {
                    $option .= '<option selected="selected" value="' . $values2["id"] . '" class="text-success">&rAarr; ' . $values2["title"] . '</option>';
                } else {
                    $option .= '<option value="' . $values2["id"] . '" class="text-success">&rAarr; ' . $values2["title"] . '</option>';
                }
                $parent3 = Yii::app()->db->createCommand()
                        ->select('id,parent,title')
                        ->from('{{site_menu}}')
                        ->where('parent=' . $values2["id"] . ' AND status=1 AND institution=' . Yii::app()->user->institution)
                        ->order('ordering')
                        ->queryAll();
                foreach ($parent3 as $key => $values3) {
                    if ($id == $values3["id"]) {
                        $option .= '<option selected="selected" value="' . $values3["id"] . '" class="text-danger">&DoubleRightArrow; ' . $values3["title"] . '</option>';
                    } else {
                        $option .= '<option value="' . $values3["id"] . '" class="text-danger">&DoubleRightArrow; ' . $values3["title"] . '</option>';
                    }
                    $parent4 = Yii::app()->db->createCommand()
                            ->select('id,parent,title')
                            ->from('{{site_menu}}')
                            ->where('parent=' . $values3["id"] . ' AND status=1 AND institution=' . Yii::app()->user->institution)
                            ->order('ordering')
                            ->queryAll();
                    foreach ($parent4 as $key => $values4) {
                        if ($id == $values4["id"]) {
                            $option .= '<option selected="selected" value="' . $values4["id"] . '" class="text-warning">&srarr; ' . $values4["title"] . '</option>';
                        } else {
                            $option .= '<option value="' . $values4["id"] . '" class="text-warning">&srarr; ' . $values4["title"] . '</option>';
                        }
                    }
                }
            }
        }
        $option .= '</select>';

        return $option;
    }

    public static function getData($id, $field) {
        $value = SiteMenu::model()->findByAttributes(array('id' => $id));
        if (empty($value->$field)) {
            return null;
        } else {
            return $value->$field;
        }
    }

    public static function get_site_menu_count($parent) {
        $array = SiteMenu::model()->findAll(array('condition' => 'status=1 AND parent=' . $parent));
        return count($array);
    }

    public static function get_site_menu() {
        $array = SiteMenu::model()->findAll(array('condition' => 'status=1 AND institution=' . Yii::app()->user->institution, 'order' => 'ordering'));
        echo '<ul class="nav navbar-nav navbar-right">';
        foreach ($array as $key => $value) {
            $total = SiteMenu::get_site_menu_count($value['id']);
            if ($value['parent'] == 0 && $value['identity'] == 0 && $total == 0) {
                $link = $value['component'] . '/' . $value['action'];
                echo '<li class="' . $value['menu_class'] . '">' . CHtml::link($value['title'], array($link)) . '</li>';
            }
            if ($value['parent'] == 0 && $value['identity'] != 0 && $total == 0) {
                $link2 = $value['component'] . '/' . $value['action'];
                $link_id2 = $value['identity'];
                echo '<li>' . CHtml::link($value['title'], array($link2, 'id' => $link_id2)) . '</li>';
            }
            if ($value['parent'] == 0 && $value['identity'] == 0 && $total > 0) {
                echo '<li class="dropdown">' . CHtml::link($value['title'], '#', array('class' => 'dropdown-toggle', 'data-toggle' => 'dropdown', 'role' => 'button', 'aria-haspopup' => 'true', 'aria-expanded' => 'false',));
                echo '<ul class="dropdown-menu">';
                $array_dd = SiteMenu::model()->findAll(array('condition' => 'status=1 AND parent=' . $value['id'], 'order' => 'ordering'));
                foreach ($array_dd as $key => $valuedd) {
                    $link = $valuedd['component'] . '/' . $valuedd['action'];
                    $link_id = $valuedd['identity'];
                    echo '<li>' . CHtml::link($valuedd['title'], array($link, 'id' => $link_id)) . '</li>';
                }
                echo '</ul>';
                echo '</li>';
            }
        }
        echo '<ul class="nav navbar-nav navbar-right">';
    }

}
