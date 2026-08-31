<?php
/* @var $this SubjectController */
/* @var $model Subject */
/* @var $form CActiveForm */
?>

<div class="form">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'subject-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation' => false,
        'htmlOptions' => array('class' => 'smart-form'),
    ));
    Yii::app()->clientScript->registerScript('chained', '
    $(document).ready(function(){
        $("#Subject_student_group").chained("#Subject_class");
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
                <label class="label"><?php echo $form->labelEx($model, 'type'); ?></label>
                <label class="select">
                    <?php echo $form->dropDownList($model, 'type', array('COMPULSARY' => 'COMPULSARY', 'CHOOSABLE' => 'CHOOSABLE', 'GROUP BASED' => 'GROUP BASED', 'UNCOUNTABLE' => 'UNCOUNTABLE'), array('empty' => 'Select Type', 'class' => 'select2')); ?>
                    <?php echo $form->error($model, 'type'); ?>
                </label>
            </section>
            <section class="col col-6">
                <label class="label"><?php echo $form->labelEx($model, 'pass_mark'); ?></label>
                <label class="input">
                    <?php echo $form->textField($model, 'pass_mark', array('maxlength' => 11, 'class' => 'col-sm-12', 'placeholder' => 'Pass Mark')); ?>
                    <?php echo $form->error($model, 'pass_mark'); ?>
                </label>
            </section>
        </div>
        <div class="row">
            <section class="col col-6">
                <label class="label"><?php echo $form->labelEx($model, 'final_mark'); ?></label>
                <label class="input">
                    <?php echo $form->textField($model, 'final_mark', array('maxlength' => 11, 'class' => 'col-sm-12', 'placeholder' => 'Final Mark')); ?>
                    <?php echo $form->error($model, 'final_mark'); ?>
                </label>
            </section>
            <section class="col col-6">
                <label class="label"><?php echo $form->labelEx($model, 'subject'); ?></label>
                <label class="input">
                    <?php echo $form->textField($model, 'subject', array('maxlength' => 150, 'class' => 'col-sm-12', 'placeholder' => 'Subject Name')); ?>
                    <?php echo $form->error($model, 'subject'); ?>
                </label>
            </section>
        </div>
        <div class="row">
            <section class="col col-6">
                <label class="label"><?php echo $form->labelEx($model, 'code'); ?></label>
                <label class="input">
                    <?php echo $form->textField($model, 'code', array('maxlength' => 11, 'class' => 'col-sm-12', 'placeholder' => 'Subject Code')); ?>
                    <?php echo $form->error($model, 'code'); ?>
                </label>
            </section>
            <section class="col col-6">
                <label class="label"><?php echo $form->labelEx($model, 'student_group'); ?></label>
                <label class="input">
                    <?php echo StudentGroup::getStudentGroup('Subject', 'student_group', $model->student_group, 'N/A'); ?>
                    <?php echo $form->error($model, 'student_group'); ?>
                </label>
            </section>
        </div>  
        <div class="row">
            <section class="col col-6">
                <label class="label"><?php echo $form->labelEx($model, 'subject_serial'); ?></label>
                <label class="input">
                    <?php echo $form->textField($model, 'subject_serial', array('maxlength' => 3, 'class' => 'col-sm-12', 'placeholder' => 'Subject Serial')); ?>
                    <?php echo $form->error($model, 'subject_serial'); ?>
                </label>
            </section>
            <section class="col col-6">
                <label class="label"><?php echo $form->labelEx($model, 'marge_id'); ?></label>
                <label class="input">
                    <?php echo $form->textField($model, 'marge_id', array('maxlength' => 11, 'class' => 'col-sm-12', 'placeholder' => 'Marge ID')); ?>
                    <?php echo $form->error($model, 'marge_id'); ?>
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
            <section class="col col-6">
                <label class="label"><?php echo $form->labelEx($model, 'status'); ?></label>
                <label class="select">
                    <?php echo $form->dropDownList($model, 'status', array('Active' => 'Active', 'Inactive' => 'Inactive'), array('class' => 'select2')); ?>
                    <?php echo $form->error($model, 'status'); ?>
                </label>
            </section>
        </div>
        <?= Institution::getAlertWarning('Note:', 'Create relevant Teacher, Student Group &amp; Class before you add Subject.') ?>
    </fieldset>
    <footer>
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => 'btn btn-primary')); ?>
    </footer>
    <?php $this->endWidget(); ?>
</div><!-- form -->