@extends('layout')

@section('content')
    <x-title :primary="__('emails.password_reset')"/>
    <x-content>
        <div style="word-break: break-word; margin-top: 20px;">{{ __('emails.password_reset_action') }}</div>
        <a href="{{ config('app.frontend_url') }}/auth/reset-password?token={{ $token }}">
            {{ config('app.frontend_url') }}/auth/reset-password?token={{ $token }}</a>
    </x-content>
@endsection
