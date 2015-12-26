@extends('admin::templates.full')

@section('header')
	{{ HTML::style('assets/css/admin/settings.css') }}
@stop

@section('body')

	<div class="selectionWrap"><select id="selection">
		@foreach($settings as $s)
			<option {{ (Session::get('page') == $s->_id || (Session::get('page') == false && $s->_id == "main")) ? 'selected' : '' }} value='{{ $s->_id }}'>{{ str_replace("_", " ", $s->_id) }}</option>
		@endforeach
	</select></div>
	<br>

	@foreach($settings as $s)
		<div class="hidden" name="{{ $s->_id }}">
			<input name="id" type="hidden" value="{{ $s->_id }}">
			<table class="table">
				<thead>
			              	<tr>
			                		<th>Key</th>
			                		<th>Value</th>
			              	</tr>
		            	</thead>
				<tbody>
					@foreach($s['attributes'] as $key => $a)
						@if(gettype($a) != "object" && $key != "_id")
							<tr>
								<td>{{ str_replace("_", " ", $key) }}</td>
								<td>
									@if($key == "_id")
										{{ $a }}
									@elseif(is_string($a) || is_numeric($a))
										<input name="{{ $key }}" type="text" value="{{ $a }}">
									@elseif(is_bool($a))
										<select name="{{ $key }}">
											<option value="true" {{ ($a) ? 'selected' : '' }}>True</option>
											<option value="false"{{ (!$a) ? 'selected' : '' }}>False</option>
										</select>
									@else
										@foreach($a as $k => $v)
											<div class="{{ (is_string($v) && strlen($v) >= 50) ? '' : 'key' }} array">{{ str_replace("_", " ", $k) }}: </div>
											@if(is_string($v) || is_numeric($v))
												@if(strlen($v) < 50)
													<input class="array" name="array__{{ $key }}__{{ $k }}" type="text" value="{{ $v }}"><br>
												@else
													<textarea name="array__{{ $key }}__{{ $k }}">{{ $v }}</textarea><br>
												@endif
											@elseif(is_bool($v))
												<select class="array" name="array__{{ $key }}__{{ $k }}">
													<option value="true" {{ ($v) ? 'selected' : '' }}>True</option>
													<option value="false"{{ (!$v) ? 'selected' : '' }}>False</option>
												</select><br>
											@endif
										@endforeach
									@endif
								</td>
							</tr>
						@endif
					@endforeach
					<tr>
						<td></td>
						<td><input type="submit" value="Update"></td>
					</tr>
				</tbody>
			</table>
		</div>
	@endforeach
		
	<div id="text">
		{{ Form::open() }}
			Loading...
		{{ Form::close() }}
	</div>

@stop

@section('footer')
	{{ HTML::script('assets/js/admin/jquery.elastic.source.js') }}
	{{ HTML::script('assets/js/admin/settings.js') }}
@stop