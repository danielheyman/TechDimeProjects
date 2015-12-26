@extends('templates.header')

@section('inner_header')
	
	<style type="text/css">
	.header-8-sub{
		padding-top: 0px;
		padding-bottom: 0px;
		margin-bottom: 10px;
	}
	.header-8-sub h3{
		margin-bottom: 30px;
	}

	.banners .col-sm-6{
		text-align: center;
	}

	.banners .banner{
		display: inline-block;
	}

	h5{
		margin-top:50px;
		margin-bottom:30px;
	}
	</style>

@stop

@section('inner_body')

	<section class="header-8-sub bg-midnight-blue">
		<div class="background">&nbsp;</div>
		<div class="container">
			<div class="row">
				<div class="col-sm-6 col-sm-offset-3">
					<h3>Banner Fight Mini Game</h3>
				</div>
			</div>
		</div>
	</section>

	<center>
		<h5>The ultimate winner is: </h5>
		
		<div class="row banners">
			<div class="col-sm-12">
				<div id="{{ $banner['_id'] }}" class="banner">
					<a target="_blank" href="{{ $banner['url'] }}"><img src='http://www.gravatar.com/avatar/{{ md5($banner['user']['email']) }}?s=60'/> <img src='{{ $banner['banner'] }}'/></a>
				</div>
			</div>
		</div>
		<br><br>
		<p>Congratulations, you have earned {{ $credits }} credits!</p>
	</center>
@stop

@section('inner_footer')

	<script type="text/javascript">
		parent.done();
	</script>

@stop