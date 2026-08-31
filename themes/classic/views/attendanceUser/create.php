<?php
/* @var $this AttendanceUserController */
/* @var $model AttendanceUser */
$this->pageTitle = 'New User Attendance';
$this->breadcrumbs = array(
    'Attendance Users' => array('admin'),
    'Create',
);
?>
<script>
    $(function () {
        $('.datepicker').datepicker({dateFormat: "yy-mm-dd"});
    });
</script>
<div class="row">
    <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
        <h1 class="page-title txt-color-blueDark">
            <i class="fa fa-home fa-fw "></i> 
            User Attendance
            <span>> 
                New Attendance
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
                    <h2>New Attendance</h2>	
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
                        <?php
                        $form = $this->beginWidget('CActiveForm', array(
                            'id' => 'user-attendance-form',
                            'enableAjaxValidation' => false,
                            'htmlOptions' => array('class' => 'smart-form'),
                        ));
                        ?>
                        <table class="table table-bordered table-condensed table-responsive">
                            <thead>
                                <tr>
                                    <th class="text-center">SL#</th>
                                    <th class="text-center">Photo</th>
                                    <th class="text-left">User Name</th>    
                                    <th class="text-left">Email</th>  
                                    <th>Attendance</th>
                                </tr>
                            </thead>
                            <tbody>                                
                                <?php
                                $i = 1;
                                $array = User::model()->findAll(array('condition' => 'institution=' . Yii::app()->user->institution . ' AND group_id>3 AND status=1', 'order' => 'full_name'));
                                foreach ($array as $key => $value) {
                                    echo $form->hiddenField($model, "[$i]userid", array('value' => $value['id']));
                                    echo '<tr>';
                                    echo '<td class="text-center width-50">' . $i . '</td>';
                                    echo '<td class="text-center width-50">' . User::getPhoto($value['id']) . '</td>';
                                    echo '<td class="text-left">' . $value['full_name'] . '</td>';
                                    echo '<td class="text-left">' . $value['email'] . '</td>';
                                    echo '<td><label class="select state-error">' . $form->dropDownList($model, "[$i]attendance", array('Present' => 'Present', 'Late Present With Excuse' => 'Late Present With Excuse', 'Late Present' => 'Late Present', 'Absent' => 'Absent', 'Half Day' => 'Half Day'), array('class' => 'form-control')) . '</label></td>';
                                    echo '</tr>';
                                    $i++;
                                }
                                ?>
                                <tr>
                                    <td colspan="5">
                                        <label class="label text-right" style="margin-top: 4px;"><?php echo $form->labelEx($model, 'attendance_in'); ?></label>                                        
                                    </td>
                                    <td colspan="1">
                                        <label class="input state-error">
                                            <?php echo $form->textField($model, 'attendance_in', array('class' => 'form-control datepicker', 'value' => date('Y-m-d'), 'data-dateformat' => 'yy-mm-dd', 'readonly' => true, 'placeholder' => 'Attendance Date')); ?>
                                        </label>                                        
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <footer>
                            <?php echo CHtml::submitButton('PROCESS USER ATTENDANCE', array('class' => 'btn btn-primary')); ?>
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