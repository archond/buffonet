@if($detail['is_collectable'] == 1 )
@if($isCollectableCounter == 0 ) 
<p>
	@foreach($detail['options']->pluck('name', 'id') as $key=> $option)
	<label class="radio-inline">

		{!! Form::radio('contact_detail['.$detail['id'].'][val][]',  null, ($key == $value['value']) ? true : false ,  ['class'=>''] ) !!}
		{!! $option !!}
	</label>
	@endforeach
</p>
@endif
@else
{!! Form::hidden('contact_detail['.$detail['id'].'][values_id][]', isset($value['id']) ? $value['id'] : null) !!} 
<p>
	@foreach($detail['options']->pluck('name', 'id') as $key=> $option)
	<label class="radio-inline">

		{!! Form::radio('contact_detail['.$detail['id'].'][val][]',  $key, ($key == $value['value']) ? true : false ,  ['class'=>''] ) !!}
		{!! $option !!}
	</label>
	@endforeach
</p>
@endif




