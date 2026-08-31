<?php
/* @var $this StudentController */
/* @var $model Student */
/* @var $form CActiveForm */
?>

<div class="wide form">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'htmlOptions' => array('class' => 'smart-form'),
    ));
    Yii::app()->clientScript->registerScript('chained', '
    $(document).ready(function(){
        $("#Student_section").chained("#Student_class");
        $("#Student_group").chained("#Student_class");
        $("#Student_shift").chained("#Student_class");
    });
', CClientScript::POS_END);
    ?>
    <fieldset>               
        <div class="row">
            <section class="col col-2">
                <label class="label"><?php echo $form->labelEx($model, 'name'); ?></label>
                <label class="input">
                    <?php echo $form->textField($model, 'name', array('maxlength' => 150, 'class' => 'col-sm-12', 'placeholder' => 'Name')); ?>
                </label>
            </section>  
            <section class="col col-2">
                <label class="label"><?php echo $form->labelEx($model, 'gender'); ?></label>
                <label class="select">
                    <?php echo $form->dropDownList($model, 'gender', array('Male' => 'Male', 'Female' => 'Female', 'Other' => 'Other'), array('empty' => 'All', 'class' => 'select2')); ?>
                </label>
            </section>
            <section class="col col-2">
                <label class="label"><?php echo $form->labelEx($model, 'blood_group'); ?></label>
                <label class="select">
                    <?php echo $form->dropDownList($model, 'blood_group', array('A+' => 'A+', 'A-' => 'A-', 'B+' => 'B+', 'B-' => 'B-', 'O+' => 'O+', 'O-' => 'O-', 'AB+' => 'AB+', 'AB-' => 'AB-'), array('empty' => 'All', 'class' => 'select2')); ?>
                </label>
            </section>
            <section class="col col-2">
                <label class="label"><?php echo $form->labelEx($model, 'religion'); ?></label>
                <label class="select">
                    <?php echo $form->dropDownList($model, 'religion', array('Islam' => 'Islam', 'Christianity' => 'Christianity', 'Hinduism' => 'Hinduism', 'Buddhism' => 'Buddhism'), array('empty' => 'All', 'class' => 'select2')); ?>
                </label>
            </section>
            <section class="col col-2">
                <label class="label"><?php echo $form->labelEx($model, 'phone'); ?></label>
                <label class="input">
                    <i class="icon-prepend fa fa-mobile-phone"></i>
                    <?php echo $form->textField($model, 'phone', array('maxlength' => 10, 'class' => '', 'placeholder' => 'Phone')); ?>
                    <b class="tooltip tooltip-top-left"><i class="fa fa-warning txt-color-teal"></i> Mobile number without +880</b>
                </label>
            </section>
            <section class="col col-2">
                <label class="label"><?php echo $form->labelEx($model, 'sid'); ?></label>
                <label class="input">
                    <?php echo $form->textField($model, 'sid', array('maxlength' => 11, 'class' => 'col-sm-12', 'placeholder' => 'Student ID')); ?>
                </label>
            </section>
        </div>
        <div class="row">
            <section class="col col-2">
                <label class="label"><?php echo $form->labelEx($model, 'class'); ?></label>
                <label class="input">
                    <?php echo $form->dropDownList($model, 'class', CHtml::listData(Classs::model()->findAll(array('condition' => 'status="Active" AND institution=' . Yii::app()->user->institution)), 'id', 'class'), array('empty' => 'Select Class', 'class' => 'select2')); ?>
                    <?php echo $form->error($model, 'class'); ?>
                </label>
            </section>
            <section class="col col-2">
                <label class="label"><?php echo $form->labelEx($model, 'section'); ?></label>
                <label class="input">
                    <?php echo Section::getSection('Student', 'section', $model->section); ?>
                    <?php echo $form->error($model, 'section'); ?>
                </label>
            </section>
            <section class="col col-2">
                <label class="label"><?php echo $form->labelEx($model, 'group'); ?></label>
                <label class="input">
                    <?php echo StudentGroup::getStudentGroup('Student', 'group', $model->group); ?>
                    <?php echo $form->error($model, 'group'); ?>
                </label>
            </section>
            <section class="col col-2">
                <label class="label"><?php echo $form->labelEx($model, 'academic_year'); ?></label>
                <label class="input">
                    <?php echo $form->dropDownList($model, 'academic_year', CHtml::listData(AcademicYear::model()->findAll(array('condition' => 'institution=' . Yii::app()->user->institution)), 'id', 'title'), array('empty' => 'Select Academic Year', 'class' => 'select2')); ?>
                    <?php echo $form->error($model, 'academic_year'); ?>
                </label>
            </section>
            <section class="col col-2">
                <label class="label"><?php echo $form->labelEx($model, 'roll'); ?></label>
                <label class="input">
                    <?php echo $form->textField($model, 'roll', array('maxlength' => 11, 'class' => 'col-sm-12', 'placeholder' => 'Roll')); ?>
                    <?php echo $form->error($model, 'roll'); ?>
                </label>
            </section>
            <section class="col col-2">
                <label class="label"><?php echo $form->labelEx($model, 'shift'); ?></label>
                <label class="input">
                    <?php echo Shift::getShift('Student', 'shift', $model->shift); ?>
                    <?php echo $form->error($model, 'shift'); ?>
                </label>
            </section>
        </div>
    </fieldset>
    <footer>
        <?php echo CHtml::submitButton('Search', array('class' => 'btn btn-primary')); ?>
    </footer>
    <?php $this->endWidget(); ?>
</div><!-- search-form -->