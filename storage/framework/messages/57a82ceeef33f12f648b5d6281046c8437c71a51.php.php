<?php /* izvadam esošos failus*/ ?>


<?php /*<?php if($detail['is_collectable'] == 1 ): ?>*/ ?>
<?php /*<?php echo e(dd($isCollectableCounter)); ?>*/ ?>

<?php if($isCollectableCounter == 0 ): ?>

<?php echo Form::file('contact_detail['.$detail['id'].'][val][]',['class'=>'form-control file-input-styled', 'placeholder'=>'Input '.$detail->name, 'style'=> Route::currentRouteName() == 'contacts.create' ? 'background-color: #ABC9FF;' : ''] ); ?>


<?php endif; ?>

<div>
<?php /*<img src="<?php echo e(route('imagecache', ['template'=>'small', 'filename'=>$value['value'] ])); ?>">*/ ?>

</div>
