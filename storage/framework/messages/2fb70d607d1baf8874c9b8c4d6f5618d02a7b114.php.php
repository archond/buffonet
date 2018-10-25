<?
//obligātie params
//if (!isset($showAverageRating))
//{
//    abort(403, '"$showAverageRating" - is missing, obligatory param for view "contact.form" ');
//}
//
//if (!isset($showRatingDataInForm))
//{
//    abort(403, '"$showRatingDataInForm" - is missing, obligatory param for view "contact.form"');
//}


?>


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


<?
$ratingsCount = 0;
?>


<script type="text/javascript">
    $(document).ready(function () {
        $(document).ready(function () {
            $(".mainobject").select2();
        });
        $(document).ready(function () {
            $("#language_id").select2();
        });
    });
</script>


<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><?= _('Base info');?></h3>
    </div>
    <div class="panel-body">

        <?php if(isset( $mainObjects)): ?>

            <div class="form-group">
                <?php echo Form::label('mainobject_id', 'Main object', ['class'=>'col-sm-2 control-label']); ?>

                <div class="col-sm-10">
                    <?php echo Form::select('mainobject_id', $mainObjects->pluck('phone', 'id'), Request::has('main-object-id') ? Request::get('main-object-id') : null , ['class'=>'form-control mainobject', 'placeholder'=>'Select phone', 'id'=>'mainobject_id'] ); ?>



                </div>
            </div>


        <?php endif; ?>


        <div class="form-group row">
            <?php echo Form::label('language_id', 'Language', ['class'=>'col-sm-2 control-label']); ?>

            <div class="col-sm-10">
                <?php echo Form::select('language_id', $languages->pluck('name', 'id'), isset($languageId) ? $languageId : (isset($contact->language_id) ? $contact->language_id : null ) , ['class'=>'form-control', 'id'=>'language_id'] ); ?>

            </div>
        </div>
    </div>
</div>

<?php /*<?php if(isset($categoryArrayTree)): ?>*/ ?>
<?php /*<div>*/ ?>
<?php /*<?php echo $__env->make('categories.includes.select-path', ['categoryArrayTree'=>$categoryArrayTree], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>*/ ?>
<?php /*</div>*/ ?>
<?php /*<?php endif; ?>*/ ?>




