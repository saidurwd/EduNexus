<?php
/* @var $this StudentController */
/* @var $model Student */
$this->pageTitle = 'Online Admission - ' . Yii::app()->name;
$this->breadcrumbs = array(
    'Online Admission' => array('admission'),
    'Manage',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#student-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
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
            Online Admission
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
                    <h2>Students</h2>   
                    <div class="widget-toolbar">                        
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
                            'id' => 'student-grid',
                            'dataProvider' => $model->search_admission(),
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
                                    'name' => 'photo',
                                    'type' => 'raw',
                                    'value' => 'Student::getPhoto($data->id)',
                                    'filter' => false,
                                    'htmlOptions' => array('class' => 'text-center width-30'),
                                ),
                                array(
                                    'name' => 'sid',
                                    'type' => 'raw',
                                    'value' => '$data->sid',
                                    'filter' => CHtml::activeTextField($model, 'sid', array('class' => 'form-control')),
                                    'htmlOptions' => array('class' => 'text-center width-80'),
                                ),
                                array(
                                    'name' => 'name',
                                    'type' => 'raw',
                                    'value' => '$data->name',
                                    'filter' => CHtml::activeTextField($model, 'name', array('class' => 'form-control')),
                                    'htmlOptions' => array('class' => ''),
                                ),
                                array(
                                    'name' => 'roll',
                                    'type' => 'raw',
                                    'value' => '$data->roll',
                                    'filter' => CHtml::activeTextField($model, 'roll', array('class' => 'form-control')),
                                    'htmlOptions' => array('class' => 'text-center width-80'),
                                ),
                                array(
                                    'name' => 'gender',
                                    'value' => '$data->gender',
                                    'filter' => CHtml::activeDropDownList($model, 'gender', array('Male' => 'Male', 'Female' => 'Female', 'Others' => 'Others'), array('empty' => 'All', 'class' => 'form-control')),
                                    'htmlOptions' => array('style' => "text-align:center;"),
                                ),
                                array(
                                    'name' => 'blood_group',
                                    'value' => '$data->blood_group',
                                    'filter' => CHtml::activeDropDownList($model, 'blood_group', array('A+' => 'A+', 'A-' => 'A-', 'B+' => 'B+', 'B-' => 'B-', 'O+' => 'O+', 'O-' => 'O-', 'AB+' => 'AB+', 'AB-' => 'AB-'), array('empty' => 'All', 'class' => 'form-control')),
                                    'htmlOptions' => array('class' => "text-center width-80"),
                                ),
                                array(
                                    'name' => 'religion',
                                    'value' => '$data->religion',
                                    'filter' => CHtml::activeDropDownList($model, 'religion', array('Islam' => 'Islam', 'Christianity' => 'Christianity', 'Hinduism' => 'Hinduism', 'Buddhism' => 'Buddhism'), array('empty' => 'All', 'class' => 'form-control')),
                                    'htmlOptions' => array('style' => "text-align:center;"),
                                ),
                                array(
                                    'name' => 'phone',
                                    'type' => 'raw',
                                    'value' => '$data->phone',
                                    'filter' => CHtml::activeTextField($model, 'phone', array('class' => 'form-control')),
                                    'htmlOptions' => array('class' => ''),
                                ),
                                array(
                                    'name' => 'class',
                                    'type' => 'raw',
                                    'value' => 'Classs::getData($data->class,"class")',
                                    'filter' => CHtml::activeDropDownList($model, 'class', CHtml::listData(Classs::model()->findAll(array('condition' => 'institution=' . Yii::app()->user->institution, 'order' => '')), 'id', 'class'), array('empty' => 'All', 'class' => 'select2')),
                                    'htmlOptions' => array('class' => 'text-center width-100'),
                                ),
                                array(
                                    'name' => 'section',
                                    'type' => 'raw',
                                    'value' => 'Section::getData($data->section,"section")',
                                    'filter' => CHtml::activeDropDownList($model, 'section', CHtml::listData(Section::model()->findAll(array('condition' => 'institution=' . Yii::app()->user->institution, 'order' => '')), 'id', 'section'), array('empty' => 'All', 'class' => 'select2')),
                                    'htmlOptions' => array('class' => 'text-center width-80'),
                                ),
                                array(
                                    'name' => 'group',
                                    'type' => 'raw',
                                    'value' => 'StudentGroup::getData($data->group,"title")',
                                    'filter' => CHtml::activeDropDownList($model, 'group', CHtml::listData(StudentGroup::model()->findAll(array('condition' => 'institution=' . Yii::app()->user->institution, 'order' => 'title')), 'id', 'title'), array('empty' => 'All', 'class' => 'select2')),
                                    'htmlOptions' => array('class' => ''),
                                ),
                                array(
                                    'name' => 'optional_subject',
                                    'type' => 'raw',
                                    'value' => 'Subject::getData($data->optional_subject,"subject")',
                                    'filter' => CHtml::activeTextField($model, 'optional_subject', array('class' => 'form-control')),
                                    'htmlOptions' => array('class' => 'text-left'),
                                ),
                                array(
                                    'name' => 'status',
                                    'value' => '$data->status',
                                    'filter' => CHtml::activeDropDownList($model, 'status', array('PENDING' => 'PENDING'), array('empty' => 'All', 'class' => 'form-control')),
                                    'htmlOptions' => array('class' => "text-center width-80"),
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
                                            'options' => array('target' => '_blank', 'class' => 'btn btn-xs btn-primary fa fa-pencil'),
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