@extends('v2.layouts.app')

@section('content')
    <x-page-header title="1С Предприятие"
                   description="Импорт и синхронизация каталога из 1С: категории, бренды, номенклатура, атрибуты и изображения." />

    <div class="grid grid-cols-1 gap-5 lg:grid-cols-2">

        {{-- Категории --}}
        @include('onec.partials.import-card', [
            'title'  => 'Импорт категорий',
            'action' => route('import-export-data.categories'),
            'btn'    => 'Импортировать категории',
            'batch'  => $categoryBatch,
            'count'  => \App\Models\Category::all()->count(),
        ])

        {{-- Брэнды --}}
        @include('onec.partials.import-card', [
            'title'  => 'Импорт брэндов',
            'action' => route('import-export-data.brands'),
            'btn'    => 'Импортировать брэнды',
            'batch'  => $brandBatch,
            'count'  => \App\Models\Brand::all()->count(),
        ])

        {{-- Номенклатура (+ таблица ошибок импорта) --}}
        <x-card>
            <h5 class="text-base font-semibold text-gray-900 mb-3">Импорт номенклатуры</h5>
            <form action="{{ route('import-export-data.nomenclature') }}" enctype="multipart/form-data" method="POST" class="space-y-3">
                @csrf
                <input type="file" name="attachment"
                       class="block w-full text-sm text-gray-700 file:mr-3 file:rounded-lg file:border-0 file:bg-brand-600 file:px-4 file:py-2 file:text-white hover:file:bg-brand-700 border border-gray-300 rounded-lg cursor-pointer focus:outline-none">
                <button type="submit" class="btn-primary">
                    <i data-lucide="settings" class="w-4 h-4"></i> Импортировать номенклатуру
                </button>
            </form>

            @if($productBatch !== null)
                @php $batch = \Illuminate\Support\Facades\Bus::findBatch($productBatch->id); @endphp
                <div class="mt-4 border-t border-gray-100 pt-4">
                    <h6 class="text-sm font-semibold text-gray-800 mb-2">Последний импорт — {{ $batch->createdAt }}</h6>
                    <dl class="grid grid-cols-2 gap-x-4 gap-y-1 text-xs text-gray-600 mb-2">
                        <div><span class="font-medium text-gray-700">Завершён:</span> {{ $batch->finishedAt }}</div>
                        <div><span class="font-medium text-gray-700">Ошибки:</span> {{ $batch->failedJobs }}</div>
                        <div><span class="font-medium text-gray-700">Кол-во:</span> {{ \App\Models\Product::all()->count() }}</div>
                    </dl>
                    <div class="h-2.5 w-full overflow-hidden rounded-full bg-gray-100">
                        <div class="h-full rounded-full bg-brand-600 transition-all" style="width: {{ $batch->progress() }}%"></div>
                    </div>
                    <p class="mt-1 text-xs text-gray-500">{{ $batch->progress() }}%</p>
                </div>

                @if($productImportFailedAnalyses->isNotEmpty())
                    <div class="mt-4 border-t border-gray-100 pt-4">
                        <h6 class="text-sm font-semibold text-gray-800 mb-2">Последние ошибки импорта (failed jobs)</h6>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-100 text-xs">
                                <thead class="bg-gray-50">
                                    <tr class="text-left text-gray-500">
                                        <th class="px-3 py-2">Дата</th>
                                        <th class="px-3 py-2">Причина (EN)</th>
                                        <th class="px-3 py-2">Товар (onec_id / название)</th>
                                        <th class="px-3 py-2">Исключение</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @foreach($productImportFailedAnalyses as $analysis)
                                        <tr>
                                            <td class="px-3 py-2 whitespace-nowrap text-gray-600">{{ \Carbon\Carbon::parse($analysis['failed_at'])->format('d.m.Y H:i') }}</td>
                                            <td class="px-3 py-2 text-gray-700">{{ $analysis['reason_en'] }}</td>
                                            <td class="px-3 py-2 text-gray-700">
                                                @forelse($analysis['products'] as $p)
                                                    <span class="block"><strong>{{ $p['onec_id'] }}</strong> {{ Str::limit($p['title'], 40) }}</span>
                                                @empty
                                                    —
                                                @endforelse
                                            </td>
                                            <td class="px-3 py-2 text-gray-500">{{ Str::limit($analysis['exception_preview'], 120) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
            @endif
        </x-card>

        {{-- Синхронизация категорий из номенклатуры --}}
        @include('onec.partials.import-card', [
            'title'  => 'Синхронизация категорий из номенклатуры',
            'desc'   => 'Очистка таблицы связей товар–категория и поочередная синхронизация по загруженному файлу номенклатуры',
            'action' => route('import-export-data.nomenclature-sync-categories'),
            'btn'    => 'Синхронизировать категории',
        ])

        {{-- Упаковка --}}
        @if(!\App\Models\Product::query()->count() < 1)
            @include('onec.partials.import-card', [
                'title'  => 'Импорт упаковки',
                'action' => route('import-export-data.package'),
                'btn'    => 'Импортировать упаковку',
                'batch'  => $packageBatch,
            ])
        @endif

        {{-- Описания (+ сброс) --}}
        @if(!\App\Models\Product::query()->count() < 1)
            <x-card>
                <h5 class="text-base font-semibold text-gray-900 mb-3">Импорт описания</h5>
                <form action="{{ route('import-export-data.description') }}" enctype="multipart/form-data" method="POST" class="space-y-3">
                    @csrf
                    <input type="file" name="attachment"
                           class="block w-full text-sm text-gray-700 file:mr-3 file:rounded-lg file:border-0 file:bg-brand-600 file:px-4 file:py-2 file:text-white hover:file:bg-brand-700 border border-gray-300 rounded-lg cursor-pointer focus:outline-none">
                    <button type="submit" class="btn-primary">
                        <i data-lucide="settings" class="w-4 h-4"></i> Импортировать описания
                    </button>
                </form>
                <form action="{{ route('import-export-data.descriptions.reset') }}" method="POST" class="mt-3"
                      onsubmit="return confirm('Вы уверены, что хотите сбросить все описания товаров?')">
                    @csrf
                    <button type="submit" class="btn-danger">
                        <i data-lucide="trash-2" class="w-4 h-4"></i> Сбросить описания
                    </button>
                </form>

                @if($descriptionBatch !== null)
                    @php $batch = \Illuminate\Support\Facades\Bus::findBatch($descriptionBatch->id); @endphp
                    <div class="mt-4 border-t border-gray-100 pt-4">
                        <h6 class="text-sm font-semibold text-gray-800 mb-2">Последний импорт — {{ $batch->createdAt }}</h6>
                        <dl class="grid grid-cols-2 gap-x-4 gap-y-1 text-xs text-gray-600 mb-2">
                            <div><span class="font-medium text-gray-700">Завершён:</span> {{ $batch->finishedAt }}</div>
                            <div><span class="font-medium text-gray-700">Ошибки:</span> {{ $batch->failedJobs }}</div>
                        </dl>
                        <div class="h-2.5 w-full overflow-hidden rounded-full bg-gray-100">
                            <div class="h-full rounded-full bg-brand-600 transition-all" style="width: {{ $batch->progress() }}%"></div>
                        </div>
                        <p class="mt-1 text-xs text-gray-500">{{ $batch->progress() }}%</p>
                    </div>
                @endif
            </x-card>
        @endif

        {{-- Аттрибуты --}}
        @include('onec.partials.import-card', [
            'title'  => 'Импорт аттрибутов',
            'action' => route('import-export-data.attribute'),
            'btn'    => 'Импортировать аттрибуты',
            'batch'  => $attributeBatch,
            'count'  => \App\Models\Attribute::all()->count(),
        ])

        {{-- Значения аттрибутов --}}
        @if(!\App\Models\Attribute::query()->count() < 1)
            @include('onec.partials.import-card', [
                'title'     => 'Импорт значений аттрибутов',
                'action'    => route('import-export-data.values'),
                'btn'       => 'Импортировать значения',
                'batch'     => $attributeValueBatch,
                'count'     => \App\Models\AttributeValue::all()->count(),
                'totalJobs' => true,
            ])
        @endif

        {{-- Импорт изображений товаров --}}
        @include('onec.partials.import-card', [
            'title'    => 'Импорт изображений товаров',
            'desc'     => 'Оптимизация и создание responsive изображений для всех товаров',
            'action'   => route('import-export-data.images'),
            'btn'      => 'Импортировать и оптимизировать изображения',
            'file'     => false,
            'btnClass' => 'btn-success',
        ])

        {{-- Оптимизация изображений брендов --}}
        @include('onec.partials.import-card', [
            'title'  => 'Оптимизация изображений для брендов',
            'desc'   => 'Оптимизация изображений для всех брендов',
            'action' => route('import-export-data.brand-images.optimize'),
            'btn'    => 'Оптимизировать изображения для уже загруженных брендов',
            'file'   => false,
        ])

    </div>
@endsection
