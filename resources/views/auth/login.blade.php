<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>.:CANAZATEL:.</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <link rel="stylesheet" href="{{ asset('template/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/bower_components/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/dist/css/AdminLTE.min.css') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body style="background: linear-gradient(45deg, rgba(207, 241, 23, 0.8), rgba(28, 179, 0, 0.8)), url('{{ asset('template-web/assets/img/logo.jpg') }}'); background-size: cover; background-repeat: no-repeat; background-position: center; background-attachment: fixed;">
    <div class="login-box">
        <div class="login-box-body">
            <div class="login-logo">
                <a href="#" style="background-color: white;"><b>CANAZATEL</b></a>
                <br>
                <a href="#" style="background-color: white;">Telecomunicaciones</a>
            </div>

            @if (session()->has('mensaje'))
                <div class="col-12 alert alert-danger text-center mt-2">
                    {{ session('mensaje') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group has-feedback">
                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <input id="email" type="text" class="form-control" name="email" value="{{ old('email') }}" required autofocus placeholder="CORREO ELECTRONICO">
                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                    </div>
                </div>

                <div class="form-group has-feedback">
                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <input id="password" type="password" class="form-control" name="password" required placeholder="CONTRASEÑA">
                        @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 text-center">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">INGRESAR</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="{{ asset('template/bower_components/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('template/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
</body>
</html>
