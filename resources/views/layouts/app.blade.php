<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="description" content="{{env('APP_NAME', '-')}}"/>
    <meta name="author" content=""/>
    <title>{{\Config('constants.APP_NAME', '-')}}</title>
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Arimo:400,700,400italic">
    <link rel="stylesheet" href="{{ URL::asset('admin-assets/css/fonts/linecons/css/linecons.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('admin-assets/css/fonts/fontawesome/css/font-awesome.min.css') }}">
    {{-- <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css"> --}}
    <link rel="stylesheet" href="{{ URL::asset('admin-assets/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('admin-assets/css/xenon-core.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('admin-assets/css/custom.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('admin-assets/css/xenon-forms.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('admin-assets/css/xenon-components.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('admin-assets/css/xenon-skins.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('admin-assets/js/uikit/uikit.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('admin-assets/js/dropzone/css/dropzone.css') }}">


    {{--select2--}}
    {{--<link rel="stylesheet" href="{{ URL::asset('admin-assets/js/select2-4.0.2/dist/css/select2.min.css') }}">--}}
    {{--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/css/select2.min.css">--}}
    {{--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/3.5.1/select2.css">--}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/css/select2.min.css" rel="stylesheet"/>
    {{--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/3.5.1/select2-bootstrap.min.css">--}}
    {{--multi select--}}
    <link rel="stylesheet" href="{{ URL::asset('admin-assets/js/multiselect/css/multi-select.css') }}">


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.css">
    <link rel="stylesheet" href="{{ URL::asset('admin-assets/froala/css/froala_editor.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ URL::asset('admin-assets/froala/css/froala_style.min.css') }}" type="text/css">


    <link rel="stylesheet" href="{{ URL::asset('admin-assets/js/tokenfield/css/bootstrap-tokenfield.min.css') }}"
          type="text/css">
    <link rel="stylesheet" href="{{ URL::asset('admin-assets/js/tagsinput/bootstrap-tagsinput.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ URL::asset('admin-assets/js/tokenfield/css/tokenfield-typeahead.min.css') }}"
          type="text/css">


    <link rel="stylesheet" href="{{ URL::asset('admin-assets/js/tokenfield/css/tokenfield-typeahead.min.css') }}"
          type="text/css">


    <link rel="stylesheet" href="{{ URL::asset('admin-assets/jquery-textext/src/css/textext.plugin.tags.css') }}"
          type="text/css">
    <link rel="stylesheet"
          href="{{ URL::asset('admin-assets/jquery-textext/src/css/textext.plugin.autocomplete.css') }}"
          type="text/css">
    <link rel="stylesheet" href="{{ URL::asset('admin-assets/lightbox2-master/src/css/lightbox.css') }}"
          type="text/css">
	  <link rel="stylesheet" href="/style.css" />


    @yield('css')
    {{--<script src="{{ URL::asset('admin-assets/js/jquery-1.11.1.min.js') }}"></script>--}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0-rc1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/js/select2.min.js"></script>
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="page-body">
<div class="page-container">
    <!-- add class "sidebar-collapsed" to close sidebar by default, "chat-visible" to make chat appear always -->

    <!-- Add "fixed" class to make the sidebar fixed always to the browser viewport. -->
    <!-- Adding class "toggle-others" will keep only one menu item open at a time. -->
    <!-- Adding class "collapsed" collapse sidebar root elements and show only icons. -->
    <div class="sidebar-menu toggle-others fixed collapsed">
        <div class="sidebar-menu-inner">
            <header class="logo-env">
                <!-- logo -->
                <div class="logo">
                    <a href="{{ URL::route('contacts.index') }}" class="logo-expanded">
                        {{--<img src="{{ URL::asset('img/WebEmbassyLogo_s.png') }}" alt=""/>--}}
                        {{--<p style="font-size: 24px; color: #FEF9F9;margin:3px;font-family: monospace">buffonet.com</p>--}}
                        <div style="font-size:24px;color:#FEF9F9;margin:3px;font-family: monospace">buffonet.com</div>
                    </a>
                    <a href="{{ URL::route('contacts.index') }}" class="logo-collapsed">
                        {{--<img src="{{ URL::asset('img/WebEmbassyLogo_l.png') }}" width="40" alt=""/>--}}

                        {{--<div style="font-size:35px;color:#FEF9F9;margin:3px;font-family: monospace">WE</div>--}}
                        <div style="font-size:24px;color:#FEF9F9;margin:3px;font-family: monospace">bn</div>
                    </a>

                </div>

                <!-- This will toggle the mobile menu and will be visible only on mobile devices -->
                <div class="mobile-menu-toggle visible-xs">
                    {{--<a href="#" data-toggle="user-info-menu">--}}
                        {{--<i class="fa-bell-o"></i>--}}
                        {{--<span class="badge badge-success">7</span>--}}
                    {{--</a>--}}
                    <a href="#" data-toggle="mobile-menu">
                        <i class="fa-bars"></i>
                    </a>
                </div>

                <!-- This will open the popup with user profile settings, you can use for any purpose, just be creative -->
            </header>

            <div>
                @include('includes.nav-bar')
            </div>
        </div>
    </div>
    <div class="main-content">


        <!-- User Info, Notifications and Menu Bar -->
        <nav class="navbar user-info-navbar" role="navigation">
            <!-- Left links for user info navbar -->
            <ul class="user-info-menu left-links list-inline list-unstyled">
                <li class="hidden-sm hidden-xs">
                    <a href="#" data-toggle="sidebar">
                        <i class="fa-bars"></i>
                    </a>
                </li>
            </ul>


            <!-- Right links for user info navbar -->


            <ul class="user-info-menu right-links list-inline list-unstyled">

                @include('includes.languages-bar')

                {{--<li class="dropdown user-profile">--}}
                {{--<a href="#" data-toggle="dropdown">--}}
                {{--<span>--}}
                {{--{{_('Administrator')}}--}}
                {{--<i class="fa-angle-down"></i>--}}
                {{--</span>--}}
                {{--</a>--}}
                {{--<ul class="dropdown-menu user-profile-menu list-unstyled">--}}
                {{--<li class="last">--}}

                {{--<a href="{!! url('logout') !!}">--}}
                {{--<i class="fa-lock"></i>--}}
                {{--Logout--}}
                {{--</a>--}}
                {{--</li>--}}
                {{--</ul>--}}
                {{--</li>--}}


                <li class="user-profile">
                    @if(Auth::check())
                        <a href="{!! url('logout') !!}">
                            <i class="fa-lock"></i>
                            Logout
                        </a>
                    @else
                        <a href="{!! url('login') !!}">
                            <i class="fa-lock"></i>
                            Login
                        </a>
                    @endif
                </li>


            </ul>
        </nav>

        @if(Auth::check())
        <button class="btn" onclick="history.back()">{{_('Go Back') }}</button>
        @endif
    @include('includes.message')
    @yield('content')

    <!-- Main Footer -->
        <!-- Choose between footer styles: "footer-type-1" or "footer-type-2" -->
        <!-- Add class "sticky" to  always stick the footer to the end of page (if page contents is small) -->
        <!-- Or class "fixed" to  always fix the footer to the end of page -->

        {{--
        <footer class="main-footer fixed footer-type-1">
            <div class="footer-inner">
                <!-- Add your copyright text here -->
                <div class="footer-text">
                    © 2016 WEB EMBASSY. Developed for {{env('APP_NAME', '-')}}.
                </div>
                <!-- Go to Top Link, just add rel="go-top" to any link to add this functionality -->
                <div class="go-up">
                    <a href="#" rel="go-top">
                        <i class="fa-angle-up"></i>
                    </a>
                </div>
            </div>
        </footer>
        --}}

        <div style="position: fixed;bottom: 0;right: 0; height: 20px;width: 20px;border:solid 1px #c6c1c1;">
            <div class="go-up" style="background-color:#ebe5e5 ">
                <a href="#" rel="go-top">
                    <i class="fa-angle-up" style="position: relative;left: 28%"></i>
                </a>
            </div>
        </div>


        <div class="footer-text" style="position: absolute;bottom: 0;">
            © 2016 WEB EMBASSY. Developed for {{env('APP_NAME', '-')}}.
        </div>
    </div>
</div>
@yield('modal')
<link rel="stylesheet" href="{{ URL::asset('admin-assets/js/daterangepicker/daterangepicker-bs3.css') }}">
<!-- Bottom Scripts -->
<script src="{{ URL::asset('admin-assets/js/bootstrap.min.js') }}"></script>
<script src="{{ URL::asset('admin-assets/js/TweenMax.min.js') }}"></script>
<script src="{{ URL::asset('admin-assets/js/resizeable.js') }}"></script>
<script src="{{ URL::asset('admin-assets/js/joinable.js') }}"></script>
<script src="{{ URL::asset('admin-assets/js/xenon-api.js') }}"></script>
<script src="{{ URL::asset('admin-assets/js/xenon-toggles.js') }}"></script>
<script src="{{ URL::asset('admin-assets/js/uikit/js/uikit.min.js') }}"></script>
<script src="{{ URL::asset('admin-assets/js/uikit/js/addons/nestable.min.js') }}"></script>
<script src="{{ URL::asset('admin-assets/js/moment.min.js') }}"></script>
<script src="{{ URL::asset('admin-assets/js/daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ URL::asset('admin-assets/js/datepicker/bootstrap-datepicker.js') }}"></script>

<script src="{{ URL::asset('admin-assets/js/rwd-table/js/rwd-table.min.js') }}"></script>


<script src="{{ URL::asset('admin-assets/js/xenon-custom.js') }}"></script>
<script src="{{ URL::asset('admin-assets/js/tagsinput/bootstrap-tagsinput.min.js') }}"></script>
<script src="{{ URL::asset('admin-assets/js/typehead/typehead.js') }}"></script>

<script src="{{ URL::asset('admin-assets/js/tokenfield/bootstrap-tokenfield.min.js') }}"></script>
<script src="{{ URL::asset('admin-assets/js/tagsinput/bootstrap-tagsinput.min.js') }}"></script>


<script src="{{ URL::asset('admin-assets/froala/js/froala_editor.min.js')}}"></script>

<script src="{{ URL::asset('admin-assets/js/bootstrap-maxlength.js')}}"></script>


<script src="{{ URL::asset('admin-assets/lightbox2-master/src/js/lightbox.js')}}"></script>

<script src="{{ URL::asset('admin-assets/jquery-textext/src/js/textext.core.js') }}"></script>
<script src="{{ URL::asset('admin-assets/jquery-textext/src/js/textext.plugin.autocomplete.js') }}"></script>
<script src="{{ URL::asset('admin-assets/jquery-textext/src/js/textext.plugin.tags.js') }}"></script>
<script src="{{ URL::asset('admin-assets/jquery-textext/src/js/textext.plugin.suggestions.js') }}"></script>
<script src="{{ URL::asset('admin-assets/jquery-textext/src/js/textext.plugin.ajax.js') }}"></script>

<script src="{{ URL::asset('admin-assets/jquery-textext/src/js/textext.plugin.ajax.js') }}"></script>
{{--select2--}}
{{--<script src="{{ URL::asset('admin-assets/js/select2-4.0.2/dist/js/select2.min.js') }}"></script>--}}
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/js/select2.full.min.js"></script>--}}
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/js/select2.full.js"></script>--}}
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0-rc.2/js/select2.full.min.js"></script>--}}


{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/3.5.1/select2.min.js"></script>--}}
{{--multiselect--}}
<script src="{{ URL::asset('admin-assets/js/multiselect/js/jquery.multi-select.js') }}"></script>


@yield('js')
<!-- JavaScripts initializations and stuff -->
<script src="{{ URL::asset('admin-assets/js/xenon-custom.js') }}"></script>
<script src="{{ URL::asset('admin-assets/js/characters-meta-min-max.js') }}"></script>


<script>

    $(function () {
        $('.table-responsive').responsiveTable();
    });

</script>
</body>
</html>
