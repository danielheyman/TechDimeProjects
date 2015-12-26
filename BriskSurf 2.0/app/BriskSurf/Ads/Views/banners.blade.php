@extends('templates.full')

@section('header')

	{{ HTML::style('assets/css/in.banners.css') }}

@stop

@section('body')

<section class="content-33" style="padding: 60px 0;">
	<div class="container">

		<div class="alert alert-error">
	            	<center>You currently have {{ $user->credits }} credits left</center>
	          	</div>

	          	<br>

	          	{{ $errors->first('global', '<p class="error">:message</p><br>') }}
	      	{{ $errors->first('image_url', '<p class="error">:message</p>') }}
	      	{{ $errors->first('target_url', '<p class="error">:message</p>') }}

	       	{{ Form::open() }}
		          	<div class="row">
		          		<div class="col-xs-6">
				          <div class="form-group">
						{{ Form::text('image_url', '', array(
							'class' => 'form-control',
							'placeholder' => '468 x 60 Image URL'
						)) }}
		              		</div>
		          		</div>
		          		<div class="col-xs-6">
				          <div class="form-group">
		                			<div class="input-group">     
							{{ Form::text('target_url', '', array(
								'class' => 'form-control',
								'placeholder' => 'Target URL'
							)) }}
		              				<span class="input-group-btn">
		                					<button type="submit" class="btn"><span class="fui-plus"></span> Add Banner</button>
		              				</span>
		                			</div>
		              		</div>
		          		</div>
			</div>
	      	{{ Form::close() }}     


	          	@if($quick_assign)
	          		<div class="row">
				{{ Form::open(array('method' => 'put', 'url' => 'banners/assign')) }}
					<div class="quick-assign {{ (!$errors->has('quick_assign') && !$errors->has('number_of_credits') ? 'hidden' : '') }}"><br></div>
		          			<div class="col-xs-12" >
		          				<div class="quick-assign {{ (!$errors->has('quick_assign') && !$errors->has('number_of_credits') ? 'hidden' : '') }}">
							{{ $errors->first('quick_assign', '<br><p class="error">:message</p>') }}
							{{ $errors->first('number_of_credits', '<p class="error">:message</p>') }}
						</div>
					</div>
		          			<div class="col-xs-5" >
		          				<div class="form-group quick-assign {{ (!$errors->has('quick_assign') && !$errors->has('number_of_credits') ? 'hidden' : '') }}">
			          				{{ Form::select('quick_assign', $quick_assign, null, array(
								'class' => 'form-control',
								'placeholder' => 'Website URL'
							)) }}
						</div>
		          			</div>
		          			<div class="col-xs-4" >
					          <div class="form-group quick-assign {{ (!$errors->has('quick_assign') && !$errors->has('number_of_credits') ? 'hidden' : '') }}">
			                			<div class="input-group">     
								{{ Form::text('number_of_credits', '', array(
									'class' => 'form-control',
									'placeholder' => 'Number of Credits'
								)) }}
			                  				<span class="input-group-btn">
			                    					<button type="submit" class="btn"><span class="fui-plus"></span> Assign</button>
			                  				</span>
			                			</div>
			              		</div>
		          			</div>
		          			<div class="col-xs-3">
		          				<div class="right"><button class="btn btn-default" id="open-quick-assign">{{ (!$errors->has('quick_assign') && !$errors->has('number_of_credits') ? 'Open' : 'Close') }} Quick Assign</button></div>
		          			</div>
		          		{{ Form::close() }}    
	          		</div>
          		@endif
          		

	          	@if($banners->count() != 0)
	          		<br>
	        		<table class="table table-striped">
			           <tr>
			              	<th>Banner Image</th>
			              	<th>Status</th>
			              	<th>Views</th>
			              	<th>Credits</th>
			              	<th>Edit</th>
			              	<th>Stats</th>
			              	<th>Delete</th>
			           </tr>
			           @foreach($banners as $banner)
				           <tr>
				              	<td class="banner"><a href="{{ $banner->url }}" target="_blank" class="text-info"><img src="{{ $banner->banner }}" /></a></td>
				              	<td >{{ Form::open(array('method' => 'put','url' => 'banners/' . $banner->_id . '/toggle')) }}<a class="text-info" href="javascript:return false;" onclick="$(this).closest('form').submit()">{{ $banner->enabled ? 'Rotating' : 'Paused' }}</a>{{ Form::close() }}</td>
				              	<td>{{ $banner->views }}</td>
				              	<td>{{ $banner->credits }}</td>
				              	<td><a href="{{ url('banners', $banner->id) }}"><span class="fui-new text-info"></span></a></td>
				              	<td><a class="graph" href="{{ url('banners/graph', $banner->id) }}"><i class="fa fa-bar-chart-o text-info"></i></a></td>
				              	<td><a href="javascript:return false;" class="delete_website" name="{{ $banner->_id }}" link="{{ $banner->url }}" image="{{ $banner->banner }}"><span class="fui-cross text-info"></span></a></td>
				           </tr>
			           @endforeach
		          </table>

		@endif
	</div>
</section>
@stop

@section('footer')
	
	<script type="text/javascript">
	$(".delete_website").click(function() {
		$("#modal .modal-title").html('Delete Banner');
		$("#modal .modal-body p").html("Are you sure you want to delete the banner:<br><br><a target='_blank' href='" + $(this).attr('link') + "'><img src='" + $(this).attr('image') + "'/></a>" );
		$("#modal .modal-footer").html('{{ Form::open(array('method' => 'delete', 'url' => 'banners/id')) }}<a onclick="$(this).closest(\'form\').submit()" href="javascript:return false;" class="btn btn-default btn-wide">Continue</a>{{ Form::close() }} <a href="javascript:return false;" data-dismiss="modal" class="btn btn-wide btn-primary">Cancel</a>')
		$("#modal .modal-footer form").css("display", "inline-block");
		var action = $("#modal .modal-footer form").attr("action").replace('id', $(this).attr('name'));
		$("#modal .modal-footer form").attr("action", action);
		$("#modal .modal-footer .btn-primary").css("margin-left", "12px");
		$('#modal').modal();
	});

	$(".graph").click(function(e) {
		e.preventDefault();
		$("#modal .modal-title").html('Banner Stats');
		$("#modal .modal-body p").html("<iframe scrolling='no' style='border:none; width:100%; height: 300px; overflow:hidden;' src='" + $(this).prop("href") + "'/>" );
		$("#modal .modal-footer").html('<a href="javascript:return false;" data-dismiss="modal" class="btn btn-wide btn-primary">Close</a>')
		$('#modal').modal();
	});



	$("#open-quick-assign").click(function(e) {
		e.preventDefault();
		if($(this).html() == "Open Quick Assign") $(this).html("Close Quick Assign");
		else $(this).html("Open Quick Assign");
		$(".quick-assign").toggleClass("hidden");
	});
	</script>

@stop