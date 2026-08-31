<?php
/* @var $this FeeTypeController */
/* @var $model FeeType */

$this->breadcrumbs=array(
	'Fee Types'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>'List FeeType', 'url'=>array('index')),
	array('label'=>'Create FeeType', 'url'=>array('create')),
	array('label'=>'Update FeeType', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete FeeType', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage FeeType', 'url'=>array('admin')),
);
?>

<h1>View FeeType #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'institution',
		'title',
		'note',
		'monthly',
		'status',
	),
)); ?>
