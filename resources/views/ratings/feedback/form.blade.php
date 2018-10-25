@if (isset($errors) && count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>n
@endif


@if( Request::route()->getName() != 'rating.admin-do-rating')
    {{--<div class="form-group">--}}
        {{--{!! Form::label('language_id', _('Language'), ['class'=>'col-sm-2 control-label']) !!}--}}
        {{--<div class="col-sm-10">--}}
            {{--{!! Form::select('language_id', $languages->pluck('name', 'id'),null , ['class'=>'form-control', 'placeholder'=> _('select language'), $readonly] ) !!}--}}
        {{--</div>--}}
    {{--</div>--}}

    <div class="form-group">
        {!! Form::label('author_name', _('Author'), ['class'=>'col-sm-2 control-label']) !!}
        <div class="col-sm-10">
            {!! Form::text('author_name',null , ['class'=>'form-control', 'placeholder'=> _('Author name'), $readonly] ) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('author_phone', _('Phone'), ['class'=>'col-sm-2 control-label']) !!}
        <div class="col-sm-10">
            {!! Form::text('author_phone',null , ['class'=>'form-control', 'placeholder'=> _('Phone'), $readonly] ) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('author_is_legal', _('Type'), ['class'=>'col-sm-2 control-label']) !!}
        <div class="col-sm-10">
            {!! Form::select('author_is_legal', [0=>_('private person'), 1=>_('legal person') ], null , ['class'=>'form-control', $readonly=='readonly' ? 'disabled' : ''] ) !!}
        </div>
    </div>
@endif




<div class="form-group">
    {!! Form::label('review', _('Review'), ['class'=>'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        {!! Form::textarea('review', null , ['class'=>'form-control', 'placeholder'=>_('review text here'), $readonly] ) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('accurancy', _('Accurancy'), ['class'=>'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        @foreach([1,2,3,4,5] as $item)
            {!! Form::radio('accurancy', $item ,false, ['class'=>'form-controlqqqq', $readonly=='readonly' ? 'disabled' : '' ] ) !!}
        @endforeach
    </div>
</div>

<div class="form-group">
    {!! Form::label('quality', _('Quality'), ['class'=>'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        @foreach([1,2,3,4,5] as $item)
            {!! Form::radio('quality', $item ,false, ['class'=>'form-controlqqqq', $readonly=='readonly' ? 'disabled' : ''] ) !!}
        @endforeach
    </div>
</div>


<div class="form-group">
    {!! Form::label('communication', _('Communication'), ['class'=>'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        @foreach([1,2,3,4,5] as $item)
            {!! Form::radio('communication', $item ,false, ['class'=>'form-controlqqqq',$readonly=='readonly' ? 'disabled' : ''] ) !!}
        @endforeach
    </div>
</div>




