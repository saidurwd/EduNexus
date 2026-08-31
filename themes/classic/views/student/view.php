<?php
/* @var $this StudentController */
/* @var $model Student */

$this->breadcrumbs = array(
    'Students' => array('index'),
    $model->name,
);
?>

<h1>View Student #<?php echo $model->id; ?></h1>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        'id',
        'institution',
        'name',
        'guardian',
        'birth_date',
        'gender',
        'blood_group',
        'religion',
        'email',
        'phone',
        'address',
        'city',
        'country',
        'nationality',
        'sid',
        'class',
        'section',
        'group',
        'optional_subject',
        'roll',
        'photo',
        'remarks',
        'status',
        'created_on',
        'updated_on',
        'created_by',
        'updated_by',
    ),
));
?>
