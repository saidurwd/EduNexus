<?php
/* @var $this StudentLeaveController */
/* @var $model StudentLeave */
/* @var $form CActiveForm */
?>

<div class="form">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'student-leave-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation' => false,
        'htmlOptions' => array('class' => 'smart-form', 'enctype' => 'multipart/form-data'),
    ));
    Yii::app()->clientScript->registerScript('chained', '
    $(document).ready(function(){
        $("#StudentLeave_section").chained("#StudentLeave_class");
        $("#StudentLeave_student").chained("#StudentLeave_section");
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
            <section class="col col-3">
                <label class="label"><?php echo $form->labelEx($model, 'class'); ?></label>
                <label class="input">
                    <?php echo $form->dropDownList($model, 'class', CHtml::listData(Classs::model()->findAll(array('condition' => 'status="Active" AND institution=' . Yii::app()->user->institution)), 'id', 'class'), array('empty' => 'Select Class', 'class' => 'select2')); ?>
                    <?php echo $form->error($model, 'class'); ?>
                </label>
            </section>
            <section class="col col-3">
                <label class="label"><?php echo $form->labelEx($model, 'section'); ?></label>
                <label class="input">
                    <?php echo Section::getSection('StudentLeave', 'section', $model->section); ?>
                    <?php echo $form->error($model, 'section'); ?>
                </label>
            </section>
        </div>
        <div class="row">
            <section class="col col-4">
                <label class="label"><?php echo $form->labelEx($model, 'student'); ?></label>
                <label class="input">
                    <?php echo Student::getStudentBySection('StudentLeave', 'student', $model->student); ?>
                    <?php echo $form->error($model, 'student'); ?>
                </label>
            </section>
            <section class="col col-2">
                <label class="label"><?php echo $form->labelEx($model, 'status'); ?></label>
                <label class="select">
                    <?php echo $form->dropDownList($model, 'status', array('PENDING' => 'PENDING', 'ACCEPTED' => 'ACCEPTED', 'DECLINE' => 'DECLINE'), array('class' => 'select2')); ?>
                    <?php echo $form->error($model, 'status'); ?>
                </label>
            </section>
        </div>
        <div class="row">
            <section class="col col-6">
                <label class="label"><?php echo $form->labelEx($model, 'reason'); ?></label>
                <label class="input">
                    <?php echo $form->textField($model, 'reason', array('maxlength' => 150, 'class' => '', 'placeholder' => 'Reason')); ?>
                    <?php echo $form->error($model, 'reason'); ?>
                </label>
            </section>
        </div>
        <div class="row">
            <section class="col col-3">
                <label class="label"><?php echo $form->labelEx($model, 'start_date'); ?></label>
                <label class="input">
                    <div class="input-group">
                        <?php echo $form->textField($model, 'start_date', array('class' => 'col-sm-12 datepicker', 'placeholder' => 'Start Date', 'data-dateformat' => 'yy-mm-dd')); ?>
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                    </div>
                    <?php echo $form->error($model, 'start_date'); ?>
                </label>
            </section>
            <section class="col col-3">
                <label class="label"><?php echo $form->labelEx($model, 'end_date'); ?></label>
                <label class="input">
                    <div class="input-group">
                        <?php echo $form->textField($model, 'end_date', array('class' => 'col-sm-12 datepicker', 'placeholder' => 'Start Date', 'data-dateformat' => 'yy-mm-dd')); ?>
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                    </div>
                    <?php echo $form->error($model, 'end_date'); ?>
                </label>
            </section>
        </div>
        <div class="row">
            <section class="col col-6">
                <label class="label"><?php echo $form->labelEx($model, 'message'); ?></label>
                <label class="textarea textarea-resizable">
                    <?php echo $form->textArea($model, 'message', array('rows' => 4, 'class' => 'custom-scroll')); ?>                    
                    <?php echo $form->error($model, 'message'); ?>
                </label>
            </section>
        </div>
    </fieldset>
    <footer>
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => 'btn btn-primary')); ?>
    </footer> 
    <?php $this->endWidget(); ?>

</div><!-- form -->