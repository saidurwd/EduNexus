<?php

class DashboardController extends Controller {

    public $layout = '//layouts/column2';

    public function filters() {
        return array(
            'accessControl',
            'postOnly + delete',
        );
    }

    public function accessRules() {
        return array(
            array('allow',
                'actions' => array('index', 'widgetData', 'exportPdf'),
                'users' => array('@'),
            ),
            array('deny', 'users' => array('*')),
        );
    }

    public function actionIndex() {
        $institutionId = Yii::app()->user->institution;
        $academicYear = $this->getDefaultAcademicYear($institutionId);
        
        $academicYears = AcademicYear::model()->findAll(array(
            'condition' => 'institution=:inst',
            'params' => array(':inst' => $institutionId),
            'order' => '`default` DESC, year DESC',
            'limit' => 10
        ));
        
        $data = DashboardData::getInstitutionStats($institutionId, $academicYear);
        $institution = Institution::model()->findByPk($institutionId);
        
        Yii::app()->clientScript->registerScriptFile(
            Yii::app()->theme->baseUrl . '/highchart404/highcharts.js',
            CClientScript::POS_END
        );
        Yii::app()->clientScript->registerScriptFile(
            Yii::app()->theme->baseUrl . '/highchart404/highcharts-more.js',
            CClientScript::POS_END
        );
        
        $this->render('index', array(
            'data' => $data,
            'academicYear' => $academicYear,
            'academicYears' => $academicYears,
            'institution' => $institution,
        ));
    }

    public function actionWidgetData() {
        if (!Yii::app()->request->isAjaxRequest) {
            throw new CHttpException(400, 'Invalid request');
        }

        $widget = Yii::app()->request->getParam('widget');
        $institutionId = Yii::app()->user->institution;
        $academicYear = Yii::app()->request->getParam('academic_year');
        $days = Yii::app()->request->getParam('days', 7);
        $startDate = Yii::app()->request->getParam('start_date');
        $endDate = Yii::app()->request->getParam('end_date');

        $data = DashboardData::getWidgetData($widget, $institutionId, $academicYear, $days, $startDate, $endDate);
        
        echo CJSON::encode($data);
        Yii::app()->end();
    }

    public function actionExportPdf() {
        $institutionId = Yii::app()->user->institution;
        $academicYear = $this->getDefaultAcademicYear($institutionId);
        $data = DashboardData::getInstitutionStats($institutionId, $academicYear);
        $institution = Institution::model()->findByPk($institutionId);
        
        Yii::app()->layout = 'print';
        $this->pageTitle = 'Dashboard Report - ' . $institution->institution;
        
        $this->render('export_pdf', array(
            'data' => $data,
            'academicYear' => $academicYear,
            'institution' => $institution,
        ));
    }

    private function getDefaultAcademicYear($institutionId) {
        $model = AcademicYear::model()->findByAttributes(array(
            'institution' => $institutionId,
            'default' => 'Yes'
        ));
        
        if ($model === null) {
            $model = AcademicYear::model()->findByAttributes(array(
                'institution' => $institutionId
            ));
        }
        
        if ($model !== null) {
            return $model->id;
        }
        
        return null;
    }
}
