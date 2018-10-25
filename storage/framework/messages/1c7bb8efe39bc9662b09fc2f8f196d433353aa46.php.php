<?// $isCollectableCounter++?>
<?php if( !isset($counter2) || $counter2 == 0): ?>
<div>
    <div id="category-default-div" class=" hidden input-group-A">

        <div class="col-sm-12 ">
            <?php /*šis DIVs ir obligāts jquery elementu klonešanai*/ ?>
            <div class="form-group">
                <div class="input-group">

                    <?php echo Form::hidden('contact_detail['.$detail['id'].'][values_id][wwww]', null); ?>

                    <div>
                        <?php echo $__env->make('contacts.fields.parentCategory', ['value'=>$detail->top_categories, 'index' => 'wwww'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                    </div>

                    <span class="input-group-addon remove-category-button"><i class="fa-minus"></i></span>

                </div>
            </div>
        </div>

    </div>
    <div class="FourthLevelCategoryForm hidden">
        <select class=" multi-select"  multiple="multiple" name="selected_categories[]">

        </select>
    </div>
    <div class="form-group-separator hidden1"></div>
</div>

<div id="place-here-new-cat-divs"></div>


<?php /*<?php echo e(dd($detail)); ?>*/ ?>
<?php /*pārbaudam, vai ir jau irpeikš uzstādītavismaz viena kategorija!*/ ?>
<?php if(!is_object($detail['values']) || $detail['values']->count() ==0 ): ?>
<?php /*ja == 0, tad izvadam otreiz default categories, jo kategoriju vispār nav */ ?>

<?php /*<div class="col-sm-12 load2levels">*/ ?>
    <?php /*šis DIVs ir obligāts jquery elementu klonešanai*/ ?>
    <?php /*<div class="form-group">*/ ?>
        <?php /*<div class="input-group">*/ ?>
            <?php /*<?php echo Form::hidden('contact_detail['.$detail['id'].'][values_id][eeee]', null); ?>*/ ?>
            <?php /*<div>*/ ?>
                <?php /*<?php echo $__env->make('contacts.fields.parentCategory', ['value'=>$detail->top_categories, 'index' => 'eeee'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>*/ ?>
            <?php /*</div>*/ ?>



            <?php /*<div  class="FourthLevelCategoryForm hidden">*/ ?>
                <?php /*<select class=" multi-select" idtt="multi-select" name="selected_categories[]">*/ ?>

                    <?php /*</select>*/ ?>

            <?php /*</div>*/ ?>


            <?php /*<span class="input-group-addon remove-category-button"><i class="fa-minus"></i></span>*/ ?>
        <?php /*</div>*/ ?>

    <?php /*</div>*/ ?>

<?php /*</div>*/ ?>


<?php endif; ?>

<?php endif; ?>


<div class="input-group-A">

    <div class="col-sm-12 ">
        <div class="input-group form-group">
            <? $index = str_random(4)?>
            <?php echo Form::hidden('contact_detail['.$detail['id'].'][values_id]['.$index .']', isset($value['id']) ? $value['id'] : null); ?>



            <?php /*<?php if(isset($value->parent->parent->parent->parent->parent->parent->parent)): ?>*/ ?>
                <?php /*<?php echo $__env->make('contacts.fields.parentCategory', ['value'=>$value->parent->parent->parent->parent->parent->parent->parent, 'index'=>$index], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>*/ ?>
            <?php /*<?php endif; ?>*/ ?>

            <?php /*<?php if(isset($value->parent->parent->parent->parent->parent->parent)): ?>*/ ?>
                <?php /*<?php echo $__env->make('contacts.fields.parentCategory', ['value'=>$value->parent->parent->parent->parent->parent->parent, 'index'=>$index], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>*/ ?>
            <?php /*<?php endif; ?>*/ ?>

            <?php /*<?php if(isset($value->parent->parent->parent->parent->parent)): ?>*/ ?>
                <?php /*<?php echo $__env->make('contacts.fields.parentCategory', ['value'=>$value->parent->parent->parent->parent->parent, 'index'=>$index], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>*/ ?>
            <?php /*<?php endif; ?>*/ ?>

            <?php /**/ ?>

            <?php /*<?php if(isset($value->parent->parent->parent->parent)): ?>*/ ?>
                <?php /*<?php echo $__env->make('contacts.fields.parentCategory', ['value'=>$value->parent->parent->parent->parent, 'index'=>$index], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>*/ ?>
            <?php /*<?php endif; ?>*/ ?>



            <?php if(isset($value->parent->parent->parent)): ?>
                <?php echo $__env->make('contacts.fields.parentCategory', ['value'=>$value->parent->parent->parent, 'index'=>$index], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <?php endif; ?>


            <?php if(isset($value->parent->parent)): ?>
                <?php echo $__env->make('contacts.fields.parentCategory', ['value'=>$value->parent->parent, 'index'=>$index], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <?php endif; ?>

            <?php if(isset($value->parent)): ?>
                <?php echo $__env->make('contacts.fields.parentCategory', ['value'=>$value->parent, 'index'=>$index], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <?php endif; ?>

            <?php if(isset($value) && isset($value->value) ): ?>

                <?php echo $__env->make('contacts.fields.parentCategory4thLevel', ['value'=>$value, 'index'=>$index], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <?php endif; ?>




            <?php /*</div>*/ ?>
            <?php /*</div>*/ ?>

            <?php if( isset($value->value) ): ?>
                <span class="input-group-addon remove-category-button"><i class="fa-minus"></i></span>
            <?php endif; ?>

        </div>
    </div>
</div>

<?php /*<div id="4thLevelCategoryForm"  class="panel-body hidden">*/ ?>
<?php /*<div class="form-group">*/ ?>
<?php /*<div class="col-sm-12">*/ ?>
<?php /*<script type="text/javascript">*/ ?>
<?php /*jQuery(document).ready(function ($) {*/ ?>
<?php /*$("#multi-select").multiSelect({*/ ?>
<?php /*afterInit: function () {*/ ?>
<?php /*// Add alternative scrollbar to list*/ ?>
<?php /*this.$selectableContainer.add(this.$selectionContainer).find('.ms-list').perfectScrollbar();*/ ?>
<?php /*},*/ ?>
<?php /*afterSelect: function () {*/ ?>
<?php /*// Update scrollbar size*/ ?>
<?php /*this.$selectableContainer.add(this.$selectionContainer).find('.ms-list').perfectScrollbar('update');*/ ?>
<?php /*}*/ ?>
<?php /*});*/ ?>
<?php /*});*/ ?>
<?php /*</script>*/ ?>
<?php /*<select class="form-control" multiple="multiple" id="multi-select" name="my-selected_categories[]">*/ ?>
<?php /*<option value="19" selected>Healing in the Silence</option>*/ ?>
<?php /*</select>*/ ?>

<?php /*</div>*/ ?>
<?php /*</div>*/ ?>
<?php /*</div>*/ ?>


<?php /*<div id="4thLevelCategoryForm" class="hidden">*/ ?>
<?php /*<select class="form-control1 multi-select" multiple="multiple" id="multi-select" name="selected_categories">*/ ?>
<?php /*<option value="19" selected>Healing in the Silence</option>*/ ?>
<?php /*</select>*/ ?>
<?php /*</div>*/ ?>


<div class="FourthLevelCategoryForm hidden">
    <select class=" multi-select"  multiple="multiple" name="selected_categories[]">

    </select>
</div>