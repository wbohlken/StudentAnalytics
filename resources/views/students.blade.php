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
                        <th width="200">Studentnummer</th>
                        <th width="350">Vooropleiding profiel</th>
                        <th width="100">Mail</th>
                        <th width="150">Laatst ingelogd</th>
                        <th width="150">Aantal keer ingelogd</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($students as $student)
                        <tr>
                            <td>{{ $student->studnr_a}}</td>
                            <td>@if(count($student->vooropl_profiel)){{ $student->vooropl_profiel->name }}@endif</td>
                            <td>@if(count($student->user())) Ja @else Nee @endif</td>
                            {{--<td>{{ $student->weekOverviews->first()->weekoverviewhistory->first()->created_at }}</td>--}}
                            <td>{{ count($student->weekOverviews) }}</td>
                        </tr>
                            @endforeach
                        @if($students->total() == 0)
                            <tr>
                                <td></td>
                                <td>Helaas! Er zijn geen resultaten gevonden.</td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>


                            @endif
                    </tbody>

                </table>
                <?php echo $students->render(); ?>
                <span class="countrows">Er zijn {{ $students->total() }} resultaten gevonden.</span>

            </div>
        </div>
    </div>
@endsection
