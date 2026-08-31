<?php
/* @var $this SubjectMarkController */
/* @var $model SubjectMark */
/* @var $form CActiveForm */
?>

<div class="form">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'subject-mark-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation' => false,
        'htmlOptions' => array('class' => 'smart-form'),
    ));
    Yii::app()->clientScript->registerScript('chained', '
    $(document).ready(function(){
        $("#SubjectMark_subject").chained("#SubjectMark_class");
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
                <label class="label"><?php echo $form->labelEx($model, 'subject'); ?></label>
                <label class="input">
                    <?php echo Subject::getSubject('SubjectMark', 'subject', $model->subject); ?>
                    <?php echo $form->error($model, 'subject'); ?>
                </label>
            </section>
        </div>
        <div class="row">
            <section class="col col-6">
                <label class="label"><?php echo $form->labelEx($model, 'written'); ?></label>
                <label class="input">
                    <?php echo $form->textField($model, 'written', array('maxlength' => 11, 'class' => 'col-sm-12', 'placeholder' => 'Written')); ?>
                    <?php echo $form->error($model, 'written'); ?>
                </label>
            </section>
            <section class="col col-6">
                <label class="label"><?php echo $form->labelEx($model, 'mcq'); ?></label>
                <label class="input">
                    <?php echo $form->textField($model, 'mcq', array('maxlength' => 11, 'class' => 'col-sm-12', 'placeholder' => 'MCQ')); ?>
                    <?php echo $form->error($model, 'mcq'); ?>
                </label>
            </section>
        </div>        
        <div class="row">
            <section class="col col-6">
                <label class="label"><?php echo $form->labelEx($model, 'practical'); ?></label>
                <label class="input">
                    <?php echo $form->textField($model, 'practical', array('maxlength' => 11, 'class' => 'col-sm-12', 'placeholder' => 'Practical')); ?>
                    <?php echo $form->error($model, 'practical'); ?>
                </label>
            </section>
            <section class="col col-6">
                <label class="label"><?php echo $form->labelEx($model, 'class_assessment'); ?></label>
                <label class="input">
                    <?php echo $form->textField($model, 'class_assessment', array('maxlength' => 11, 'class' => 'col-sm-12', 'placeholder' => 'Class Assessment')); ?>
                    <?php echo $form->error($model, 'class_assessment'); ?>
                </label>
            </section>
        </div>
        <div class="row">
            <section class="col col-6">
                <label class="label"><?php echo $form->labelEx($model, 'full_mark'); ?></label>
                <label class="input">
                    <?php echo $form->textField($model, 'full_mark', array('maxlength' => 11, 'class' => 'col-sm-12', 'placeholder' => 'Full Mark')); ?>
                    <?php echo $form->error($model, 'full_mark'); ?>
                </label>
            </section>
            <section class="col col-6">
                <label class="label"><?php echo $form->labelEx($model, 'with_class_assessment'); ?></label>
                <label class="select">
                    <?php echo $form->dropDownList($model, 'with_class_assessment', array('Yes' => 'Yes', 'No' => 'No'), array('empty' => 'Select With Class Assesment', 'class' => 'select2')); ?>
                    <?php echo $form->error($model, 'with_class_assessment'); ?>
                </label>
            </section>
        </div>
        <div class="row">
            <section class="col col-6">
                <label class="label"><?php echo $form->labelEx($model, 'passed_separately'); ?></label>
                <label class="select">
                    <?php echo $form->dropDownList($model, 'passed_separately', array('Yes' => 'Yes', 'No' => 'No'), array('empty' => 'Select Passed Separately', 'class' => 'select2')); ?>
                    <?php echo $form->error($model, 'passed_separately'); ?>
                </label>
            </section>
            <section class="col col-6">
                <label class="label"><?php echo $form->labelEx($model, 'calculate_percent'); ?></label>
                <label class="input">
                    <?php echo $form->textField($model, 'calculate_percent', array('maxlength' => 11, 'class' => 'col-sm-12', 'placeholder' => 'Calculate Percent')); ?>
                    <?php echo $form->error($model, 'calculate_percent'); ?>
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