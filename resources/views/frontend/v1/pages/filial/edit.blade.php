@extends('frontend.v1.layouts.layout')

@section('sf-page', 1)

@section('content')
    @include('frontend.v1.pages.filial.form', [
        'action' => route('theme.user.filial.update', $filial),
        'heading' => __('theme.edit_filial'),
        'submit' => __('theme.update_filial'),
        'filial' => $filial,
    ])
@endsection
