@extends('app')

@section('content')
<div class="container-fluid">
    <div class="container">
        <a href="/"><div class="back btn">Terug naar dashboard overzicht</div></a>

        <div class="row">

            <h1>Studenten dashboard</h1>
            <div class='row'>

                <div class="filter-box">
                    <form method="get" action="/studentdashboard">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group">
                            <select name="studentnumber" class="form-control studentnumber-search">
                                <option value="">Studentnummer</option>
                                @foreach ($studentnumbers as $number) 
                                <option  value="{{ $number }}">{{ $number }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-default">Zoek</button>

                    </form>
                </div>

            </div>

            <div role="tabpanel">

                <!-- Nav tabs -->
                <ul class="nav nav-tabs tab nav-justified nav-pills" role="tablist">
                    @for ($i = 1; $i < 9; $i++)
                    <li role="presentation"  class="disabled"><a href="#" aria-controls="home" role="tab" data-toggle="tab" >Week {{$i}}</a></li>
                    @endfor
                </ul>
                <div id="ajax-panel">
                    @if(Session::has('error'))
                        <div class="alert alert-danger"">
                        <h2>{{ Session::get('error') }}</h2>
                </div>
                @endif
                    <!-- Tab panes -->
                    <div class="tab-content" >
                        <div class="dashboard-no-found">Geen resultaat. Zoek een student door op studentnummer te zoeken.</div>
                    </div>
                </div>

            </div>


        </div>
    </div>
</div>
@endsection
