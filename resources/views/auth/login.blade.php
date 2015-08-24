@extends('auth')

@section('content')
  <div class="container-fluid">
      
	<div class="row">
			<div class="panel login panel-default">
				<div class="panel-heading">Studenten Dashboard Login</div>
				<div class="panel-body">
					@if (count($errors) > 0)
						<div class="alert alert-danger">
							
								@foreach ($errors->all() as $error)
									{{ $error }}
								@endforeach
							
						</div>
					@endif

					<form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">

						<div class="form-group">
							<label class="col-md-3 control-label">E-mail</label>
							<div class="col-md-8">
								<input type="email" class="form-control" name="email" value="{{ old('email') }}">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-3 control-label">Wachtwoord</label>
							<div class="col-md-8">
								<input type="password" class="form-control" name="password">
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-11">
								<div class="col-md-3">

								</div>
								<div class="col-md-8"><button type="submit" class="btn btn-primary login-btn">Login</button></div>

								<a class="forgot-password btn-link" href="{{ url('/password/email') }}">Wachtwoord vergeten?</a>
							</div>
						</div>
					</form>
				</div>
			</div>
	</div>
</div>
@endsection
