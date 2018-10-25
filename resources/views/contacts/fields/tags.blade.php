
{{-- Tags automaticali are translatable --}}


@foreach($languages as $language)
<? 
$index = str_random(5);
$string1 = '[translated]['.$index.'][]';
$string2 = '[translated]['.$index.'][language_id]';  


?>
{{--<div class="" style="width:100%">--}}
	{{--<label for="{{'contact_detail['.$detail['id'].']'.$string1, $tagList[$language->id]}}">({{strtoupper($language->abbr)}})</label>--}}

	{{--{!! Form::text('contact_detail['.$detail['id'].']'.$string1, $tagList[$language->id] , ['class'=>'form-control tagsinput', 'placeholder'=>'Input '.$detail['name']] ) !!}--}}

	{{--{!! Form::hidden('contact_detail['.$detail['id'].']'.$string2, $language->id) !!} --}}
{{--</div>--}}
@endforeach



{{--}}
@else
{!! Form::textarea('contact_detail['.$detail['id'].'][]',  isset($value['value']) ? $value['value'] : null , ['class'=>'form-control', 'placeholder'=>'Input '.$detail['name'], 'size' => '1000x5'] ) !!}
@endif
--}}
{{------------------------------------------------------------------------------------------------}}
<script type="text/javascript">
	$(document).ready(function() {
		$(document).ready(function() {
			$(".tagsinput1").select2({
				tags: true,
				tokenSeparators: [',']
			})
		});
	});
</script>



@foreach($languages as $language)
	<?
	$index = str_random(5);
	$string1 = '[translated]['.$index.'][]';
	$string2 = '[translated]['.$index.'][language_id]';



	?>
	<div class="form-group col-sm-12">
		{{--{{dd($tagList[$language->id] )}}--}}
		<label for="{{'contact_detail['.$detail['id'].']'.$string1, $tagList[$language->id]}}" class="col-sm-2">({{strtoupper($language->abbr)}})</label>
		<div class="col-sm-10">
			{!! Form::select('contact_detail['.$detail['id'].']'.$string1, $tagListAll[$language->id]->pluck('name', 'id'),$tagList[$language->id] , ['class'=>'form-control tagsinput1', 'multiple'=>'multiple' ] ) !!}

			{!! Form::hidden('contact_detail['.$detail['id'].']'.$string2, $language->id) !!}
		</div>

	</div>
@endforeach

<script>
	$(document).ready(function(){
		$(".tagsinput").tagsinput();
	});

</script>