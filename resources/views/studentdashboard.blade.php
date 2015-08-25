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
                            <tr><td class="title-table">Mail ontvangen</td>
                                <td>Ja</td>
                            </tr>
                            <tr><td class="title-table">Aantal keer geopend</td>
                                <td>10</td>
                            </tr>
                        </table>
                        <a href="{{ url('/dashboard-history?studentnumber=' . $student->studnr_a .'&week=&vooropl=')}}"><div class="btn btn-primary" style="margin-top:10px;">Bekijk de dashboard geschiedenis van student #{{$student['studnr_a']}}</div></a>
                    </div>
                </div>
                    @endif
                @endif
                <div class="col-lg-5 col-md-5 col-lg-offset-2 prediction-box">
                    <div class="col-lg-6 col-md-6">
                        <h2>Je verwachte cijfer</h2>
                        <div id="graph-grade" data-attr="{{ $weekOverview['estimated_grade']   }}" style="width:50%; float:left; height:150px;"></div>

                        <h2>Gemiddeld verwacht cijfer</h2>
                        <div id="graph-risk" data-attr="{{ $mainResults['AverageGrade'] }}" style="width:50%; float:left; height:150px;"></div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <h2>Zekerheidspercentage</h2>
                        {{--<div id="graph-risk" data-attr="{{ number_format($weekOverview['estimated_risk'] * 100,2) }}" style="width:100%; height:150px;"></div>--}}

                        <div id="traffic-light" data-attr="{{ number_format($weekOverview['estimated_risk'] * 100,2) }}">
                            <div id="stopLight" class="bulb"></div>
                            <div id="slowLight" class="bulb"></div>
                            <div id="goLight" class="bulb"></div>
                        </div>
                    </div>
                    <span class="predicted-text">We voorspellen dat je het @if($weekOverview['estimated_passed'] == 'yes')<span class="wel">WEL</span> @else <span class="niet">NIET</span> @endif  haalt met een zekerheid van {{ number_format($weekOverview['estimated_risk'] * 100 , 2) }}%</ps>
                        
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

                                <div class="col-lg-12 col-md-12 head-graphs">
                                    <div class="moodle-box col-lg-6 col-md-6">
                                        <h1>Moodle</h1>
                                        <div class="col-lg-6 col-md-6 moodle-prac">
                                            <h2>Practicum</h2>
                                            <div class="col-lg-6 col-md-6">
                                                <h3>Jouw cijfer</h3>
                                                <div class="counter">{{ $mainResults['MoodleResult']['pracGrade'] }}</div>
                                            </div>
                                            <div class="col-lg-6 col-md-6">
                                                <h3>Gem. cijfer</h3>
                                                <div class="counter">{{ $averageResults['MoodleResult']['averagePrac'] }}</div>
                                            </div>

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
                                    </div>
                                    <div class="col-md-6 col-lg-6 mplbox">
                                        <h1>MyProgrammingLab</h1>
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
                                    </div>
                                    <div class="col-lg-6 col-md-6 lyndabox">
                                        <h1>Lynda</h1>
                                        <div class="col-lg-6 col-md-6">
                                            <h2>Voltooid</h2>
                                            <div data-amount="{{ $mainResults['LyndaResult']['complete'] }}" data-average="{{ $averageResults['LyndaResult']['complete'] }}" id="lynda_graph"></div>
                                        </div>
                                        <div class="col-lg-6 col-md-6">
                                            <h2>Aantal uren bekeken</h2>
                                            <h3>Jouw uren</h3>
                                            <div class="counter">{{ $mainResults['LyndaResult']['hoursviewed'] }}</div>
                                            <h3>Gemiddelde uren</h3>
                                            <div class="counter-fast">{{ $averageResults['LyndaResult']['hoursviewed'] }}</div>
                                        </div> 
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
@endsection
