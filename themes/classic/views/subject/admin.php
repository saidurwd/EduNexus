<?php
/* @var $this SubjectController */
/* @var $model Subject */
$this->pageTitle = 'Subjects - ' . Yii::app()->name;
$this->breadcrumbs = array(
    'Subjects' => array('admin'),
    'Manage',
);
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
            Subjects
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
                    <h2>Subjects</h2>   
                    <div class="widget-toolbar">
                        <?php echo CHtml::link('<i class="fa fa-plus"></i> NEW', array('create'), array('data-rel' => 'tooltip', 'title' => 'New', 'data-placement' => 'bottom', 'class' => 'btn btn-xs btn-primary')); ?>
                    </div>
                </header>
                <!-- widget div-->
                <div>
                    <!-- widget content -->
                    <div class="widget-body no-padding">
                        <?php
                        $this->widget('zii.widgets.grid.CGridView', array(
                            'id' => 'subject-grid',
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
                                    'name' => 'teacher',
                                    'type' => 'raw',
                                    'value' => 'Teacher::getData($data->teacher,"teacher_name")',
                                    'filter' => CHtml::activeDropDownList($model, 'teacher', CHtml::listData(Teacher::model()->findAll(array('condition' => 'institution=' . Yii::app()->user->institution, 'order' => 'teacher_name')), 'id', 'teacher_name'), array('empty' => 'All', 'class' => 'select2')),
                                    'htmlOptions' => array('class' => ''),
                                ),
                                array(
                                    'name' => 'type',
                                    'value' => '$data->type',
                                    'filter' => CHtml::activeDropDownList($model, 'type', array('COMPULSARY' => 'COMPULSARY', 'CHOOSABLE' => 'CHOOSABLE', 'GROUP BASED' => 'GROUP BASED', 'UNCOUNTABLE' => 'UNCOUNTABLE'), array('empty' => 'All', 'class' => 'form-control')),
                                    'htmlOptions' => array('style' => "text-align:center;"),
                                ),
                                array(
                                    'name' => 'pass_mark',
                                    'type' => 'raw',
                                    'value' => '$data->pass_mark',
                                    'filter' => CHtml::activeTextField($model, 'pass_mark', array('class' => 'form-control')),
                                    'htmlOptions' => array('class' => ''),
                                ),
                                array(
                                    'name' => 'final_mark',
                                    'type' => 'raw',
                                    'value' => '$data->final_mark',
                                    'filter' => CHtml::activeTextField($model, 'final_mark', array('class' => 'form-control')),
                                    'htmlOptions' => array('class' => ''),
                                ),
                                array(
                                    'name' => 'subject',
                                    'type' => 'raw',
                                    'value' => '$data->subject',
                                    'filter' => CHtml::activeTextField($model, 'subject', array('class' => 'form-control')),
                                    'htmlOptions' => array('class' => ''),
                                ),
                                array(
                                    'name' => 'code',
                                    'type' => 'raw',
                                    'value' => '$data->code',
                                    'filter' => CHtml::activeTextField($model, 'code', array('class' => 'form-control')),
                                    'htmlOptions' => array('class' => ''),
                                ),
                                array(
                                    'name' => 'subject_serial',
                                    'type' => 'raw',
                                    'value' => '$data->subject_serial',
                                    'filter' => CHtml::activeTextField($model, 'subject_serial', array('class' => 'form-control')),
                                    'htmlOptions' => array('class' => 'text-center'),
                                ),
                                array(
                                    'name' => 'marge_id',
                                    'type' => 'raw',
                                    'value' => '$data->marge_id',
                                    'filter' => CHtml::activeTextField($model, 'marge_id', array('class' => 'form-control')),
                                    'htmlOptions' => array('class' => 'text-center'),
                                ),
                                array(
                                    'name' => 'student_group',
                                    'type' => 'raw',
                                    'value' => 'StudentGroup::getData($data->student_group,"title")',
                                    'filter' => CHtml::activeDropDownList($model, 'student_group', CHtml::listData(StudentGroup::model()->findAll(array('condition' => 'institution=' . Yii::app()->user->institution, 'order' => 'title')), 'id', 'title'), array('empty' => 'All', 'class' => 'select2')),
                                    'htmlOptions' => array('class' => ''),
                                ),
                                array(
                                    'name' => 'status',
                                    'value' => '$data->status',
                                    'filter' => CHtml::activeDropDownList($model, 'status', array('Active' => 'Active', 'Inactive' => 'Inactive'), array('empty' => 'All', 'class' => 'form-control')),
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