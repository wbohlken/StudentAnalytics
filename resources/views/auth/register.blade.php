@extends('auth')

@section('content')
	<div class="container-fluid">
		<div class="row">
			<div class="panel panel-default registreren">
				<div class="panel-heading">Registeren voor het Studenten Dashboard <span style="float:right; display:block;"> Terug naar <a
										href="{{ url('/auth/login') }}">Inlogpagina</a></span></div>
				<div class="panel-body">
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

					<form class="form-horizontal" role="form" method="POST" action="{{ url('/auth/register') }}">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">

						<div class="form-group">
							<label class="col-md-4 control-label">Naam</label>

							<div class="col-md-6">
								<input type="text" class="form-control" name="name" value="{{ old('name') }}">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Studentnummer</label>

							<div class="col-md-6">
								<input type="text" class="form-control" name="student_nr" value="{{ old('student_nr') }}">
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
