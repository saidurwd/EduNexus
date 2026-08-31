<?php
/* @var $this CategoryController */
/* @var $model Category */
/* @var $form CActiveForm */
?>

<div class="form">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'category-form',
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
                <label class="label"><?php echo $form->labelEx($model, 'parent'); ?></label>
                <label class="select">
                    <?php echo $form->dropDownList($model, 'parent', CHtml::listData(Category::model()->findAll(array('condition' => '(parent IS NULL OR parent=0) AND (institution=0 OR institution=' . Yii::app()->user->institution . ')', 'order' => "title")), 'id', 'title'), array('empty' => 'Select a Category', 'class' => 'select2')); ?>
                    <?php echo $form->error($model, 'parent'); ?>
                </label>
            </section>
            <section class="col col-2">
                <label class="label"><?php echo $form->labelEx($model, 'status'); ?></label>
                <label class="select">
                    <?php echo $form->dropDownList($model, 'status', array('Active' => 'Active', 'Inactive' => 'Inactive'), array('class' => 'select2')); ?>
                    <?php echo $form->error($model, 'status'); ?>
                </label>
            </section>
        </div>
        <div class="row">
            <section class="col col-8">
                <label class="label"><?php echo $form->labelEx($model, 'title'); ?></label>
                <label class="input">
                    <?php echo $form->textField($model, 'title', array('maxlength' => 150, 'class' => 'col-sm-12', 'placeholder' => 'Category')); ?>
                    <?php echo $form->error($model, 'title'); ?>
                </label>
            </section>
        </div>
        <div class="row">
            <section class="col col-8">
                <label class="label"><?php echo $form->labelEx($model, 'details'); ?></label>
                <label class="input">
                    <?php //echo $form->textArea($model, 'details', array('rows' => 6, 'cols' => 50, 'class' => 'col-sm-12')); ?>                    
                    <?php
                    $this->widget('application.extensions.yii-ckeditor.CKEditorWidget', array(
                        'model' => $model,
                        'attribute' => 'details',
                        // editor options http://docs.ckeditor.com/#!/api/CKEDITOR.config
                        'config' => array(
                            'language' => 'en',
                            'toolbar' => 'Basic',
                        ),
                    ));
                    ?>
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