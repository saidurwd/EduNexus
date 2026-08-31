<?php
/* @var $this GradeController */
/* @var $model Grade */
/* @var $form CActiveForm */
?>
<div class="form">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'grade-form',
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
                <label class="label"><?php echo $form->labelEx($model, 'class'); ?></label>
                <label class="input">
                    <?php echo $form->dropDownList($model, 'class', CHtml::listData(Classs::model()->findAll(array('condition' => 'status="Active" AND institution=' . Yii::app()->user->institution)), 'id', 'class'), array('empty' => 'Select Class', 'class' => 'select2')); ?>
                    <?php echo $form->error($model, 'class'); ?>
                </label>
            </section>
        </div>
        <div class="row">
            <section class="col col-6">
                <label class="label"><?php echo $form->labelEx($model, 'grade_name'); ?></label>
                <label class="input">
                    <?php echo $form->textField($model, 'grade_name', array('maxlength' => 50, 'class' => 'col-sm-12', 'placeholder' => 'Grade')); ?>
                    <?php echo $form->error($model, 'grade_name'); ?>
                </label>
            </section>
        </div>
        <div class="row">
            <section class="col col-6">
                <label class="label"><?php echo $form->labelEx($model, 'grade_point'); ?></label>
                <label class="input">
                    <?php echo $form->textField($model, 'grade_point', array('maxlength' => 11, 'class' => 'col-sm-12', 'placeholder' => 'Grade Point')); ?>
                    <?php echo $form->error($model, 'grade_point'); ?>
                </label>
            </section>
        </div>
        <div class="row">
            <section class="col col-6">
                <label class="label"><?php echo $form->labelEx($model, 'mark_from'); ?></label>
                <label class="input">
                    <?php echo $form->textField($model, 'mark_from', array('maxlength' => 11, 'class' => 'col-sm-12', 'placeholder' => 'Mark From')); ?>
                    <?php echo $form->error($model, 'mark_from'); ?>
                </label>
            </section>
        </div>
        <div class="row">
            <section class="col col-6">
                <label class="label"><?php echo $form->labelEx($model, 'mark_upto'); ?></label>
                <label class="input">
                    <?php echo $form->textField($model, 'mark_upto', array('maxlength' => 11, 'class' => 'col-sm-12', 'placeholder' => 'Mark To')); ?>
                    <?php echo $form->error($model, 'mark_upto'); ?>
                </label>
            </section>
        </div>
        <div class="row">
            <section class="col col-6">
                <label class="label"><?php echo $form->labelEx($model, 'Note'); ?></label>
                <label class="input">
                    <?php echo $form->textField($model, 'Note', array('maxlength' => 250, 'class' => 'col-sm-12', 'placeholder' => 'Note')); ?>
                    <?php echo $form->error($model, 'Note'); ?>
                </label>
            </section>
        </div>
        <?= Institution::getAlertWarning('Note:', 'Create relevant Class before you add Grade.') ?>
    </fieldset>
    <footer>
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => 'btn btn-primary')); ?>
    </footer>
    <?php $this->endWidget(); ?>
</div><!-- form -->