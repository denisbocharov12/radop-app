@extends('user.v1.layouts.layout')

@section('content')
    <section class="section-login">
        <div class="container">
            <div class="row">
                <div class="col-12 col-login">
                    <div class="col-login-wrap">
                        <form action="{{route('user.auth')}}" method="POST">
                            @csrf
                            <div class="form-logo">
                                <img src="{{asset('/v1/frontend/assets')}}/images/logo_icon.svg" alt="">
                            </div>
                            <div class="form-control">
                                <label for="#">Email или Username</label>
                                <input type="text" name="username" id="username" placeholder="Введите ваш email или username">
                                @error('username')
                                <span class="invalid">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-control">
                                <label for="#">Пароль</label>
                                <input type="password" name="password" id="password" placeholder="Пароль">
                                @error('password')
                                <span class="invalid">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-flex">
                                <div class="form-control form-control-align-left">
                                    <input type="checkbox" class="checkbox" name="remember_me" id="remember_me">
                                    <label for="remember_me">Запомнить меня</label>
                                </div>
                                <div class="form-control form-control-align-right">
                                    <a href="#" class="link">Забыли пароль?</a>
                                </div>
                            </div>
                            <div class="form-flex form-flex-direction">
                                <button class="link link-submit" type="submit">Войти</button>
                                @error('auth')
                                    <span class="invalid auth">{{ $message }}</span>
                                @enderror
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
