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
	<?php echo Form::label('name', 'Stage', ['class'=>'col-sm-2 control-label']); ?>

	<div class="col-sm-10">
		<?php echo Form::text('name', null , ['class'=>'form-control', 'placeholder'=>'Input stage name'] ); ?> 
	</div>
</div>

<?php /* Translations */ ?>
<div class="form-group" >
	<?php echo Form::label('translation', 'Translations', ['class'=>'col-sm-2 control-label']); ?>

	<div class="col-sm-10">
		<div class="row">

			<div class="col-md-12" >

				<ul class="nav nav-tabs nav-tabs-justified" >
					<?php foreach($languages as $language): ?>
						<li class="<?php echo e($language->id == 1 ? 'active' : null); ?>">
							<a href="#<?php echo e($language->id); ?>" data-toggle="tab">
								<span class="visible-xs"><i class="fa-home"></i></span>
								<span class="hidden-xs"><?php echo e(strtoupper($language->abbr)); ?></span>
							</a>
						</li>
					<?php endforeach; ?>
				</ul>


				<div class="tab-content">
					<?php foreach($languages as $language): ?>
						<div class="tab-pane <?php echo e($language->id == 1 ? 'active' : null); ?>" id="<?php echo e($language->id); ?>">

							<div>
								<?php /*<?php echo e(dd($contactDetail->translations)); ?>*/ ?>
								<?php echo e(Form::text('translations['.$language->id.']',


                                isset($stage) && isset( $stage->translations->filter(function($trans) use($language){

                                return isset($trans->language_id) && $trans['language_id'] == $language->id;
                                } )->first()->name )
                                ?

                                $stage->translations->filter(function($trans) use($language){

                                return isset($trans->language_id) && $trans['language_id'] == $language->id;
                                } )->first()->name


                                : null
                                , ['class'=>'form-control', 'placeholder'=>'Input translation in '.strtoupper($language->abbr).' language!'] )); ?>


							</div>

						</div>
					<?php endforeach; ?>


				</div>
			</div>
		</div>
	</div>
</div>
<?php /**/ ?>

<div class="form-group">
	<?php echo Form::label('is_contact_data_stage', 'Is contact data stage?', ['class'=>'col-sm-2 control-label']); ?>

	<div class="col-sm-10">
		<?php echo Form::hidden('is_contact_data_stage', 0); ?>

		<?php echo Form::checkbox('is_contact_data_stage', 1, isset($contactDetail['is_contact_data_stage']) ? $contactDetail['is_contact_data_stage'] : false , ['class'=>''] ); ?>

	</div>
</div>

<div class="form-group">
	<?php echo Form::label('name', 'Contact Details', ['class'=>'col-sm-2 control-label']); ?>

	<div class="col-sm-10">
		<?php if(isset($stage['contactDetails'])): ?>
		<ul class="form-group">
			<?php foreach($stage['contactDetails'] as $key=> $detal): ?>
			<li class=""><?php echo $detal->name; ?></li> 
			<?php endforeach; ?>
		</ul>
		<?php else: ?>
			<?php echo e(_('Stage do not have any contact detail')); ?>

		<?php endif; ?>
	</div>
</div>

