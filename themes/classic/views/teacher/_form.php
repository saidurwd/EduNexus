<?php
/* @var $this TeacherController */
/* @var $model Teacher */
/* @var $form CActiveForm */
?>

<div class="form">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'teacher-form',
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
                <label class="label"><?php echo $form->labelEx($model, 'teacher_name'); ?></label>
                <label class="input">
                    <?php echo $form->textField($model, 'teacher_name', array('maxlength' => 150, 'class' => 'col-sm-12', 'placeholder' => 'Teacher Name')); ?>
                    <?php echo $form->error($model, 'teacher_name'); ?>
                </label>
            </section>
        </div>
        <div class="row">
            <section class="col col-6">
                <label class="label"><?php echo $form->labelEx($model, 'designation'); ?></label>
                <label class="input">
                    <?php echo $form->textField($model, 'designation', array('maxlength' => 150, 'class' => 'col-sm-12', 'placeholder' => 'Designation')); ?>
                    <?php echo $form->error($model, 'designation'); ?>
                </label>
            </section>
        </div>
        <div class="row">
            <section class="col col-6">
                <label class="label"><?php echo $form->labelEx($model, 'birth_date'); ?></label>
                <label class="input">
                    <div class="input-group">
                        <?php echo $form->textField($model, 'birth_date', array('class' => 'col-sm-12 datepicker', 'placeholder' => 'Date of Birth', 'data-dateformat' => 'yy-mm-dd')); ?>
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                    </div>
                    <?php echo $form->error($model, 'birth_date'); ?>
                </label>
            </section>
        </div>
        <div class="row">
            <section class="col col-6">
                <label class="label"><?php echo $form->labelEx($model, 'gender'); ?></label>
                <label class="select">
                    <?php echo $form->dropDownList($model, 'gender', array('Male' => 'Male', 'Female' => 'Female', 'Other' => 'Other'), array('class' => 'select2')); ?>
                    <?php echo $form->error($model, 'gender'); ?>
                </label>
            </section>
        </div>
        <div class="row">
            <section class="col col-6">
                <label class="label"><?php echo $form->labelEx($model, 'religion'); ?></label>
                <label class="select">
                    <?php echo $form->dropDownList($model, 'religion', array('Islam' => 'Islam', 'Christianity' => 'Christianity', 'Hinduism' => 'Hinduism', 'Buddhism' => 'Buddhism'), array('class' => 'select2')); ?>
                    <?php echo $form->error($model, 'religion'); ?>
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
                    <?php echo $form->textField($model, 'phone', array('maxlength' => 11, 'class' => '', 'placeholder' => 'Phone')); ?>
                    <b class="tooltip tooltip-top-left"><i class="fa fa-warning txt-color-teal"></i> Mobile number without +880</b>
                    <?php echo $form->error($model, 'phone'); ?>
                </label>
            </section>
        </div>
        <div class="row">
            <section class="col col-6">
                <label class="label"><?php echo $form->labelEx($model, 'Address'); ?></label>
                <label class="input">
                    <?php echo $form->textField($model, 'Address', array('maxlength' => 250, 'class' => 'col-sm-12', 'placeholder' => 'Address')); ?>
                    <?php echo $form->error($model, 'Address'); ?>
                </label>
            </section>
        </div>
        <div class="row">
            <section class="col col-6">
                <label class="label"><?php echo $form->labelEx($model, 'joining_date'); ?></label>
                <label class="input">
                    <div class="input-group">
                        <?php echo $form->textField($model, 'joining_date', array('class' => 'col-sm-12 datepicker', 'placeholder' => 'Joining Date', 'data-dateformat' => 'yy-mm-dd')); ?>
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                    </div>
                    <?php echo $form->error($model, 'joining_date'); ?>
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