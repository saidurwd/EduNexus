<?php
/* @var $this ReportController */
$this->pageTitle = 'Fail List';
$this->breadcrumbs = array(
    'Report' => array('/report/faillist'),
    'Fail List',
);
Yii::app()->clientScript->registerScript('chained', '
    $(document).ready(function(){
        $("#section").chained("#class");
    });
', CClientScript::POS_END);
?>
<div class="row">
    <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
        <h1 class="page-title txt-color-blueDark">
            <i class="fa fa-home fa-fw "></i> 
            Reports 
            <span>> 
                Fail List
            </span>
        </h1>
    </div>
    <div class="col-xs-12 col-sm-5 col-md-5 col-lg-8">
    </div>
</div>
<!-- widget grid -->
<section id="widget-grid" class="">
    <!-- row -->
    <div class="row">
        <article class="col-sm-12">
            <!-- new widget -->
            <div class="jarviswidget" id="wid-id-0" data-widget-togglebutton="false" data-widget-editbutton="false" data-widget-fullscreenbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">
                <header>
                    <span class="widget-icon"> <i class="glyphicon glyphicon-stats txt-color-darken"></i> </span>
                    <h2>Fail List</h2>
                    <ul class="nav nav-tabs pull-right in" id="myTab">
                        <li class="active"><a data-toggle="tab" href="#s1"><i class="fa fa-th-large"></i> <span class="hidden-mobile hidden-tablet">Class Wise</span></a></li>
                        <li><a data-toggle="tab" href="#s2"><i class="fa fa-th"></i> <span class="hidden-mobile hidden-tablet">Section Wise</span></a></li>
                        <li><a data-toggle="tab" href="#s3"><i class="fa fa-th-list"></i> <span class="hidden-mobile hidden-tablet">Group Wise</span></a></li>
                    </ul>
                </header>
                <!-- widget div-->
                <div class="no-padding">
                    <!-- widget edit box -->
                    <div class="jarviswidget-editbox">
                        test
                    </div>
                    <!-- end widget edit box -->
                    <div class="widget-body">
                        <!-- content -->
                        <div id="myTabContent" class="tab-content">
                            <div class="tab-pane fade active in no-padding no-padding-bottom" id="s1">
                                <div class="row no-space">
                                    <?php
                                    $this->widget('zii.widgets.grid.CGridView', array(
                                        'id' => 'class-fail-grid',
                                        'dataProvider' => $model->search_class(),
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
                                                'template' => '{update}',
                                                'buttons' => array(
                                                    'update' => array(
                                                        'label' => '',
                                                        'imageUrl' => '',
                                                        'url' => 'yii::app()->createUrl("/report/faillistclassprint", array("class"=>$data["class"],"exam"=>$data["exam"],"year"=>$data["academic_year"]))',
                                                        'options' => array('class' => 'btn btn-sm btn-primary fa fa-print', 'title' => 'Fail List', 'target' => '_blank'),
                                                    ),
                                                ),
                                            ),
                                        ),
                                    ));
                                    ?>
                                </div>
                            </div>
                            <!-- end s1 tab pane -->

                            <div class="tab-pane fade" id="s2">
                                <div class="row no-space">
                                    <?php
                                    $this->widget('zii.widgets.grid.CGridView', array(
                                        'id' => 'section-fail-grid',
                                        'dataProvider' => $model->search_section(),
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
                                                'template' => '{update}',
                                                'buttons' => array(
                                                    'update' => array(
                                                        'label' => '',
                                                        'imageUrl' => '',
                                                        'url' => 'yii::app()->createUrl("/report/faillistsectionprint", array("class"=>$data["class"],"section"=>$data["section"],"exam"=>$data["exam"],"year"=>$data["academic_year"]))',
                                                        'options' => array('class' => 'btn btn-sm btn-primary fa fa-print', 'title' => 'Fail List', 'target' => '_blank'),
                                                    ),
                                                ),
                                            ),
                                        ),
                                    ));
                                    ?>
                                </div>
                            </div>
                            <!-- end s2 tab pane -->

                            <div class="tab-pane fade" id="s3">
                                <div class="row no-space">
                                    <?php
                                    $this->widget('zii.widgets.grid.CGridView', array(
                                        'id' => 'group-fail-grid',
                                        'dataProvider' => $model->search(),
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
                                                'template' => '{update}',
                                                'buttons' => array(
                                                    'update' => array(
                                                        'label' => '',
                                                        'imageUrl' => '',
                                                        'url' => 'yii::app()->createUrl("/report/faillistprint", array("class"=>$data["class"],"section"=>$data["section"],"group"=>$data["group"],"exam"=>$data["exam"],"year"=>$data["academic_year"]))',
                                                        'options' => array('class' => 'btn btn-sm btn-primary fa fa-print', 'title' => 'Fail List', 'target' => '_blank'),
                                                    ),
                                                ),
                                            ),
                                        ),
                                    ));
                                    ?>
                                </div>
                            </div>
                            <!-- end s3 tab pane -->
                        </div>
                        <!-- end content -->
                    </div>
                </div>
                <!-- end widget div -->
            </div>
            <!-- end widget -->
        </article>
    </div>
    <!-- end row -->
</section>
<!-- end widget grid -->