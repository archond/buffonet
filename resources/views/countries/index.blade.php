@extends('layouts.app')

@section('content')


    <div class="row">


        <div class="panel panel-default">
            <div class="panel-heading">
                <!-- Table Model 2 -->
                <strong>{{_('Countries')}}</strong>
                <a type="button" class="btn btn-success btn-xs " href="{{ route('countries.create') }}">
                    <i class="fa fa-plus"></i>
                </a>
            </div>

            <div class="panel-body">

                <div class="text-center">{!! $countries->render() !!}</div>
                <div class="table-responsive" data-pattern="priority-columns" data-focus-btn-icon="fa-asterisk" data-sticky-table-header="true" data-add-display-all-btn="true"
                     data-add-focus-btn="true">

                    <table cellspacing="0" class="table table-small-font table-bordered table-striped">
                        <thead>
                        <tr>


                            <th data-priority="1">
                                <div class="col-sm-3">{{_('Country')}}</div>
                                {{Form::open(['route'=>'countries.index', 'method'=>'get'])}}
                                <div class="col-sm-5 input-group pull-right">

                                        {{Form::text('search_country', Request::session()->has('search_country') ? Request::session()->get('search_country') : null, ['class'=>'form-control col-sm-5', 'id'=>'search_country'] )}}

                                    <div class="input-group-btn">
                                        <button class="btn btn-default"><i class="fa fa-filter"></i></button>
                                    </div>

                                </div>
                                {{Form::close()}}
                            </th>

                            <th>{{_('Action')}}</th>

                        </tr>
                        </thead>
                        <tbody>


                        @foreach($countries as $country)
                            <tr>
                                <td>
                                    {{$country->name}}
                                </td>

                                <td>
                                    <div class="">

                                        <a class="btn btn-info btn-xs" href="{{ route('countries.show', $country['id']) }}"><i class="fa fa-info"></i></a>


                                        <a class="btn btn-success btn-xs" href="{{ route('countries.edit', $country['id']) }}"><i class="fa fa-edit"></i></a>


                                        <a class="btn btn-red btn-xs" href="{{ route('country.delete', ['id'=>Crypt::encrypt($country['id'])  ] )}}"><i class="fa fa-remove"></i></a>


                                    </div>
                                </td>

                            </tr>

                        @endforeach

                        </tbody>
                    </table>

                    <!-- </div> -->
                </div>
                <div class="text-center">{!! $countries->render() !!}</div>

            </div>
        </div>
    </div>


    <script type="text/javascript">
        $(document).ready(function() {
            $("#search_country").select2();
        });
    </script>



@endsection