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
                    <p>Vă mulțumim pentru înregistrarea pe site-ul www.radop.md.</p>
                    <p>Pentru a finaliza procesul de înregistrare și a activa contul, vă rugăm să accesați următorul link:</p>
                    <a href="{{route('user.registration.activation', $token)}}">Activează</a>
                    <p>Dacă nu v-ați înregistrat pe site-ul nostru, vă rugăm să ignorați acest email.</p>
                    <p>Vă mulțumim că ați ales www.radop.md! Suntem bucuroși că sunteți alături de noi!</p>
                    <p>Dacă aveți întrebări, vă rugăm să contactați serviciul de suport al site-ului la adresa <a href="mailto:radop@mail.ru">radop@mail.ru</a></p>
                    <p>Cu respect,</p>
                    <p>Echipa www.radop.md</p>
                    <p><a href="mailto:support@radop.md">support@radop.md</a></p>
                    <p><a href="tel:37322782112">022 78 21 12</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
