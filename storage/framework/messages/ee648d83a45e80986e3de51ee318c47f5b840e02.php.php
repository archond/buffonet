<?php $__env->startSection('content'); ?>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3><?php echo e(_('Send request to rate object(s)')); ?>:</h3>
        </div>

        <div class="panel-body">


            <?php echo e(Form::open(['route'=> 'rating.ask-for-rating', 'method'=>'post'])); ?>

            <div class="form-group row">
                <label for="sss" class="col-sm-5 form-control-label"><?php echo e(_('Ask for rating following contacts')); ?>:</label>
                <div class="col-sm-7">
                    <ul>
                        <?php foreach($contacts as $contact): ?>
                            <li><a href="<?php echo e(route('contacts.show', $contact->id)); ?>"
                                   target="_blank"><?php echo e(isset($contact->contactDetailValues->first()->value) ? $contact->contactDetailValues->first()->value : 'no title'); ?></a></li>
                            <input type="hidden" name="contact[]" value="<?php echo e($contact->id); ?>">
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>


            <div class="form-group row">
                <label for="emails_list" class="col-sm-2 form-control-label"><?php echo e(_('Email')); ?></label>
                <div class="col-sm-10">
                    <textarea name="emails_list" id="emails_list" class="form-control" rows="1"></textarea>
                </div>
            </div>

            <div class="form-group row">
                <?php echo Form::label('message_text', _('Message'), ['class'=>'col-sm-2 form-control-label']); ?>

                <div class="col-sm-10">
                    <?php echo e(Form::textarea('message_text', null,  ['class'=>'form-control', 'placeholder'=>_('Input message')])); ?>

                </div>
            </div>


            <input type="submit" class="btn btn-info pull-right" value="<?php echo e(_('Send request')); ?>">
            <?php echo e(Form::close()); ?>

        </div>


    </div>





<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    <script type="text/javascript">
        $('#emails_list')
                .textext({
                    plugins: 'autocomplete filter tags ajax',
                    ajax: {
                        url: '<?php echo e(route('ajax.get-contacts-emais')); ?>',
                        dataType: 'json',
//                        cacheResults : true
                    }
                }).bind('isTagAllowed', function (e, data) {
            var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
//                    return regex.test(email);

            if (!regex.test(data.tag)) {
                data.result = false;
            }
        });

    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>