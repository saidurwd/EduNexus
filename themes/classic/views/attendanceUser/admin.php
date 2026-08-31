<?php
/* @var $this AttendanceUserController */
/* @var $model AttendanceUser */
$this->pageTitle = 'User Attendance - ' . Yii::app()->name;
$this->breadcrumbs = array(
    'Users Attendance' => array('admin'),
    'Manage',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#attendance-user-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
Yii::app()->clientScript->registerScript('reload-pageSetUp', "
    function reloadPageSetUp() {
        pageSetUp();
    }
    $('.datepicker').datepicker({dateFormat: 'yy-mm-dd'});
    ", CClientScript::POS_END);
?>
<div class="row">
    <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
        <h1 class="page-title txt-color-blueDark">
            <i class="fa fa-home fa-fw "></i> 
            User Attendance
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
                    <h2>Users Attendance</h2>   
                    <div class="widget-toolbar">
                        <?php echo CHtml::link('<i class="fa fa-plus"></i> NEW', array('create'), array('data-rel' => 'tooltip', 'title' => 'New', 'data-placement' => 'bottom', 'class' => 'btn btn-xs btn-primary')); ?>
                        <?php echo CHtml::link('<i class="fa fa-search"></i> SEARCH', '#', array('data-rel' => 'tooltip', 'title' => 'Advanced Search', 'data-placement' => 'bottom', 'class' => 'btn btn-xs btn-primary search-button')); ?>
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
                            'id' => 'attendance-user-grid',
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
                                    'name' => 'user',
                                    'type' => 'raw',
                                    'value' => '$data->user0->full_name',
                                    'filter' => CHtml::activeDropDownList($model, 'user', CHtml::listData(User::model()->findAll(array('condition' => 'institution=' . Yii::app()->user->institution, 'order' => 'full_name')), 'id', 'full_name'), array('empty' => 'All', 'class' => 'select2')),
                                    'htmlOptions' => array('class' => ''),
                                ),
                                array(
                                    'name' => 'attendance_in',
                                    'type' => 'raw',
                                    'value' => 'User::get_date_time($data->attendance_in)',
                                    'filter' => CHtml::activeTextField($model, 'attendance_in', array('class' => 'form-control datepicker')),
                                    'htmlOptions' => array('class' => ''),
                                ),
                                array(
                                    'name' => 'attendance_out',
                                    'type' => 'raw',
                                    'value' => 'User::get_date_time($data->attendance_out)',
                                    'filter' => CHtml::activeTextField($model, 'attendance_out', array('class' => 'form-control datepicker')),
                                    'htmlOptions' => array('class' => ''),
                                ),
                                array(
                                    'name' => 'attendance',
                                    'value' => '$data->attendance',
                                    'filter' => CHtml::activeDropDownList($model, 'attendance', array('Present' => 'Present', 'Late Present With Excuse' => 'Late Present With Excuse', 'Late Present' => 'Late Present', 'Absent' => 'Absent', 'Half Day' => 'Half Day'), array('empty' => 'All', 'class' => 'form-control')),
                                    'htmlOptions' => array('style' => "text-align:center;"),
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
                                            'options' => array('class' => 'btn btn-xs btn-primary fa fa-pencil'),
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