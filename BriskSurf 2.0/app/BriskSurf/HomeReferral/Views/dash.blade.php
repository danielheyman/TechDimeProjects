@extends('templates.full')

@section('header')
	{{ HTML::style('assets/css/in.home.css') }}
@stop

@section('body')

	<!-- content-13 -->
	<section class="content-33" style="padding: 60px 0;">
		<div class="container">
			<div class="row demo-tiles">

				@if( isset($deals) )
					<div class="col-xs-12">
						@foreach($deals as $deal)
								<div name="{{ $deal->_id }}" class="alert alert-info deal">
								  	<h4>{{ $deal->subject }}</h4>
								  	<p>{{ $deal->text }}</p>
								  	{{ PaymentManager::makePayment($deal->package_id, '<button class="btn btn-info">Buy Now</button>') }}
								  	<p><div class="fui-time"></div> The offer expired in {{ $deal->expires->diffForHumans() }}.</p>
								</div>
						@endforeach
					</div>

					<div class="col-xs-12">
						<center>
							@for($x = 0; $x < count($deals); $x++)
								<div  name="{{ $deals[$x]->_id }}" class="circle {{ ($x == 0) ? 'active' : '' }}"></div>
							@endfor
						</center>
					</div>
				@endif

				<div class="col-xs-12">
					<div class="alert alert-error">
		            			<center>
							@if($user->websites->count() == 0)
							            	We've noticed that you have not added a website yet.
							            	<br>
							            	<a href="{{ url('websites') }}"><button class="btn btn-info">Add One Now</button></a>
						            	</div>
							@elseif($user->credits == 0)
						            	We've noticed that you have not surfed yet today. You currently have <strong>{{ $user->credits }}</strong> credits.
						            	<br>
						            	<a href="{{ url('surf') }}"><button class="btn btn-info">Surf Now</button></a>
						            @else
						            	Congratulations on surfing today! You currently have <strong>{{ $user->credits }}</strong> credits.
						          	@endif
			            		</center>
		            		</div>
			          	</div>


				<div class="col-xs-3">
					<div class="tile">
						<img src="{{ asset('assets/common-files/icons/Earth@2x.png') }}" class="tile-image big-illustration">
						<a class="btn btn-info btn-large btn-block" href="{{ url('surf') }}">Surf Websites</a>
					</div>
				</div>

				<div class="col-xs-3">
					<div class="tile">
						<img src="{{ asset('assets/common-files/icons/Box1@2x.png') }}" class="tile-image">
						<a class="btn btn-info btn-large btn-block" href="{{ url('websites') }}">Your Websites</a>
					</div>
				</div>

				<div class="col-xs-3">
					<div class="tile">
						<img src="{{ asset('assets/common-files/icons/Banner@2x.png') }}" class="tile-image">
						<a class="btn btn-info btn-large btn-block" href="{{ url('banners') }}">Your Banners</a>
					</div>
				</div>

				<div class="col-xs-3">
					<div class="tile tile-hot">
						<img src="{{ asset('assets/common-files/icons/Spaceship@2x.png') }}" class="tile-image">
						<a class="btn btn-info btn-large btn-block" href="{{ url('memberships') }}">Upgrade</a>
					</div>
				</div>

				<div class="col-xs-3">
					<div class="tile tile-hot">
						<img src="{{ asset('assets/common-files/icons/Magic@2x.png') }}" class="tile-image">
						<a class="btn btn-info btn-large btn-block" href="{{ url('credits') }}">Buy Credits</a>
					</div>
				</div>

				<div class="col-xs-3">
					<div class="tile">
						<img src="{{ asset('assets/common-files/icons/Money@2x.png') }}" class="tile-image">
						<a class="btn btn-info btn-large btn-block" href="#">Your Cash</a>
					</div>
				</div>

				<div class="col-xs-3">
					<div class="tile">
						<img src="{{ asset('assets/common-files/icons/Dude@2x.png') }}" class="tile-image">
						<a class="btn btn-info btn-large btn-block" href="#">Referral Tools</a>
					</div>
				</div>
			</div>

			<!--<p class="lead"><b>Congrats!</b> You are now logged in as {{ Auth::user()->name }}.</p>-->
		</div>
	</section>
@stop

@section('footer')
	{{ HTML::script('assets/js/in.home.js') }}
@stop