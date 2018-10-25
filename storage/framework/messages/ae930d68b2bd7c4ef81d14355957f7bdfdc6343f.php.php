<?php $__env->startSection('content'); ?>


<div class="row">
	<div class="panel panel-default">
		<div class="panel-heading">

			<strong>Search</strong>  
			<div class="panel-options">
				<a href="#" data-toggle="panel" class="panel1">
					<span class="collapse-icon">+</span>
					<span class="expand-icon">-</span>
				</a>
				<a href="#" data-toggle="remove">
					×
				</a>
			</div>

			<?php echo e(Form::open(['method'=>'get', 'route'=>'mainobjects.index'])); ?>  
			
			<div class="panel-body <?php echo e(!isset($inputs['search_value']) || $inputs['search_value']=='' || $inputs['search_value'] ==null ? "hide" : null); ?>">

				<section class="search-env"> 
					<div class="input-group input-group-minimal">
						<input type="text" name="search_value" class="form-control" placeholder="Search for something…" value="<?php echo e(isset($inputs['search_value']) ?  $inputs['search_value'] : null); ?>"> 
						<span class="input-group-addon">
							<input type="submit"><i class="linecons-search"></i></input>
						</span>
					</div>



					<div class="row">
						<div class="col-md-12">

							<?php foreach($searchDetails as $key => $detail): ?>

							<label class="checkbox-inline">
								<?php echo e(Form::checkbox('search_detail['.$detail['id'].']', $detail['id'], isset($inputs['search_detail'][ $detail['id'] ]) ? 1 :0  )); ?>  
								<?php echo e($detail['name']); ?> 
							</label>

							<?php endforeach; ?>

						</div>
					</div>
				</section>
			</div>
			<?php echo e(Form::close()); ?>

		</div>
	</div>


	<div class="panel panel-default">

		<?php echo e(Form::open(['method'=>'get', 'route'=>'contacts.create-request'])); ?>

		<div class="panel-heading">
			<!-- Table Model 2 -->
			<strong>Main Objects</strong>  

			<a type="button" class="btn btn-success btn-xs " href="<?php echo e(route('mainobjects.create')); ?>">
				<i class="fa fa-plus"></i>
			</a> 

			
			<?php /*
			<div class="panel-options" style="margin-left:5px">
				<?php echo e(Form::submit('Create Request', ['class'=>'btn btn-blue', 'name'=>'createRequest'])); ?>

			</div>

			<div class="panel-options" style="margin-left:5px">
				<?php echo e(Form::submit('Get Emails', ['class'=>'btn btn-blue', 'name'=>'getEmails'])); ?>

			</div>

			<div class="panel-options" style="margin-left:5px">
				<?php echo e(Form::submit('Get Phones', ['class'=>'btn btn-blue', 'name'=>'getPhones'])); ?>

			</div>
			*/ ?>



		</div>
		<div class="panel-body">


			

			<?php if(isset($requestedDataString) ): ?>
			<div>
				<pre>
					<?php echo e($requestedDataString); ?>

				</pre>
			</div>
			<?php endif; ?>


			<div class="table-responsive" data-pattern="priority-columns" data-focus-btn-icon="fa-asterisk" data-sticky-table-header="true" data-add-display-all-btn="true" data-add-focus-btn="true">

				<table cellspacing="0" class="table table-small-font table-bordered table-striped">
					<thead>
						<tr>

							<?php foreach($tableColumns as $key=> $column): ?>
							<th data-priority="1"><?php echo e($column); ?></th>
							<?php endforeach; ?>


							<?php /*
							<th>send request</th>
							*/ ?>
							<th>action</th>

						</tr>
					</thead>
					<tbody>

						<form method="get" action="<?php echo e(url(route('mainobjects.index'))); ?>" enctype="application/x-www-form-urlencoded">
							<?php foreach($mainobjects as $contact): ?>
							<tr>
								<?php foreach($tableColumns as $property): ?>


								<?php if(is_array($contact[$property] ) ): ?>
								<td ><?php echo e(implode(",", $contact[$property] )); ?></td>
								<?php else: ?>
								<td><?php echo e($contact[$property]); ?></td>
								<?php endif; ?>

								<?php endforeach; ?>

<?php /*
								<td>
									<?php if( $contact['e-mail'] ): ?>
									<?php echo e(Form::checkbox('contacts[]', $contact['id'], null)); ?>

									<?php else: ?>
									add email first!
									<?php endif; ?>
								</td> 
*/ ?>
								<td>
									<div class="" > 
										<a class="btn btn-success btn-xs"  href="<?php echo e(route('mainobjects.edit', $contact['id'])); ?>"><i class="fa fa-edit"></i></a>

										<a class="btn btn-red btn-xs" href="<?php echo e(route('mainobject.delete', ['id'=>Crypt::encrypt($contact['id'])  ] )); ?>"><i class="fa fa-remove"></i></a>

									</div>
								</td>

							</tr>

							<?php endforeach; ?>



							<?php echo e(Form::close()); ?>

						</tbody> 
					</table>

					<!-- </div> -->
				</div>

			</div>
		</div>
	</div>






	<script type="text/javascript">
		$(document).ready(function(){
			$('.panel1').on('click', function(){
				$(this).closest('.panel-heading').find('.panel-body').toggleClass('hide');
			});


		$('form').on('click', 'button', function(){ // disable button elements to submit form!//
			$(this).attr('type','button');
		});

	});

</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>