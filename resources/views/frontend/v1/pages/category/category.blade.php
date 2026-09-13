@extends('frontend.v1.layouts.layout')

@section('content')
    @include('frontend.v1.pages.category.parts.breadcrumbs')
    @include('frontend.v1.components.breadcrumb-schema', ['items' => $breadcrumbs])
    @include('frontend.v1.pages.category.parts.child-category')
@endsection

@section('scripts')
@endsection
