<?php
/* @var $this ExamScheduleController */
/* @var $model ExamSchedule */
/* @var $form CActiveForm */
?>

<div class="form">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'exam-schedule-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation' => false,
        'htmlOptions' => array('class' => 'smart-form'),
    ));
    Yii::app()->clientScript->registerScript('chained', '
    $(document).ready(function(){
        $("#ExamSchedule_section").chained("#ExamSchedule_class");
        $("#ExamSchedule_subject").chained("#ExamSchedule_class");
        $("#ExamSchedule_exam").chained("#ExamSchedule_class");
    });
', CClientScript::POS_END);
    ?>
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
                <label class="label"><?php echo $form->labelEx($model, 'class'); ?></label>
                <label class="input">
                    <?php echo $form->dropDownList($model, 'class', CHtml::listData(Classs::model()->findAll(array('condition' => 'status="Active" AND institution=' . Yii::app()->user->institution)), 'id', 'class'), array('empty' => 'Select Class', 'class' => 'select2')); ?>
                    <?php echo $form->error($model, 'class'); ?>
                </label>
            </section>
        </div>
        <div class="row">
            <section class="col col-6">
                <label class="label"><?php echo $form->labelEx($model, 'exam'); ?></label>
                <label class="input">
                    <?php echo Exam::getExam('ExamSchedule', 'exam', $model->exam); ?>
                    <?php echo $form->error($model, 'exam'); ?>
                </label>
            </section>
        </div>        
        <div class="row">
            <section class="col col-6">
                <label class="label"><?php echo $form->labelEx($model, 'section'); ?></label>
                <label class="input">
                    <?php //echo $form->dropDownList($model, 'section', CHtml::listData(Section::model()->findAll(array('condition' => 'status="Active" AND institution=' . Yii::app()->user->institution)), 'id', 'section'), array('empty' => 'Select Section', 'class' => 'select2')); ?>
                    <?php echo Section::getSection('ExamSchedule', 'section', $model->section); ?>
                    <?php echo $form->error($model, 'section'); ?>
                </label>
            </section>
        </div>
        <div class="row">
            <section class="col col-6">
                <label class="label"><?php echo $form->labelEx($model, 'subject'); ?></label>
                <label class="input">
                    <?php //echo $form->dropDownList($model, 'subject', CHtml::listData(Subject::model()->findAll(array('condition' => 'status="Active" AND institution=' . Yii::app()->user->institution)), 'id', 'subject'), array('empty' => 'Select Subject', 'class' => 'select2')); ?>
                    <?php echo Subject::getSubject('ExamSchedule', 'subject', $model->subject); ?>
                    <?php echo $form->error($model, 'subject'); ?>
                </label>
            </section>
        </div>
        <div class="row">
            <section class="col col-6">
                <label class="label"><?php echo $form->labelEx($model, 'exam_date'); ?></label>
                <label class="input">
                    <div class="input-group">
                        <?php echo $form->textField($model, 'exam_date', array('class' => 'col-sm-12 datepicker', 'placeholder' => 'Exam Date', 'data-dateformat' => 'yy-mm-dd')); ?>
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                    </div>
                    <?php echo $form->error($model, 'exam_date'); ?>
                </label>
            </section>
        </div>
        <div class="row">
            <section class="col col-6">
                <label class="label"><?php echo $form->labelEx($model, 'time_from'); ?></label>
                <label class="input">
                    <?php echo $form->textField($model, 'time_from', array('maxlength' => 8, 'class' => 'col-sm-12', 'placeholder' => 'Time From')); ?>
                    <?php echo $form->error($model, 'time_from'); ?>
                </label>
            </section>
        </div>               
        <div class="row">
            <section class="col col-6">
                <label class="label"><?php echo $form->labelEx($model, 'time_to'); ?></label>
                <label class="input">
                    <?php echo $form->textField($model, 'time_to', array('maxlength' => 8, 'class' => 'col-sm-12', 'placeholder' => 'Time To')); ?>
                    <?php echo $form->error($model, 'time_to'); ?>
                </label>
            </section>
        </div>
        <div class="row">
            <section class="col col-6">
                <label class="label"><?php echo $form->labelEx($model, 'room'); ?></label>
                <label class="input">
                    <?php echo $form->textField($model, 'room', array('maxlength' => 11, 'class' => 'col-sm-12', 'placeholder' => 'Room')); ?>
                    <?php echo $form->error($model, 'room'); ?>
                </label>
            </section>
        </div>     
        <?= Institution::getAlertWarning('Note:', 'Create relevant Class, Exam, Section &amp; Subject before you add Exam Schedule.') ?>
    </fieldset>
    <footer>
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => 'btn btn-primary')); ?>
    </footer>
    <?php $this->endWidget(); ?>
</div><!-- form -->