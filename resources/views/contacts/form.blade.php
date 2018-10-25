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
@if (isset($errors) && count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


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
        <h3 class="panel-title">{{_('Base info') }}</h3>
    </div>
    <div class="panel-body">

        @if(isset( $mainObjects))

            <div class="form-group">
                {!! Form::label('mainobject_id', 'Main object', ['class'=>'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                    {!! Form::select('mainobject_id', $mainObjects->pluck('phone', 'id'), Request::has('main-object-id') ? Request::get('main-object-id') : null , ['class'=>'form-control mainobject', 'placeholder'=>'Select phone', 'id'=>'mainobject_id'] ) !!}


                </div>
            </div>


        @endif


        <div class="form-group row">
            {!! Form::label('language_id', 'Language', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
                {!! Form::select('language_id', $languages->pluck('name', 'id'), isset($languageId) ? $languageId : (isset($contact->language_id) ? $contact->language_id : null ) , ['class'=>'form-control', 'id'=>'language_id'] ) !!}
            </div>
        </div>
    </div>
</div>

{{--@if(isset($categoryArrayTree))--}}
{{--<div>--}}
{{--@include('categories.includes.select-path', ['categoryArrayTree'=>$categoryArrayTree])--}}
{{--</div>--}}
{{--@endif--}}




@foreach($stages as $stage)



    <div class="panel panel-default">
        <div class="panel-heading">
            <div><h3>{{isset($stage['translation']['name']) ? $stage['translation']['name'] :  $stage['name']}}</h3>
            </div>
        </div>
        <div class="panel-body">


            @foreach($stage->contactDetails as $k => $detail)


                <div class="form-group row" id={{ $detail->model == 'Category'  ?  "category-group-sc" : "" }} >

                    @if( ( !(Route::currentRouteName() == 'requests.admin-process-view' && $detail->model == 'Marker') ) && $detail->model != 'Tag' && $detail->model != 'Category'   )

                        {!! Form::label('name',
                         (isset($detail->translation) && isset($detail->translation->name))
                         ? $detail->translation->name
                         : (isset($detail['name']) ? $detail['name'] :'not set name'),
                         ['class'=> 'col-sm-2 control-label']) !!}
                    @else



                    @endif


                    <div class="{{ (Route::currentRouteName() == 'requests.admin-process-view' && ($detail->model == 'Marker' || $detail->model == 'Category') ) || $detail->model == 'Tag'  || $detail->model == 'Category'  ? 'col-sm-12' : 'col-sm-10'}}">


                        <?php $counter = 0; ?>
                        <?php $isCollectableCounter = 0;  ?>
                        <?php



                        if (count($detail->values) == 0) { // šis ir nepieciešams, kad contactam nav konkrētās detaļas vērtības, lai tukš lauks parādītos, pievienojam tukšu atribūtu
                            $detail->setAttribute('values', ['values' => '']);
                        }

                        ?>



                        @if($detail->name == 'phone' && $counter ==0)

                            {{--{{ var_dump($contact->mainObejects->phone) }}--}}
                            {{--{{ $contact->mainObejects->phone }}--}}
                            {{--{{ dd(isset($contact) ) }}--}}
                            {{--{{ dd( isset($contact->mainObejects->phone) ) }}--}}






                            {{--                            @if(isset($contact->mainObejects->phone) )--}}
                            @if(isset($contact) && $contact->mainObejects->phone )

                                <div class="input-group col-sm-12 col-xs-12">
                                    {{Form::text('aaa', $contact->mainObejects->phone, ['disabled', 'class'=>'form-control col-md-12'])}}

                                </div>
                            @elseif(Request::has('main-object-id'))

                                <?php $mainobj = \App\Mainobject::find(Request::get('main-object-id'));?>

                                @if(isset($mainobj->phone))
                                    <div class="input-group col-sm-12 col-xs-12">
                                        {{Form::text('aaa', $mainobj->phone, ['disabled', 'class'=>'form-control col-md-12'])}}
                                    </div>
                                    @endif

                            @endif

                        @endif


                        @if($detail->model == 'Category' && $counter ==0)
                            <div class="row category-btn-holder">
                                <div class="col-sm-12">
                                    <div class="">
                                        <div class="btn btn-gray add-category-button pull-right"><i class="fa-plus"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif


                        @if($detail->model == 'Marker' && $counter ==0)
                            <div class="row marker-btn-holder">
                                <div class="col-sm-12">
                                    <div class="">
                                        <div class="btn btn-gray add-marker-button pull-right"><i class="fa-plus"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <?$counter2 = 0;?>
                        @foreach($detail['values'] as $detailId => $value)
                            {{--{{var_dump($value)}}--}}

                            {{-- Categories --}}
                            @if($detail['model'] == 'Category' || (isset($detail->model ) && $detail->model == 'Category')  )
                                @if($counter2==0)
                                    @include('contacts.fields.category')
                                    {{--&nbsp;<div class="form-group-separator"></div>--}}
                                @endif

                                {{-- Markers --}}
                            @elseif($detail['model'] =='Marker' || (isset($detail->model) && $detail->model =='Marker')  )
                                @include('contacts.fields.marker')
                            @else

                                {{--var_dump((array)$value)--}}
                                <div class="{{$detail->model != 'Tag' ? 'input-group' : null}} ">

                                    @if($detail['is_collectable'] == 1  )

                                        @if($isCollectableCounter==0)
                                            {{-- _('This is collectable field, you are not able to see submitted info') --}}
                                        @endif

                                    @else
                                        {{-- hidden for all fiels --}}

                                    @endif

                                    @if($detail['is_translatable'] == 1)
                                        @foreach($languages as $language)
                                            @if(isset($value['language_id']) && $language->id == $value['language_id'])
                                                Language: ({{strtoupper ($language->abbr) }})
                                            @endif
                                        @endforeach
                                    @endif

                                    {{-- tags --}}
                                    @if($detail['model'] =='Tag' || (isset($detail->model) && $detail->model =='Tag')  )
                                        @include('contacts.fields.tags')

                                        {{-- ratings --}}
                                    @elseif($detail['model'] =='Rating' || (isset($detail->model) && $detail->model =='Rating')  )
                                        @if($ratingsCount++ ==0)
                                            {{--@include('contacts.fields.rating')--}}
                                        @endif

                                        {{-- markers--}}
                                        {{--@elseif($detail['model'] =='Marker' || (isset($detail->model) && $detail->model =='Marker')  )--}}
                                        {{--@include('contacts.fields.marker')--}}



                                        {{-- text --}}
                                    @elseif($detail['input_field']['name'] =='text' || (isset($detail->inputField['name'])  && $detail->inputField['name'] =='text') )
                                        {{--<pre>--}}
                                        {{-- @if($detail->id == 5 OR $detail->id == 4)<pre>{{var_dump($detail->values)}}</pre> @endif --}}

                                        {{--</pre>--}}
                                        @include('contacts.fields.text')



                                        {{-- textarea--}}
                                    @elseif($detail['input_field']['name'] =='textarea' || (isset($detail->inputField['name'])  && $detail->inputField['name'] =='textarea') )

                                        @include('contacts.fields.textarea')

                                        {{-- select--}}
                                    @elseif($detail['input_field']['name'] =='select' || (isset($detail->inputField['name'])  && $detail->inputField['name'] =='select') )
                                        @include('contacts.fields.select')

                                        {{-- checkbox--}}
                                    @elseif($detail['input_field']['name'] =='checkbox' ||(isset($detail->inputField['name'])  && $detail->inputField['name'] =='checkbox') )
                                        @include('contacts.fields.checkbox')

                                        {{-- radio--}}
                                    @elseif($detail['input_field']['name'] =='radio' || (isset($detail->inputField['name'])  && $detail->inputField['name'] =='radio') )
                                        @include('contacts.fields.radio')

                                        {{-- file--}}
                                    @elseif($detail['input_field']['name'] =='file' || (isset($detail->inputField['name'])  && $detail->inputField['name'] =='file') )

                                        @include('contacts.fields.file')

                                    @endif


                                    @if($detail['is_uniq_value'] !=1)


                                        @if( in_array($detail->inputField->name , ['text', 'file', 'textarea'] )  && !in_array($detail->model, ['Category']))

                                            @if($detail->inputField->name == 'textarea')

                                                @if($detail->name =='comment')

                                                    @if($counter++ == 0 )
                                                        <span class="input-group-addon add-button"><i
                                                                    class="fa-plus"></i></span>
                                                    @elseif($detail->inputField->name != 'fi1111le')
                                                        <span class="input-group-addon remove-button btn-danger"><i
                                                                    class="fa-remove"></i></span>
                                                    @endif

                                                @endif

                                            @else
                                                @if($counter++ == 0 )
                                                    <span class="input-group-addon add-button"><i
                                                                class="fa-plus"></i></span>
                                                @elseif($detail->inputField->name == 'file')

                                                @else
                                                    <span class="input-group-addon remove-button btn-danger"><i
                                                                class="fa-remove"></i></span>
                                                @endif
                                            @endif


                                        @endif
                                    @else
                                        <span class="input-group-addon "><i class="fa-square-o"></i></span>
                                    @endif

                                </div>
                                <? $isCollectableCounter++?>
                                {{--{{ var_dump($detail->inputField->name) }}--}}

                                @if($detail->inputField->name =='file')
                                    {{--                                        {{ var_dump($value['value']) }}--}}
                                    {{--{{ var_dump($value) }}--}}
                                    {{--{{ '!!!' }}--}}
                                @endif

                                @if($detail->inputField->name =='file' && isset($value['value']) && $value['value'] )


                                    <div class="image-container">
                                        <div class="pull-left" style="margin:2px; height: 120px">
                                            <img src="{{  route('imagecache', ['template'=>'small', 'filename'=>$value['value'] ])  }}"
                                                 class="media-image-list ">
                                            <div class="text-center">
                                                @if(strpos($value['value'], 'files-request') !== false )
                                                    <? $indexImage = str_random(4); ?>
                                                    <input type="hidden"
                                                           name="contact_detail[{{$detail['id']}}][values_id][{{$indexImage}}]"
                                                           value="" class="new-file-path11"/>
                                                    <input type="hidden"
                                                           name="contact_detail[{{$detail['id']}}][val][{{$indexImage}}]"
                                                           value="{{ $value['value'] }}" class="new-file-path"/>

                                                @endif
                                                {{ _('Delete?') }}

                                                {!! Form::checkbox('contact_detail['.$detail['id'].'][delete_values_id][]', isset($value['id']) ? $value['id'] : null, isset($value['id']) && isset($detail['delete_values_id']) && in_array($value['id'], $detail['delete_values_id']) ? true :false, ['class'=>'image-delete-chk'] ) !!}

                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endif

                            <? $counter2++ ?>
                        @endforeach

                    </div>
                </div>


            @endforeach
        </div>
    </div>
@endforeach

@if( !isset($doNotLoadJsTwice ) )

    @include('contacts.form-js')

@endif


