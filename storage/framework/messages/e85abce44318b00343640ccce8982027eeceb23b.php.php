<?php $__env->startSection('content'); ?>


    <div class="row">


        <div class="panel panel-default">
            <div class="panel-heading">
                <!-- Table Model 2 -->
                <strong><?php echo e(_('Stages')); ?></strong>
                <a type="button" class="btn btn-success btn-xs " href="<?php echo e(route('stages.create')); ?>">
                    <i class="fa fa-plus"></i>
                </a>
            </div>

            <div class="panel-body">

                <div class="table-responsive" data-pattern="priority-columns" data-focus-btn-icon="fa-asterisk"
                     data-sticky-table-header="true" data-add-display-all-btn="true"
                     data-add-focus-btn="true">



                    <table cellspacing="0" class="table table-small-font table-bordered table-striped">
                        <thead>
                        <tr>


                            <th data-priority="1"><?php echo e(_('Stage')); ?></th>

                            <th data-priority="1"><?php echo e(_('Is Contact data stage')); ?></th>


                            <th data-priority="1"><?php echo e(_('Action')); ?></th>

                        </tr>
                        </thead>
                        <tbody>


                        <?php foreach($stages as $stage): ?>
                            <tr>
                                <td>
                                    <?php echo e($stage->name); ?>

                                </td>

                                <td>
                                    <?php echo $stage->is_contact_data_stage ? '<i class="fa fa-check ">' : '-'; ?>

                                </td>


                                <td>
                                    <div class="">
                                        <a class="btn btn-info btn-xs" href="<?php echo e(route('stages.show', $stage['id'])); ?>"><i class="fa fa-info"></i></a>

                                        <a class="btn btn-success btn-xs" href="<?php echo e(route('stages.edit', $stage['id'])); ?>"><i class="fa fa-edit"></i></a>

                                        <a class="btn btn-red btn-xs" href="<?php echo e(route('stage.delete', ['id'=>Crypt::encrypt($stage['id'])  ] )); ?>"><i class="fa fa-remove"></i></a>

                                    </div>
                                </td>

                            </tr>

                        <?php endforeach; ?>

                        </tbody>
                    </table>

                    <!-- </div> -->
                </div>

            </div>
        </div>
    </div>




<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>