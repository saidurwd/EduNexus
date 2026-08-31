<?php
/* @var $this ParentsController */
/* @var $model Parents */
/* @var $form CActiveForm */
?>

<div class="form">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'parents-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation' => false,
        'htmlOptions' => array('class' => 'smart-form', 'enctype' => 'multipart/form-data'),
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
                <label class="label"><?php echo $form->labelEx($model, 'guardian_name'); ?></label>
                <label class="input">
                    <?php echo $form->textField($model, 'guardian_name', array('maxlength' => 150, 'class' => 'col-sm-12', 'placeholder' => 'Guardian Name')); ?>
                    <?php echo $form->error($model, 'guardian_name'); ?>
                </label>
            </section>
        </div>
        <div class="row">
            <section class="col col-6">
                <label class="label"><?php echo $form->labelEx($model, 'father'); ?></label>
                <label class="input">
                    <?php echo $form->textField($model, 'father', array('maxlength' => 150, 'class' => 'col-sm-12', 'placeholder' => 'Father')); ?>
                    <?php echo $form->error($model, 'father'); ?>
                </label>
            </section>
        </div>
        <div class="row">
            <section class="col col-6">
                <label class="label"><?php echo $form->labelEx($model, 'mother'); ?></label>
                <label class="input">
                    <?php echo $form->textField($model, 'mother', array('maxlength' => 150, 'class' => 'col-sm-12', 'placeholder' => 'Mother')); ?>
                    <?php echo $form->error($model, 'mother'); ?>
                </label>
            </section>
        </div>
        <div class="row">
            <section class="col col-6">
                <label class="label"><?php echo $form->labelEx($model, 'father_profession'); ?></label>
                <label class="input">
                    <?php echo $form->textField($model, 'father_profession', array('maxlength' => 150, 'class' => 'col-sm-12', 'placeholder' => 'Father Profession')); ?>
                    <?php echo $form->error($model, 'father_profession'); ?>
                </label>
            </section>
        </div>
        <div class="row">
            <section class="col col-6">
                <label class="label"><?php echo $form->labelEx($model, 'mother_profession'); ?></label>
                <label class="input">
                    <?php echo $form->textField($model, 'mother_profession', array('maxlength' => 150, 'class' => 'col-sm-12', 'placeholder' => 'Mother Profession')); ?>
                    <?php echo $form->error($model, 'mother_profession'); ?>
                </label>
            </section>
        </div>
        <div class="row">
            <section class="col col-6">
                <label class="label"><?php echo $form->labelEx($model, 'email'); ?></label>
                <label class="input">
                    <i class="icon-prepend fa fa-envelope"></i>
                    <?php echo $form->textField($model, 'email', array('maxlength' => 150, 'class' => '', 'placeholder' => 'Email')); ?>
                    <?php echo $form->error($model, 'email'); ?>
                </label>
            </section>
        </div>
        <div class="row">
            <section class="col col-6">
                <label class="label"><?php echo $form->labelEx($model, 'phone'); ?></label>
                <label class="input">
                    <i class="icon-prepend fa fa-mobile-phone"></i>
                    <?php echo $form->textField($model, 'phone', array('maxlength' => 10, 'class' => '', 'placeholder' => 'Phone')); ?>
                    <b class="tooltip tooltip-top-left"><i class="fa fa-warning txt-color-teal"></i> Mobile number without +880</b>
                    <?php echo $form->error($model, 'phone'); ?>                    
                </label>
            </section>
        </div>
        <div class="row">
            <section class="col col-6">
                <label class="label"><?php echo $form->labelEx($model, 'address'); ?></label>
                <label class="input">
                    <?php echo $form->textField($model, 'address', array('maxlength' => 250, 'class' => 'col-sm-12', 'placeholder' => 'Address')); ?>
                    <?php echo $form->error($model, 'address'); ?>
                </label>
            </section>
        </div>
        <div class="row">
            <section class="col col-6">
                <label class="label"><?php echo $form->labelEx($model, 'photo'); ?></label>
                <label for="file" class="input input-file" onchange="this.parentNode.nextSibling.value = this.value">
                    <div class="button"><?php echo $form->fileField($model, 'photo', array('class' => '', 'onchange' => 'this.parentNode.nextSibling.value = this.value')); ?>Browse</div><input type="text" placeholder="Browse file" readonly="">
                    <?php echo $form->error($model, 'photo'); ?>
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