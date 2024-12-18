<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Responsive Bootstrap4 Shop Template, Created by Imran Hossain from https://imransdesign.com/">
    
    <!-- title -->
    <title>Login - CodeTechEvolution</title>
    
    <!-- favicon -->
    <link rel="shortcut icon" type="image/png" href="{{ asset('web/assets/img/logos/logo-ai-favicon.png') }}">
    <!-- google font -->
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
        <a href="{{ route('index') }}" class="img-link"><img src="{{ asset('web/assets/img/logos/logo-ai.png') }}" alt="CodeTech"></a>
        <form action="{{ route('login') }}" method="post">
            @csrf
            <div class="input-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="input-group">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" placeholder="Introduce al menos 6 caracteres" required autocomplete="current-password">
                <i class="fa-duotone fa-eye" id="change-pass"></i>
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="input-group link-content">
                <a href="/password/reset/">¿Contraseña olvidada?</a>
            </div>

            <button type="submit">Iniciar sesión</button>
        </form>
        <div class="auth-or">
            <span>o continuar con</span>
        </div>
        <div class="social-icons">
            <a href="{{ route('auth.google') }}" class="icon"><img src="{{ asset('web/assets/img/logos/google.png') }}" alt="Google"></a>
            <a href="{{ route('auth.github') }}" class="icon"><img src="{{ asset('web/assets/img/logos/github.png') }}" alt="Github"></a>
            <a href="{{ route('auth.facebook') }}" class="icon"><img src="{{ asset('web/assets/img/logos/facebook.png') }}" alt="Facebook"></a>
            <a href="{{ route('auth.gitlab') }}" class="icon"><img src="{{ asset('web/assets/img/logos/gitlab.png') }}" alt="Gitlab"></a>
        </div>
        <div class="regis">
            <span>¿No tienes cuenta? <a href="{{ route('register') }}">Registrar</a></span>
        </div>
    </div>
    <div class="terms">
        <span>Al continuar, aceptas los <a href="{{ route('terms') }}">Términos de uso</a> y <a href="{{ route('priv') }}">Política de privacidad</a> de CodeTech.</span>
    </div>

    <script>
        var pass = document.getElementById('password');
        var icon1 = document.getElementById('change-pass');

        icon1.addEventListener('click', ()=>{
            if (pass.type == 'password') {
                pass.type='text';
                icon1.classList.remove('fa-eye');
                icon1.classList.add('fa-eye-slash');
            } else{
                pass.type='password';
                icon1.classList.remove('fa-eye-slash');
                icon1.classList.add('fa-eye');
            }
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var body = document.querySelector('body');
            setTimeout(function() {
                body.classList.add('show');
            }, 100);
        });
    </script>
</body>
</html>
