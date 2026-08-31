<?php
/* @var $this InstitutionController */
/* @var $model Institution */
/* @var $form CActiveForm */
?>

<div class="form">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'institution-form',
        'enableAjaxValidation' => false,
        'htmlOptions' => array('class' => 'smart-form', 'enctype' => 'multipart/form-data'),
    ));
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
                <label class="label"><?php echo $form->labelEx($model, 'institution'); ?></label>
                <label class="input">
                    <?php echo $form->textField($model, 'institution', array('maxlength' => 250, 'class' => 'col-sm-12', 'placeholder' => 'Institution')); ?>
                    <?php echo $form->error($model, 'institution'); ?>
                </label>
            </section>
            <section class="col col-6">
                <label class="label"><?php echo $form->labelEx($model, 'sub_title'); ?></label>
                <label class="input">
                    <?php echo $form->textField($model, 'sub_title', array('maxlength' => 250, 'class' => 'col-sm-12', 'placeholder' => 'Sub Title')); ?>
                    <?php echo $form->error($model, 'sub_title'); ?>
                </label>
            </section>
        </div>
        <div class="row">
            <section class="col col-6">
                <label class="label"><?php echo $form->labelEx($model, 'phone'); ?></label>
                <label class="input">
                    <?php echo $form->textField($model, 'phone', array('maxlength' => 11, 'class' => 'col-sm-12', 'placeholder' => 'Phone')); ?>
                    <?php echo $form->error($model, 'phone'); ?>
                </label>
            </section>
            <section class="col col-6">
                <label class="label"><?php echo $form->labelEx($model, 'email'); ?></label>
                <label class="input">
                    <?php echo $form->textField($model, 'email', array('maxlength' => 150, 'class' => 'col-sm-12', 'placeholder' => 'Email')); ?>
                    <?php echo $form->error($model, 'email'); ?>
                </label>
            </section>
        </div>             
        <div class="row">
            <section class="col col-6">
                <label class="label"><?php echo $form->labelEx($model, 'institute_code'); ?></label>
                <label class="input">
                    <?php echo $form->textField($model, 'institute_code', array('maxlength' => 50, 'class' => 'col-sm-12', 'placeholder' => 'Institute ID')); ?>
                    <?php echo $form->error($model, 'institute_code'); ?>
                </label>
            </section>
            <section class="col col-6">
                <label class="label"><?php echo $form->labelEx($model, 'mpo_code'); ?></label>
                <label class="input">
                    <?php echo $form->textField($model, 'mpo_code', array('maxlength' => 50, 'class' => 'col-sm-12', 'placeholder' => 'MPO Code')); ?>
                    <?php echo $form->error($model, 'mpo_code'); ?>
                </label>
            </section>
        </div>
        <div class="row">
            <section class="col col-6">
                <label class="label"><?php echo $form->labelEx($model, 'eiin'); ?></label>
                <label class="input">
                    <?php echo $form->textField($model, 'eiin', array('maxlength' => 50, 'class' => 'col-sm-12', 'placeholder' => 'EIIN NO.')); ?>
                    <?php echo $form->error($model, 'eiin'); ?>
                </label>
            </section>
            <section class="col col-6">
                <label class="label"><?php echo $form->labelEx($model, 'eastablished'); ?></label>
                <label class="input">
                    <?php echo $form->textField($model, 'eastablished', array('maxlength' => 50, 'class' => 'col-sm-12', 'placeholder' => 'Established')); ?>
                    <?php echo $form->error($model, 'eastablished'); ?>
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
                <label class="label"><?php echo $form->labelEx($model, 'footer'); ?></label>
                <label class="input">
                    <?php echo $form->textField($model, 'footer', array('maxlength' => 250, 'class' => 'col-sm-12', 'placeholder' => 'Footer')); ?>
                    <?php echo $form->error($model, 'footer'); ?>
                </label>
            </section>
        </div>
        <div class="row">
            <section class="col col-6">
                <label class="label"><?php echo $form->labelEx($model, 'logo'); ?></label>
                <label for="file" class="input input-file" onchange="this.parentNode.nextSibling.value = this.value">
                    <div class="button"><?php echo $form->fileField($model, 'logo', array('class' => '', 'onchange' => 'this.parentNode.nextSibling.value = this.value')); ?>Browse</div><input type="text" placeholder="Browse file" readonly="">
                    <?php echo $form->error($model, 'logo'); ?>
                </label>
            </section>
            <section class="col col-6">
                <label class="label"><?php echo $form->labelEx($model, 'signature'); ?></label>
                <label for="file" class="input input-file" onchange="this.parentNode.nextSibling.value = this.value">
                    <div class="button"><?php echo $form->fileField($model, 'signature', array('class' => '', 'onchange' => 'this.parentNode.nextSibling.value = this.value')); ?>Browse</div><input type="text" placeholder="Browse file" readonly="">
                    <?php echo $form->error($model, 'signature'); ?>
                </label>
            </section>
        </div>
        <div class="row">
            <section class="col col-6">
                <label class="label"><?php echo $form->labelEx($model, 'menu_logo'); ?></label>
                <label for="file" class="input input-file" onchange="this.parentNode.nextSibling.value = this.value">
                    <div class="button"><?php echo $form->fileField($model, 'menu_logo', array('class' => '', 'onchange' => 'this.parentNode.nextSibling.value = this.value')); ?>Browse</div><input type="text" placeholder="Browse file" readonly="">
                    <?php echo $form->error($model, 'menu_logo'); ?>
                </label>
            </section>
            <section class="col col-6">
                <label class="label"><?php echo $form->labelEx($model, 'special_logo'); ?></label>
                <label for="file" class="input input-file" onchange="this.parentNode.nextSibling.value = this.value">
                    <div class="button"><?php echo $form->fileField($model, 'special_logo', array('class' => '', 'onchange' => 'this.parentNode.nextSibling.value = this.value')); ?>Browse</div><input type="text" placeholder="Browse file" readonly="">
                    <?php echo $form->error($model, 'special_logo'); ?>
                </label>
            </section>
        </div>
        <div class="row">
            <section class="col col-6">
                <label class="label"><?php echo $form->labelEx($model, 'twitter'); ?></label>
                <label class="input">
                    <?php echo $form->textField($model, 'twitter', array('maxlength' => 150, 'class' => 'col-sm-12', 'placeholder' => 'Twitter')); ?>
                    <?php echo $form->error($model, 'twitter'); ?>
                </label>
            </section>
            <section class="col col-6">
                <label class="label"><?php echo $form->labelEx($model, 'facebook'); ?></label>
                <label class="input">
                    <?php echo $form->textField($model, 'facebook', array('maxlength' => 150, 'class' => 'col-sm-12', 'placeholder' => 'Facebook')); ?>
                    <?php echo $form->error($model, 'facebook'); ?>
                </label>
            </section>
        </div>
        <div class="row">
            <section class="col col-6">
                <label class="label"><?php echo $form->labelEx($model, 'instagram'); ?></label>
                <label class="input">
                    <?php echo $form->textField($model, 'instagram', array('maxlength' => 150, 'class' => 'col-sm-12', 'placeholder' => 'Instagram')); ?>
                    <?php echo $form->error($model, 'instagram'); ?>
                </label>
            </section>
            <section class="col col-6">
                <label class="label"><?php echo $form->labelEx($model, 'youtube'); ?></label>
                <label class="input">
                    <?php echo $form->textField($model, 'youtube', array('maxlength' => 150, 'class' => 'col-sm-12', 'placeholder' => 'Youtube')); ?>
                    <?php echo $form->error($model, 'youtube'); ?>
                </label>
            </section>
        </div>
        <div class="row">
            <section class="col col-10">
                <label class="label"><?php echo $form->labelEx($model, 'map'); ?></label>
                <label class="textarea textarea-resizable">
                    <?php echo $form->textArea($model, 'map', array('rows' => 2, 'class' => 'custom-scroll')); ?>                    
                    <?php echo $form->error($model, 'map'); ?>
                </label>
            </section>
        </div>
    </fieldset>
    <footer>
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => 'btn btn-primary')); ?>
    </footer>
    <?php $this->endWidget(); ?>
</div><!-- form -->