<?php
/* @var $this AttendanceTeacherController */
/* @var $model AttendanceTeacher */
/* @var $form CActiveForm */
?>

<div class="form">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'attendance-teacher-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation' => false,
        'htmlOptions' => array('class' => 'smart-form'),
    ));
    ?>
    <script>
        $(function () {
            $('.datepicker').datepicker({dateFormat: "yy-mm-dd"});
        });
    </script>
    <fieldset>
        <div class="row">
            <section class="col col-12">
                <p class="note">Fields with <span class="required">*</span> are required.</p>
            </section>
        </div>
        <div class="row">
            <section class="col col-12">
                <?php echo $form->errorSummary($model, '<i class="fa fa-bell text-danger"></i> Please fix the following input errors:', '', array('class' => 'text-danger', 'style' => 'padding-left:20px;')); ?>
            </section>
        </div>          
        <div class="row">
            <section class="col col-6">
                <label class="label"><?php echo $form->labelEx($model, 'teacher'); ?></label>
                <label class="input">
                    <?php echo $form->dropDownList($model, 'teacher', CHtml::listData(Teacher::model()->findAll(array('condition' => 'institution=' . Yii::app()->user->institution . ' AND status="Active"')), 'id', 'teacher_name'), array('empty' => 'Select Name', 'class' => 'select2')); ?>
                    <?php echo $form->error($model, 'teacher'); ?>
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
        </div>
        <div class="row">
            <section class="col col-6">
                <label class="label"><?php echo $form->labelEx($model, 'attendance_out'); ?></label>
                <label class="input">
                    <?php echo $form->textField($model, 'attendance_out', array('class' => 'col-sm-12 datepicker', 'placeholder' => 'Attendance Out')); ?>
                    <?php echo $form->error($model, 'attendance_out'); ?>
                </label>
            </section>
        </div>
        <div class="row">
            <section class="col col-6">
                <label class="label"><?php echo $form->labelEx($model, 'attendance'); ?></label>
                <label class="select">
                    <?php echo $form->dropDownList($model, 'attendance', array('Present' => 'Present', 'Late Present With Excuse' => 'Late Present With Excuse', 'Late Present' => 'Late Present', 'Absent' => 'Absent', 'Half Day' => 'Half Day'), array('class' => 'select2')); ?>
                    <?php echo $form->error($model, 'attendance'); ?>
                </label>
            </section>
        </div>
    </fieldset>
    <footer>
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => 'btn btn-primary')); ?>
    </footer>
    <?php $this->endWidget(); ?>
</div><!-- form -->