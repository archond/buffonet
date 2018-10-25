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


        <div class="panel panel-default">


            <div class="panel-heading">
                <!-- Table Model 2 -->
                <strong>Categories</strong>

                <a type="button" class="btn btn-success btn-xs " href="<?php echo e(route('categories.create')); ?>">
                    <i class="fa fa-plus"></i>
                </a>


            </div>
            <div class="panel-body">

                <ul>
                    <?php foreach($categories->toArray() as $category): ?>

                        <?php echo $__env->make('categories.includes.item', ['categories'=>$category], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>


                    <?php endforeach; ?>


                </ul>


            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function () {

            $('body').on('click', '.btn-delete', function () {
                console.log('.btn-delete clicked')
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
                    <a href="#" id="action-delete-url">
                        <div class="btn btn-red"><?php echo e(_('Delete')); ?></div>
                    </a>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>