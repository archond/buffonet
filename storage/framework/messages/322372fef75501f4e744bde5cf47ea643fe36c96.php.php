<select name="search_value_category[1234]" data-name="search_value_category[1234]" class="myselect form-control col-sm-12" name="category_id">

    <?php if(isset($value['options'])): ?>
        <option value=""></option>
        <?php foreach($value['options'] as $option): ?>

            <option value="<?php echo e($option->id); ?>"
                    <?php if(isset( $value['value']) && $option['id'] == $value['value'] ): ?>
                    selected
                    <?php endif; ?>
            ><?php echo e($option['translation']['name']); ?></option>
        <?php endforeach; ?>
    <?php endif; ?>
</select>