<?php $__env->startSection("content"); ?>

<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title"><?php echo e(_("Stage")); ?>: <?php echo e($stage->name); ?></h3>
	</div>
	<div class="panel-body">





		<div class="row"> 
			<div class="col-md-12">

				<?php echo e(Form::open(["route"=>["stage.updatecontactdetails", $stage->id], "method"=>"put"])); ?>


				<?php foreach($stage['contactdetails'] as $detail): ?> 
				<div class="row">

					<div class="form-group col-md-7 col-sm-7 col-xs-7">
						<?php echo e(Form::text("name[$detail->id]", $detail->name, ["class"=>"col-xs-12"])); ?> 
					</div>

					<div class="form-group col-md-2 col-sm-2 col-xs-2">
						<?php echo e(Form::text("order[$detail->id]", $detail->order, ["class"=>"col-xs-12","placeholder"=>"order"])); ?>  
					</div>

					<div class="form-group col-md-2 col-sm-2 col-xs-2"> 
						<?php echo e(Form::select("input_field_id[$detail->id]", $inputFields->pluck("name", "id"),$detail->input_field_id, ["class"=>"col-xs-12"])); ?>

					</div> 

					<!-- <div class="form-group col-md-1 col-sm-1 col-xs-1"><i class="fa fa-remove removeButton"></i></div> -->  
				</div>
				<?php endforeach; ?>

				<div id="emptyDiv"></div> 

			</div>
			<div class="form-group col-md-12">
				<button type="button" class="form-group btn fa-plus btn-info pull-right" id="addButton"></button>
				<button class="form-group btn fa-save btn-info"></button>
			</div>

			<?php echo e(Form::close()); ?>

		</div>



	</div>
</div>


<script type="text/javascript">
	$("body")
	.on("click", ".removeButton", function(){  
		$(this).closest(".row").remove();  
	});

	$("body").on("click", "#addButton", function(){
		// $(this).closest(".row").remove(); 

		// console.log("clicked"); 
		var div = '<div class="row"> \
		<div class="form-group col-md-7 col-sm-7 col-xs-7"> \
			<?php echo e(Form::text("name_new[]", '', ["class"=>"col-xs-12"])); ?> \
		</div> \
		<div class="form-group col-md-2 col-sm-2 col-xs-2"> \
			<?php echo e(Form::text("order_new[]", '', ["class"=>"col-xs-12","placeholder"=>"order"])); ?> \
		</div> \
		<div class="form-group col-md-2 col-sm-2 col-xs-2"> \
			<?php echo e(Form::select("input_field_id_new[]", $inputFields->pluck("name", "id"),'', ["class"=>"col-xs-12"])); ?> \
		</div> \
		<div class="form-group col-md-1 col-sm-1 col-xs-1"> \
			<i class="fa fa-remove removeButton"></i> \
		</div> \
	</div>';

	$("#emptyDiv").before(div);

});;
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make("layouts.app", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>