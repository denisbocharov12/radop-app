<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Examples</title>
    <link rel="stylesheet" href="{{ asset('css/mega-menu.css') }}">
</head>
<body>

<h1>Примеры использования меню</h1>

{{-- Пример 1: Через Blade Directive --}}
<h2>1. Через Blade Directive @renderMenu</h2>
@renderMenu('main_catalog', 'header__catalog-menu')

{{-- Пример 2: Через @include с загрузкой данных в контроллере --}}
<h2>2. Через @include (данные из контроллера)</h2>
@php
    $catalogMenu = app('App\Services\MenuRenderService')->getMenuData('main_catalog');
@endphp
@if($catalogMenu)
    @include('partials.menus.mega-menu', [
        'menu' => $catalogMenu,
        'cssClass' => 'custom-class',
        'code' => 'main_catalog'
    ])
@endif

{{-- Пример 3: Простое меню --}}
<h2>3. Простое меню</h2>
@php
    $headerMenu = app('App\Services\MenuRenderService')->getMenuData('header_menu');
@endphp
@if($headerMenu)
    @include('partials.menus.simple-menu', [
        'menu' => $headerMenu,
        'cssClass' => 'header-menu',
        'code' => 'header_menu'
    ])
@endif

{{-- Пример 4: Через Service в контроллере (рекомендуемый способ) --}}
<h2>4. Данные переданы из контроллера</h2>
{{-- 
В контроллере:
use App\Services\MenuRenderService;

public function index(MenuRenderService $menuRenderService)
{
    $mainCatalog = $menuRenderService->getMenuData('main_catalog');
    return view('home', compact('mainCatalog'));
}

В view:
@include('partials.menus.mega-menu', ['menu' => $mainCatalog, 'cssClass' => '', 'code' => 'main_catalog'])
--}}

</body>
</html>

