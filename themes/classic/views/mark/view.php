<?php
/* @var $this MarkController */
/* @var $model Mark */

$this->breadcrumbs=array(
	'Marks'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Mark', 'url'=>array('index')),
	array('label'=>'Create Mark', 'url'=>array('create')),
	array('label'=>'Update Mark', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Mark', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Mark', 'url'=>array('admin')),
);
?>

<h1>View Mark #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'institution',
		'student',
		'class',
		'section',
		'group',
		'subject',
		'exam',
		'academic_year',
		'calculate_percent',
		'full_mark',
		'highest_mark',
		'written',
		'mcq',
		'practical',
		'class_assessment',
		'absence',
		'subject_total',
		'letter_grade',
		'gpa',
		'created_on',
		'updated_on',
		'created_by',
		'updated_by',
	),
)); ?>
