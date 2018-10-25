<div><?php /* šis DIVs ir obligāts jquery elementu klonešanai*/ ?>
    <div class="form-group">
        <?php echo Form::label('parent_id', _('Category'), ['class'=>'col-sm-2 control-label']); ?>

        <div class="col-sm-10">
            <?

            if ($categoryArrayTree[0]['showCurrentCategoryAsSelected'])
            {
                $level = 0;
            } else
            {
                $level = 2;
            }
            ?>
            <?php /*d($categoryArrayTree)*/ ?>
            <?php /*dd($level)*/ ?>
                <? $counter = 0 ?>
            <?php foreach(array_reverse($categoryArrayTree) as $key=> $tree): ?>

                <?php /*
                    #level =0 - nav izvēleto kategoriju (rāda top kategorijas bez izvēlētas konkrētas lategorijas)
                    $level =1 - rāda savu kategoriju kā izvēlēto (pēdējo kategoriju)
                    $level =2 - rādā parentkategoriju kā izvēlēto, savas kategorijas izvēlni vispār nerāda
                */ ?>


                <?php if(isset($categoryArrayTree[($key+$level)]) ): ?>

                    <?php if(isset($tree['parent']) && count($tree['parent'])>0 ): ?>
                        <select class="myselect form-control" name="category_id">
                            <option value="0">-</option>

                            <?php foreach($tree['parent'] as $category): ?>


                                <option value="<?php echo e($category['id']); ?>" <?php if($tree['parent_selected_id'] == $category['id']): ?>  selected <?php endif; ?> ><?php echo e($category['translation']['name']); ?> </option>



                            <?php endforeach; ?>

                        </select>

                    <?php endif; ?>


                <?php elseif(count($categoryArrayTree) < 3 ): ?>

                    <?php if(isset($tree['parent']) && count($tree['parent'])>0  && $counter==0 ): ?>
                        <select class="myselect form-control" name="category_id">
                            <option value="0" selected="selected">-</option>


                            <?php foreach($tree['parent'] as $category): ?>

                                <option value="<?php echo e($category['id']); ?>" <?php if($tree['parent_selected_id'] == $category['id']): ?>  <?php endif; ?> ><?php echo e($category['translation']['name']); ?> </option>

                            <?php endforeach; ?>

                        </select>
                    <?php endif; ?>
                    <? $counter = $counter+1 ?>

                <?php endif; ?>



            <?php endforeach; ?>
        </div>
    </div>
</div>
<?php echo $__env->make('categories.includes.js', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>