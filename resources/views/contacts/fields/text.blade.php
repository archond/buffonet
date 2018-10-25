@if($detail['is_collectable'] == 1 )
@if($isCollectableCounter == 0 )
{!! Form::text('contact_detail['.$detail['id'].'][val][]', null , ['class'=>'form-control', 'placeholder'=>'Input '.$detail['name']] ) !!}
@endif 

@else



{!! Form::hidden('contact_detail['.$detail['id'].'][values_id][]', isset($value['id']) ? $value['id'] : null) !!} 
{!! Form::hidden('contact_detail['.$detail['id'].'][language_id][]', isset($value['language_id']) ? $value['language_id'] : null ) !!}


@if($detail->name == 'e-mail')
{!! Form::email('contact_detail['.$detail['id'].'][val][]', isset($value['value']) ? $value['value'] : null , ['class'=>'form-control', 'placeholder'=>'Input '. $detail['name'], 'id'=>str_random() ] ) !!}



@elseif($detail->name == 'phone')

{!! Form::text('contact_detail['.$detail['id'].'][val][]', isset($value['value']) ? $value['value'] : null , ['class'=>'form-control phone-validation', 'placeholder'=>_('phone format minimum 8 digits only - 00000000'), 'id'=>str_random() ]) !!}



@else

{!! Form::text('contact_detail['.$detail['id'].'][val][]', isset($value['value']) ? $value['value'] : null , ['class'=>'form-control', 'placeholder'=>'Input '. $detail['name'] ] ) !!}
@endif

{{--{{dd($detail)}}--}}
@endif




