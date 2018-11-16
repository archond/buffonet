@extends('layouts.app')

@section('content')

<?php




// $translations = Translations::fromPoFile('C:\var\www\buffonet\resources\lang\i18n\en_GB\LC_MESSAGES\messages.po');
//
//
// $translation = $translations->find(null, 'Thank you');
//
// if ($translation) {
// 	$translation->setTranslation('Спасибо');
// }
//
// $translations->toMoFile('C:\var\www\buffonet\resources\lang\i18n\en_GB\LC_MESSAGES\messages1.po');

?>
<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
      <div class="white-box content">
          <div class="white-box-heading border-bottom clearfix">
							<span class="dark bold text-uppercase">{!! "Translations" !!}</span>
					</div>

					{!! Form::open(['url' => '/' . LaravelGettext::getLocaleLanguage() . '/transUpdate', 'method' => 'post']) !!}
					<div class="filters-map">
						<div class="border-bottom">
								<label for="numtd">{!! __('Original(English):') !!}</label>
								{!! Form::label('original', $original,['class' => 'form-control']) !!}
						</div>
					</div>
					<div class="filters-map hidden">
						<div class="border-bottom">
								<label for="numtd">{!! __('Original(English):') !!}</label>
								{!! Form::text('original', $original,['class' => 'form-control']) !!}
						</div>
					</div>
					<div class="filters-map">
						<div class="border-bottom">
		 						<label for="numtd">{!! __('LV') !!}</label>
		 						{!! Form::text('transLV',isset($params->transLV) ? $params->transLV : $translateLV,['class' => 'form-control']) !!}
 						</div>
				</div>
				<div class="filters-map">
					<div class="border-bottom">
							<label for="numtd">{!! __('RU') !!}</label>
							{!! Form::text('transRU',isset($params->transRU) ? $params->transRU : $translateRU,['class' => 'form-control']) !!}
					</div>
				</div>
				<div style="margin-top:10px; margin-bottom:10px;">
				{!! Form::submit(__('Save'), [
					'class' => 'btn btn-primary',
				]) !!}
				<a href="{!! $_SERVER['REMOTE_ADDR'] !!}" class="btn btn-default">
					{{ __('Cancel') }}
				</a>
				</div>
					{!!Form::close() !!}
		</div>
		</div>

@endsection
