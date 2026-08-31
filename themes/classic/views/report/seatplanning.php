<?php
/* @var $this ReportController */
$this->pageTitle = 'Exam Seat Planning';
$this->breadcrumbs = array(
    'Report' => array('/report'),
    'Exam Seat Planning',
);
Yii::app()->clientScript->registerScript('chained', '
    $(document).ready(function(){
        $("#exam").chained("#class");
    });
', CClientScript::POS_END);
if (empty($_POST['class'])) {
    $class = NULL;
} else {
    $class = $_POST['class'];
}
if (empty($_POST['exam'])) {
    $exam = NULL;
} else {
    $exam = $_POST['exam'];
}
if (empty($_POST['year'])) {
    $year = NULL;
} else {
    $year = $_POST['year'];
}
?>
<div class="row">
    <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
        <h1 class="page-title txt-color-blueDark">
            <i class="fa fa-home fa-fw "></i> 
            Reports 
            <span>> 
                Exam Seat Planning
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
                    <span class="widget-icon"> <i class="fa fa-signal"></i> </span>
                    <h2>Exam Seat Planning</h2>	
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
                            'action' => Yii::app()->createUrl($this->route),
                            'method' => 'post',
                            'htmlOptions' => array('class' => 'smart-form'),
                        ));
                        ?>
                        <fieldset>
                            <div class="row">
                                <section class="col col-4">
                                    <label class="label">Class</label>
                                    <label class="input">
                                        <?php echo CHtml::dropDownList('class', isset($_REQUEST['class']) ? CHtml::encode($_REQUEST['class']) : '', CHtml::listData(Classs::model()->findAll(array('condition' => 'institution=' . Yii::app()->user->institution . ' AND status="Active"', 'order' => 'class_numeric')), 'id', 'class'), array('empty' => 'All Class', 'class' => 'select2')); ?> 
                                    </label>
                                </section>
                                <section class="col col-4">
                                    <label class="label">Exam</label>
                                    <label class="input">
                                        <?php echo Exam::getExamReport('exam', @$_REQUEST['exam']); ?>
                                    </label>
                                </section>
                                <section class="col col-4">
                                    <label class="label">Academic Year</label>
                                    <label class="input">
                                        <?php echo CHtml::dropDownList('year', isset($_REQUEST['year']) ? CHtml::encode($_REQUEST['year']) : '', CHtml::listData(AcademicYear::model()->findAll(array('condition' => 'institution=' . Yii::app()->user->institution, 'order' => '`default` DESC')), 'id', 'title'), array('class' => 'select2')); ?> 
                                    </label>
                                </section>
                            </div>
                        </fieldset>
                        <footer>                            
                            <?php echo CHtml::link('<i class="fa fa-print"></i> PRINT', array('seatplanningprint', 'class' => $class, 'exam' => $exam, 'year' => $year), array('class' => 'btn btn-success btn-sm', 'target' => '_blank')); ?>
                            <?php echo CHtml::htmlButton('<i class="fa fa-search"></i> SEARCH', array('type' => 'submit', 'class' => 'btn btn-primary btn-sm')); ?>
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