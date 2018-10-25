@extends('layouts.app')

@section('content')

<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">Create new / search existing Main object</h3>
	</div>
	<div class="panel-body">


		{!! Form::model('mainobject', ['class'=>'form-horizontal', 'method'=>'post','files'=>'true','route' => ['mainobjects.store']]) !!}
		@include('mainobjects.form')

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