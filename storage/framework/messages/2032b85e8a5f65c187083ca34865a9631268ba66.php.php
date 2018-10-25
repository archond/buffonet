<?php $__env->startSection('content'); ?>


    <div class="row">


        <?php /* new search*/ ?>
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading">

                    <strong><?php echo e(_('Search')); ?></strong>

                    <?php echo e(Form::open(['method'=>'get', 'route'=>'contacts.index', 'id'=>'search-form'])); ?>



                    <div class="panel-body">

                        <div class="col-md-12  load2levels111">
                            <div class="form-group input-group" style="width:100%">


                                <?php echo $__env->make('contacts.search.category', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="input-group col-md-12 col-sm-12 col-xs-12">
                                <input type="text" name="search_value_what" class="form-control0"
                                       placeholder="<?php echo e(_('What.. press enter to accept typed string')); ?>"
                                       value="" id="search_value_what"
                                       style="width:100%">
                            </div>


                            <div class="row1 form-group">
                                <div class="col-md-12 input-group text-center">

                                    <?php foreach($searchDetails as $key => $detail): ?>

                                        <label class="checkbox-inline">
                                            <?php echo e(Form::checkbox('search_detail['.$detail['id'].']', $detail['id'], isset($inputs['search_detail'][ $detail['id'] ]) ? 1 :0  )); ?>

                                            <?php echo e(isset($detail->translation->name) ? $detail->translation->name :  $detail['name']); ?>

                                        </label>
                                    <?php endforeach; ?>

                                </div>
                            </div>

                        </div>
                        <div class="col-md-6">
                            <div class="input-group col-md-12 col-sm-12 col-xs-12">
                                <input type="text" name="search_value_where" class="form-control"
                                       placeholder="<?php echo e(_('Kur…')); ?>"
                                       value="<?php echo e(isset($inputs['search_value_where']) ?  $inputs['search_value_where'] : null); ?>">
                            </div>
                        </div>
                        <div class="col-md-12">

                            <input type="submit" value="<?php echo e(_('Search')); ?>" class="pull-right btn btn-success"></input>


                            <div class="pull-right"><?php echo e(_('Show on Map?')); ?> <?php echo e(Form::checkbox('show-map', 1, isset($inputs['show-map'] ) ? $inputs['show-map'] : false, ['style'=>'margin:5px;'] )); ?></div>

                        </div>
                    </div>

                    <?php if( isset($inputs['show-map'] ) && $inputs['show-map']  ): ?>
                        <div class="col-sm-12">
                            <?php echo $__env->make('contacts.index-map', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                        </div>
                    <?php endif; ?>

                    <input type="hidden" name="search_value_what2" id="search_value_what2" class="search_value_what2"
                           value="<?php echo e(Request::has('search_value_what2') ? Request::get('search_value_what2')  : null); ?>">
                    <input type="hidden" name="search_value_type" id="search_value_type"
                           value="<?php echo e(Request::has('search_value_type') ? Request::get('search_value_type')  : null); ?>">
                    <input type="hidden" name="contacts_checked" id="contacts_checked"
                           value="<?php echo e(Request::has('contacts_checked') ? Request::get('contacts_checked')  : null); ?>">

                    <?php echo e(Form::close()); ?>

                </div>
            </div>
        </div>
        <?php /* search finish*/ ?>


        <div class="panel panel-default">

            <?php echo e(Form::open(['method'=>'get', 'route'=>'contacts.create-request', 'target'=>'_blank'])); ?>


            <input type="hidden" name="contacts_checked" id="contacts_checked_2"
                   value="<?php echo e(Request::has('contacts_checked') ? Request::get('contacts_checked')  : null); ?>">
            <div class="panel-heading">
                <!-- Table Model 2 -->

                <?php /*<?php echo e(dd( $selectedLanguage )); ?>*/ ?>
                <strong><?= _('Contacts') ?></strong>

                <a type="button" class="btn btn-success btn-xs " href="<?php echo e(route('contacts.create')); ?>">
                    <i class="fa fa-plus"></i>
                </a>

                <?php /*<div class="panel-options" style="margin-left:5px">*/ ?>
                <?php /*Form::submit('Create Request', ['class'=>'btn btn-blue', 'name'=>'createRequest'])*/ ?>
                <?php /*</div>*/ ?>

                <div class="panel-options" style="margin-left:5px">
                    <?php echo e(Form::submit(_('Ask for Rating'), ['class'=>'btn btn-blue', 'name'=>'createAskForRating'])); ?>

                </div>

                <div class="panel-options" style="margin-left:5px">
                    <?php echo e(Form::submit(_('Request contact info'), ['class'=>'btn btn-blue', 'name'=>'createRequestForContactInfo'])); ?>

                </div>

                <div class="panel-options" style="margin-left:5px">
                    <?php echo e(Form::submit(_('Get Emails'), ['class'=>'btn btn-blue', 'name'=>'getEmails'])); ?>

                </div>

                <div class="panel-options" style="margin-left:5px">
                    <?php echo e(Form::submit(_('Get Phones'), ['class'=>'btn btn-blue', 'name'=>'getPhones'])); ?>

                </div>


            </div>
            <div class="panel-body">


                <?php if(isset($requestedDataString) ): ?>
                    <div id="requestDataStringDiv" style="margin:10px;">
                        <div style="position: relative;  background-color:white; padding:10px; margin:15px; border: solid 1px"
                             class="com-md-12">
                            <div class="text-left"
                                 style="position:absolute; top:-13px;left: 5px; background-color:white;padding: 1px; width:180px; float:left; border: solid 1px"><?php echo e(_('Data')); ?>

                                :</i></div>
                            <div id="requestDataStringDiv-removeIcon" style="position:absolute; top:5px;right: 5px;"><i
                                        class="fa fa-remove"></i></div>
                            <?php echo e($requestedDataString); ?>

                        </div>
                    </div>
                <?php endif; ?>

                <?php /*<?php echo e(dd($data)); ?>*/ ?>

                <?php /*<?php echo e(dd($data['search_value_what'])); ?>*/ ?>

                <?php if( isset($data) && (
                (isset($data['search_value_what']) && $data['search_value_what'] && $data['search_value_what'] != '[]') ||
                (isset($data['search_value_where']) && $data['search_value_where'] && $data['search_value_where'] != '' ) ||
                (isset($data['search_value_what2']) && $data['search_value_what2'] && $data['search_value_what2'] != '') ||
                (isset($data['search_value_type']) && $data['search_value_type'] && $data['search_value_type']!='') ||
                (isset($data['search_value_category']) && $data['search_value_category']) ||
                (isset($data['show-map']) && $data['show-map'])
                )
                ): ?>

                    <div id="requestDataDiv" style="margin:10px;">

                        <div style="position: relative;  background-color:white; padding:10px; margin:15px;border: solid 1px"
                        "
                        class="com-md-12">
                        <div class="text-left"
                             style="position:absolute; top:-12px;left: 5px; background-color:white;padding: 1px; width:180px; border: solid 1px"><?=_('Filter data');?>
                            :
                        </div>
                        <div id="requestDataDiv-removeIcon" style="position:absolute; top:3px;right: 5px;"><i
                                    class="fa fa-remove"></i></div>
                        <?php if( isset($data['search_value_what']) && $data['search_value_what']): ?>
                            <?php echo e(_('What')); ?>: <?php echo e($data['search_value_what']); ?><br>
                        <?php endif; ?>
                        <?php if(isset($data['search_value_where']) && $data['search_value_where']): ?>
                            <?php echo e(_('Where')); ?>: <?php echo e($data['search_value_where']); ?><br>
                        <?php endif; ?>
                        <?php if(isset($data['search_value_what2']) && $data['search_value_what2']): ?>
                            <?php echo e(_('Tags:')); ?>: <?php echo e($data['search_value_what2']); ?><br>
                        <?php endif; ?>
                        <?php if(isset($data['search_value_type']) && $data['search_value_type']): ?>
                            <?php echo e(_('Type')); ?>:
                            <?php echo e(\App\ContactDetailOption::with('translation')->find($data['search_value_type'])->translation->name); ?>

                            <br>
                        <?php endif; ?>
                        <?php if(isset($data['search_value_category']) && $data['search_value_category']): ?>
                            <?php echo e(_('Category')); ?>:
                            <?php if(is_array($data['search_value_category']) ): ?>
                                <?php foreach( $data['search_value_category'] as $categoryId): ?>
                                    <?php echo e(App\Category::with('translation')->find($categoryId)->translation->name); ?>

                                <?php endforeach; ?>
                            <?php endif; ?>

                            <br>
                        <?php endif; ?>

                        <?php if(isset($data['show-map']) && $data['show-map']): ?>
                            <?php echo e(_('Show on map')); ?>: <?php echo e($data['show-map']); ?><br>
                        <?php endif; ?>


                    </div>
            </div>
            <?php endif; ?>


            <div class="table-responsive" data-pattern="priority-columns" data-focus-btn-icon="fa-asterisk"
                 data-sticky-table-header="true" data-add-display-all-btn="true"
                 data-add-focus-btn="true">

                <div class="form-group row col-sm-12" style="margin: 10px 0">
                    <div class="col-sm-4">
                        <div class="row">
                            <?php /*<div class="input-group col-sm-12 row">*/ ?>

                            <?php /*<?php echo e(link_to_route('contacts.index', _('Clear filters'), ['clear_rating_filters'=>'true'], ['class'=>'btn btn-gray'] )); ?>*/ ?>

                            <div class="input-group col-sm-12">
                                        <span class="input-group-addon">
                                            <?php echo e(link_to_route('contacts.index', _('Clear filters'), ['clear_index_filters'=>'true'], ['class'=>''] )); ?>

                                        </span>
                                <?php echo e(Form::select('search_for_type', $contactTypes->options->pluck('name', 'id'), Request::has('search_value_type') ? Request::get('search_value_type') : null, ['class'=>"form-control search_for_type", 'placeholder'=>_('filter by type') ] )); ?>

                                <span class="input-group-addon submit_btn_addition_search_form" style="cursor:pointer">
                                    <i class="fa-filter"></i>
                                </span>
                            </div>
                            <?php /*</div>*/ ?>
                        </div>

                    </div>
                    <div class="col-sm-8">
                        <div class="row">
                            <div class="input-group col-sm-12">
                                <?php echo e(Form::text('search_value_for_what2', null,
                                ['class'=>'form-control0 search_value_for_what2', 'placeholder'=>_('search by tags...'), 'id'=>'search_value_for_what2'])); ?>

                                <?php /*<span class="input-group-addon submit_btn_addition_search_form" style="cursor:pointer">*/ ?>
                                <?php /*<i class="fa-filter"></i>*/ ?>
                                <?php /*</span>*/ ?>
                            </div>
                        </div>
                    </div>
                </div>

                <table cellspacing="0" class="table table-small-font table-bordered table-striped">
                    <thead>
                    <tr>
                        <th><input type="checkbox" id="check-all-checkboxes"></th>
                        <th data-priority="3">
                            <?php echo e(_('Action')); ?>


                        </th>
                        <th data-priority="1">
                            <?
                            //                                $request = Request::all();
                            //                                dd($data);

                            $request = $data;
                            //                                    dd($request);


                            $class = isset($request['sort']) && $request['sort'] == 'date_a' ? 'fa-sort-desc' : (isset($request['sort']) && $request['sort'] == 'date_d' ? 'fa-sort-asc' : 'fa-sort');
                            $request['sort'] = isset($request['sort']) && $request['sort'] == 'date_a' ? 'date_d' : 'date_a';
                            ?>
                            <a href="<?php echo e(route('contacts.index', $request )); ?>">
                                <div><?php echo e(_('Date')); ?> <span class="fa <?php echo e($class); ?> pull-right"></span></div>
                            </a>
                        </th>

                        <?php if(Auth::user()->is_developer == 1): ?>
                            <th data-priority="1"><?php echo e(_('ID')); ?></th>
                        <?php endif; ?>
                        <th data-priority="1">
                            <?php echo e(_('Type')); ?>

                        </th>

                        <th data-priority="1">
                            <?php echo e(_('picture')); ?>

                        </th>
                        <th data-priority="1">
                            <?
                            $request = $data;
                            $class = isset($request['sort']) && $request['sort'] == 'title_a' ? 'fa-sort-desc' : (isset($request['sort']) && $request['sort'] == 'title_d' ? 'fa-sort-asc' : 'fa-sort');
                            $request['sort'] = isset($request['sort']) && $request['sort'] == 'title_a' ? 'title_d' : 'title_a';
                            ?>
                            <a href="<?php echo e(route('contacts.index', $request )); ?>">
                                <div><?php echo e(_('Title')); ?> <span class="fa <?php echo e($class); ?> pull-right"></span></div>
                            </a>
                        </th>


                        <th data-priority="1">
                            <?
                            $request = $data;
                            $class = isset($request['sort']) && $request['sort'] == 'rating_a' ? 'fa-sort-desc' : (isset($request['sort']) && $request['sort'] == 'rating_d' ? 'fa-sort-asc' : 'fa-sort');
                            $request['sort'] = isset($request['sort']) && $request['sort'] == 'rating_a' ? 'rating_d' : 'rating_a';
                            ?>

                            <a href="<?php echo e(route('contacts.index', $request )); ?>">
                                <div><?php echo e(_('Ratings')); ?> <span class="fa <?php echo e($class); ?> pull-right"></span></div>
                            </a>
                        </th>


                    </tr>
                    </thead>
                    <tbody>

                    <?php /*<form method="get" action="<?php echo e(url(route('contacts.index'))); ?>" enctype="application/x-www-form-urlencoded">*/ ?>


                    <?php foreach($contacts as $contact): ?>
                        <?php /*<?php echo e(dd($contact)); ?>*/ ?>
                        <tr>

                            <td>

                                <?php echo e(Form::checkbox('contacts[]', $contact['id'], in_array($contact['id'], explode(',',Request::get('contacts_checked'))) ? 1 : (in_array($contact['id'], Request::get('contacts') ? Request::get('contacts') : [] ) ? 1 : 0 )   , ['class'=>'contact-checkbox'])); ?>


                            </td>
                            <td>
                                <div class="">
                                    <div style="margin-bottom: 2px;">
                                        <a class="btn btn-info btn-xs"
                                           href="<?php echo e(route('contacts.show', $contact['id'])); ?>"><i
                                                    class="fa fa-info fa-fw"></i></a>
                                    </div>
                                    <div style="margin-bottom: 2px;">

                                        <a class="btn btn-success btn-xs"
                                           href="<?php echo e(route('contacts.edit', $contact['id'])); ?>"><i
                                                    class="fa fa-edit fa-fw"></i></a>
                                    </div>
                                    <div style="margin-bottom: 2px;">

                                        <a class="btn btn-success btn-xs"
                                           href="<?php echo e(route('rating.admin-do-rating', $contact['id'])); ?>"><i
                                                    class="fa fa-star fa-fw"></i></a>
                                    </div>
                                    <div style="margin-bottom: 2px;">

                                        <div class="btn btn-red btn-xs btn-delete"
                                           data-url="<?php echo e(route('contact.delete', ['id'=>Crypt::encrypt($contact['id'])  ] )); ?>"><i
                                                    class="fa fa-remove fa-fw"></i></div>
                                    </div>

                                </div>
                            </td>
                            <td>
                                <?php echo e(\Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$contact['created_at'])->format('d.m.Y')); ?>

                                <br>
                                <?php echo e(\Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$contact['created_at'])->format('H:i:s')); ?>

                            </td>

                            <?php if(Auth::user()->is_developer == 1): ?>
                                <td>
                                    <?php echo e($contact['id']); ?>

                                </td>
                            <?php endif; ?>

                            <td>
                                <?php echo e(isset($contact['type'][0]) ? $contact['type'][0] : _('Type is not set')); ?>

                            </td>

                            <td style="vertical-align: middle; text-align: center;">
                                <?php if(isset($contact['photos'][0])): ?>
                                    <img src="<?php echo e(route('imagecache', ['smallCustom', $contact['photos'][0]] )); ?>">
                                <?php else: ?>
                                    -
                                <?php endif; ?>
                            </td>

                            <td>
                                <?php if(isset($contact['title'])): ?>
                                    <?php if(is_array($contact['title'] ) ): ?>
                                        <?php echo e(implode(",", $contact['title'] )); ?>

                                    <?php else: ?>
                                        <?php echo e($contact['title']); ?>

                                    <?php endif; ?>
                                <?php endif; ?>
                                <hr>
                                <?php if(isset($contact['addresses'])): ?>
                                    <?php foreach($contact['addresses'] as $address): ?>
                                        <?php echo e($address['marker_address'] ? $address['marker_address'].',' : ''); ?>

                                        <?php echo e($address['city']['name'] ? $address['city']['name'].',' : ''); ?>

                                        <?php echo e($address['marker_zip'] ? $address['marker_zip'].',' : ''); ?>

                                        <?php echo e($address['country']['name'] ? $address['country']['name'] : ''); ?>;<br>

                                    <?php endforeach; ?>
                                <?php endif; ?>

                            </td>

                            <td>

                                <?php if(isset($contact['phone'])): ?>

                                    <?php if(is_array($contact['phone'] ) ): ?>
                                        <?php echo e(implode(",", $contact['phone'] )); ?>,
                                    <?php else: ?>
                                        <?php echo e($contact['phone']); ?>,
                                    <?php endif; ?>
                                <?php endif; ?>
                                <?php echo e($contact['mainobejects']['phone']); ?>

                                <br>
                                <?php if(isset($contact['e-mail'])): ?>
                                    <?php if(is_array($contact['e-mail'] ) ): ?>
                                        <?php echo e(implode(",", $contact['e-mail'] )); ?>

                                    <?php else: ?>
                                        <?php echo e($contact['e-mail']); ?>

                                    <?php endif; ?>
                                <?php endif; ?>
                                <hr style="margin-top: 5px !important;margin-bottom: 5px !important;">

                                <?php if(isset($contact['parent_categories']) ): ?>

                                    <?php foreach($contact['parent_categories'] as $parent): ?>
                                        <?php if( isset($parent->parent->translation->name)): ?>
                                            <?php echo e($parent->parent->translation->name); ?> <span
                                                    class="fa fa-angle-double-right"></span>
                                            <?php echo e($parent->translation->name); ?>

                                            <br>
                                        <?php endif; ?>
                                    <?php endforeach; ?>

                                <?php else: ?>
                                    <?php echo e(_('Categpries is not set')); ?>

                                <?php endif; ?>


                                <hr style="margin-top: 5px !important;margin-bottom: 5px !important;">
                                [<?php echo e(ROUND($contact['rating_overall'],2)); ?>]
                                <?php foreach([1,2,3,4,5] as $star): ?>
                                    <?php if($star <= $contact['rating_overall']): ?>
                                        <span class="fa fa-star"></span>
                                    <?php else: ?>
                                        <span class="fa fa-star-o"></span>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                                (<?php echo e($contact['rating_count']); ?>)
                            </td>


                        </tr>

                    <?php endforeach; ?>



                    <?php echo e(Form::close()); ?>


                    </tbody>
                </table>


                <!-- </div> -->
            </div>
            <div class="text-center"><?php echo e($contacts->links()); ?></div>

        </div>
    </div>
    </div>



    <script type="text/javascript">
        $(document).ready(function () {
            $('.panel1').on('click', function () {
                $(this).closest('.panel-heading').find('.panel-body').toggleClass('hide');
            });

            $('form').on('click', 'button', function () { // disable button elements to submit form!//
                $(this).attr('type', 'button');
            });


            $('body').on('change', '.search_value_for_what2', function () {
//                $('#search_value_what2').val($(this).val());
                $('#search_value_what2').val($(this).next('input[type="hidden"]').val());
                console.log('search_value_what2 chaged');
            });

            $('body').on('change', '.search_for_type', function () {
                $('#search_value_type').val($(this).val());

            });

            $('body').on('click', '.submit_btn_addition_search_form', function () {
//                $('#search-form').submit();
                document.forms["search-form"].submit();
            });


            $('#search_value_what')
                    .textext({
                        plugins: 'autocomplete filter tags ajax',
                        tagsItems: <?php echo isset($inputs['search_value_what']) && $inputs['search_value_what'] ?  $inputs['search_value_what'] : '[]'; ?>,
                        ajax: {
                            url: '<?php echo e(route('ajax.get-contacts-emais-phones-tags')); ?>',
                            dataType: 'json',
//                        cacheResults : true
                        }
                    }).bind('isTagAllowed', function (e, data) {
                        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                    }
            );

            $('#search_value_for_what2')
                    .textext({
                        plugins: 'autocomplete filter tags ajax',
                        tagsItems: <?php echo isset($inputs['search_value_what2']) && $inputs['search_value_what2'] ?  $inputs['search_value_what2'] : '[]'; ?>,
                        ajax: {
                            url: '<?php echo e(route('ajax.get-contacts-tags')); ?>',
                            dataType: 'json',
                            loadingMessage: '<?php echo e(_('Loading....')); ?>',
                        }
                    })


            var textarea = $('#search_value_for_what2'),
                    output = $('#search_value_what2');

            textarea.bind('setFormData', function (e, data, isEmpty) {
                var textext = $(e.target).textext()[0];
                output.val(textext.hiddenInput().val());

//                console.log('ss', textext.hiddenInput().val());
            });

            $('body').on('click', '#check-all-checkboxes', function () {
                if ($(this).is(':checked')) {
                    $('.contact-checkbox').prop('checked', true);
                } else {
                    console.log('chk', 0);
                    $('.contact-checkbox').prop('checked', false);
                }
            });


            $('body').on('click', '.contact-checkbox', function () {
                        var checkedContactsIdsArray = ',' + $('#contacts_checked').val();

                        if ($(this).is(':checked')) {
                            checkedContactsIdsArray = checkedContactsIdsArray.replace(',,', ',');
                            checkedContactsIdsArray = checkedContactsIdsArray + $(this).val() + ',';

                            $('#contacts_checked').val(checkedContactsIdsArray);
                        } else {

                            checkedContactsIdsArray = checkedContactsIdsArray.replace(',,', ',');
                            checkedContactsIdsArray = checkedContactsIdsArray.replace(',' + $(this).val() + ',', ',');
                            $('#contacts_checked').val(checkedContactsIdsArray);
                        }
                    }
            );

            $('body').on('click', '#check-all-checkboxes', function () {
                if ($(this).is(':checked')) {
                    var sList = ",";
                    $('.contact-checkbox').each(function () {
                        var sThisVal = (this.checked ? $(this).val() : "");
                        sList += sThisVal + ',';
                    });
                    $('#contacts_checked').val(sList);
                } else {
                    $('#contacts_checked').val('');
                }
            });

            $('#requestDataStringDiv-removeIcon').click(function () {
                $('#requestDataStringDiv').remove();
            });

            $('#requestDataDiv-removeIcon').click(function () {
                $('#requestDataDiv').remove();
            });


            $(document).ready(function () {
                $("form").submit(function (event) {

                    $('#contacts_checked_2').val($('#contacts_checked').val());


//                    if(whatever) {
//                        event.preventDefault();
//                    }
                });
            });

            $('form').on('click', '.btn-delete', function () {
                $('#action-delete-url').attr('href', $(this).attr('data-url') );
                $('#modal-delete').modal('show');
            });


        });


    </script>


    <?php echo $__env->make('contacts.form-js', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('modal'); ?>
    <!-- Modal 1 (Basic)-->
    <div class="modal fade" id="modal-delete">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><?php echo e(_('Confirmation')); ?></h4>
                </div>

                <div class="modal-body">
                    <?php echo e(_('Are you sure to delete this item')); ?>?
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal"><?php echo e(_('Cancel')); ?></button>
                    <a href="#" id="action-delete-url"><div class="btn btn-red"><?php echo e(_('Delete')); ?></div></a>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>