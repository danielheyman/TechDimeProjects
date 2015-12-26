@extends('templates.full')

@section('header')
	{{ HTML::style('assets/css/in.memberships.css') }}
@stop

@section('body')

	<section class="price-2">
		<div class="container">
			@if($user->membership != "free")
			<div class="alert alert-info">
						<b>Sweet!</b> You are a {{ $user->membership }} member. Your membership expires in {{ $user->membership_expires->diffForHumans() }} on {{ $user->membership_expires->toDayDateTimeString() }}.
					</div>
				   <br>
			@endif


			<div class="plan-options dialog dialog-success">
	      			<button class="btn btn-wide btn-info">
	        				Pay monthly
	      			</button>
	      			<button style="margin-left:30px;" class="btn btn-wide">
	        				Pay annually ( <strong>20% off</strong> )
	      			</button>
	    		</div>

			<div class="plans">
				<?php $count = 0 ?>
				@foreach($memberships as $membership_name => $membership)
					@if( $membership_name != "_id" )
						<div class="plan {{ $count > 0 && $count < count($memberships) ? 'plan-2' : '' }} {{ $membership['popular'] ? 'plan-highlight' : '' }}">
							<div class="title">
								{{ strtoupper($membership_name) }}
								@if( $membership_name != "free")
									<?php $package = $packages->filter( function($package) use ($membership_name) {
										return $package->active == $membership_name . " month"; 
									} )->first(); ?>
									<div class="plan-period">
										<div class="price"><span class="currency">$</span>{{ $package->cost }}<span class="period">/ MO</span></div>
										{{ $paymentManager->makeButton($package, '<input type="submit" class="btn btn-clear btn-small" value="Upgrade Now"/>') }}
										
									</div>
									<?php $package = $packages->filter( function($package) use ($membership_name) {
										return $package->active == $membership_name . " annual"; 
									} )->first(); ?>
									<div class="plan-period hide">
										<div class="price"><span class="currency">$</span>{{ $package->cost }}<span class="period">/ YR</span></div>
										{{ $paymentManager->makeButton($package, '<input type="submit" class="btn btn-clear btn-small" value="Upgrade Now"/>') }}
									</div>
								@else
									<div class="price"><span class="currency">$</span>0<span class="period"></span></div>
									<button class="btn btn-clear btn-small">Free</button>
								@endif
							</div>
							<div class="description">
								<div class="description-box">
									<b>{{ $membership['commission'] }}%</b> commissions
								</div>
								<div class="description-box">
									<b>{{ $membership['credits_per_view'] }}</b> credits per view
								</div>
								<div class="description-box">
									<b>{{ $membership['referral_percent'] }}</b>% referral credits
								</div>
								<div class="description-box">
									<b>{{ $membership['timer'] }}</b> second surf timer
								</div>
								<div class="description-box">
									<b>{{ ($membership['monthly_credits']) ?: '<span class="fui-cross"></span>' }}</b> monthly credits
								</div>
								<div class="description-box">
									<b><span class="{{ ($membership['targeting']) ? 'fui-check' : 'fui-cross' }}"></span></b> target your ad
								</div>
								<div class="description-box">
									<b>{{ $membership['maximum_websites'] }}</b> maximum websites
								</div>
								<div class="description-box">
									<b>Outstanding</b> support <!--<span data-toggle="tooltip" data-placement="left"  title="hey" class="fui-question info"></span>-->
								</div>
							</div>
						</div>
					@endif
					<?php $count++ ?>
				@endforeach
			</div>
		</div>
		<!--/.container-->
	</section>

@stop

@section('footer')
	
	<script type="text/javascript">
		$(".plan-options button").click(function() {
			if(!$(this).hasClass("btn-info"))
			{
				$(".plan-options button").toggleClass("btn-info");
				$(".plan-period").toggleClass("hide");
			}
		});
	</script>

@stop