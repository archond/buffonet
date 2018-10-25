@extends('layouts.app')

@section('content')

<div class="panel panel-default" style="background-color:lightgoldenrodyellow">
	<div class="panel-heading">
		<h3 class="panel-title">{{_('Create new Stage')}}</h3>
	</div>
	<div class="panel-body">


		{!! Form::model('stage', ['class'=>'form-horizontal', 'method'=>'post','files'=>'true','route' => ['stages.store']]) !!}
		@include('stages.form')

		<div class="form-group">
			{!! Form::label('', '', ['class'=>'col-sm-2 control-label']) !!}
			<div class="col-sm-10">
				{!! Form::submit('Save', ['class'=>'btn'])!!}
			</div>
			{!! Form::close() !!}
		</div>
	</div>
</div>
@stop