<?php $__env->startSection('content'); ?>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><?php echo e(_('Create new City')); ?></h3>
        </div>
        <div class="panel-body">


            <?php echo Form::model('city', ['class'=>'form-horizontal', 'method'=>'post','files'=>'true','route' => ['cities.store']]); ?>

            <?php echo $__env->make('cities.form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

            <div class="form-group">
                <?php echo Form::label('', '', ['class'=>'col-sm-2 control-label']); ?>

                <div class="col-sm-10">
                    <?php echo Form::submit('Save', ['class'=>'btn']); ?>

                </div>
                <?php echo Form::close(); ?>

            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>