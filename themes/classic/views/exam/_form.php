<?php
/* @var $this ExamController */
/* @var $model Exam */
/* @var $form CActiveForm */
?>

<div class="form">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'exam-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation' => false,
        'htmlOptions' => array('class' => 'smart-form'),
    ));
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
                <label class="label"><?php echo $form->labelEx($model, 'academic_year'); ?></label>
                <label class="input">
                    <?php echo $form->dropDownList($model, 'academic_year', CHtml::listData(AcademicYear::model()->findAll(array('condition' => 'institution=' . Yii::app()->user->institution)), 'id', 'title'), array('empty' => 'Select Year', 'class' => 'select2')); ?>
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
                <label class="label"><?php echo $form->labelEx($model, 'exam_name'); ?></label>
                <label class="input">
                    <?php echo $form->textField($model, 'exam_name', array('maxlength' => 150, 'class' => 'col-sm-12', 'placeholder' => 'Exam Name')); ?>
                    <?php echo $form->error($model, 'exam_name'); ?>
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
                <label class="label"><?php echo $form->labelEx($model, 'result'); ?></label>
                <label class="select">
                    <?php echo $form->dropDownList($model, 'result', array('PROCESSING' => 'PROCESSING', 'PUBLISHED' => 'PUBLISHED'), array('class' => 'select2')); ?>
                    <?php echo $form->error($model, 'result'); ?>
                </label>
            </section>
        </div>
        <div class="row">
            <section class="col col-6">
                <label class="label"><?php echo $form->labelEx($model, 'status'); ?></label>
                <label class="select">
                    <?php echo $form->dropDownList($model, 'status', array('ACTIVE' => 'ACTIVE', 'INACTIVE' => 'INACTIVE'), array('class' => 'select2')); ?>
                    <?php echo $form->error($model, 'status'); ?>
                </label>
            </section>
        </div>        
        <div class="row">
            <section class="col col-6">
                <label class="label"><?php echo $form->labelEx($model, 'note'); ?></label>
                <label class="input">
                    <?php echo $form->textField($model, 'note', array('maxlength' => 250, 'class' => 'col-sm-12', 'placeholder' => 'Note')); ?>
                    <?php echo $form->error($model, 'note'); ?>
                </label>
            </section>
        </div>
        <?= Institution::getAlertWarning('Note:', 'Create relevant Class before you add Exam.') ?>
    </fieldset>
    <footer>
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => 'btn btn-primary')); ?>
    </footer>
    <?php $this->endWidget(); ?>
</div><!-- form -->