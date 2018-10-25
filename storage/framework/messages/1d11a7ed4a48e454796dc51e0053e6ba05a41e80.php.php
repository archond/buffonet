<?php /*<?php echo e(var_dump($category['selectedIds'])); ?>*/ ?>

<div class="FourthLevelCategoryForm fromDb">
    <select class=" multi-select"  multiple="multiple" name="selected_categories[]">
        <?php if(isset($category['brothers'])): ?>
        <?php /*<option value="">-</option>*/ ?>
        <?php foreach($category['brothers'] as $option): ?>

        <option value="<?php echo e($option->id); ?>"
        <?php if( in_array($option['id'], $category['selectedIds']) ): ?>
        selected
        <?php endif; ?>
        ><?php echo e($option['translation']['name']); ?>  </option>

        <?php endforeach; ?>
        <?php endif; ?>
    </select>
</div>


<script>
    <?php /*var data = "<?php echo e(implode(',', $category['selectedIds'] )); ?>";*/ ?>
    <?php /*var presetValArray = data.split(",");*/ ?>

</script>

