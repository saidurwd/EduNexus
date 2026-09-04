<?php

class DashboardSnapshot extends CActiveRecord {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return '{{dashboard_snapshot}}';
    }

    public function rules() {
        return array(
            array('institution, metric_type, metric_key, recorded_date', 'required'),
            array('institution, academic_year', 'numerical', 'integerOnly' => true),
            array('metric_type, metric_key', 'length', 'max' => 50),
            array('metric_value', 'length', 'max' => 18),
            array('recorded_date, metric_value', 'safe'),
        );
    }

    public function relations() {
        return array();
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'institution' => 'Institution',
            'metric_type' => 'Metric Type',
            'metric_key' => 'Metric Key',
            'metric_value' => 'Metric Value',
            'recorded_date' => 'Recorded Date',
            'academic_year' => 'Academic Year',
        );
    }

    public function search() {
        $criteria = new CDbCriteria;
        $criteria->compare('id', $this->id);
        $criteria->compare('institution', $this->institution);
        $criteria->compare('metric_type', $this->metric_type, true);
        $criteria->compare('metric_key', $this->metric_key, true);
        $criteria->compare('recorded_date', $this->recorded_date, true);
        $criteria->compare('academic_year', $this->academic_year);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array('pageSize' => Yii::app()->params['pageSize']),
        ));
    }

    public static function getSnapshot($institutionId, $metricType, $metricKey, $date = null, $academicYearId = null) {
        if ($date === null) {
            $date = date('Y-m-d');
        }

        $criteria = new CDbCriteria;
        $criteria->condition = 'institution=:inst AND metric_type=:type AND metric_key=:key AND recorded_date=:date';
        $criteria->params = array(
            ':inst' => $institutionId,
            ':type' => $metricType,
            ':key' => $metricKey,
            ':date' => $date
        );

        if ($academicYearId !== null) {
            $criteria->condition .= ' AND academic_year=:year';
            $criteria->params[':year'] = $academicYearId;
        }

        $model = self::model()->find($criteria);
        return $model !== null ? $model->metric_value : null;
    }

    public static function saveSnapshot($institutionId, $metricType, $metricKey, $metricValue, $date = null, $academicYearId = null) {
        if ($date === null) {
            $date = date('Y-m-d');
        }

        $model = self::model()->findByAttributes(array(
            'institution' => $institutionId,
            'metric_type' => $metricType,
            'metric_key' => $metricKey,
            'recorded_date' => $date,
            'academic_year' => $academicYearId
        ));

        if ($model === null) {
            $model = new self;
            $model->institution = $institutionId;
            $model->metric_type = $metricType;
            $model->metric_key = $metricKey;
            $model->recorded_date = $date;
            $model->academic_year = $academicYearId;
        }

        $model->metric_value = $metricValue;
        $model->save(false);
    }
}
