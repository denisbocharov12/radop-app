@extends('frontend.v1.layouts.layout')

@section('content')
    <section class="my-account" style="margin-bottom: 100px">
        <div class="container">
            <h1 class="my-account__title title">{{__('theme.my-account')}}</h1>
            <div class="my-account__wrapper">
                @include('frontend.v1.pages.account.sidebar')
                <div class="my-account-details">
                    <h2 class="my-account-details__title">{{__('theme.account-details')}}</h2>
                    <ul class="my-account-details__list">
                        <li class="my-account-details__item">
                            <h3 class="my-account-details__name">
                                {{__('theme.personal-information')}}
                            </h3>
                            <div class="my-account-details__inner">
                                <div class="my-account-details__text">
                                    {{__('theme.personal-information-save')}}
                                </div>
                                <form class="my-account-details-form" action="{{route('theme.user.account.update', auth()->guard('user')->user())}}" method="POST">
                                    @csrf
                                    <ul class="my-account-details-form__list">
                                        <li class="my-account-details-form__item">
                                            <label
                                                class="my-account-details-form__label"
                                                for="first_name"
                                            >{{__('theme.first-name')}}</label
                                            >
                                            <input
                                                class="my-account-details-form__input"
                                                type="text"
                                                name="first_name"
                                                id="first_name"
                                                placeholder="{{__('theme.first-name')}}"
                                                value="{{$user->profile->first_name}}"
                                                required
                                            />
                                        </li>
                                        <li class="my-account-details-form__item">
                                            <label
                                                class="my-account-details-form__label"
                                                for="last_name"
                                            >{{__('theme.second-name')}}</label
                                            >
                                            <input
                                                class="my-account-details-form__input"
                                                type="text"
                                                name="last_name"
                                                id="last_name"
                                                placeholder="{{__('theme.second-name')}}"
                                                value="{{$user->profile->last_name}}"
                                                required
                                            />
                                        </li>
                                        <li class="my-account-details-form__item select-2-container-wrap">
                                            <label
                                                class="my-account-details-form__label"
                                                for="city_id"
                                            >{{__('theme.city-label')}}</label
                                            >
                                            <select name="city_id" id="city_id" class="select-2-container my-account-details-form__input">
                                                @foreach($cities as $city)
                                                    <option value="{{$city->id}}" {{$user->city_id === $city->id ? 'selected' : ''}}>{{$city->name}}</option>
                                                @endforeach
                                            </select>
                                        </li>
                                        <li class="my-account-details-form__item">
                                            <label
                                                class="my-account-details-form__label"
                                                for="address"
                                            >{{__('theme.address')}}</label
                                            >
                                            <input
                                                class="my-account-details-form__input"
                                                type="text"
                                                name="address"
                                                id="address"
                                                placeholder="{{__('theme.address')}}"
                                                value="{{$user->profile->address}}"
                                                required
                                            />
                                        </li>
                                        <li class="my-account-details-form__item">
                                            <label
                                                class="my-account-details-form__label"
                                                for="phone"
                                            >{{__('theme.phone-number')}}</label
                                            >
                                            <input
                                                class="my-account-details-form__input"
                                                type="tel"
                                                name="phone"
                                                id="phone"
                                                placeholder="{{__('theme.phone-number')}}"
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
                                                    for="cod_fiscal"
                                                >{{__('theme.cod-fiscal')}}</label
                                                >
                                                <input
                                                    class="my-account-details-form__input"
                                                    type="text"
                                                    name="cod_fiscal"
                                                    id="cod_fiscal"
                                                    placeholder="{{__('theme.cod-fiscal')}}"
                                                    value="{{$user->profile->cod_fiscal}}"
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
                                        {{__('theme.save')}}
                                    </button>
                                </form>
                            </div>
                        </li>
                            <h3 class="my-account-details__name">{{__('theme.password')}}</h3>
                            <div class="my-account-details__inner">
                                <div class="my-account-details__text">
                                    {{__('theme.personal-information-save')}}
                                </div>
                                <form class="my-account-details-form" action="{{route('theme.user.account.password.update')}}" method="POST">
                                    @csrf
                                    <div class="password-requirements">
                                        <h3>{{__('theme.password-recommendations')}}:</h3>
                                        <ul class="mt-3">
                                            <li>
                                                {{__('theme.password-recommendations-uppercase')}}
                                            </li>
                                            <li>
                                                {{__('theme.password-recommendations-lowercase')}}
                                            </li>
                                            <li>
                                                {{__('theme.password-recommendations-numbers')}}
                                            </li>
                                        </ul>
                                    </div>
                                    <ul class="my-account-details-form__list mt-3">
                                        <li class="my-account-details-form__item">
                                            <label
                                                class="my-account-details-form__label"
                                                for="current_password"
                                            >{{__('theme.current-password')}}</label
                                            >
                                            <input
                                                required
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
                                            >{{__('theme.new-password')}}</label
                                            >
                                            <input
                                                required
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
                                            >{{__('theme.confirm-password')}}</label
                                            >
                                            <input
                                                required
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
                                        {{__('theme.save')}}
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
