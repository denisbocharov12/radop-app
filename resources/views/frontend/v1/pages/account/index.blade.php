@extends('frontend.v1.layouts.layout')

@section('content')
    <section class="my-account" style="margin-bottom: 100px">
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
                                                required
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
                                                required
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
                                                required
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
                                                required
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
                                                required
                                            />
                                        </li>
                                        @if($user->type->key_name == 'iur')
                                            <li class="my-account-details-form__item">
                                                <label
                                                    class="my-account-details-form__label"
                                                    for="organization_name"
                                                >Название компании</label
                                                >
                                                <input
                                                    class="my-account-details-form__input"
                                                    type="text"
                                                    name="organization_name"
                                                    id="organization_name"
                                                    placeholder="Название компании"
                                                    value="{{$user->profile->organization_name}}"
                                                />
                                            </li>
                                            <li class="my-account-details-form__item">
                                                <label
                                                    class="my-account-details-form__label"
                                                    for="contact_name"
                                                >Контактное лицо</label
                                                >
                                                <input
                                                    class="my-account-details-form__input"
                                                    type="text"
                                                    name="contact_name"
                                                    id="contact_name"
                                                    placeholder="Контактное лицо"
                                                    value="{{$user->profile->contact_name}}"
                                                />
                                            </li>
                                        @endif
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
                            <h3 class="my-account-details__name">Пароль</h3>
                            <div class="my-account-details__inner">
                                <div class="my-account-details__text">
                                    Мы сохраняем данную информацию для удобства
                                    использования нашей платформы. Все права защищены
                                    сосгласно Политике конфиденциальности
                                </div>
                                <form class="my-account-details-form" action="{{route('theme.account.password.update')}}" method="POST">
                                    @csrf
                                    <div class="password-requirements">
                                        <h3>Используйте в своём новом пароле следующие символы:</h3>
                                        <ul class="mt-3">
                                            <li>
                                                <i class="fas fa-check"></i> Английские прописные буквы (A - Z)
                                            </li>
                                            <li>
                                                <i class="fas fa-check"></i> Английские строчные символы (a - z)
                                            </li>
                                            <li>
                                                <i class="fas fa-check"></i> Цифры (0 - 9)
                                            </li>
                                        </ul>
                                    </div>
                                    <ul class="my-account-details-form__list mt-3">
                                        <li class="my-account-details-form__item">
                                            <label
                                                class="my-account-details-form__label"
                                                for="current_password"
                                            >Текущий пароль</label
                                            >
                                            <input
                                                class="my-account-details-form__input my-account-details-form-password"
                                                type="password"
                                                name="current_password"
                                                id="current_password"
                                            />
                                            <i class="icon-eye-off togglePassword"></i>
                                        </li>
                                        <li class="my-account-details-form__item">
                                            <label
                                                class="my-account-details-form__label"
                                                for="password"
                                            >Новый пароль</label
                                            >
                                            <input
                                                class="my-account-details-form__input my-account-details-form-password"
                                                type="password"
                                                name="password"
                                                id="password"
                                            />
                                            <i class="icon-eye-off togglePassword"></i>
                                        </li>
                                        <li class="my-account-details-form__item">
                                            <label
                                                class="my-account-details-form__label"
                                                for="confirm_password"
                                            >Подтверждение пароля</label
                                            >
                                            <input
                                                class="my-account-details-form__input my-account-details-form-password"
                                                type="password"
                                                name="confirm_password"
                                                id="confirm_password"
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
