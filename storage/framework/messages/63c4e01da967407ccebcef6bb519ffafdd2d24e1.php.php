<?// $isCollectableCounter++?>
<?php if( !isset($counter2) || $counter2 == 0): ?>
<div>
    <div id="category-default-div" class=" hidden input-group-A">

        <div class="col-sm-12 ">
            <?php /*šis DIVs ir obligāts jquery elementu klonešanai*/ ?>
            <div class="form-group">
                <div class="input-group">

                    <?php /*<?php echo Form::hidden('contact_detail['.$detail['id'].'][values_id][wwww]', null); ?>*/ ?>
                    <div>
                        <?php echo $__env->make('contacts.fields.parentCategory', ['category'=>$topCategories], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                    </div>

                    <span class="input-group-addon remove-category-button"><i class="fa-minus"></i></span>

                </div>
            </div>
        </div>

    </div>
    <div class="FourthLevelCategoryForm hidden">
        <select class=" multi-select" multiple="multiple" name="selected_categories[]">

        </select>
    </div>
    <div class="form-group-separator hidden1"></div>
</div>

<div id="place-here-new-cat-divs" class="place-here-new-cat-divs"></div>

<?php endif; ?>

<?php foreach($categories as $category): ?>
<?php if( isset($category['parent']->parentCategory->parentCategory) ): ?>
<div class="input-group-A">

    <div class="col-sm-12 ">
        <div class="input-group form-group">
            <? $index = str_random(4)?>
            <?php echo Form::hidden('contact_detail['.$detail['id'].'][values_id]['.$index .']', isset($value['id']) ? $value['id'] : null); ?>



            <?php /*<?php if(isset($value->parent->parent->parent)): ?>*/ ?>
            <?php /*<?php echo $__env->make('contacts.fields.parentCategory', ['value'=>$value->parent->parent->parent, 'index'=>$index], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>*/ ?>
            <?php /*<?php endif; ?>*/ ?>


            <?php /*<?php if(isset($value->parent->parent)): ?>*/ ?>
            <?php /*<?php echo $__env->make('contacts.fields.parentCategory', ['value'=>$value->parent->parent, 'index'=>$index], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>*/ ?>
            <?php /*<?php endif; ?>*/ ?>

            <?php /*<?php echo e(dd($category['parent']->parentCategory)); ?>*/ ?>


            <?php echo $__env->make('contacts.fields.parentCategory', ['category'=>$category['parent']->parentCategory->parentCategory] , array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <?php echo $__env->make('contacts.fields.parentCategory', ['category'=>$category['parent']->parentCategory] , array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <?php echo $__env->make('contacts.fields.parentCategory', ['category'=>$category['parent']], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <?php echo $__env->make('contacts.fields.parentCategory4thLevel', $category, array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>



            <?php /*<?php if( isset($value->value) ): ?>*/ ?>
            <span class="input-group-addon remove-category-button"><i class="fa-minus"></i></span>
            <?php /*<?php endif; ?>*/ ?>

        </div>
    </div>
</div>
<?php endif; ?>


<div class="FourthLevelCategoryForm hidden">
    <select class=" multi-select" multiple="multiple" name="selected_categories[]">

    </select>
</div>
<br>
<?php /*&nbsp;*/ ?>
<?php /*<div class="form-group-separator"></div>*/ ?>
<?php endforeach; ?>


<? $categoriesNeed4thLevelSet = 1?>
<script>
    <?php if(isset($categoriesNeed4thLevelSet) && $categoriesNeed4thLevelSet ==1 && Route::currentRouteName() != 'contacts.index' ): ?>

    //$categgoriesNeed4thLevelSet comes from contacts\fiels\category.bade.php
    $("form").submit(function (e) {
        e.preventDefault();
        var categoriesIsSet = false;

        $('select[name="selected_categories[]"').each(function () {
            console.log('$(this).val()', $(this).val());
            if (categoriesIsSet == false && $(this).val() != '' && $(this).val()) {
                categoriesIsSet = true;
            }

            console.log('categoriesIsSet', categoriesIsSet);
        });


        console.log('categoriesIsSet', categoriesIsSet);

        if (categoriesIsSet == false) {
            e.stopImmediatePropagation();
            alert("<?php echo e(_('At least one Category of 4th level is required')); ?>");
            return false;
        }
    });

    <?php endif; ?>
</script>


