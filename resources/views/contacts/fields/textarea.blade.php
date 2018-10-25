@if($detail['is_collectable'] == 1 )
{{-- ja IR collectable --}}
	@if($isCollectableCounter == 0 ) 
	{{-- izvadam tikai vienu ciklu --}}
	{!! Form::textarea('contact_detail['.$detail['id'].'][val][]', null , ['class'=>'form-control', 'placeholder'=>'Input '.$detail['name'], 'size' => '1000x5'] ) !!}
	@endif


@else
	{{-- ja nav collectable --}}
		{!! Form::hidden('contact_detail['.$detail['id'].'][values_id][]', isset($value['id']) ? $value['id'] : null) !!} 
		{!! Form::hidden('contact_detail['.$detail['id'].'][language_id][]', isset($value['language_id']) ? $value['language_id'] : null ) !!} 
		{!! Form::textarea('contact_detail['.$detail['id'].'][val][]',  isset($value['value']) ? $value['value'] : null , ['class'=>'form-control', 'placeholder'=>'Input '.$detail['name'], 'size' => '1000x5'] ) !!}
@endif

