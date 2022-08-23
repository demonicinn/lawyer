@if ($message = Session::get('success'))
<div class="container alert-message">
	<div class="row">
		<div class="col-md-12">
			<div class="alert alert-success alert-dismissible fade show" style="text-align: center;" role="alert">
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				<strong>{!! $message !!}</strong>
			</div>
		</div>
	</div>
</div>
@endif

@if ($message = Session::get('error'))
<div class="container alert-message">
	<div class="row">
		<div class="col-md-12">
			<div class="alert alert-danger alert-dismissible fade show" style="text-align: center;" role="alert">
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				<strong>{!! $message !!}</strong>
			</div>
		</div>
	</div>
</div>
@endif

@if ($message = Session::get('warning'))
<div class="container alert-message">
	<div class="row">
		<div class="col-md-12">
			<div class="alert alert-warning alert-dismissible fade show" style="text-align: center;" role="alert">
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				<strong>{!! $message !!}</strong>
			</div>
		</div>
	</div>
</div>
@endif

@if ($message = Session::get('info'))
<div class="container alert-message">
	<div class="row">
		<div class="col-md-12">
			<div class="alert alert-info alert-dismissible fade show" style="text-align: center;" role="alert">
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				<strong>{!! $message !!}</strong>
			</div>
		</div>
	</div>
</div>
@endif