@extends('templates.full')

@section('header')
	{{ HTML::style('assets/css/out.home.css') }}
@stop

@section('body')
	<!-- header-2 -->
	<section class="header-2-sub bg-midnight-blue">
		<div class="background">&nbsp;</div>
		<div class="container">
			<div class="row">
				<div class="col-xs-8 col-xs-offset-2">
					<div class="hero-unit">
						<h1>The simpler manual traffic exchange<br/>where you matter most</h1>
					</div>
					<div class="btns">
						<a class="btn btn-info" href="{{ url('register') }}">Sign Up</a>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- content-26 -->
	<section class="content-26 bg-clouds">
		<div class="container">
			<div class="row">
				<div class="col-xs-12">
					<h3>It is more than just another traffic exchange</h3>
					<p class="lead">We’ve created a product that will push you to become the best.</p>
				</div>
			</div>
			<div class="row features">
				<div class="col-xs-3">
					<img src="{{ asset('assets/common-files/icons/Magic@2x.png') }}" alt="" width="100" height="100">
					<h6>Revamped Structure</h6>
					Completely redesigned to teach you how to make the best of your website.
				</div>
				<div class="col-xs-4 col-xs-offset-1">
					<img src="{{ asset('assets/common-files/icons/Dude@2x.png') }}" alt="" width="100" height="100">
					<h6>You Come First</h6>
					We will guide you through Brisk Surf, and ensure that you get the experience that you deserve.
				</div>
				<div class="col-xs-3 col-xs-offset-1">
					<img src="{{ asset('assets/common-files/icons/Bulb@2x.png') }}" alt="" width="100" height="100">
					<h6>Inspiration</h6>
					You will discover the best converting splash pages and create your own.
				</div>
			</div>
		</div>
	</section>

	<!-- crew-4 -->
	<section class="crew-4">
		<div class="container">
			<h3>Made with <div class="fui-heart"></div> by your two best buddies</h3>
			<div class="members">
				<div class="member-wrapper col-xs-3 col-xs-offset-2">
					<div class="member">
						<div class="photo-wrapper">
							<div class="photo" style="background-image: url(http://www.gravatar.com/avatar/1745a7a47ae81329de35fe3f99ad5a37?s=200);"><img src="http://www.gravatar.com/avatar/1745a7a47ae81329de35fe3f99ad5a37?s=200" alt="" style="display: none;"></div>
							{{--<div class="overlay">
								<a href="#"><span class="fui-skype"></span></a>
							</div>--}}
						</div>
						<div class="info">
							<div class="name">Matt Baker</div>
							<b>Awesomeness</b> The most awesome guy you will ever meet. He can turn any day into a great one.
						</div>
					</div>
				</div>
				<div class="member-wrapper col-xs-3 col-xs-offset-2">
					<div class="member">
						<div class="photo-wrapper">
							<div class="photo" style="background-image: url(http://www.gravatar.com/avatar/310184a4125a9aa94c376cec399a612a?s=200);"><img src="http://www.gravatar.com/avatar/310184a4125a9aa94c376cec399a612a?s=200" alt="" style="display: none;"></div>
							<div class="overlay">
								<a target="_blank" href="http://twitter.com/daniel_heyman"><span class="fui-twitter"></span></a>
							</div>
						</div>
						<div class="info">
							<div class="name">Daniel Heyman</div>
							<b>Developer</b> He sees and breathes code, but you can blame him for any bugs you find.
						</div>
					</div>
				</div>
			</div>
		</div>
		<!--/.container-->
	</section>
@stop