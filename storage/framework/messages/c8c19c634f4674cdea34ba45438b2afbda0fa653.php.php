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
	<?php echo Form::label('slug', 'slug', ['class'=>'col-sm-2 control-label']); ?>

	<div class="col-sm-10">
		<?php echo Form::text('slug', isset($category) ? $category['slug'] : null , ['class'=>'form-control', 'placeholder'=>'Input slug'] ); ?>

	</div>
</div>

<?php foreach($languages as $language): ?>  
<div class="form-group">
	<?php echo Form::label('name['.$language->id.']', strtoupper($language->abbr), ['class'=>'col-sm-2 control-label']); ?>

	<div class="col-sm-10">
		<?php echo Form::text('name['.$language->id.']', isset($translation[$language->id]) ? $translation[$language->id] : null , ['class'=>'form-control', 'placeholder'=>'Input Category name in '.strtoupper($language->abbr).' language'] ); ?>

	</div>
</div>
<?php endforeach; ?>




	<?php /* $selectedParentcategories */ ?>
	
	<?php if(!isset($categoryArrayTree) ): ?> 

		<?php echo $__env->make('categories.includes.select-path', ['categoryArrayTree'=>$categoryArrayTree], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	<?php else: ?>

		 <?php echo $__env->make('categories.includes.select-path', ['categoryArrayTree'=>$categoryArrayTree], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	<?php endif; ?>



