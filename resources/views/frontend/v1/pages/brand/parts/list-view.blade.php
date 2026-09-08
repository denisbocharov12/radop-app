{{-- Product grid returned by the AJAX filter endpoints
     (ThemeBrandController / ThemeCategoryController / ThemeShopController).
     Renders the same card the server-rendered listings use, so a filtered
     response cannot drift out of style with the page it lands in. --}}
@foreach($products as $product)
    <x-sf-product-card
        :product="$product"
        :list-id="$ga4ItemListId ?? null"
        :list-name="$ga4ItemListName ?? null"
    />
@endforeach
