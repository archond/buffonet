@extends('layouts.app')
@section('content')

<div class="row">
		<div class="panel panel-default">
									<div class="panel-heading">
                    <strong>{!! _('Change password') !!}</strong>
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
                    <div class="panel-body">
											<div class="flash-message">
												@foreach (['danger'] as $msg)
													@if(Session::has('alert-' . $msg))
													<p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }}</p>
													@endif
												@endforeach
											</div>
											<div class="flash-message">
												@foreach (['success'] as $msg)
													@if(Session::has('alert-' . $msg))
													<p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }}</p>
													@endif
												@endforeach
											</div>
                        <form class="form-horizontal" method="POST" action="{{ url(LaravelGettext::getLocaleLanguage().'/changePassword') }}">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('current-password') ? ' has-error' : '' }}">
                                <label for="new-password" class="col-md-2 control-label">{!! _('Current password') !!}</label>

                                <div class="col-md-3">
                                    <input id="current-password" type="password" class="form-control" name="current-password" required>

                                    @if ($errors->has('current-password'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('current-password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('new-password') ? ' has-error' : '' }}">
                                <label for="new-password" class="col-md-2 control-label">{!! _('New password') !!}</label>

                                <div class="col-md-3">
                                    <input id="new-password" type="password" class="form-control" name="new-password" required>

                                    @if ($errors->has('new-password'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('new-password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="new-password-confirm" class="col-md-2 control-label">{!! _('Confirm new password') !!}</label>

                                <div class="col-md-3">
                                    <input id="new-password-confirm" type="password" class="form-control" name="new-password_confirmation" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-3 col-md-offset-2">
                                    <button type="submit" class="btn btn-primary">
                                        {!! _('Change password') !!}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
<style>
.form-horizontal .control-label {
	text-align:left;
}
</style>
@endsection
