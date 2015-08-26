@extends('app')

@section('content')
    <div class="container-fluid">
        <div class="container">
            <a href="/">
                <div class="back btn">Terug naar dashboard overzicht</div>
            </a>

            <div class="row">
                <h1>Studenten overzicht</h1>

                <div class="filter">
                    <form name="history-filter-form" method="get">
                        <div class="content-filter">
                            <span>Filter op </span>

                            <div class="filter-element">
                                <select name="studentnumber" class="studentnumber-search">
                                    <option value="">Studentnummer</option>
                                    @foreach ($studentnumbers as $number)
                                        <option @if($number == $studentnumber)selected="selected"@endif value="{{ $number }}">{{ $number }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="filter-element">
                                <select name="week" class="week-search">
                                    <option value="">Week</option>
                                    @for ($i = 1; $i < 9; $i++)
                                        <option @if($i == $week)selected="selected"@endif value="{{$i}}">Week {{$i}}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="filter-element">
                                <select name="vooropl" class="vooropl-search">
                                    <option value="">Vooropleiding</option>
                                    @foreach ($vooropls as $vooropl)
                                        <option @if($vooropl == $vooropleiding)selected="selected"@endif value="{{$vooropl->id}}">{{$vooropl->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <input type="submit" class="filteren-btn btn" value="Filteren">
                        </div>
                    </form>
                </div>

                <table id="historytable">
                    <thead>
                    <tr>
                        <th>Studnr</th>
                        <th>Vooropleiding profiel</th>
                        <th>Mail?</th>
                        <th>Laatst ingelogd</th>
                        <th>Aantal ingelogd</th>
                        <th>Verwacht cijfer</th>
                        <th>Verwacht risico</th>
                        <th>Verwacht slagen</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($students as $student)
                        <tr>
                            <td>{{ $student->studnr_a}}</td>
                            <td>@if(count($student->vooropl_profiel)){{ $student->vooropl_profiel->name }}@endif</td>
                            <td>@if(count($student->user)) Ja @else Nee @endif</td>
                            <td>@if ($student->getLastLogin()['created_at']){{ $student->getLastLogin()['created_at']->format('d-m-Y H:i') }} @else - @endif</td>
                            <td>{{ $student->getAmountLoggedIn() }}</td>
                            <td>@if($student->getLatestWeekOverview()) {{ $student->getLatestWeekOverview()->estimated_grade  }} @else n.v.t @endif</td>
                            <td>@if($student->getLatestWeekOverview()){{ number_format($student->getLatestWeekOverview()->estimated_risk * 100, 2) }} % @else n.v.t @endif </td>
                            <td>@if($student->getLatestWeekOverview()) @if($student->getLatestWeekOverview()->estimated_passed == 'yes') Ja @else Nee @endif @else n.v.t @endif</td>
                        </tr>
                            @endforeach
                        @if($students->total() == 0)
                            <tr>
                                <td></td>
                                <td>Helaas! Er zijn geen resultaten gevonden.</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>


                            @endif
                    </tbody>

                </table>
                <div class="row">
                <?php echo $students->render(); ?>
                    </div>
                <div class="row">
                <span class="countrows">Er zijn {{ $students->total() }} resultaten gevonden.</span>
                    </div>

            </div>
        </div>
    </div>
@endsection
