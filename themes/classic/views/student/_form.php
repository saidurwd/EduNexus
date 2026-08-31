<?php
/* @var $this StudentController */
/* @var $model Student */
/* @var $form CActiveForm */
?>

<div class="form">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'student-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation' => false,
        'htmlOptions' => array('class' => 'smart-form', 'enctype' => 'multipart/form-data'),
    ));
    Yii::app()->clientScript->registerScript('chained', '
    $(document).ready(function(){
        $("#Student_city").chained("#Student_country");
        $("#Student_section").chained("#Student_class");
        $("#Student_group").chained("#Student_class");
        $("#Student_shift").chained("#Student_class");
        $("#Student_optional_subject").chained("#Student_class");
    });
', CClientScript::POS_END);
    ?>
    <fieldset>
        <div class="row">
            <section class="col col-12">
                <p class="note">Fields with <span class="required">*</span> are required.</p>
            </section>
        </div>
        <div class="row">
            <section class="col col-12">
                <?php echo $form->errorSummary($model, '<i class="fa fa-bell text-danger"></i> Please fix the following input errors:', '', array('class' => 'text-danger', 'style' => 'padding-left:20px;')); ?>
            </section>
        </div>                
        <div class="row">
            <section class="col col-6">
                <label class="label"><?php echo $form->labelEx($model, 'name'); ?></label>
                <label class="input">
                    <?php echo $form->textField($model, 'name', array('maxlength' => 150, 'class' => 'col-sm-12', 'placeholder' => 'Name')); ?>
                    <?php echo $form->error($model, 'name'); ?>
                </label>
            </section>            
            <?php if (!$model->isNewRecord && isset($model->guardian)) { ?>
                <section class="col col-5">
                    <label class="label"><?php echo $form->labelEx($model, 'guardian'); ?></label>
                    <label class="input">
                        <?php echo $form->dropDownList($model, 'guardian', CHtml::listData(Parents::model()->findAll(array('condition' => 'status="Active" AND institution=' . Yii::app()->user->institution)), 'id', 'guardian_name'), array('empty' => 'Select Guardian', 'class' => 'select2')); ?>
                        <?php echo $form->error($model, 'guardian'); ?>
                    </label>
                </section>
                <section class="col col-1">
                    <label class="label">&nbsp;</label>
                    <?php echo CHtml::link('UPDATE', array('parents/update', 'id' => $model->guardian), array('title' => 'Update Guardian', 'target' => '_blank', 'class' => 'btn btn-info btn-sm btn-block')); ?>
                </section>

            <?php } else { ?>
                <section class="col col-6">
                    <label class="label"><?php echo $form->labelEx($model, 'guardian'); ?></label>
                    <label class="input">
                        <?php echo $form->dropDownList($model, 'guardian', CHtml::listData(Parents::model()->findAll(array('condition' => 'status="Active" AND institution=' . Yii::app()->user->institution)), 'id', 'guardian_name'), array('empty' => 'Select Guardian', 'class' => 'select2')); ?>
                        <?php echo $form->error($model, 'guardian'); ?>
                    </label>
                </section>
            <?php } ?>
        </div>
        <div class="row">
            <section class="col col-6">
                <label class="label"><?php echo $form->labelEx($model, 'birth_date'); ?></label>
                <label class="input">
                    <div class="input-group">
                        <?php echo $form->textField($model, 'birth_date', array('class' => 'col-sm-12 datepicker', 'placeholder' => 'Date of Birth', 'data-dateformat' => 'yy-mm-dd')); ?>
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                    </div>
                    <?php echo $form->error($model, 'birth_date'); ?>
                </label>
            </section>
            <section class="col col-6">
                <label class="label"><?php echo $form->labelEx($model, 'gender'); ?></label>
                <label class="select">
                    <?php echo $form->dropDownList($model, 'gender', array('Male' => 'Male', 'Female' => 'Female', 'Other' => 'Other'), array('class' => 'select2')); ?>
                    <?php echo $form->error($model, 'gender'); ?>
                </label>
            </section>
        </div>
        <div class="row">
            <section class="col col-6">
                <label class="label"><?php echo $form->labelEx($model, 'blood_group'); ?></label>
                <label class="select">
                    <?php echo $form->dropDownList($model, 'blood_group', array('A+' => 'A+', 'A-' => 'A-', 'B+' => 'B+', 'B-' => 'B-', 'O+' => 'O+', 'O-' => 'O-', 'AB+' => 'AB+', 'AB-' => 'AB-'), array('class' => 'select2')); ?>
                    <?php echo $form->error($model, 'blood_group'); ?>
                </label>
            </section>
            <section class="col col-6">
                <label class="label"><?php echo $form->labelEx($model, 'religion'); ?></label>
                <label class="select">
                    <?php echo $form->dropDownList($model, 'religion', array('Islam' => 'Islam', 'Christianity' => 'Christianity', 'Hinduism' => 'Hinduism', 'Buddhism' => 'Buddhism'), array('class' => 'select2')); ?>
                    <?php echo $form->error($model, 'religion'); ?>
                </label>
            </section>
        </div>              
        <div class="row">
            <section class="col col-6">
                <label class="label"><?php echo $form->labelEx($model, 'email'); ?></label>
                <label class="input">
                    <i class="icon-prepend fa fa-envelope"></i>
                    <?php echo $form->textField($model, 'email', array('maxlength' => 150, 'class' => '', 'placeholder' => 'Email')); ?>
                    <?php echo $form->error($model, 'email'); ?>
                </label>
            </section>
            <section class="col col-6">
                <label class="label"><?php echo $form->labelEx($model, 'phone'); ?></label>
                <label class="input">
                    <i class="icon-prepend fa fa-mobile-phone"></i>
                    <?php echo $form->textField($model, 'phone', array('maxlength' => 10, 'class' => '', 'placeholder' => 'Phone')); ?>
                    <b class="tooltip tooltip-top-left"><i class="fa fa-warning txt-color-teal"></i> Mobile number without +880</b>
                    <?php echo $form->error($model, 'phone'); ?>
                </label>
            </section>
        </div>
        <div class="row">
            <section class="col col-6">
                <label class="label"><?php echo $form->labelEx($model, 'address'); ?></label>
                <label class="input">
                    <?php echo $form->textField($model, 'address', array('maxlength' => 250, 'class' => 'col-sm-12', 'placeholder' => 'Address')); ?>
                    <?php echo $form->error($model, 'address'); ?>
                </label>
            </section>
            <section class="col col-6">
                <label class="label"><?php echo $form->labelEx($model, 'nationality'); ?></label>
                <label class="input">
                    <?php echo $form->dropDownList($model, 'nationality', CHtml::listData(Country::model()->findAll(array('condition' => 'status="Active"')), 'id', 'title'), array('empty' => 'Select Nationality', 'class' => 'select2')); ?>
                    <?php echo $form->error($model, 'nationality'); ?>
                </label>
            </section>
        </div>
        <div class="row">
            <section class="col col-6">
                <label class="label"><?php echo $form->labelEx($model, 'country'); ?></label>
                <label class="input">
                    <?php echo $form->dropDownList($model, 'country', CHtml::listData(Country::model()->findAll(array('condition' => 'status="Active"')), 'id', 'title'), array('empty' => 'Select Country', 'class' => 'select2')); ?>
                    <?php echo $form->error($model, 'country'); ?>
                </label>
            </section>
            <section class="col col-6">
                <label class="label"><?php echo $form->labelEx($model, 'city'); ?></label>
                <label class="input">
                    <?php echo City::getCity('Student', 'city', $model->city); ?>
                    <?php echo $form->error($model, 'city'); ?>
                </label>
            </section>
        </div>
        <div class="row">
            <section class="col col-6">
                <label class="label"><?php echo $form->labelEx($model, 'sid'); ?></label>
                <label class="input">
                    <?php echo $form->textField($model, 'sid', array('maxlength' => 11, 'class' => 'col-sm-12', 'placeholder' => 'Student ID')); ?>
                    <?php echo $form->error($model, 'sid'); ?>
                </label>
            </section>
            <section class="col col-6">
                <label class="label"><?php echo $form->labelEx($model, 'class'); ?></label>
                <label class="input">
                    <?php echo $form->dropDownList($model, 'class', CHtml::listData(Classs::model()->findAll(array('condition' => 'status="Active" AND institution=' . Yii::app()->user->institution)), 'id', 'class'), array('empty' => 'Select Class', 'class' => 'select2')); ?>
                    <?php echo $form->error($model, 'class'); ?>
                </label>
            </section>
        </div>
        <div class="row">
            <section class="col col-6">
                <label class="label"><?php echo $form->labelEx($model, 'section'); ?></label>
                <label class="input">
                    <?php echo Section::getSection('Student', 'section', $model->section); ?>
                    <?php echo $form->error($model, 'section'); ?>
                </label>
            </section>
            <section class="col col-6">
                <label class="label"><?php echo $form->labelEx($model, 'group'); ?></label>
                <label class="input">
                    <?php echo StudentGroup::getStudentGroup('Student', 'group', $model->group); ?>
                    <?php echo $form->error($model, 'group'); ?>
                </label>
            </section>
        </div>
        <div class="row">
            <section class="col col-6">
                <label class="label"><?php echo $form->labelEx($model, 'optional_subject'); ?></label>
                <label class="input">
                    <?php echo Subject::getOptionalSubject('Student', 'optional_subject', $model->optional_subject); ?>
                    <?php echo $form->error($model, 'optional_subject'); ?>
                </label>
            </section>
            <section class="col col-6">
                <label class="label"><?php echo $form->labelEx($model, 'academic_year'); ?></label>
                <label class="input">
                    <?php echo $form->dropDownList($model, 'academic_year', CHtml::listData(AcademicYear::model()->findAll(array('condition' => 'institution=' . Yii::app()->user->institution)), 'id', 'title'), array('empty' => 'Select Academic Year', 'class' => 'select2')); ?>
                    <?php echo $form->error($model, 'academic_year'); ?>
                </label>
            </section>
        </div>
        <div class="row">
            <section class="col col-6">
                <label class="label"><?php echo $form->labelEx($model, 'roll'); ?></label>
                <label class="input">
                    <?php echo $form->textField($model, 'roll', array('maxlength' => 11, 'class' => 'col-sm-12', 'placeholder' => 'Roll')); ?>
                    <?php echo $form->error($model, 'roll'); ?>
                </label>
            </section>
            <section class="col col-3">
                <label class="label"><?php echo $form->labelEx($model, 'shift'); ?></label>
                <label class="input">
                    <?php echo Shift::getShift('Student', 'shift', $model->shift); ?>
                    <?php echo $form->error($model, 'shift'); ?>
                </label>
            </section>
            <section class="col col-3">
                <label class="label"><?php echo $form->labelEx($model, 'status'); ?></label>
                <label class="select">
                    <?php echo $form->dropDownList($model, 'status', array('ACTIVE' => 'ACTIVE', 'INACTIVE' => 'INACTIVE', 'TRANSFERRED' => 'TRANSFERRED', 'EXPIRE' => 'EXPIRE', 'PENDING' => 'PENDING'), array('class' => 'select2')); ?>
                    <?php echo $form->error($model, 'status'); ?>
                </label>
            </section>
        </div>
        <div class="row">
            <section class="col col-6">
                <label class="label"><?php echo $form->labelEx($model, 'remarks'); ?></label>
                <label class="input">
                    <?php echo $form->textField($model, 'remarks', array('maxlength' => 250, 'class' => 'col-sm-12', 'placeholder' => 'Remarks')); ?>
                    <?php echo $form->error($model, 'remarks'); ?>
                </label>
            </section>
            <section class="col col-6">
                <label class="label"><?php echo $form->labelEx($model, 'photo'); ?></label>
                <label for="file" class="input input-file" onchange="this.parentNode.nextSibling.value = this.value">
                    <div class="button"><?php echo $form->fileField($model, 'photo', array('class' => '', 'onchange' => 'this.parentNode.nextSibling.value = this.value')); ?>Browse</div><input type="text" placeholder="Browse file" readonly="">
                    <?php echo $form->error($model, 'photo'); ?>
                </label>
            </section>
        </div>
        <?= Institution::getAlertWarning('Note:', 'Create relevant Academic Year, Teacher, Student Group, Shift, Class, Section &amp; Subject before you add Student.') ?>
    </fieldset>
    <footer>
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => 'btn btn-primary')); ?>
    </footer>
    <?php $this->endWidget(); ?>
</div><!-- form -->