@extends('errors.sf-layout')

{{-- Expired CSRF token: usually a form left open overnight. --}}
@section('code', '419')
@section('title', __('theme.sf-error-419-title'))
@section('message', __('theme.sf-error-419-text'))

@section('actions')
    <a href="{{ url()->previous() ?: url('/') }}" class="sf-btn-primary">
        <x-sf-icon name="chevronLeft" :size="16" />{{ __('theme.sf-error-back') }}
    </a>
    <a href="{{ url('/') }}" class="sf-btn-secondary">{{ __('theme.on-homepage') }}</a>
@endsection
