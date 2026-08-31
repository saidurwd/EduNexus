<?php

class MarkController extends Controller {

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
                'actions' => array('admin', 'delete', 'create', 'update', 'edit', 'view', 'merit'),
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
        $model = new MarkParent;

        if (isset($_POST['MarkParent'])) {
            $model->attributes = $_POST['MarkParent'];
            $model->institution = Yii::app()->user->institution;
            $model->created_on = new CDbExpression('NOW()');
            $model->created_by = Yii::app()->user->id;
            if ($model->save()) {
                $subject_type = Subject::getData($model->subject, 'type');
                if ($subject_type == 'CHOOSABLE') {
                    $array = Student::model()->findAll(array('condition' => 'institution=' . $model->institution . ' AND class=' . $model->class . ' AND section=' . $model->section . ' AND `group`=' . $model->group . ' AND `optional_subject`=' . $model->subject . ' AND `status`="ACTIVE"', 'order' => 'roll'));
                } else {
                    $array = Student::model()->findAll(array('condition' => 'institution=' . $model->institution . ' AND class=' . $model->class . ' AND section=' . $model->section . ' AND `group`=' . $model->group . ' AND `status`="ACTIVE"', 'order' => 'roll'));
                }
                foreach ($array as $key => $value) {
                    $student = new Mark;
                    $student->institution = $model->institution;
                    $student->parent = $model->id;
                    $student->student = $value['id'];
                    $student->class = $model->class;
                    $student->section = $model->section;
                    $student->group = $model->group;
                    $student->subject = $model->subject;
                    $student->exam = $model->exam;
                    $student->academic_year = $model->academic_year;
                    $student->sid = $value['sid'];
                    $student->roll = $value['roll'];
                    $student->created_on = new CDbExpression('NOW()');
                    $student->created_by = Yii::app()->user->id;
                    $student->save();
                }
                Yii::app()->user->setFlash('success', 'Data was saved successfully');
                $this->redirect(array('edit', 'id' => $model->id));
            }
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    public function actionMerit() {
        $model = new MeritPosition;

        if (isset($_POST['MeritPosition'])) {
            $model->attributes = $_POST['MeritPosition'];

            $connection = Yii::app()->db;
            $command = $connection->createCommand('SELECT SUM(M.`subject_total`) AS subject_total, M.`student`, M.`class`, M.`section`, M.`group`, M.`exam`, M.`academic_year`, M.`sid`, M.`roll`
                                                FROM {{mark}} M
                                                LEFT OUTER JOIN {{student}} S ON S.`id`=M.`student` 
                                                LEFT OUTER JOIN {{subject}} SB ON SB.`id` = M.`subject` 
                                                WHERE  M.`institution`=' . Yii::app()->user->institution . ' AND SB.`type`!="UNCOUNTABLE" AND M.`class`=' . $model->class . ' AND M.`section`=' . $model->section . ' AND M.`group`=' . $model->group . ' AND M.`exam`=' . $model->exam . ' AND M.`academic_year`=' . $model->academic_year . ' GROUP BY M.`student` ORDER BY `subject_total` DESC');
            $students = $command->queryAll();
            //delete old data 
            MeritPosition::model()->deleteAll(array('condition' => 'institution=' . Yii::app()->user->institution . ' AND class=' . $model->class . ' AND section=' . $model->section . ' AND `group`=' . $model->group . ' AND exam=' . $model->exam . ' AND academic_year=' . $model->academic_year));
            foreach ($students as $key => $value) {
                $modelMP = new MeritPosition();
                $modelMP->institution = Yii::app()->user->institution;
                $modelMP->student = $value['student'];
                $modelMP->class = $value['class'];
                $modelMP->section = $value['section'];
                $modelMP->group = $value['group'];
                $modelMP->exam = $value['exam'];
                $modelMP->academic_year = $value['academic_year'];
                $modelMP->sid = $value['sid'];
                $modelMP->roll = $value['roll'];
                $modelMP->total_mark = $value['subject_total'];
                $modelMP->gpa = Mark::getSemesterData(Yii::app()->user->institution, $value['student'], $value['class'], $value['section'], $value['group'], $value['exam'], $value['academic_year'])['gpa'];
                $modelMP->letter_grade = Mark::getSemesterData(Yii::app()->user->institution, $value['student'], $value['class'], $value['section'], $value['group'], $value['exam'], $value['academic_year'])['letter_grade'];
                $modelMP->failed_subject = Mark::getSemesterFailedSubject(Yii::app()->user->institution, $value['student'], $value['class'], $value['section'], $value['group'], $value['exam'], $value['academic_year']);
                $modelMP->save();
            }

            //set actual merit position - class wise 
            $i = 1;
            $array_class = MeritPosition::model()->findAll(array('condition' => 'institution=' . Yii::app()->user->institution . ' AND class=' . $model->class . ' AND exam=' . $model->exam . ' AND academic_year=' . $model->academic_year . ' AND letter_grade != "F"', 'order' => '`gpa` DESC, `total_mark` DESC'));
            foreach ($array_class as $key => $value) {
                MeritPosition::model()->updateAll(array('class_position' => $i), 'institution=' . Yii::app()->user->institution . ' AND student=' . $value['student'] . ' AND class=' . $model->class . ' AND exam=' . $model->exam . ' AND academic_year=' . $model->academic_year);
                $i++;
            }

            //set actual merit position - section wise 
            $j = 1;
            $array_section = MeritPosition::model()->findAll(array('condition' => 'institution=' . Yii::app()->user->institution . ' AND class=' . $model->class . ' AND section=' . $model->section . ' AND exam=' . $model->exam . ' AND academic_year=' . $model->academic_year . ' AND letter_grade != "F"', 'order' => '`gpa` DESC, `total_mark` DESC'));
            foreach ($array_section as $key => $value) {
                MeritPosition::model()->updateAll(array('section_position' => $j), 'institution=' . Yii::app()->user->institution . ' AND student=' . $value['student'] . ' AND class=' . $model->class . ' AND section=' . $model->section . ' AND exam=' . $model->exam . ' AND academic_year=' . $model->academic_year);
                $j++;
            }

            //set actual merit position - group wise 
            $k = 1;
            $array = MeritPosition::model()->findAll(array('condition' => 'institution=' . Yii::app()->user->institution . ' AND class=' . $model->class . ' AND section=' . $model->section . ' AND `group`=' . $model->group . ' AND exam=' . $model->exam . ' AND academic_year=' . $model->academic_year . ' AND letter_grade != "F"', 'order' => '`gpa` DESC, `total_mark` DESC'));
            foreach ($array as $key => $value) {
                MeritPosition::model()->updateAll(array('group_position' => $k), 'institution=' . Yii::app()->user->institution . ' AND student=' . $value['student'] . ' AND class=' . $model->class . ' AND section=' . $model->section . ' AND `group`=' . $model->group . ' AND exam=' . $model->exam . ' AND academic_year=' . $model->academic_year);
                $k++;
            }

            Yii::app()->user->setFlash('success', 'Merit Position was saved successfully');
            $this->redirect(array('merit'));
        }

        $this->render('merit', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model_parent = $this->loadModelParent($id);
        $model = new Mark;
        //get subject distributed mark id
        $SubjectMarkID = SubjectMark::getMark($model_parent->institution, $model_parent->class, $model_parent->subject, 'id');
        $modelSubjectMark = $this->loadModelSujectMark($SubjectMarkID);

        if (isset($_POST['Mark'])) {
            $total = count($_POST['Mark']);
            for ($i = 1; $i <= $total; $i++) {
                $model->attributes = $_POST['Mark'][$i];
//                print_r($_POST['Mark']);
                $student = $this->loadModel($model->markid);
                $student->written = $model->written;
                $student->mcq = $model->mcq;
                $student->practical = $model->practical;
                $student->class_assessment = $model->class_assessment;
                $student->full_mark = Subject::getData($student->subject, 'final_mark');
                $student->subject_total = Mark::getSubjectTotal($modelSubjectMark->full_mark, $modelSubjectMark->class_assessment, $model->written, $model->mcq, $model->practical, $model->class_assessment, $modelSubjectMark->calculate_percent);
                $student->calculate_percent = Mark::getPercent($student->full_mark, $student->subject_total, $modelSubjectMark->calculate_percent);
                $student->updated_on = new CDbExpression('NOW()');
                $student->updated_by = Yii::app()->user->id;
                $actualPercent = Subject::getData($student->subject, 'pass_mark');
//                $student->save();
                if ($student->save()) {
                    // Update letter_grade and gpa based on passed_separately
                    if ($modelSubjectMark->passed_separately == 'Yes') {
                        $getMargeID = Subject::getData($student->subject, 'marge_id');
                        if ($modelSubjectMark->written > 0) {
                            if ($getMargeID > 0) {
                                $marged_written_actual = Mark::getMargedMarkesActual($student->institution, $student->class, $getMargeID, 'written');
                                $marged_written = Mark::getMargedMarkes($student->institution, $student->class, $getMargeID, $student->student, $student->exam, $student->academic_year, 'written');
                                $pWritten = Mark::getPercent($marged_written_actual, $marged_written, $modelSubjectMark->calculate_percent);
                            } else {
                                $pWritten = Mark::getPercent($modelSubjectMark->written, $student->written, $modelSubjectMark->calculate_percent);
                            }
                            if ($pWritten < $actualPercent) {
                                $pw = 0;
                            } else {
                                $pw = 1;
                            }
                        } else {
                            $pw = 1;
                        }
                        if ($modelSubjectMark->mcq > 0) {
                            if ($getMargeID > 0) {
                                $marged_mcq_actual = Mark::getMargedMarkesActual($student->institution, $student->class, $getMargeID, 'mcq');
                                $marged_mcq = Mark::getMargedMarkes($student->institution, $student->class, $getMargeID, $student->student, $student->exam, $student->academic_year, 'mcq');
                                $pMCQ = Mark::getPercent($marged_mcq_actual, $marged_mcq, $modelSubjectMark->calculate_percent);
                            } else {
                                $pMCQ = Mark::getPercent($modelSubjectMark->mcq, $student->mcq, $modelSubjectMark->calculate_percent);
                            }
                            if ($pMCQ < $actualPercent) {
                                $pm = 0;
                            } else {
                                $pm = 1;
                            }
                        } else {
                            $pm = 1;
                        }
                        if ($modelSubjectMark->practical > 0) {
                            if ($getMargeID > 0) {
                                $marged_practical_actual = Mark::getMargedMarkesActual($student->institution, $student->class, $getMargeID, 'practical');
                                $marged_practical = Mark::getMargedMarkes($student->institution, $student->class, $getMargeID, $student->student, $student->exam, $student->academic_year, 'practical');
                                $pPractical = Mark::getPercent($marged_practical_actual, $marged_practical, $modelSubjectMark->calculate_percent);
                            } else {
                                $pPractical = Mark::getPercent($modelSubjectMark->practical, $student->practical, $modelSubjectMark->calculate_percent);
                            }
                            if ($pPractical < $actualPercent) {
                                $pp = 0;
                            } else {
                                $pp = 1;
                            }
                        } else {
                            $pp = 1;
                        }
                        if ($modelSubjectMark->class_assessment > 0) {
                            if ($getMargeID > 0) {
                                $marged_class_assessment_actual = Mark::getMargedMarkesActual($student->institution, $student->class, $getMargeID, 'class_assessment');
                                $marged_class_assessment = Mark::getMargedMarkes($student->institution, $student->class, $getMargeID, $student->student, $student->exam, $student->academic_year, 'class_assessment');
                                $pCA = Mark::getPercent($marged_class_assessment_actual, $marged_class_assessment, $modelSubjectMark->calculate_percent);
                            } else {
                                $pCA = Mark::getPercent($modelSubjectMark->class_assessment, $student->class_assessment, $modelSubjectMark->calculate_percent);
                            }
                            if ($pCA < $actualPercent) {
                                $pc = 0;
                            } else {
                                $pc = 1;
                            }
                        } else {
                            $pc = 1;
                        }
                        if ($pw == 1 && $pm == 1 && $pp == 1 && $pc == 1) {
                            if ($getMargeID > 0) {
                                $marged_full_mark = Mark::getMargedMarkes($student->institution, $student->class, $getMargeID, $student->student, $student->exam, $student->academic_year, 'full_mark');
                                $marged_subject_total = Mark::getMargedMarkes($student->institution, $student->class, $getMargeID, $student->student, $student->exam, $student->academic_year, 'subject_total');
                                $letter_grade = Mark::getLetterGrade($student->institution, $student->class, $marged_full_mark, $marged_subject_total);
                                $gpa = Mark::getGPA($student->institution, $student->class, $marged_full_mark, $marged_subject_total);
                            } else {
                                $letter_grade = Mark::getLetterGrade($student->institution, $student->class, $student->full_mark, $student->subject_total);
                                $gpa = Mark::getGPA($student->institution, $student->class, $student->full_mark, $student->subject_total);
                            }
                            Mark::model()->updateAll(array('letter_grade' => $letter_grade, 'gpa' => $gpa), 'id = ' . $student->id);
                        } else {
                            Mark::model()->updateAll(array('letter_grade' => 'F', 'gpa' => 0), 'id = ' . $student->id);
                        }
                    } else {
                        $letter_grade = Mark::getLetterGrade($student->institution, $student->class, $student->full_mark, $student->subject_total);
                        $gpa = Mark::getGPA($student->institution, $student->class, $student->full_mark, $student->subject_total);
                        Mark::model()->updateAll(array('letter_grade' => $letter_grade, 'gpa' => $gpa), 'id = ' . $student->id);
                    }
                    //UPDATE marged letter grade and GPA
                    $marge_id = Subject::getData($student->subject, 'marge_id');
                    if ($marge_id > 0) {
                        $marge_grade = Mark::getMargeLetterGrade($student->institution, $student->class, $marge_id, $student->student, $student->exam, $student->academic_year);
                        $marge_gpa = Mark::getMargeGPA($student->institution, $student->class, $marge_id, $student->student, $student->exam, $student->academic_year);
                        Mark::model()->updateAll(array('marge_grade' => $marge_grade, 'marge_gpa' => $marge_gpa), 'id=' . $student->id);
                    }
                }
            }
//          Update highest marks
            $highestMark = Mark::getHighestMark($model_parent->institution, $model_parent->class, $model_parent->section, $model_parent->group, $model_parent->subject, $model_parent->exam, $model_parent->academic_year);
            Mark::model()->updateAll(array('highest_mark' => $highestMark), 'institution = ' . $model_parent->institution . ' AND class=' . $model_parent->class . ' AND section=' . $model_parent->section . ' AND `group`=' . $model_parent->group . ' AND `subject`=' . $model_parent->subject . ' AND exam=' . $model_parent->exam . ' AND academic_year=' . $model_parent->academic_year);

            Yii::app()->user->setFlash('success', 'Mark was saved successfully');
            $this->redirect(array('admin'));
        }

        $this->render('update', array(
            'model_parent' => $model_parent,
            'model' => $model,
            'modelSubjectMark' => $modelSubjectMark,
        ));
    }

    public function actionEdit($id) {
        $model_parent = $this->loadModelParent($id);
        $model = new Mark;
        //get subject distributed mark id
        $SubjectMarkID = SubjectMark::getMark($model_parent->institution, $model_parent->class, $model_parent->subject, 'id');
        $modelSubjectMark = $this->loadModelSujectMark($SubjectMarkID);

        if (isset($_POST['Mark'])) {
            $total = count($_POST['Mark']);
            for ($i = 1; $i <= $total; $i++) {
                $model->attributes = $_POST['Mark'][$i];
//                print_r($_POST['Mark']);
                $student = $this->loadModel($model->markid);
                $student->written = $model->written;
                $student->mcq = $model->mcq;
                $student->practical = $model->practical;
                $student->class_assessment = $model->class_assessment;
                $student->full_mark = Subject::getData($student->subject, 'final_mark');
                $student->subject_total = Mark::getSubjectTotal($modelSubjectMark->full_mark, $modelSubjectMark->class_assessment, $model->written, $model->mcq, $model->practical, $model->class_assessment, $modelSubjectMark->calculate_percent);
                $student->calculate_percent = Mark::getPercent($student->full_mark, $student->subject_total, $modelSubjectMark->calculate_percent);
                $student->updated_on = new CDbExpression('NOW()');
                $student->updated_by = Yii::app()->user->id;
                $actualPercent = Subject::getData($student->subject, 'pass_mark');
//                $student->save();
                if ($student->save()) {
                    // Update letter_grade and gpa based on passed_separately
                    if ($modelSubjectMark->passed_separately == 'Yes') {
                        $getMargeID = Subject::getData($student->subject, 'marge_id');
                        if ($modelSubjectMark->written > 0) {
                            if ($getMargeID > 0) {
                                $marged_written_actual = Mark::getMargedMarkesActual($student->institution, $student->class, $getMargeID, 'written');
                                $marged_written = Mark::getMargedMarkes($student->institution, $student->class, $getMargeID, $student->student, $student->exam, $student->academic_year, 'written');
                                $pWritten = Mark::getPercent($marged_written_actual, $marged_written, $modelSubjectMark->calculate_percent);
                            } else {
                                $pWritten = Mark::getPercent($modelSubjectMark->written, $student->written, $modelSubjectMark->calculate_percent);
                            }
                            if ($pWritten < $actualPercent) {
                                $pw = 0;
                            } else {
                                $pw = 1;
                            }
                        } else {
                            $pw = 1;
                        }
                        if ($modelSubjectMark->mcq > 0) {
                            if ($getMargeID > 0) {
                                $marged_mcq_actual = Mark::getMargedMarkesActual($student->institution, $student->class, $getMargeID, 'mcq');
                                $marged_mcq = Mark::getMargedMarkes($student->institution, $student->class, $getMargeID, $student->student, $student->exam, $student->academic_year, 'mcq');
                                $pMCQ = Mark::getPercent($marged_mcq_actual, $marged_mcq, $modelSubjectMark->calculate_percent);
                            } else {
                                $pMCQ = Mark::getPercent($modelSubjectMark->mcq, $student->mcq, $modelSubjectMark->calculate_percent);
                            }
                            if ($pMCQ < $actualPercent) {
                                $pm = 0;
                            } else {
                                $pm = 1;
                            }
                        } else {
                            $pm = 1;
                        }
                        if ($modelSubjectMark->practical > 0) {
                            if ($getMargeID > 0) {
                                $marged_practical_actual = Mark::getMargedMarkesActual($student->institution, $student->class, $getMargeID, 'practical');
                                $marged_practical = Mark::getMargedMarkes($student->institution, $student->class, $getMargeID, $student->student, $student->exam, $student->academic_year, 'practical');
                                $pPractical = Mark::getPercent($marged_practical_actual, $marged_practical, $modelSubjectMark->calculate_percent);
                            } else {
                                $pPractical = Mark::getPercent($modelSubjectMark->practical, $student->practical, $modelSubjectMark->calculate_percent);
                            }
                            if ($pPractical < $actualPercent) {
                                $pp = 0;
                            } else {
                                $pp = 1;
                            }
                        } else {
                            $pp = 1;
                        }
                        if ($modelSubjectMark->class_assessment > 0) {
                            if ($getMargeID > 0) {
                                $marged_class_assessment_actual = Mark::getMargedMarkesActual($student->institution, $student->class, $getMargeID, 'class_assessment');
                                $marged_class_assessment = Mark::getMargedMarkes($student->institution, $student->class, $getMargeID, $student->student, $student->exam, $student->academic_year, 'class_assessment');
                                $pCA = Mark::getPercent($marged_class_assessment_actual, $marged_class_assessment, $modelSubjectMark->calculate_percent);
                            } else {
                                $pCA = Mark::getPercent($modelSubjectMark->class_assessment, $student->class_assessment, $modelSubjectMark->calculate_percent);
                            }
                            if ($pCA < $actualPercent) {
                                $pc = 0;
                            } else {
                                $pc = 1;
                            }
                        } else {
                            $pc = 1;
                        }
                        if ($pw == 1 && $pm == 1 && $pp == 1 && $pc == 1) {
                            $letter_grade = Mark::getLetterGrade($student->institution, $student->class, $student->full_mark, $student->subject_total);
                            $gpa = Mark::getGPA($student->institution, $student->class, $student->full_mark, $student->subject_total);
                            Mark::model()->updateAll(array('letter_grade' => $letter_grade, 'gpa' => $gpa), 'id = ' . $student->id);
                        } else {
                            Mark::model()->updateAll(array('letter_grade' => 'F', 'gpa' => 0), 'id = ' . $student->id);
                        }
                    } else {
                        $letter_grade = Mark::getLetterGrade($student->institution, $student->class, $student->full_mark, $student->subject_total);
                        $gpa = Mark::getGPA($student->institution, $student->class, $student->full_mark, $student->subject_total);
                        Mark::model()->updateAll(array('letter_grade' => $letter_grade, 'gpa' => $gpa), 'id = ' . $student->id);
                    }
                }
            }
//          Update highest marks
            $highestMark = Mark::getHighestMark($model_parent->institution, $model_parent->class, $model_parent->section, $model_parent->group, $model_parent->subject, $model_parent->exam, $model_parent->academic_year);
            Mark::model()->updateAll(array('highest_mark' => (int) $highestMark), 'institution = ' . $model_parent->institution . ' AND class=' . $model_parent->class . ' AND section=' . $model_parent->section . ' AND `group`=' . $model_parent->group . ' AND `subject`=' . $model_parent->subject . ' AND exam=' . $model_parent->exam . ' AND academic_year=' . $model_parent->academic_year);

            Yii::app()->user->setFlash('success', 'Mark was saved successfully');
            $this->redirect(array('admin'));
        }

        $this->render('update', array(
            'model_parent' => $model_parent,
            'model' => $model,
            'modelSubjectMark' => $modelSubjectMark,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
//        Delete marks
        Mark::model()->deleteAll(array("condition" => "parent='$id'"));
//        Delete marks parent
        $this->loadModelParent($id)->delete();
        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('Mark');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new MarkParent('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['MarkParent']))
            $model->attributes = $_GET['MarkParent'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Mark the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Mark::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    public function loadModelParent($id) {
        $model = MarkParent::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    public function loadModelSujectMark($id) {
        $model = SubjectMark::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Mark $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'mark-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    protected function performAjaxValidationParent($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'mark-parent-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
