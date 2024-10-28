@extends('layout')

@section('content')
    <x-title :primary="__('emails.password_reset')"/>
    <x-content>
        <div style="word-break: break-word; margin-top: 20px;">{{ __('emails.password_has_been_reset') }}</div>
    </x-content>
@endsection
