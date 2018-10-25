<?php $__env->startSection('content'); ?>


    <div class="row">


        <div class="panel panel-default">
            <div class="panel-heading">
                <!-- Table Model 2 -->
                <strong><?php echo e(_('Ratings')); ?></strong>
                <?php /*<a type="button" class="btn btn-success btn-xs " href="<?php echo e(route('ratings.create')); ?>">*/ ?>
                <?php /*<i class="fa fa-plus"></i>*/ ?>
                <?php /*</a>*/ ?>
            </div>

            <div class="panel-body">

                <div class="table-responsive" data-pattern="priority-columns" data-focus-btn-icon="fa-asterisk"
                     data-sticky-table-header="true" data-add-display-all-btn="true"
                     data-add-focus-btn="true">

                    <table cellspacing="0" class="table table-small-font table-bordered table-striped">
                        <?php echo e(Form::open(['route'=>'ratings.index', 'method'=>'get'])); ?>

                        <thead>
                        <tr>


                            <th data-priority="1">
                                <div>
                                    <?php echo e(link_to_route('ratings.index', _('Clear filters'), ['clear_rating_filters'=>'true'], ['class'=>'btn btn-gray'] )); ?>

                                </div>
                                <div class="text-center">
                                    <?php echo e(_('id')); ?>

                                </div>
                            </th>
                            <th data-priority="1">
                                <div class="input-group">
                                    <?php echo e(Form::text('rating_search_by_contact', Request::session()->get('rating_search_by_contact'), ['class'=>'form-control', 'placeholder'=>_('Search by contact title')])); ?>

                                    <span class="input-group-btn">
                                            <button type="submit" class="btn btn-default" type="button"><i
                                                        class="fa fa-search"></i></button>
                                        </span>
                                </div>
                                <div class="text-center"><?php echo e(_('contact')); ?></div>
                            </th>
                            <th data-priority="1">
                                <div class="input-group">
                                    <?php echo e(Form::text('rating_search_by_email', Request::session()->get('rating_search_by_email'), ['class'=>'form-control', 'placeholder'=>_('Search by email')])); ?>

                                    <span class="input-group-btn">
                                            <button type="submit" class="btn btn-default" type="button"><i
                                                        class="fa fa-search"></i></button>
                                        </span>
                                </div>
                                <div class="text-center"><?php echo e(_('email')); ?></div>
                            </th>
                            <th data-priority="1">
                                <?php echo e(link_to_route('ratings.index', _('sent'), ['rating_sort'=> Request::session()->get('rating_sort') == 'sent_date_a' ? 'sent_date_d' : 'sent_date_a' ]  )); ?>

                                <span class="fa <?php echo e(Request::session()->get('rating_sort') == 'sent_date_a' ? 'fa-sort-down' : (Request::session()->get('rating_sort') == 'sent_date_d' ? 'fa-sort-up' : 'fa-sort')); ?>">
                                </span>

                            </th>
                            <th data-priority="1">
                                <?php echo e(link_to_route('ratings.index', _('complete'), ['rating_sort'=> Request::session()->get('rating_sort') == 'complete_date_a' ? 'complete_date_d' : 'complete_date_a' ]  )); ?>

                                <span class="fa <?php echo e(Request::session()->get('rating_sort') == 'complete_date_a' ? 'fa-sort-down' : (Request::session()->get('rating_sort') == 'complete_date_d' ? 'fa-sort-up' : 'fa-sort')); ?>">
                                </span>
                            </th>
                            <th data-priority="1"><?php echo e(_('language')); ?></th>
                            <th data-priority="1"><?php echo e(_('author')); ?></th>

                            <th><?php echo e(_('Action')); ?></th>

                        </tr>
                        </thead>
                        <?php echo e(Form::close()); ?>

                        <tbody>


                        <?php foreach($ratings as $rating): ?>
                            <tr class="<?php echo e($rating->deleted_at ? 'warning1' : ''); ?>">

                                <td>
                                    <?php echo $rating->deleted_at ? '<s>' : null; ?>

                                    <?php echo e($rating->id); ?>

                                    <?php echo $rating->deleted_at ? '</s>' : null; ?>

                                </td>
                                <td>
                                    <?php echo $rating->deleted_at ? '<s>' : null; ?>

                                    <?php echo e(isset($rating->contact->contactDetailValue->value) ? $rating->contact->contactDetailValue->value : 'no title'); ?>

                                    <?php echo $rating->deleted_at ? '</s>' : null; ?>

                                </td>
                                <td>
                                    <?php echo $rating->deleted_at ? '<s>' : null; ?>

                                    <?php echo e($rating->email); ?>

                                    <?php echo $rating->deleted_at ? '</s>' : null; ?>

                                </td>
                                <td>
                                    <?php echo $rating->deleted_at ? '<s>' : null; ?>

                                    <?php echo e($rating->sent_date); ?>

                                    <?php echo $rating->deleted_at ? '</s>' : null; ?>

                                </td>
                                <td>
                                    <?php echo $rating->deleted_at ? '<s>' : null; ?>

                                    <?php echo e($rating->complete_date); ?>

                                    <?php echo $rating->deleted_at ? '</s>' : null; ?>

                                </td>
                                <td>
                                    <?php echo $rating->deleted_at ? '<s>' : null; ?>

                                    <?php echo e($rating->language); ?>

                                    <?php echo $rating->deleted_at ? '</s>' : null; ?>

                                </td>
                                <td>
                                    <?php echo $rating->deleted_at ? '<s>' : null; ?>

                                    <?php echo e($rating->author_name); ?>

                                    <?php echo $rating->deleted_at ? '</s>' : null; ?>

                                </td>

                                <td>
                                    <div class="">

                                        <a class="btn btn-info btn-xs"
                                           href="<?php echo e(route('ratings.show', $rating['id'])); ?>"><i class="fa fa-info"></i></a>


                                        <?/*
                                        <a class="btn btn-success btn-xs" href="{{ route('ratings.edit', $rating['id']) }}"><i class="fa fa-edit"></i></a>
                                        */?>

                                        <?php if($rating->deleted_at): ?>
                                            <a class="btn btn-warning btn-xs"
                                               href="<?php echo e(route('rating.restore', ['id'=>Crypt::encrypt($rating['id'])  ] )); ?>"><i
                                                        class="fa fa-undo"></i></a>
                                        <?php else: ?>
                                            <a class="btn btn-red btn-xs"
                                               href="<?php echo e(route('rating.delete', ['id'=>Crypt::encrypt($rating['id'])  ] )); ?>"><i
                                                        class="fa fa-remove"></i></a>
                                        <?php endif; ?>

                                    </div>
                                </td>

                            </tr>

                        <?php endforeach; ?>

                        </tbody>
                    </table>


                    <!-- </div> -->
                </div>
                <div class="text-center"><?php echo $ratings->links(); ?></div>

            </div>
        </div>
    </div>




<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>