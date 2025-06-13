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
               data-fancybox
               data-src="#loginModal"
               class="cart-auth-btn cart-auth-btn-blue">{{__('theme.cart-auth-modal-login')}}</a>
            <div class="cart-auth-separator"><span>{{__('theme.or')}}</span></div>
            <a href="{{route('user.registration.index')}}"
               class="cart-auth-btn cart-auth-btn-red">{{__('theme.cart-auth-modal-register')}}</a>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var btns = document.querySelectorAll('.cart-auth-modal-btn');
        var overlay = document.getElementById('cartAuthModalOverlay');
        var closeBtn = document.getElementById('cart-auth-modal-close');
        btns.forEach(function (btn) {
            btn.addEventListener('click', function (e) {
                if (window.$ && $.fancybox) {
                    $.fancybox.open({src: '#cartAuthModalOverlay', type: 'inline'});
                } else {
                    overlay.style.display = 'flex';
                }
            });
        });
        if (closeBtn) {
            closeBtn.addEventListener('click', function () {
                if (window.$ && $.fancybox) {
                    $.fancybox.close();
                } else {
                    overlay.style.display = 'none';
                }
            });
        }
        overlay && overlay.addEventListener('click', function (e) {
            if (e.target === overlay) {
                overlay.style.display = 'none';
            }
        });
        var loginBtn = document.getElementById('cart-auth-login-btn');
        if (loginBtn) {
            loginBtn.addEventListener('click', function (e) {
                if (window.$ && $.fancybox) {
                    $.fancybox.close();
                    $.fancybox.open({src: '#loginModal', type: 'inline'});
                } else {
                    overlay.style.display = 'none';
                    if (typeof openLoginModalCart === 'function') {
                        openLoginModalCart();
                    } else {
                        document.getElementById('loginModal').style.display = 'block';
                    }
                }
            });
        }
    });
</script>
