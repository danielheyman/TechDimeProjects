@extends('admin::templates.full')

@section('header')
	{{ HTML::style('assets/css/admin/history.css') }}
@stop

@section('body')

<div class="history">
	{{ Form::open() }}
	<div class="green">Events</div>
	<div class="blue">::</div>
	<div class="red">get</div>( array(<br>
	<div class="item">
		<div class="red">'start'</div> =>  
		{{ Form::text('start', Carbon::now()->subWeek()->format('Y/m/d H:i'), array(
	                     'class' => "datetime"
	           )) }}
	</div>
	<div class="item">
		<div class="red">'end'</div> => 
		{{ Form::text('end', Carbon::now()->format('Y/m/d H:i'), array(
	                     'class' => "datetime"
	           )) }}
	</div>
	<div class="item">
		<div class="red">'type'</div> =>  
		{{ Form::select('type', array(
			'counter' => 'Counter', 
			'action' => 'Action'
		)) }}
	</div>
	<div class="item">
		<div class="red">'person'</div> =>  
		{{ Form::select('user', array(

		)) }}
	</div>
	<div class="item user">
		<div class="red">'user'</div> => 
		{{ Form::text('user2', '', array(
	                    'placeholder' => 'danielheyman'
	           )) }}
	</div>
	<div class="item">
		<div class="red">'event'</div> =>  
		{{ Form::select('type2', array(

		)) }}
	</div>
	<div class="item conditions">
		<div class="red">'conditions'</div> => array(<br>
			@for($x = 0; $x<5; $x++)
			<div class="item">
				{{ Form::select('condition_field' . $x, array(

				), null, array(
			                    'class' => 'condition',
			           )) }}
				{{ Form::text('condition_operator' . $x, '', array(
			                    'placeholder' => '=',
			                    'data-autosize-input' => '{ "space": 5 }'
			           )) }}
				{{ Form::text('condition_value' . $x, '', array(
			                    'placeholder' => 'value',
			                    'data-autosize-input' => '{ "space": 5 }'
			           )) }}
			</div>
			@endfor
		)
	</div>
	<div class="item graph">
		<div class="red">'graph'</div> => 
		{{ Form::select('graph', array(

		)) }}
	</div>
	<div class="item">
		<div class="red">'sort'</div> => 
		{{ Form::text('sort', '', array(
	                    'placeholder' => 'created_at'
	           )) }}
	</div>
	));<br>
	<input type="submit" value="Submit">
	{{ Form::close() }}
</div>

@if( Session::get('records') !== null )
	<div class="records">
		@if( count(Session::get('records')) == 0 )
			No records found
		@else
			<div class="selectionWrap"><select id="selection">
				<option>Hourly</option>
				<option selected>Daily</option>
			</select></div>
			<div class="chartWrapper"><div id="chart"></div></div>
			@foreach(Session::get('records') as $record)
				<div class="record">
					<div class="green">ID</div>: <a href="{{ url('admin/users/' . $record->user_id) }}"><div class="blue">{{ $record->user_id }}</div></a>
					<div class="green">User</div>: <a href="{{ url('admin/users/' . $record->user_id) }}"><div class="blue">{{ $record->username }}</div></a>
					<div class="green">Type</div>: <div class="blue"> {{ $record->type }}</div>
					<br>
					@foreach((array) $record->data['attributes'] as $key => $attr)
						<div class="option">
							<div class="red graph_sort">{{$key }}</div> => 
							<div class="graph_value">
								@if(is_string($attr) || (is_numeric($attr)))
									{{ $attr }}
								@elseif(gettype($attr) == "object")
									{{ $record->data->{$key}  }}
								@else
									{{ print_r($attr) }}
								@endif
							</div>
						</div>
					@endforeach
				</div>
			@endforeach
		@endif
	</div>
@endif
	
<span id="width_tmp"></span>

@stop

