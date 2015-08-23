@extends('app')

@section('content')
<div class="container-fluid">
    <div class="container">
        <a href="/"><div class="back btn">Terug naar dashboard overzicht</div></a>
        <div class="row">
            <h1>Algemene Informatie</h1>

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

                        <table>
                            <tr>
                                <td class="general-box-first">Laatst geuploade data</td>
                                <td>@if($dateLastCSVdata !== ''){{ $dateLastCSVdata }}@else Geen @endif</td>
                            </tr>
                            <tr>
                                <td class="general-box-first">Aantal studenten</td>
                                <td>@if($countStudents == 0)<a href='/createstudents'><div class='btn btn-info'>Maak studenten</div></a>@else{{ $countStudents }}@endif</td>
                            </tr>
                            <tr>
                                <td class="general-box-first">Aantal gebruikers</td>
                                <td>{{ $countUsers }}</td>
                            </tr>
                            <tr>
                                <td class="general-box-first">Aantal admins</td>
                                <td>{{ $countAdmins }}</td>
                            </tr>
                            <tr>
                                <td class="general-box-first">Laatst verstuurde week</td>
                                <td>@if($sendWeek !== '') Week {{ $sendWeek }} @else Geen @endif</td>
                            </tr>
                            @if($sendWeek !== '')<tr>
                                <td class="general-box-first">Verstuurde datum week {{ $sendWeek }}</td>
                                <td>@if($dateSendWeek !== '') {{ $dateSendWeek }} @else Geen @endif</td>
                            </tr>

                            <tr>
                                <td class="general-box-first">Aantal geopende dashboards in week {{ $sendWeek }}</td>
                                <td>{{ $countOpened }}</td>
                            </tr>
                            @endif


                        </table>
                    </div>
                {{--@if(Auth::user()->isAdmin())--}}
                {{--<div class="panel panel-default week-box col-md-3 col-lg-3 col-lg-offset-2 right">--}}
                    {{--<div class="panel-heading">--}}
                        {{--<h3 class="panel-title">Verstuur weekdashboards</h3>--}}
                    {{--</div>--}}
                    {{--<div class="panel-body">--}}
                        {{--<table>--}}
                            {{--@for ($i = 1; $i < 9; $i++)--}}
                            {{--<tr>--}}
                                {{--<td class="general-box-first">Week {{$i}} </td>--}}
                                {{--<td>@if(in_array($i,$allweeks))<div class='btn btn-success' disabled>Verzonden</div>@else<a href='/fireweekoverview?week={{$i}}'><div class='btn btn-success'>Verstuur</div></a>@endif</td>--}}
                            {{--</tr>--}}
                            {{--@endfor--}}
                        {{--</table>--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--@endif--}}

            </div>




        </div>
    </div>
</div>
@endsection
