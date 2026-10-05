@props([
    /** Сколько значений в группе всего — показываем в подписи. */
    'total' => null,
])

{{-- Кнопка «показать все / свернуть» для длинной группы фильтров: вместо
     собственной полосы прокрутки группа раскрывается по месту. --}}
<button
    type="button"
    class="mt-1 px-1 text-xs font-medium text-brand-600 hover:text-brand-700"
    data-sf-more-toggle
    data-label-more="{{ __('theme.sf-brands-show-all') }}{{ $total ? ' (' . $total . ')' : '' }}"
    data-label-less="{{ __('theme.sf-brands-collapse') }}"
>{{ __('theme.sf-brands-show-all') }}{{ $total ? ' (' . $total . ')' : '' }}</button>
