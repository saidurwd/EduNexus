<?php
/* @var $this RoutineController */
/* @var $model Routine */
/* @var $form CActiveForm */
?>

<div class="form">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'routine-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'htmlOptions' => array('class' => 'smart-form'),
    ));
    Yii::app()->clientScript->registerScript('chained', '
    $(document).ready(function(){
        $("#Routine_section").chained("#Routine_class");
        $("#Routine_subject").chained("#Routine_class");
    });
', CClientScript::POS_END);
    ?>
    <fieldset>            
        <p class="note">Fields with <span class="required">*</span> are required.</p>
        <div class="row">
            <section class="col col-12">
                <?php echo $form->errorSummary($model, '<i class="fa fa-bell text-danger"></i> Please fix the following input errors:', '', array('class' => 'text-danger', 'style' => 'padding-left:20px;')); ?>
            </section>
        </div>  
        <div class="row">
            <section class="col col-6">
                <label class="label"><?php echo $form->labelEx($model, 'academic_year'); ?></label>
                <label class="input">
                    <?php echo $form->dropDownList($model, 'academic_year', CHtml::listData(AcademicYear::model()->findAll(array('condition' => 'institution=' . Yii::app()->user->institution)), 'id', 'title'), array('empty' => 'Select Academic Year', 'class' => 'select2')); ?>
                    <?php echo $form->error($model, 'academic_year'); ?>
                </label>
            </section>
        </div>
        <div class="row">
            <section class="col col-6">
                <label class="label"><?php echo $form->labelEx($model, 'class'); ?></label>
                <label class="input">
                    <?php echo $form->dropDownList($model, 'class', CHtml::listData(Classs::model()->findAll(array('condition' => 'status="Active" AND institution=' . Yii::app()->user->institution)), 'id', 'class'), array('empty' => 'Select Class', 'class' => 'select2')); ?>
                    <?php echo $form->error($model, 'class'); ?>
                </label>
            </section>
        </div>
        <div class="row">
            <section class="col col-6">
                <label class="label"><?php echo $form->labelEx($model, 'section'); ?></label>
                <label class="input">
                    <?php echo Section::getSection('Routine', 'section', $model->section); ?>
                    <?php echo $form->error($model, 'section'); ?>
                </label>
            </section>
        </div>
        <div class="row">
            <section class="col col-6">
                <label class="label"><?php echo $form->labelEx($model, 'subject'); ?></label>
                <label class="input">
                    <?php echo Subject::getSubject('Routine', 'subject', $model->subject); ?>
                    <?php echo $form->error($model, 'subject'); ?>
                </label>
            </section>
        </div>
        <div class="row">
            <section class="col col-6">
                <label class="label"><?php echo $form->labelEx($model, 'day'); ?></label>
                <label class="select">
                    <?php echo $form->dropDownList($model, 'day', array('SATURDAY' => 'SATURDAY', 'SUNDAY' => 'SUNDAY', 'MONDAY' => 'MONDAY', 'TUESDAY' => 'TUESDAY', 'WEDNESDAY' => 'WEDNESDAY', 'THURSDAY' => 'THURSDAY', 'FRIDAY' => 'FRIDAY'), array('class' => 'select2')); ?>
                    <?php echo $form->error($model, 'day'); ?>
                </label>
            </section>
        </div>
        <div class="row">
            <section class="col col-6">
                <label class="label"><?php echo $form->labelEx($model, 'teacher'); ?></label>
                <label class="input">
                    <?php echo $form->dropDownList($model, 'teacher', CHtml::listData(Teacher::model()->findAll(array('condition' => 'institution=' . Yii::app()->user->institution)), 'id', 'teacher_name'), array('empty' => 'Select Teacher', 'class' => 'select2')); ?>
                    <?php echo $form->error($model, 'teacher'); ?>
                </label>
            </section>
        </div>
        <div class="row">
            <section class="col col-6">
                <label class="label"><?php echo $form->labelEx($model, 'starting_time'); ?></label>
                <div class="input-group">
                    <?php echo $form->textField($model, 'starting_time', array('maxlength' => 50, 'class' => 'form-control', 'placeholder' => ' Starting Time')); ?>
                    <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                    <?php echo $form->error($model, 'starting_time'); ?>
                </div>
            </section>
        </div>  
        <div class="row">
            <section class="col col-6">
                <label class="label"><?php echo $form->labelEx($model, 'ending_time'); ?></label>
                <div class="input-group">
                    <?php echo $form->textField($model, 'ending_time', array('maxlength' => 50, 'class' => 'form-control', 'placeholder' => ' Ending Time')); ?>
                    <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                    <?php echo $form->error($model, 'ending_time'); ?>
                </div>
            </section>
        </div> 
        <div class="row">
            <section class="col col-6">
                <label class="label"><?php echo $form->labelEx($model, 'room'); ?></label>
                <label class="input">
                    <?php echo $form->textField($model, 'room', array('maxlength' => 50, 'class' => 'col-sm-12', 'placeholder' => 'Room')); ?>
                    <?php echo $form->error($model, 'room'); ?>
                </label>
            </section>
        </div>  
        <?= Institution::getAlertWarning('Note:', 'Create relevant Academic Year, Teacher, Class, Section &amp; Subject before you add Routine.') ?>
    </fieldset>
    <footer>
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => 'btn btn-primary')); ?>
    </footer>
    <?php $this->endWidget(); ?>
</div><!-- form -->