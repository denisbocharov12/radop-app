{{--
    Reusable sortable list (manual save).

    Expected variables:
      $rows      array of ['id' => mixed, 'title' => string, 'code' => ?string, 'image' => ?string]
      $title     page heading
      $showImage bool (default true)  — show the thumbnail column
      $showCode  bool (default true)  — show the code (onec_id) column
      $codeLabel string (default 'Код (1C)')
--}}
@php
    $showImage = $showImage ?? true;
    $showCode  = $showCode ?? true;
    $codeLabel = $codeLabel ?? 'Код (1C)';
@endphp

<style>
    .sortable-toolbar { gap: 12px; }
    .sortable-list { list-style:none; margin:0; padding:0; }
    .sortable-head, .sortable-item {
        display:grid; align-items:center; gap:10px;
        grid-template-columns: 36px {{ $showImage ? '52px' : '' }} 1fr {{ $showCode ? '130px' : '' }} 96px 84px;
    }
    .sortable-head {
        padding:8px 12px; font-size:11px; font-weight:600; letter-spacing:.4px;
        color:#8094ae; text-transform:uppercase; border-bottom:1px solid #e5e9f2;
    }
    .sortable-item {
        padding:8px 12px; background:#fff; border:1px solid #e5e9f2; border-radius:6px;
        margin-bottom:6px; transition:box-shadow .15s, background .15s;
    }
    .sortable-item:hover { box-shadow:0 2px 8px rgba(0,0,0,.06); }
    .sortable-handle { cursor:grab; color:#8094ae; text-align:center; font-size:18px; }
    .sortable-handle:active { cursor:grabbing; }
    .sortable-thumb { width:44px; height:44px; display:flex; align-items:center; justify-content:center;
        border:1px solid #f0f3f7; border-radius:4px; overflow:hidden; background:#f8fafc; }
    .sortable-thumb img { max-width:100%; max-height:100%; object-fit:contain; }
    .sortable-title { font-weight:500; font-size:13px; line-height:1.3; }
    .sortable-code { font-size:12px; color:#8094ae; }
    .sortable-order .order-input { width:84px; text-align:center; }
    .sortable-actions { display:flex; gap:4px; justify-content:flex-end; }
    .sortable-placeholder { border:1px dashed #6576ff; background:#f5f6ff; border-radius:6px; margin-bottom:6px; height:60px; }
    .sortable-item.is-hidden { display:none; }
</style>

<div class="nk-block nk-block-lg">
    <div class="nk-block-head">
        <div class="nk-block-between sortable-toolbar flex-wrap">
            <div class="nk-block-head-content">
                <h4 class="title nk-block-title">{{ $title }}</h4>
                <div class="nk-block-des text-soft">
                    <p>Перетащите строки за <em class="icon ni ni-move"></em>, измените «Порядок» вручную или используйте кнопки. Изменения сохраняются по кнопке <strong>«Сохранить»</strong>.</p>
                </div>
            </div>
            <div class="nk-block-head-content">
                <button type="button" id="sortable-save" class="btn btn-primary">
                    <em class="icon ni ni-save"></em><span>Сохранить</span>
                </button>
            </div>
        </div>
    </div>

    <div class="card card-bordered">
        <div class="card-inner">
            <div class="form-control-wrap mb-3" style="max-width:440px;">
                <div class="form-icon form-icon-left"><em class="icon ni ni-search"></em></div>
                <input type="text" id="sortable-search" class="form-control"
                       placeholder="Поиск по названию{{ $showCode ? ' или коду' : '' }}...">
            </div>

            <div class="sortable-head">
                <span></span>
                @if($showImage)<span>Фото</span>@endif
                <span>Наименование</span>
                @if($showCode)<span>{{ $codeLabel }}</span>@endif
                <span class="text-center">Порядок</span>
                <span class="text-end">Действия</span>
            </div>

            <ul id="sortable-contents" class="sortable-list mt-2">
                @foreach($rows as $i => $row)
                    <li class="sortable-item" data-id="{{ $row['id'] }}"
                        data-title="{{ \Illuminate\Support\Str::lower((string)($row['title'] ?? '')) }}"
                        data-code="{{ \Illuminate\Support\Str::lower((string)($row['code'] ?? '')) }}">
                        <span class="sortable-handle" title="Перетащить"><em class="icon ni ni-move"></em></span>
                        @if($showImage)
                            <span class="sortable-thumb">
                                @if(!empty($row['image']))
                                    <img src="{{ $row['image'] }}" loading="lazy" alt="">
                                @else
                                    <em class="icon ni ni-img-fill" style="color:#dbdfea;font-size:20px;"></em>
                                @endif
                            </span>
                        @endif
                        <span class="sortable-title">{{ $row['title'] ?? '—' }}</span>
                        @if($showCode)
                            <span class="sortable-code">{{ $row['code'] ?? '—' }}</span>
                        @endif
                        <span class="sortable-order">
                            <input type="number" min="1" class="form-control form-control-sm order-input"
                                   value="{{ $i + 1 }}" title="Изменить порядок вручную">
                        </span>
                        <span class="sortable-actions">
                            <button type="button" class="btn btn-icon btn-sm btn-outline-light move-top" title="В самый верх">
                                <em class="icon ni ni-chevrons-up"></em>
                            </button>
                            <button type="button" class="btn btn-icon btn-sm btn-outline-light move-up" title="Поднять на одну позицию">
                                <em class="icon ni ni-chevron-up"></em>
                            </button>
                        </span>
                    </li>
                @endforeach
            </ul>

            @if(count($rows) === 0)
                <div class="text-soft text-center py-4">Нет элементов для сортировки</div>
            @endif
        </div>
    </div>
</div>
