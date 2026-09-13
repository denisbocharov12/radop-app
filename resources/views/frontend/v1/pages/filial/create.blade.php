@extends('frontend.v1.layouts.layout')

@section('sf-page', 1)

@section('content')
    @include('frontend.v1.pages.filial.form', [
        'action' => route('theme.user.filial.store'),
        'heading' => __('theme.create_filial'),
        'submit' => __('theme.save_filial'),
        'filial' => null,
    ])
@endsection
