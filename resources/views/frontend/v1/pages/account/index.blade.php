@extends('frontend.v1.layouts.layout')

@section('content')
    <section class="my-account">
        <div class="container">
            <h1 class="my-account__title title">Мой аккаунт</h1>
            <div class="my-account__wrapper">
                @include('frontend.v1.pages.account.sidebar')
                <div class="my-account-details">
                    <h2 class="my-account-details__title">Детали аккаунта</h2>
                    <ul class="my-account-details__list">
                        <li class="my-account-details__item">
                            <h3 class="my-account-details__name">
                                Персональная информация
                            </h3>
                            <div class="my-account-details__inner">
                                <div class="my-account-details__text">
                                    Мы сохраняем данную информацию для удобства
                                    использования нашей платформы. Все права защищены
                                    сосгласно Политике конфиденциальности
                                </div>
                                <form class="my-account-details-form" action="{{route('theme.account.update', auth()->guard('user')->user())}}" method="POST">
                                    @csrf
                                    <ul class="my-account-details-form__list">
                                        <li class="my-account-details-form__item">
                                            <label
                                                class="my-account-details-form__label"
                                                for="first_name"
                                            >Имя</label
                                            >
                                            <input
                                                class="my-account-details-form__input"
                                                type="text"
                                                name="first_name"
                                                id="first_name"
                                                placeholder="Имя"
                                                value="{{$user->profile->first_name}}"
                                            />
                                        </li>
                                        <li class="my-account-details-form__item">
                                            <label
                                                class="my-account-details-form__label"
                                                for="last_name"
                                            >Фамилия</label
                                            >
                                            <input
                                                class="my-account-details-form__input"
                                                type="text"
                                                name="last_name"
                                                id="last_name"
                                                placeholder="Фамилия"
                                                value="{{$user->profile->last_name}}"
                                            />
                                        </li>
                                        <li class="my-account-details-form__item">
                                            <label
                                                class="my-account-details-form__label"
                                                for="cod_fiscal"
                                            >Фискальный код</label
                                            >
                                            <input
                                                class="my-account-details-form__input"
                                                type="text"
                                                name="cod_fiscal"
                                                id="cod_fiscal"
                                                placeholder="Фискальный код"
                                                value="{{$user->profile->cod_fiscal}}"
                                            />
                                        </li>
                                        <li class="my-account-details-form__item">
                                            <label
                                                class="my-account-details-form__label"
                                                for="address"
                                            >Адрес</label
                                            >
                                            <input
                                                class="my-account-details-form__input"
                                                type="text"
                                                name="address"
                                                id="address"
                                                placeholder="Ул. Пушкина 22"
                                                value="{{$user->profile->address}}"
                                            />
                                        </li>
                                        <li class="my-account-details-form__item">
                                            <label
                                                class="my-account-details-form__label"
                                                for="phone"
                                            >Номер телефона</label
                                            >
                                            <input
                                                class="my-account-details-form__input"
                                                type="tel"
                                                name="phone"
                                                id="phone"
                                                placeholder="+373 777 77 777"
                                                value="{{$user->profile->phone}}"
                                            />
                                        </li>
                                        <li class="my-account-details-form__item">
                                            <label
                                                class="my-account-details-form__label"
                                                for="email"
                                            >Email</label
                                            >
                                            <input
                                                class="my-account-details-form__input"
                                                type="email"
                                                name="email"
                                                id="email"
                                                placeholder="example@mail.ru"
                                                value="{{$user->email}}"
                                            />
                                        </li>
                                    </ul>
                                    <button
                                        class="my-account-details-form__button"
                                        type="submit"
                                    >
                                        Сохранить
                                    </button>
                                </form>
                            </div>
                        </li>
                        <li class="my-account-details__item">
                            <h3 class="my-account-details__name">Email адрес</h3>
                            <div class="my-account-details__inner">
                                <div class="my-account-details__text">
                                    Мы сохраняем данную информацию для удобства
                                    использования нашей платформы. Все права защищены
                                    сосгласно Политике конфиденциальности
                                </div>
                                <form class="my-account-details-form" action="#">
                                    <ul class="my-account-details-form__list">
                                        <li class="my-account-details-form__item">
                                            <label
                                                class="my-account-details-form__label"
                                                for="email"
                                            >Email</label
                                            >
                                            <input
                                                class="my-account-details-form__input"
                                                type="email"
                                                name="email"
                                                id="email"
                                                placeholder="example@mail.ru"
                                                value="{{$user->email}}"
                                            />
                                        </li>
                                    </ul>
                                    <button
                                        class="my-account-details-form__button"
                                        type="submit"
                                    >
                                        Сохранить
                                    </button>
                                </form>
                            </div>
                        </li>
                        <li class="my-account-details__item">
                            <h3 class="my-account-details__name">Пароль</h3>
                            <div class="my-account-details__inner">
                                <div class="my-account-details__text">
                                    Мы сохраняем данную информацию для удобства
                                    использования нашей платформы. Все права защищены
                                    сосгласно Политике конфиденциальности
                                </div>
                                <form class="my-account-details-form" action="#">
                                    <ul class="my-account-details-form__list">
                                        <li class="my-account-details-form__item">
                                            <label
                                                class="my-account-details-form__label"
                                                for="currentpassword"
                                            >Текущий пароль</label
                                            >
                                            <input
                                                class="my-account-details-form__input my-account-details-form-password"
                                                type="password"
                                                name="currentpassword"
                                                id="currentpassword"
                                            />
                                            <i class="icon-eye-off togglePassword"></i>
                                        </li>
                                        <li class="my-account-details-form__item">
                                            <label
                                                class="my-account-details-form__label"
                                                for="newpassword"
                                            >Новый пароль</label
                                            >
                                            <input
                                                class="my-account-details-form__input my-account-details-form-password"
                                                type="password"
                                                name="newpassword"
                                                id="newpassword"
                                            />
                                            <i class="icon-eye-off togglePassword"></i>
                                        </li>
                                        <li class="my-account-details-form__item">
                                            <label
                                                class="my-account-details-form__label"
                                                for="confirmpassword"
                                            >Подтверждение пароля</label
                                            >
                                            <input
                                                class="my-account-details-form__input my-account-details-form-password"
                                                type="password"
                                                name="confirmpassword"
                                                id="confirmpassword"
                                            />
                                            <i class="icon-eye-off togglePassword"></i>
                                        </li>
                                    </ul>
                                    <button
                                        class="my-account-details-form__button"
                                        type="submit"
                                    >
                                        Сохранить
                                    </button>
                                </form>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
@endsection
