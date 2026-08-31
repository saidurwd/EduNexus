<?php
/* @var $this SectionController */
/* @var $model Section */
/* @var $form CActiveForm */
?>

<div class="form">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'section-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation' => false,
        'htmlOptions' => array('class' => 'smart-form'),
    ));
    Yii::app()->clientScript->registerScript('chained', '
    $(document).ready(function(){
        $("#Section_shift").chained("#Section_class");
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
                <label class="label"><?php echo $form->labelEx($model, 'shift'); ?></label>
                <label class="input">
                    <?php echo Shift::getShift('Section', 'shift', $model->shift); ?>
                    <?php echo $form->error($model, 'shift'); ?>
                </label>
            </section>
        </div>
        <div class="row">
            <section class="col col-6">
                <label class="label"><?php echo $form->labelEx($model, 'section'); ?></label>
                <label class="input">
                    <?php echo $form->textField($model, 'section', array('maxlength' => 150, 'class' => 'col-sm-12', 'placeholder' => 'Section')); ?>
                    <?php echo $form->error($model, 'section'); ?>
                </label>
            </section>
        </div>
        <div class="row">
            <section class="col col-6">
                <label class="label"><?php echo $form->labelEx($model, 'category'); ?></label>
                <label class="input">
                    <?php echo $form->textField($model, 'category', array('maxlength' => 150, 'class' => 'col-sm-12', 'placeholder' => 'Category')); ?>
                    <?php echo $form->error($model, 'category'); ?>
                </label>
            </section>
        </div>
        <div class="row">
            <section class="col col-6">
                <label class="label"><?php echo $form->labelEx($model, 'capacity'); ?></label>
                <label class="input">
                    <?php echo $form->textField($model, 'capacity', array('maxlength' => 11, 'class' => 'col-sm-12', 'placeholder' => 'Capacity')); ?>
                    <?php echo $form->error($model, 'capacity'); ?>
                </label>
            </section>
        </div>
        <div class="row">
            <section class="col col-6">
                <label class="label"><?php echo $form->labelEx($model, 'teacher'); ?></label>
                <label class="input">
                    <?php echo $form->dropDownList($model, 'teacher', CHtml::listData(Teacher::model()->findAll(array('condition' => 'institution=' . Yii::app()->user->institution)), 'id', 'teacher_name'), array('empty' => 'Select Teacher', 'class' => 'select2')); ?>
                    <?php echo $form->error($model, 'teacher'); ?>
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
        <div class="row">
            <section class="col col-6">
                <label class="label"><?php echo $form->labelEx($model, 'status'); ?></label>
                <label class="select">
                    <?php echo $form->dropDownList($model, 'status', array('Active' => 'Active', 'Inactive' => 'Inactive'), array('class' => 'select2')); ?>
                    <?php echo $form->error($model, 'status'); ?>
                </label>
            </section>
        </div>
        <?= Institution::getAlertWarning('Note:', 'Create relevant Teacher, Shift &amp; Class before you add Section.') ?>
    </fieldset>
    <footer>
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => 'btn btn-primary')); ?>
    </footer>
    <?php $this->endWidget(); ?>
</div><!-- form -->