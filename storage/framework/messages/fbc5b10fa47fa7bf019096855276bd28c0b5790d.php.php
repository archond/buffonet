<?php $__env->startSection('content'); ?>


<div class="row">



	<div class="panel panel-default">
		<div class="panel-heading">
			<!-- Table Model 2 -->
			<strong><?php echo e(_('Contact Details')); ?></strong>  
			<a type="button" class="btn btn-success btn-xs " href="<?php echo e(route('contactdetails.create')); ?>">
				<i class="fa fa-plus"></i>
			</a> 
		</div>

		<div class="panel-body">

			<div class="table-responsive" data-pattern="priority-columns" data-focus-btn-icon="fa-asterisk" data-sticky-table-header="true" data-add-display-all-btn="true" data-add-focus-btn="true">

				<table cellspacing="0" class="table table-small-font table-bordered table-striped">
					<thead>
						<tr>


							<th data-priority="1"><?php echo e(_('Contact Detail')); ?></th>

							<th data-priority="1"> 
								<div class="row">
									<div class="col-md-2">
									<?php echo e(_('Stage')); ?>

									</div> 
									<?php echo Form::open(['method'=>'get', 'class'=>'col-md-6'] ); ?>

									<?php echo Form::select('stage_id', $stages->pluck('name', 'id'), \Request::has('stage_id') ? \Request::get('stage_id')  : null, ['placeholder'=>'-']); ?> 
									<button class="btn-xs btn-info btn "><i class="fa fa-filter"></i></button>
									<?php echo Form::close(); ?>

								</div>
							</th>
							<th data-priority="1"><?php echo e(_('Model')); ?></th>  
							<th data-priority="1"><?php echo e(_('is Translatable?')); ?></th>
							<th data-priority="1"><?php echo e(_('is Colollectable?')); ?></th>  
							<th data-priority="1"><?php echo e(_('is Uniq Value?')); ?></th>
							<th data-priority="1"><?php echo e(_('is Searchable?')); ?></th>


							<th><?php echo e(_('Action')); ?></th>

						</tr>
					</thead>
					<tbody>


						<?php foreach($contactDetails as $detail): ?>  
						<tr>
							<td>
								<?php echo e($detail->name); ?>

							</td>

							<td>
								<?php echo e($detail->stage->name); ?> 
							</td>
							<td>
								<?php echo e($detail->model ? $detail->model : '-'); ?>

							</td>
							<td>
								<?php if($detail->is_translatable): ?> <i class="fa fa-check"</i> <?php else: ?> - <?php endif; ?>
							</td>
							<td>
								<?php if($detail->is_collectable): ?> <i class="fa fa-check "</i> <?php else: ?> - <?php endif; ?> 
							</td>
							<td>
								<?php if($detail->is_uniq_value): ?> <i class="fa fa-check "</i> <?php else: ?> - <?php endif; ?> 
							</td>
							<td>
								<?php if($detail->is_searchable): ?> <i class="fa fa-check "</i> <?php else: ?> - <?php endif; ?>
							</td>
							<td>
								<div class="" > 
								<?php /*
									<a class="btn btn-info btn-xs"  href="<?php echo e(route('contactdetails.show', $detail['id'])); ?>"><i class="fa fa-info"></i></a> 
									*/ ?>

									<a class="btn btn-success btn-xs"  href="<?php echo e(route('contactdetails.edit', $detail['id'])); ?>"><i class="fa fa-edit"></i></a>
									
									<?php if(count($detail['values']) == 0): ?>
									<a class="btn btn-red btn-xs" href="<?php echo e(route('contactdetail.delete', ['id'=>Crypt::encrypt($detail['id'])  ] )); ?>"><i class="fa fa-remove"></i></a>
									<?php endif; ?>

								</div>
							</td>

						</tr>

						<?php endforeach; ?>

					</tbody> 
				</table>

				<!-- </div> -->
			</div>

		</div>
	</div>
</div>




<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>