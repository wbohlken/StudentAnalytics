@extends('app')

@section('content')
<div class="container-fluid">
    <div class="container">
        <div class="row">
            <h1>Dashboard</h1>
            <div class="filter-box">
                <form method="post" action="/post-studentnumber">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group">
                        <select name="studentnumber" class="form-control">
                            <option value="">Studentnummer</option>
                            @foreach ($studentnumbers as $number) 
                            <option value="{{ $number }}">{{ $number }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-default">Zoek</button>

                </form>
            </div>
            <div role="tabpanel">

                <!-- Nav tabs -->
                <ul class="nav nav-tabs tab nav-justified nav-pills" role="tablist">
                    <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Week 1</a></li>
                    <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Week 2</a></li>
                    <li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Week 3</a></li>
                    <li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">Week 4</a></li>
                    <li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">Week 5</a></li>
                    <li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">Week 6</a></li>
                    <li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">Week 7</a></li>
                    <li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">Week 8</a></li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
        
                    <div role="tabpanel" class="tab-pane active" id="home">
                        <div class="progress-box">
                            <h3> Totale voortgang deze week</h3>
                            <div class="progress">

                                <div class="progress-bar progress-bar-striped active progress-bar-success" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 45%">
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 head-graphs">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6">
                                        <h2>Moodle</h2>
                                        <div id="moodle_graph"></div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <h2>Lynda</h2>
                                        <div id="lynda_graph"></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6">
                                        <h2>MyProgrammingLab</h2>
                                        <div id="mpl_graph"></div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <h2>Lessen</h2>
                                        <div id="course_graph"></div>
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
@endsection
