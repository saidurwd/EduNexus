<?php
/* @var $this StudentController */
/* @var $model Student */
$this->pageTitle = 'Student Migration';
$this->breadcrumbs = array(
    'Students' => array('migration'),
    'Migration',
);
Yii::app()->clientScript->registerScript('chained', '
    $(document).ready(function(){
        $("#Student_exam").chained("#Student_class");
        $("#Student_section").chained("#Student_class");
        $("#Student_group").chained("#Student_class");
        $("#Migration_shift").chained("#Migration_class");
        $("#Migration_section").chained("#Migration_class");
        $("#Migration_group").chained("#Migration_class");        
    });
', CClientScript::POS_END);
Yii::app()->clientScript->registerScript("validate", "
    $(document).ready(function(){
      $('#student-migration-form').validate({// initialize the plugin
        rules: {
            'Student[academic_year]': {
                required: true,
            },
            'Student[class]': {
                required: true,
            },
            'Student[section]': {
                required: true,
            },
            'Student[group]': {
                required: true,
            }
        },
        submitHandler: function (form) {
            form.submit();
        }
    });
    $('#migration-form').validate({// initialize the plugin
        rules: {
            'Migration[academic_year]': {
                required: true,
            },
            'Migration[class]': {
                required: true,
            },
            'Migration[section]': {
                required: true,
            },
            'Migration[group]': {
                required: true,
            },
            'Migration[shift]': {
                required: true,
            }
        },
        submitHandler: function (form) {
            form.submit();
        }
    });
    });
", CClientScript::POS_END);
?>
<div class="row">
    <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
        <h1 class="page-title txt-color-blueDark">
            <i class="fa fa-home fa-fw "></i> 
            Students 
            <span>> 
                Student Migration
            </span>
        </h1>
    </div>
    <div class="col-xs-12 col-sm-5 col-md-5 col-lg-8">
    </div>
</div>
<!-- widget grid -->
<section id="widget-grid" class="">
    <!-- START ROW -->
    <div class="row">
        <!-- NEW COL START -->
        <article class="col-sm-12 col-md-12 col-lg-12">
            <!-- Widget ID (each widget will need unique ID)-->
            <div class="jarviswidget" id="wid-id-4" data-widget-editbutton="false" data-widget-custombutton="false">
                <header>
                    <span class="widget-icon"> <i class="fa fa-plus"></i> </span>
                    <h2>Student Migration</h2>
                </header>
                <!-- widget div-->
                <div>
                    <!-- widget edit box -->
                    <div class="jarviswidget-editbox">
                        <!-- This area used as dropdown edit box -->
                    </div>
                    <!-- end widget edit box -->
                    <!-- widget content -->
                    <div class="widget-body no-padding">    
                        <div class="alert alert-success fade in">
                            <i class="fa-fw fa fa-check"></i>
                            <strong>STUDENT MIGRATION FROM</strong>
                        </div>
                        <?php
                        $form = $this->beginWidget('CActiveForm', array(
                            'id' => 'student-migration-form',
                            'enableAjaxValidation' => false,
                            'htmlOptions' => array('class' => 'smart-form'),
                        ));
                        ?>
                        <fieldset>
                            <?php echo $form->errorSummary($model, '<i class="fa fa-bell text-danger"></i> Please fix the following input errors:', '', array('class' => 'text-danger', 'style' => 'padding-left:20px;')); ?>
                            <div class="row">
                                <section class="col col-2">
                                    <label class="input">
                                        <?php echo $form->dropDownList($model, 'academic_year', CHtml::listData(AcademicYear::model()->findAll(array('condition' => 'institution=' . Yii::app()->user->institution)), 'id', 'title'), array('empty' => 'Select Year', 'class' => 'select2')); ?>
                                        <?php echo $form->error($model, 'academic_year'); ?>
                                    </label>
                                </section>
                                <section class="col col-2">
                                    <label class="input">
                                        <?php echo $form->dropDownList($model, 'class', CHtml::listData(Classs::model()->findAll(array('condition' => 'status="Active" AND institution=' . Yii::app()->user->institution)), 'id', 'class'), array('empty' => 'Select Class', 'class' => 'select2')); ?>
                                        <?php echo $form->error($model, 'class'); ?>
                                    </label>
                                </section>
                                <section class="col col-2">
                                    <label class="input">
                                        <?php echo Section::getSection('Student', 'section', $model->section); ?>
                                        <?php echo $form->error($model, 'section'); ?>
                                    </label>
                                </section>
                                <section class="col col-2">
                                    <label class="input">
                                        <?php echo StudentGroup::getStudentGroup('Student', 'group', $model->group); ?>
                                        <?php echo $form->error($model, 'group'); ?>
                                    </label>
                                </section>
                                <section class="col col-2">
                                    <label class="input">
                                        <?php echo Exam::getExam('Student', 'exam', $model->exam); ?>
                                        <?php echo $form->error($model, 'exam'); ?>
                                    </label>
                                </section>
                                <section class="col col-2">
                                    <label class="select">
                                        <?php echo $form->dropDownList($model, 'MeritPosition', array('class_position' => 'Class Position', 'section_position' => 'Section Position', 'group_position' => 'Group Position'), array('class' => 'select2')); ?>
                                        <?php echo $form->error($model, 'MeritPosition'); ?>
                                    </label>
                                </section>                                                               
                            </div>                            
                        </fieldset>
                        <footer>
                            <?php echo CHtml::submitButton('SEARCH', array('class' => 'btn btn-primary')); ?>
                        </footer>
                        <?php
                        $this->endWidget();
//                        print_r($_REQUEST);
//                        print $_REQUEST['Student']['class'];
                        ?>
                        <?php
                        if (isset($_POST['Student'])) {
                            $form2 = $this->beginWidget('CActiveForm', array(
                                'id' => 'migration-form',
                                'enableAjaxValidation' => false,
                                'htmlOptions' => array('class' => 'smart-form'),
                            ));
                            ?>
                            <?= Institution::getAlertInfo('Note:', '<strong>Class:</strong> ' . Classs::getData($_REQUEST['Student']['class'], "class") . ' <strong>Section:</strong> ' . Section::getData($_REQUEST['Student']['section'], "section") . ' <strong>Group:</strong> ' . StudentGroup::getData($_REQUEST['Student']['group'], "title") . ' <strong>Academic Year:</strong> ' . AcademicYear::getData($_REQUEST['Student']['academic_year'], "title")) ?>                  
                            <table class="table table-bordered table-condensed table-responsive">
                                <thead>
                                    <tr>
                                        <th class="text-center">SL#</th>
                                        <th class="text-center">Photo</th>
                                        <th class="text-center">SID</th>
                                        <th class="text-left">Student Name</th>                                    
                                        <th class="text-center">Section</th>
                                        <th>Group</th>
                                        <th class="text-center">Current Roll</th>
                                        <th class="text-center">New Roll</th>
                                        <th>Migration</th>
                                    </tr>
                                </thead>
                                <tbody>                                
                                    <?php
                                    $i = 1;
                                    $array = Student::model()->findAll(array('condition' => 'institution=' . Yii::app()->user->institution . ' AND class=' . $_REQUEST['Student']['class'] . ' AND section=' . $_REQUEST['Student']['section'] . ' AND `group`=' . $_REQUEST['Student']['group'] . ' AND `academic_year`=' . $_REQUEST['Student']['academic_year'] . ' AND `status`="ACTIVE"', 'order' => 'roll'));
                                    foreach ($array as $key => $value) {
                                        $new_position = MeritPosition::getMeritPosition($value['institution'], $value['id'], $value['class'], $value['section'], $value['group'], @$_REQUEST['Student']['exam'], $value['academic_year'], $_REQUEST['Student']['MeritPosition']);
                                        echo $form2->hiddenField($migration, "[$i]studentid", array('value' => $value['id']));
                                        echo '<tr>';
                                        echo '<td class="text-center width-50">' . $i . '</td>';
                                        echo '<td class="text-center width-50">' . Student::getPhotoAdmitCard($value['id'], 40) . '</td>';
                                        echo '<td class="text-center width-100">' . $value['sid'] . '</td>';
                                        echo '<td class="text-left">' . $value['name'] . '</td>';
                                        echo '<td class="text-center width-100">' . Section::getData($value['section'], 'section') . '</td>';
                                        echo '<td>' . StudentGroup::getData($value['group'], 'title') . '</td>';
                                        echo '<td class="text-center width-100">' . $value['roll'] . '</td>';
                                        echo '<td class="text-center width-100"><label class="input">' . $form2->textField($migration, "[$i]roll", array('value' => $new_position, 'class' => 'col-sm-12')) . '</label></td>';
                                        echo '<td class="text-left width-100"><label class="input">' . $form2->dropDownList($migration, "[$i]Migration", array('Yes' => 'Yes', 'No' => 'No'), array('class' => 'select2')) . '</label></td>';
                                        echo '</tr>';
                                        $i++;
                                    }
                                    ?>
                                </tbody>
                            </table>                            
                            <fieldset>
                                <div class="alert alert-success fade in">
                                    <i class="fa-fw fa fa-check"></i>
                                    <strong>STUDENT MIGRATION TO</strong>
                                </div>
                                <div class="row">
                                    <section class="col col-2">
                                        <label class="input">
                                            <?php echo $form2->dropDownList($migration, 'academic_year', CHtml::listData(AcademicYear::model()->findAll(array('condition' => 'institution=' . Yii::app()->user->institution . ' AND id!=' . $_REQUEST['Student']['academic_year'])), 'id', 'title'), array('empty' => 'Select Year', 'class' => 'select2')); ?>
                                            <?php echo $form2->error($migration, 'academic_year'); ?>
                                        </label>
                                    </section>
                                    <section class="col col-2">
                                        <label class="input">
                                            <?php echo $form2->dropDownList($migration, 'class', CHtml::listData(Classs::model()->findAll(array('condition' => 'status="Active" AND institution=' . Yii::app()->user->institution . ' AND id!=' . $_REQUEST['Student']['class'])), 'id', 'class'), array('empty' => 'Select Class', 'class' => 'select2')); ?>
                                            <?php echo $form2->error($migration, 'class'); ?>
                                        </label>
                                    </section>
                                    <section class="col col-2">
                                        <label class="input">
                                            <?php echo Section::getSection('Migration', 'section', $migration->section); ?>
                                            <?php echo $form2->error($migration, 'section'); ?>
                                        </label>
                                    </section>
                                    <section class="col col-2">
                                        <label class="input">
                                            <?php echo StudentGroup::getStudentGroup('Migration', 'group', $migration->group); ?>
                                            <?php echo $form2->error($migration, 'group'); ?>
                                        </label>
                                    </section> 
                                    <section class="col col-2">
                                        <label class="input">
                                            <?php echo Shift::getShift('Migration', 'shift', $migration->shift); ?>
                                            <?php echo $form2->error($migration, 'shift'); ?>
                                        </label>
                                    </section>
                                </div>
                            </fieldset>
                            <footer>
                                <?php echo CHtml::submitButton('PROCESS MIGRATION', array('class' => 'btn btn-primary')); ?>
                            </footer>
                            <?php
                            $this->endWidget();
                        }
                        ?>
                    </div>
                    <!-- end widget content -->
                </div>
                <!-- end widget div -->
            </div>
            <!-- end widget -->
        </article>
        <!-- END COL -->		
    </div>
    <!-- END ROW -->
</section>
<!-- end widget grid -->