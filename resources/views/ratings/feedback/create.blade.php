@extends('layouts.feedback')

@section('content')


    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">{{_('Rating Form')}}</h3>
        </div>
        <div class="panel-body">


            {!! Form::model($rating, ['class'=>'form-horizontal', 'method'=>'put','files'=>'true','route' => ['request-ask-for-rating-update', $encodedId] ]) !!}


            @include('ratings.feedback.form')

            @if($readonly !='readonly')
                <div class="form-group">
                    {!! Form::label('', '', ['class'=>'col-sm-2 control-label']) !!}
                    <div class="col-sm-10">
                        {!! Form::submit('Submit', ['class'=>'btn'])!!}
                    </div>

                </div>


            @endif




            @if($readonly =='readonly')
                @include('ratings.feedback.form2')
            @endif
            {!! Form::close() !!}
        </div>
    </div>
@stop