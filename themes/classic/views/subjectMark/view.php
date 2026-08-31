<?php
/* @var $this SubjectMarkController */
/* @var $model SubjectMark */

$this->breadcrumbs=array(
	'Subject Marks'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List SubjectMark', 'url'=>array('index')),
	array('label'=>'Create SubjectMark', 'url'=>array('create')),
	array('label'=>'Update SubjectMark', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete SubjectMark', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage SubjectMark', 'url'=>array('admin')),
);
?>

<h1>View SubjectMark #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'institution',
		'class',
		'subject',
		'written',
		'mcq',
		'practical',
		'class_assessment',
		'full_mark',
		'with_class_assessment',
		'passed_separately',
		'calculate_percent',
		'created_on',
		'updated_on',
		'created_by',
		'updated_by',
		'status',
	),
)); ?>
