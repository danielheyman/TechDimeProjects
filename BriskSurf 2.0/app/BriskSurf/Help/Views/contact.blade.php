@extends('templates.full')

@section('body')

	<section class="contacts-1">
		<div class="container">
			<div class="row">
				<div class="col-sm-8">
					<h3>We love what we do <br> And we are here to help you.</h3>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-6">
					<form>
						<label class="h6">Name / Last Name</label>
						<input type="text" class="form-control" value="{{ Auth::check() ? Auth::user()->name : '' }}">
						<label class="h6">E-mail</label>
						<input type="text" class="form-control" value="{{ Auth::check() ? Auth::user()->email : '' }}">
						<label class="h6">Message</label>
						<textarea rows="7" class="form-control"></textarea>
						<button type="submit" class="btn btn-primary"><span class="fui-mail"></span></button>
					</form>
				</div>
				<div class="col-sm-4 col-sm-offset-1">
					<div class="additional">
						<h6>Need Help?</h6>
						<p>Don’t hestiate to ask us something. You can checkout our <a href="{{ url('help/faq') }}">FAQ</a> and <a href="{{ url('help/tos') }}">TOS</a> page to get more information about our products.</p>
					</div>
					<div class="additional">
						<h6>Estimated Time</h6>
						<p>We're here to help in any way we can. Please submit your request below and we'll get back to you within the next day.</p>
					</div>
				</div>
			</div>
		</div>
	</section>

@stop