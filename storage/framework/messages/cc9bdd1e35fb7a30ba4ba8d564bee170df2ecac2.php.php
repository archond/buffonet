<?php /*

<option><?php echo e($category['slug']); ?></option>

<optgroup label=<?php echo e($category['slug']); ?>>


		

			<?php if(isset($category['all_children'])): ?>

			<?php foreach($category['all_children'] as $category): ?>
			<?php echo $__env->make('categories.includes.optionitem', ['categories'=>$category['children']], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?> 
			<?php endforeach; ?>

			<?php elseif(isset($category['children'])): ?>

			<?php foreach($category['children'] as $category): ?> 
			<?php echo $__env->make('categories.includes.optionitem', ['categories'=>isset($category['children']) ? $category['children'] : [] ], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
			<?php endforeach; ?>

			<?php endif; ?>


</optgroup>

*/ ?>