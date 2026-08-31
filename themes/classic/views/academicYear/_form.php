<?php
/* @var $this AcademicYearController */
/* @var $model AcademicYear */
/* @var $form CActiveForm */
?>

<div class="form">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'academic-year-form',
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
                <label class="label"><?php echo $form->labelEx($model, 'year'); ?></label>
                <label class="input">
                    <?php echo $form->textField($model, 'year', array('maxlength' => 150, 'class' => 'col-sm-12', 'placeholder' => 'Year')); ?>
                    <?php echo $form->error($model, 'year'); ?>
                </label>
            </section>
        </div>
        <div class="row">
            <section class="col col-6">
                <label class="label"><?php echo $form->labelEx($model, 'title'); ?></label>
                <label class="input">
                    <?php echo $form->textField($model, 'title', array('maxlength' => 150, 'class' => 'col-sm-12', 'placeholder' => 'Year Title')); ?>
                    <?php echo $form->error($model, 'title'); ?>
                </label>
            </section>
        </div>
        <div class="row">
            <section class="col col-6">
                <label class="label"><?php echo $form->labelEx($model, 'starting_date'); ?></label>
                <label class="input">
                    <div class="input-group">
                        <?php echo $form->textField($model, 'starting_date', array('class' => 'col-sm-12 datepicker', 'placeholder' => 'Starting Date', 'data-dateformat' => 'yy-mm-dd')); ?>
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                    </div>
                    <?php echo $form->error($model, 'starting_date'); ?>
                </label>
            </section>
        </div>
        <div class="row">
            <section class="col col-6">
                <label class="label"><?php echo $form->labelEx($model, 'ending_date'); ?></label>
                <label class="input">
                    <div class="input-group">
                        <?php echo $form->textField($model, 'ending_date', array('class' => 'col-sm-12 datepicker', 'placeholder' => 'Ending Date', 'data-dateformat' => 'yy-mm-dd')); ?>
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                    </div>
                    <?php echo $form->error($model, 'ending_date'); ?>
                </label>
            </section>
        </div>
        <div class="row">
            <section class="col col-6">
                <label class="label"><?php echo $form->labelEx($model, 'default'); ?></label>
                <label class="select">
                    <?php echo $form->dropDownList($model, 'default', array('Yes' => 'Yes', 'No' => 'No'), array('class' => 'select2')); ?>
                    <?php echo $form->error($model, 'default'); ?>
                </label>
            </section>
        </div>
    </fieldset>
    <footer>
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => 'btn btn-primary')); ?>
    </footer>
    <?php $this->endWidget(); ?>
</div><!-- form -->