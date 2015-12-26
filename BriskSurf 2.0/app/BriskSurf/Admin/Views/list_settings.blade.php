@extends('admin::templates.full')


@section('header')
	{{ HTML::style('assets/css/admin/lists.css') }}
@stop

@section('body')
	@if($list != "new" && ($list->status == "process" || $list->status == "processing"))
		<p>The list is processing. You cannot make any changes. Try refreshing in a couple of seconds</p>
	@else
		@if($list != 'new') <button class="right" id="delete">Delete</button> @endif
		<button class="right" id="save">Save</button>
		{{ Form::open(array('id' => 'saveform')) }}
			Name: <input class="name" placeholder="Enter a name" type="text" value="{{ ($list == 'new') ? '' : $list->name }}" name="name">
			<input type="hidden" name="data" value="">
		{{ Form::close() }}
		<br>

		{{ Form::open(array('id' => 'deleteform', 'method' => 'delete')) }} {{ Form::close() }}

		<div id="action_data">
			<p class="second">Users who:</p>
			<select class="performed"><option>have</option><option>have not</option></select> performed the action
			<br><br>
			<select class="field">@foreach($actions as $action)<option>{{ $action }}</option>@endforeach</select>
			<br><br>
			at least <input class="value frequency" type="text" value="1"></td> times
			<br><br>
			<select class="within"><option>since signing up</option><option>within the past</option>
			</select>
			<input class="value within_value" type="text">
			<div class="info"></div>
		</div>

		<div id="attribute_data">
			<p class="second">Users where:</p>
			<select class="field">@foreach($attributes as $attribute => $type)<option type="{{ $type }}" value="{{ $attribute }}">{{ $attribute }}</option>@endforeach</select>
			<select class="comparison"><option>is a timestamp after</option></select>
			<input class="value" type="text"></td>
			<div class="info"></div>
		</div>

		@if($list != "new")
			@foreach($list->data as $and)
				<div class="options">
					@foreach($and as $or)
						<div class="section {{ $or['type'] }}">
							<div class="title"><div class="desc">loading...</div><a class="delete" href="javascript:void();">delete</a></div>
							<div class="inner">
								<p>Filter users by:</p>
								<select class="type">
									<option value="attribute" {{ $or['type'] == "attribute" ? 'selected' : '' }}>Attribute</option>
									<option value="action" {{ $or['type'] == "action" ? 'selected' : '' }}>Action</option>
								</select>
								<div class="data">
									@if($or['type'] == "attribute")
										<p class="second">Users where:</p>
										<select class="field">
											@foreach($attributes as $attribute => $type)
												<option type="{{ $type }}" value="{{ $attribute }}"  {{ $or['field'] == $attribute ? 'selected' : '' }}>{{ $attribute }}</option>
											@endforeach
										</select>
										<select class="comparison" default="{{ $or['comparison'] }}">
											<option>is a timestamp after</option>
										</select>
										<input class="value" type="text" default="{{ $or['value'] }}"></td>
										<div class="info"></div>
									@else
										<p class="second">Users who:</p>
										<select class="performed"><option {{ $or['performed'] ? 'selected' : '' }}>have</option><option {{ !$or['performed'] ? 'selected' : '' }}>have not</option></select> performed the action
										<br><br>
										<select class="field">@foreach($actions as $action)<option {{ $or['field'] == $action ? 'selected' : '' }}>{{ $action }}</option>@endforeach</select>
										<br><br>
										at least <input class="value frequency" type="text" value="{{ $or['frequency'] }}"></td> times
										<br><br>
										<select class="within"><option {{ $or['within'] == "start" ? 'selected' : '' }}>since signing up</option><option {{ $or['within'] != "start" ? 'selected' : '' }}>within the past</option>
										</select>
										<input class="value within_value" type="text" default="{{ $or['within'] == 'start' ? '' : $or['within'] }}">
										<div class="info"></div>
									@endif
								</div>
							</div>
						</div>
					@endforeach
					<div class="or">+ OR Filter</div>
				</div>
			@endforeach
		@endif

		<button class="and">+ AND Filter</button>
	@endif

	<br><br><br>
	<br><br><br>

@stop


@section('footer')

	{{ HTML::script('assets/js/admin/lists.js') }}

	@if($list == 'new')
		<script type="text/javascript">
			$(".and").click();
		</script>
	@endif

@stop