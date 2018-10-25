<hr>
<div class="form-group">
    <?php echo Form::label('', _('Email'), ['class'=>'col-sm-2 control-label']); ?>

    <div class="col-sm-10 ">
        <?php echo e(isset($rating->email) ? $rating->email : '-'); ?>

    </div>
</div>

<div class="form-group">
    <?php echo Form::label('', _('Sentdate'), ['class'=>'col-sm-2 control-label']); ?>

    <div class="col-sm-10 ">
        <?php echo e(isset($rating->sent_date) ? $rating->sent_date : '-'); ?>

    </div>
</div>




<div class="form-group">
    <?php echo Form::label('', _('Complete date'), ['class'=>'col-sm-2 control-label']); ?>

    <div class="col-sm-10 ">
        <?php echo e(isset($rating->complete_date) ? $rating->complete_date : '-'); ?>

    </div>
</div>

