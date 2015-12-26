@extends('templates.header')


@section('inner_header')

	{{ HTML::style('assets/css/sidebars.css') }}

	@yield('header')

@stop


@section('inner_body')

	@if(Auth::check())
		<div id="tasks">
			<a class="fui-checkbox-checked">
		        		<span class="iconbar-unread">1</span>
	      		</a>
		</div>
		<div id="tasks_sidebar">
			<div class="inner">
				<div class="item">
					<div class="title">Beginners Task</div>
					<div class="sub">Surf 50 websites</div>
					<div class="progress">
	        					<div class="progress-bar progress-bar-warning" style="width: 90%;"></div>
	      					</div>
					<div class="options">
	          					<i class="fa fa-cube step"></i> Step 1 / 2
	      					</div>
				</div>
				<div class="item">
					<div class="title">Halloween Hunt</div>
					<div class="sub">Refer five friends</div>
					<div class="progress">
	        					<div class="progress-bar progress-bar-warning" style="width: 20%;"></div>
	      					</div>
					<div class="options">
	          					<i class="fa fa-cube step"></i> Step 0 / 1
	      					</div>
				</div>
			</div>
		</div>
		<div id="messages">
			<i class="fa fa-bell">
				@if(count($notifications) != 0)
					<span class="iconbar-unread">{{ count($notifications) }}</span> 
				@endif
			</i>
		</div>
		<div id="messages_sidebar">
			<div class="inner">
				<div class="caughtup item special {{ count($notifications) == 0 ? '' : 'hidden' }}">
					<div class="title">All caught up</div>
					<div class="sub">Congratulations, you are all caught up. You have no notifications.</div>
				</div>
				{{-- <div class="item special">
					<div class="title">Connect your notifications</div>
					<div class="sub">Connect to Surf Savant and get notifications across all websites.</div>
					<div class="options">
	          					<a href="#"><i class="fa fa-send"></i> Connect now</a>
	      					</div>
				</div>
				<div class="item">
					<div class="time">15 mins</div>
					<div class="title">Daniel Heyman</div>
					<div class="sub">Sent you a private message</div>
					<div class="options">
	          					<a href="#"><i class="fa fa-check"></i> Mark seen</a>
	          					<a href="#"><i class="fa fa-send margin"></i> Brisk Surf</a>
	      					</div>
				</div> --}}
				@foreach($notifications as $notification)
					<div class="item" id="{{ $notification->id }}" url="{{ URL::to('notification/seen') }}">
						<div class="time">{{ $notification->created_at->diffForHumans() }}</div>
						<div class="title">{{ $notification->subject }}</div>
						<div class="sub">{{ $notification->message }}</div>
						<div class="options">
		          					<a href="#" class="seen"><i class="fa fa-check"></i> Mark seen</a>
		      				</div>
		      				@if($notification->type_data)
		      					<iframe value="{{ $notification->type }}" class="type_data" srcdoc="{{ $notification->type_data }}"></iframe>
		      					<iframe class="type_data_title" srcdoc="{{ $notification->type_data_title }}"></iframe>
		      				@endif
					</div>
				@endforeach
			</div>
		</div>
	@endif

	<!-- header-10 -->
	<header class="header-10">
		<div class="container">
			<div class="row">
				<div class="navbar col-xs-12" role="navigation">
					<div class="navbar-header">
						<a class="brand" href="{{ (Auth::check()) ? url('/dash') : url('/') }}">{{ Settings::get('main')->website_name }}</a>
					</div>
					<div class="pull-right">
						@if(Auth::check())
						<ul class="nav pull-left">
							<li class="{{ set_active('dash') }}"><a href="{{ url('dash') }}">Dash</a></li>
							<li class="dropdown {{ set_active(['surf', 'surf/banners']) }}">
          								<a href="#" class="dropdown-toggle" data-toggle="dropdown">Surf Now</a>
          								<span class="dropdown-arrow"></span>
      								<ul class="dropdown-menu">
							                    	<li class="{{ set_active('surf') }}"><a href="{{ url('surf') }}">Hover Bar</a></li>
							                    	<li class="{{ set_active('surf/classic') }}"><a href="{{ url('surf/classic') }}">Classic Bar</a></li>
      								</ul>
							</li>
							<li class="dropdown {{ set_active(['memberships', 'credits', 'settings']) }}">
          								<a href="#" class="dropdown-toggle" data-toggle="dropdown">Account</a>
          								<span class="dropdown-arrow"></span>
      								<ul class="dropdown-menu">
							                    	<li class="{{ set_active('memberships') }}"><a href="{{ url('memberships') }}">Upgrade</a></li>
							                    	<li class="{{ set_active('credits') }}"><a href="{{ url('credits') }}">Buy Credits</a></li>
							                    	<li class="{{ set_active('settings') }}"><a href="{{ url('settings') }}">Settings</a></li>
							                    	<li><a href="{{ url('logout') }}">Logout</a></li>
      								</ul>
							</li>
							<li class="dropdown {{ set_active(['websites', 'banners']) }}">
          								<a href="#" class="dropdown-toggle" data-toggle="dropdown">My Ads</a>
          								<span class="dropdown-arrow"></span>
      								<ul class="dropdown-menu">
							                    	<li class="{{ set_active('websites') }}"><a href="{{ url('websites') }} ">Websites</a></li>
							                    	<li class="{{ set_active('banners') }}"><a href="{{ url('banners') }}">Banners</a></li>
      								</ul>
							</li>
							<li class="dropdown {{ set_active(['tools', 'referrals', 'commissions']) }}">
          								<a href="#" class="dropdown-toggle" data-toggle="dropdown">Promo</a>
          								<span class="dropdown-arrow"></span>
      								<ul class="dropdown-menu">
							                    	<li class="{{ set_active('tools') }}"><a href="{{ url('tools') }}">Tools</a></li>
							                    	<li class="{{ set_active('referrals') }}"><a href="{{ url('referrals') }}">Referrals</a></li>
							                    	<li class="{{ set_active('commissions') }}"><a href="{{ url('commissions') }}">Commissions</a></li>
      								</ul>
							</li>
							<li class="dropdown {{ set_active(['faq', 'tos', 'contact']) }}">
          								<a href="#" class="dropdown-toggle" data-toggle="dropdown">Help Me</a>
          								<span class="dropdown-arrow"></span>
      								<ul class="dropdown-menu">
							                    	<li class="{{ set_active('help/faq') }}"><a href="{{ url('help/faq') }}">FAQ</a></li>
							                    	<li class="{{ set_active('help/tos') }}"><a href="{{ url('help/tos') }}">TOS</a></li>
							                    	<li class="{{ set_active('contact') }}"><a target="_blank" href="http://www.techdime.com/support">Contact Us</a></li>
      								</ul>
							</li>
							<li><a id="tasks_menu">Tasks <span class="iconbar-unread">1</span></a></li>
							<li><a id="notifications_menu">Notifications <span class="iconbar-unread">4</span></a></li>
						</ul>
						@else
						<ul class="nav pull-left">
							<li><a href="{{ url('/') }}">Home</a></li>
							<li><a href="{{ url('login') }}">Login</a></li>
						</ul>
						<form class="navbar-form pull-left">
							<a class="btn btn-danger" href="{{ url('register') }}">Sign Up</a>
						</form>
						@endif
					</div>
				</div>
			</div>
		</div>
		<div class="header-background"></div>
	</header>

	@yield('body')


	<div id="modal" class="modal fade">
		<div class="modal-dialog">
		        	<div class="modal-content">
			          <div class="modal-header">
					<button type="button" class="close fui-cross" data-dismiss="modal" aria-hidden="true"></button>
					<h4 class="modal-title">Subject</h4>
				</div>
				<div class="modal-body">
					<p>Text.</p>
				</div>
				<div class="modal-footer">
					<a href="javascript:return false;" class="btn btn-default btn-wide">Continue</a>
					<a href="javascript:return false;" data-dismiss="modal" class="btn btn-wide btn-primary">Cancel</a>
				</div>
			</div>
		</div>
	</div>

	<!-- footer-14 -->
	<footer class="footer-14">
		<div class="container">
			<a class="brand" href="#">
				TechDime 2014 &copy;
			</a>
			<nav>
				<ul>
					<li><a target="_blank" href="http://techdime.com">Tech Dime</a></li>
					<li><a target="_blank" href="http://listviral.com">List Viral</a></li>
				</ul>
			</nav>
			<!--<div class="social-btns">
				<a target="_blank" href="http://twitter.com/surfsavant">
					<div class="fui-twitter"></div>
					<div class="fui-twitter"></div>
				</a>
				<a target="_blank" href="http://facebook.com/surfsavant">
					<div class="fui-facebook"></div>
					<div class="fui-facebook"></div>
				</a>
				<a target="_blank" href="http://blog.surfsavant.com">
					<div class="fui-document"></div>
					<div class="fui-document"></div>
				</a>
			</div>-->
		</div>
	</footer>

@stop


@section('inner_footer')

	{{ HTML::script('assets/js/sidebars.js') }}

	@yield('footer')

@stop