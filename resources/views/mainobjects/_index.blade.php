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
			
			<div class="panel-body {{ !isset($inputs['search_value']) || $inputs['search_value']=='' || $inputs['search_value'] ==null ? "hide" : null }}">

				<section class="search-env"> 
					<div class="input-group input-group-minimal">
						<input type="text" name="search_value" class="form-control" placeholder="Search for something…" value="{{ isset($inputs['search_value']) ?  $inputs['search_value'] : null }}"> 
						<span class="input-group-addon">
							<input type="submit"><i class="linecons-search"></i></input>
						</span>
					</div>



					<div class="row">
						<div class="col-md-12">

							@foreach($searchDetails as $key => $detail)

							<label class="checkbox-inline">
								{{Form::checkbox('search_detail['.$detail['id'].']', $detail['id'], isset($inputs['search_detail'][ $detail['id'] ]) ? 1 :0  )}}  
								{{$detail['name']}} 
							</label>

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


			<div class="table-responsive" data-pattern="priority-columns" data-focus-btn-icon="fa-asterisk" data-sticky-table-header="true" data-add-display-all-btn="true" data-add-focus-btn="true">

				<table cellspacing="0" class="table table-small-font table-bordered table-striped">
					<thead>
						<tr>

							@foreach($tableColumns as $key=> $column)
							<th data-priority="1">{{ $column }}</th>
							@endforeach


							{{--
							<th>send request</th>
							--}}
							<th>action</th>

						</tr>
					</thead>
					<tbody>

						<form method="get" action="{{url(route('mainobjects.index'))}}" enctype="application/x-www-form-urlencoded">
							@foreach($mainobjects as $contact)
							<tr>
								@foreach($tableColumns as $property)


								@if(is_array($contact[$property] ) )
								<td >{{ implode(",", $contact[$property] ) }}</td>
								@else
								<td>{{ $contact[$property] }}</td>
								@endif

								@endforeach

{{--
								<td>
									@if( $contact['e-mail'] )
									{{ Form::checkbox('contacts[]', $contact['id'], null) }}
									@else
									add email first!
									@endif
								</td> 
--}}
								<td>
									<div class="" > 
										<a class="btn btn-success btn-xs"  href="{{ route('mainobjects.edit', $contact['id']) }}"><i class="fa fa-edit"></i></a>

										<a class="btn btn-red btn-xs" href="{{ route('mainobject.delete', ['id'=>Crypt::encrypt($contact['id'])  ] )}}"><i class="fa fa-remove"></i></a>

									</div>
								</td>

							</tr>

							@endforeach



							{{Form::close()}}
						</tbody> 
					</table>

					<!-- </div> -->
				</div>

			</div>
		</div>
	</div>






	<script type="text/javascript">
		$(document).ready(function(){
			$('.panel1').on('click', function(){
				$(this).closest('.panel-heading').find('.panel-body').toggleClass('hide');
			});


		$('form').on('click', 'button', function(){ // disable button elements to submit form!//
			$(this).attr('type','button');
		});

	});

</script>

@endsection