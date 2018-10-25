@extends('layouts.app')

@section('content')

<div class="panel panel-default" style="background-color:#E5E5E5">
	<div class="panel-heading">
		<h3 class="panel-title">Edit Contact Detail</h3>
	</div>
	<div class="panel-body">


		{!! Form::model($contactDetail, ['class'=>'form-horizontal', 'method'=>'put','files'=>'true','route' => ['contactdetails.update', $contactDetail->id ] ]) !!}
		@include('contactdetails.form')

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