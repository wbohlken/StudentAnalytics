
<table style="width:98%">
    <thead>
    <tr><img src="{{ $message->embed(asset('/img/logo.svg')) }}"></tr>
    <tr style="height:50px; background-color:#8da4b6; width:98%;"></tr>
    </thead>
    <tbody>
    <p>Beste Student,<br/><br/>
        Uit onze gegevens van het online programmingdashboard is gebleken dat je nog niet hebt gekeken in het speciaal voor jou gemaakte dashboard over Programming van week {{ $week }}, waarin o.a. jouw voortgang in Myprogramminglab en Moodle te zien is.
        Uit onderzoek van de vorige studiejaren is gebleken dat de voortgang in de elektronische leeromgevingen voorspellend is voor het eindcijfer. Studenten die online actief zijn hebben een grote kans om het vak te halen.<br/><br/></p>

    <p style="color:red; font-size:14px;">Dus kijk gauw op jouw dashboard om te zien hoe jij presteert t.o.v. van de rest van de studenten en wat je verwachte eindcijfer en slaagkans is.
    </p><br/><br/>
        {{ url('/studentdashboard?key=' . $view_key) }}

    <br/><br/>

        <strong>Vragen?</strong><br/>

        Heb je vragen over jouw dashboard of lukt er iets niet? Neem dan contact op met Jan Hellings (j.f.hellings@hva.nl) <br/><br/>

    Met vriendelijke groet,<br/>
        Jan Hellings<br/>
        Docent HBO-ICT.<br/>

    </tbody>




</table>


