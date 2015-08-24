@extends('app')

@section('content')
<div class="container-fluid">
    <div class="container">
        <a href="/"><div class="back btn">Terug naar dashboard overzicht</div></a>
        <div class="row">
            <h1>Dashboards versturen</h1>

            @if(Session::has('success'))
                <div class="alert alert-success"">
                    <h2>{{ Session::get('success') }}</h2>
                </div>
            @endif
            <div class='row'>
                {{--<div class="filter-box dashboard-filter">--}}
                    {{--<form method="get" action="/studentdashboard">--}}

                        {{--<input type="hidden" name="_token" value="{{ csrf_token() }}">--}}
                        {{--<div class="form-group">--}}
                            {{--<select name="studentnumber" class="form-control">--}}
                                {{--<option value="">Studentnummer</option>--}}
                                {{--@foreach ($studentnumbers as $number)--}}
                                {{--<option  value="{{ $number }}">{{ $number }}</option>--}}
                                {{--@endforeach--}}
                            {{--</select>--}}
                        {{--</div>--}}
                        {{--<button type="submit" class="btn btn-default">Zoek</button>--}}



                    {{--</form>--}}
                {{--</div>--}}
                @if(Session::has('success'))
                        <p class="alert alert-success"> {{ Session::get('success') }}</p>
                @elseif(Session::has('error'))
                        <p class="alert alert-danger">{{ Session::get('error') }}</p>
                @endif

                <div class="general-box col-md-5 col-lg-5  @if(Auth::user()->isAdmin()) @else alignmiddle @endif ">
                    <h2><b>LET OP! Stappenplan voor versturen</b></h2>
                <h2 style="text-align:left;">1. Staat alle relevante week voor de desbetreffende week in de database?</h2>
                    <h2 style="text-align:left;">2. Er wordt naar {{ $countUsers }} studenten een mail gestuurd.</h2>
                    <table class="versturen">
                    @for ($i = 1; $i < 9; $i++)
                    <tr>
                    <td class="general-box-first">Week {{$i}} </td>
                    <td>@if(in_array($i,$allweeks))<div class='btn btn-primary' disabled>Verzonden</div>@else<a href='/fireweekoverview?week={{$i}}'><div class='btn btn-primary'>Verstuur</div></a>@endif</td>
                    </tr>
                    @endfor
                    </table>
                    </div>


            </div>




        </div>
    </div>
</div>
@endsection
