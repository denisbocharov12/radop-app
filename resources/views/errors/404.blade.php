@extends('errors.sf-layout')

@section('code', '404')
@section('title', __('theme.sf-error-404-title'))
@section('message', __('theme.sf-error-404-text'))
@section('search', 1)

@section('actions')
    <a href="{{ url('/shop/catalog') }}" class="sf-btn-primary">
        <x-sf-icon name="grid" :size="16" />{{ __('theme.go-to-catalog') }}
    </a>
    <a href="{{ url('/') }}" class="sf-btn-secondary">{{ __('theme.on-homepage') }}</a>
@endsection
