@extends('v1.layouts.layout')

@section('content')
    <div class="nk-content ">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="nk-block-head nk-block-head-sm">
                        <div class="nk-block-between">
                            <div class="nk-block-head-content">
                                <h3 class="nk-block-title page-title">Экспорты менеджеров</h3>
                                <div class="nk-block-des text-soft">
                                    <p>Количество: {{ $files->total() }} файлов</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @include('v1.errors.errors')
                    <div class="nk-block">
                        <div class="card card-bordered card-stretch">
                            <div class="card-inner-group">
                                <div class="card-inner p-0">
                                    <div class="nk-tb-list nk-tb-ulist">
                                        <div class="nk-tb-item nk-tb-head">
                                            <div class="nk-tb-col"><span class="sub-text">Имя файла</span></div>
                                            <div class="nk-tb-col"><span class="sub-text">Размер</span></div>
                                            <div class="nk-tb-col"><span class="sub-text">Дата создания</span></div>
                                            <div class="nk-tb-col nk-tb-col-tools text-end"><span class="sub-text">Действия</span></div>
                                        </div>
                                        @forelse($files as $file)
                                            <div class="nk-tb-item">
                                                <div class="nk-tb-col">
                                                    <span>{{ $file['name'] }}</span>
                                                </div>
                                                <div class="nk-tb-col">
                                                    <span>{{ number_format($file['size'] / 1024, 2) }} KB</span>
                                                </div>
                                                <div class="nk-tb-col">
                                                    <span>{{ date('d.m.Y H:i', $file['modified']) }}</span>
                                                </div>
                                                <div class="nk-tb-col nk-tb-col-tools">
                                                    <ul class="nk-tb-actions gx-2">
                                                        <li>
                                                            <form action="{{ route('manager-export.download') }}" method="POST" style="display: inline;">
                                                                @csrf
                                                                <input type="hidden" name="file_name" value="{{ $file['name'] }}">
                                                                <button type="submit" class="btn btn-sm btn-primary">
                                                                    <em class="icon ni ni-download"></em>
                                                                    <span>Скачать</span>
                                                                </button>
                                                            </form>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="nk-tb-item">
                                                <div class="nk-tb-col">
                                                    <span class="text-muted">Файлы не найдены</span>
                                                </div>
                                                <div class="nk-tb-col"></div>
                                                <div class="nk-tb-col"></div>
                                                <div class="nk-tb-col"></div>
                                            </div>
                                        @endforelse
                                    </div>
                                </div>
                                @if($files->hasPages())
                                    <div class="card-inner">
                                        {{ $files->links() }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

