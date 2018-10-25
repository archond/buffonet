<?php $__env->startSection('content'); ?>

	Thank you for your time! 
	<br><br>
	<?php echo e(confg('constants.APP_NAME')); ?>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.feedback', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>