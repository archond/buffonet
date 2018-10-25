@extends('layouts.app')

@section('content')


    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">

                <strong>Search</strong>
                <div class="panel-options">
                    <a href="#" data-toggle="panel" class="panel1">
                        <span class="collapse-icon">+</span>
                        <span class="expand-icon">-</span>
                    </a>
                    <a href="#" data-toggle="remove">
                        ×
                    </a>
                </div>

                {{Form::open(['method'=>'get', 'route'=>'mainobjects.index'])}}

                {{--<div class="panel-body {{ !isset($inputs['search_value']) || $inputs['search_value']=='' || $inputs['search_value'] ==null ? "hide" : null }}">--}}
                <div class="panel-body {{ !isset($inputs['search_value']) || $inputs['search_value']=='' || $inputs['search_value'] ==null ? "" : null }}">

                    <section class="search-env">
                        <div class="input-group input-group-minimal">
                            <input type="text" name="search_value" class="form-control" placeholder="Search for something…"
                                   value="{{ isset($inputs['search_value']) ?  $inputs['search_value'] : null }}">
						<span class="input-group-addon">
							<input type="submit"><i class="linecons-search"></i></input>
						</span>
                        </div>


                        <div class="row">
                            <div class="col-md-12">

                                {{--{{dd($searchDetails)}}--}}

                                @foreach($searchDetails as $key => $detail)

                                    @if(in_array($detail->name, ['e-mail', 'phone'] ) )

                                    <label class="checkbox-inline">
                                        {{Form::checkbox('search_detail['.$detail['id'].']', $detail['id'], isset($inputs['search_detail'][ $detail['id'] ]) ? 1 :0  )}}
                                        {{$detail['name']}}
                                    </label>
                                    @endif

                                @endforeach

                            </div>
                        </div>
                    </section>
                </div>
                {{Form::close()}}
            </div>
        </div>


        <div class="panel panel-default">

            {{Form::open(['method'=>'get', 'route'=>'contacts.create-request'])}}
            <div class="panel-heading">
                <!-- Table Model 2 -->
                <strong>Main Objects</strong>

                <a type="button" class="btn btn-success btn-xs " href="{{ route('mainobjects.create') }}">
                    <i class="fa fa-plus"></i>
                </a>


                {{--
                <div class="panel-options" style="margin-left:5px">
                    {{Form::submit('Create Request', ['class'=>'btn btn-blue', 'name'=>'createRequest'])}}
                </div>

                <div class="panel-options" style="margin-left:5px">
                    {{Form::submit('Get Emails', ['class'=>'btn btn-blue', 'name'=>'getEmails'])}}
                </div>

                <div class="panel-options" style="margin-left:5px">
                    {{Form::submit('Get Phones', ['class'=>'btn btn-blue', 'name'=>'getPhones'])}}
                </div>
                --}}


            </div>
            <div class="panel-body">


                @if(isset($requestedDataString) )
                    <div>
				<pre>
					{{$requestedDataString}}
				</pre>
                    </div>
                @endif
                    <div class="text-center">{{ $mainobjects->links() }}</div>

                <div class="table-responsive" data-pattern="priority-columns" data-focus-btn-icon="fa-asterisk" data-sticky-table-header="true" data-add-display-all-btn="true"
                     data-add-focus-btn="true">

                    <table cellspacing="0" class="table table-small-font table-bordered table-striped">
                        <thead>
                        <tr>


                            <th data-priority="1">{{_('Phone')}}</th>
                            <th data-priority="1"><?_('Number of contacts');?></th>
                            <th data-priority="1">{{_('Created at')}}</th>

                            <th>action</th>

                        </tr>
                        </thead>
                        <tbody>

                        <form method="get" action="{{url(route('mainobjects.index'))}}" enctype="application/x-www-form-urlencoded">
                            @foreach($mainobjects as $contact)
                                <tr>
                                    <td>

                                        @if(is_array($contact['phone']))
                                            {{$contact['phone'][0]}}
                                        @else
                                            {{$contact['phone']}}
                                        @endif
                                    </td>

                                    <td>
                                        {{$contact->contacts->count()}}
                                    </td>

                                    <td>
                                        {{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$contact['created_at'])->timeZone('Europe/Riga')->format('Y-m-d H:i:s') }}
                                    </td>


                                    <td>
                                        <div class="">
                                            <a class="btn btn-info btn-xs" href="{{ route('contacts.create', ['main-object-id'=>$contact['id']]) }}"><i class="fa fa-plus"></i></a>

                                            <a class="btn btn-info btn-xs" href="{{ route('mainobjects.show', $contact['id']) }}"><i class="fa fa-info"></i></a>


                                            <a class="btn btn-success btn-xs" href="{{ route('mainobjects.edit', $contact['id']) }}"><i class="fa fa-edit"></i></a>

                                            <div class="btn btn-red btn-xs btn-delete" href="#" data-url="{{ route('mainobject.delete', ['id'=>Crypt::encrypt($contact['id'])  ] )}}"><i class="fa fa-remove"></i></div>

                                        </div>
                                    </td>

                                </tr>

                        @endforeach



                        {{Form::close()}}
                        </tbody>
                    </table>


                    <!-- </div> -->
                </div>
                    <div class="text-center">{{ $mainobjects->links() }}</div>

            </div>
        </div>
    </div>






    <script type="text/javascript">
        $(document).ready(function () {
            $('.panel1').on('click', function () {
                $(this).closest('.panel-heading').find('.panel-body').toggleClass('hide');
            });


            $('form').on('click', 'button', function () { // disable button elements to submit form!//
                $(this).attr('type', 'button');
            });

            $('form').on('click', '.btn-delete', function () {
                $('#action-delete-url').attr('href', $(this).attr('data-url') );
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
                    <a href="#" id="action-delete-url"><div class="btn btn-red">{{_('Delete')}}</div></a>
                </div>
            </div>
        </div>
    </div>
@endsection