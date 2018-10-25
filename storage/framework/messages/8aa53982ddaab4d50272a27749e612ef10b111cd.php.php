<?php $__env->startSection('content'); ?>


    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">

                <strong>Search</strong>
                <div class="panel-options">
                    <a href="#" data-toggle="panel" class="panel1">
                        <span class="collapse-icon">+</span>
                        <span class="expand-icon">-</span>
                    </a>
                    <a href="#" data-toggle="remove">
                        ×
                    </a>
                </div>

                <?php echo e(Form::open(['method'=>'get', 'route'=>'mainobjects.index'])); ?>


                <?php /*<div class="panel-body <?php echo e(!isset($inputs['search_value']) || $inputs['search_value']=='' || $inputs['search_value'] ==null ? "hide" : null); ?>">*/ ?>
                <div class="panel-body <?php echo e(!isset($inputs['search_value']) || $inputs['search_value']=='' || $inputs['search_value'] ==null ? "" : null); ?>">

                    <section class="search-env">
                        <div class="input-group input-group-minimal">
                            <input type="text" name="search_value" class="form-control" placeholder="Search for something…"
                                   value="<?php echo e(isset($inputs['search_value']) ?  $inputs['search_value'] : null); ?>">
						<span class="input-group-addon">
							<input type="submit"><i class="linecons-search"></i></input>
						</span>
                        </div>


                        <div class="row">
                            <div class="col-md-12">

                                <?php /*<?php echo e(dd($searchDetails)); ?>*/ ?>

                                <?php foreach($searchDetails as $key => $detail): ?>

                                    <?php if(in_array($detail->name, ['e-mail', 'phone'] ) ): ?>

                                    <label class="checkbox-inline">
                                        <?php echo e(Form::checkbox('search_detail['.$detail['id'].']', $detail['id'], isset($inputs['search_detail'][ $detail['id'] ]) ? 1 :0  )); ?>

                                        <?php echo e($detail['name']); ?>

                                    </label>
                                    <?php endif; ?>

                                <?php endforeach; ?>

                            </div>
                        </div>
                    </section>
                </div>
                <?php echo e(Form::close()); ?>

            </div>
        </div>


        <div class="panel panel-default">

            <?php echo e(Form::open(['method'=>'get', 'route'=>'contacts.create-request'])); ?>

            <div class="panel-heading">
                <!-- Table Model 2 -->
                <strong>Main Objects</strong>

                <a type="button" class="btn btn-success btn-xs " href="<?php echo e(route('mainobjects.create')); ?>">
                    <i class="fa fa-plus"></i>
                </a>


                <?php /*
                <div class="panel-options" style="margin-left:5px">
                    <?php echo e(Form::submit('Create Request', ['class'=>'btn btn-blue', 'name'=>'createRequest'])); ?>

                </div>

                <div class="panel-options" style="margin-left:5px">
                    <?php echo e(Form::submit('Get Emails', ['class'=>'btn btn-blue', 'name'=>'getEmails'])); ?>

                </div>

                <div class="panel-options" style="margin-left:5px">
                    <?php echo e(Form::submit('Get Phones', ['class'=>'btn btn-blue', 'name'=>'getPhones'])); ?>

                </div>
                */ ?>


            </div>
            <div class="panel-body">


                <?php if(isset($requestedDataString) ): ?>
                    <div>
				<pre>
					<?php echo e($requestedDataString); ?>

				</pre>
                    </div>
                <?php endif; ?>


                <div class="table-responsive" data-pattern="priority-columns" data-focus-btn-icon="fa-asterisk" data-sticky-table-header="true" data-add-display-all-btn="true"
                     data-add-focus-btn="true">

                    <table cellspacing="0" class="table table-small-font table-bordered table-striped">
                        <thead>
                        <tr>


                            <th data-priority="1"><?php echo e(_('Phone')); ?></th>
                            <th data-priority="1"><?php echo e(_('Created at')); ?></th>

                            <th>action</th>

                        </tr>
                        </thead>
                        <tbody>

                        <form method="get" action="<?php echo e(url(route('mainobjects.index'))); ?>" enctype="application/x-www-form-urlencoded">
                            <?php foreach($mainobjects as $contact): ?>
                                <tr>
                                    <td>

                                        <?php if(is_array($contact['phone'])): ?>
                                            <?php echo e($contact['phone'][0]); ?>

                                        <?php else: ?>
                                            <?php echo e($contact['phone']); ?>

                                        <?php endif; ?>
                                    </td>

                                    <td>
                                        <?php echo e($contact['created_at']); ?>

                                    </td>


                                    <td>
                                        <div class="">
                                            <a class="btn btn-info btn-xs" href="<?php echo e(route('contacts.create', ['main-object-id'=>$contact['id']])); ?>"><i class="fa fa-plus"></i></a>

                                            <a class="btn btn-info btn-xs" href="<?php echo e(route('mainobjects.show', $contact['id'])); ?>"><i class="fa fa-info"></i></a>


                                            <a class="btn btn-success btn-xs" href="<?php echo e(route('mainobjects.edit', $contact['id'])); ?>"><i class="fa fa-edit"></i></a>

                                            <div class="btn btn-red btn-xs btn-delete" href="#" data-url="<?php echo e(route('mainobject.delete', ['id'=>Crypt::encrypt($contact['id'])  ] )); ?>"><i class="fa fa-remove"></i></div>

                                        </div>
                                    </td>

                                </tr>

                        <?php endforeach; ?>



                        <?php echo e(Form::close()); ?>

                        </tbody>
                    </table>
                    <div class="text-center"><?php echo e($mainobjects->links()); ?></div>

                    <!-- </div> -->
                </div>

            </div>
        </div>
    </div>






    <script type="text/javascript">
        $(document).ready(function () {
            $('.panel1').on('click', function () {
                $(this).closest('.panel-heading').find('.panel-body').toggleClass('hide');
            });


            $('form').on('click', 'button', function () { // disable button elements to submit form!//
                $(this).attr('type', 'button');
            });

            $('form').on('click', '.btn-delete', function () {
                $('#action-delete-url').attr('href', $(this).attr('data-url') );
                $('#modal-delete').modal('show');
            });

        });

    </script>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('modal'); ?>
        <!-- Modal 1 (Basic)-->
    <div class="modal fade" id="modal-delete">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><?php echo e(_('Confirmation')); ?></h4>
                </div>

                <div class="modal-body">
                    <?php echo e(_('Are you sure to delete this item')); ?>?
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal"><?php echo e(_('Cancel')); ?></button>
                    <a href="#" id="action-delete-url"><div class="btn btn-red"><?php echo e(_('Delete')); ?></div></a>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>