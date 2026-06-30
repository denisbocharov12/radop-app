@extends('v2.layouts.app')

@section('title', 'Атрибуты')
@section('breadcrumb')<span class="text-gray-700">Атрибуты</span>@endsection

@section('content')
    <x-page-header title="Атрибуты" description="Всего атрибутов: {{ $attributeItems->total() }}" />

    <x-alert type="info" class="mb-4">
        Атрибуты синхронизируются из 1C. Здесь доступен просмотр и сортировка.
    </x-alert>

    <div class="card">
        <div class="table-wrap">
            <table class="data-table">
                @include('attribute.table.content')
            </table>
        </div>
        @include('attribute.table.footer', ['attributeItems' => $attributeItems])
    </div>
@endsection
