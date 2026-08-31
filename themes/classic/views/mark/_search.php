<?php
/* @var $this MarkController */
/* @var $model Mark */
/* @var $form CActiveForm */
?>

<?php
$form = $this->beginWidget('CActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'htmlOptions' => array('class' => 'smart-form'),
        ));
Yii::app()->clientScript->registerScript('chained', '
    $(document).ready(function(){
        $("#MarkParent_exam").chained("#MarkParent_class");
        $("#MarkParent_section").chained("#MarkParent_class");
        $("#MarkParent_subject").chained("#MarkParent_class");
        $("#MarkParent_group").chained("#MarkParent_class");
    });
    ', CClientScript::POS_END);
?>
<fieldset>               
    <div class="row">
        <section class="col col-2">
            <label class="label"><?php echo $form->labelEx($model, 'class'); ?></label>
            <label class="input">
                <?php echo $form->dropDownList($model, 'class', CHtml::listData(Classs::model()->findAll(array('condition' => 'status="Active" AND institution=' . Yii::app()->user->institution)), 'id', 'class'), array('empty' => 'Select Class', 'class' => 'form-control')); ?>
            </label>
        </section>
        <section class="col col-2">
            <label class="label"><?php echo $form->labelEx($model, 'section'); ?></label>
            <label class="input">
                <?php echo Section::getSection('MarkParent', 'section', $model->section, 'form-control'); ?>
                <?php echo $form->error($model, 'section'); ?>
            </label>
        </section>
        <section class="col col-2">
            <label class="label"><?php echo $form->labelEx($model, 'group'); ?></label>
            <label class="input">
                <?php echo StudentGroup::getStudentGroup('MarkParent', 'group', $model->group, 'Select Group', 'form-control'); ?>
                <?php echo $form->error($model, 'group'); ?>
            </label>
        </section>
        <section class="col col-2">
            <label class="label"><?php echo $form->labelEx($model, 'academic_year'); ?></label>
            <label class="input">
                <?php echo $form->dropDownList($model, 'academic_year', CHtml::listData(AcademicYear::model()->findAll(array('condition' => 'institution=' . Yii::app()->user->institution)), 'id', 'title'), array('empty' => 'Select Academic Year', 'class' => 'form-control')); ?>
                <?php echo $form->error($model, 'academic_year'); ?>
            </label>
        </section>
        <section class="col col-2">
            <label class="label"><?php echo $form->labelEx($model, 'subject'); ?></label>
            <label class="input">
                <?php echo Subject::getSubject('MarkParent', 'subject', $model->subject, 'form-control'); ?>
                <?php echo $form->error($model, 'subject'); ?>
            </label>
        </section>
        <section class="col col-2">
            <label class="label"><?php echo $form->labelEx($model, 'academic_year'); ?></label>
            <label class="input">
                <?php echo $form->dropDownList($model, 'academic_year', CHtml::listData(AcademicYear::model()->findAll(array('condition' => 'institution=' . Yii::app()->user->institution)), 'id', 'title'), array('empty' => 'Select Year', 'class' => 'form-control')); ?>
                <?php echo $form->error($model, 'academic_year'); ?>
            </label>
        </section>
    </div>
</fieldset>
<footer>
    <?php echo CHtml::submitButton('Search', array('class' => 'btn btn-primary')); ?>
</footer>
<?php $this->endWidget(); ?>