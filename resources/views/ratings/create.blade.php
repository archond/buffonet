@extends('layouts.app')

@section('content')

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3>{{_('Send request to rate object(s)')}}:</h3>
        </div>

        <div class="panel-body">


            {{Form::open(['route'=> 'rating.ask-for-rating', 'method'=>'post'])}}
            <div class="form-group row">
                <label for="sss" class="col-sm-5 form-control-label">{{_('Ask for rating following contacts')}}:</label>
                <div class="col-sm-7">
                    <ul>
                        @foreach($contacts as $contact)
                            <li><a href="{{route('contacts.show', $contact->id)}}"
                                   target="_blank">{{isset($contact->contactDetailValues->first()->value) ? $contact->contactDetailValues->first()->value : 'no title' }}</a></li>
                            <input type="hidden" name="contact[]" value="{{$contact->id}}">
                        @endforeach
                    </ul>
                </div>
            </div>


            <div class="form-group row">
                <label for="emails_list" class="col-sm-2 form-control-label">{{_('Email')}}</label>
                <div class="col-sm-10">
                    <textarea name="emails_list" id="emails_list" class="form-control" rows="1"></textarea>
                </div>
            </div>

            <div class="form-group row">
                {!! Form::label('message_text', _('Message'), ['class'=>'col-sm-2 form-control-label']) !!}
                <div class="col-sm-10">
                    {{Form::textarea('message_text', null,  ['class'=>'form-control', 'placeholder'=>_('Input message')])}}
                </div>
            </div>


            <input type="submit" class="btn btn-info pull-right" value="{{_('Send request')}}">
            {{Form::close()}}
        </div>


    </div>





@endsection

@section('js')
    <script type="text/javascript">
        $('#emails_list')
                .textext({
                    plugins: 'autocomplete filter tags ajax',
                    ajax: {
                        url: '{{ route('ajax.get-contacts-emais') }}',
                        dataType: 'json',
//                        cacheResults : true
                    }
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