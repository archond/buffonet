@extends('layouts.app')

@section('content')

<?php

?>
<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
      <div class="white-box content">
          <div class="white-box-heading border-bottom clearfix">
							<span class="dark bold text-uppercase">{!! __('Translations') !!}</span>
					</div>
					<div class="flash-message">
					  @foreach (['danger'] as $msg)
					    @if(Session::has('alert-' . $msg))
					    <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }}</p>
					    @endif
					  @endforeach
					</div>
					{!! Form::open(['url' => '/' . LaravelGettext::getLocaleLanguage() . '/trans', 'method' => 'post']) !!}
					<div class="filters-map">
						<div class="border-bottom">
		 						<label for="numtd">{!! "Find: English" !!}</label>
		 						{!! Form::text('trans',isset($params->trans) ? $params->trans : Request::input('trans'),['class' => 'form-control']) !!}
 						</div>
				</div>
				<div style="margin-top:10px; margin-bottom:10px;">
				{!! Form::submit("Find", [
					'class' => 'btn btn-primary',
				]) !!}
				</div>
					{!!Form::close() !!}
		</div>
		</div>

@endsection
