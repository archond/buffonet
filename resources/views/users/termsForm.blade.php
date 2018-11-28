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
							<strong>{{_('My addresses')}}</strong>
					</div>
            <div class="panel-body">
                <div class="form-group">
 									<strong>{!! _('buffonet.com - terms of use')!!}</strong>
								</div>
							  <div class="form-group">
									<strong>{!! _('Privacy policy')!!}</strong>
								</div>
							  <div class="form-group">
									<strong>{!! _('Others.')!!}</strong>
								</div>


            </div>
        </div>
    </div>




@endsection
