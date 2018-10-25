@extends('layouts.feedback')

@section('content')
	

<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">Update contacts Contact</h3>
	</div>
	<div class="panel-body">


		{!! Form::open(['class'=>'form-horizontal', 'method'=>'put','files'=>'true','route' => ['request-form.feedback-update', $encodedId], 'novalidate' ]) !!}
		{{-- 
			@include('requests.feedback.form') 
		--}}
		@include('contacts.form')

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