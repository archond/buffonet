<?php $__env->startSection('content'); ?>


    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><?php echo e(_('Rating Form')); ?></h3>
        </div>
        <div class="panel-body">


            <?php echo Form::model($rating, ['class'=>'form-horizontal', 'method'=>'put','files'=>'true','route' => ['rating.admin-do-rating-update', $rating->id] ]); ?>



            <?php echo $__env->make('ratings.feedback.form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

            <?php if($readonly !='readonly'): ?>
                <div class="form-group">
                    <?php echo Form::label('', '', ['class'=>'col-sm-2 control-label']); ?>

                    <div class="col-sm-10">
                        <?php echo Form::submit('Submit', ['class'=>'btn']); ?>

                    </div>

                </div>


            <?php endif; ?>




            <?php if($readonly =='readonly'): ?>
                <?php echo $__env->make('ratings.feedback.form2', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <?php endif; ?>
            <?php echo Form::close(); ?>

        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>