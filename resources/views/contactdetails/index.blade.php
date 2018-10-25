@extends('layouts.app')




@section('content')


<div class="row">



	<div class="panel panel-default">
		<div class="panel-heading">
			<!-- Table Model 2 -->
			<strong>{{_('Contact Details')}}</strong>  
			<a type="button" class="btn btn-success btn-xs " href="{{ route('contactdetails.create') }}">
				<i class="fa fa-plus"></i>
			</a> 
		</div>

		<div class="panel-body">

			<div class="table-responsive" data-pattern="priority-columns" data-focus-btn-icon="fa-asterisk" data-sticky-table-header="true" data-add-display-all-btn="true" data-add-focus-btn="true">

				<table cellspacing="0" class="table table-small-font table-bordered table-striped">
					<thead>
						<tr>


							<th data-priority="1">{{_('Contact Detail')}}</th>

							<th data-priority="1"> 
								<div class="row">
									<div class="col-md-2">
									{{_('Stage')}}
									</div> 
									{!! Form::open(['method'=>'get', 'class'=>'col-md-6'] ) !!}
									{!! Form::select('stage_id', $stages->pluck('name', 'id'), \Request::has('stage_id') ? \Request::get('stage_id')  : null, ['placeholder'=>'-']) !!} 
									<button class="btn-xs btn-info btn "><i class="fa fa-filter"></i></button>
									{!! Form::close()!!}
								</div>
							</th>
							<th data-priority="1">{{_('Model')}}</th>  
							<th data-priority="1">{{_('is Translatable?')}}</th>
							<th data-priority="1">{{_('is Colollectable?')}}</th>  
							<th data-priority="1">{{_('is Uniq Value?')}}</th>
							<th data-priority="1">{{_('is Searchable?')}}</th>


							<th>{{_('Action')}}</th>

						</tr>
					</thead>
					<tbody>


						@foreach($contactDetails as $detail)  
						<tr>
							<td>
								{{$detail->name}}
							</td>

							<td>
								{{$detail->stage->name}} 
							</td>
							<td>
								{{ $detail->model ? $detail->model : '-'}}
							</td>
							<td>
								@if($detail->is_translatable) <i class="fa fa-check"</i> @else - @endif
							</td>
							<td>
								@if($detail->is_collectable) <i class="fa fa-check "</i> @else - @endif 
							</td>
							<td>
								@if($detail->is_uniq_value) <i class="fa fa-check "</i> @else - @endif 
							</td>
							<td>
								@if($detail->is_searchable) <i class="fa fa-check "</i> @else - @endif
							</td>
							<td>
								<div class="" > 
								{{--
									<a class="btn btn-info btn-xs"  href="{{ route('contactdetails.show', $detail['id']) }}"><i class="fa fa-info"></i></a> 
									--}}

									<a class="btn btn-success btn-xs"  href="{{ route('contactdetails.edit', $detail['id']) }}"><i class="fa fa-edit"></i></a>
									
									@if(count($detail['values']) == 0)
									<a class="btn btn-red btn-xs" href="{{ route('contactdetail.delete', ['id'=>Crypt::encrypt($detail['id'])  ] )}}"><i class="fa fa-remove"></i></a>
									@endif

								</div>
							</td>

						</tr>

						@endforeach

					</tbody> 
				</table>

				<!-- </div> -->
			</div>

		</div>
	</div>
</div>




@endsection