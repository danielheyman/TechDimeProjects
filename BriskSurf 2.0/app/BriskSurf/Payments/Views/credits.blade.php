@extends('templates.full')

@section('body')

<section class="content-33" style="padding: 60px 0;">
	<div class="container">
		<div class="row demo-tiles">

			<div class="col-xs-12">
				<div class="alert alert-info">
			            	<strong>How many credits do I have?</strong><br>You currently have {{ $credits }} credits.
			          	</div>
			           <br>
		         	</div>

		         	@foreach($packages as $package)
				<div class="col-xs-3">
					<div class="tile">
						<strong>{{ number_format($package->value) }} Credits</strong>
						<br><br>
						Now Only ${{ $package->cost }}
						<br><br>
						{{ $paymentManager->makeButton($package, '<input class="btn btn-info" type="submit" value="Purchase Now"/>') }}
					</div>
				</div>
			@endforeach
		</div>
	</div>
</section>
	
@stop