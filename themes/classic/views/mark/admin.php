<?php
/* @var $this MarkController */
/* @var $model Mark */
$this->pageTitle = 'Marks - ' . Yii::app()->name;
$this->breadcrumbs = array(
    'Marks' => array('admin'),
    'Manage',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#mark-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
Yii::app()->clientScript->registerScript('reload-pageSetUp', "
    function reloadPageSetUp() {
        pageSetUp();
        $('.select2').select2();
    }
    ", CClientScript::POS_END);
?>
<div class="row">
    <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
        <h1 class="page-title txt-color-blueDark">
            <i class="fa fa-home fa-fw "></i> 
            Marks
            <span>>
                Manage
            </span>
        </h1>
    </div>
    <div class="col-xs-12 col-sm-5 col-md-5 col-lg-8">
        <ul id="sparks" class="">
            <li class="sparks-info">
                <h5> </h5>
            </li>
        </ul>
    </div>
</div>
<!-- widget grid -->
<section id="widget-grid" class="">
    <!-- row -->
    <div class="row">
        <!-- NEW WIDGET START -->
        <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <!-- Widget ID (each widget will need unique ID)-->
            <div class="jarviswidget" id="wid-id-1" data-widget-editbutton="false">
                <header>
                    <span class="widget-icon"> <i class="fa fa-home"></i> </span>
                    <h2>Marks</h2>   
                    <div class="widget-toolbar">
                        <?php echo CHtml::link('<i class="fa fa-plus"></i> NEW', array('create'), array('data-rel' => 'tooltip', 'title' => 'New', 'data-placement' => 'bottom', 'class' => 'btn btn-xs btn-primary')); ?>
                        <?php echo CHtml::link('<i class="fa fa-search"></i> SEARCH', '#', array('data-rel' => 'tooltip', 'title' => 'Advanced Search', 'data-placement' => 'bottom', 'class' => 'btn btn-xs btn-primary search-button')); ?>
                        <?php echo CHtml::link('<i class="fa fa-plus-circle"></i> MERIT POSITION', array('merit'), array('data-rel' => 'tooltip', 'title' => 'MERIT POSITION', 'data-placement' => 'bottom', 'class' => 'btn btn-xs btn-primary')); ?>
                    </div>
                </header>
                <!-- widget div-->
                <div>
                    <!-- widget content -->
                    <div class="widget-body no-padding">
                        <div class="search-form" style="display:none">
                            <?php
                            $this->renderPartial('_search', array(
                                'model' => $model,
                            ));
                            ?>
                        </div><!-- search-form -->
                        <?php
                        $this->widget('zii.widgets.grid.CGridView', array(
                            'id' => 'mark-grid',
                            'dataProvider' => $model->search(),
                            'filter' => $model,
                            'afterAjaxUpdate' => 'reloadPageSetUp',
                            'htmlOptions' => array('class' => ''),
                            'itemsCssClass' => 'table table-bordered table-striped table-hover smart-form',
                            'template' => '{items}{pager}{summary}',
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
                                    'filter' => CHtml::activeDropDownList($model, 'class', CHtml::listData(Classs::model()->findAll(array('condition' => 'institution=' . Yii::app()->user->institution, 'order' => '')), 'id', 'class'), array('empty' => 'All', 'class' => 'form-control')),
                                    'htmlOptions' => array('class' => ''),
                                ),
                                array(
                                    'name' => 'section',
                                    'type' => 'raw',
                                    'value' => 'Shift::getData(Section::getData($data->section,"shift"),"title")."-".Section::getData($data->section,"section")',
                                    'filter' => CHtml::activeDropDownList($model, 'section', CHtml::listData(Section::model()->findAll(array('condition' => 'institution=' . Yii::app()->user->institution, 'order' => '')), 'id', 'section'), array('empty' => 'All', 'class' => 'form-control')),
                                    'htmlOptions' => array('class' => 'text-center'),
                                ),
                                array(
                                    'name' => 'group',
                                    'type' => 'raw',
                                    'value' => 'StudentGroup::getData($data->group,"title")',
                                    'filter' => CHtml::activeDropDownList($model, 'group', CHtml::listData(StudentGroup::model()->findAll(array('condition' => 'institution=' . Yii::app()->user->institution, 'order' => '')), 'id', 'title'), array('empty' => 'All', 'class' => 'form-control')),
                                    'htmlOptions' => array('class' => ''),
                                ),
                                array(
                                    'name' => 'subject',
                                    'type' => 'raw',
                                    'value' => 'Subject::getData($data->subject,"subject")',
                                    'filter' => CHtml::activeDropDownList($model, 'subject', CHtml::listData(Subject::model()->findAll(array('condition' => 'institution=' . Yii::app()->user->institution, 'order' => '')), 'id', 'subject'), array('empty' => 'All', 'class' => 'form-control')),
                                    'htmlOptions' => array('class' => ''),
                                ),
                                array(
                                    'name' => 'exam',
                                    'type' => 'raw',
                                    'value' => 'Exam::getData($data->exam,"exam_name")',
                                    'filter' => CHtml::activeDropDownList($model, 'exam', CHtml::listData(Exam::model()->findAll(array('condition' => 'institution=' . Yii::app()->user->institution, 'order' => '')), 'id', 'exam_name'), array('empty' => 'All', 'class' => 'form-control')),
                                    'htmlOptions' => array('class' => ''),
                                ),
                                array(
                                    'name' => 'academic_year',
                                    'type' => 'raw',
                                    'value' => 'AcademicYear::getData($data->academic_year,"title")',
                                    'filter' => CHtml::activeDropDownList($model, 'academic_year', CHtml::listData(AcademicYear::model()->findAll(array('condition' => 'institution=' . Yii::app()->user->institution, 'order' => '')), 'id', 'title'), array('empty' => 'All', 'class' => 'form-control')),
                                    'htmlOptions' => array('class' => ''),
                                ),
                                array(
                                    'header' => 'Actions',
                                    'class' => 'CButtonColumn',
                                    'htmlOptions' => array('class' => "text-center width-50"),
                                    'template' => '{update} {delete}',
                                    'buttons' => array(
                                        'update' => array(
                                            'label' => '',
                                            'imageUrl' => '',
                                            'options' => array('class' => 'btn btn-xs btn-primary fa fa-random', 'title' => 'UPDATE MARKS'),
                                        ),
                                        'delete' => array(
                                            'label' => '',
                                            'imageUrl' => '',
                                            'options' => array('class' => 'btn btn-xs btn-danger fa fa-times'),
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
        <!-- WIDGET END -->
    </div>
    <!-- end row -->
</section>
<!-- end widget grid -->