@section('footer')
	<script type="text/javascript">
		var events = {{ json_encode($events) }};

		var type = '';
		var user = '';
		var type2 = '';
		var default_user = '{{ Input::old('user') }}';
		var default_type2 = '{{ Input::old('type2') }}';
		var default_graph = '{{ Input::old('graph') }}';
		var default_condition_field = [];
		default_condition_field[0] = '{{ Input::old('condition_field0') }}';
		default_condition_field[1] = '{{ Input::old('condition_field1') }}';
		default_condition_field[2] = '{{ Input::old('condition_field2') }}';
		default_condition_field[3] = '{{ Input::old('condition_field3') }}';
		default_condition_field[4] = '{{ Input::old('condition_field4') }}';
		function init_select() {
			var value = $('select[name=type]').val();
			var options = events[value];
			if(type != value)
			{
				type = value;
				$('select[name=user]').html('');
				for(var key in options)
				{
					var selected = (key == default_user) ? ' selected' : '';
					$('select[name=user]').append('<option value=' + key + selected + '>' + caps(key) + '</option>');
				}
			}
			var value = $('select[name=user]').val();
			var options = options[value];
			var show_conditions = true;
			if(user != value)
			{
				user = value;
				if(value == "user") $('.history .item.user').show();
				else $('.history .item.user').hide();

				$('select[name=type2]').html('');
				for(var key in options)
				{
					if(!isNaN(key))
					{
						key = options[key];
						show_conditions = false;
					}
					var selected = (key == default_type2) ? ' selected' : '';
					$('select[name=type2]').append('<option value=' + key + selected + '>' + caps(key) + '</option>');
				}
			}
			if(show_conditions)
			{
				$('.history .item.conditions').show();
				$('.history .item.graph').show();

				var value = $('select[name=type2]').val();
				var options = options[value];
				if(type2 != value)
				{
					type2 = value;
					$('select.condition').html('');
					$('select[name=graph]').html('<option value="">Instances</option>');
					for(var key in options)
					{
						var selected = (key == default_graph) ? ' selected' : '';
						if(options[key] == "number") $('select[name=graph]').append('<option value=' + key + selected + '>' + caps(key) + '</option>');

						$('select.condition').append('<option value=' + key + '>' + caps(key) + '</option>');
					}
					var count = 0;

					$('select.condition').each(function(){
						$(this).find("option[value=" + default_condition_field[count] + "]").attr("selected", "selected");
					    	count++;


					    	$("#width_tmp").html($(this).val());
					    	$(this).width($("#width_tmp").width()+30);
					 });
				}
			}
			else
			{
				$('.history .item.conditions').hide();
				$('.history .item.graph').hide();
			}
		}

		$('select[name=type]').change(function() {
			init_select();
		});

		$('select[name=user]').change(function() {
			init_select();
		});

		$('select[name=type2]').change(function() {
			init_select();
		});

		function caps(string)
		{
		    	return string.charAt(0).toUpperCase() + string.slice(1);
		}

		init_select();

		$('select.condition').change(function(){
		    	$("#width_tmp").html($(this).val());
		    	$(this).width($("#width_tmp").width()+30); 
		 });
	</script>

	@if( Session::get('hourly') && count(Session::get('records')) != 0 )

		<script type="text/javascript">
			$(".graph_sort").click(function() {
				var sort = $(this).html();
				//alert("The sort type has been changed to " + sort + ". Click submit to redraw.");
				$("input[name=sort]").val(sort);
			});

			$("#selection").change(function() {
				init();
			});

			google.setOnLoadCallback(init);

			function init() {
				$("#chart").show();
				var labels = ["Amount"];
				var points = [];
				if($("#selection").val() == "Hourly") points.push('{{  Session::get('hourly')  }}');
				else points.push('{{  Session::get('daily')  }}');
				drawChart(labels, points, 'none');
			}
		</script>
	@endif
@stop