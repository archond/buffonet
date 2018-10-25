<?php $__env->startSection('content'); ?>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3><?php echo e(_('Send mail to Contact')); ?>:</h3>
        </div>

        <div class="panel-body">


            <?php echo e(Form::open(['route'=> ['contacts.send-mail-send', $contact->id ], 'method'=>'post'])); ?>



            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 form-control-label"><?php echo e(_('Email')); ?></label>
                <div class="col-sm-10">
                    <textarea name="emails_list" id="emails_list" class="form-control" rows="1"></textarea>
                </div>
            </div>

            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 form-control-label"><?php echo e(_('Subject')); ?></label>
                <div class="col-sm-10">
                    <input type="text" name="subject" id="subject" class="form-control"></input>
                </div>
            </div>

            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 form-control-label"><?php echo e(_('Message')); ?></label>
                <div class="col-sm-10">
                    <textarea name="message" id="message" class="form-control" rows="8"></textarea>
                </div>
            </div>

            <input type="submit" class="btn btn-info pull-right" value="<?php echo e(_('Send message')); ?>">
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
                    },
                    tagsItems: [<?php echo isset($emails)  ?  $emails : null; ?> ],
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