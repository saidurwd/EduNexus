<?php
/* @var $this MarkController */
/* @var $model Mark */
$this->pageTitle = 'Merit Position';
$this->breadcrumbs = array(
    'Marks' => array('admin'),
    'Merit Position',
);
Yii::app()->clientScript->registerScript('chained', '
    $(document).ready(function(){
        $("#MeritPosition_exam").chained("#MeritPosition_class");
        $("#MeritPosition_section").chained("#MeritPosition_class");
        $("#MeritPosition_group").chained("#MeritPosition_class");
    });
', CClientScript::POS_END);
?>
<div class="row">
    <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
        <h1 class="page-title txt-color-blueDark">
            <i class="fa fa-home fa-fw "></i> 
            Marks 
            <span>> 
                Merit Position
            </span>
        </h1>
    </div>
    <div class="col-xs-12 col-sm-5 col-md-5 col-lg-8">
    </div>
</div>
<!-- widget grid -->
<section id="widget-grid" class="">
    <!-- START ROW -->
    <div class="row">
        <!-- NEW COL START -->
        <article class="col-sm-12 col-md-12 col-lg-12">
            <!-- Widget ID (each widget will need unique ID)-->
            <div class="jarviswidget" id="wid-id-4" data-widget-editbutton="false" data-widget-custombutton="false">
                <header>
                    <span class="widget-icon"> <i class="fa fa-plus"></i> </span>
                    <h2>Merit Position</h2>
                </header>
                <!-- widget div-->
                <div>
                    <!-- widget edit box -->
                    <div class="jarviswidget-editbox">
                        <!-- This area used as dropdown edit box -->
                    </div>
                    <!-- end widget edit box -->
                    <!-- widget content -->
                    <div class="widget-body no-padding">                                           
                        <?php
                        $form = $this->beginWidget('CActiveForm', array(
                            'id' => 'merit-position-form',
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
                                    <label class="label"><?php echo $form->labelEx($model, 'class'); ?></label>
                                    <label class="input">
                                        <?php echo $form->dropDownList($model, 'class', CHtml::listData(Classs::model()->findAll(array('condition' => 'status="Active" AND institution=' . Yii::app()->user->institution)), 'id', 'class'), array('empty' => 'Select Class', 'class' => 'select2')); ?>
                                        <?php echo $form->error($model, 'class'); ?>
                                    </label>
                                </section>
                            </div>
                            <div class="row">
                                <section class="col col-6">
                                    <label class="label"><?php echo $form->labelEx($model, 'exam'); ?></label>
                                    <label class="input">
                                        <?php echo Exam::getExam('MeritPosition', 'exam', $model->exam); ?>
                                        <?php echo $form->error($model, 'exam'); ?>
                                    </label>
                                </section>
                            </div>
                            <div class="row">
                                <section class="col col-6">
                                    <label class="label"><?php echo $form->labelEx($model, 'section'); ?></label>
                                    <label class="input">
                                        <?php echo Section::getSection('MeritPosition', 'section', $model->section); ?>
                                        <?php echo $form->error($model, 'section'); ?>
                                    </label>
                                </section>
                            </div>
                            <div class="row">
                                <section class="col col-6">
                                    <label class="label"><?php echo $form->labelEx($model, 'group'); ?></label>
                                    <label class="input">
                                        <?php echo StudentGroup::getStudentGroup('MeritPosition', 'group', $model->group); ?>
                                        <?php echo $form->error($model, 'group'); ?>
                                    </label>
                                </section>
                            </div>
                            <div class="row">
                                <section class="col col-6">
                                    <label class="label"><?php echo $form->labelEx($model, 'academic_year'); ?></label>
                                    <label class="input">
                                        <?php echo $form->dropDownList($model, 'academic_year', CHtml::listData(AcademicYear::model()->findAll(array('condition' => 'institution=' . Yii::app()->user->institution)), 'id', 'title'), array('empty' => 'Select Year', 'class' => 'select2')); ?>
                                        <?php echo $form->error($model, 'academic_year'); ?>
                                    </label>
                                </section>
                            </div>
                        </fieldset>
                        <footer>
                            <?php echo CHtml::submitButton($model->isNewRecord ? 'PROCESS MERIT POSITION' : 'SAVE', array('class' => 'btn btn-primary')); ?>
                        </footer>  
                        <?php $this->endWidget(); ?>
                    </div>
                    <!-- end widget content -->
                </div>
                <!-- end widget div -->
            </div>
            <!-- end widget -->
        </article>
        <!-- END COL -->		
    </div>
    <!-- END ROW -->
</section>
<!-- end widget grid -->