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
	{!! Form::label('slug', 'slug', ['class'=>'col-sm-2 control-label']) !!}
	<div class="col-sm-10">
		{!! Form::text('slug', isset($category) ? $category['slug'] : null , ['class'=>'form-control', 'placeholder'=>'Input slug'] ) !!}
	</div>
</div>

@foreach($languages as $language)  
<div class="form-group">
	{!! Form::label('name['.$language->id.']', strtoupper($language->abbr), ['class'=>'col-sm-2 control-label']) !!}
	<div class="col-sm-10">
		{!! Form::text('name['.$language->id.']', isset($translation[$language->id]) ? $translation[$language->id] : null , ['class'=>'form-control', 'placeholder'=>'Input Category name in '.strtoupper($language->abbr).' language'] ) !!}
	</div>
</div>
@endforeach




	{{-- $selectedParentcategories --}}
	
	@if(!isset($categoryArrayTree) ) 

		@include('categories.includes.select-path', ['categoryArrayTree'=>$categoryArrayTree])
	@else

		 @include('categories.includes.select-path', ['categoryArrayTree'=>$categoryArrayTree])
	@endif



