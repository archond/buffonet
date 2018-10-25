@extends('layouts.app')

@section('content')

<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">Edit Main object</h3>
	</div>
	<div class="panel-body">


		{!! Form::model($mainobject, ['class'=>'form-horizontal', 'method'=>'put','files'=>'true','route' => ['mainobjects.update', $mainobject->id ], 'novalidate' ]) !!}
		@include('mainobjects.form')

		<div class="form-group">
			{!! Form::label('', '', ['class'=>'col-sm-2 control-label']) !!}
			<div class="col-sm-10">
				{!! Form::submit('Update', ['class'=>'btn'])!!}
			</div>
			{!! Form::close() !!}
		</div>
	</div>
</div>
@stop