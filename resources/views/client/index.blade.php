@extends('v2.layouts.app')

@section('title', 'Клиенты')
@section('breadcrumb')<span class="text-gray-700">Клиенты</span>@endsection

@section('content')
    <x-page-header title="Клиенты" description="Всего в базе: {{ $users->total() }}">
        <x-slot:actions>
            <button type="button" class="btn-primary btn-sm" @click="$dispatch('open-modal', 'client-create')">
                <i data-lucide="user-plus" class="w-4 h-4"></i> Добавить клиента
            </button>
        </x-slot:actions>
    </x-page-header>

    @if($errors->any())
        <x-alert type="error" class="mb-4">
            <ul class="list-disc list-inside space-y-0.5">
                @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
            </ul>
        </x-alert>
    @endif

    <div class="card">
        @include('client.table.head')
        <div class="table-wrap">
            <table class="data-table">
                @include('client.table.content')
            </table>
        </div>
        @include('client.table.footer')
    </div>

    @include('client.modal.create')
@endsection
