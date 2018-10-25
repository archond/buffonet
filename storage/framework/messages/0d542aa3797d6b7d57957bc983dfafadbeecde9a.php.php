<!-- <pre> -->
<?php
	// var_dump( $validator->errors() );
?>
<!-- </pre> -->
<?php if(isset($errors) && count($errors) > 0): ?>
<div class="alert alert-danger">
	<ul>
		<?php foreach($errors->all() as $error): ?>
		<li><?php echo e($error); ?></li>
		<?php endforeach; ?>
	</ul>
</div>
<?php endif; ?>



<div class="form-group">
	<?php echo Form::label('phone', 'Phone', ['class'=>'col-sm-2 control-label']); ?>

	<div class="col-sm-10">
		<?php echo Form::text('phone', isset($mainobject) ? $mainobject['phone'] : null , ['class'=>'form-control', 'placeholder'=>_('phone format +37100000000')] ); ?>

	</div>
</div>

