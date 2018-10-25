<?php if(isset($errors) && count($errors) > 0): ?>
    <div class="alert alert-danger">
        <ul>
            <?php foreach($errors->all() as $error): ?>
                <li><?php echo e($error); ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<div class="form-group">
    <?php echo Form::label(_('Request for contact:'), null, ['class'=>'col-sm-2 control-label']); ?>

    <div class="col-sm-10">
        <?php echo e(Form::textarea('a', $title, ['class'=>'form-control', 'placeholder'=>_('Title is missing'), 'disabled'])); ?>

    </div>
</div>




<?php foreach($stages as $stage): ?>
    <?php if($stage->is_contact_data_stage): ?>
        <div class="form-group">
            <?php echo Form::label(_('stages'), $stage->name, ['class'=>'col-sm-2 control-label']); ?>

            <div class="col-sm-10">
                <?php echo Form::checkbox('stages[]',  $stage->id, null , ['class'=>'form-control1', 'placeholder'=>'Input name'] ); ?>

            </div>
        </div>
    <?php endif; ?>
<?php endforeach; ?>

<div class="form-group">
    <?php echo Form::label(_('Message'), null, ['class'=>'col-sm-2 control-label']); ?>

    <div class="col-sm-10">
        <?php echo e(Form::textarea('message_text', null,  ['class'=>'form-control', 'placeholder'=>_('Input message')])); ?>

    </div>
</div>
<?php echo e(Form::hidden('contacts', implode(',',$contacts ))); ?>

<?php /*<?php echo e(Form::hidden('data', json_encode($data))); ?>*/ ?>


