@extends('v1.layouts.layout')

@section('content')
    <div class="nk-content ">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="nk-block-head nk-block-head-sm">
                        <div class="nk-block-between">
                            <div class="nk-block-head-content">
                                <h3 class="nk-block-title page-title">SEO Мета-теги</h3>
                                <div class="nk-block-des text-soft">
                                    <p>Количество: {{ $seoMetas->total() }} ед.</p>
                                </div>
                            </div>
                            <div class="nk-block-head-content">
                                <div class="toggle-wrap nk-block-tools-toggle">
                                    <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em class="icon ni ni-menu-alt-r"></em></a>
                                    <div class="toggle-expand-content" data-content="pageMenu">
                                        <ul class="nk-block-tools g-3">
                                            <li class="nk-block-tools-opt">
                                                <div class="drodown">
                                                    <a href="#" class="dropdown-toggle btn btn-icon btn-primary" data-bs-toggle="dropdown"><em class="icon ni ni-plus"></em></a>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <ul class="link-list-opt no-bdr">
                                                            <li><a href="{{ route('seo_meta.create') }}"><span>Добавить SEO-запись</span></a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @include('v1.errors.errors')
                    <div class="nk-block">
                        <div class="card card-bordered card-stretch">
                            <div class="card-inner-group">
                                <div class="card-inner">
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Тип страницы</th>
                                                    <th>ID страницы</th>
                                                    <th>RU</th>
                                                    <th>RO</th>
                                                    <th>Действия</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($seoMetas as $group)
                                                    <tr>
                                                        <td>
                                                            @php
                                                                $pageTypes = app(\App\Enums\PageTypes::class)->getAll();
                                                                $pageTypeLabel = $pageTypes[$group['page_type']] ?? $group['page_type'];
                                                            @endphp
                                                            {{ $pageTypeLabel }}
                                                        </td>
                                                        <td>{{ $group['page_id'] }}</td>
                                                        <td>
                                                            @if($group['ru'])
                                                                {{ \Illuminate\Support\Str::limit($group['ru']->title, 50) }}
                                                            @else
                                                                —
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if($group['ro'])
                                                                {{ \Illuminate\Support\Str::limit($group['ro']->title, 50) }}
                                                            @else
                                                                —
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <a href="{{ route('seo_meta.edit', $group['ru'] ?? $group['ro']) }}" class="btn btn-sm btn-primary">
                                                                <em class="icon ni ni-edit"></em>
                                                                <span>Редактировать</span>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                @if($seoMetas->hasPages())
                                    <div class="card-inner">
                                        {{ $seoMetas->links() }}
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
