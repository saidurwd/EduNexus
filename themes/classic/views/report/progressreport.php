<?php
/* @var $this ReportController */
$this->pageTitle = 'Progress Report';
$this->breadcrumbs = array(
    'Report' => array('/report/progressreport'),
    'Progress Report',
);
Yii::app()->clientScript->registerScript('chained', '
    $(document).ready(function(){
        $("#section").chained("#class");
    });
', CClientScript::POS_END);
Yii::app()->clientScript->registerScript('reload-pageSetUp', "
    function reloadPageSetUp() {
        pageSetUp();
    }
    ", CClientScript::POS_END);
?>
<div class="row">
    <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
        <h1 class="page-title txt-color-blueDark">
            <i class="fa fa-home fa-fw "></i> 
            Reports 
            <span>> 
                Progress Report
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
                    <h2>Progress Report</h2>	
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
                        $this->widget('zii.widgets.grid.CGridView', array(
                            'id' => 'mark-parent-grid',
                            'dataProvider' => $model->search_tabulationsheet(),
                            'filter' => $model,
                            'afterAjaxUpdate' => 'reloadPageSetUp',
                            'htmlOptions' => array('class' => ''),
                            'itemsCssClass' => 'table table-bordered table-striped table-hover smart-form',
                            'template' => '{items}{pager}',
                            'emptyText' => 'No result found.',
                            'summaryText' => "{start} - {end} of {count} result",
                            'pager' => array(
                                'htmlOptions' => array(
                                    'class' => 'pagination',
                                ),
                                'header' => '',
                                'selectedPageCssClass' => 'active',
                            ),
                            'pagerCssClass' => 'widget-footer',
                            'columns' => array(
                                array(
                                    'name' => 'class',
                                    'type' => 'raw',
                                    'value' => 'Classs::getData($data->class,"class")',
                                    'filter' => CHtml::activeDropDownList($model, 'class', CHtml::listData(Classs::model()->findAll(array('condition' => 'institution=' . Yii::app()->user->institution, 'order' => '')), 'id', 'class'), array('empty' => 'All', 'class' => 'select2')),
                                    'htmlOptions' => array('class' => ''),
                                ),
                                array(
                                    'name' => 'section',
                                    'type' => 'raw',
                                    'value' => 'Shift::getData(Section::getData($data->section,"shift"),"title")."-".Section::getData($data->section,"section")',
                                    'filter' => CHtml::activeDropDownList($model, 'section', CHtml::listData(Section::model()->findAll(array('condition' => 'institution=' . Yii::app()->user->institution, 'order' => '')), 'id', 'section'), array('empty' => 'All', 'class' => 'select2')),
                                    'htmlOptions' => array('class' => 'text-center'),
                                ),
                                array(
                                    'name' => 'group',
                                    'type' => 'raw',
                                    'value' => 'StudentGroup::getData($data->group,"title")',
                                    'filter' => CHtml::activeDropDownList($model, 'group', CHtml::listData(StudentGroup::model()->findAll(array('condition' => 'institution=' . Yii::app()->user->institution, 'order' => '')), 'id', 'title'), array('empty' => 'All', 'class' => 'select2')),
                                    'htmlOptions' => array('class' => ''),
                                ),
                                array(
                                    'name' => 'exam',
                                    'type' => 'raw',
                                    'value' => 'Exam::getData($data->exam,"exam_name")',
                                    'filter' => CHtml::activeDropDownList($model, 'exam', CHtml::listData(Exam::model()->findAll(array('condition' => 'institution=' . Yii::app()->user->institution, 'order' => '')), 'id', 'exam_name'), array('empty' => 'All', 'class' => 'select2')),
                                    'htmlOptions' => array('class' => ''),
                                ),
                                array(
                                    'name' => 'academic_year',
                                    'type' => 'raw',
                                    'value' => 'AcademicYear::getData($data->academic_year,"title")',
                                    'filter' => CHtml::activeDropDownList($model, 'academic_year', CHtml::listData(AcademicYear::model()->findAll(array('condition' => 'institution=' . Yii::app()->user->institution, 'order' => '')), 'id', 'title'), array('empty' => 'All', 'class' => 'select2')),
                                    'htmlOptions' => array('class' => ''),
                                ),
                                array(
                                    'header' => 'Actions',
                                    'class' => 'CButtonColumn',
                                    'htmlOptions' => array('class' => "text-center width-50"),
                                    'template' => '{view}',
                                    'buttons' => array(
                                        'view' => array(
                                            'label' => '',
                                            'imageUrl' => '',
                                            'url' => 'yii::app()->createUrl("/report/progressreportprint", array("class"=>$data["class"],"section"=>$data["section"],"group"=>$data["group"],"exam"=>$data["exam"],"year"=>$data["academic_year"]))',
                                            'options' => array('class' => 'btn btn-sm btn-primary fa fa-print', 'title' => 'Progress Report', 'target' => '_blank'),
                                        ),
                                    ),
                                ),
                            ),
                        ));
                        ?>
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