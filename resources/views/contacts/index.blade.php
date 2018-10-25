@extends('layouts.app')

@section('content')


    <div class="row">


        {{-- new search--}}
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading">

                    <strong>{{_('Search')}}</strong>

                    {{Form::open(['method'=>'get', 'route'=>'contacts.index', 'id'=>'search-form'])}}

                    <input type="hidden" name="page" value="{{Request::has('page') ? Request::get('page') : ''}}">

                    <div class="panel-body">

                        <div class="col-md-12  load2levels111">
                            <div class="form-group input-group" style="width:100%">


                                @include('contacts.search.category')
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="input-group col-md-12 col-sm-12 col-xs-12">
                                <input type="text" name="search_value_what" class="form-control0  input-for-tags"
                                       placeholder="{{ _('What.. press enter to accept typed string') }}"
                                       value="" id="search_value_what"
                                       style="width:100%">
                            </div>


                            <div class="row1 form-group">
                                <div class="col-md-12 input-group text-center">

                                    @foreach($searchDetails as $key => $detail)

                                        <label class="checkbox-inline">
                                            {{Form::checkbox('search_detail['.$detail['id'].']', $detail['id'], isset($inputs['search_detail'][ $detail['id'] ]) ? 1 :0  )}}
                                            {{isset($detail->translation->name) ? $detail->translation->name :  $detail['name']}}
                                        </label>
                                    @endforeach

                                </div>
                            </div>

                        </div>
                        <div class="col-md-6">
                            <div class="input-group col-md-12 col-sm-12 col-xs-12">
                                <input type="text" name="search_value_where" class="form-control"
                                       placeholder="{{ _('Kur…') }}"
                                       value="{{ isset($inputs['search_value_where']) ?  $inputs['search_value_where'] : null }}">
                            </div>
                        </div>
                        <div class="col-md-12">

                            <input type="submit" value="{{_('Search')}}" class="pull-right btn btn-success"></input>


                            <div class="pull-right">{{_('Show on Map?')}} {{Form::checkbox('show-map', 1, isset($inputs['show-map'] ) ? $inputs['show-map'] : false, ['style'=>'margin:5px;'] )}}</div>

                        </div>
                    </div>

                    @if( isset($inputs['show-map'] ) && $inputs['show-map']  )
                        <div class="col-sm-12">
                            @include('contacts.index-map')
                        </div>
                    @endif

                    <input type="hidden" name="search_value_what2" id="search_value_what2" class="search_value_what2"
                           value="{{Request::has('search_value_what2') ? Request::get('search_value_what2')  : null }}">
                    <input type="hidden" name="search_value_type" id="search_value_type"
                           value="{{Request::has('search_value_type') ? Request::get('search_value_type')  : null }}">
                    <input type="hidden" name="contacts_checked" id="contacts_checked"
                           value="{{Request::has('contacts_checked') ? Request::get('contacts_checked')  : null }}">

                    {{Form::close()}}
                </div>
            </div>
        </div>
        {{-- search finish--}}


        <div class="panel panel-default">

            {{Form::open(['method'=>'get', 'route'=>'contacts.create-request', 'target'=>'_blank'])}}

            <input type="hidden" name="contacts_checked" id="contacts_checked_2"
                   value="{{Request::has('contacts_checked') ? Request::get('contacts_checked')  : null }}">
            <div class="panel-heading">
                <!-- Table Model 2 -->

                {{--{{ dd( $selectedLanguage )  }}--}}
                <strong><?= _('Contacts') ?></strong>

                <a type="button" class="btn btn-success btn-xs " href="{{ route('contacts.create') }}">
                    <i class="fa fa-plus"></i>
                </a>

                {{--<div class="panel-options" style="margin-left:5px">--}}
                {{--Form::submit('Create Request', ['class'=>'btn btn-blue', 'name'=>'createRequest'])--}}
                {{--</div>--}}

                <div class="panel-options" style="margin-left:5px">
                    {{Form::submit(_('Ask for Rating'), ['class'=>'btn btn-blue', 'name'=>'createAskForRating'])}}
                </div>

                <div class="panel-options" style="margin-left:5px">
                    {{Form::submit(_('Request contact info'), ['class'=>'btn btn-blue', 'name'=>'createRequestForContactInfo'])}}
                </div>

                <div class="panel-options" style="margin-left:5px">
                    {{Form::submit(_('Get Emails'), ['class'=>'btn btn-blue', 'name'=>'getEmails'])}}
                </div>

                <div class="panel-options" style="margin-left:5px">
                    {{Form::submit(_('Get Phones'), ['class'=>'btn btn-blue', 'name'=>'getPhones'])}}
                </div>


            </div>
            <div class="panel-body">


                @if(isset($requestedDataString) )
                    <div id="requestDataStringDiv" style="margin:10px;">
                        <div style="position: relative;  background-color:white; padding:10px; margin:15px; border: solid 1px"
                             class="com-md-12">
                            <div class="text-left"
                                 style="position:absolute; top:-13px;left: 5px; background-color:white;padding: 1px; width:180px; float:left; border: solid 1px">{{_('Data')}}
                                :</i></div>
                            <div id="requestDataStringDiv-removeIcon" style="position:absolute; top:5px;right: 5px;"><i
                                        class="fa fa-remove"></i></div>
                            {{$requestedDataString}}
                        </div>
                    </div>
                @endif

                {{--{{dd($data)}}--}}

                {{--{{dd($data['search_value_what']) }}--}}

                @if( isset($data) && (
                (isset($data['search_value_what']) && $data['search_value_what'] && $data['search_value_what'] != '[]') ||
                (isset($data['search_value_where']) && $data['search_value_where'] && $data['search_value_where'] != '' ) ||
                (isset($data['search_value_what2']) && $data['search_value_what2'] && $data['search_value_what2'] != '') ||
                (isset($data['search_value_type']) && $data['search_value_type'] && $data['search_value_type']!='') ||
                (isset($data['search_value_category']) && $data['search_value_category']) ||
                (isset($data['show-map']) && $data['show-map'])
                )
                )

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
                        @if( isset($data['search_value_what']) && $data['search_value_what'])
                            {{_('What')}}: {{$data['search_value_what']}}<br>
                        @endif
                        @if(isset($data['search_value_where']) && $data['search_value_where'])
                            {{_('Where')}}: {{$data['search_value_where']}}<br>
                        @endif
                        @if(isset($data['search_value_what2']) && $data['search_value_what2'])
                            {{_('Tags:')}}: {{$data['search_value_what2']}}<br>
                        @endif
                        @if(isset($data['search_value_type']) && $data['search_value_type'])
                            {{_('Type')}}:
                            {{ \App\ContactDetailOption::with('translation')->find($data['search_value_type'])->translation->name }}
                            <br>
                        @endif
                        @if(isset($data['search_value_category']) && $data['search_value_category'])
                            {{_('Category')}}:
                            @if(is_array($data['search_value_category']) )
                                @foreach( $data['search_value_category'] as $categoryId)
                                    {{App\Category::with('translation')->find($categoryId)->translation->name}}
                                @endforeach
                            @endif

                            <br>
                        @endif

                        @if(isset($data['show-map']) && $data['show-map'])
                            {{_('Show on map')}}: {{$data['show-map']}}<br>
                        @endif


                    </div>
            </div>
            @endif



            {{--filtri--}}
            <div class="form-group row col-sm-12" style="margin: 10px 0">
                <div class="col-sm-4">
                    <div class="row">
                        {{--<div class="input-group col-sm-12 row">--}}

                        {{--{{link_to_route('contacts.index', _('Clear filters'), ['clear_rating_filters'=>'true'], ['class'=>'btn btn-gray'] )}}--}}

                        <div class="input-group col-sm-12">
                                        <span class="input-group-addon">
                                            {{link_to_route('contacts.index', _('Clear filters'), ['clear_index_filters'=>'true'], ['class'=>''] )}}
                                        </span>
                            {{Form::select('search_for_type', $contactTypes->options->pluck('name', 'id'), Request::has('search_value_type') ? Request::get('search_value_type') : null, ['class'=>"form-control search_for_type", 'placeholder'=>_('filter by type') ] )}}
                            <span class="input-group-addon submit_btn_addition_search_form" style="cursor:pointer">
                                    <i class="fa-filter"></i>
                                </span>
                        </div>
                        {{--</div>--}}
                    </div>

                </div>
                <div class="col-sm-8">
                    <div class="row">
                        <div class="input-group col-sm-12 ">
                            {{Form::text('search_value_for_what2', null,
                            ['class'=>'form-control0 search_value_for_what2 input-for-tags', 'placeholder'=>_('search by tags...'), 'id'=>'search_value_for_what2'])}}
                            {{--<span class="input-group-addon submit_btn_addition_search_form" style="cursor:pointer">--}}
                            {{--<i class="fa-filter"></i>--}}
                            {{--</span>--}}
                        </div>
                    </div>
                </div>
            </div>
            {{--filtri finish--}}

            <div class="pull-right">{{_('Show on Map?')}} {{Form::checkbox('show-map', 1, isset($inputs['show-map'] ) ? $inputs['show-map'] : false, ['style'=>'margin:5px;'] )}}</div>
            <div class="pull-left">{{_('Total contacts')}}: {{$contacts->total()}}</div>
            <div class="text-center">{{ $contacts->appends(Request::all())->links() }}</div>


            <div class="table-responsive" data-pattern="priority-columns" data-focus-btn-icon="fa-asterisk"
                 data-sticky-table-header="true" data-add-display-all-btn="true"
                 data-add-focus-btn="true">


                <table cellspacing="0" class="table table-small-font table-bordered table-striped">
                    <thead>
                    <tr>
                        <th><input type="checkbox" id="check-all-checkboxes"></th>
                        <th data-priority="3">
                            {{_('Action')}}

                        </th>
                        <th data-priority="1">
                            <?
                            $request = $data;
                            $class = isset($request['sort']) && $request['sort'] == 'date_a' ? 'fa-sort-desc' : (isset($request['sort']) && $request['sort'] == 'date_d' ? 'fa-sort-asc' : 'fa-sort');
                            $request['sort'] = isset($request['sort']) && $request['sort'] == 'date_a' ? 'date_d' : 'date_a';
                            ?>
                            <a href="{{route('contacts.index', $request )}}">
                                <div>{{_('Date')}} <span class="fa {{$class}} pull-right"></span></div>
                            </a>
                        </th>

                        @if(Auth::user()->is_developer == 1)
                            <th data-priority="1">{{_('ID')}}</th>
                        @endif
                        <th data-priority="1">
                            {{ _('Type')}}
                        </th>

                        <th data-priority="1">
                            {{ _('picture')}}
                        </th>
                        <th data-priority="1">
                            <?
                            $request = $data;
                            $class = isset($request['sort']) && $request['sort'] == 'title_a' ? 'fa-sort-desc' : (isset($request['sort']) && $request['sort'] == 'title_d' ? 'fa-sort-asc' : 'fa-sort');
                            $request['sort'] = isset($request['sort']) && $request['sort'] == 'title_a' ? 'title_d' : 'title_a';
                            ?>
                            <a href="{{route('contacts.index', $request )}}">
                                <div>{{_('Title')}} <span class="fa {{$class}} pull-right"></span></div>
                            </a>
                        </th>


                        <th data-priority="1">
                            <?
                            $request = $data;
                            $class = isset($request['sort']) && $request['sort'] == 'rating_a' ? 'fa-sort-desc' : (isset($request['sort']) && $request['sort'] == 'rating_d' ? 'fa-sort-asc' : 'fa-sort');
                            $request['sort'] = isset($request['sort']) && $request['sort'] == 'rating_a' ? 'rating_d' : 'rating_a';
                            ?>

                            <a href="{{route('contacts.index', $request )}}">
                                <div>{{_('Ratings')}} <span class="fa {{$class}} pull-right"></span></div>
                            </a>
                        </th>


                    </tr>
                    </thead>
                    <tbody>

                    {{--<form method="get" action="{{url(route('contacts.index'))}}" enctype="application/x-www-form-urlencoded">--}}


                    @foreach($contacts as $contact)
                        {{--{{dd($contact)}}--}}
                        <tr>

                            <td>

                                {{ Form::checkbox('contacts[]', $contact['id'], in_array($contact['id'], explode(',',Request::get('contacts_checked'))) ? 1 : (in_array($contact['id'], Request::get('contacts') ? Request::get('contacts') : [] ) ? 1 : 0 )   , ['class'=>'contact-checkbox']) }}

                            </td>
                            <td>
                                <div class="">
                                    <div style="margin-bottom: 2px;">
                                        <a class="btn btn-info btn-xs"
                                           href="{{ route('contacts.show', $contact['id']) }}"><i
                                                    class="fa fa-info fa-fw"></i></a>
                                    </div>
                                    <div style="margin-bottom: 2px;">

                                        <a class="btn btn-success btn-xs"
                                           href="{{ route('contacts.edit', $contact['id']) }}"><i
                                                    class="fa fa-edit fa-fw"></i></a>
                                    </div>
                                    <div style="margin-bottom: 2px;">

                                        <a class="btn btn-success btn-xs"
                                           href="{{ route('rating.admin-do-rating', $contact['id']) }}"><i
                                                    class="fa fa-star fa-fw"></i></a>
                                    </div>
                                    <div style="margin-bottom: 2px;">

                                        <div class="btn btn-red btn-xs btn-delete"
                                             data-url="{{ route('contact.delete', ['id'=>Crypt::encrypt($contact['id'])  ] )}}">
                                            <i
                                                    class="fa fa-remove fa-fw"></i></div>
                                    </div>

                                </div>
                            </td>
                            <td>
                                {{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$contact['created_at'])->timeZone('Europe/Riga')->format('d.m.Y') }}
                                <br>
                                {{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$contact['created_at'])->timeZone('Europe/Riga')->format('H:i:s') }}
                            </td>

                            @if(Auth::user()->is_developer == 1)
                                <td>
                                    {{$contact['id']}}
                                </td>
                            @endif

                            <td>
                                {{ isset($contact['type'][0]) ? $contact['type'][0] : _('Type is not set') }}
                            </td>

                            <td style="vertical-align: middle; text-align: center;">
                                @if(isset($contact['photos'][0]))
                                    <img src="{{route('imagecache', ['smallCustom', $contact['photos'][0]] )}}">
                                @else
                                    -
                                @endif
                            </td>

                            <td>
                                @if(isset($contact['title']))
                                    @if(is_array($contact['title'] ) )
                                        {{ implode(",", $contact['title'] ) }}
                                    @else
                                        {{ $contact['title'] }}
                                    @endif
                                @endif
                                <hr>
                                @if(isset($contact['addresses']))
                                    @foreach($contact['addresses'] as $address)
                                        {{$address['marker_address'] ? $address['marker_address'].',' : ''}}
                                        {{$address['city']['name'] ? $address['city']['name'].',' : ''}}
                                        {{$address['country']['name'] ? $address['country']['name'] : ''}}
                                        {{ $address['marker_zip'] && $address['marker_zip'] != '' ? ',' : '' }}
                                        {{$address['marker_zip'] && $address['marker_zip'] != '' ? $address['marker_zip'] : ''}}
                                        ;<br>

                                    @endforeach
                                @endif

                            </td>

                            <td>

                                @if(isset($contact['phone']))

                                    @if(is_array($contact['phone'] ) )
                                        {{ implode(",", $contact['phone'] ) }},
                                    @else
                                        {{ $contact['phone'] }},
                                    @endif
                                @endif
                                {{$contact['mainobejects']['phone'] }}
                                <br>
                                @if(isset($contact['e-mail']))
                                    @if(is_array($contact['e-mail'] ) )
                                        {{ implode(",", $contact['e-mail'] ) }}
                                    @else
                                        {{ $contact['e-mail'] }}
                                    @endif
                                @endif
                                <hr style="margin-top: 5px !important;margin-bottom: 5px !important;">

                                @if(isset($contact['parent_categories']) )
                                    <? $iterator = 0;?>
                                    @foreach($contact['parent_categories'] as $parent)
                                        @if( isset($parent->parent->translation->name) && ++$iterator <=2)
                                            {{$parent->parent->translation->name }} <span
                                                    class="fa fa-angle-double-right"></span>
                                            {{$parent->translation->name}}
                                            <br>
                                        @elseif($iterator == 3)
                                            ...
                                        @endif
                                    @endforeach

                                @else
                                    {{_('Categories is not set')}}
                                @endif


                                <hr style="margin-top: 5px !important;margin-bottom: 5px !important;">

                                [{{ number_format((float)$contact['rating_overall'], 2, '.', ',') }}]


                                @foreach([1,2,3,4,5] as $star)
                                    @if($star <= $contact['rating_overall'])
                                        <span class="fa fa-star"></span>
                                    @else
                                        <span class="fa fa-star-o"></span>
                                    @endif
                                @endforeach
                                ({{$contact['rating_count']}})
                            </td>


                        </tr>

                    @endforeach



                    {{Form::close()}}

                    </tbody>
                </table>


                <!-- </div> -->
            </div>
            <div class="text-center">{{ $contacts->links() }}</div>

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
                        tagsItems: {!! isset($inputs['search_value_what']) && $inputs['search_value_what'] ?  $inputs['search_value_what'] : '[]' !!},
                        ajax: {
                            url: '{{ route('ajax.get-contacts-emais-phones-tags') }}',
                            dataType: 'json',
//                        cacheResults : true
                        }
                    }).bind('isTagAllowed', function (e, data) {
                        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;

                        var formData = $(e.target).textext()[0].tags()._formData,
                                list = eval(formData);
                        // duplicate checking
                        if (formData.length && list.indexOf(data.tag) >= 0) {
                            var message = [data.tag, '{{_('is already listed.')}}'].join(' ');
                            alert(message);

                            data.result = false;
                        }
                    }
            );

            $('#search_value_for_what2')
                    .textext({
                        plugins: 'autocomplete filter tags ajax',
                        tagsItems: {!! isset($inputs['search_value_what2']) && $inputs['search_value_what2'] ?  $inputs['search_value_what2'] : '[]' !!},
                        ajax: {
                            url: '{{ route('ajax.get-contacts-tags') }}',
                            dataType: 'json',
                            loadingMessage: '{{_('Loading....')}}',
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
                $('#action-delete-url').attr('href', $(this).attr('data-url'));
                $('#modal-delete').modal('show');
            });


            $('form').on('click', 'input[name=show-map]', function () {
                if ($(this).is(':checked')) {
                    $('input[name=show-map]').prop('checked', true);
                } else {
                    $('input[name=show-map]').prop('checked', false);
                    ;
                }
            });


        });


    </script>


    @include('contacts.form-js')

@endsection

@section('modal')
    <!-- Modal 1 (Basic)-->
    <div class="modal fade" id="modal-delete">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">{{_('Confirmation')}}</h4>
                </div>

                <div class="modal-body">
                    {{_('Are you sure to delete this item')}}?
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">{{_('Cancel')}}</button>
                    <a href="#" id="action-delete-url">
                        <div class="btn btn-red">{{_('Delete')}}</div>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection