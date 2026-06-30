@extends('v2.layouts.app')

@section('content')
    @php $aiDefault = config('seo_ai.provider', 'gemini'); @endphp
    <x-page-header>
        <x-slot:title>
            <span class="inline-flex items-center gap-2">
                Редактирование SEO записи — {{ strtoupper($seoMeta->locale) }}
                @if($seoMeta->ai_generated)
                    <x-badge type="info" title="Сгенерировано AI">AI</x-badge>
                @endif
            </span>
        </x-slot:title>
        <x-slot:description>{{ $pageTypes[$seoMeta->page_type] ?? $seoMeta->page_type }}{{ $seoMeta->page_id ? ' · ID: '.$seoMeta->page_id : '' }}</x-slot:description>
        <x-slot:actions>
            <div class="flex items-center gap-2">
                <select id="ai-provider-select" class="no-select2 rounded-lg border border-gray-300 px-2 py-1.5 text-sm focus:border-brand-500 focus:ring-1 focus:ring-brand-500 focus:outline-none" title="AI провайдер">
                    <option value="gemini" {{ $aiDefault === 'gemini' ? 'selected' : '' }}>Google Gemini</option>
                    <option value="claude" {{ $aiDefault === 'claude' ? 'selected' : '' }}>Anthropic Claude</option>
                </select>
                <button type="button" id="ai-regenerate-btn" class="btn-warning" data-seo-id="{{ $seoMeta->id }}">
                    <i data-lucide="sparkles" class="h-4 w-4"></i>
                    <span>Регенерировать с AI</span>
                </button>
                <a href="{{ route('seo_meta.index') }}" class="btn-secondary">
                    <i data-lucide="arrow-left" class="h-4 w-4"></i>
                    <span>Назад</span>
                </a>
            </div>
        </x-slot:actions>
    </x-page-header>

    @if ($errors->any())
        <x-alert type="error" class="mb-5">
            <ul class="list-disc pl-5 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </x-alert>
    @endif

    <x-card>
        <form action="{{route('seo_meta.update', $seoMeta)}}" enctype="multipart/form-data" method="POST" class="space-y-5">
            @csrf
            @method('PUT')
            <input type="hidden" name="locale" value="{{$seoMeta->locale}}" required>

            <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                <div>
                    <label for="page_type" class="mb-1 block text-sm font-medium text-gray-700">Тип страницы</label>
                    <select id="page_type" name="page_type" required
                            class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-brand-500 focus:ring-1 focus:ring-brand-500 focus:outline-none">
                        <option value="">Выберите тип страницы</option>
                        @foreach($pageTypes as $value => $label)
                            <option value="{{ $value }}" {{ old('page_type', $seoMeta->page_type) == $value ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="page_id" class="mb-1 block text-sm font-medium text-gray-700">ID страницы</label>
                    <input type="text" id="page_id" name="page_id" value="{{$seoMeta->page_id}}" placeholder="ID страницы"
                           class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-brand-500 focus:ring-1 focus:ring-brand-500 focus:outline-none @error('page_id') border-red-400 @enderror">
                    @error('page_id')<span class="mt-1 block text-xs text-red-600">{{ $message }}</span>@enderror
                </div>

                <div>
                    <label for="title" class="mb-1 block text-sm font-medium text-gray-700">Заголовок</label>
                    <input type="text" required id="title" name="title" value="{{$seoMeta->title}}" placeholder="Заголовок"
                           class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-brand-500 focus:ring-1 focus:ring-brand-500 focus:outline-none @error('title') border-red-400 @enderror">
                    @error('title')<span class="mt-1 block text-xs text-red-600">{{ $message }}</span>@enderror
                </div>

                <div>
                    <label for="keywords" class="mb-1 block text-sm font-medium text-gray-700">Ключевые слова</label>
                    <input type="text" id="keywords" name="keywords" value="{{$seoMeta->keywords}}" placeholder="Ключевые слова через запятую"
                           class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-brand-500 focus:ring-1 focus:ring-brand-500 focus:outline-none @error('keywords') border-red-400 @enderror">
                    @error('keywords')<span class="mt-1 block text-xs text-red-600">{{ $message }}</span>@enderror
                </div>
            </div>

            <div>
                <label for="description" class="mb-1 block text-sm font-medium text-gray-700">Описание</label>
                <textarea id="description" name="description" rows="4" placeholder="Описание"
                          class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-brand-500 focus:ring-1 focus:ring-brand-500 focus:outline-none @error('description') border-red-400 @enderror">{{$seoMeta->description}}</textarea>
                @error('description')<span class="mt-1 block text-xs text-red-600">{{ $message }}</span>@enderror
            </div>

            <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                <div>
                    <label for="canonical" class="mb-1 block text-sm font-medium text-gray-700">Каноническая ссылка</label>
                    <div class="flex items-stretch gap-2">
                        <input type="text" id="canonical" name="canonical"
                               value="{{ $seoMeta->canonical ?? $suggestedCanonical ?? '' }}" placeholder="https://radop.md/..."
                               class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-brand-500 focus:ring-1 focus:ring-brand-500 focus:outline-none @error('canonical') border-red-400 @enderror">
                        @if(!empty($suggestedCanonical))
                            <button type="button" class="btn-secondary shrink-0" title="Подставить автоматически определённый URL"
                                    onclick="document.getElementById('canonical').value='{{ $suggestedCanonical }}'">
                                <i data-lucide="link" class="h-4 w-4"></i>
                            </button>
                        @endif
                    </div>
                    @if(!empty($suggestedCanonical))
                        <div class="mt-1 flex items-center gap-1 text-xs text-gray-500">
                            <i data-lucide="info" class="h-3.5 w-3.5 text-brand-600"></i>
                            Авто: <code class="rounded bg-gray-100 px-1 py-0.5 text-[11px]">{{ $suggestedCanonical }}</code>
                        </div>
                    @endif
                    @error('canonical')<span class="mt-1 block text-xs text-red-600">{{ $message }}</span>@enderror
                </div>

                <div>
                    <label for="robots" class="mb-1 block text-sm font-medium text-gray-700">Robots</label>
                    <input type="text" id="robots" name="robots" value="{{$seoMeta->robots}}" placeholder="Robots"
                           class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-brand-500 focus:ring-1 focus:ring-brand-500 focus:outline-none @error('robots') border-red-400 @enderror">
                    @error('robots')<span class="mt-1 block text-xs text-red-600">{{ $message }}</span>@enderror
                </div>
            </div>

            <div>
                <label class="mb-1 block text-sm font-medium text-gray-700">SEO изображение</label>
                <input type="file" name="attachments[]" multiple id="seoAttachments"
                       class="block w-full text-sm text-gray-600 file:mr-4 file:rounded-lg file:border-0 file:bg-brand-50 file:px-4 file:py-2 file:text-sm file:font-medium file:text-brand-700 hover:file:bg-brand-100">
            </div>

            @if($seoMeta->getMedia('files')->count())
                <div>
                    <h3 class="mb-3 text-sm font-semibold text-gray-900">SEO изображения</h3>
                    <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-4">
                        @foreach($seoMeta->getMedia('files') as $image)
                            <div id="model-media-{{$image->id}}" class="overflow-hidden rounded-lg border border-gray-200 bg-white">
                                <a href="{{$image->getUrl()}}" target="_blank" class="block">
                                    <img class="h-32 w-full object-cover" src="{{$image->getUrl()}}" alt="">
                                </a>
                                <div class="flex items-center justify-between gap-2 px-3 py-2">
                                    <span class="truncate text-xs text-gray-600">#{{$image->id}} — {{$image->name}}</span>
                                    <a href="#" data-id="{{$image->id}}" data-model-id="{{$seoMeta->id}}"
                                       class="model-media-delete shrink-0 text-gray-400 hover:text-red-600" title="Удалить">
                                        <i data-lucide="trash-2" class="h-4 w-4"></i>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="flex items-center gap-3 border-t border-gray-100 pt-5">
                <button type="submit" class="btn-primary">
                    <i data-lucide="save" class="h-4 w-4"></i>
                    <span>Обновить SEO запись</span>
                </button>
                <button type="button" class="btn-danger seo-delete-btn" data-id="{{ $seoMeta->id }}" data-page-type="{{ $pageTypes[$seoMeta->page_type] ?? $seoMeta->page_type }}">
                    <i data-lucide="trash-2" class="h-4 w-4"></i>
                    <span>Удалить запись</span>
                </button>
            </div>
        </form>
    </x-card>
@endsection

@section('scripts')
    <script>
        function notify(text, type) {
            if (window.Alpine && window.Alpine.store('toast')) window.Alpine.store('toast').add(text, type === 'error' ? 'error' : 'success');
            else alert(text);
        }

        // AI Regenerate
        $('#ai-regenerate-btn').on('click', function() {
            const btn = $(this);
            const seoId = btn.data('seo-id');

            if (!confirm('Регенерировать SEO данные с помощью AI?\nТекущие значения заголовка, описания и ключевых слов будут заменены.')) return;

            const original = btn.html();
            btn.prop('disabled', true).html('<i data-lucide="loader" class="h-4 w-4 animate-spin"></i><span>Генерация...</span>');
            if (window.renderIcons) window.renderIcons();

            const provider = $('#ai-provider-select').val() || 'gemini';

            $.ajax({
                url: '/admin/seo/' + seoId + '/regenerate',
                type: 'POST',
                data: { _token: '{{ csrf_token() }}', provider },
                success: function(response) {
                    if (response.status && response.data) {
                        const d = response.data;
                        if (d.title)       $('#title').val(d.title);
                        if (d.description) $('#description').val(d.description);
                        if (d.keywords)    $('#keywords').val(d.keywords);
                        notify('SEO регенерирован. Сохраните форму для применения изменений.', 'success');
                    } else {
                        notify('Ошибка: ' + (response.message || 'Не удалось сгенерировать SEO'), 'error');
                    }
                },
                error: function(xhr) {
                    const res = xhr.responseJSON || {};
                    if (xhr.status === 402 || res.billing) {
                        notify('💳 ' + (res.message || 'Недостаточно средств на балансе AI API.'), 'error');
                    } else if (xhr.status === 429 || res.quota) {
                        notify('⚠️ ' + (res.message || 'Превышен лимит Gemini API. Попробуйте позже.'), 'error');
                    } else {
                        notify('Ошибка: ' + (res.message || 'Ошибка запроса. Проверьте GEMINI_API_KEY в .env'), 'error');
                    }
                },
                complete: function() {
                    btn.prop('disabled', false).html(original);
                    if (window.renderIcons) window.renderIcons();
                }
            });
        });

        $(document).on('click','.model-media-delete',function (e) {
            e.preventDefault();
            var image_id = $(this).data('id');
            var token = "{{csrf_token()}}";
            var path = "{{route('seo_meta.media.delete', $seoMeta)}}";
            $.ajax({
                url: path,
                type: "GET",
                dataType:"JSON",
                data:{ id: image_id, _token: token },
                success:function (response) {
                    if(response.status) {
                        $('#model-media-'+image_id).fadeOut();
                    }
                }
            });
        });

        $(document).on('click', '.seo-delete-btn', function(e) {
            e.preventDefault();
            const id = $(this).data('id');
            const pageType = $(this).data('page-type');

            if (confirm(`Вы уверены, что хотите удалить SEO запись для "${pageType}"?`)) {
                const deleteBtn = $(this);
                const original = deleteBtn.html();
                deleteBtn.prop('disabled', true).html('<i data-lucide="loader" class="h-4 w-4 animate-spin"></i><span>Удаление...</span>');
                if (window.renderIcons) window.renderIcons();

                $.ajax({
                    url: `/admin/seo/${id}/ajax-delete`,
                    type: 'DELETE',
                    data: { _token: '{{ csrf_token() }}' },
                    success: function(response) {
                        if (response.status) {
                            notify('Запись успешно удалена', 'success');
                            setTimeout(function() {
                                window.location.href = '{{ route("seo_meta.index") }}';
                            }, 1000);
                        } else {
                            notify(response.message || 'Ошибка при удалении', 'error');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Delete Error:', xhr, status, error);
                        notify('Ошибка при удалении записи', 'error');
                    },
                    complete: function() {
                        deleteBtn.prop('disabled', false).html(original);
                        if (window.renderIcons) window.renderIcons();
                    }
                });
            }
        });
    </script>
@endsection
