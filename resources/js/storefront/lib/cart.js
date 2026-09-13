/**
 * Cart transport shared by every island that can change the basket.
 *
 * Talks to the same endpoints the legacy jQuery used, so server behaviour is
 * unchanged. Results are broadcast once on `document` (header badge, mini-cart,
 * product cards listen) and the GA4 payloads the server attaches are pushed to
 * the dataLayer exactly as scripts.blade.php did, so ecommerce reporting keeps
 * receiving add_to_cart / remove_from_cart.
 */

/**
 * Endpoints come from `window.__SF__.routes`, printed by the layout with
 * route(), so they carry the locale prefix. The fallbacks only matter if an
 * island is ever rendered outside the storefront layout.
 */
export function route(name, fallback) {
    return window.__SF__?.routes?.[name] ?? fallback;
}

export function csrf() {
    return document.querySelector('meta[name="csrf-token"]')?.content ?? '';
}

export async function postJson(url, payload) {
    const res = await fetch(url, {
        method: 'POST',
        credentials: 'same-origin',
        headers: {
            Accept: 'application/json',
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': csrf(),
        },
        body: JSON.stringify(payload),
    });

    if (!res.ok) throw new Error(`HTTP ${res.status}`);

    return res.json();
}

export async function getJson(url) {
    const res = await fetch(url, {
        credentials: 'same-origin',
        headers: { Accept: 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
    });
    if (!res.ok) throw new Error(`HTTP ${res.status}`);
    return res.json();
}

function broadcast(response) {
    document.dispatchEvent(new CustomEvent('sf:cart-updated', { detail: response }));
}

/**
 * Push the GA4 ecommerce payload the server attached under
 * `radopAnalyticsJsonPayloadKeys[key]`, using the helpers defined in
 * scripts.blade.php. Silently does nothing when analytics is not loaded.
 */
export function pushEcommerce(key, response, { quantityPayload = true } = {}) {
    const keys = window.radopAnalyticsJsonPayloadKeys ?? {};
    const events = window.radopAnalyticsDataLayerEventNames ?? {};
    const payloadKey = keys[key];
    const data = payloadKey ? response?.[payloadKey] : null;

    if (!data || typeof window.radopGa4EcommercePush !== 'function' || !events[key]) return;

    // Cart payloads arrive as a single line; wishlist payloads are already a
    // complete ecommerce object.
    const ecommerce = quantityPayload
        ? {
            currency: window.radopGaCurrency || 'MDL',
            value: Number(data.price) * Number(data.quantity),
            items: [{
                item_id: String(data.item_id),
                item_name: String(data.item_name),
                price: Number(data.price),
                quantity: Number(data.quantity),
            }],
        }
        : data;

    window.radopGa4EcommercePush(events[key], ecommerce);
}

export async function addToCart(productId, quantity) {
    const response = await postJson(route('cartAdd', '/product/addToCart'), {
        product_id: productId,
        product_qty: String(quantity),
    });
    if (response?.status === true) {
        pushEcommerce('cart_line_item_added', response);
        broadcast({ ...response, action: 'add', product_id: productId });
    }
    return response;
}

export async function updateCart(productId, quantity) {
    const response = await postJson(route('cartUpdate', '/product/updateCart'), {
        product_id: productId,
        product_qty: String(quantity),
    });
    if (response?.status === true) broadcast({ ...response, action: 'update', product_id: productId });
    return response;
}

export async function removeFromCart(productId) {
    const response = await postJson(route('cartRemove', '/product/deleteCartItem'), { product_id: productId });
    if (response?.status === true) {
        pushEcommerce('cart_line_item_removed', response);
        broadcast({ ...response, action: 'remove', product_id: productId });
    }
    return response;
}

/** Lines, total and minimum-order state for the header mini-cart. */
export function fetchSummary() {
    return getJson(route('cartSummary', '/sf/cart/summary'));
}

/**
 * toastr is still provided by the legacy script bundle. Stock warnings come
 * back with "\n" separators and are meant to render as line breaks, which is
 * how the old handler displayed them.
 */
export function notify(message, type = 'success') {
    if (!message) return;
    const toastr = window.toastr;
    if (!toastr?.[type]) {
        console.info(`[sf] ${message}`);
        return;
    }
    const escaped = String(message)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/\n/g, '<br>');
    // Phones: top, clear of the bottom tab bar and the thumb.
    const positionClass = window.matchMedia('(min-width: 1024px)').matches ? 'toast-bottom-right' : 'toast-top-center';
    toastr.options = { ...(toastr.options ?? {}), escapeHtml: false, positionClass };
    toastr[type](escaped);
}
