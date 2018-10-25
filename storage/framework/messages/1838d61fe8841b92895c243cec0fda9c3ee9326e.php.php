
<?php if(isset($errors) && count($errors) > 0): ?>
    <div class="alert alert-danger">
        <ul>
            <?php foreach($errors->all() as $error): ?>
                <li><?php echo e($error); ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>



<div class="form-group">
    <?php echo Form::label('name', 'Country name', ['class'=>'col-sm-2 control-label']); ?>

    <div class="col-sm-10">
        <?php echo Form::text('name', null , ['class'=>'form-control', 'placeholder'=>'Input Country name'] ); ?>

    </div>
</div>



