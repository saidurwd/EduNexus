<?php
/* @var $this ReportController */
$this->pageTitle = 'Student ID Card - Admin';
$this->breadcrumbs = array(
    'Report' => array('/report'),
    'Student ID Card - Admin',
);
Yii::app()->clientScript->registerScript('chained', '
    $(document).ready(function(){
        $("#class").chained("#institution");
        $("#section").chained("#class");
        $("#year").chained("#institution");
    });
', CClientScript::POS_END);
if (empty($_POST['institution'])) {
    $institution = NULL;
} else {
    $institution = $_POST['institution'];
}
if (empty($_POST['class'])) {
    $class = NULL;
} else {
    $class = $_POST['class'];
}
if (empty($_POST['section'])) {
    $section = NULL;
} else {
    $section = $_POST['section'];
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
                Student ID Card - Admin
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
                    <h2>Student ID Card - Admin</h2>	
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
                                <section class="col col-3">
                                    <label class="label">Class</label>
                                    <label class="input">
                                        <?php echo CHtml::dropDownList('institution', isset($_REQUEST['institution']) ? CHtml::encode($_REQUEST['institution']) : '', CHtml::listData(Institution::model()->findAll(array('condition' => '', 'order' => 'institution')), 'id', 'institution'), array('empty' => 'All Institution', 'class' => 'select2')); ?> 
                                    </label>
                                </section>
                                <section class="col col-3">
                                    <label class="label">Class</label>
                                    <label class="input">                                        
                                        <?php echo Classs::getClassReportAdmin('class', @$_REQUEST['class']); ?>
                                    </label>
                                </section>
                                <section class="col col-3">
                                    <label class="label">Section</label>
                                    <label class="input">
                                        <?php echo Section::getSectionReportAdmin('section', @$_REQUEST['section']); ?>
                                    </label>
                                </section>
                                <section class="col col-3">
                                    <label class="label">Academic Year</label>
                                    <label class="input">
                                        <?php echo AcademicYear::getAcademicYearReportAdmin('year', @$_REQUEST['year']); ?>
                                    </label>
                                </section>
                            </div>
                        </fieldset>
                        <footer>                            
                            <?php echo CHtml::link('<i class="fa fa-print"></i> PRINT', array('idcardadminprint', 'institution' => $institution, 'class' => $class, 'section' => $section, 'year' => $year), array('class' => 'btn btn-success btn-sm', 'target' => '_blank')); ?>
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