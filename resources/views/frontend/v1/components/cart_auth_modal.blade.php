<div id="cartAuthModalOverlay">
    <div class="cart-auth-modal-window">
        <button type="button" id="cart-auth-modal-close">&times;</button>
        <div class="login-logo d-flex align-items-center justify-content-center">
            <img src="/v1/frontend/assets/images/logo.svg" alt="Radop Logo"/>
        </div>
        <div class="login-head d-flex align-items-center justify-content-center">
            <h3>{{__('theme.cart-auth-modal-text')}}</h3>
        </div>
        <div class="login-form-wrap">
            <a href="javascript:;" id="cart-auth-login-btn"
               class="cart-auth-btn cart-auth-btn-blue">{{__('theme.cart-auth-modal-login')}}</a>
            <div class="cart-auth-separator"><span>{{__('theme.or')}}</span></div>
            <a href="{{route('user.registration.index')}}"
               class="cart-auth-btn cart-auth-btn-red">{{__('theme.cart-auth-modal-register')}}</a>
        </div>
    </div>
</div>
<script>
    // Delegated + idempotent: survives AJAX re-render of the cart (.cart-page),
    // so the guest checkout button keeps working after quantity changes.
    (function () {
        if (window.__cartAuthModalBound) { return; }
        window.__cartAuthModalBound = true;

        function overlay() { return document.getElementById('cartAuthModalOverlay'); }

        document.addEventListener('click', function (e) {
            // Guest "place order" button -> show the login/register overlay
            if (e.target.closest('.cart-auth-modal-btn')) {
                e.preventDefault();
                var o = overlay();
                if (o) { o.style.display = 'flex'; }
                return;
            }
            // Close button
            if (e.target.closest('#cart-auth-modal-close')) {
                var oc = overlay();
                if (oc) { oc.style.display = 'none'; }
                return;
            }
            // Click on the backdrop closes the overlay
            if (e.target.id === 'cartAuthModalOverlay') {
                e.target.style.display = 'none';
                return;
            }
            // "Login" inside the overlay -> open the login modal
            if (e.target.closest('#cart-auth-login-btn')) {
                e.preventDefault();
                var ol = overlay();
                if (ol) { ol.style.display = 'none'; }
                if (typeof window.Fancybox !== 'undefined') {
                    window.Fancybox.show([{ src: '#loginModal', type: 'inline' }]);
                } else {
                    var trigger = document.querySelector('[data-src="#loginModal"]');
                    if (trigger) { trigger.click(); }
                }
            }
        });
    })();
</script>
