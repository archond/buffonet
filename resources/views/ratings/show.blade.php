@extends('layouts.app')

@section('content')


    <div class="row">


        <div class="panel panel-default">
            <div class="panel-heading">
                <!-- Table Model 2 -->
                <strong>{{_('Rating')}} : {{$rating->contact->contactDetailValue->value}}</strong>

                <?/*
                <a type="button" class="btn btn-success btn-xs " href="{{ route('ratings.create') }}">
                    <i class="fa fa-plus"></i>
                </a>
                */?>
                <a class="btn btn-info btn-xs" href="{{ route('contacts.show', $rating->contact['id']) }}"><i class="fa fa-info"></i></a>
            </div>
f
            <div class="panel-body">

                <div class="table-responsive" data-pattern="priority-columns" data-focus-btn-icon="fa-asterisk" data-sticky-table-header="true" data-add-display-all-btn="true"
                     data-add-focus-btn="true">

                    <table cellspacing="0" class="table table-small-font table-bordered table-striped">

                        <thead>
                        <th  data-priority="1" >{{_('Property')}}</th>
                        <th  data-priority="1">{{_('Value')}}</th>
                        </thead>

                        <tbody>
                        <?/*
                    <tr>
                        <td>{{_('Contact')}}</td>
                        <td>{{$rating->contact->contactDetailValue->value}}</td>
                    </tr>
                    */?>
                        <tr>
                            <td>{{_('Language')}}</td>
                            <td>{{$rating->language}}</td>
                        </tr>
                        <tr>
                            <td>{{_('Email')}}</td>
                            <td>{{$rating->email}}</td>
                        </tr>
                        <tr>
                            <td>{{_('Author')}}</td>
                            <td>{{$rating->author_name}}</td>
                        </tr>
                        <tr>
                            <td>{{_('Author phone')}}</td>
                            <td>{{$rating->author_phone}}</td>
                        </tr>
                        <tr>
                            <td>{{_('Accurancy')}}</td>
                            <td>
                                @foreach([1,2,3,4,5] as $star)
                                    {!! $star <= $rating->accurancy ? '<i class="fa fa-star" ></i>' : '<i class="fa fa-star-o" ></i>' !!}
                                @endforeach
                            </td>
                        </tr>
                        <tr>
                            <td>{{_('Quality')}}</td>
                            <td>
                                @foreach([1,2,3,4,5] as $star)
                                    {!! $star <= $rating->quality ? '<i class="fa fa-star" ></i>' : '<i class="fa fa-star-o" ></i>' !!}
                                @endforeach
                            </td>
                        </tr>
                        <tr>
                            <td>{{_('Communication')}}</td>
                            <td>
                                @foreach([1,2,3,4,5] as $star)
                                    {!! $star <= $rating->communication ? '<i class="fa fa-star" ></i>' : '<i class="fa fa-star-o" ></i>' !!}
                                @endforeach
                            </td>
                        </tr>
                        <tr>
                            <td >{{_('Review')}}</td>
                            <td style="white-space: normal !important; ">{{$rating->review}}</td>
                        </tr>
                        <tr>
                            <td>{{_('Request sent date')}}</td>
                            <td>{{$rating->sent_date}}</td>
                        </tr>
                        <tr>
                            <td>{{_('Complete date')}}</td>
                            <td>{{$rating->complete_date}}</td>
                        </tr>
                        <tr>
                            <td>{{_('Action')}}</td>
                            <td>
                                @if(!$rating->deleted_at)
                                    <a class="btn btn-red btn-xs" href="{{ route('rating.delete', ['id'=>Crypt::encrypt($rating['id'])  ] )}}"><i class="fa fa-remove"></i></a>
                                @else
                                    {{_('deleted')}}: {{$rating->deleted_at}}
                                    <a class="btn btn-warning btn-xs" href="{{ route('rating.restore', ['id'=>Crypt::encrypt($rating['id'])  ] )}}"><i class="fa fa-undo"></i></a>
                                @endif
                            </td>
                        </tr>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>




@endsection