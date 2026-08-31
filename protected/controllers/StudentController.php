<?php

class StudentController extends Controller {

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
                'actions' => array('admin', 'delete', 'create', 'update', 'view', 'migration', 'admission'),
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

    public function actionMigration() {
        $model = new Student;
        $migration = new Migration;

        if (isset($_POST['Migration'])) {
            $total = count($_POST['Migration']) - 5;
            if ($total <= 0) {
                Yii::app()->user->setFlash('error', 'No student found.');
                $this->redirect(array('migration'));
            }
            for ($i = 1; $i <= $total; $i++) {
                $migration->attributes = $_POST['Migration'][$i];
//                print_r($_POST['Migration']); exit;
                if ($migration->Migration == 'Yes') {
                    $modelStudent = $this->loadModel($migration->studentid);
                    $student_photo = $modelStudent->photo;
                    $modelStudent->roll = $migration->roll;
                    $modelStudent->academic_year = $_POST['Migration']['academic_year'];
                    $modelStudent->class = $_POST['Migration']['class'];
                    $modelStudent->section = $_POST['Migration']['section'];
                    $modelStudent->group = $_POST['Migration']['group'];
                    $modelStudent->shift = $_POST['Migration']['shift'];
                    $modelStudent->save();
                    //update missing photo 
                    Student::model()->updateAll(array('photo' => $student_photo), 'id=' . (int) $migration->studentid);
                }
            }
            Yii::app()->user->setFlash('success', 'Student migration was saved successfully');
            $this->redirect(array('migration'));
        }

        $this->render('migration', array(
            'model' => $model,
            'migration' => $migration,
        ));
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
        $model = new Student;
        $path = Yii::app()->basePath . '/../uploads/student/' . Yii::app()->user->institution;
        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Student'])) {
            $model->attributes = $_POST['Student'];
            $model->institution = Yii::app()->user->institution;
            $model->created_on = new CDbExpression('NOW()');
            $model->created_by = Yii::app()->user->id;
            if ($model->validate()) {
                //Picture upload script
                if (@!empty($_FILES['Student']['name']['photo'])) {
                    $model->photo = $_POST['Student']['photo'];
                    if ($model->validate(array('photo'))) {
                        $model->photo = CUploadedFile::getInstance($model, 'photo');
                    } else {
                        $model->photo = '';
                    }
                    $model->photo->saveAs($path . '/' . time() . '_' . str_replace(' ', '_', strtolower($model->photo)));
                    $model->photo = time() . '_' . str_replace(' ', '_', strtolower($model->photo));
                }
                if ($model->save()) {
                    Yii::app()->user->setFlash('success', 'Data was saved successfully');
                    $this->redirect(array('admin'));
                }
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
        $previuosFileName = $model->photo;
        $path = Yii::app()->basePath . '/../uploads/student/' . Yii::app()->user->institution;
        if (!is_dir($path)) {
            mkdir($path);
        }

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Student'])) {
            $model->attributes = $_POST['Student'];
            $model->updated_on = new CDbExpression('NOW()');
            $model->updated_by = Yii::app()->user->id;
            if ($model->validate()) {
                //Picture upload script
                if (@!empty($_FILES['Student']['name']['photo'])) {
                    $model->photo = $_POST['Student']['photo'];
                    if ($model->validate(array('photo'))) {
                        $myFile = $path . '/' . $previuosFileName;
                        if ((is_file($myFile)) && (file_exists($myFile))) {
                            unlink($myFile);
                        }
                        $model->photo = CUploadedFile::getInstance($model, 'photo');
                    } else {
                        $model->photo = '';
                    }
                    $model->photo->saveAs($path . '/' . time() . '_' . str_replace(' ', '_', strtolower($model->photo)));
                    $model->photo = time() . '_' . str_replace(' ', '_', strtolower($model->photo));
                } else {
                    $model->photo = $previuosFileName;
                }
                if ($model->save()) {
                    if (empty($model->photo)) {
                        Student::model()->updateAll(array('photo' => $previuosFileName), 'id=' . (int) $model->id);
                    }
                    Yii::app()->user->setFlash('success', 'Data was saved successfully');
                    $this->redirect(array('admin'));
                }
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
        $dataProvider = new CActiveDataProvider('Student');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Student('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Student']))
            $model->attributes = $_GET['Student'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }
    
    public function actionAdmission() {
        $model = new Student('search_admission');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Student']))
            $model->attributes = $_GET['Student'];

        $this->render('admission', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Student the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Student::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Student $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'student-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
