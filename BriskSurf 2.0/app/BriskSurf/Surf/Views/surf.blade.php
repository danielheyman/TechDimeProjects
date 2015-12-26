@extends('templates.header')


@section('inner_header')

	{{ HTML::style('assets/css/in.surf.css') }}

	<style type="text/css">
	#counter {
		background-image: url(http://www.gravatar.com/avatar/{{ $email }}?s=50);
		background-size: contain;
		background-repeat: no-repeat;
	}
	</style>

@stop

@section('inner_body')

	<div id="surf">
		<iframe id="iframe" src="{{ $website }}" sandbox="allow-forms allow-scripts allow-popups"></iframe>
		<a href="{{ url('dash') }}" class="btn btn-lg btn-danger" id="home"><span class="fui-home"></span></a>
		<button class="btn btn-lg btn-info" id="views">{{ $views }} Views</button>
		<button class="btn btn-sm btn-info" id="credits">Credits Today: {{ $credits_today }}<br>Credits Balance: {{ $credits }}</button>

		<button class="btn btn-lg btn-info" id="counter">{{ $timer }}</button>
	</div>

	<div id="modal" class="modal fade">
		<div class="modal-dialog">
		        	<div class="modal-content">
			          <div class="modal-header">
					<button type="button" class="close fui-cross" data-dismiss="modal" aria-hidden="true"></button>
					<h4 class="modal-title">Rate the Website</h4>
				</div>
				<div class="modal-body">
					<div id="rating">
						<span class="fui-star-2"></span>
						<span class="fui-star-2"></span>
						<span class="fui-star-2"></span>
					</div>

					<br>
					{{ ($verify_human) ? '<div id="insertSecurityHere"></div>' : '' }}

					<br>
					<center>
						<div addthis:url='{{ $website }}' class='addthis_toolbox addthis_32x32_style addthis_default_style'>
					                	<a class='addthis_button_compact'></a>
					                	<a class='addthis_button_facebook'></a>
					                	<a class='addthis_button_twitter'></a>
					                	<a class='addthis_button_google_plusone_share'></a>
					                	<a class='addthis_button_email'></a>
					            </div>
					         	<br><br>
					         	Also check out:
					         	<br>
					         	<a target="_blank" href="{{ $banner_url }}">
					         		<img src='http://www.gravatar.com/avatar/{{ $banner_email }}?s=60'/>
					         		<img src="{{ $banner_image }}"/>
					         	</a>
				         	</center>
				</div>
			</div>
		</div>
	</div>
	
	{{ $errors->first('global', '<div class="error btn btn-sm btn-danger">:message</div>') }}

	{{ Form::open(array('id' => 'form')) }}
		<button></button>
		{{ Form::hidden('hash', $hash) }}
		{{ Form::hidden('id', $id) }}
		{{ Form::hidden('banner_id', $banner_id) }}
		{{ ($verify_human) ? SecureForm::create() : '' }}
	{{ Form::close() }}

@stop

@section('inner_footer')

	<script type="text/javascript">
	var type = 'hover';
	</script>
	{{ HTML::script('assets/js/animate-colors.js') }}
	{{ ($verify_human) ? HTML::script('packages/module/secureForm/assets/js/main.js') : '' }}
	{{ HTML::script('//s7.addthis.com/js/300/addthis_widget.js#pubid=xa-51f28e7a17cad498') }}
	{{ HTML::script('assets/js/in.surf.js') }}

@stop