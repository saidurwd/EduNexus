<?php
/* @var $this AttendanceTeacherController */
/* @var $model AttendanceTeacher */
/* @var $form CActiveForm */
?>

<div class="wide form">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'htmlOptions' => array('class' => 'smart-form'),
    ));
    ?>
    <fieldset>      
        <div class="row">
            <section class="col col-6">
                <label class="label"><?php echo $form->labelEx($model, 'teacher'); ?></label>
                <label class="input">
                    <?php echo $form->dropDownList($model, 'teacher', CHtml::listData(Teacher::model()->findAll(array('condition' => 'institution=' . Yii::app()->user->institution . ' AND status="Active"')), 'id', 'teacher_name'), array('empty' => 'Select Name', 'class' => 'select2')); ?>
                    <?php echo $form->error($model, 'teacher'); ?>
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