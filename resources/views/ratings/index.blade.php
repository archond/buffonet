@extends('layouts.app')

@section('content')


    <div class="row">


        <div class="panel panel-default">
            <div class="panel-heading">
                <!-- Table Model 2 -->
                <strong>{{_('Ratings')}}</strong>
                {{--<a type="button" class="btn btn-success btn-xs " href="{{ route('ratings.create') }}">--}}
                {{--<i class="fa fa-plus"></i>--}}
                {{--</a>--}}
            </div>

            <div class="panel-body">

                <div class="text-center">{!! $ratings->links() !!}</div>

                <div class="table-responsive" data-pattern="priority-columns" data-focus-btn-icon="fa-asterisk"
                     data-sticky-table-header="true" data-add-display-all-btn="true"
                     data-add-focus-btn="true">

                    <table cellspacing="0" class="table table-small-font table-bordered table-striped">
                        {{Form::open(['route'=>'ratings.index', 'method'=>'get'])}}
                        <thead>
                        <tr>


                            <th data-priority="1">
                                <div>
                                    {{link_to_route('ratings.index', _('Clear filters'), ['clear_rating_filters'=>'true'], ['class'=>'btn btn-gray'] )}}
                                </div>
                                <div class="text-center">
                                    {{_('id')}}
                                </div>
                            </th>
                            <th data-priority="1">
                                <div class="input-group">
                                    {{Form::text('rating_search_by_contact', Request::session()->get('rating_search_by_contact'), ['class'=>'form-control', 'placeholder'=>_('Search by contact title')])}}
                                    <span class="input-group-btn">
                                            <button type="submit" class="btn btn-default" type="button"><i
                                                        class="fa fa-search"></i></button>
                                        </span>
                                </div>
                                <div class="text-center">{{_('contact')}}</div>
                            </th>
                            <th data-priority="1">
                                <div class="input-group">
                                    {{Form::text('rating_search_by_email', Request::session()->get('rating_search_by_email'), ['class'=>'form-control', 'placeholder'=>_('Search by email')])}}
                                    <span class="input-group-btn">
                                            <button type="submit" class="btn btn-default" type="button"><i
                                                        class="fa fa-search"></i></button>
                                        </span>
                                </div>
                                <div class="text-center">{{_('email')}}</div>
                            </th>
                            <th data-priority="1">
                                {{ link_to_route('ratings.index', _('sent'), ['rating_sort'=> Request::session()->get('rating_sort') == 'sent_date_a' ? 'sent_date_d' : 'sent_date_a' ]  )}}
                                <span class="fa {{Request::session()->get('rating_sort') == 'sent_date_a' ? 'fa-sort-down' : (Request::session()->get('rating_sort') == 'sent_date_d' ? 'fa-sort-up' : 'fa-sort') }}">
                                </span>

                            </th>
                            <th data-priority="1">
                                {{ link_to_route('ratings.index', _('complete'), ['rating_sort'=> Request::session()->get('rating_sort') == 'complete_date_a' ? 'complete_date_d' : 'complete_date_a' ]  )}}
                                <span class="fa {{Request::session()->get('rating_sort') == 'complete_date_a' ? 'fa-sort-down' : (Request::session()->get('rating_sort') == 'complete_date_d' ? 'fa-sort-up' : 'fa-sort') }}">
                                </span>
                            </th>
                            <th data-priority="1">{{_('language')}}</th>
                            <th data-priority="1">{{_('author')}}</th>

                            <th>{{_('Action')}}</th>

                        </tr>
                        </thead>
                        {{Form::close()}}
                        <tbody>


                        @foreach($ratings as $rating)
                            <tr class="{{ $rating->deleted_at ? 'warning1' : '' }}">

                                <td>
                                    {!!  $rating->deleted_at ? '<s>' : null !!}
                                    {{$rating->id}}
                                    {!!  $rating->deleted_at ? '</s>' : null !!}
                                </td>
                                <td>
                                    {!!  $rating->deleted_at ? '<s>' : null !!}
                                    {{isset($rating->contact->contactDetailValue->value) ? $rating->contact->contactDetailValue->value : 'no title'}}
                                    {!!  $rating->deleted_at ? '</s>' : null !!}
                                </td>
                                <td>
                                    {!!  $rating->deleted_at ? '<s>' : null !!}
                                    {{$rating->email}}
                                    {!!  $rating->deleted_at ? '</s>' : null !!}
                                </td>
                                <td>
                                    {!!  $rating->deleted_at ? '<s>' : null !!}
                                    {{$rating->sent_date}}
                                    {!!  $rating->deleted_at ? '</s>' : null !!}
                                </td>
                                <td>
                                    {!!  $rating->deleted_at ? '<s>' : null !!}
                                    {{$rating->complete_date}}
                                    {!!  $rating->deleted_at ? '</s>' : null !!}
                                </td>
                                <td>
                                    {!!  $rating->deleted_at ? '<s>' : null !!}
                                    {{$rating->language}}
                                    {!!  $rating->deleted_at ? '</s>' : null !!}
                                </td>
                                <td>
                                    {!!  $rating->deleted_at ? '<s>' : null !!}
                                    {{$rating->author_name}}
                                    {!!  $rating->deleted_at ? '</s>' : null !!}
                                </td>

                                <td>
                                    <div class="">

                                        <a class="btn btn-info btn-xs"
                                           href="{{ route('ratings.show', $rating['id']) }}"><i class="fa fa-info"></i></a>


                                        <?/*
                                        <a class="btn btn-success btn-xs" href="{{ route('ratings.edit', $rating['id']) }}"><i class="fa fa-edit"></i></a>
                                        */?>

                                        @if($rating->deleted_at)
                                            <a class="btn btn-warning btn-xs"
                                               href="{{ route('rating.restore', ['id'=>Crypt::encrypt($rating['id'])  ] )}}"><i
                                                        class="fa fa-undo"></i></a>
                                        @else
                                            <a class="btn btn-red btn-xs"
                                               href="{{ route('rating.delete', ['id'=>Crypt::encrypt($rating['id'])  ] )}}"><i
                                                        class="fa fa-remove"></i></a>
                                        @endif

                                    </div>
                                </td>

                            </tr>

                        @endforeach

                        </tbody>
                    </table>


                    <!-- </div> -->
                </div>
                <div class="text-center">{!! $ratings->links() !!}</div>

            </div>
        </div>
    </div>




@endsection