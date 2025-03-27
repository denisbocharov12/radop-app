@extends('frontend.v1.layouts.layout')

@section('content')
    <div class="login-container d-flex align-items-center justify-content-center">
        <div class="card shadow-lg p-4 rounded" style="max-width: 450px; width: 100%;">
            <div class="login-logo d-flex align-items-center justify-content-center">
                <img style="width: 90px; height: auto" src="{{asset('/v1/frontend/assets')}}/images/logo.svg" alt="Radop Logo" />
            </div>
            <h2 class="text-center mb-4 fw-bold">
                {{ __('theme.log-in-account') }}
            </h2>

            <div id="auth-response" class="mb-3"></div>

            <form id="loginForm" method="POST" action="{{ route('user.login') }}">
                @csrf

                <div class="form-group mb-3">
                    <label for="username" class="form-label">Email:</label>
                    <input type="text" id="username" name="username" class="form-control" required placeholder="Email">
                </div>

                <div class="form-group mb-3">
                    <label for="password" class="form-label">{{ __('theme.password') }}:</label>
                    <input type="password" id="password" name="password" class="form-control" required placeholder="{{ __('theme.password') }}">
                </div>

                <button type="submit" class="btn btn-primary w-100">{{ __('theme.enter') }}</button>
            </form>
        </div>
    </div>
    @endif

    <script>
        document.getElementById('loginForm').addEventListener('submit', async function (e) {
            e.preventDefault();

            const formData = new FormData(this);
            const responseDiv = document.getElementById('auth-response');

            try {
                const response = await fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                });

                const result = await response.json();

                if (result.status) {
                    window.location.href = '/orders';
                } else {
                    responseDiv.innerHTML = '<div class="alert alert-danger">{{ __('theme.login-error')}}</div>';
                }
            } catch (error) {
                responseDiv.innerHTML = '<div class="alert alert-danger">{{ __('theme.error-message') }}</div>';
            }
        });
    </script>

    <style>
        .login-container{
            margin: 50px 0;
        }
        .card {
            background: #fff;
            border: none;
            border-radius: 16px;
        }

        .form-control {
            border-radius: 8px;
            padding: 10px 15px;
        }

        .btn-primary {
            background: #0052a6;
            border: none;
            padding: 10px 0;
            border-radius: 8px;
            transition: background 0.3s ease;
        }

        .btn-primary:hover {
            background: #034486;
        }
        h2 {
            font-size: 26px;
        }
    </style>
@endsection
