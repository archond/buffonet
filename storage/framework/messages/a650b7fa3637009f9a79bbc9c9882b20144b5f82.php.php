<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="description" content="<?php echo e(env('APP_NAME', '-')); ?>" />
	<meta name="author" content="" />
	<title><?php echo e(env('APP_NAME', '-')); ?></title>
	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Arimo:400,700,400italic">
	<link rel="stylesheet" href="<?php echo e(URL::asset('admin-assets/css/fonts/linecons/css/linecons.css')); ?>">
	<link rel="stylesheet" href="<?php echo e(URL::asset('admin-assets/css/fonts/fontawesome/css/font-awesome.min.css')); ?>">
	<?php /* <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css"> */ ?>
	<link rel="stylesheet" href="<?php echo e(URL::asset('admin-assets/css/bootstrap.css')); ?>">
	<link rel="stylesheet" href="<?php echo e(URL::asset('admin-assets/css/xenon-core.css')); ?>">
	<link rel="stylesheet" href="<?php echo e(URL::asset('admin-assets/css/xenon-forms.css')); ?>">
	<link rel="stylesheet" href="<?php echo e(URL::asset('admin-assets/css/xenon-components.css')); ?>">
	<link rel="stylesheet" href="<?php echo e(URL::asset('admin-assets/css/xenon-skins.css')); ?>">
	<link rel="stylesheet" href="<?php echo e(URL::asset('admin-assets/css/custom.css')); ?>">
	<link rel="stylesheet" href="<?php echo e(URL::asset('admin-assets/js/uikit/uikit.css')); ?>">
	<link rel="stylesheet" href="<?php echo e(URL::asset('admin-assets/js/dropzone/css/dropzone.css')); ?>">


	<?php /*select2*/ ?>
	<link rel="stylesheet" href="<?php echo e(URL::asset('admin-assets/js/select2-4.0.2/dist/css/select2.min.css')); ?>">
	<?php /*multi select*/ ?>
	<link rel="stylesheet" href="<?php echo e(URL::asset('admin-assets/js/multiselect/css/multi-select.css')); ?>">

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.css">
	<link rel="stylesheet" href="<?php echo e(URL::asset('admin-assets/froala/css/froala_editor.min.css')); ?>" type="text/css">
	<link rel="stylesheet" href="<?php echo e(URL::asset('admin-assets/froala/css/froala_style.min.css')); ?>" type="text/css">

	<?php echo $__env->yieldContent('css'); ?>
	<script src="<?php echo e(URL::asset('admin-assets/js/jquery-1.11.1.min.js')); ?>"></script>
	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="page-body">
    	<div class="page-container"><!-- add class "sidebar-collapsed" to close sidebar by default, "chat-visible" to make chat appear always -->

    		<!-- Add "fixed" class to make the sidebar fixed always to the browser viewport. -->
    		<!-- Adding class "toggle-others" will keep only one menu item open at a time. -->
    		<!-- Adding class "collapsed" collapse sidebar root elements and show only icons. -->

            <?/*
            <div class="sidebar-menu toggle-others fixed ">
                <div class="sidebar-menu-inner">    
                    <header class="logo-env">
                        <!-- logo -->
                        <div class="logo">
                            <a href="{{ URL::route('index') }}" class="logo-expanded">
                                <img src="{{ URL::asset('img/WebEmbassyLogo_s.png') }}" alt="" />
                            </a>
                            <a href="{{ URL::route('index') }}" class="logo-collapsed">
                                <img src="{{ URL::asset('img/WebEmbassyLogo_l.png') }}" width="40" alt="" />
                                {{--<div style="font-size:35px;color:#FEF9F9;margin:3px;font-family: monospace">WE</div>--}}
                            </a>
                        </div>
                        <!-- This will toggle the mobile menu and will be visible only on mobile devices -->
                        <div class="mobile-menu-toggle visible-xs">
                            <a href="#" data-toggle="user-info-menu">
                                <i class="fa-bell-o"></i>
                                <span class="badge badge-success">7</span>
                            </a>
                            <a href="#" data-toggle="mobile-menu">
                                <i class="fa-bars"></i>
                            </a>
                        </div>
                        <!-- This will open the popup with user profile settings, you can use for any purpose, just be creative -->
                    </header>
                    @include('includes.nav-bar')
                </div>
            </div>

            */ ?>
            
            <div class="main-content">
            	<?/*
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

            			<li class="dropdown user-profile">
            				<a href="#" data-toggle="dropdown">
            					<span>
            						Administrator
            						<i class="fa-angle-down"></i>
            					</span>
            				</a>
            				<ul class="dropdown-menu user-profile-menu list-unstyled">
            					<li class="last">

            						<a href="{!! url('logout') !!}">
            							<i class="fa-lock"></i>
            							Logout
            						</a>
            					</li>
            				</ul>
            			</li>
            		</ul>
            	</nav>
            	*/?>

            	<?php echo $__env->make('includes.message', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            	<?php echo $__env->yieldContent('content'); ?>
            	<!-- Main Footer -->
            	<!-- Choose between footer styles: "footer-type-1" or "footer-type-2" -->
            	<!-- Add class "sticky" to  always stick the footer to the end of page (if page contents is small) -->
            	<!-- Or class "fixed" to  always fix the footer to the end of page -->
            	<footer class="main-footer footer-type-1">
            		<div class="footer-inner">
            			<!-- Add your copyright text here -->
            			<div class="footer-text">
            				© 2016 WEB EMBASSY. Developed for <?php echo e(env('APP_NAME', '-')); ?>.
            			</div>
            			<!-- Go to Top Link, just add rel="go-top" to any link to add this functionality -->
            			<div class="go-up">
            				<a href="#" rel="go-top">
            					<i class="fa-angle-up"></i>
            				</a>
            			</div>
            		</div>
            	</footer>
            </div>
        </div>
        <?php echo $__env->yieldContent('modal'); ?>
        <link rel="stylesheet" href="<?php echo e(URL::asset('admin-assets/js/daterangepicker/daterangepicker-bs3.css')); ?>">
        <!-- Bottom Scripts -->
        <script src="<?php echo e(URL::asset('admin-assets/js/bootstrap.min.js')); ?>"></script>
        <script src="<?php echo e(URL::asset('admin-assets/js/TweenMax.min.js')); ?>"></script>
        <script src="<?php echo e(URL::asset('admin-assets/js/resizeable.js')); ?>"></script>
        <script src="<?php echo e(URL::asset('admin-assets/js/joinable.js')); ?>"></script>
        <script src="<?php echo e(URL::asset('admin-assets/js/xenon-api.js')); ?>"></script>
        <script src="<?php echo e(URL::asset('admin-assets/js/xenon-toggles.js')); ?>"></script>
        <script src="<?php echo e(URL::asset('admin-assets/js/uikit/js/uikit.min.js')); ?>"></script>
        <script src="<?php echo e(URL::asset('admin-assets/js/uikit/js/addons/nestable.min.js')); ?>"></script>
        <script src="<?php echo e(URL::asset('admin-assets/js/moment.min.js')); ?>"></script>
        <script src="<?php echo e(URL::asset('admin-assets/js/daterangepicker/daterangepicker.js')); ?>"></script>
        <script src="<?php echo e(URL::asset('admin-assets/js/datepicker/bootstrap-datepicker.js')); ?>"></script>

        <script src="<?php echo e(URL::asset('admin-assets/js/rwd-table/js/rwd-table.min.js')); ?>"></script>




        <script src="<?php echo e(URL::asset('admin-assets/js/xenon-custom.js')); ?>"></script>
        <script src="<?php echo e(URL::asset('admin-assets/js/tagsinput/bootstrap-tagsinput.min.js')); ?>"></script>
        <script src="<?php echo e(URL::asset('admin-assets/js/typehead/typehead.js')); ?>"></script>
        <script src="<?php echo e(URL::asset('admin-assets/js/tokenfield/bootstrap-tokenfield.js')); ?>"></script>
        <script src="<?php echo e(URL::asset('admin-assets/froala/js/froala_editor.min.js')); ?>"></script>

		<script src="<?php echo e(URL::asset('admin-assets/js/bootstrap-maxlength.js')); ?>"></script>

		<script src="<?php echo e(URL::asset('admin-assets/jquery-textext/src/js/textext.core.js')); ?>"></script>
		<script src="<?php echo e(URL::asset('admin-assets/jquery-textext/src/js/textext.plugin.autocomplete.js')); ?>"></script>
		<script src="<?php echo e(URL::asset('admin-assets/jquery-textext/src/js/textext.plugin.tags.js')); ?>"></script>
		<script src="<?php echo e(URL::asset('admin-assets/jquery-textext/src/js/textext.plugin.suggestions.js')); ?>"></script>
		<script src="<?php echo e(URL::asset('admin-assets/jquery-textext/src/js/textext.plugin.ajax.js')); ?>"></script>

		<script src="<?php echo e(URL::asset('admin-assets/jquery-textext/src/js/textext.plugin.ajax.js')); ?>"></script>
		<?php /*select2*/ ?>
		<script src="<?php echo e(URL::asset('admin-assets/js/select2-4.0.2/dist/js/select2.min.js')); ?>"></script>
		<?php /*multiselect*/ ?>
		<script src="<?php echo e(URL::asset('admin-assets/js/multiselect/js/jquery.multi-select.js')); ?>"></script>
        <?php echo $__env->yieldContent('js'); ?>
        <!-- JavaScripts initializations and stuff -->
        <script src="<?php echo e(URL::asset('admin-assets/js/xenon-custom.js')); ?>"></script>
        <script src="<?php echo e(URL::asset('admin-assets/js/characters-meta-min-max.js')); ?>"></script>
        <script>



        </script>
    </body>
    </html>
