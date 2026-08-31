<?php
/* @var $this CoaController */
/* @var $model Coa */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'coa-form',
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
                <label class="select">
                    <?php echo $form->labelEx($model, 'parent'); ?>
                    <?php echo $form->dropDownList($model, 'parent', CHtml::listData(Coa::model()->findAll(array('condition' => 'parent IS NULL OR parent=0', 'order' => "path")), 'id', 'account_title'), array('empty' => 'Select a Parent', 'class' => 'select2')); ?>
                    <?php echo $form->error($model, 'parent'); ?>
                </label>
            </section>
        </div>
        <div class="row">
            <section class="col col-6">
                <label class="label"><?php echo $form->labelEx($model, 'account_code'); ?></label>
                <label class="input">
                    <?php echo $form->textField($model, 'account_code', array('maxlength' => 250, 'class' => 'col-sm-12', 'placeholder' => 'Account Code')); ?>
                    <?php echo $form->error($model, 'account_code'); ?>
                </label>
            </section>
        </div>
        <div class="row">
            <section class="col col-6">
                <label class="label"><?php echo $form->labelEx($model, 'account_title'); ?></label>
                <label class="input">
                    <?php echo $form->textField($model, 'account_title', array('maxlength' => 250, 'class' => 'col-sm-12', 'placeholder' => 'Account Title')); ?>
                    <?php echo $form->error($model, 'account_title'); ?>
                </label>
            </section>
        </div>
        <div class="row">
            <section class="col col-6">
                <label class="label"><?php echo $form->labelEx($model, 'status'); ?></label>
                <label class="select">
                    <?php echo $form->dropDownList($model, 'status', array('Active' => 'Active', 'Inactive' => 'Inactive'), array('class' => 'select2')); ?>
                    <?php echo $form->error($model, 'status'); ?>
                </label>
            </section>
        </div>
    </fieldset>
    <footer>
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => 'btn btn-primary')); ?>
    </footer>
    <?php $this->endWidget(); ?>
</div><!-- form -->