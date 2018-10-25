<?php $__env->startSection('content'); ?>


    <style>
        .left-column {
            width: 200px;
        }

        .hoverDiv:hover {
            background-color: #EEEEEE;
            overflow: hidden;
        }

    </style>

    <div class="row">



        <?php foreach($mainObjects as $mainObject): ?>
            <div class="panel panel-default">
                <div class="panel-heading">

                    <div><?php echo e($mainObject->phone); ?>  <a  href="<?php echo e(route('contacts.create', ['main-object-id'=>$mainObject->id])); ?>" class="pull-right"><i class="btn btn-xs btn-success fa fa-plus"></i></a></div>


                </div>
                <div class="panel-body ">

                    <table class="table table-model-2 table-hover">
                        <tbody>

                        <?php foreach($mainObject->contacts as $contact): ?>


                            <tr>
                                <td><?php echo e(_('Title')); ?>:</td>
                                <td>
                                    <b>
                                        <?php if(is_array($contact->title)): ?>
                                            <?php echo e(implode(',', $contact->title)); ?>

                                        <?php elseif($contact->title): ?>
                                            <?php echo e($contact->title); ?>

                                        <?php else: ?>
                                            -
                                        <?php endif; ?>
                                    </b>

                                </td>


                                <td rowspan="0" width="120px">
                                    <a class="pull-left" href="<?php echo e(route('contacts.show', $contact['id'])); ?>"><i
                                                style="width:25px; margin:2px"
                                                class="fa fa-info btn btn-info btn-xs btn-block"></i></a>

                                    <a class="pull-left" href="<?php echo e(route('contacts.edit', $contact['id'])); ?>"><i
                                                style="width:25px; margin:2px"
                                                class="fa fa-edit btn btn-success btn-xs"></i></a>

                                    <div class="pull-left" href="#"
                                         data-url="<?php echo e(route('contact.delete', ['id'=>Crypt::encrypt($contact['id'])  ] )); ?>">
                                        <i class="fa fa-remove btn btn-red btn-xs" style="width:25px; margin:2px"></i>
                                    </div>
                                </td>

                            </tr>

                            <tr>


                                <td><?php echo e(_('Language')); ?>:</td>
                                <td colspan="2">
                                    <?php if($contact->language->name): ?>
                                        <?php echo e($contact->language->name); ?>

                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
                                </td>
                            </tr>

                            <tr>


                                <td><?php echo e(_('Phone')); ?>:</td>
                                <td colspan="2">
                                    <?php if(is_array($contact->phone) ): ?>
                                        <?php echo e(implode(',', $contact->phone)); ?>

                                    <?php elseif($contact->phone): ?>
                                        <?php echo e($contact->phone); ?>

                                    <?php else: ?>
                                        <?php echo e($mainObject->phone); ?>

                                    <?php endif; ?>
                                </td>

                            </tr>

                            <tr>


                                <td><?php echo e(_('e-mail')); ?>:</td>
                                <td colspan="2">
                                    <?php if(is_array($contact['e-mail'])): ?>
                                        <?php echo e(implode(',', $contact['e-mail'])); ?>

                                    <?php elseif($contact['email']): ?>
                                        <?php echo e($contact['email']); ?>

                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
                                </td>


                            </tr>




                            <tr>
                                <td><?php echo e(_('Address')); ?>:</td>
                                <td colspan="2">
                                    <?php foreach($contact->addresses as $address): ?>
                                        <?php echo e($address->marker_address.
                                        ($address->city->name != '' ? ', '.$address->city->name : null).
                                        ($address->country->name != '' ? ', '.$address->country->name : null).
                                        ($address->marker_zip != '' ? ', '.$address->marker_zip : null)); ?>;

                                    <?php endforeach; ?>

                                </td>
                            </tr>

                            <tr>
                                <td><?php echo e(_('Category')); ?>:</td>
                                <td colspan="2">
                                    <?php if(is_array($contact->categories)): ?>
                                        <?php echo e((implode(',', $contact->categories) )); ?>&nbsp;
                                    <?php elseif($contact->categories): ?>
                                        <?php echo e($contact->categories); ?>

                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5" style="border-bottom: 1px solid black;"></td>
                            </tr>





                        <?php endforeach; ?>

                        </tbody>

                    </table>

                </div>
            </div>

        <?php endforeach; ?>
    </div>


    <script type="text/javascript">
        $(document).ready(function () {


            $('body').on('click', '.btn-delete', function () {
                $('#action-delete-url').attr('href', $(this).attr('data-url'));
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
                    <a href="#" id="action-delete-url">
                        <div class="btn btn-red"><?php echo e(_('Delete')); ?></div>
                    </a>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>