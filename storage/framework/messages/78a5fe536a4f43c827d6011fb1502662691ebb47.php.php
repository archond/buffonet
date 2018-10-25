
<?php if($detail['is_collectable'] == 1 ): ?>
<?php if($isCollectableCounter == 0 ): ?> 
<?php echo Form::select('contact_detail['.$detail['id'].'][val][]', $detail['options']->lists('name', 'id'),  null, ['class'=>'form-control'] ); ?>

<?php endif; ?> 
<?php else: ?>

<?php echo Form::hidden('contact_detail['.$detail['id'].'][values_id][]', isset($value['id']) ? $value['id'] : null); ?> 
<?php echo Form::select('contact_detail['.$detail['id'].'][val][]', $detail['options']->lists('name', 'id'),  isset($value['value']) ? $value['value'] : null, ['class'=>'form-control'] ); ?>

<?php endif; ?>

