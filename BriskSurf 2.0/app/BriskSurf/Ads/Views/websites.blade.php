@extends('templates.full')

@section('header')

	{{ HTML::style('assets/css/in.websites.css') }}

@stop

@section('body')

<section class="content-33" style="padding: 60px 0;">
	<div class="container">

		<div class="alert alert-error">
	            	<center>You currently have {{ $user->credits }} credits left</center>
	          	</div>

	          	<br>

	          	{{ $errors->first('global', '<p class="error">:message</p><br>') }}
	      	{{ $errors->first('website', '<p class="error">:message</p><br>') }}

	          	<div class="row">
	          		<div class="col-xs-{{ $quick_assign ? 9 : 12 }}">
			          	{{ Form::open() }}
				          <div class="form-group">
		                			<div class="input-group">     
							{{ Form::text('website', '', array(
								'class' => 'form-control',
								'placeholder' => 'Website URL'
							)) }}
		                  				<span class="input-group-btn">
		                    					<button type="submit" class="btn"><span class="fui-plus"></span> Add Website</button>
		                  				</span>
		                			</div>
		              		</div>
		          		{{ Form::close() }}     
	          		</div>
	          		@if($quick_assign)
		          		<div class="col-xs-3">
		          			<div class="right"><button class="btn btn-default" id="open-quick-assign">{{ (!$errors->has('quick_assign') && !$errors->has('number_of_credits') ? 'Open' : 'Close') }} Quick Assign</button></div>
		          		</div>
	          		@endif
		</div>

		@if($quick_assign)
	          		<div class="row {{ (!$errors->has('quick_assign') && !$errors->has('number_of_credits') ? 'hidden' : '') }}" id="quick-assign">
				{{ Form::open(array('method' => 'put', 'url' => 'websites/assign')) }}
		          			<br>
		          			<div class="col-xs-12" >
						{{ $errors->first('quick_assign', '<p class="error">:message</p>') }}
						{{ $errors->first('number_of_credits', '<p class="error">:message</p>') }}
					</div>
		          			<div class="col-xs-6" >
		          				{{ Form::select('quick_assign', $quick_assign, null, array(
							'class' => 'form-control',
							'placeholder' => 'Website URL'
						)) }}
		          			</div>
		          			<div class="col-xs-6" >
					          <div class="form-group">
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
		          		{{ Form::close() }}    
	          		</div>
	          	@endif
          		

	          	@if($websites->count() != 0)
	          		<br>
	        		<table class="table table-striped">
			           <tr>
			              	<th>Website URL</th>
			              	<th>Status</th>
			              	<th>Views</th>
			              	<th>Credits</th>
			              	<th>Edit</th>
			              	<th>Stats</th>
			              	<th>AA</th>
			              	<th>Delete</th>
			           </tr>
			           @foreach($websites as $website)
				           <tr>
				              	<td class="website_url"><a href="{{ $website->url }}" target="_blank" class="text-info">{{ $website->url }}</a></td>
				              	<td>{{ Form::open(array('method' => 'put','url' => 'websites/' . $website->_id . '/toggle')) }}<a class="text-info" href="javascript:return false;" onclick="$(this).closest('form').submit()">{{ $website->enabled ? 'Rotating' : 'Paused' }}</a>{{ Form::close() }}</td>
				              	<td>{{ $website->views }}</td>
				              	<td>{{ $website->credits }}</td>
				              	<td><a href="{{ url('websites', $website->id) }}"><span class="fui-new text-info"></span></a></td>
				              	<td><a class="graph" href="{{ url('websites/graph', $website->id) }}"><i class="fa fa-bar-chart-o text-info"></i></a></td>
				              	<td>{{ $website->auto_assign }}%</td>
				              	<td><a href="javascript:return false;" class="delete_website" name="{{ $website->_id }}" link="{{ $website->url }}"><span class="fui-cross text-info"></span></a></td>
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
		$("#modal .modal-title").html('Delete Website');
		$("#modal .modal-body p").html("Are you sure you want to delete the website <a target='_blank' href='" + $(this).attr('link') + "'>" + $(this).attr('link') + "</a>?" );
		$("#modal .modal-footer").html('{{ Form::open(array('method' => 'delete', 'url' => 'websites/id')) }}<a onclick="$(this).closest(\'form\').submit()" href="javascript:return false;" class="btn btn-default btn-wide">Continue</a>{{ Form::close() }} <a href="javascript:return false;" data-dismiss="modal" class="btn btn-wide btn-primary">Cancel</a>')
		$("#modal .modal-footer form").css("display", "inline-block");
		var action = $("#modal .modal-footer form").attr("action").replace('id', $(this).attr('name'));
		$("#modal .modal-footer form").attr("action", action);
		$("#modal .modal-footer .btn-primary").css("margin-left", "12px");
		$('#modal').modal();
	});
	</script>
	{{ HTML::script('assets/js/in.websites.js') }}

@stop