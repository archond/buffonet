<?php if($detail['is_collectable'] == 1 ): ?>
<?php if($isCollectableCounter == 0 ): ?>
<?php echo Form::text('contact_detail['.$detail['id'].'][val][]', null , ['class'=>'form-control', 'placeholder'=>'Input '.$detail['name']] ); ?>

<?php endif; ?> 

<?php else: ?>



<?php echo Form::hidden('contact_detail['.$detail['id'].'][values_id][]', isset($value['id']) ? $value['id'] : null); ?> 
<?php echo Form::hidden('contact_detail['.$detail['id'].'][language_id][]', isset($value['language_id']) ? $value['language_id'] : null ); ?>



<?php if($detail->name == 'e-mail'): ?>
<?php echo Form::email('contact_detail['.$detail['id'].'][val][]', isset($value['value']) ? $value['value'] : null , ['class'=>'form-control', 'placeholder'=>'Input '. $detail['name']] ); ?>




<?php elseif($detail->name == 'phone'): ?>

<?php echo Form::text('contact_detail['.$detail['id'].'][val][]', isset($value['value']) ? $value['value'] : null , ['class'=>'form-control', 'placeholder'=>_('phone format +37100000000') ]); ?>




<?php else: ?>

<?php echo Form::text('contact_detail['.$detail['id'].'][val][]', isset($value['value']) ? $value['value'] : null , ['class'=>'form-control', 'placeholder'=>'Input '. $detail['name'] ] ); ?>

<?php endif; ?>

<?php /*<?php echo e(dd($detail)); ?>*/ ?>
<?php endif; ?>




