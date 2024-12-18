<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Responsive Bootstrap4 Shop Template, Created by Imran Hossain from https://imransdesign.com/">
    
    <!-- title -->
    <title>Verificar email - CodeTechEvolution</title>
    
    <!-- favicon -->
    <link rel="shortcut icon" type="image/png" href="{{ asset('web/assets/img/logos/logo-ai-favicon.png') }}">
    <!-- google font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- fontawesome -->
    <link rel="stylesheet" href="{{ asset('web/assets/fontawesome/css/all.css') }}">
    <link rel="stylesheet" href="{{ asset('web/assets/css/fonts.css') }}">
    <!-- main style -->
    <link rel="stylesheet" href="{{ asset('web/assets/css/auth.css') }}">
</head>
<body class="auth">
    <div class="back"></div>
    <div class="container">
        <p class="title">Verifica tu email</p>
        <div class="terms passt">
            <span>Se ha enviado un codigo de verificación a tu correo electrónico asociado a tu cuenta CodeTech.</span>
        </div>
        <form action="{{ route('verification') }}" method="POST">
            @csrf
            <div class="input-group input-code">
                <input type="text" id="code1" name="code1" maxlength="1" oninput="handleInput(1)" onkeydown="handleBackspace(1, event)">
                <input type="text" id="code2" name="code2" maxlength="1" oninput="handleInput(2)" onkeydown="handleBackspace(2, event)" disabled>
                <input type="text" id="code3" name="code3" maxlength="1" oninput="handleInput(3)" onkeydown="handleBackspace(3, event)" disabled>
                <input type="text" id="code4" name="code4" maxlength="1" oninput="handleInput(4)" onkeydown="handleBackspace(4, event)" disabled>
                <input type="text" id="code5" name="code5" maxlength="1" oninput="handleInput(5)" onkeydown="handleBackspace(5, event)" disabled>
                <input type="text" id="code6" name="code6" maxlength="1" oninput="handleInput(6)" onkeydown="handleBackspace(6, event)" disabled>
            </div>
            <input type="hidden" name="email" id="email" value="{{ Auth::user()->email }}">
            <button type="submit" id="btn-send" disabled>Verificar</button>
        </form>
        <div class="regis">
            <span><a href="{{ route('register') }}">Volver al registro</a></span>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var body = document.querySelector('body');
            setTimeout(function() {
                body.classList.add('show');
            }, 100);
        });
    </script>
    <script>
        const handleInput = (inputNumber)=>{
            const currentInput = document.querySelector(`.input-code input:nth-child(${inputNumber})`);
            const nextInput = document.querySelector(`.input-code input:nth-child(${inputNumber + 1})`);

            if (currentInput.value.length === 1 && nextInput) {
                nextInput.disabled = false;
                nextInput.focus();
            }

            const allInputsFilled = Array.from(document.querySelectorAll('.input-code input')).every(input => input.value.length === 1);

            const verifyBtn = document.querySelector('#btn-send');
            verifyBtn.disabled = !allInputsFilled;
        }

        const handleBackspace = (inputNumber, event) => {
            if (event.key == "Backspace") {
                const currentInput = document.querySelector(`.input-code input:nth-child(${inputNumber})`);
                const prevInput = document.querySelector(`.input-code input:nth-child(${inputNumber - 1})`);

                if (currentInput.value.length === 0 && prevInput) {
                    currentInput.disabled = true;
                    currentInput.value = "";
                    prevInput.focus();
                }

                const allInputsFilled = Array.from(document.querySelectorAll('.input-code input')).every(input => input.value.length === 1);

                const verifyBtn = document.querySelector('#btn-send');
                verifyBtn.disabled = !allInputsFilled;
            }
        }
    </script>
</body>
</html>
