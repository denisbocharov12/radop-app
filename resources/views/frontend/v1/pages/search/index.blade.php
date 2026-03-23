@extends('frontend.v1.layouts.layout')

@section('content')
    @include('frontend.v1.pages.search.parts.breadcrumbs')
    @include('frontend.v1.pages.search.parts.shop')
@endsection

@section('scripts')
    @include('frontend.v1.analytics.ga4-item-lists')
@endsection
