@extends('layouts.app')

@section('content')

<div class="panel panel-default" style="background-color:#E5E5E5">
	<div class="panel-heading">
		<h3 class="panel-title">{{_('Create new Contact detail')}}</h3>
	</div>
	<div class="panel-body">


		{!! Form::model('stage', ['class'=>'form-horizontal', 'method'=>'post','files'=>'true','route' => ['contactdetails.store']]) !!}
		@include('contactdetails.form') 

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