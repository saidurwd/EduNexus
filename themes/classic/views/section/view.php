<?php
/* @var $this SectionController */
/* @var $model Section */

$this->breadcrumbs=array(
	'Sections'=>array('index'),
	$model->id,
);
?>

<h1>View Section #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'institution',
		'section',
		'category',
		'class',
		'capacity',
		'teacher',
		'note',
		'status',
	),
)); ?>
