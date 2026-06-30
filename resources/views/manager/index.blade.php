@extends('v2.layouts.app')

@section('title', 'Менеджеры')
@section('breadcrumb')<span class="text-gray-700">Менеджеры</span>@endsection

@section('content')
    <x-page-header title="Пользователи без менеджера"
                   description="Назначьте ответственного менеджера клиентам, у которых он ещё не задан." />

    @if($errors->any())
        <x-alert type="error" class="mb-4">
            <ul class="list-disc list-inside space-y-0.5">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </x-alert>
    @endif

    <div class="card">
        <div class="table-wrap">
            <table class="data-table">
                @include('manager.table.content')
            </table>
        </div>
        @if($users instanceof \Illuminate\Contracts\Pagination\Paginator)
            <x-pager :paginator="$users" />
        @endif
    </div>
@endsection
