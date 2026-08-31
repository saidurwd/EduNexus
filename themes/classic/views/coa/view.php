<?php
/* @var $this CoaController */
/* @var $model Coa */

$this->breadcrumbs=array(
	'Coas'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Coa', 'url'=>array('index')),
	array('label'=>'Create Coa', 'url'=>array('create')),
	array('label'=>'Update Coa', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Coa', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Coa', 'url'=>array('admin')),
);
?>

<h1>View Coa #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'parent',
		'account_code',
		'account_title',
		'status',
	),
)); ?>
