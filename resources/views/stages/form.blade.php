<!-- <pre> -->
<?php
	// var_dump( $validator->errors() );
?>
<!-- </pre> -->
@if (isset($errors) && count($errors) > 0)
<div class="alert alert-danger">
	<ul>
		@foreach ($errors->all() as $error)  
		<li>{{ $error }}</li>
		@endforeach
	</ul>
</div>
@endif



<div class="form-group">
	{!! Form::label('name', 'Stage', ['class'=>'col-sm-2 control-label']) !!}
	<div class="col-sm-10">
		{!! Form::text('name', null , ['class'=>'form-control', 'placeholder'=>'Input stage name'] ) !!} 
	</div>
</div>

{{-- Translations --}}
<div class="form-group" >
	{!! Form::label('translation', 'Translations', ['class'=>'col-sm-2 control-label']) !!}
	<div class="col-sm-10">
		<div class="row">

			<div class="col-md-12" >

				<ul class="nav nav-tabs nav-tabs-justified" >
					@foreach($languages as $language)
						<li class="{{$language->id == 1 ? 'active' : null}}">
							<a href="#{{$language->id}}" data-toggle="tab">
								<span class="visible-xs"><i class="fa-home"></i></span>
								<span class="hidden-xs">{{strtoupper($language->abbr)}}</span>
							</a>
						</li>
					@endforeach
				</ul>


				<div class="tab-content">
					@foreach($languages as $language)
						<div class="tab-pane {{$language->id == 1 ? 'active' : null}}" id="{{$language->id}}">

							<div>
								{{--{{dd($contactDetail->translations)}}--}}
								{{Form::text('translations['.$language->id.']',


                                isset($stage) && isset( $stage->translations->filter(function($trans) use($language){

                                return isset($trans->language_id) && $trans['language_id'] == $language->id;
                                } )->first()->name )
                                ?

                                $stage->translations->filter(function($trans) use($language){

                                return isset($trans->language_id) && $trans['language_id'] == $language->id;
                                } )->first()->name


                                : null
                                , ['class'=>'form-control', 'placeholder'=>'Input translation in '.strtoupper($language->abbr).' language!'] ) }}

							</div>

						</div>
					@endforeach


				</div>
			</div>
		</div>
	</div>
</div>
{{----}}

<div class="form-group">
	{!! Form::label('is_contact_data_stage', 'Is contact data stage?', ['class'=>'col-sm-2 control-label']) !!}
	<div class="col-sm-10">
		{!! Form::hidden('is_contact_data_stage', 0) !!}
		{!! Form::checkbox('is_contact_data_stage', 1, isset($contactDetail['is_contact_data_stage']) ? $contactDetail['is_contact_data_stage'] : false , ['class'=>''] ) !!}
	</div>
</div>

<div class="form-group">
	{!! Form::label('name', 'Contact Details', ['class'=>'col-sm-2 control-label']) !!}
	<div class="col-sm-10">
		@if(isset($stage['contactDetails']))
		<ul class="form-group">
			@foreach($stage['contactDetails'] as $key=> $detal)
			<li class="">{!!$detal->name !!}</li> 
			@endforeach
		</ul>
		@else
			{{_('Stage do not have any contact detail')}}
		@endif
	</div>
</div>

