@extends('layouts.app')

@section('content')


    <style>
        .left-column {
            width: 200px;
        }

        .hoverDiv:hover {
            background-color: #EEEEEE;
            overflow: hidden;
        }

    </style>

    <div class="row">



        @foreach($mainObjects as $mainObject)
            <div class="panel panel-default">
                <div class="panel-heading">

                    <div>{{$mainObject->phone}}  <a  href="{{route('contacts.create', ['main-object-id'=>$mainObject->id])}}" class="pull-right"><i class="btn btn-xs btn-success fa fa-plus"></i></a></div>


                </div>
                <div class="panel-body ">

                    <table class="table table-model-2 table-hover">
                        <tbody>

                        @foreach($mainObject->contacts as $contact)


                            <tr>
                                <td style="width: 108px;">{{_('Title')}}:</td>
                                <td>
                                    <b>
                                        @if(is_array($contact->title))
                                            {{implode(',', $contact->title)}}
                                        @elseif($contact->title)
                                            {{$contact->title}}
                                        @else
                                            -
                                        @endif
                                    </b>

                                </td>


                                <td rowspan="0" width="120px">
                                    <a class="pull-left" href="{{ route('contacts.show', $contact['id']) }}"><i
                                                style="width:25px; margin:2px"
                                                class="fa fa-info btn btn-info btn-xs btn-block"></i></a>

                                    <a class="pull-left" href="{{ route('contacts.edit', $contact['id']) }}"><i
                                                style="width:25px; margin:2px"
                                                class="fa fa-edit btn btn-success btn-xs"></i></a>

                                    <div class="pull-left" href="#"
                                         data-url="{{ route('contact.delete', ['id'=>Crypt::encrypt($contact['id'])  ] )}}">
                                        <i class="fa fa-remove btn btn-red btn-xs" style="width:25px; margin:2px"></i>
                                    </div>
                                </td>

                            </tr>

                            <tr>


                                <td>{{_('Language')}}:</td>
                                <td colspan="2">
                                    @if($contact->language->name)
                                        {{$contact->language->name}}
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>

                            <tr>


                                <td>{{_('Phone')}}:</td>
                                <td colspan="2">
                                    @if(is_array($contact->phone) )
                                        {{implode(',', $contact->phone)}}
                                    @elseif($contact->phone)
                                        {{$contact->phone}}
                                    @else
                                        {{$mainObject->phone}}
                                    @endif
                                </td>

                            </tr>

                            <tr>


                                <td>{{_('e-mail')}}:</td>
                                <td colspan="2">
                                    @if(is_array($contact['e-mail']))
                                        {{implode(',', $contact['e-mail'])}}
                                    @elseif($contact['email'])
                                        {{$contact['email']}}
                                    @else
                                        -
                                    @endif
                                </td>


                            </tr>




                            <tr>
                                <td>{{_('Address')}}:</td>
                                <td colspan="2">
                                    @foreach($contact->addresses as $address)
                                        {{$address->marker_address.
                                        ($address->city->name != '' ? ', '.$address->city->name : null).
                                        ($address->country->name != '' ? ', '.$address->country->name : null).
                                        ($address->marker_zip != '' ? ', '.$address->marker_zip : null) }};

                                    @endforeach

                                </td>
                            </tr>

                            <tr>
                                <td>{{_('Category')}}:</td>
                                <td colspan="2">
                                    @if(is_array($contact->categories))
                                        {{ (implode(',', $contact->categories) ) }}&nbsp;
                                    @elseif($contact->categories)
                                        {{$contact->categories}}
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5" style="border-bottom: 1px solid black;"></td>
                            </tr>





                        @endforeach

                        </tbody>

                    </table>

                </div>
            </div>

        @endforeach
    </div>


    <script type="text/javascript">
        $(document).ready(function () {


            $('body').on('click', '.btn-delete', function () {
                $('#action-delete-url').attr('href', $(this).attr('data-url'));
                $('#modal-delete').modal('show');
            });

        });

    </script>

@endsection



@section('modal')
    <!-- Modal 1 (Basic)-->
    <div class="modal fade" id="modal-delete">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">{{_('Confirmation')}}</h4>
                </div>

                <div class="modal-body">
                    {{_('Are you sure to delete this item')}}?
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">{{_('Cancel')}}</button>
                    <a href="#" id="action-delete-url">
                        <div class="btn btn-red">{{_('Delete')}}</div>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection