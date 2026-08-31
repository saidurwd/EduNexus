<?php
/* @var $this AttendanceController */
/* @var $model Attendance */
$this->pageTitle = 'New Attendance';
$this->breadcrumbs = array(
    'Student Attendances' => array('admin'),
    'Create',
);
Yii::app()->clientScript->registerScript('chained', '
    $(document).ready(function(){
        $("#Student_section").chained("#Student_class");
        $("#Student_group").chained("#Student_class");
    });
', CClientScript::POS_END);
?>
<script>
    $(function () {
        $('.datepicker').datepicker({dateFormat: "yy-mm-dd"});
    });
</script>
<div class="row">
    <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
        <h1 class="page-title txt-color-blueDark">
            <i class="fa fa-home fa-fw "></i> 
            Student Attendance
            <span>> 
                New Attendance
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
                    <h2>New Attendance</h2>	
                    <div class="widget-toolbar">
                        <?php echo CHtml::link('<i class="fa fa-home"></i> MANAGE', array('admin'), array('data-rel' => 'tooltip', 'title' => 'Manage', 'data-placement' => 'bottom', 'class' => 'btn btn-xs btn-primary')); ?>
                    </div>
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
                        <?php
                        $form = $this->beginWidget('CActiveForm', array(
                            'id' => 'student-attendance-search',
                            'enableAjaxValidation' => false,
                            'htmlOptions' => array('class' => 'smart-form'),
                        ));
                        ?>
                        <fieldset>
                            <?php echo $form->errorSummary($model, '<i class="fa fa-bell text-danger"></i> Please fix the following input errors:', '', array('class' => 'text-danger', 'style' => 'padding-left:20px;')); ?>
                            <div class="row">
                                <section class="col col-2">
                                    <label class="label"><?php echo $form->labelEx($model, 'academic_year'); ?></label>
                                    <label class="input">
                                        <?php echo $form->dropDownList($model, 'academic_year', CHtml::listData(AcademicYear::model()->findAll(array('condition' => 'institution=' . Yii::app()->user->institution)), 'id', 'title'), array('empty' => 'Select Year', 'class' => 'select2')); ?>
                                        <?php echo $form->error($model, 'academic_year'); ?>
                                    </label>
                                </section>
                                <section class="col col-2">
                                    <label class="label"><?php echo $form->labelEx($model, 'class'); ?></label>
                                    <label class="input">
                                        <?php echo $form->dropDownList($model, 'class', CHtml::listData(Classs::model()->findAll(array('condition' => 'status="Active" AND institution=' . Yii::app()->user->institution)), 'id', 'class'), array('empty' => 'Select Class', 'class' => 'select2')); ?>
                                        <?php echo $form->error($model, 'class'); ?>
                                    </label>
                                </section>
                                <section class="col col-2">
                                    <label class="label"><?php echo $form->labelEx($model, 'section'); ?></label>
                                    <label class="input">
                                        <?php echo Section::getSection('Student', 'section', $model->section); ?>
                                        <?php echo $form->error($model, 'section'); ?>
                                    </label>
                                </section>
                                <section class="col col-2">
                                    <label class="label"><?php echo $form->labelEx($model, 'group'); ?></label>
                                    <label class="input">
                                        <?php echo StudentGroup::getStudentGroup('Student', 'group', $model->group); ?>
                                        <?php echo $form->error($model, 'group'); ?>
                                    </label>
                                </section>
                                <section class="col col-2">
                                    <label class="label">&nbsp;</label>
                                    <label class="input">
                                        <?php echo CHtml::submitButton('SEARCH', array('class' => 'btn btn-primary')); ?>
                                    </label>
                                </section>
                            </div>
                        </fieldset>
                        <?php $this->endWidget(); ?>
                        <?php
                        if (isset($_POST['Student'])) {
                            $form2 = $this->beginWidget('CActiveForm', array(
                                'id' => 'student-attendance-form',
                                'enableAjaxValidation' => false,
                                'htmlOptions' => array('class' => 'smart-form'),
                            ));
                            ?>
                            <table class="table table-bordered table-condensed table-responsive">
                                <thead>
                                    <tr>
                                        <th class="text-center">SL#</th>
                                        <th class="text-center">Photo</th>
                                        <th class="text-left">Student Name</th>
                                        <th class="text-center">Roll</th>
                                        <th class="text-left">Class</th>
                                        <th class="text-center">Section</th>
                                        <th class="text-left">Group</th>
                                        <th>Attendance</th>
                                    </tr>
                                </thead>
                                <tbody>                                
                                    <?php
                                    $i = 1;
                                    $array = Student::model()->findAll(array('condition' => 'institution=' . Yii::app()->user->institution . ' AND class=' . $_REQUEST['Student']['class'] . ' AND section=' . $_REQUEST['Student']['section'] . ' AND `group`=' . $_REQUEST['Student']['group'] . ' AND `academic_year`=' . $_REQUEST['Student']['academic_year'] . ' AND `status`="ACTIVE"', 'order' => 'roll'));
                                    foreach ($array as $key => $value) {
                                        echo $form2->hiddenField($Attendance, "[$i]studentid", array('value' => $value['id']));
                                        echo '<tr>';
                                        echo '<td class="text-center width-50">' . $i . '</td>';
                                        echo '<td class="text-center width-50">' . Student::getPhoto($value['id']) . '</td>';
                                        echo '<td class="text-left">' . $value['name'] . '</td>';
                                        echo '<td class="text-center">' . $value['roll'] . '</td>';
                                        echo '<td class="text-left">' . Classs::getData($value['class'], 'class') . '</td>';
                                        echo '<td class="text-center">' . Section::getData($value['section'], 'section') . '</td>';
                                        echo '<td class="text-left">' . StudentGroup::getData($value['group'], 'title') . '</td>';
                                        echo '<td><label class="select state-error">' . $form2->dropDownList($Attendance, "[$i]attendance", array('Present' => 'Present', 'Late Present With Excuse' => 'Late Present With Excuse', 'Late Present' => 'Late Present', 'Absent' => 'Absent', 'Half Day' => 'Half Day'), array('class' => 'form-control')) . '</label></td>';
                                        echo '</tr>';
                                        $i++;
                                    }
                                    ?>
                                    <tr>
                                        <td colspan="7">
                                            <label class="label text-right" style="margin-top: 4px;"><?php echo $form2->labelEx($Attendance, 'attendance_in'); ?></label>                                        
                                        </td>
                                        <td colspan="1">
                                            <label class="input state-error">
                                                <?php echo $form2->textField($Attendance, 'attendance_in', array('class' => 'form-control datepicker', 'value' => date('Y-m-d'), 'data-dateformat' => 'yy-mm-dd', 'readonly' => true, 'placeholder' => 'Attendance Date')); ?>
                                            </label>                                        
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <footer>
                                <?php echo CHtml::submitButton('PROCESS STUDENT ATTENDANCE', array('class' => 'btn btn-primary')); ?>
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