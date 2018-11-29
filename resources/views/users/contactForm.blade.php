@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">
                <!-- Table Model 2 -->
                <strong>{{_('User Profile')}}</strong>
            </div>
						<div class="container">
						<div class="col-md-3">
                <!-- Table Model 2 -->

								<a href="{!! 'http://'.$_SERVER['HTTP_HOST'].'/'.LaravelGettext::getLocaleLanguage() .'/contact' !!}" class="btn btn-default">
						{{ _('Contact information') }}
								</a>

            </div>
						<div class="col-md-3">
                <!-- Table Model 2 -->
								<a href="{!! 'http://'.$_SERVER['HTTP_HOST'].'/'.LaravelGettext::getLocaleLanguage() .'/addresses' !!}" class="btn btn-default">
						{{ _('My addresses') }}
								</a>
            </div>
						<div class="col-md-3">
                <!-- Table Model 2 -->
								<a href="{!! 'http://'.$_SERVER['HTTP_HOST'].'/'.LaravelGettext::getLocaleLanguage() .'/terms' !!}" class="btn btn-default">
						{{ _('Terms and conditions') }}
								</a>
            </div>
						<div class="col-md-3">
                <!-- Table Model 2 -->
								<a href="{!! 'http://'.$_SERVER['HTTP_HOST'].'/'.LaravelGettext::getLocaleLanguage() .'/changePassword' !!}" class="btn btn-default">
						{{ _('Edit Password') }}
								</a>
            </div>
					</div>
					<div>
							<!-- Table Model 2 -->
							<strong>{{_('Contact information')}}</strong>
					</div>
            <div class="panel-body">
                <div class="text-center"></div>
 {!! Form::open(['url' => '/' . LaravelGettext::getLocaleLanguage() . '/contactUpd', 'method' => 'post']) !!}
										 <table cellspacing="0" class="table table-small-font table-bordered table-striped">

											 <tr>

													 <td>
															<strong>{{_('Name')}}</strong>
													 </td>
													 <td>
														 	{!! Form::text('name',isset($params->name) ? $params->name : $data[0]->name,['class' => 'form-control']) !!}
													 </td>

											 </tr>
											 <tr>

													 <td>
															<strong>{{_('Email')}}</strong>
													 </td>
													 <td>
														 {!! Form::text('email',isset($params->email) ? $params->email : $data[0]->email,['class' => 'form-control']) !!}
													 </td>

											 </tr>
											 <tr>

											 		<td>
											 			 <strong>{{_('Phone')}}</strong>
											 		</td>
													<td>
 													 {!! Form::text('phone',isset($params->phone) ? $params->phone : $data[0]->phone,['class' => 'form-control']) !!}
 												 </td>


											 </tr>
											 <tr>

											 		<td>
											 			 <strong>{{_('Language')}}</strong>
											 		</td>
													<td>
														{!! Form::text('language',isset($params->language) ? $params->language : $data[0]->language,['class' => 'form-control']) !!}
													</td>

											 </tr>

									 	</table>
										<div style="margin-top:10px; margin-bottom:10px;">
										{!! Form::submit(__('Save'), [
										 'class' => 'btn btn-primary',
										]) !!}
										<a href="{!! 'http://'.$_SERVER['HTTP_HOST'].'/'.LaravelGettext::getLocaleLanguage() .'/contact' !!}" class="btn btn-default">
										 {{ __('Cancel') }}
										</a>
										</div>
										 {!!Form::close() !!}



                    <!-- </div> -->

                <div class="text-center"></div>

            </div>
        </div>
    </div>




@endsection
