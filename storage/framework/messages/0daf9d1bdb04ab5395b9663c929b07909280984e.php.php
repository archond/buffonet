
<?php /* Tags automaticali are translatable */ ?>


<?php foreach($languages as $language): ?>
<? 
$index = str_random(5);
$string1 = '[translated]['.$index.'][]';
$string2 = '[translated]['.$index.'][language_id]';  


?>
<?php /*<div class="" style="width:100%">*/ ?>
	<?php /*<label for="<?php echo e('contact_detail['.$detail['id'].']'.$string1, $tagList[$language->id]); ?>">(<?php echo e(strtoupper($language->abbr)); ?>)</label>*/ ?>

	<?php /*<?php echo Form::text('contact_detail['.$detail['id'].']'.$string1, $tagList[$language->id] , ['class'=>'form-control tagsinput', 'placeholder'=>'Input '.$detail['name']] ); ?>*/ ?>

	<?php /*<?php echo Form::hidden('contact_detail['.$detail['id'].']'.$string2, $language->id); ?> */ ?>
<?php /*</div>*/ ?>
<?php endforeach; ?>



<?php /*}}
<?php else: ?>
<?php echo Form::textarea('contact_detail['.$detail['id'].'][]',  isset($value['value']) ? $value['value'] : null , ['class'=>'form-control', 'placeholder'=>'Input '.$detail['name'], 'size' => '1000x5'] ); ?>

<?php endif; ?>
*/ ?>
<?php /*--------------------------------------------------------------------------------------------*/ ?>
<script type="text/javascript">
	$(document).ready(function() {
		$(document).ready(function() {
			$(".tagsinput1").select2({
				tags: true,
				tokenSeparators: [',']
			})
		});
	});
</script>



<?php foreach($languages as $language): ?>
	<?
	$index = str_random(5);
	$string1 = '[translated]['.$index.'][]';
	$string2 = '[translated]['.$index.'][language_id]';



	?>
	<div class="form-group col-sm-12">
		<?php /*<?php echo e(dd($tagList[$language->id] )); ?>*/ ?>
		<label for="<?php echo e('contact_detail['.$detail['id'].']'.$string1, $tagList[$language->id]); ?>" class="col-sm-2">(<?php echo e(strtoupper($language->abbr)); ?>)</label>
		<div class="col-sm-10">
			<?php echo Form::select('contact_detail['.$detail['id'].']'.$string1, $tagListAll[$language->id]->pluck('name', 'id'),$tagList[$language->id] , ['class'=>'form-control tagsinput1', 'multiple'=>'multiple' ] ); ?>


			<?php echo Form::hidden('contact_detail['.$detail['id'].']'.$string2, $language->id); ?>

		</div>

	</div>
<?php endforeach; ?>

<script>
	$(document).ready(function(){
		$(".tagsinput").tagsinput();
	});

</script>