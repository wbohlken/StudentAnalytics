@extends('app')

@section('content')
<div class="container-fluid">
    <div class="container">
        <div class="row">
            <h1>Studenten dashboard #{{ $student['studnr_a'] }}</h1>
            <div class='row'>
                @if(Auth::user()->isAdmin()))
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
                            <h3> Totale voortgang deze week</h3>
                            <div class="progress">

                                <div class="progress-bar progress-bar-striped active progress-bar-success" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="400" style="width:{{ $mainResults['TotalResult']}}%">
                                </div>
                            </div>
                            <div class="col-lg-12 row col-md-12 head-graphs">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6">
                                        <h2>Moodle</h2>
                                        <div data-amount="{{ $mainResults['MoodleResult'] }}" id="moodle_graph"></div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <h2>Lynda</h2>
                                        <div data-amount="{{ $mainResults['LyndaResult'] }}" id="lynda_graph"></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <h2>MyProgrammingLab</h2>
                                    <div class="col-lg-6 col-md-6">
                                        <h3>Voltooid</h3>
                                        <div data-amount="{{ $mainResults['MPLresult']['MMLMastery'] }}" id="mpl_graph"></div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <h3>Pogingen</h3>
                                        <div data-amount="{{ $mainResults['MPLresult']['MMLAttempts'] }}" id="course_graph"></div>
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
