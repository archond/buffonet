


            <?php /*<select name="contact_detail[<?php echo e(isset($detail['id']) ? $detail['id'] : null); ?>][val][<?php echo e(isset($index) ? $index : 'wwww'); ?>]"*/ ?>
                    <?php /*data-name="contact_detail[<?php echo e(isset($detail['id']) ? $detail['id'] : null); ?>][val][<?php echo e(isset($index) ? $index : 'wwww'); ?>]"*/ ?>
                    <?php /*class="myselect form-control" name="category_id">*/ ?>

                <?php /*<?php if(isset($value['options'])): ?>*/ ?>
                    <?php /*<option value="">-</option>*/ ?>
                    <?php /*<?php foreach($value['options'] as $option): ?>*/ ?>

                        <?php /*<option value="<?php echo e($option->id); ?>"*/ ?>
                                <?php /*<?php if(isset( $value['value']) && $option['id'] == $value['value'] ): ?>*/ ?>
                                <?php /*selected*/ ?>
                                <?php /*<?php endif; ?>*/ ?>
                        <?php /*><?php echo e($option['translation'][0]['name']); ?></option>*/ ?>
                    <?php /*<?php endforeach; ?>*/ ?>
                <?php /*<?php endif; ?>*/ ?>
            <?php /*</select>*/ ?>

            <?php /*<?php echo e(dd($category)); ?>*/ ?>
            <select class="myselect0 form-control">

                <?php if(isset($category['brothers'])): ?>
                    <option value="">-</option>
                    <?php foreach($category['brothers'] as $option): ?>

                        <option value="<?php echo e($option->id); ?>"
                                <?php if(isset( $category['id']) && $option['id'] == $category['id'] ): ?>
                                selected
                                <?php endif; ?>
                        ><?php echo e($option['translation']['name']); ?></option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>

