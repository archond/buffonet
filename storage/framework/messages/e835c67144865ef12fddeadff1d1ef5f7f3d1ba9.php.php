<?php $__env->startSection('content'); ?>


    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">
                <!-- Table Model 2 -->
                <strong><?php echo e(_('Cities of')); ?> <?php echo e($country->name); ?></strong>
                <a type="button" class="btn btn-success btn-xs " href="<?php echo e(route('cities.create', ['countryId'=>$country->id])); ?>">
                    <i class="fa fa-plus"></i>
                </a>
            </div>

            <div class="panel-body">

                <div class="table-responsive" data-pattern="priority-columns" data-focus-btn-icon="fa-asterisk" data-sticky-table-header="true" data-add-display-all-btn="true"
                     data-add-focus-btn="true">

                    <table cellspacing="0" class="table table-small-font table-bordered table-striped">
                        <thead>
                        <tr>


                            <th data-priority="1"><?php echo e(_('Country')); ?></th>

                            <th><?php echo e(_('Action')); ?></th>

                        </tr>
                        </thead>
                        <tbody>


                        <?php foreach($country->cities as $city): ?>
                            <tr>
                                <td>
                                    <?php echo e($city->name); ?>

                                </td>

                                <td>
                                    <div class="">
                                        <?php /*
                                            <a class="btn btn-info btn-xs" href="<?php echo e(route('countries.show', $city['id'])); ?>"><i class="fa fa-info"></i></a>
                                         */ ?>

                                        <a class="btn btn-success btn-xs" href="<?php echo e(route('cities.edit', [$city['id'], 'countryId'=>$country->id] )); ?>"><i class="fa fa-edit"></i></a>


                                        <a class="btn btn-red btn-xs" href="<?php echo e(route('city.delete', ['id'=>Crypt::encrypt($city['id']), 'countryId'=>$country->id  ] )); ?>"><i class="fa fa-remove"></i></a>


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