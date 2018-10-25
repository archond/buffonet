<?=_('Hi')?>, {{$email}}<br><br>



<?= _('Please be so kind and rate following object') ;?> :{{ $title }}<br><br>


<?=_('Links:')?>,
<ul>
    @foreach($languages as $language)
        <a href="{{ url($language->abbr.'/request-ask-for-rating/'.Crypt::encrypt($rating['id'] ) )  }}"><?=_('link on '.$language->name.' language')?></a>.<br>
    @endforeach
</ul>






<br><br>
{{ $message_text }}
<br><br>
<?=_('Thank you')?>!<br><br>

{{config('constants.APP_NAME')}}
