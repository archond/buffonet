{{-- izvadam esošos failus--}}


{{--@if($detail['is_collectable'] == 1 )--}}
{{--{{dd($isCollectableCounter)}}--}}

@if($isCollectableCounter == 0 )

{!! Form::file('contact_detail['.$detail['id'].'][val][]',['class'=>'form-control file-input-styled', 'placeholder'=>'Input '.$detail->name, 'style'=> Route::currentRouteName() == 'contacts.create' ? 'background-color: #ABC9FF;' : ''] ) !!}

@endif

<div>
{{--<img src="{{  route('imagecache', ['template'=>'small', 'filename'=>$value['value'] ])  }}">--}}

</div>
