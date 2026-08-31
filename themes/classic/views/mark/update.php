<?php
/* @var $this MarkController */
/* @var $model Mark */
$this->pageTitle = 'Edit Marks';
$this->breadcrumbs = array(
    'Marks' => array('admin'),
    $model->id => array('view', 'id' => $model->id),
    'Update',
);
?>
<div class="row">
    <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
        <h1 class="page-title txt-color-blueDark">
            <i class="fa fa-home fa-fw "></i> 
            Marks 
            <span>> 
                Edit Marks
            </span>
        </h1>
    </div>
    <div class="col-xs-12 col-sm-5 col-md-5 col-lg-8">
    </div>
</div>
<!-- widget grid -->
<section id="widget-grid" class="">
    <!-- START ROW -->
    <div class="row">
        <!-- NEW COL START -->
        <article class="col-sm-12 col-md-12 col-lg-12">
            <!-- Widget ID (each widget will need unique ID)-->
            <div class="jarviswidget" id="wid-id-4" data-widget-editbutton="false" data-widget-custombutton="false">
                <header>
                    <span class="widget-icon"> <i class="fa fa-plus"></i> </span>
                    <h2>Edit Marks</h2>	
                    <div class="widget-toolbar">
                        <?php echo CHtml::link('<i class="fa fa-home"></i> MANAGE', array('admin'), array('data-rel' => 'tooltip', 'title' => 'Manage', 'data-placement' => 'bottom', 'class' => 'btn btn-xs btn-primary')); ?>
                    </div>
                </header>
                <!-- widget div-->
                <div>
                    <!-- widget edit box -->
                    <div class="jarviswidget-editbox">
                        <!-- This area used as dropdown edit box -->
                    </div>
                    <!-- end widget edit box -->
                    <!-- widget content -->
                    <div class="widget-body no-padding">      
                        <?= Institution::getAlertInfo('Note:', '<strong>Class:</strong> ' . Classs::getData($model_parent->class,"class") . ' <strong>Section:</strong> ' . Section::getData($model_parent->section,"section") . ' <strong>Subject:</strong> ' . Subject::getData($model_parent->subject, "subject") . ' <strong>Group:</strong> ' . StudentGroup::getData($model_parent->group, "title") . ' <strong>Exam:</strong> ' . Exam::getData($model_parent->exam, "exam_name") . ' <strong>Academic Year:</strong> ' . AcademicYear::getData($model_parent->academic_year,"title")) ?>                  
                        <?php
                        $form = $this->beginWidget('CActiveForm', array(
                            'id' => 'mark-form',
                            'enableAjaxValidation' => false,
                            'htmlOptions' => array('class' => 'smart-form'),
                        ));
                        $class_written = $modelSubjectMark->written <= 0 ? 'class="column-hide"' : '';
                        $class_mcq = $modelSubjectMark->mcq <= 0 ? 'class="column-hide"' : '';
                        $class_practical = $modelSubjectMark->practical <= 0 ? 'class="column-hide"' : '';
                        $class_ca = $modelSubjectMark->class_assessment <= 0 ? 'class="column-hide"' : '';
                        ?>
                        <table class="table table-bordered table-condensed table-responsive">
                            <thead>
                                <tr>
                                    <th class="text-center">SL#</th>
                                    <th class="text-center">Photo</th>
                                    <th class="text-left">Student Name</th>
                                    <th class="text-center">SID</th>
                                    <th class="text-center">Roll</th>
                                    <th <?php echo $class_written; ?>>Written (<?php echo $modelSubjectMark->written; ?>)</th>
                                    <th <?php echo $class_mcq; ?>>MCQ (<?php echo $modelSubjectMark->mcq; ?>)</th>
                                    <th <?php echo $class_practical; ?>>Practical (<?php echo $modelSubjectMark->practical; ?>)</th>
                                    <th <?php echo $class_ca; ?>>Assessment (<?php echo $modelSubjectMark->class_assessment; ?>)</th>
                                    <th>Presence</th>
                                </tr>
                            </thead>
                            <tbody>                                
                                <?php
                                $i = 1;
                                $array = Mark::model()->findAll(array('condition' => 'institution=' . $model_parent->institution . ' AND class=' . $model_parent->class . ' AND section=' . $model_parent->section . ' AND `subject`=' . $model_parent->subject . ' AND `group`=' . $model_parent->group . ' AND `exam`=' . $model_parent->exam . ' AND `academic_year`=' . $model_parent->academic_year, 'order' => 'id'));
                                foreach ($array as $key => $value) {
                                    echo $form->hiddenField($model, "[$i]markid", array('value' => $value['id']));
                                    echo '<tr>';
                                    echo '<td class="text-center">' . $i . '</td>';
                                    echo '<td class="text-center">' . Student::getPhotoAdmitCard($value['student'], 40) . '</td>';
                                    echo '<td class="text-left">' . Student::getData($value['student'], 'name') . '</td>';
                                    echo '<td class="text-center">' . Student::getData($value['student'], 'sid') . '</td>';
                                    echo '<td class="text-center">' . Student::getData($value['student'], 'roll') . '</td>';
                                    echo '<td ' . $class_written . '><label class="input">' . $form->textField($model, "[$i]written", array('value' => $value['written'], 'maxlength' => 6, 'class' => 'form-control')) . '</label></td>';
                                    echo '<td ' . $class_mcq . '><label class="input">' . $form->textField($model, "[$i]mcq", array('value' => $value['mcq'], 'maxlength' => 6, 'class' => 'form-control')) . '</label></td>';
                                    echo '<td ' . $class_practical . '><label class="input">' . $form->textField($model, "[$i]practical", array('value' => $value['practical'], 'maxlength' => 6, 'class' => 'form-control')) . '</label></td>';
                                    echo '<td ' . $class_ca . '><label class="input">' . $form->textField($model, "[$i]class_assessment", array('value' => $value['class_assessment'], 'maxlength' => 6, 'class' => 'form-control')) . '</label></td>';
                                    echo '<td><label class="input">' . $form->dropDownList($model, "[$i]absence", array('No' => 'Present', 'Yes' => 'Absent'), array('class' => 'select2')) . '</label></td>';
                                    echo '</tr>';
                                    $i++;
                                }
                                ?>
                            </tbody>
                        </table>
                        <footer>
                            <?php echo CHtml::submitButton('SAVE MARKS', array('class' => 'btn btn-primary')); ?>
                        </footer>
                        <?php $this->endWidget(); ?>
                    </div>
                    <!-- end widget content -->
                </div>
                <!-- end widget div -->
            </div>
            <!-- end widget -->
        </article>
        <!-- END COL -->		
    </div>
    <!-- END ROW -->
</section>
<!-- end widget grid -->