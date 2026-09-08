/**
 * Cart transport shared by every island that can change the basket.
 *
 * Talks to the same endpoints the legacy jQuery used, so server behaviour and
 * GA4 payloads are unchanged; the difference is that the result is broadcast
 * once on `document` instead of each caller hand-patching header markup.
 */

const ENDPOINTS = {
    add: '/product/addToCart',
    update: '/product/updateCart',
    remove: '/product/deleteCartItem',
};

function csrf() {
    return document.querySelector('meta[name="csrf-token"]')?.content ?? '';
}

async function post(url, payload) {
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

/** Everything that listens to the cart (header total, mini-cart) hears this. */
function broadcast(response) {
    document.dispatchEvent(new CustomEvent('sf:cart-updated', { detail: response }));
}

export async function addToCart(productId, quantity) {
    const response = await post(ENDPOINTS.add, {
        product_id: productId,
        product_qty: String(quantity),
    });
    if (response?.status === true) broadcast(response);
    return response;
}

export async function updateCart(productId, quantity) {
    const response = await post(ENDPOINTS.update, {
        product_id: productId,
        product_qty: String(quantity),
    });
    if (response?.status === true) broadcast(response);
    return response;
}

export async function removeFromCart(productId) {
    const response = await post(ENDPOINTS.remove, { product_id: productId });
    broadcast(response);
    return response;
}

/** toastr is still provided by the legacy script bundle; degrade quietly. */
export function notify(message, type = 'success') {
    if (!message) return;
    if (window.toastr?.[type]) {
        window.toastr[type](message);
        return;
    }
    console.info(`[sf:cart] ${message}`);
}
