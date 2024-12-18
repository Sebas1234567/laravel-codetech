<!DOCTYPE html>
<html>
<head>
    <title>Fwd: {{ $subject }}</title>
</head>
<body>
    <div id=":5f" class="a3s aiL" style="direction: initial;font: small/1.5 Arial,Helvetica,sans-serif;overflow-x: auto;overflow-y: hidden;position: relative;">
        <u style="text-decoration: underline;"></u>   
        <div>
            <span class="im" style="color: #500050;">
                <br>
                <br>
                <span>---------- Forwarded message ---------</span>
                <br>
                <span>De: {{ $from }}</span>
                <br>
                <span>Date: {{ $date }}</span>
                <br>
                <span>Subject: {{ $subject }}</span>
                <br>
                <span>To: {{ $to }}</span>
                <div class="adL">
                    <br>
                    <br>
                    <br>
                </div>
            </span>
            <div class="adL">
                <div class="adm" style="margin: 5px 0;">
                    <div id="q_40" class="ajR h4">
                        <div class="ajT"></div>
                    </div>
                </div>
                <div class="h5">
                    {!! $cuerpo !!}
                </div>
            </div>
        </div>
        <div class="adL">
        </div>
    </div>
</body>
</html>
