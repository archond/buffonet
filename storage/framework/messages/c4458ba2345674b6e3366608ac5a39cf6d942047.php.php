<?php $__env->startSection('content'); ?>


    <div class="row">


        <div class="panel panel-default">
            <div class="panel-heading">
                <!-- Table Model 2 -->
                <strong><?php echo e(_('Rating')); ?> : <?php echo e($rating->contact->contactDetailValue->value); ?></strong>

                <?/*
                <a type="button" class="btn btn-success btn-xs " href="{{ route('ratings.create') }}">
                    <i class="fa fa-plus"></i>
                </a>
                */?>
                <a class="btn btn-info btn-xs" href="<?php echo e(route('contacts.show', $rating->contact['id'])); ?>"><i class="fa fa-info"></i></a>
            </div>
f
            <div class="panel-body">

                <div class="table-responsive" data-pattern="priority-columns" data-focus-btn-icon="fa-asterisk" data-sticky-table-header="true" data-add-display-all-btn="true"
                     data-add-focus-btn="true">

                    <table cellspacing="0" class="table table-small-font table-bordered table-striped">

                        <thead>
                        <th  data-priority="1" ><?php echo e(_('Property')); ?></th>
                        <th  data-priority="1"><?php echo e(_('Value')); ?></th>
                        </thead>

                        <tbody>
                        <?/*
                    <tr>
                        <td>{{_('Contact')}}</td>
                        <td>{{$rating->contact->contactDetailValue->value}}</td>
                    </tr>
                    */?>
                        <tr>
                            <td><?php echo e(_('Language')); ?></td>
                            <td><?php echo e($rating->language); ?></td>
                        </tr>
                        <tr>
                            <td><?php echo e(_('Email')); ?></td>
                            <td><?php echo e($rating->email); ?></td>
                        </tr>
                        <tr>
                            <td><?php echo e(_('Author')); ?></td>
                            <td><?php echo e($rating->author_name); ?></td>
                        </tr>
                        <tr>
                            <td><?php echo e(_('Author phone')); ?></td>
                            <td><?php echo e($rating->author_phone); ?></td>
                        </tr>
                        <tr>
                            <td><?php echo e(_('Accurancy')); ?></td>
                            <td>
                                <?php foreach([1,2,3,4,5] as $star): ?>
                                    <?php echo $star <= $rating->accurancy ? '<i class="fa fa-star" ></i>' : '<i class="fa fa-star-o" ></i>'; ?>

                                <?php endforeach; ?>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo e(_('Quality')); ?></td>
                            <td>
                                <?php foreach([1,2,3,4,5] as $star): ?>
                                    <?php echo $star <= $rating->quality ? '<i class="fa fa-star" ></i>' : '<i class="fa fa-star-o" ></i>'; ?>

                                <?php endforeach; ?>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo e(_('Communication')); ?></td>
                            <td>
                                <?php foreach([1,2,3,4,5] as $star): ?>
                                    <?php echo $star <= $rating->communication ? '<i class="fa fa-star" ></i>' : '<i class="fa fa-star-o" ></i>'; ?>

                                <?php endforeach; ?>
                            </td>
                        </tr>
                        <tr>
                            <td ><?php echo e(_('Review')); ?></td>
                            <td style="white-space: normal !important; "><?php echo e($rating->review); ?></td>
                        </tr>
                        <tr>
                            <td><?php echo e(_('Request sent date')); ?></td>
                            <td><?php echo e($rating->sent_date); ?></td>
                        </tr>
                        <tr>
                            <td><?php echo e(_('Complete date')); ?></td>
                            <td><?php echo e($rating->complete_date); ?></td>
                        </tr>
                        <tr>
                            <td><?php echo e(_('Action')); ?></td>
                            <td>
                                <?php if(!$rating->deleted_at): ?>
                                    <a class="btn btn-red btn-xs" href="<?php echo e(route('rating.delete', ['id'=>Crypt::encrypt($rating['id'])  ] )); ?>"><i class="fa fa-remove"></i></a>
                                <?php else: ?>
                                    <?php echo e(_('deleted')); ?>: <?php echo e($rating->deleted_at); ?>

                                    <a class="btn btn-warning btn-xs" href="<?php echo e(route('rating.restore', ['id'=>Crypt::encrypt($rating['id'])  ] )); ?>"><i class="fa fa-undo"></i></a>
                                <?php endif; ?>
                            </td>
                        </tr>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>




<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>