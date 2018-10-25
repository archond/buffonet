<?php $__env->startSection('content'); ?>

<?php /*<div class="panel panel-default">*/ ?>
	<?php /*<div class="panel-heading">*/ ?>
		<h3 class="panel-title"><?=_('Edit Contact') ;?></h3>
	<?php /*</div>*/ ?>
	<?php /*<div class="panel-body">*/ ?>


		<?php echo Form::model($contact, ['class'=>'form-horizontal', 'method'=>'put','files'=>'true','route' => ['contacts.update', $contact->id ] ]); ?>

		<?php echo $__env->make('contacts.form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

		<div class="form-group">
			<?php echo Form::label('', '', ['class'=>'col-sm-2 control-label']); ?>

			<div class="col-sm-10">
				<?php echo Form::submit('Update', ['class'=>'btn']); ?>

			</div>
			<?php echo Form::close(); ?>

		</div>
	<?php /*</div>*/ ?>
<?php /*</div>*/ ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>