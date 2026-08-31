<?php
/* @var $this AttendanceController */
/* @var $model Attendance */
/* @var $form CActiveForm */
?>

<div class="wide form">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'htmlOptions' => array('class' => 'smart-form'),
    ));
    Yii::app()->clientScript->registerScript('chained', '
    $(document).ready(function(){
        $("#Attendance_exam").chained("#Attendance_class");
        $("#Attendance_section").chained("#Attendance_class");
        $("#Attendance_group").chained("#Attendance_class");
    });
    ', CClientScript::POS_END);
    ?>
    <fieldset>
        <div class="row">
            <section class="col col-6">
                <label class="label"><?php echo $form->labelEx($model, 'class'); ?></label>
                <label class="input">
                    <?php echo $form->dropDownList($model, 'class', CHtml::listData(Classs::model()->findAll(array('condition' => 'status="Active" AND institution=' . Yii::app()->user->institution)), 'id', 'class'), array('empty' => 'Select Class', 'class' => 'select2')); ?>
                    <?php echo $form->error($model, 'class'); ?>
                </label>
            </section>
            <section class="col col-6">
                <label class="label"><?php echo $form->labelEx($model, 'section'); ?></label>
                <label class="input">
                    <?php echo Section::getSection('Attendance', 'section', $model->section); ?>
                    <?php echo $form->error($model, 'section'); ?>
                </label>
            </section>
        </div>
        <div class="row">
            <section class="col col-6">
                <label class="label"><?php echo $form->labelEx($model, 'group'); ?></label>
                <label class="input">
                    <?php echo StudentGroup::getStudentGroup('Attendance', 'group', $model->group); ?>
                    <?php echo $form->error($model, 'group'); ?>
                </label>
            </section>
            <section class="col col-6">
                <label class="label"><?php echo $form->labelEx($model, 'academic_year'); ?></label>
                <label class="input">
                    <?php echo $form->dropDownList($model, 'academic_year', CHtml::listData(AcademicYear::model()->findAll(array('condition' => 'institution=' . Yii::app()->user->institution)), 'id', 'title'), array('empty' => 'Select Year', 'class' => 'select2')); ?>
                    <?php echo $form->error($model, 'academic_year'); ?>
                </label>
            </section>
        </div>
        <div class="row">
            <section class="col col-6">
                <label class="label"><?php echo $form->labelEx($model, 'student'); ?></label>
                <label class="input">
                    <?php echo $form->dropDownList($model, 'student', CHtml::listData(Student::model()->findAll(array('condition' => 'institution=' . Yii::app()->user->institution)), 'id', 'name'), array('empty' => 'Select Name', 'class' => 'select2')); ?>
                    <?php echo $form->error($model, 'student'); ?>
                </label>
            </section>
            <section class="col col-6">
                <label class="label"><?php echo $form->labelEx($model, 'attendance'); ?></label>
                <label class="select">
                    <?php echo $form->dropDownList($model, 'attendance', array('Present' => 'Present', 'Late Present With Excuse' => 'Late Present With Excuse', 'Late Present' => 'Late Present', 'Absent' => 'Absent', 'Half Day' => 'Half Day'), array('class' => 'select2')); ?>
                    <?php echo $form->error($model, 'attendance'); ?>
                </label>
            </section>
        </div>
        <div class="row">
            <section class="col col-6">
                <label class="label"><?php echo $form->labelEx($model, 'attendance_in'); ?></label>
                <label class="input">
                    <?php echo $form->textField($model, 'attendance_in', array('class' => 'col-sm-12 datepicker', 'placeholder' => 'Attendance IN')); ?>
                    <?php echo $form->error($model, 'attendance_in'); ?>
                </label>
            </section>
            <section class="col col-6">
                <label class="label"><?php echo $form->labelEx($model, 'attendance_out'); ?></label>
                <label class="input">
                    <?php echo $form->textField($model, 'attendance_out', array('class' => 'col-sm-12 datepicker', 'placeholder' => 'Attendance Out')); ?>
                    <?php echo $form->error($model, 'attendance_out'); ?>
                </label>
            </section>
        </div>
    </fieldset>
    <footer>
        <?php echo CHtml::submitButton('Search', array('class' => 'btn btn-primary')); ?>
    </footer>
    <?php $this->endWidget(); ?>
</div><!-- search-form -->