<?php $__env->startSection('content'); ?>

<div class="panel panel-default" style="background-color:#E5E5E5">
	<div class="panel-heading">
		<h3 class="panel-title">Edit Contact Detail</h3>
	</div>
	<div class="panel-body">


		<?php echo Form::model($contactDetail, ['class'=>'form-horizontal', 'method'=>'put','files'=>'true','route' => ['contactdetails.update', $contactDetail->id ] ]); ?>

		<?php echo $__env->make('contactdetails.form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

		<div class="form-group">
			<?php echo Form::label('', '', ['class'=>'col-sm-2 control-label']); ?>

			<div class="col-sm-10">
				<?php echo Form::submit('Update', ['class'=>'btn']); ?>

			</div>
			<?php echo Form::close(); ?>

		</div>
	</div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>