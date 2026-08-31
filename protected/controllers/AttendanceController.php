<?php

class AttendanceController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

    protected function beforeAction($action) {
        $access = $this->checkAccess(Yii::app()->controller->id, Yii::app()->controller->action->id);
        if ($access == 1) {
            return true;
        } else {
            Yii::app()->user->setFlash('error', "You are not authorized to perform this action!");
            $this->redirect(array('/site/noaccess'));
        }
    }

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('*'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('admin', 'delete', 'create', 'update', 'download'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete'),
                'users' => array('admin'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $Attendance = new Attendance;
        $model = new Student;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($Attendance);
        
        if (isset($_POST['Attendance'])) {
            $total = count($_POST['Attendance']);
            if ($total <= 0) {
                Yii::app()->user->setFlash('error', 'No student found.');
                $this->redirect(array('admin'));
            }
            $dataExist = Attendance::studentAttendanceCount($_POST['Attendance']['attendance_in']);
            if ($dataExist > 0) {
                Yii::app()->user->setFlash('error', 'This date attendance already taken. Please try another.');
                $this->redirect(array('create'));
            }
            for ($i = 1; $i < $total; $i++) {
                $Attendance->attributes = $_POST['Attendance'][$i];
//                print_r($_POST['Attendance']); exit;
                $modelStudent = $this->loadModelStudent($Attendance->studentid);
                $Student = new Attendance;
                $Student->institution = Yii::app()->user->institution;
                $Student->student = $Attendance->studentid;
                $Student->class = $modelStudent->class;
                $Student->section = $modelStudent->section;
                $Student->group = $modelStudent->group;
                $Student->academic_year = $modelStudent->academic_year;
                $Student->sid = $modelStudent->sid;
                $Student->roll = $modelStudent->roll;
                $Student->attendance_in = $_POST['Attendance']['attendance_in'];
                $Student->attendance = $Attendance->attendance;
                $Student->created_on = new CDbExpression('NOW()');
                $Student->created_by = Yii::app()->user->id;
                $Student->save();
            }
            Yii::app()->user->setFlash('success', 'Student attendance was saved successfully');
            $this->redirect(array('admin'));
        }

        $this->render('create', array(
            'model' => $model,
            'Attendance' => $Attendance,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Attendance'])) {
            $model->attributes = $_POST['Attendance'];
            if ($model->save()) {
                Yii::app()->user->setFlash('success', 'Data was saved successfully');
                $this->redirect(array('admin'));
            }
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('Attendance');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Attendance('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Attendance']))
            $model->attributes = $_GET['Attendance'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Attendance the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Attendance::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    public function loadModelStudent($id) {
        $model = Student::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Attendance $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'attendance-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
