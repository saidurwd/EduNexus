<?php
/* @var $this BannerController */
/* @var $model Banner */
/* @var $form CActiveForm */
?>

<div class="form">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'banner-form',
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
            <section class="col col-4">
                <label class="label"><?php echo $form->labelEx($model, 'category'); ?></label>
                <label class="select">
                    <?php echo $form->dropDownList($model, 'category', CHtml::listData(BannerCategory::model()->findAll(array('condition' => 'parent IS NULL', 'order' => "title")), 'id', 'title'), array('empty' => 'Select a Category', 'class' => 'select2')); ?>
                    <?php echo $form->error($model, 'category'); ?>
                </label>
            </section>
            <section class="col col-2">
                <label class="label"><?php echo $form->labelEx($model, 'status'); ?></label>
                <label class="select">
                    <?php echo $form->dropDownList($model, 'status', array('Active' => 'Active', 'Inactive' => 'Inactive'), array('class' => 'select2')); ?>
                    <?php echo $form->error($model, 'status'); ?>
                </label>
            </section>
            <section class="col col-1">
                <label class="label"><?php echo $form->labelEx($model, 'sticky'); ?></label>
                <label class="select">
                    <?php echo $form->dropDownList($model, 'sticky', array('Yes' => 'Yes', 'No' => 'No'), array('class' => 'select2')); ?>
                    <?php echo $form->error($model, 'sticky'); ?>
                </label>
            </section>
            <section class="col col-1">
                <label class="label"><?php echo $form->labelEx($model, 'ordering'); ?></label>
                <label class="input">
                    <?php echo $form->textField($model, 'ordering', array('maxlength' => 11, 'class' => 'col-sm-12', 'placeholder' => 'Ordering')); ?>
                    <?php echo $form->error($model, 'ordering'); ?>
                </label>
            </section>
        </div>
        <div class="row">
            <section class="col col-8">
                <label class="label"><?php echo $form->labelEx($model, 'title'); ?></label>
                <label class="input">
                    <?php echo $form->textField($model, 'title', array('maxlength' => 150, 'class' => 'col-sm-12', 'placeholder' => 'Title')); ?>
                    <?php echo $form->error($model, 'title'); ?>
                </label>
            </section>
        </div>
        <div class="row">       
            <section class="col col-8">
                <?php echo $form->labelEx($model, 'banner'); ?>
                <label for="file" class="input input-file" onchange="this.parentNode.nextSibling.value = this.value">
                    <div class="button"><?php echo $form->fileField($model, 'banner', array('class' => '', 'onchange' => 'this.parentNode.nextSibling.value = this.value')); ?>Browse</div><input type="text" placeholder="Browse file" readonly="">
                    <?php echo $form->error($model, 'banner'); ?>
                </label>
            </section>
        </div>
        <div class="row">
            <section class="col col-8">
                <label class="label"><?php echo $form->labelEx($model, 'clickurl'); ?></label>
                <label class="input">
                    <?php echo $form->textField($model, 'clickurl', array('maxlength' => 150, 'class' => 'col-sm-12', 'placeholder' => 'Click URL')); ?>
                    <?php echo $form->error($model, 'clickurl'); ?>
                </label>
            </section>
        </div>
        <div class="row">
            <section class="col col-8">
                <label class="label"><?php echo $form->labelEx($model, 'details'); ?></label>
                <label class="textarea textarea-resizable">
                    <?php echo $form->textArea($model, 'details', array('rows' => 4, 'class' => 'custom-scroll')); ?>                    
                    <?php echo $form->error($model, 'details'); ?>
                </label>
            </section>
        </div>
    </fieldset>
    <footer>
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => 'btn btn-primary')); ?>
    </footer>
    <?php $this->endWidget(); ?>
</div><!-- form -->