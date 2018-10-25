@extends('layouts.app')

@section('content')

<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">Create new Contact</h3>
	</div>
	<div class="panel-body">


		{!! Form::model('contact', ['class'=>'form-horizontal', 'method'=>'post','files'=>'true','route' => ['contacts.store'], 'novalidate']) !!}
		@include('contacts.form')

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