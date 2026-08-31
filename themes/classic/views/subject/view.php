<?php
/* @var $this SubjectController */
/* @var $model Subject */

$this->breadcrumbs = array(
    'Subjects' => array('index'),
    $model->id,
);
?>

<h1>View Subject #<?php echo $model->id; ?></h1>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        'id',
        'institution',
        'class',
        'teacher',
        'type',
        'pass_mark',
        'final_mark',
        'subject',
        'code',
        'effect',
        'religion_subject',
        'religion',
        'student_group',
        'note',
        'status',
    ),
));
?>
