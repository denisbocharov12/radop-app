<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Radop - Activation Link</title>
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    @if (session('resent'))
                            {{ __('A fresh verification link has been sent to your email address.') }}
                        </div>
                    @endif
                    {{ __('Înregistrarea pe site-ul www.radop.md a avut succes. Confirmați înregistrarea. Dacă nu ați făcut-o, ignorați acest mesaj.') }}
                    <a href="{{route('user.registration.activation', $token)}}">{{__('Click aici')}}</a>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
