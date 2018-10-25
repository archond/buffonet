


<?php /*<?php echo e(dd($searchedCategory)); ?>*/ ?>

<?php if( !isset($searchedCategory) || !$searchedCategory): ?>

    <?php /*dd('!!!!!!!!!!!!!!');*/ ?>

    <?php /*<?php echo e(dd($detail->top_categories)); ?>*/ ?>
    <div class="">
        <?php /*šis DIVs ir obligāts jquery elementu klonešanai*/ ?>
        <div class="form-group ">
            <div class="input-group col-md-12 col-sm-12 col-xs-12">
                <?php /*<?php echo Form::hidden('contact_detail['.$detail['id'].'][values_id][eeee]', null); ?>*/ ?>
                <div>
                    <?php echo $__env->make('contacts.search.category-parent', ['value'=>$detail->top_categories, 'index' => '1234'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                </div>
                <?php /*<span class="input-group-addon remove-category-button"><i class="fa-minus"></i></span>*/ ?>
            </div>
        </div>
    </div>

    <?php /*-----------------*/ ?>

<?php else: ?>


    <?
    $index = str_random(5);
    ?>



    <?php /*<?php if(isset($searchedCategory->parent->parent->parent->parent->parent->parent->parent)): ?>*/ ?>
    <?php /*<?php echo $__env->make('contacts.search.category-parent', ['value'=>$searchedCategory->parent->parent->parent->parent->parent->parent->parent, 'index'=>$index], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>*/ ?>
    <?php /*<?php endif; ?>*/ ?>

    <?php /*<?php if(isset($searchedCategory->parent->parent->parent->parent->parent->parent)): ?>*/ ?>
    <?php /*<?php echo $__env->make('contacts.search.category-parent', ['value'=>$searchedCategory->parent->parent->parent->parent->parent->parent, 'index'=>$index], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>*/ ?>
    <?php /*<?php endif; ?>*/ ?>

    <?php /*<?php if(isset($searchedCategory->parent->parent->parent->parent->parent)): ?>*/ ?>
    <?php /*<?php echo $__env->make('contacts.search.category-parent', ['value'=>$searchedCategory->parent->parent->parent->parent->parent, 'index'=>$index], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>*/ ?>
    <?php /*<?php endif; ?>*/ ?>

    <?php /**/ ?>

    <?php /*<?php if(isset($searchedCategory->parent->parent->parent->parent)): ?>*/ ?>
    <?php /*6*/ ?>
    <?php /*<?php echo $__env->make('contacts.search.category-parent', ['value'=>$searchedCategory->parent->parent->parent->parent, 'index'=>$index], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>*/ ?>
    <?php /*<?php endif; ?>*/ ?>

    <?php /*<?php if(isset($searchedCategory->parent->parent->parent)): ?>*/ ?>

    <?php /*5*/ ?>
    <?php /*<?php echo $__env->make('contacts.search.category-parent', ['value'=>$searchedCategory->parent->parent->parent, 'index'=>$index], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>*/ ?>
    <?php /*<?php endif; ?>*/ ?>
    <?php /**/ ?>

    <?php if(isset($searchedCategory->parent->parent)): ?>
        <?php /*4*/ ?>
        <?php echo $__env->make('contacts.search.category-parent', ['value'=>$searchedCategory->parent->parent, 'index'=>$index], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php endif; ?>

    <?php if(isset($searchedCategory->parent)): ?>
        <?php /*3*/ ?>
        <?php echo $__env->make('contacts.search.category-parent', ['value'=>$searchedCategory->parent, 'index'=>$index], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php endif; ?>
    <?php /*2*/ ?>
    <?php if(isset($searchedCategory) && isset($searchedCategory->value) ): ?>
        <?php /*1*/ ?>
        <?php echo $__env->make('contacts.search.category-parent', ['value'=>$searchedCategory, 'index'=>$index], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php endif; ?>

<?php endif; ?>

