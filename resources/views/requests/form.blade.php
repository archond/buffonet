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
    {!! Form::label(_('Request for contact:'), null, ['class'=>'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        {{ Form::text('a', $title, ['class'=>'form-control', 'placeholder'=>_('Title is missing'), 'disabled']) }}
    </div>
</div>

<div class="form-group">
    {!! Form::label(_('to:'), null, ['class'=>'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        {{Form::text('emails_list', null,  ['class'=>'', 'placeholder'=>_('Input emails'), 'id'=>'emails_list' ])}}
    </div>
</div>




@foreach($stages as $stage)
    @if($stage->is_contact_data_stage)
        <div class="form-group">
            {!! Form::label(_('stages'), $stage->name, ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
                {!! Form::checkbox('stages[]',  $stage->id, null , ['class'=>'form-control1', 'placeholder'=>'Input name'] ) !!}
            </div>
        </div>
    @endif
@endforeach

<div class="form-group">
    {!! Form::label(_('Message'), null, ['class'=>'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        {{Form::textarea('message_text', null,  ['class'=>'form-control', 'placeholder'=>_('Input message')])}}
    </div>
</div>
{{ Form::hidden('contact_id', $contact->id ) }}
{{--{{ Form::hidden('data', json_encode($data)) }}--}}


@section('js')
    <script type="text/javascript">
        $('#emails_list')
                .textext({
                    plugins: 'autocomplete filter tags ajax',
                    tagsItems: [{!! isset($emails)  ?  $emails : null !!} ],
//                    tagsItems: ["abc", "123"],
                    ajax: {
                        url: '{{ route('ajax.get-contacts-emais') }}',
                        dataType: 'json',
//                        cacheResults : true
                    },
                    loadingMessage: '{{_('Loading....')}}',
                }).bind('isTagAllowed', function (e, data) {
            var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
//                    return regex.test(email);

            if (!regex.test(data.tag)) {
                data.result = false;
            }

            var formData = $(e.target).textext()[0].tags()._formData,
                    list = eval(formData);
            // duplicate checking
            if (formData.length && list.indexOf(data.tag) >= 0) {
                var message = [ data.tag, '{{_('is already listed.')}}' ].join(' ');
                alert(message);

                data.result = false;
            }
        });

    </script>
@endsection