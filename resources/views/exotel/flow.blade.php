<?xml version="1.0" encoding="UTF-8"?>
<Response>

    <Say voice="female">
        Please wait while we connect you to the nearest hospital.
    </Say>

    <Dial parallel="true" timeout="3600" record="true">
        @foreach($numbers as $number)
            <Number>{{ $number }}</Number>
        @endforeach
    </Dial>

</Response>