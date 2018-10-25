<li>
    <div style="height: 33px " class="hoverDiv">

        <?php if($category['translation']['language_id'] == $selectedLanguage->id): ?>
            <?php echo e($category['translation']['name']); ?>

        <?php endif; ?>

        <div class="pull-right">
            <a class="btn btn-success btn-xs" href="<?php echo e(route('categories.edit', $category['id'])); ?>"><i
                        class="fa fa-edit"></i></a>

            <div class="btn btn-red btn-xs btn-delete"
                 data-url="<?php echo e(route('category.delete', ['id'=>Crypt::encrypt($category['id'])  ] )); ?>"><i
                        class="fa fa-remove"></i>
            </div>
        </div>
    </div>


    <ul>

        <?php if(isset($category['all_children'])): ?>

            <?php foreach($category['all_children'] as $category): ?>
                <?php echo $__env->make('categories.includes.item', ['categories'=>$category['children']], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <?php endforeach; ?>

        <?php elseif(isset($category['children'])): ?>

            <?php foreach($category['children'] as $category): ?>
                <?php echo $__env->make('categories.includes.item', ['categories'=>isset($category['children']) ? $category['children'] : [] ], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <?php endforeach; ?>

        <?php endif; ?>
    </ul>
</li>