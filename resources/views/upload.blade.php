@extends('app')

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-10 col-md-offset-1">
				<div class="panel panel-default">
					<div class="panel-heading">Upload file</div>

					@if(Session::has('success'))
						<div class="alert-box success">
							<p>{!! Session::get('success') !!}</p>
						</div>
					@endif
					@if(Session::has('error'))
						<p class="errors">{!! Session::get('error') !!}</p>
					@endif

					<div class="panel-body">
						{!! Form::open(array('files' => TRUE, 'method' => 'POST')) !!}
						{!! Form::file('file') !!}
						{!! Form::submit('Submit') !!}
						{!! Form::close() !!}
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection