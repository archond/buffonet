<?php if($detail['is_collectable'] == 1 ): ?>
<?php if($isCollectableCounter == 0 ): ?> 
<p>
	<?php foreach($detail['options']->pluck('name', 'id') as $key=> $option): ?>
	<label class="radio-inline">
		<?php echo Form::checkbox('contact_detail['.$detail['id'].'][val][]',  $key, false ,  ['class'=>''] ); ?>

		<?php echo $option; ?>

	</label>
	<?php endforeach; ?>
</p>

<?php endif; ?>
<?php else: ?>
<?php echo Form::hidden('contact_detail['.$detail['id'].'][values_id][]', isset($value['id']) ? $value['id'] : null); ?> 
<p>
	<?php foreach($detail['options']->pluck('name', 'id') as $key=> $option): ?>
	<label class="radio-inline">
		<?php echo Form::checkbox('contact_detail['.$detail['id'].'][val][]',  $key, ($key ==  isset($value['value']) ? $value['value'] : null) ? true : false ,  ['class'=>''] ); ?>

		<?php echo $option; ?>

	</label>
	<?php endforeach; ?>
</p>

<?php endif; ?>






