<?php $__env->startSection('content'); ?>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><?php echo e(_('Compare received data with existing')); ?></h3>
        </div>
    </div>

    <div class="col-sm-12">
        <div class="col-sm-6">
            <?php /*<div class="panel panel-default">*/ ?>
            <?php /*<div class="panel-body">*/ ?>

            <?php /*                    <?php echo e(Form::model('contact', ['class'=>'form-horizontal', 'method'=>'post','files'=>'true','route' => ['contacts.update', $contact->id ]])); ?>*/ ?>

            <?
            $showAverageRating = 1;
            $showRatingDataInForm = 1;
            ?>
            <?php echo $__env->make('contacts.form', ['stages'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>


            <?php /*<div class="form-group">*/ ?>
            <?php /*<?php echo Form::label('', '', ['class'=>'col-sm-2 control-label']); ?>*/ ?>
            <?php /*<div class="col-sm-10">*/ ?>
            <?php /*<?php echo e(Form::submit('Save received data', ['class'=>'btn'])); ?>*/ ?>
            <?php /*</div>*/ ?>

            <?php /*</div>*/ ?>
            <?php /*<?php echo e(Form::close()); ?>*/ ?>
            <?php /*</div>*/ ?>
            <?php /*</div>*/ ?>
        </div>


        <div class="col-sm-6">
            <?php /*<div class="panel panel-default">*/ ?>
            <?php /*<div class="panel-body">*/ ?>


            <?php echo Form::open(['class'=>'form-horizontal', 'method'=>'put','files'=>'true','route' => ['requests.admin-process-save', $myRequest->id, $contact->id  ] ] ); ?>



            <?


            $stages1 = $stages->each(function ($stage, $stageKey) use ($stages) {
                $stage = $stage->contactDetails->each(function ($detail, $detailKey) use ($stageKey, $stages) {


//                    $detail->setRelation('values', collect($detail->valuesUpdated));
                    $detail->setAttribute('values', collect($detail->valuesUpdated));
                    return $detail;
                });

                return $stage;
            });

            $languageId = unserialize($myRequest->request_data)['language_id'];


            $stages1 = (new App\Http\Controllers\ContactController())->setTranslatableFieldsIfNotTranslations($stages1, $contactDetailValues);
            $stages1 = (new App\Http\Controllers\ContactController())->setCategoryParentCategories($stages1);

            $stages = $stages1;

//                dd($stages[5]);

//                dd($stages[0]->contactDetails[2]->values);


            $tagList = $tagListNew;

            $doNotLoadJsTwice = true;
//            $showRatingDataInForm = true;

            $categories = $categoriesNew;
            $addresses = $addressesNew;



            ?>

            <?php /*<pre>*/ ?>
                <?php /*<?php echo e(var_dump($stages)); ?>*/ ?>
            <?php /*</pre>*/ ?>

            <?php /*<?php echo $__env->make('contacts.form', ['stages', 'doNotLoadJsTwice', 'showRatingDataInForm', '$showAverageRating', 'showRatingDataInForm', 'languageId', 'categories'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>*/ ?>
            <?php echo $__env->make('contacts.form', ['stages', 'doNotLoadJsTwice', 'showRatingDataInForm','languageId', 'categories'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>


            <div class="form-group col-sm-12">
                <?php echo Form::label('', '', ['class'=>'col-sm-2 control-label']); ?>

                <div class="col-sm-10">
                    <?php echo Form::submit(_('Save received data'), ['class'=>'btn']); ?>

                    <a href="<?php echo e(route('requests.admin-process-reject', $myRequest->id)); ?>"
                       class="btn btn-red"><?php echo e(_('Reject received data')); ?></a>
                </div>
            </div>
            <?php echo Form::close(); ?>


            <?php /*</div>*/ ?>
            <?php /*</div>*/ ?>
        </div>
    </div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>