@extends('layouts.app')

@section('content')





    <div class="row">


        <div class="panel panel-default">
            <div class="panel-heading">
                <!-- Table Model 2 -->
                <strong>{{_('Requests list')}}</strong>
                <a type="button" class="btn btn-success btn-xs " href="{{ route('requests.create') }}">
                    <i class="fa fa-plus"></i>
                </a>
            </div>

            <div class="panel-body">

                <div class="text-center">{{ $myRequests->links() }}</div>
                <div class="table-responsive" data-pattern="priority-columns" data-focus-btn-icon="fa-asterisk"
                     data-sticky-table-header="true" data-add-display-all-btn="true"
                     data-add-focus-btn="true">


                    <table cellspacing="0" class="table table-small-font table-bordered table-striped">

                        {{Form::open(['route'=> ['requests.index'], 'method'=>'get'])}}
                        <thead>
                        <tr>
                            <th data-priority="1">
                                <div>
                                    {{--<a href="{{Request::route('requests.index', ['clear_request_filters'=>'true'])}}">Clear</a>--}}

                                    {{link_to_route('requests.index', _('Clear filters'), ['clear_request_filters'=>'true'], ['class'=>'btn btn-gray'] )}}
                                </div>

                                <div>
                                    {{_('id')}}
                                </div>
                            </th>

                            <th data-priority="1">
                                <div class="row1">

                                    <div class="input-group">
                                        {{Form::text('search_by_email', Request::session()->get('search_by_email'), ['class'=>'form-control', 'placeholder'=>_('email')])}}
                                        <span class="input-group-btn">
                                            <button type="submit" class="btn btn-default" type="button"><i
                                                        class="fa fa-search"></i></button>
                                        </span>
                                    </div>
                                    <div class="text-center">
                                        {{_('email')}}
                                    </div>
                                </div>
                            </th>
                            <th data-priority="1">
                                <div class="row1">


                                    <div class="input-group">
                                        {!! Form::text('search_by_title', Request::session()->get('search_by_title'), ['class'=>'form-control', 'placeholder'=>_('contact\'s title')]) !!}
                                        <span class="input-group-btn">
                                        <button type="submit" class="btn btn-default"><i
                                                    class="fa fa-search"></i></button>
                                            </span>
                                    </div>
                                    <div class="text-center">
                                        {{_('contact\'s title')}}
                                    </div>

                                </div>
                            </th>
                            <th data-priority="1">
                                {{ link_to_route('requests.index', _('sent Date'), ['request_sort'=> Request::session()->get('request_sort') == 'sent_date_a' ? 'sent_date_d' : 'sent_date_a' ]  )}}
                                <span class="fa {{Request::session()->get('request_sort') == 'sent_date_a' ? 'fa-sort-down' : (Request::session()->get('request_sort') == 'sent_date_d' ? 'fa-sort-up' : 'fa-sort') }}">
                                </span>
                            </th>
                            <th data-priority="1">
                                {{ link_to_route('requests.index', _('complete Date'), ['request_sort'=> Request::session()->get('request_sort') == 'complete_date_a' ? 'complete_date_d' : 'complete_date_a' ]  )}}
                                <span class="fa {{Request::session()->get('request_sort') == 'complete_date_a' ? 'fa-sort-down' : (Request::session()->get('request_sort') == 'complete_date_d' ? 'fa-sort-up' : 'fa-sort') }}">
                                </span>

                            </th>
                            <th data-priority="1">
                                <div class="row1 ">

                                    <div class="input-group">
                                        {{ Form::select('search_by_status', $requestStatuses, Request::session()->get('search_by_status'), ['class'=>'form-control'] ) }}
                                        <span class="input-group-btn">
                                        <button type="submit" class="btn btn-default">
                                            <i class="fa fa-search"></i>
                                        </button>
                                            </span>
                                    </div>
                                    <div class="text-center">
                                        {{_('Admin processed')}}
                                    </div>
                                </div>


                            </th>

                            <th data-priority="1">
                                <div class="row1 ">

                                    <div class="">


                                    </div>
                                    <div class="text-center">
                                        {{_('Action')}}
                                    </div>
                                </div>
                            </th>

                        </tr>
                        </thead>
                        {{Form::close()}}
                        <tbody>


                        @foreach($myRequests as $myRequest)
                            <tr>
                                <td>
                                    {{$myRequest->id}}
                                </td>

                                <td>{{$myRequest->email}}</td>

                                <td>{{  implode(',', isset($myRequest['contact_title']) ? $myRequest['contact_title'] : []) }}</td>

                                <td>{{  $myRequest['sent_date'] }}</td>
                                <td>{{  $myRequest['complete_date'] }}</td>

                                <td>
                                    <div class="text-center">
								<span

                                        @if($myRequest['is_confirmed_by_admin'] ==1 )
                                        class="fa fa-check-square-o" style="color:green"

                                        @elseif($myRequest['is_denied_by_admin'] ==1 )
                                        class="fa fa-times" style="color:red"

                                        @elseif($myRequest['complete_date'] )
                                        class="fa fa-clock-o" style="color:blue"

                                        @else
                                        class="fa fa-hourglass-start "
                                        @endif
                                ></span>
                                    </div>
                                </td>


                                <td>
                                    <div class="">
                                        {{--
                                            <a class="btn btn-info btn-xs"  href="{{ route('requests.show', $myRequest['id']) }}"><i class="fa fa-info"></i></a> \
                                            --}}
                                        @if($myRequest['is_confirmed_by_admin'] != 1 && $myRequest['is_denied_by_admin'] != 1 && $myRequest['complete_date'] )
                                            <a class="btn btn-warning btn-xs"
                                               href="{{ route('requests.admin-process-view', $myRequest['id']) }}"><i
                                                        class="fa fa-edit"></i></a>
                                        @endif
                                        {{--
                                            <a class="btn btn-red btn-xs" href="{{ route('request.delete', ['id'=>Crypt::encrypt($myRequest['id'])  ] )}}"><i class="fa fa-remove"></i></a>
                                            --}}


                                    </div>
                                </td>

                            </tr>

                        @endforeach

                        </tbody>
                    </table>

                    <!-- </div> -->
                </div>
                <div class="text-center">{{ $myRequests->links() }}</div>

            </div>
        </div>
    </div>




@endsection


