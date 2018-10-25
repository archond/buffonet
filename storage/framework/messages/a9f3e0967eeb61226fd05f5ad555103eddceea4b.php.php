<?php $__env->startSection('content'); ?>


    <style>
        .left-column {
            width: 200px;
        }

        .hoverDiv:hover {
            background-color: #EEEEEE;
            overflow: hidden;
        }

    </style>

    <div class="row">
        <div class="panel panel-flat">
            <div class="panel-heading">
                <?php /*<div><?php echo e($contact->name); ?></div>*/ ?>
                <div class="form-group pull-right">
                    <a class="btn btn-info pull-righ1t"
                       href="<?php echo e(route('contacts.create-ask-request', $contact->id)); ?>"><?php echo e(_('Request to update contacts info')); ?></a>
                    <a class="btn btn-info pull-right1"
                       href="<?php echo e(route('contacts.send-mail-create', $contact->id)); ?>"><?php echo e(_('Send Mail to contact')); ?></a>
                </div>


            </div>

            <div class="panel-body ">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <?php echo e($contact->mainobejects->phone); ?>

                    </div>
                </div>
            </div>

            <?php if( isset($contact->mainobejects->contacts) && $contact->mainobejects->contacts->count() > 1 ): ?>

                <div class="panel-body ">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <?php echo e(_('Related objects')); ?>:
                            <div class="btn btn-info pull-right"
                                 id="show-hide-related-objects-btn"><?php echo e(_('Show / hide related contacts')); ?></div>
                        </div>
                        <div class="panel-body " id="related-objects-div">
                            <div class="form-group row">
                                <label class="col-sm-2 form-control-label"><?php echo e(_('Related contacts')); ?></label>
                                <div class="col-sm-10">
                                    <?php if( isset($contact->mainobejects->contacts) ): ?>
                                        <ul>
                                            <?php foreach($contact->mainobejects->contacts as $relatedContact): ?>

                                                <?php if($contact->id !== $relatedContact->id): ?>
                                                    <li>
                                                        <?php /*<?php echo e(dd($relatedContact->contactDetailValue)); ?>*/ ?>
                                                        <a href="<?php echo e(route('contacts.show', $relatedContact->id)); ?>">
                                                            <?php echo e(isset( $relatedContact->contactDetailValue->value)
                                                 ? $relatedContact->contactDetailValue->value : _('Contact without title')); ?>

                                                        </a>
                                                    </li>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </ul>
                                </div>
                            </div>

                            <?php else: ?>
                                <?php echo e(_('Contact do not have any related object')); ?>

                            <?php endif; ?>
                        </div>

                    </div>
                </div>
            <?php endif; ?>

            <div class="panel-body ">


                <?php foreach($stages as $stage): ?>
                    <div class="panel panel-default">
                        <div class="panel-heading">

                            <div><?php echo e($stage->name); ?>:</div>

                            <?php /*<?php echo e(dd($stage)); ?>*/ ?>

                        </div>
                        <div class="panel-body ">

                            <?php foreach($stage->contactDetails as $detail): ?>

                                <? $counter = -1?>

                                <div class="form-group row">
                                    <label class="col-sm-2 form-control-label"><?php echo e($detail->name); ?></label>
                                    <div class="col-sm-10">

                                        <?php if($detail->name =='phone'): ?>
                                            <?php if($detail->values && count($detail->values) ==0 ): ?>
                                                <?php echo e($contact->mainobejects->phone); ?>

                                            <?php endif; ?>

                                        <?php endif; ?>


                                        <?php if($detail->values && count($detail->values) !=0 ): ?>

                                            <?php foreach($detail->values as $value): ?>


                                                <? $counter++?>

                                                <?php if($detail->inputField->name == 'file'): ?>

                                                    <a href="<?php echo e(route('imagecache', ['template'=>'original', 'filename'=>$value['value'] ])); ?>"
                                                       data-lightbox="roadtrip">
                                                        <img src="<?php echo e(route('imagecache', ['template'=>'smallCustom', 'filename'=>$value['value'] ])); ?>">
                                                    </a>

                                                <?php elseif($detail->name == 'web'): ?>
                                                    <a href="<?php echo e(url($value->value)); ?>"
                                                       target="_blank"><?php echo e($value->value); ?></a>
                                                <?php elseif($detail->name == 'social networks'): ?>
                                                    <a href="<?php echo e($value->value); ?>" target="_blank">
                                                        <?php if(strpos($value->value, 'youtube.com') !== false): ?>
                                                            <span class="fa fa-youtube fa-3x"></span>
                                                        <?php elseif(strpos($value->value, 'twitter.com') !== false): ?>
                                                            <span class="fa fa-twitter fa-3x"></span>
                                                        <?php elseif(strpos($value->value, 'facebook.com') !== false): ?>
                                                            <span class="fa fa-facebook-square fa-3x"></span>
                                                        <?php elseif(strpos($value->value, 'google.com') !== false): ?>
                                                            <span class="fa fa-google-plus-square fa-3x"></span>
                                                        <?php elseif(strpos($value->value, 'vk.com') !== false): ?>
                                                            <span class="fa fa-vk fa-3x"></span>

                                                        <?php elseif(strpos($value->value, 'linkedin.com') !== false): ?>
                                                            <span class="fa fa-linkedin-square fa-3x"></span>

                                                        <?php else: ?>
                                                            <?php echo e($value->value); ?>

                                                        <?php endif; ?>
                                                    </a>
                                                <?php elseif($detail->model == 'Video'): ?>
                                                    <?php /*<?php echo e(last(explode('/',$value['value']))); ?>*/ ?>
                                                    <embed width="120" height="100"
                                                           src="http://img.youtube.com/vi/<?php echo e(last(explode('/',$value['value']))); ?>/0.jpg"
                                                           class="video-env"
                                                           data-src="<?php echo e($value['value']); ?>?version=3&enablejsapi=1&playerapiid=AIzaSyAdwo9TTBY5YyhpNGtgRVZMqryZDzMewGE"/>
                                                <?php elseif($detail->model == 'Category' ): ?>
                                                    <?php if($counter==0): ?>
                                                        <div class="col-sm-12">
                                                            <div class="pull-left">

                                                                <?php echo $__env->make('contacts.show-category', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                                                            </div>
                                                        </div>
                                                    <?php endif; ?>
                                                <?php elseif(isset($detail->options) AND count($detail->options) !=0 ): ?>
                                                    <?php foreach($detail->options as $option): ?>
                                                        <?php /*<?php echo e(dd($value->id)); ?>*/ ?>
                                                        <?php if($option->id == $value['value'] ): ?>
                                                            <?php echo e($option->name); ?>

                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                <?php elseif($detail->is_translatable): ?>

                                                    <?php if($value->language_id == $selectedLanguage['id']): ?>
                                                        <?php echo e($value->value); ?>

                                                    <?php endif; ?>

                                                <?php else: ?>


                                                    <?php /* 36 => comments */ ?>
                                                    <?php if($value->contactdetail_id == '36'): ?>
                                                        <div class="col-sm-12" style="margin-top: 5px;">
                                                            <?php echo nl2br($value->value); ?>

                                                            <div style=" font-size: 10px;    position:absolute;   bottom:0; right:0;  ">
                                                                [<?php echo e(\Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$value->created_at)->format('d.m.Y H:i:s')); ?>

                                                                ]
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <hr>
                                                        </div>
                                                    <?php else: ?>

                                                        <?php echo e($value->value); ?>

                                                    <?php endif; ?>
                                                <?php endif; ?>
                                            <?php endforeach; ?>

                                        <?php else: ?>
                                            <?php if($detail->model == "Tag"): ?>
                                                <?php foreach( explode(',',trim($tagList[$selectedLanguage->id]) ) as $key => $tag): ?>
                                                    <?php if($tag): ?>
                                                        <div class="btn btn-info"><?php echo e($tag); ?></div>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            <?php elseif($detail->model == "Rating"): ?>

                                                <div class="row">
                                                    <div class="text-center">
                                                        <?php echo $__env->make('contacts.show-rating', ['eachRating'=>$contact, 'class'=>'col-sm-12e' ], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                                        <div class="btn btn-info pull-right"
                                                             id="show-hide-reviews-btn"><?php echo e(_('Show / hide reviews')); ?></div>
                                                    </div>
                                                </div>



                                                <div class="hidden" id="review-block">
                                                    <?php foreach($contact['rating'] as $eachRating): ?>
                                                        <div class="col-sm-12">

                                                            <blockquote class="blockquote blockquote-default">
                                                                <div>
                                                                    <div style="font-size: 10px"
                                                                         class="pull-right"><?php echo e($eachRating->created_at); ?></div>
                                                                    <div class="row">
                                                                        <p>
                                                                            <strong><?php echo e($eachRating->author_name); ?></strong>
                                                                            - <?php echo e($eachRating->email); ?></p>
                                                                    </div>
                                                                </div>
                                                                <p>
                                                                    <small><?php echo e($eachRating->review); ?> </small>
                                                                </p>
                                                                <div style="font-size: 10px">
                                                                    <div class="row">
                                                                        <?php echo $__env->make('contacts.show-rating', ['eachRating'=>$eachRating, 'class'=>'col-sm-3' ], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                                                    </div>
                                                                </div>
                                                            </blockquote>

                                                        </div>

                                                    <?php endforeach; ?>
                                                </div>
                                            <?php elseif($detail->model == "Marker"): ?>

                                                <div class="row">
                                                    <div class="text-center">
                                                        <?php echo $__env->make('contacts.index-map', ['contacts'=> [$contact], ], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                                                    </div>
                                                    <ul>
                                                        <?php foreach($contact['addresses'] as $address): ?>
                                                            <li>
                                                                <?php echo e($address->marker_address); ?><?php echo e($address->marker_address && $address->city->name ? ',': null); ?>

                                                                <?php echo e($address->city->name); ?><?php echo e($address->country->name ? ',': null); ?>

                                                                <?php echo e($address->country->name); ?><?php echo e($address->marker_zip ? ',': null); ?>

                                                                <?php echo e($address->marker_zip); ?>

                                                            </li>
                                                        <?php endforeach; ?>
                                                    </ul>
                                                </div>

                                            <?php endif; ?>
                                        <?php endif; ?>

                                        <?php if(Auth::check()): ?>
                                            <div class="row">
                                                <?php if($detail->name == 'comment'): ?>
                                                    <?php echo $__env->make('contacts.show-comments-form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>


                                </div>




                            <?php endforeach; ?>

                        </div>
                    </div>

                <?php endforeach; ?>
            </div>


        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('modal'); ?>

    <!-- Gallery Modal Image -->
    <div class="modal fade" id="gallery-image-modal">
        <div class="modal-dialog">
            <div class="modal-content1">

                <div class="modal-gallery-image1">
                    <img src="" id="gallery_modal_imnage_src" class="img-responsive"/>
                </div>
                <?php /*<div class="modal-body">*/ ?>
                <?php /*</div>*/ ?>
                <div class="modal-footer modal-gallery-top-controls">
                    <button type="button" class="btn btn-xs btn-white" data-dismiss="modal">close</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Video Modal Image -->
    <div class="modal fade" id="video-modal">
        <div class="modal-dialog">
            <div class="modal-content1">

                <div class="modal-gallery-image1">
                    <?php /*<embed width="500" height="350" id="video_modal_src" class="img-responsive1"/>*/ ?>
                    <iframe width="560" height="560" id="video_modal_src" class="img-responsive1"
                            frameborder="0"
                            allowfullscreen="true"></iframe>
                </div>
                <?php /*<div class="modal-body">*/ ?>
                <?php /*</div>*/ ?>
                <div class="modal-footer modal-gallery-top-controls">
                    <button type="button" class="btn btn-xs btn-white close-btn" data-dismiss="modal">close
                    </button>
                </div>
            </div>
        </div>
    </div>


    <script>
        $(document).ready(function ($) {
            // Gallery Modal
            $('.gallery-env').on('click', function (ev) {
                ev.preventDefault();
                var pictureUrlSmall = $(this).attr('src');
                var pictureUrlMedium = pictureUrlSmall.replace('/smallCustom/', '/original/');
                $('#gallery_modal_imnage_src').attr('src', pictureUrlMedium);
                $("#gallery-image-modal").modal('show');
            });

            // Video Modal
            $('.video-env').on('click', function (ev) {
                ev.preventDefault();
                var videoUrl = $(this).attr('data-src');

                $('#video_modal_src').attr('src', videoUrl);
                $("#video-modal").modal('show');
            });

            $('#video-modal').on('click', '.close-btn', function () {
                $('#video_modal_src')[0].contentWindow.postMessage('{"event":"command","func":"' + 'stopVideo' + '","args":""}', '*');
            });

            $('#show-hide-reviews-btn').click(function () {
                $('#review-block').toggleClass('hidden');
            });


            $('#show-hide-related-objects-btn').click(function () {
                $('#related-objects-div').toggleClass('hidden');
            });


        });


    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>