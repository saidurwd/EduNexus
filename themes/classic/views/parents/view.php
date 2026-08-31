<?php
/* @var $this ParentsController */
/* @var $model Parents */

$this->breadcrumbs = array(
    'Parents' => array('index'),
    $model->id,
);
?>

<h1>View Parents #<?php echo $model->id; ?></h1>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        'id',
        'institution',
        'guardian_name',
        'father',
        'mother',
        'father_profession',
        'mother_profession',
        'email',
        'phone',
        'address',
        'photo',
        'status',
    ),
));
?>
