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
	{!! Form::label('phone', 'Phone', ['class'=>'col-sm-2 control-label']) !!}
	<div class="col-sm-10">
		{!! Form::text('phone', isset($mainobject) ? $mainobject['phone'] : null , ['class'=>'form-control', 'placeholder'=>_('phone format minimum 8 digits only - 00000000'), 'id'=>'phone'] ) !!}
	</div>
</div>

@section('js')
<script>
	$("form").submit(function (e) {
		e.preventDefault();

		var pattern = /^[0-9]{8,15}$/;

		if (!$('#phone').val().match(pattern)) {
			$('#phone').css('border-color', 'red')
			e.stopImmediatePropagation();
			return false;
		}

		$('.default-hidden-div').remove();
		$("form").unbind('submit').submit();

	});

	$('#phone').keyup(function(){
		$(this).css('border-color', '');
	});
</script>
@endsection
