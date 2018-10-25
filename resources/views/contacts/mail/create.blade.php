@extends('layouts.app')

@section('content')

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3>{{_('Send mail to Contact')}}:</h3>
        </div>

        <div class="panel-body">


            {{Form::open(['route'=> ['contacts.send-mail-send', $contact->id ], 'method'=>'post'])}}


            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 form-control-label">{{_('Email')}}</label>
                <div class="col-sm-10">
                    <textarea name="emails_list" id="emails_list" class="form-control" rows="1"></textarea>
                </div>
            </div>

            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 form-control-label">{{_('Subject')}}</label>
                <div class="col-sm-10">
                    <input type="text" name="subject" id="subject" class="form-control"></input>
                </div>
            </div>

            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 form-control-label">{{_('Message')}}</label>
                <div class="col-sm-10">
                    <textarea name="message" id="message" class="form-control" rows="8"></textarea>
                </div>
            </div>

            <input type="submit" class="btn btn-info pull-right" value="{{_('Send message')}}">
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
                    },
                    tagsItems: [{!! isset($emails)  ?  $emails : null !!} ],
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




