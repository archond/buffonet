<?php if($detail['is_collectable'] == 1 ): ?>
<?php /* ja IR collectable */ ?>
	<?php if($isCollectableCounter == 0 ): ?> 
	<?php /* izvadam tikai vienu ciklu */ ?>
	<?php echo Form::textarea('contact_detail['.$detail['id'].'][val][]', null , ['class'=>'form-control', 'placeholder'=>'Input '.$detail['name'], 'size' => '1000x5'] ); ?>

	<?php endif; ?>


<?php else: ?>
	<?php /* ja nav collectable */ ?>
		<?php echo Form::hidden('contact_detail['.$detail['id'].'][values_id][]', isset($value['id']) ? $value['id'] : null); ?> 
		<?php echo Form::hidden('contact_detail['.$detail['id'].'][language_id][]', isset($value['language_id']) ? $value['language_id'] : null ); ?> 
		<?php echo Form::textarea('contact_detail['.$detail['id'].'][val][]',  isset($value['value']) ? $value['value'] : null , ['class'=>'form-control', 'placeholder'=>'Input '.$detail['name'], 'size' => '1000x5'] ); ?>

<?php endif; ?>

