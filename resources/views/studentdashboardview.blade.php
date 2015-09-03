@extends('student')

@section('content')
<div class="container-fluid">
    <div class="container">
        <div class="row">
            <h1>Studenten dashboard @if($student) #{{ $student['studnr_a'] }} @endif</h1>
            <div class='row'>
                <div class="col-lg-12 col-md-12  prediction-box">
                    <div class="col-lg-4 col-md-4">
                        <h2>Je verwachte cijfer</h2>
                        <div id="graph-grade" data-attr="{{ number_format($weekOverview['estimated_grade'],1)   }}" style="width:100%; float:left; height:300px;"></div>
                        <div id="tooltipholder-graph" class="tooltip-chart"></div>
                    </div>

                    <div class="col-lg-4 col-md-4">
                        <h2 class="text-trafficlight"></h2>
                        {{--<div id="graph-risk" data-attr="{{ number_format($weekOverview['estimated_risk'] * 100,2) }}" style="width:100%; height:300px;"></div>--}}
                        <div id="traffic-light" data-attr="{{ number_format($weekOverview['estimated_risk'] * 100,1) }}">
                            <div id="stopLight" class="bulb"></div>
                            <div id="slowLight" class="bulb"></div>
                            <div id="goLight" class="bulb"></div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <h2>Hoe presteren je studiegenoten?</h2>
                        <div id="graph-averagegrade" data-attr="{{ $averageResults['AverageGrade'] }}" style="width:100%; float:left; height:300px;"></div>
                        <div id="tooltipholder-averagegraph" class="tooltip-chart"></div>
                    </div>
                </div>
                <span class="predicted-text">We voorspellen dat je het @if($weekOverview['estimated_passed'] == 'yes')<span class="wel">WEL</span> @else <span class="niet">NIET</span> @endif  haalt met een zekerheid van {{ number_format($weekOverview['estimated_risk'] * 100 , 2) }}%</span>

            </div>

            <div role="tabpanel">

                <!-- Nav tabs -->
                <ul class="nav nav-tabs tab nav-justified nav-pills" role="tablist">
                    @for ($i = 1; $i < 9; $i++)
                    @if(in_array($i, $sentweeks))
                    <li role="presentation" @if($i == $week)class="active" @endif><a href="{{ url('/studentdashboard?key=' . $viewkeys[$i])}}" aria-controls="home" @if($i == $week) role="tab" data-toggle="tab" @endif>Week {{$i}}</a></li>
                    @else
                    <li role="presentation" @if($i == $week)class="active" @endif  class="disabled"><a href="#" aria-controls="home" @if($i == $week) role="tab" data-toggle="tab" @endif>Week {{$i}}</a></li>
                    @endif
                    @endfor
                </ul>
                <div id="ajax-panel">
                    <!-- Tab panes -->
                    <input type="hidden" id="week" value="{{ $week }}">
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
<div class="modal fade disclaimer">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Disclaimer Programming Dashboard</h4>
            </div>
            <div class="modal-body">
                <p>Met het gebruik van deze webpagina gaat u akkoord met deze disclaimer. Wij spannen ons in om de informatie op deze webpagina zo volledig en nauwkeurig mogelijk te laten zijn. De gegevens komen uit verschillende systemen en kunnen door statistische bewerkingen onnauwkeurigheden bevatten. Aan de inhoud van deze webpagina kan je geen rechten ontlenen en wij aanvaarden geen enkele verantwoordelijkheid voor schade op welke manier dan ook ontstaan door gebruik, onvolledigheid of onjuistheid van de aangeboden informatie op deze webpagina. Jan Hellings j.f.hellings@hva.nl
                </p>
            </div>
            <div class="modal-footer">

                <button type="button" class="btn btn-primary ok-disclaimer">Oke, ik wil mijn dashboard zien.</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

@endsection
