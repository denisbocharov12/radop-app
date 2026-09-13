@extends('errors.sf-layout')

{{--
    The account area answers 403 (CheckClientStatus) to guests and to accounts
    that are not activated yet, rather than redirecting. Offer the way in
    instead of a bare "Forbidden".
--}}
@section('code', '403')
@section('title', __('theme.sf-error-403-title'))
@section('message', __('theme.sf-error-403-text'))

@section('actions')
    <a href="{{ url('/?auth=login') }}" class="sf-btn-primary">
        <x-sf-icon name="user" :size="16" />{{ __('theme.log-in-account') }}
    </a>
    <a href="{{ url('/registration') }}" class="sf-btn-secondary">{{ __('theme.registration') }}</a>
    <a href="{{ url('/') }}" class="sf-btn-ghost">{{ __('theme.on-homepage') }}</a>
@endsection
