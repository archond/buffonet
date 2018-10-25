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



<div class="form-group">
    {!! Form::label('name', 'Name', ['class'=>'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        {!! Form::text('name', null , ['class'=>'form-control', 'placeholder'=>'Input contact detail name'] ) !!}
    </div>
</div>

{{-- Translations --}}
<div class="form-group">
    {!! Form::label('translation', 'Translations', ['class'=>'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        <div class="row">

            <div class="col-md-12">

                <ul class="nav nav-tabs nav-tabs-justified">
                    @foreach($languages as $language)
                        <li class="{{$language->id == 1 ? 'active' : null}}">
                            <a href="#{{$language->id}}" data-toggle="tab">
                                <span class="visible-xs"><i class="fa-home"></i></span>
                                <span class="hidden-xs">{{strtoupper($language->abbr)}}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>


                <div class="tab-content">
                    @foreach($languages as $language)
                        <div class="tab-pane {{$language->id == 1 ? 'active' : null}}" id="{{$language->id}}">

                            <div>
                                {{--{{dd($contactDetail->translations)}}--}}
                                {{Form::text('translations['.$language->id.']',


                                isset($contactDetail) && isset( $contactDetail->translations->filter(function($trans) use($language){

                                return isset($trans->language_id) && $trans['language_id'] == $language->id;
                                } )->first()->name )
                                ?

                                $contactDetail->translations->filter(function($trans) use($language){

                                return isset($trans->language_id) && $trans['language_id'] == $language->id;
                                } )->first()->name


                                : null
                                , ['class'=>'form-control', 'placeholder'=>'Input translation in '.strtoupper($language->abbr).' language!'] ) }}

                            </div>

                        </div>
                    @endforeach


                </div>
            </div>
        </div>
    </div>
</div>
{{----}}

<div class="form-group {{Auth::user()->is_developer !=1 ? 'hidden' : null}}">
    {!! Form::label('stage_id', 'Stage', ['class'=>'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        {!! Form::select('stage_id', $stages->pluck('name', 'id'),null , ['class'=>'form-control' , Auth::user()->is_developer !=1 ? 'disabled' : ''] ) !!}
    </div>
</div>

<div class="form-group {{Auth::user()->is_developer !=1 ? 'hidden' : null}}">
    {!! Form::label('input_field_id', 'Input Field', ['class'=>'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        {!! Form::select('input_field_id', $inputFields->pluck('name', 'id'),null , ['class'=>'form-control', Auth::user()->is_developer !=1 ? 'disabled' : ''] ) !!}
    </div>
</div>

<div class="form-group {{Auth::user()->is_developer !=1 ? 'hidden' : null}}">
    {!! Form::label('model', 'Model', ['class'=>'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        {!! Form::text('model', null , ['class'=>'form-control', Auth::user()->is_developer !=1 ? 'disabled' : ''] ) !!}
    </div>
</div>

<div class="form-group {{Auth::user()->is_developer !=1 ? 'hidden' : null}}">
    {!! Form::label('is_translatable', 'Translatable?', ['class'=>'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        {!! Form::hidden('is_translatable', 0) !!}
        {!! Form::checkbox('is_translatable', 1, isset($contactDetail['is_translatable']) ? $contactDetail['is_translatable'] : false , ['class'=> ''] ) !!}

    </div>
</div>

<div class="form-group {{Auth::user()->is_developer !=1 ? 'hidden' : null}}">
    {!! Form::label('is_collectable', 'Collectable?', ['class'=>'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        {!! Form::hidden('is_collectable', 0) !!}
        {!! Form::checkbox('is_collectable', 1, isset($contactDetail['is_collectable']) ? $contactDetail['is_collectable'] : false , ['class'=> ''] ) !!}
    </div>
</div>

<div class="form-group {{Auth::user()->is_developer !=1 ? 'hidden' : null}}">
    {!! Form::label('is_uniq_value', 'Uniq?', ['class'=>'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        {!! Form::hidden('is_uniq_value', 0) !!}
        {!! Form::checkbox('is_uniq_value', 1, isset($contactDetail['is_uniq_value']) ? $contactDetail['is_uniq_value'] : false , ['class'=> ''] ) !!}
    </div>
</div>

<div class="form-group {{Auth::user()->is_developer !=1 ? 'hidden' : null}}">
    {!! Form::label('is_searchable', 'Searchable?', ['class'=>'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        {!! Form::hidden('is_searchable', 0) !!}
        {!! Form::checkbox('is_searchable', 1, isset($contactDetail['is_searchable']) ? $contactDetail['is_searchable'] : false , ['class'=>''] ) !!}
    </div>
</div>


<hr>

@if(isset($contactDetail['options']))
    @foreach($contactDetail['options'] as $option)

        <div class="form-group">
            {!! Form::label('optionname['.$option["id"].']', 'Options', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-9">
                {!! Form::text('optionname['.$option["id"].']', $option['name'] , ['class'=>'form-control', 'placeholder'=>'Input option name'] ) !!}


                {{--te--}}
                <div class="col-md-12">

                    <ul class="nav nav-tabs nav-tabs-justified">
                        <? $randomString = str_random(4) ?>
                        @foreach($languages as $language)
                            <li class="{{$language->id == 1 ? 'active' : null}}">
                                <a href="#{{$randomString}}_{{$language->id}}" data-toggle="tab">
                                    <span class="visible-xs"><i class="fa-home"></i></span>
                                    <span class="hidden-xs">{{strtoupper($language->abbr)}}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>


                    <div class="tab-content">
                        @foreach($languages as $language)
                            <div class="tab-pane {{$language->id == 1 ? 'active' : null}}" id="{{$randomString}}_{{$language->id}}">

                                <div>
                                    {{Form::text('optionTranslations['.$option['id'].']['.$language->id.']',

                                    isset($option) && isset( $option->translations->filter(function($trans) use($language){

                                    return isset($trans->language_id) && $trans['language_id'] == $language->id;
                                    } )->first()->name )
                                    ?

                                    $option->translations->filter(function($trans) use($language){

                                    return isset($trans->language_id) && $trans['language_id'] == $language->id;
                                    } )->first()->name

                                    : null
                                    , ['class'=>'form-control', 'placeholder'=>'Input option translation in '.strtoupper($language->abbr).' language!'] ) }}

                                </div>

                            </div>
                        @endforeach


                    </div>
                </div>
                {{----}}
            </div>
            <div class="col-sm-1">
                <div class="col-md-1 col-sm-1 col-xs-1" style="cursor:pointer;"><i class="fa fa-remove removeButton"></i></div>
            </div>
        </div>

    @endforeach
@endif
<div id="placeForDynamicOptions"></div>
<button id="addOption" type="button" class="btn btn-info fa fa-plus pull-right"></button>


{{-- default empty ->start--}}
<div id="default-div" class="form-group hidden">
    {!! Form::label('optionname', 'Options', ['class'=>'col-sm-2 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::text('optionname[yyyy]', '' , ['class'=>'form-control option_index', 'placeholder'=>'Input option name'] ) !!}
        <div class="col-md-12">

            <ul class="nav nav-tabs nav-tabs-justified">
                @foreach($languages as $language)
                    <li class="{{$language->id == 1 ? 'active' : null}}">
                        <a href="#xxxx_{{$language->id}}" data-toggle="tab" class="class_{{$language->id}}">
                            <span class="visible-xs"><i class="fa-home"></i></span>
                            <span class="hidden-xs">{{strtoupper($language->abbr)}}</span>
                        </a>
                    </li>
                @endforeach
            </ul>
            <div class="tab-content">
                @foreach($languages as $language)
                    <div class="tab-pane {{$language->id == 1 ? 'active' : null}}" id="xxxx_{{$language->id}}">
                        <div>
                            {{Form::text('optionTranslations[yyyy]['.$language->id.']',''

                            , ['class'=>'form-control option_translation_index', 'placeholder'=>'Input option translation in '.strtoupper($language->abbr).' language!'] ) }}

                        </div>

                    </div>
                @endforeach


            </div>
        </div>
        <div class="col-sm-1">
            <div class="col-md-1 col-sm-1 col-xs-1" style="cursor:pointer;"><i class="fa fa-remove removeButton"></i></div>
        </div>
    </div>
</div>
{{--default empty ->finish--}}

<script type="text/javascript">

    $('body').on('click', '.removeButton', function () {
        $(this).closest('.form-group').remove();
    });

    $('body').on('click', '#addOption', function () {

        var randomString = (new Date % 9e6).toString(36);
        var newDiv = $('#default-div').clone();
        newDiv.removeClass('hidden');
        newDiv.removeAttr('id');
        newDiv.find('.option_index').attr('name', "optionname["+randomString+"]");

        <? $iterator = 0;?>
        @foreach($languages as $language)

        newDiv.find('#xxxx_{{$language->id}}').attr('id', randomString + "_{{$language->id}}");
        newDiv.find('.class_{{$language->id}}').attr('href', '#' + randomString + "_{{$language->id}}");
        newDiv.find('.option_translation_index:eq({{$iterator}})').attr('name', "optionTranslations["+randomString+"][{{$language->id}}]");
        <? $iterator++;?>
       @endforeach




       $(newDiv).insertBefore($('#placeForDynamicOptions'));

    });


    $("form").submit(function (e) {
        e.preventDefault();
        $('#default-div').remove();
        $("form").unbind('submit').submit();

    });
</script>