<?php

class ClasssController extends Controller {

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
                'actions' => array('admin', 'delete', 'create', 'update'),
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
        $model = new Classs;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Classs'])) {
            $model->attributes = $_POST['Classs'];
            $model->institution = Yii::app()->user->institution;
            if ($model->save()) {
                //Create Default Shift
                $modelShift = new Shift;
                $modelShift->institution = Yii::app()->user->institution;
                $modelShift->class = $model->id;
                $modelShift->title = 'DAY';
                $modelShift->status = 'Active';
                $modelShift->save();
                //Create Default Section
                $modelSection = new Section;
                $modelSection->institution = Yii::app()->user->institution;
                $modelSection->section = 'A';
                $modelSection->category = 'Best';
                $modelSection->class = $model->id;
                $modelSection->shift = $modelShift->id;
                $modelSection->capacity = 100;
                $modelSection->status = 'Active';
                $modelSection->save();
                //Create default Student Groups
                Yii::app()->db->createCommand("INSERT INTO {{student_group}} (`institution`, `class`, `title`, `status`) VALUES (" . Yii::app()->user->institution . "," . $model->id . ", 'General', 'Active')")->execute();
                //Create default Grade
                Yii::app()->db->createCommand("INSERT INTO {{grade}} (`institution`, `class`, `grade_name`, `grade_point`, `mark_from`, `mark_upto`, `Note`) VALUES 
                                            (" . Yii::app()->user->institution . "," . $model->id . ", 'A+', '5.00', 80, 101, 'Excellent'),
                                            (" . Yii::app()->user->institution . "," . $model->id . ", 'A', '4.00', 70, 80, 'Well done'),
                                            (" . Yii::app()->user->institution . "," . $model->id . ", 'A-', '3.50', 60, 70, 'Not bad but need to focus more'),
                                            (" . Yii::app()->user->institution . "," . $model->id . ", 'B', '3.00', 50, 60, 'Average'),
                                            (" . Yii::app()->user->institution . "," . $model->id . ", 'C', '2.00', 40, 50, 'Average'),
                                            (" . Yii::app()->user->institution . "," . $model->id . ", 'D', '1.00', 33, 40, 'Bad'),
                                            (" . Yii::app()->user->institution . "," . $model->id . ", 'F', '0.00', 0, 33, 'Vey Bad')")->execute();

                Yii::app()->user->setFlash('success', 'Data was saved successfully');
                $this->redirect(array('admin'));
            }
        }

        $this->render('create', array(
            'model' => $model,
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

        if (isset($_POST['Classs'])) {
            $model->attributes = $_POST['Classs'];
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
        $dataProvider = new CActiveDataProvider('Classs');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Classs('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Classs']))
            $model->attributes = $_GET['Classs'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Classs the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Classs::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Classs $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'classs-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
