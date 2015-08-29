
<table style="width:98%">
    <thead>
    <tr><img src="{{ $message->embed(asset('/img/logo.svg')) }}"></tr>
    <tr style="height:50px; background-color:#8da4b6; width:98%;"></tr>
    </thead>
    <tbody>
    <p>Beste Student,<br/><br/>
        Hierbij de link naar jouw dashboard voor het vak Programming. Ben je benieuwd naar jouw voortgang in de elektronische leeromgevingen (Myprogramminglab, Moodle en Lynda.com) en wil je weten van jouw verwachte eindcijfer en slagkans is, klik dan op de onderstaande link.<br/><br/>

        {{ url('/studentdashboard?key=' . $view_key) }}

    <br/><br/>

        <strong>Vragen?</strong><br/>

        Heb je vragen over jouw dashboard of lukt er iets niet? Neem dan contact op met Jan Hellings (j.f.hellings@hva.nl) <br/><br/>

    Met vriendelijke groet,<br/>
        Jan Hellings<br/>
        Docent HBO-ICT.<br/>

    </tbody>




</table>


