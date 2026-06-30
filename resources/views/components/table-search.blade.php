@props(['placeholder' => 'Поиск...', 'name' => 'search', 'value' => null])

<div class="search-bar w-full sm:w-64">
    <i data-lucide="search" class="search-icon"></i>
    <input type="search" name="{{ $name }}" value="{{ $value ?? request($name) }}"
           placeholder="{{ $placeholder }}" {{ $attributes }}>
</div>
