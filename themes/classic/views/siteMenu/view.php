<?php
/* @var $this SiteMenuController */
/* @var $model SiteMenu */

$this->breadcrumbs=array(
	'Site Menus'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>'List SiteMenu', 'url'=>array('index')),
	array('label'=>'Create SiteMenu', 'url'=>array('create')),
	array('label'=>'Update SiteMenu', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete SiteMenu', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage SiteMenu', 'url'=>array('admin')),
);
?>

<h1>View SiteMenu #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'parent',
		'title',
		'component',
		'action',
		'identity',
		'ordering',
		'status',
	),
)); ?>
