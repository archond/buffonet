@extends('layouts.app')

@section('content')


    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">
                <!-- Table Model 2 -->
                <strong>{{_('List of Users')}}</strong>
                {{--<a type="button" class="btn btn-success btn-xs " href="{{ route('users.create') }}">--}}
                    {{--<i class="fa fa-plus"></i>--}}
                {{--</a>--}}
            </div>
						
            <div class="panel-body">
                <div class="text-center">{!! $users->render() !!}</div>
                <div class="table-responsive" data-pattern="priority-columns" data-focus-btn-icon="fa-asterisk" data-sticky-table-header="true" data-add-display-all-btn="true"
                     data-add-focus-btn="true">

                    <table cellspacing="0" class="table table-small-font table-bordered table-striped">
                        <thead>
                        <tr>


                            <th data-priority="1">{{_('name')}}</th>
                            <th data-priority="1">{{_('email')}}</th>
                            <th>{{_('Is admin?')}}</th>
                            {{--<th>{{_('Action')}}</th>--}}

                        </tr>
                        </thead>
                        <tbody>


                        @foreach($users as $user)
                            <tr>
                                <td>
                                    {{$user->name}}
                                </td>
                                <td>
                                    {{$user->email}}
                                </td>
                                <td>
                                    <a href="{{route('user.setAdminRole', Crypt::encrypt($user->id) )}}">
                                        <span class="fa {{$user->is_admin ? 'fa-check-square-o': 'fa-square-o   ' }}"></span>
                                    </a>
                                </td>
                                {{--<td>--}}
                                    {{--<div class="">--}}
                                            {{--<a class="btn btn-info btn-xs" href="{{ route('countries.show', $city['id']) }}"><i class="fa fa-info"></i></a>--}}
                                        {{--<a class="btn btn-success btn-xs" href="{{ route('users.edit', [$user['id']] ) }}"><i class="fa fa-edit"></i></a>--}}
                                        {{--<a class="btn btn-red btn-xs" href="{{ route('user.delete', ['id'=>Crypt::encrypt($user['id']) ] )}}"><i class="fa fa-remove"></i></a>--}}
                                    {{--</div>--}}
                                {{--</td>--}}

                            </tr>

                        @endforeach

                        </tbody>
                    </table>

                    <!-- </div> -->
                </div>
                <div class="text-center">{!! $users->render() !!}</div>

            </div>
        </div>
    </div>




@endsection
