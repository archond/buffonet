<?php /*<?php echo e(dd($value)); ?>*/ ?>


<?php /*<div class="pull-right btn"><?php if(isset($value->parent)): ?> <span class="fa-chevron-right"></span> <?php endif; ?> <?php echo e(isset($value->translations[0]) ? $value->translations[0]->name : _('No category assigned to object')); ?> </div>*/ ?>

<?php /*<?php if(isset($value->parent)): ?>*/ ?>
<?php /*<?php echo $__env->make('contacts.show-category', ['value'=>$value->parent], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>*/ ?>
<?php /*<?php endif; ?>*/ ?>

<?php /*<?php echo e(dd($categories)); ?>*/ ?>

<ul>
    <?php foreach($categories as $category): ?>

        <li>

            <?php if(isset($category['parent']->parentCategory->parentCategory->brothers)): ?>
                <?php echo e($category['parent']->parentCategory->parentCategory->brothers->where('id', $category['parent']->parentCategory->parentCategory->id)->first()->translation->name); ?>

                <span class="fa fa-chevron-right "></span>
            <?php endif; ?>

            <?php if(isset($category['parent']->parentCategory->brothers)): ?>
                <?php echo e($category['parent']->parentCategory->brothers->where('id', $category['parent']->parentCategory->id)->first()->translation->name); ?>

                <span class="fa fa-chevron-right "></span>
            <?php endif; ?>


            <?php if(isset($category['parent']['brothers'])): ?>
                <?php echo e($category['parent']['brothers']->where('id', $category['parent']['id'])->first()->translation->name); ?>

                :
                <ul>
                    <?php foreach($category['brothers'] as $brother): ?>
                        <?php if(in_array($brother->id, $category['selectedIds'])): ?>
                            <li style="display: inline;"><?php echo e($brother->translation->name); ?></li>;
                        <?php endif; ?>
                    <?php endforeach; ?>

                </ul>
            <?php endif; ?>
        </li>

        <?php /*<li></li>*/ ?>


    <?php endforeach; ?>
</ul>

