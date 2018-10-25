<?php foreach(['quality', 'accurancy', 'communication'] as $item ): ?>
    <div class="<?php echo e(isset($class) ? $class: 'pull-left'); ?> row">
        <div class="col-sm-6 text-right"><?php echo e($item); ?>:</div>
        <?
        $plusStars = isset($eachRating[$item]) ? $eachRating[$item] instanceOf stdClass ? $eachRating[$item] : $eachRating[$item] : 0;

        ?>
        <div class="col-sm-6 text-left">
            [<?php echo e(ROUND($plusStars,2)); ?>]
            <?php for( $i =0; $i<(int)$plusStars; $i++): ?>
                <i class="fa-star"></i>
            <?php endfor; ?>

            <?php for( $i =$i; $i< 5; $i++): ?>
                <i class="fa-star-o"></i>
            <?php endfor; ?>

        </div>
    </div>
<?php endforeach; ?>

<div class="<?php echo e(isset($class) ? $class: 'pull-left'); ?> row">
    <div class="col-sm-6 text-right">Total raters:</div>
    <div class="col-sm-6 text-left">
        (<?php echo e($contact->rating_count); ?>)
    </div>
</div>

