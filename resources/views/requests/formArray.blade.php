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
    {!! Form::label(_('Request for contact:'), null, ['class'=>'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        {{ Form::textarea('a', $title, ['class'=>'form-control', 'placeholder'=>_('Title is missing'), 'disabled']) }}
    </div>
</div>




@foreach($stages as $stage)
    @if($stage->is_contact_data_stage)
        <div class="form-group">
            {!! Form::label(_('stages'), $stage->name, ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
                {!! Form::checkbox('stages[]',  $stage->id, null , ['class'=>'form-control1', 'placeholder'=>'Input name'] ) !!}
            </div>
        </div>
    @endif
@endforeach

<div class="form-group">
    {!! Form::label(_('Message'), null, ['class'=>'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        {{Form::textarea('message_text', null,  ['class'=>'form-control', 'placeholder'=>_('Input message')])}}
    </div>
</div>
{{ Form::hidden('contacts', implode(',',$contacts )) }}
{{--{{ Form::hidden('data', json_encode($data)) }}--}}


