<?php

class InstitutionController extends Controller {

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
                'actions' => array('admin', 'delete', 'create', 'update', 'view', 'setting'),
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
        $model = new Institution;
        $path = Yii::app()->basePath . '/../uploads/institution/' . Yii::app()->user->institution;
        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Institution'])) {
            $model->attributes = $_POST['Institution'];
            if ($model->validate()) {
                //Logo upload script
                if (@!empty($_FILES['Institution']['name']['logo'])) {
                    $model->logo = $_POST['Institution']['logo'];
                    if ($model->validate(array('logo'))) {
                        $model->logo = CUploadedFile::getInstance($model, 'logo');
                    } else {
                        $model->logo = '';
                    }
                    $model->logo->saveAs($path . '/' . time() . '_' . str_replace(' ', '_', strtolower($model->logo)));
                    $model->logo = time() . '_' . str_replace(' ', '_', strtolower($model->logo));
                }
                //Signature upload script
                if (@!empty($_FILES['Institution']['name']['signature'])) {
                    $model->signature = $_POST['Institution']['signature'];
                    if ($model->validate(array('signature'))) {
                        $model->signature = CUploadedFile::getInstance($model, 'signature');
                    } else {
                        $model->signature = '';
                    }
                    $model->signature->saveAs($path . '/' . time() . '_' . str_replace(' ', '_', strtolower($model->signature)));
                    $model->signature = time() . '_' . str_replace(' ', '_', strtolower($model->signature));
                }
                //Menu Logo upload script
                if (@!empty($_FILES['Institution']['name']['menu_logo'])) {
                    $model->menu_logo = $_POST['Institution']['menu_logo'];
                    if ($model->validate(array('menu_logo'))) {
                        $model->menu_logo = CUploadedFile::getInstance($model, 'menu_logo');
                    } else {
                        $model->menu_logo = '';
                    }
                    $model->menu_logo->saveAs($path . '/' . time() . '_' . str_replace(' ', '_', strtolower($model->menu_logo)));
                    $model->menu_logo = time() . '_' . str_replace(' ', '_', strtolower($model->menu_logo));
                }
                //Special Logo upload script
                if (@!empty($_FILES['Institution']['name']['special_logo'])) {
                    $model->special_logo = $_POST['Institution']['special_logo'];
                    if ($model->validate(array('special_logo'))) {
                        $model->special_logo = CUploadedFile::getInstance($model, 'special_logo');
                    } else {
                        $model->special_logo = '';
                    }
                    $model->special_logo->saveAs($path . '/' . time() . '_' . str_replace(' ', '_', strtolower($model->special_logo)));
                    $model->special_logo = time() . '_' . str_replace(' ', '_', strtolower($model->special_logo));
                }
                if ($model->save()) {
                    //Create default Content
                    Yii::app()->db->createCommand("INSERT INTO {{content}} (`institution`, `category`, `title`, `created_by`, `created_on`) VALUES
                                            (" . $model->id . ", 8, 'Achievement and success', " . Yii::app()->user->id . ", " . new CDbExpression('NOW()') . "),
                                            (" . $model->id . ", 9, 'School History', " . Yii::app()->user->id . ", " . new CDbExpression('NOW()') . "),
                                            (" . $model->id . ", 10, 'Purpose and philosophy', " . Yii::app()->user->id . ", " . new CDbExpression('NOW()') . "),
                                            (" . $model->id . ", 11, 'Physical infrastructure information', " . Yii::app()->user->id . ", " . new CDbExpression('NOW()') . "),
                                            (" . $model->id . ", 12, 'Virtual Campus', " . Yii::app()->user->id . ", " . new CDbExpression('NOW()') . "),
                                            (" . $model->id . ", 13, 'Speech of the President', " . Yii::app()->user->id . ", " . new CDbExpression('NOW()') . "),
                                            (" . $model->id . ", 14, 'Message from the head of the organization', " . Yii::app()->user->id . ", " . new CDbExpression('NOW()') . ")")->execute();
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
        $preLogo = $model->logo;
        $preSignature = $model->signature;
        $preMenuLogo = $model->menu_logo;
        $preSpecialLogo = $model->special_logo;
        $path = Yii::app()->basePath . '/../uploads/institution/' . Yii::app()->user->institution;
        if (!is_dir($path)) {
            mkdir($path);
        }

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Institution'])) {
            $model->attributes = $_POST['Institution'];
            if ($model->validate()) {
                //Logo upload script
                if (@!empty($_FILES['Institution']['name']['logo'])) {
                    $model->logo = $_POST['Institution']['logo'];
                    if ($model->validate(array('logo'))) {
                        $myFile = $path . '/' . $preLogo;
                        if ((is_file($myFile)) && (file_exists($myFile))) {
                            unlink($myFile);
                        }
                        $model->logo = CUploadedFile::getInstance($model, 'logo');
                    } else {
                        $model->logo = '';
                    }
                    $model->logo->saveAs($path . '/' . time() . '_' . str_replace(' ', '_', strtolower($model->logo)));
                    $model->logo = time() . '_' . str_replace(' ', '_', strtolower($model->logo));
                } else {
                    $model->logo = $preLogo;
                }
                //Signeture upload script
                if (@!empty($_FILES['Institution']['name']['signature'])) {
                    $model->signature = $_POST['Institution']['signature'];
                    if ($model->validate(array('signature'))) {
                        $myFile = $path . '/' . $preSignature;
                        if ((is_file($myFile)) && (file_exists($myFile))) {
                            unlink($myFile);
                        }
                        $model->signature = CUploadedFile::getInstance($model, 'signature');
                    } else {
                        $model->signature = '';
                    }
                    $model->signature->saveAs($path . '/' . time() . '_' . str_replace(' ', '_', strtolower($model->signature)));
                    $model->signature = time() . '_' . str_replace(' ', '_', strtolower($model->signature));
                } else {
                    $model->signature = $preSignature;
                }

                //Menu logo upload script
                if (@!empty($_FILES['Institution']['name']['menu_logo'])) {
                    $model->menu_logo = $_POST['Institution']['menu_logo'];
                    if ($model->validate(array('menu_logo'))) {
                        $myFile = $path . '/' . $preMenuLogo;
                        if ((is_file($myFile)) && (file_exists($myFile))) {
                            unlink($myFile);
                        }
                        $model->menu_logo = CUploadedFile::getInstance($model, 'menu_logo');
                    } else {
                        $model->menu_logo = '';
                    }
                    $model->menu_logo->saveAs($path . '/' . time() . '_' . str_replace(' ', '_', strtolower($model->menu_logo)));
                    $model->menu_logo = time() . '_' . str_replace(' ', '_', strtolower($model->menu_logo));
                } else {
                    $model->menu_logo = $preMenuLogo;
                }
                //Special Logo upload script
                if (@!empty($_FILES['Institution']['name']['special_logo'])) {
                    $model->special_logo = $_POST['Institution']['special_logo'];
                    if ($model->validate(array('special_logo'))) {
                        $myFile = $path . '/' . $preSpecialLogo;
                        if ((is_file($myFile)) && (file_exists($myFile))) {
                            unlink($myFile);
                        }
                        $model->special_logo = CUploadedFile::getInstance($model, 'special_logo');
                    } else {
                        $model->special_logo = '';
                    }
                    $model->special_logo->saveAs($path . '/' . time() . '_' . str_replace(' ', '_', strtolower($model->special_logo)));
                    $model->special_logo = time() . '_' . str_replace(' ', '_', strtolower($model->special_logo));
                } else {
                    $model->special_logo = $preSpecialLogo;
                }
                if ($model->save()) {
                    if (empty($model->logo)) {
                        Institution::model()->updateAll(array('logo' => $preLogo), 'id=' . (int) $model->id);
                    }
                    if (empty($model->signature)) {
                        Institution::model()->updateAll(array('signature' => $preSignature), 'id=' . (int) $model->id);
                    }
                    if (empty($model->menu_logo)) {
                        Institution::model()->updateAll(array('menu_logo' => $preMenuLogo), 'id=' . (int) $model->id);
                    }
                    if (empty($model->special_logo)) {
                        Institution::model()->updateAll(array('special_logo' => $preSpecialLogo), 'id=' . (int) $model->id);
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

    public function actionSetting() {
        $model = $this->loadModel(Yii::app()->user->institution);
        $preLogo = $model->logo;
        $preSignature = $model->signature;
        $preMenuLogo = $model->menu_logo;
        $preSpecialLogo = $model->special_logo;
        $path = Yii::app()->basePath . '/../uploads/institution/' . Yii::app()->user->institution;
        if (!is_dir($path)) {
            mkdir($path);
        }

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Institution'])) {
            $model->attributes = $_POST['Institution'];
            if ($model->validate()) {
                //Logo upload script
                if (@!empty($_FILES['Institution']['name']['logo'])) {
                    $model->logo = $_POST['Institution']['logo'];
                    if ($model->validate(array('logo'))) {
                        $myFile = $path . '/' . $preLogo;
                        if ((is_file($myFile)) && (file_exists($myFile))) {
                            unlink($myFile);
                        }
                        $model->logo = CUploadedFile::getInstance($model, 'logo');
                    } else {
                        $model->logo = '';
                    }
                    $model->logo->saveAs($path . '/' . time() . '_' . str_replace(' ', '_', strtolower($model->logo)));
                    $model->logo = time() . '_' . str_replace(' ', '_', strtolower($model->logo));
                } else {
                    $model->logo = $preLogo;
                }
                //Signeture upload script
                if (@!empty($_FILES['Institution']['name']['signature'])) {
                    $model->signature = $_POST['Institution']['signature'];
                    if ($model->validate(array('signature'))) {
                        $myFile = $path . '/' . $preSignature;
                        if ((is_file($myFile)) && (file_exists($myFile))) {
                            unlink($myFile);
                        }
                        $model->signature = CUploadedFile::getInstance($model, 'signature');
                    } else {
                        $model->signature = '';
                    }
                    $model->signature->saveAs($path . '/' . time() . '_' . str_replace(' ', '_', strtolower($model->signature)));
                    $model->signature = time() . '_' . str_replace(' ', '_', strtolower($model->signature));
                } else {
                    $model->signature = $preSignature;
                }
                //Menu logo upload script
                if (@!empty($_FILES['Institution']['name']['menu_logo'])) {
                    $model->menu_logo = $_POST['Institution']['menu_logo'];
                    if ($model->validate(array('menu_logo'))) {
                        $myFile = $path . '/' . $preMenuLogo;
                        if ((is_file($myFile)) && (file_exists($myFile))) {
                            unlink($myFile);
                        }
                        $model->menu_logo = CUploadedFile::getInstance($model, 'menu_logo');
                    } else {
                        $model->menu_logo = '';
                    }
                    $model->menu_logo->saveAs($path . '/' . time() . '_' . str_replace(' ', '_', strtolower($model->menu_logo)));
                    $model->menu_logo = time() . '_' . str_replace(' ', '_', strtolower($model->menu_logo));
                } else {
                    $model->menu_logo = $preMenuLogo;
                }
                //Special Logo upload script
                if (@!empty($_FILES['Institution']['name']['special_logo'])) {
                    $model->special_logo = $_POST['Institution']['special_logo'];
                    if ($model->validate(array('special_logo'))) {
                        $myFile = $path . '/' . $preSpecialLogo;
                        if ((is_file($myFile)) && (file_exists($myFile))) {
                            unlink($myFile);
                        }
                        $model->special_logo = CUploadedFile::getInstance($model, 'special_logo');
                    } else {
                        $model->special_logo = '';
                    }
                    $model->special_logo->saveAs($path . '/' . time() . '_' . str_replace(' ', '_', strtolower($model->special_logo)));
                    $model->special_logo = time() . '_' . str_replace(' ', '_', strtolower($model->special_logo));
                } else {
                    $model->special_logo = $preSpecialLogo;
                }
                if ($model->save()) {
                    if (empty($model->logo)) {
                        Institution::model()->updateAll(array('logo' => $preLogo), 'id=' . (int) $model->id);
                    }
                    if (empty($model->signature)) {
                        Institution::model()->updateAll(array('signature' => $preSignature), 'id=' . (int) $model->id);
                    }
                    if (empty($model->menu_logo)) {
                        Institution::model()->updateAll(array('menu_logo' => $preMenuLogo), 'id=' . (int) $model->id);
                    }
                    if (empty($model->special_logo)) {
                        Institution::model()->updateAll(array('special_logo' => $preSpecialLogo), 'id=' . (int) $model->id);
                    }
                    Yii::app()->user->setFlash('success', 'Institution was saved successfully');
                    $this->redirect(array('institution/setting'));
                }
            }
        }

        $this->render('setting', array(
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
        $dataProvider = new CActiveDataProvider('Institution');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Institution('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Institution']))
            $model->attributes = $_GET['Institution'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Institution the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Institution::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Institution $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'institution-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
