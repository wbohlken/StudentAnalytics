<table style="width:98%">
    <thead>
    <tr><img src="{{ $message->embed(asset('/img/logo.svg')) }}"></tr>
    <tr style="height:50px; background-color:#8da4b6; width:98%;"></tr>
    </thead>
    <tbody>
    <p>Beste {{ $name }},<br/><br/>
        {{ $nameCurrent }} heeft een account aangemaakt binnen het programming dashboard.
        <br/>
        login met de volgende gegevens:
        <br/><br/>
        Website: http://www.dashboard.informatica-hva.nl
        Email: {{ $email }}<br/>
        Wachtwoord: {{ $password }}<br/><br/>


        Heb je vragen over je dashboard of lukt er iets niet? Neem dan contact op met Jan Hellings (j.f.hellings@hva.nl) <br/><br/>

        Met vriendelijke groet,<br/>
        Jan Hellings<br/>
        Docent HBO-ICT.<br/>

    </tbody>




</table>