<?php foreach($stages as $stage): ?>



    <div class="panel panel-default">
        <div class="panel-heading">
            <div><h3><?php echo e(isset($stage['translation']['name']) ? $stage['translation']['name'] :  $stage['name']); ?></h3>
            </div>
        </div>
        <div class="panel-body">


            <?php foreach($stage->contactDetails as $k => $detail): ?>


                <div class="form-group row" id=<?php echo e($detail->model == 'Category'  ?  "category-group-sc" : ""); ?> >

                    <?php if( ( !(Route::currentRouteName() == 'requests.admin-process-view' && $detail->model == 'Marker') ) && $detail->model != 'Tag' && $detail->model != 'Category'   ): ?>

                        <?php echo Form::label('name',
                         (isset($detail->translation) && isset($detail->translation->name))
                         ? $detail->translation->name
                         : (isset($detail['name']) ? $detail['name'] :'not set name'),
                         ['class'=> 'col-sm-2 control-label']); ?>

                    <?php else: ?>



                    <?php endif; ?>


                    <div class="<?php echo e((Route::currentRouteName() == 'requests.admin-process-view' && ($detail->model == 'Marker' || $detail->model == 'Category') ) || $detail->model == 'Tag'  || $detail->model == 'Category'  ? 'col-sm-12' : 'col-sm-10'); ?>">


                        <?php $counter = 0; ?>
                        <?php $isCollectableCounter = 0;  ?>
                        <?php



                        if (count($detail->values) == 0) { // šis ir nepieciešams, kad contactam nav konkrētās detaļas vērtības, lai tukš lauks parādītos, pievienojam tukšu atribūtu
                            $detail->setAttribute('values', ['values' => '']);
                        }



                        ?>



                        <?php if($detail->name == 'phone' && $counter ==0): ?>
                            <?php if(isset($contact->mainObejects->phone)): ?>
                                <div class="input-group col-sm-12">
                                    <?php echo e(Form::text('aaa', $contact->mainObejects->phone, ['disabled', 'class'=>'form-control col-md-12'])); ?>

                                </div>
                            <?php endif; ?>

                        <?php endif; ?>


                        <?php if($detail->model == 'Category' && $counter ==0): ?>
                            <div class="row category-btn-holder">
                                <div class="col-sm-12">
                                    <div class="">
                                        <div class="btn btn-gray add-category-button pull-right"><i class="fa-plus"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>


                        <?php if($detail->model == 'Marker' && $counter ==0): ?>
                            <div class="row marker-btn-holder">
                                <div class="col-sm-12">
                                    <div class="">
                                        <div class="btn btn-gray add-marker-button pull-right"><i class="fa-plus"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?$counter2 = 0;?>
                        <?php foreach($detail['values'] as $detailId => $value): ?>
                            <?php /*<?php echo e(var_dump($value)); ?>*/ ?>

                            <?php /* Categories */ ?>
                            <?php if($detail['model'] == 'Category' || (isset($detail->model ) && $detail->model == 'Category')  ): ?>
                                <?php if($counter2==0): ?>
                                    <?php echo $__env->make('contacts.fields.category', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                    <?php /*&nbsp;<div class="form-group-separator"></div>*/ ?>
                                <?php endif; ?>

                                <?php /* Markers */ ?>
                            <?php elseif($detail['model'] =='Marker' || (isset($detail->model) && $detail->model =='Marker')  ): ?>
                                <?php echo $__env->make('contacts.fields.marker', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                            <?php else: ?>

                                <?php /*var_dump((array)$value)*/ ?>
                                <div class="<?php echo e($detail->model != 'Tag' ? 'input-group' : null); ?> ">

                                    <?php if($detail['is_collectable'] == 1  ): ?>

                                        <?php if($isCollectableCounter==0): ?>
                                            <?php /* _('This is collectable field, you are not able to see submitted info') */ ?>
                                        <?php endif; ?>

                                    <?php else: ?>
                                        <?php /* hidden for all fiels */ ?>

                                    <?php endif; ?>

                                    <?php if($detail['is_translatable'] == 1): ?>
                                        <?php foreach($languages as $language): ?>
                                            <?php if(isset($value['language_id']) && $language->id == $value['language_id']): ?>
                                                Language: (<?php echo e(strtoupper ($language->abbr)); ?>)
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    <?php endif; ?>

                                    <?php /* tags */ ?>
                                    <?php if($detail['model'] =='Tag' || (isset($detail->model) && $detail->model =='Tag')  ): ?>
                                        <?php echo $__env->make('contacts.fields.tags', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                                        <?php /* ratings */ ?>
                                    <?php elseif($detail['model'] =='Rating' || (isset($detail->model) && $detail->model =='Rating')  ): ?>
                                        <?php if($ratingsCount++ ==0): ?>
                                            <?php /*<?php echo $__env->make('contacts.fields.rating', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>*/ ?>
                                        <?php endif; ?>

                                        <?php /* markers*/ ?>
                                        <?php /*<?php elseif($detail['model'] =='Marker' || (isset($detail->model) && $detail->model =='Marker')  ): ?>*/ ?>
                                        <?php /*<?php echo $__env->make('contacts.fields.marker', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>*/ ?>



                                        <?php /* text */ ?>
                                    <?php elseif($detail['input_field']['name'] =='text' || (isset($detail->inputField['name'])  && $detail->inputField['name'] =='text') ): ?>
                                        <?php /*<pre>*/ ?>
                                        <?php /* <?php if($detail->id == 5 OR $detail->id == 4): ?><pre><?php echo e(var_dump($detail->values)); ?></pre> <?php endif; ?> */ ?>

                                        <?php /*</pre>*/ ?>
                                        <?php echo $__env->make('contacts.fields.text', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>



                                        <?php /* textarea*/ ?>
                                    <?php elseif($detail['input_field']['name'] =='textarea' || (isset($detail->inputField['name'])  && $detail->inputField['name'] =='textarea') ): ?>

                                        <?php echo $__env->make('contacts.fields.textarea', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                                        <?php /* select*/ ?>
                                    <?php elseif($detail['input_field']['name'] =='select' || (isset($detail->inputField['name'])  && $detail->inputField['name'] =='select') ): ?>
                                        <?php echo $__env->make('contacts.fields.select', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                                        <?php /* checkbox*/ ?>
                                    <?php elseif($detail['input_field']['name'] =='checkbox' ||(isset($detail->inputField['name'])  && $detail->inputField['name'] =='checkbox') ): ?>
                                        <?php echo $__env->make('contacts.fields.checkbox', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                                        <?php /* radio*/ ?>
                                    <?php elseif($detail['input_field']['name'] =='radio' || (isset($detail->inputField['name'])  && $detail->inputField['name'] =='radio') ): ?>
                                        <?php echo $__env->make('contacts.fields.radio', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                                        <?php /* file*/ ?>
                                    <?php elseif($detail['input_field']['name'] =='file' || (isset($detail->inputField['name'])  && $detail->inputField['name'] =='file') ): ?>

                                        <?php echo $__env->make('contacts.fields.file', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                                    <?php endif; ?>


                                    <?php if($detail['is_uniq_value'] !=1): ?>


                                        <?php if( in_array($detail->inputField->name , ['text', 'file', 'textarea'] )  && !in_array($detail->model, ['Category'])): ?>

                                            <?php if($detail->inputField->name == 'textarea'): ?>

                                                <?php if($detail->name =='comment'): ?>

                                                    <?php if($counter++ == 0 ): ?>
                                                        <span class="input-group-addon add-button"><i
                                                                    class="fa-plus"></i></span>
                                                    <?php elseif($detail->inputField->name != 'fi1111le'): ?>
                                                        <span class="input-group-addon remove-button btn-danger"><i
                                                                    class="fa-remove"></i></span>
                                                    <?php endif; ?>

                                                <?php endif; ?>

                                            <?php else: ?>
                                                <?php if($counter++ == 0 ): ?>
                                                    <span class="input-group-addon add-button"><i
                                                                class="fa-plus"></i></span>
                                                <?php elseif($detail->inputField->name == 'file'): ?>

                                                <?php else: ?>
                                                    <span class="input-group-addon remove-button btn-danger"><i
                                                                class="fa-remove"></i></span>
                                                <?php endif; ?>
                                            <?php endif; ?>


                                        <?php endif; ?>
                                    <?php else: ?>
                                        <span class="input-group-addon "><i class="fa-square-o"></i></span>
                                    <?php endif; ?>

                                </div>
                                <? $isCollectableCounter++?>
                                <?php /*<?php echo e(var_dump($detail->inputField->name)); ?>*/ ?>

                                <?php if($detail->inputField->name =='file'): ?>
<?php /*                                        <?php echo e(var_dump($value['value'])); ?>*/ ?>
                                        <?php /*<?php echo e(var_dump($value)); ?>*/ ?>
                                        <?php /*<?php echo e('!!!'); ?>*/ ?>
                                <?php endif; ?>

                                <?php if($detail->inputField->name =='file' && isset($value['value']) && $value['value'] ): ?>


                                    <div class="image-container">
                                        <div class="pull-left">
                                            <img src="<?php echo e(route('imagecache', ['template'=>'small', 'filename'=>$value['value'] ])); ?>"
                                                 class="media-image-list ">
                                            <div class="text-center">
                                                <?php if(strpos($value['value'], 'files-request') !== false ): ?>
                                                    <? $indexImage = str_random(4); ?>
                                                    <input type="hidden"
                                                           name="contact_detail[<?php echo e($detail['id']); ?>][values_id][<?php echo e($indexImage); ?>]"
                                                           value="" class="new-file-path11"/>
                                                    <input type="hidden"
                                                           name="contact_detail[<?php echo e($detail['id']); ?>][val][<?php echo e($indexImage); ?>]"
                                                           value="<?php echo e($value['value']); ?>" class="new-file-path"/>

                                                <?php endif; ?>
                                                <?php echo e(_('Delete?')); ?>


                                                <?php echo Form::checkbox('contact_detail['.$detail['id'].'][delete_values_id][]', isset($value['id']) ? $value['id'] : null, isset($value['id']) && isset($detail['delete_values_id']) && in_array($value['id'], $detail['delete_values_id']) ? true :false, ['class'=>'image-delete-chk'] ); ?>


                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>

                            <? $counter2++ ?>
                        <?php endforeach; ?>

                    </div>
                </div>


            <?php endforeach; ?>
        </div>
    </div>
<?php endforeach; ?>

<?php if( !isset($doNotLoadJsTwice ) ): ?>

    <?php echo $__env->make('contacts.form-js', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php endif; ?>


