@props(['icon' => 'inbox', 'title' => 'Нет данных', 'text' => null])

<div class="empty-state">
    <i data-lucide="{{ $icon }}" class="empty-state-icon"></i>
    <p class="empty-state-title">{{ $title }}</p>
    @if($text)
        <p class="empty-state-text">{{ $text }}</p>
    @endif
    @isset($action)
        <div class="mt-4">{{ $action }}</div>
    @endisset
</div>
