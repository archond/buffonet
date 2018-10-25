<?=_('Hi')?>, <?php echo e($email); ?><br><br>



<?= _('Please be so kind and rate following object') ;?> :<?php echo e($title); ?><br><br>

<?=_('Please')?>, <a href="<?php echo e(url($contact->language->abbr.'/request-ask-for-rating/'.Crypt::encrypt($rating['id'] ) )); ?>"><b><?=_('click on this link')?></b></a>.

<br><br>
<?php echo e($message_text); ?>

<br><br>
<?=_('Thank you')?>!<br><br>

<?php echo e(config('constants.APP_NAME')); ?>

