
@if($detail['is_collectable'] == 1 )
@if($isCollectableCounter == 0 ) 
{!! Form::select('contact_detail['.$detail['id'].'][val][]', $detail['options']->lists('name', 'id'),  null, ['class'=>'form-control'] ) !!}
@endif 
@else

{!! Form::hidden('contact_detail['.$detail['id'].'][values_id][]', isset($value['id']) ? $value['id'] : null) !!} 
{!! Form::select('contact_detail['.$detail['id'].'][val][]', $detail['options']->lists('name', 'id'),  isset($value['value']) ? $value['value'] : null, ['class'=>'form-control'] ) !!}
@endif

