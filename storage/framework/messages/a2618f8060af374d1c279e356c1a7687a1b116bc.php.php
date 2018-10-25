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
        <?php echo e(Form::text('a', $title, ['class'=>'form-control', 'placeholder'=>_('Title is missing'), 'disabled'])); ?>

    </div>
</div>

<div class="form-group">
    <?php echo Form::label(_('to:'), null, ['class'=>'col-sm-2 control-label']); ?>

    <div class="col-sm-10">
        <?php echo e(Form::text('emails_list', null,  ['class'=>'', 'placeholder'=>_('Input emails'), 'id'=>'emails_list' ])); ?>

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
<?php echo e(Form::hidden('contact_id', $contact->id )); ?>

<?php /*<?php echo e(Form::hidden('data', json_encode($data))); ?>*/ ?>


<?php $__env->startSection('js'); ?>
    <script type="text/javascript">
        $('#emails_list')
                .textext({
                    plugins: 'autocomplete filter tags ajax',
                    tagsItems: [<?php echo isset($emails)  ?  $emails : null; ?> ],
//                    tagsItems: ["abc", "123"],
                    ajax: {
                        url: '<?php echo e(route('ajax.get-contacts-emais')); ?>',
                        dataType: 'json',
//                        cacheResults : true
                    },
                    loadingMessage: '<?php echo e(_('Loading....')); ?>',
                }).bind('isTagAllowed', function (e, data) {
            var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
//                    return regex.test(email);

            if (!regex.test(data.tag)) {
                data.result = false;
            }
        });

    </script>
<?php $__env->stopSection(); ?>