@extends('layouts.app')

@section('content')
<?php
use App\Http\Models\Users;?>

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
							<strong>{{_('My addresses')}}</strong>
					</div>
            <div class="panel-body">
                <div class="text-center"></div>
 {!! Form::open(['url' => '/' . LaravelGettext::getLocaleLanguage() . '/contactUpd', 'method' => 'post']) !!}
										 <table cellspacing="0" class="table table-small-font table-bordered table-striped">
											 <tr>

													 <td>
															<strong>{{_('Country')}}</strong>
													 </td>
													 <td>

								{!! Form::text('countryname',isset($params->countryname) ? $params->countryname : $data[0]->countryname,['class' => 'form-control']) !!}
													 </td>

											 </tr>
											 <tr>

													 <td>
															<strong>{{_('City')}}</strong>
													 </td>
													 <td>
														{!! Form::text('citiesname',isset($params->citiesname) ? $params->citiesname : $data[0]->citiesname,['class' => 'form-control']) !!}

													 </td>

											 </tr>
											 <tr>

											 		<td>
											 			 <strong>{{_('District')}}</strong>
											 		</td>


											 </tr>
											 <tr>

											 		<td>
											 			 <strong>{{_('Address')}}</strong>
											 		</td>
													<td>
														{!! Form::text('address',isset($params->address) ? $params->address : $data[0]->marker_address,['class' => 'form-control']) !!}
													</td>

											 </tr>
											 <tr>

											 		<td>
											 			 <strong>{{_('Postal Code')}}</strong>
											 		</td>

											 </tr>
									 	</table>
										<div style="margin-top:10px; margin-bottom:10px;">
										{!! Form::submit(__('Save'), [
										 'class' => 'btn btn-primary',
										]) !!}
										<a href="{!! 'http://'.$_SERVER['HTTP_HOST'].'/'.LaravelGettext::getLocaleLanguage() .'/addresses' !!}" class="btn btn-default">
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
