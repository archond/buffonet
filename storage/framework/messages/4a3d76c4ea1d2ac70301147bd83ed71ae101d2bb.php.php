<?php $__env->startSection('content'); ?>
	

<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">Update contacts Contact</h3>
	</div>
	<div class="panel-body">


		<?php echo Form::open(['class'=>'form-horizontal', 'method'=>'put','files'=>'true','route' => ['request-form.feedback-update', $encodedId] ]); ?>

		<?php /* 
			<?php echo $__env->make('requests.feedback.form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?> 
		*/ ?>
		<?php echo $__env->make('contacts.form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

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
<?php echo $__env->make('layouts.feedback', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>