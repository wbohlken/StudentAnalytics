@extends('app')

@section('content')
<div class="container-fluid">
    <div class="container">
        <a href="/"><div class="back btn">Terug naar dashboard overzicht</div></a>

        <div class="row">

            <h1>Studenten dashboard @if($student) #{{ $student['studnr_a'] }} @endif</h1>
            <div class='row'>
                @if(Auth::user()->isAdmin())
                <div class="filter-box">
                    <form method="get" action="/studentdashboard">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group">
                            <select name="studentnumber" class="form-control studentnumber-search">
                                <option value="">Studentnummer</option>
                                @foreach ($studentnumbers as $number)

                                <option @if($number == $studentnumber)selected="selected"@endif  value="{{ $number }}">{{ $number }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-default">Zoek</button>

                    </form>
                </div>
                @if($student)
                <div class="col-lg-5 col-md-5 right information-box">
                    <div class="panel-body">
                        <table class="personal-info">
                            <tr>
                                <td class='title-table'>Studentnummer</td>
                                <td>{{$student->studnr_a}}</td>
                            </tr>
                            <tr>
                                <td class='title-table'>Cohort Jaar</td>
                                <td>{{$student->cohort_year }}</td>
                            </tr>
                            <tr>
                                <td class='title-table'>Cohort Blok</td>
                                <td>{{$student->cohort_block}}</td>
                            </tr>
                            <tr>
                                <td class='title-table'>Vooropleiding profiel</td>
                                <td>@if(count($student->vooropl_profiel)){{$student->vooropl_profiel->name }}@endif</td>
                            </tr>
                            <tr>
                                <td class='title-table'>Profiel</td>
                                <td>{{$student->profile }}</td>
                            </tr>
                            <tr>
                                <td class="title-table">Richting</td>
                                <td>@if(count($student->direction)){{$student->direction->name }}@endif</td>
                            </tr>
                            <tr><td class="title-table">Mail ontvangen</td>
                                <td>@if(count($student->user)) Ja @else Nee @endif</td>
                            </tr>
                            <tr><td class="title-table">Keer deze week geopend</td>
                                <td>{{ $student->getAmountLoggedIn($weekOverview['week_id']) }}</td>
                            </tr>
                            <tr><td class="title-table">Keer totaal geopend</td>
                                <td>{{ $student->getAmountLoggedIn() }}</td>
                            </tr>
                            <tr><td class="title-table">Laatst actief op dashboard</td>
                                <td>@if($student->getLastLogin()){{ $student->getLastLogin() }}@else - @endif</td>
                            </tr>
                        </table>
                        <a href="{{ url('/dashboard-history?studentnumber=' . $student->studnr_a .'&week=&vooropl=')}}"><div class="btn btn-primary" style="margin-top:10px;">Bekijk de dashboard geschiedenis van student #{{$student['studnr_a']}}</div></a>
                    </div>
                </div>
                    @endif
                @endif
                <div class="col-lg-5 col-md-5 col-lg-offset-2 prediction-box">
                    <div class="col-lg-6 col-md-6">
                        <div class="row">
                        <h2>Je verwachte cijfer</h2>
                        <div id="graph-grade" data-attr="{{ $weekOverview['estimated_grade']   }}" style="width:100%; float:left; height:150px;"></div>
                        </div>
                        <div class="row">
                        <h2>Gemiddeld verwacht cijfer</h2>
                            <div id="graph-averagegrade" data-attr="{{ $averageResults['AverageGrade'] }}" style="width:100%; float:left; height:150px;">                        </div>
                        </div>
                        <div class="btn btn-progression2" data-toggle="modal" data-target="#voortgang">Bekijk hier je voortgang</div>

                    </div>
                    <div class="col-lg-6 col-md-6">
                        {{--<div id="graph-risk" data-attr="{{ number_format($weekOverview['estimated_risk'] * 100,2) }}" style="width:100%; height:150px;"></div>--}}

                        <div id="traffic-light" data-attr="{{ $weekOverview['estimated_passed'] }}">
                            <div id="stopLight" class="bulb"></div>
                            <div id="slowLight" class="bulb"></div>
                            <div id="goLight" class="bulb"></div>
                        </div>
                    </div>
                    <span class="predicted-text">We voorspellen dat je het @if($weekOverview['estimated_passed'] == 'yes')<span class="wel">WEL</span> @else <span class="niet">NIET</span> @endif  haalt met een zekerheid van @if($weekOverview['estimated_passed'] == 'yes'){{  number_format($weekOverview['estimated_risk'] * 100 , 2) }}% @else {{ 100 - number_format($weekOverview['estimated_risk'] * 100, 2) }}% @endif</ps>
                        
                    </div>
                </div>
            </div>

            <div role="tabpanel">

                <!-- Nav tabs -->
                <ul class="nav nav-tabs tab nav-justified nav-pills" role="tablist">
                    @for ($i = 1; $i < 9; $i++)
                    <li role="presentation" @if($i == $week)class="active" @endif @if(!Auth::user()->isAdmin()) @if(!in_array($i, $sentweeks)) class="disabled" @endif @endif><a href="{{ URL::to(URL::full() . '&week=' . $i)  }}" aria-controls="home" @if($i == $week) role="tab" data-toggle="tab" @endif>Week {{$i}}</a></li>
                    @endfor
                </ul>
                <div id="ajax-panel">
                    <!-- Tab panes -->

                    <div class="tab-content" >
                        <script type="text/javascript" src="https://www.google.com/jsapi"></script>
                        @if($weekOverview)
                        <div role="tabpanel" class="tab-pane active" id="home">
                            <div class="progress-box">
                                <h3 class="total"> Totale voortgang deze week</h3>
                                <div class="progress progress-striped">
                                    <div class="progress-bar progress-bar-custom" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width:{{ $mainResults['TotalResult']}}%">
                                        <p>{{ $mainResults['TotalResult']}}% voltooid</p>
                                    </div>
                                </div>
                                <input type="hidden" id="week" value="{{ $week }}">
                                <div id="progressgrade" data-attr="{{ $progressgrade }}">
                                <div class="col-lg-12 col-md-12 head-graphs">
                                    <div class="moodle-box col-lg-6 col-md-6">
                                        <h1>Moodle</h1>
                                        @if($week !== '7' and $week !== '8')
                                            <div class="col-lg-6 col-md-6 moodle-prac" data-attr="{{ $mainResults['MoodleResult']['pracGrade'] }}">
                                                <h2>Practicum</h2>
                                                @if(is_null($mainResults['MoodleResult']['pracGrade']))
                                                    <div id="prac-light" class="bulb"></div>
                                                @else
                                                    <div id="prac-light" class="bulb"></div>
                                                @endif
                                            </div>
                                            <div class="col-lg-6 col-md-6 moodle-quiz">
                                                <div class="row">
                                                    <h2>Quiz</h2>
                                                    <div class="col-lg-6 col-md-6">
                                                        <h3>Jouw cijfer</h3>
                                                        <div class="counter">{{ $mainResults['MoodleResult']['quizGrade'] }}</div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6">
                                                        <h3>Gem. cijfer</h3>
                                                        <div class="counter">{{ $averageResults['MoodleResult']['averageQuiz'] }}</div>
                                                    </div>
                                                </div>

                                            </div>
                                        @else
                                            <h2>Oefen toets</h2>
                                            <div class="col-lg-6 col-md-6">
                                                <h3>Jouw cijfer</h3>
                                                <div class="counter">{{ $mainResults['MoodleResult']['quizGrade'] }}</div>
                                            </div>
                                            <div class="col-lg-6 col-md-6">
                                                <h3>Gem. cijfer</h3>
                                                <div class="counter">{{ $averageResults['MoodleResult']['averageQuiz'] }}</div>
                                            </div>
                                        @endif
                                    </div>



                                    <div class="col-md-6 col-lg-6 mplbox">
                                        <h1>MyProgrammingLab</h1>
                                        @if($week !== '7')
                                            <div class="col-lg-6 col-md-6">
                                                <h2>Voltooid</h2>
                                                <div data-amount="{{ $mainResults['MPLresult']['MMLMastery'] }}" data-average="{{ $averageResults['MPLresult']['averageMastery'] }}" id="mpl_graph"></div>
                                            </div>
                                            <div class="col-lg-6 col-md-6">
                                                <h2>Pogingen</h2>
                                                <div class="col-lg-6 col-md-6 mplattempts" >
                                                    <h3>Jouw Pogingen</h3>
                                                    <div class="counter">{{ $mainResults['MPLresult']['MMLAttempts'] }}</div>
                                                </div>
                                                <div class="col-lg-6 col-md-6">
                                                    <h3>Gem. pogingen</h3>
                                                    <div class="counter">{{ $averageResults['MPLresult']['averageAttempts'] }}</div>
                                                </div>
                                            </div>
                                        @else
                                            <h3 style="text-align:center;">Er zijn van deze week geen gegevens van MyProgrammingLab</h3>
                                        @endif

                                    </div>
                                </div>


                            </div>

                        </div>
                        @else
                            <div role="tabpanel" class="tab-pane active" id="home">
                                <h2>Helaas, we hebben nog geen weekdashboard van deze student</h2>
                                </div>
                                @endif
                    </div>

                </div>

            </div>


        </div>
    </div>
</div>
<div class="modal fade" id="voortgang" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Jouw voortgang (verwachte cijfer)</h4>
            </div>
            <div class="modal-body">
                <div class="voortgang"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Sluiten</button>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@endsection
