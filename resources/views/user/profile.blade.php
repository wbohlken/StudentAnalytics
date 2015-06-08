@extends('app')

@section('content')
	<div class="container-fluid">

		<div class="row">
			<div class="container">
				<h1 style="text-align: center;">Profiel</h1>

				<div class="wijzigen-block">
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
					@if(Session::has('success'))
						<p class="alert alert-success"> {{ Session::get('success') }}</p>
					@elseif(Session::has('error'))
						<p class="alert alert-danger">{{ Session::get('error') }}</p>
					@endif
					<form class="form-horizontal" role="form" method="POST" action="{{ url('/profile') }}">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">

						<div class="form-group">
							<label class="col-md-4 control-label">Naam</label>

							<div class="col-md-6">
								<input type="text" class="form-control" name="name" value="{{ $user->name }}">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Studentnummer</label>

							<div class="col-md-6">
								<input type="text" class="form-control" name="student_nr" value="{{ $user->student_nr }}">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Email adres</label>

							<div class="col-md-6">
								<input type="email" class="form-control" name="email" value="{{ $user->email }}">
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button type="submit" class="btn btn-primary">
									Wijzig profiel
								</button>
							</div>
						</div>
					</form>
					<div class="password-edit-block">
						<div class="btn btn-primary password-edit">Wachtwoord wijzigen?</div>
						<div class="password-edit-fields">
							<form class="form-horizontal"/>

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
							<div class="btn btn-primary edit-password">Wijzig wachtwoord</div>

							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
	<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
	<script src="{{ asset('/js/main.js') }}"></script>
@endsection
