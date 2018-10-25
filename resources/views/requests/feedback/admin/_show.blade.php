@extends('layouts.app')

@section('content')

<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">{{_('Compare receved data wityh existing')}}</h3>
	</div>
	<div class="panel-body">


		{!! Form::model('contact', ['class'=>'form-horizontal', 'method'=>'post','files'=>'true','route' => ['requests.store']]) !!}
		
		@include('requests.feedback.admin.item')
		<div class="form-group">
			{!! Form::label('', '', ['class'=>'col-sm-2 control-label']) !!}
			<div class="col-sm-10">
				{!! Form::submit('Save received data', ['class'=>'btn'])!!}
			</div>
			{!! Form::close() !!}
		</div>
	</div>
</div>
@stop