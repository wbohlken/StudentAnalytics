@extends('app')

@section('content')
<div class="container-fluid">
    <div class="container">
        <div class="row">
            <h1>Studenten dashboard #{{ $student['studnr_a'] }}</h1>
            <div class='row'>
                @if(Auth::user()->isAdmin())
                <div class="filter-box">
                    <form method="get" action="/studentdashboard">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group">
                            <select name="studentnumber" class="form-control">
                                <option value="">Studentnummer</option>
                                @foreach ($studentnumbers as $number) 
                                <option  value="{{ $number }}">{{ $number }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-default">Zoek</button>

                    </form>
                </div>

                <div class="panel panel-default col-lg-5 col-md-5 right information-box">
                    <div class="panel-heading">
                        <h3 class="panel-title">Persoonlijke informatie student #{{ $student['studnr_a'] }}</h3>
                    </div>
                    <div class="panel-body">
                        <table>
                            <tr>
                                <td class='title-table'>Studentnummer</td>
                                <td>{{$student['studnr_a']}}</td>
                            </tr>
                            <tr>
                                <td class='title-table'>Cohort</td>
                                <td>{{$student['block']}}</td>
                            </tr>
                            <tr>
                                <td class='title-table'>Cohort Jaar</td>
                                <td>{{$student['cohort_year']}}</td>
                            </tr>
                            <tr>
                                <td class='title-table'>Cohort Blok</td>
                                <td>{{$student['cohort_block']}}</td>
                            </tr>
                            <tr>
                                <td class='title-table'>Vooropleiding type</td>
                                <td>{{$student['preschool_type']}}</td>
                            </tr>
                            <tr>
                                <td class='title-table'>Vooropleiding profiel</td>
                                <td>{{$student['preschool_profile']}}</td>
                            </tr>
                            <tr>
                                <td class='title-table'>Profiel</td>
                                <td>{{$student['profile']}}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                @endif
                <div class="panel panel-default col-lg-5 col-md-5 col-lg-offset-2 prediction-box">
                    <div class="panel-heading">
                        <h3 class="panel-title">Verwachtingsmodule</h3>
                    </div>
                    <div class="panel-body">
                        Verwacht cijfer
                        <p>{{ }}</p>
                    </div>
                </div>
            </div>

            <div role="tabpanel">

                <!-- Nav tabs -->
                <ul class="nav nav-tabs tab nav-justified nav-pills" role="tablist">
                    @for ($i = 1; $i < 9; $i++)
                    <li role="presentation" @if($i == $weekOverview['week_id'])class="active" @else class="disabled" @endif><a href="#" aria-controls="home" @if($i == $weekOverview['week_id']) role="tab" data-toggle="tab" @endif>Week {{$i}}</a></li>
                    @endfor
                </ul>
                <div id="ajax-panel">
                    <!-- Tab panes -->
                    <div class="tab-content" >
                        <script type="text/javascript" src="https://www.google.com/jsapi"></script>

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
                        <div role="tabpanel" class="tab-pane" id="profile">...</div>
                        <div role="tabpanel" class="tab-pane" id="messages">...</div>
                        <div role="tabpanel" class="tab-pane" id="settings">...</div>
                    </div>
                </div>

            </div>


        </div>
    </div>
</div>
@endsection
