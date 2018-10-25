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


        <div class="panel panel-default">


            <div class="panel-heading">
                <!-- Table Model 2 -->
                <strong>Categories</strong>

                <a type="button" class="btn btn-success btn-xs " href="{{ route('categories.create') }}">
                    <i class="fa fa-plus"></i>
                </a>


            </div>
            <div class="panel-body">

                <ul>
                    @foreach($categories->toArray() as $category)

                        @include('categories.includes.item', ['categories'=>$category])


                    @endforeach


                </ul>


            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function () {

            $('body').on('click', '.btn-delete', function () {
                console.log('.btn-delete clicked')
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
                    <a href="#" id="action-delete-url">
                        <div class="btn btn-red">{{_('Delete')}}</div>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection