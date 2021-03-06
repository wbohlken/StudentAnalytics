@extends('app')

@section('content')
    <div class="container-fluid">
        <div class="container">
            <a href="/">
                <div class="back btn">Terug naar dashboard overzicht</div>
            </a>

            <div class="row">
                <h1>Dashboard geschiedenis</h1>

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
                        <th width="">Studnr</th>
                        <th width="200">Vooropleiding profiel</th>
                        <th width="75">Week</th>
                        <th width="125">Geopend op</th>
                        <th width="">Totaal geopend</th>
                        <th>Verwacht cijfer</th>
                        <th>Verwacht risico</th>
                        <th>Verwacht slagen</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($weekoverviewhistory as $overview)
                        <tr>
                            <td>{{ $overview->user->student->studnr_a }}</td>
                            <td>@if($overview->user->student->vooropl_profiel){{ $overview->user->student->vooropl_profiel->name }}@endif</td>
                            <td>Week {{ $overview->weekoverview->week->week_nr }}</td>
                            <td>{{ $overview->created_at->format('d-m-Y H:i') }}</td>
                            <td>{{ $overview->user->student->getAmountLoggedIn() }}</td>
                            <td>{{ $overview->user->student->getLatestWeekOverview()->estimated_grade }}</td>
                            <td>{{ number_format($overview->user->student->getLatestWeekOverview()->estimated_risk * 100,2) }}</td>
                            <td>@if($overview->user->student->getLatestWeekOverview()->estimated_passed == 'yes') Ja @else Nee @endif</td>

                        </tr>
                            @endforeach
                        @if($weekoverviewhistory->total() == 0)
                            <tr>
                                <td></td>
                                <td>Helaas! Er zijn geen resultaten gevonden.</td>
                                <td></td>
                                <td></td>
                            </tr>


                            @endif
                    </tbody>

                </table>
                <div class="row">
                <span class="countrows">Er zijn {{ $weekoverviewhistory->total() }} resultaten gevonden.</span>
                    </div>
                <div class="row">
                    <?php echo $weekoverviewhistory->render(); ?>
                </div>


            </div>
        </div>
    </div>
@endsection
