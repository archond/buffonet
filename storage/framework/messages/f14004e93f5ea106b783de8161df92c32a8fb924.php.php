

		<?php if(Session::has('error')): ?>
		<div class="alert alert-danger">
			<button type="button" class="close" data-dismiss="alert">
				<span aria-hidden="true">×</span>
				<span class="sr-only">Close</span>
			</button>
			<?php echo e(Session::get('form_message')); ?>

		</div>
		<?php endif; ?>

		<?php if(Session::has('success')): ?>
		<div class="alert alert-success">
			<button type="button" class="close" data-dismiss="alert">
				<span aria-hidden="true">×</span>
				<span class="sr-only">Close</span>
			</button>

			<?php echo e(Session::get('form_message')); ?>

		</div>

		<?php endif; ?>

		<?php if(Session::has('warning')): ?>
		<div class="alert alert-warning">
			<button type="button" class="close" data-dismiss="alert">
				<span aria-hidden="true">×</span>
				<span class="sr-only">Close</span>
			</button>
			<?php echo e(Session::get('form_message')); ?>

		</div>

		<?php endif; ?>