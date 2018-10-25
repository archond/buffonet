<!-- <pre> -->
<?php
// var_dump( $validator->errors() );
?>
        <!-- </pre> -->
<?php if(isset($errors) && count($errors) > 0): ?>
    <div class="alert alert-danger">
        <ul>
            <?php foreach($errors->all() as $error): ?>
                <li><?php echo e($error); ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>


<?php if(isset($country->id)): ?>
    <?php echo e(Form::hidden('countryId', $country->id)); ?>

<?php endif; ?>

<div class="form-group">
    <?php echo Form::label('country_id', _('Select country'), ['class'=>'col-sm-2 control-label']); ?>

    <div class="col-sm-10">
        <?php echo Form::select('country_id', $countries->pluck('name', 'id'), isset($country->id) ? $country->id : null , ['class'=>'form-control', 'placeholder'=>null] ); ?>

    </div>
</div>


<div class="form-group">
    <?php echo Form::label('name', _('City name'), ['class'=>'col-sm-2 control-label']); ?>

    <div class="col-sm-10">
        <?php echo Form::text('name', isset($city->name) ? $city['name'] : null , ['class'=>'form-control', 'placeholder'=>_('Input City name') ] ); ?>

    </div>
</div>



