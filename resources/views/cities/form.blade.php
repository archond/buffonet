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


@if(isset($country->id))
    {{Form::hidden('countryId', $country->id)}}
@endif

<div class="form-group">
    {!! Form::label('country_id', _('Select country'), ['class'=>'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        {!! Form::select('country_id', $countries->pluck('name', 'id'), isset($country->id) ? $country->id : null , ['class'=>'form-control', 'placeholder'=>null] ) !!}
    </div>
</div>


<div class="form-group">
    {!! Form::label('name', _('City name'), ['class'=>'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        {!! Form::text('name', isset($city->name) ? $city['name'] : null , ['class'=>'form-control', 'placeholder'=>_('Input City name') ] ) !!}
    </div>
</div>



