@extends('app')

@section('content')
	<div class="container">
		<a href="/"><div class="back btn">Terug naar dashboard overzicht</div></a>

		<div class="row">
				<h1>Registreer een nieuwe gebruiker</h1>
				<p style="text-align: center">Maak hier een nieuwe gebruiker aan voor het studentendashboard</p>
			@if(Session::has('success'))
				<div class="alert alert-success">
				<h2>{{ Session::get('success') }}</h2>
		</div>
		@endif
		@if(Session::has('error'))
			<div class="alert alert-error"">
			<h2>{{ Session::get('error') }}</h2>
	</div>
	@endif
				<div class="panel-body col-lg-6 col-md-6 col-lg-offset-3">
					@if (count($errors) > 0)
						<div class="alert alert-danger">
							<strong>Helaas!</strong> Er zijn een aantal problemen opgetreden.<br><br>
							<ul>
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					@endif


					<form class="form-horizontal" role="form" method="POST" action="{{ url('/register') }}">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">

						<div class="form-group">
							<label class="col-md-4 control-label">Naam</label>

							<div class="col-md-6">
								<input type="text" class="form-control" name="name" value="{{ old('name') }}">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Email adres</label>

							<div class="col-md-6">
								<input type="email" class="form-control" name="email" value="{{ old('email') }}">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Wachtwoord</label>

							<div class="col-md-6">
								<input type="password" class="form-control" name="password">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Bevestig Wachtwoord</label>

							<div class="col-md-6">
								<input type="password" class="form-control" name="password_confirmation">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Admin?</label>

							<div class="col-md-6">
								<input type="checkbox" name="admin" value="1">
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button type="submit" class="btn btn-primary">
									Registreren
								</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
@endsection
