<?=_('Hi')?>, <?php echo e($request['email']); ?> <br><br>


<?php echo e($request->message_text); ?>


<br><br>

<?/*=_('Could you please provide me with your contact info?')?><br><br>*/?>

<?/*If you agree, <a href="{{ url(route('request-form', Crypt::encrypt($request['id'] ) ) ) }}">click on this <b>link</b></a>.*/?>
<?/*<?=_('If you agree')?>, <a href="{{ url($request->contact->language->abbr.'/request-form/'.Crypt::encrypt($request['id'] ) )  }}"><b><?=_('click on this link')?></b></a>.*/?>
Linki:
<?php foreach($languages as $language): ?>
    <a href="<?php echo e(url($language->abbr.'/request-form/'.Crypt::encrypt($request['id'] ) )); ?>"><b><?php echo e($language->name); ?></b></a><br>
<?php endforeach; ?>

<br><br>


<?=_('Thank you')?>!<br><br>

<?php echo e(config('constants.APP_NAME')); ?>


