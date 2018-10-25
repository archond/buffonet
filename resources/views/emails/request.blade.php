<?=_('Hi')?>, {{$request['email']}} <br><br>


{{$request->message_text}}

<br><br>

<?/*=_('Could you please provide me with your contact info?')?><br><br>*/?>

<?/*If you agree, <a href="{{ url(route('request-form', Crypt::encrypt($request['id'] ) ) ) }}">click on this <b>link</b></a>.*/?>
<?/*<?=_('If you agree')?>, <a href="{{ url($request->contact->language->abbr.'/request-form/'.Crypt::encrypt($request['id'] ) )  }}"><b><?=_('click on this link')?></b></a>.*/?>
Linki:
@foreach($languages as $language)
    <a href="{{ url($language->abbr.'/request-form/'.Crypt::encrypt($request['id'] ) )  }}"><b>{{$language->name}}</b></a><br>
@endforeach

<br><br>


<?=_('Thank you')?>!<br><br>

{{config('constants.APP_NAME')}}

