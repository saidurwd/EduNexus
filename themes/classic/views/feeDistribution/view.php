<?php
/* @var $this FeeDistributionController */
/* @var $model FeeDistribution */

$this->breadcrumbs=array(
	'Fee Distributions'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List FeeDistribution', 'url'=>array('index')),
	array('label'=>'Create FeeDistribution', 'url'=>array('create')),
	array('label'=>'Update FeeDistribution', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete FeeDistribution', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage FeeDistribution', 'url'=>array('admin')),
);
?>

<h1>View FeeDistribution #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'institution',
		'fee_type',
		'class',
		'section',
		'amount',
		'status',
	),
)); ?>
