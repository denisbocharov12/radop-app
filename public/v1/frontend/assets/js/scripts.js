// $('a.link-megamenu').on("click", function (e) {
//   e.preventDefault();
//
//   $(this).toggleClass('active');
//   $(this).next('.megamenu-wrap').toggleClass('open');
// });

$('a.link-megamenu').hoverDelay({
    delayIn: 400,
    delayOut: 200,
    handlerIn: function($element){
        $element.addClass('active');
        $('a.link-megamenu').not($element).removeClass('active');
        $('.megamenu-wrap.open').removeClass('open');
        $element.next('.megamenu-wrap').addClass('open');
    },
    handlerOut: function($element){
        $('.megamenu-wrap.open').on('mouseleave', function () {
            $element.removeClass('open');
            $element.removeClass('active');
            $element.children().find('a.link-megamenu.active').removeClass('active');
            $element.next('.megamenu-wrap').removeClass('open');
        });
        $('.theme-wrapper-sticky').on('mouseenter', function () {
            $('.megamenu-wrap.open').removeClass('open');
            $element.removeClass('active');
        });
        if ($element.hasClass('active')) {
            $element.removeClass('active');
        }
        $element.removeClass('active');
    }
});

;(function ($, window, document) {
    const COPIED_CLASS = 'product-code--copied';
    const TOAST_VISIBLE_CLASS = 'product-code-toast--visible';
    const TOAST_HIDE_CLASS = 'product-code-toast--hide';
    const TOAST_VISIBLE_DURATION = 1500;
    const TOAST_HIDE_DURATION = 220;

    let toastHideTimeoutId = null;
    let toastRemoveTimeoutId = null;

    function copyTextToClipboard(text) {
        if (!text) {
            return Promise.resolve();
        }

        if (navigator.clipboard && typeof navigator.clipboard.writeText === 'function') {
            return navigator.clipboard.writeText(text);
        }

        return new Promise(function (resolve, reject) {
            const textarea = document.createElement('textarea');
            textarea.value = text;
            textarea.setAttribute('readonly', '');
            textarea.style.position = 'fixed';
            textarea.style.top = '-9999px';
            document.body.appendChild(textarea);
            textarea.select();

            try {
                const successful = document.execCommand('copy');
                if (successful) {
                    resolve();
                } else {
                    reject(new Error('Copy command was unsuccessful'));
                }
            } catch (err) {
                reject(err);
            } finally {
                document.body.removeChild(textarea);
            }
        });
    }

    function setCopiedState($element) {
        const previousTimeoutId = $element.data('copyTimeoutId');
        if (previousTimeoutId) {
            window.clearTimeout(previousTimeoutId);
        }

        $element.addClass(COPIED_CLASS);

        const timeoutId = window.setTimeout(function () {
            $element.removeClass(COPIED_CLASS);
            $element.removeData('copyTimeoutId');
        }, 1500);

        $element.data('copyTimeoutId', timeoutId);
    }

    function getCopyValue($element) {
        const dataValue = $element.data('copyValue');
        if (typeof dataValue !== 'undefined' && dataValue !== null && dataValue !== '') {
            return dataValue.toString();
        }
        return ($element.text() || '').trim();
    }

    function handleCopy($element) {
        const value = getCopyValue($element);
        if (!value) {
            return;
        }

        copyTextToClipboard(value)
            .then(function () {
                setCopiedState($element);
                showCopyToast($element);
            })
            .catch(function () {
                // Silently fail if copying is not supported
            });
    }

    function showCopyToast($element) {
        const message = $element.data('copyMessage');

        if (typeof message === 'undefined' || message === null || message === '') {
            return;
        }

        if (toastHideTimeoutId) {
            window.clearTimeout(toastHideTimeoutId);
            toastHideTimeoutId = null;
        }
        if (toastRemoveTimeoutId) {
            window.clearTimeout(toastRemoveTimeoutId);
            toastRemoveTimeoutId = null;
        }

        $('.product-code-toast').remove();

        const $toast = $('<div/>', {
            class: 'product-code-toast',
            role: 'status',
            text: message
        }).appendTo('body');

        const elementOffset = $element.offset();
        const elementWidth = $element.outerWidth();
        const elementHeight = $element.outerHeight();
        const toastWidth = $toast.outerWidth();
        const toastHeight = $toast.outerHeight();
        const windowWidth = $(window).width();
        const windowHeight = $(window).height();
        const scrollTop = $(window).scrollTop();

        let top = elementOffset.top - toastHeight - 8;
        const bottomAlternative = elementOffset.top + elementHeight + 8;

        if (top < scrollTop + 8) {
            top = bottomAlternative;
        } else if (top + toastHeight > scrollTop + windowHeight - 8) {
            top = Math.max(scrollTop + 8, bottomAlternative);
        }

        let left = elementOffset.left + (elementWidth / 2) - (toastWidth / 2);
        const minLeft = 8;
        const maxLeft = windowWidth - toastWidth - 8;
        left = Math.min(Math.max(left, minLeft), Math.max(minLeft, maxLeft));

        $toast.css({
            top: top,
            left: left
        });

        window.requestAnimationFrame(function () {
            $toast.addClass(TOAST_VISIBLE_CLASS);
        });

        toastHideTimeoutId = window.setTimeout(function () {
            $toast.addClass(TOAST_HIDE_CLASS);
            toastRemoveTimeoutId = window.setTimeout(function () {
                $toast.remove();
                toastRemoveTimeoutId = null;
            }, TOAST_HIDE_DURATION);
            toastHideTimeoutId = null;
        }, TOAST_VISIBLE_DURATION);
    }

    $(document).on('click', '.product-code', function () {
        handleCopy($(this));
    });

    $(document).on('keydown', '.product-code', function (event) {
        if (event.key === 'Enter' || event.key === ' ') {
            event.preventDefault();
            handleCopy($(this));
        }
    });
})(jQuery, window, document);

$('main').click(function (){
    $('.megamenu-wrap').removeClass('open');
    $('a.link-megamenu').removeClass('active');
});
$('a.link-megamenu').hover(function () {
    $(this).toggleClass('active');
});

document.addEventListener("DOMContentLoaded", () => {

  const options = document.querySelectorAll(".order__options");

  const toggleOptions = (event) => {
    [...options].forEach((elem) => {
      const dropdownElem = elem.querySelector(".order-dropdown");
      if (event.target === elem) {
        dropdownElem.classList.toggle("order-dropdown--active");
      } else {
        dropdownElem.classList.remove("order-dropdown--active");
      }
      document.addEventListener("click", function (event) {
        if (event.target !== elem) {
          dropdownElem.classList.remove("order-dropdown--active");
        }
      });
    });
  };

  const orderOptionsArr = (arr) => {
    return [...arr].forEach((element) => {
      element.addEventListener("click", toggleOptions);
    });
  };
  orderOptionsArr(options);
});

$(document).ready(function () {
    $("#scroll_to_top_btn").click(function() {
        $("html").scrollTop(0);
    });

  const delivery = $(".total-selects__item--delivery .dropdown");
  const payment = $(".total-selects__item--payment .dropdown");
  const deliveryItem = $(
    ".total-selects__item--delivery .dropdown .dropdown-menu li"
  );
  const paymentItem = $(
    ".total-selects__item--payment .dropdown .dropdown-menu li"
  );

  function activeDropdown() {
    $(this).attr("tabindex", 1).focus();
    $(this).toggleClass("active");
    $(this).find(".dropdown-menu").slideToggle(300);
  }

  function removeDropdown() {
    $(this).removeClass("active");
    $(this).find(".dropdown-menu").slideUp(300);
  }

  function setValue() {
    $(this).parents(".dropdown").find("span").text($(this).text());
    $(this)
      .parents(".dropdown")
      .find("input")
      .attr("value", $(this).attr("id"));
  }

  delivery.click(activeDropdown);
  payment.click(activeDropdown);

  delivery.focusout(removeDropdown);
  payment.focusout(removeDropdown);

  deliveryItem.click(setValue);
  paymentItem.click(setValue);

  $("#btn-catalog").hover(function () {
    if (!$(this).hasClass("active")) {
      $(this).find(".dropdown").css({
        visibility: "visible",
        opacity: "1",
        transform: "translate(0px, 0px)",
        display: "block",
      });
      $(this).addClass("active");
    } else {
      $(this).find(".dropdown").css({
        visibility: "hidden",
        opacity: "0",
        transform: "translate(0px, 0px)",
        display: "none",
      });
      $(this).removeClass("active");
    }
  });
    const speed = $('#main-banner').data('autoplay-speed');
  $("#main-banner")
    .on('init', function(){ $(this).addClass('slick-initialized'); })
    .slick({
    autoplay: true,
    dots: true,
    autoplaySpeed: speed,
    speed: 1000,
    infinite: true,
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: true,
    swipe: true,
    prevArrow: "<i class='icon-arrow-radop-left prev-arrow'></i>",
    nextArrow: "<i class='icon-arrow-radop-right next-arrow'></i>",
    cssEase: "ease-out",
    responsive: [
      {
        breakpoint: 768,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1,
        },
      },
      {
        breakpoint: 576,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1,
        },
      },
    ],
  });
  $("#partners-slider").slick({
    autoplay: true,
    dots: false,
    autoplaySpeed: 5000,
    speed: 1000,
    infinite: true,
    slidesToShow: 5,
    slidesToScroll: 5,
    arrows: true,
    swipe: true,
    prevArrow: "<i class='icon-arrow-radop-left prev-arrow'></i>",
    nextArrow: "<i class='icon-arrow-radop-right next-arrow'></i>",
    cssEase: "ease-out",
    responsive: [
      {
        breakpoint: 1200,
        settings: {
          slidesToShow: 3,
          slidesToScroll: 3,
          infinite: true,
        },
      },
      {
        breakpoint: 768,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 2,
        },
      },
      {
        breakpoint: 576,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1,
        },
      },
    ],
  });
  $(".header-top-slider").slick({
    autoplay: false,
    dots: false,
    autoplaySpeed: 5000,
    speed: 1000,
    infinite: true,
    slidesToShow: 2,
    slidesToScroll: 1,
    arrows: false,
    cssEase: "ease-out",
  });

  $(".catalog-slider")
    .slick({
      autoplay: false,
      dots: false,
      autoplaySpeed: 3000,
      speed: 1000,
      infinite: true,
      slidesToShow: 5,
      slidesToScroll: 5,
      arrows: true,
      swipe: false,
        prevArrow: "<i class='icon-arrow-radop-left prev-arrow'></i>",
        nextArrow: "<i class='icon-arrow-radop-right next-arrow'></i>",
      cssEase: "ease-out",
      rows: 1,
      responsive: [
        {
          breakpoint: 992,
          settings: {
            slidesToShow: 3,
            swipe: true,
            dots: false,
            arrows: true,
            slidesToScroll: 3,
          },
        },
        {
          breakpoint: 768,
          settings: {
            dots: false,
            swipe: true,
            arrows: true,
            slidesToShow: 2,
            slidesToScroll: 2,
          },
        },
      ],
    })
    .on("setPosition", function (event, slick) {
      slick.$slides.css("height", slick.$slideTrack.height() + "px");
    });
  $(".categories-cards-slider").slick({
    autoplay: false,
    dots: false,
    autoplaySpeed: 8000,
    speed: 1000,
    infinite: true,
    slidesToShow: 5,
    slidesToScroll: 1,
    arrows: true,
    swipe: true,
      prevArrow: "<i class='icon-arrow-radop-left prev-arrow'></i>",
      nextArrow: "<i class='icon-arrow-radop-right next-arrow'></i>",
    cssEase: "ease-out",
    rows: 1,
    responsive: [
      {
        breakpoint: 992,
        settings: {
          slidesToShow: 3,
          dots: false,
          arrows: true,
          slidesToScroll: 3,
        },
      },
      {
        breakpoint: 768,
        settings: {
          dots: false,
          swipe: true,
          arrows: true,
          slidesToShow: 2,
          slidesToScroll: 2,
        },
      },
    ],
  });
  $(".cart-catalog-slider")
    .slick({
      autoplay: false,
      dots: false,
      autoplaySpeed: 8000,
      speed: 1000,
      infinite: true,
      slidesToShow: 4,
      slidesToScroll: 1,
      arrows: true,
      swipe: false,
        prevArrow: "<i class='icon-arrow-radop-left prev-arrow'></i>",
        nextArrow: "<i class='icon-arrow-radop-right next-arrow'></i>",
      cssEase: "ease-out",
      rows: 1,
      responsive: [
        {
          breakpoint: 992,
          settings: {
            slidesToShow: 2,
            swipe: true,
            dots: false,
            arrows: true,
            slidesToScroll: 1,
          },
        },
        {
          breakpoint: 768,
          settings: {
            dots: false,
            swipe: true,
            arrows: true,
            slidesToShow: 2,
            slidesToScroll: 1,
          },
        },
      ],
    })
    .on("setPosition", function (event, slick) {
      slick.$slides.css("height", slick.$slideTrack.height() + "px");
    });
});

// Slider Product
$(document).ready(function () {
  const $rootSingle = $(".product-slider-main");
  const $rootNav = $(".product-slider-thumb");

  $rootSingle.slick({
    slide: ".product-image",
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: false,
    fade: false,
    adaptiveHeight: true,
    infinite: false,
    useTransform: true,
    speed: 400,
    cssEase: "cubic-bezier(0.77, 0, 0.18, 1)",
  });

  $rootNav
    .on("init", function (event, slick) {
      $(this).find(".slick-slide.slick-current").addClass("is-active");
    })
    .slick({
      slide: ".product-image",
      slidesToShow: 3,
      arrows: true,
      slidesToScroll: 1,
      dots: false,
      focusOnSelect: false,
      infinite: false,
      prevArrow: "<i class='icon-arrow-radop-left prev-arrow'></i>",
      nextArrow: "<i class='icon-arrow-radop-right next-arrow'></i>",
      responsive: [
        {
          breakpoint: 1024,
          settings: {
            slidesToShow: 5,
            slidesToScroll: 5,
          },
        },
        {
          breakpoint: 640,
          settings: {
            slidesToShow: 4,
            slidesToScroll: 4,
          },
        },
        {
          breakpoint: 420,
          settings: {
            slidesToShow: 3,
            slidesToScroll: 3,
          },
        },
      ],
    });
  $rootSingle.on("afterChange", function (event, slick, currentSlide) {
    $rootNav.slick("slickGoTo", currentSlide);
    $rootNav.find(".slick-slide.is-active").removeClass("is-active");
    $rootNav
      .find('.slick-slide[data-slick-index="' + currentSlide + '"]')
      .addClass("is-active");
  });

  $rootNav.on("click", ".slick-slide", function (event) {
    event.preventDefault();
    var goToSingleSlide = $(this).data("slick-index");

    $rootSingle.slick("slickGoTo", goToSingleSlide);
  });
});

const ham_open = $("#hamburger-open");
const ham_close = $("#hamburger-close");
const navExpand = [].slice.call(document.querySelectorAll(".nav-expand"));
const backLink = `<li class="nav-item">
        <a class="nav-link nav-back-link" href="javascript:;">
          Назад
        </a>
      </li>`;

navExpand.forEach((item) => {
  item
    .querySelector(".nav-expand-content")
    .insertAdjacentHTML("afterbegin", backLink);
  item
    .querySelector(".nav-link")
    .addEventListener("click", () => item.classList.add("active"));
  item
    .querySelector(".nav-back-link")
    .addEventListener("click", () => item.classList.remove("active"));
});
ham_open.click(function () {
  $("#nav-drill").addClass("nav-is-toggled");
});
ham_close.click(function () {
  $("#nav-drill").removeClass("nav-is-toggled");
});

var tab; // заголовок вкладки
var tabContent; // блок содержащий контент вкладки

window.onload = function () {
  tabContent = document.getElementsByClassName("tabContent");
  tab = document.getElementsByClassName("tab");
  hideTabsContent(1);
};
if (document.getElementById("tabs")) {
    document.getElementById("tabs").onclick = function (event) {
        var target = event.target;
        if (target.className == "tab") {
            for (var i = 0; i < tab.length; i++) {
                if (target == tab[i]) {
                    showTabsContent(i);
                    break;
                }
            }
        }
    };
}


function hideTabsContent(a) {
  for (var i = a; i < tabContent.length; i++) {
    tabContent[i].classList.remove("show");
    tabContent[i].classList.add("hide");
    tab[i].classList.remove("active");
  }
}

function showTabsContent(b) {
  if (tabContent[b].classList.contains("hide")) {
    hideTabsContent(0);
    tab[b].classList.add("active");
    tabContent[b].classList.remove("hide");
    tabContent[b].classList.add("show");
  }
}

// EYE
$(".eye_change_type").on("click", function (e) {
  var t, c;
  e.preventDefault();
  var t = $("#password").attr("type");
  var c = $(this).find("i").attr("class");
  if (c == "fa fa-eye") {
    $(this).find("i").removeClass("fa-eye");
    $(this).find("i").addClass("fa-eye-slash");
  } else {
    $(this).find("i").addClass("fa-eye");
    $(this).find("i").removeClass("fa-eye-slash");
  }
  if (t == "password") {
    $("#password").attr("type", "text");
  } else {
    $("#password").attr("type", "password");
  }
});
$(function () {
  $(".vertical-tabs").delegate("li:not(.chosen)", "click", function () {
    $(this)
      .addClass("chosen")
      .siblings()
      .removeClass("chosen")
      .parents(".wrap-vertical-tabs")
      .find(".vertical-tabs-content")
      .hide()
      .eq($(this).index())
      .fadeIn(170);
  });
});
$(document).ready(function () {
    $(window).scroll(function() {
        if ($(this).scrollTop() > 117) {
            $('#header-js-sticky').addClass('header-js-sticky container');
        } else {
            $('#header-js-sticky').removeClass('header-js-sticky container');
        }
    });
    $("a.scroll-element").click(function(e) {
        e.preventDefault();
        var target = $(this).data("anchor");

        $('html, body').animate({scrollTop:$('#'+target).offset().top - 300}, 300, 'linear');
    });

    $('.btn-quantity-product').click(function () {
        var qtyBlock = $(this).closest('.qty-block');
        var input = qtyBlock.find('.product-qty-item');

        if ($(this).hasClass('minus')) {
            input[0].stepDown();
            input.data('warnedMaxShown', false);
        } else if ($(this).hasClass('plus')) {
            var max = Number(input.attr('max'));
            var step = Number(input.attr('step')) || 1;
            var current = Number(input.val()) || 0;
            if (!isNaN(max)) {
                if (current >= max || current + step > max) {
                    input.val(max);
                    var msgs = (typeof window.getLimitedStockWarnings === 'function') ? window.getLimitedStockWarnings(max, $(input).attr('data-unit') || undefined) : null;
                    if (typeof toastr !== 'undefined') {
                        if (msgs && msgs.length) {
                            var html = msgs.join('<br/><br/>');
                            toastr.options = Object.assign({}, toastr.options, { escapeHtml: false });
                            toastr["warning"](html);
                        } else {
                            toastr["warning"]('Доступно только ' + max);
                        }
                    }
                } else {
                    input[0].stepUp();
                    input.data('warnedMaxShown', false);
                }
            } else {
                input[0].stepUp();
            }
        }

        var qtyCount = input.val();
        var productId = input.data('product-id');
        var productPrice = input.data('price');
        var packageCount = input.data('package');

        var result = (qtyCount * productPrice) / packageCount;
        var formatted = result.toFixed(2).replace('.', ',');

        // определяем, в каком контейнере клик
        let isInTableView = $(this).closest('#productsTableView').length > 0;
        let isInListView = $(this).closest('#productsListView').length > 0;

        if (isInTableView) {
            $('#productsTableView .product-card-summary-' + productId).html(formatted);
        } else if (isInListView) {
            $('#productsListView .product-card-summary-' + productId).html(formatted);
        } else {
            $('.product-card-summary-' + productId).html(formatted);
        }
    });

    $('.product-qty-item').on('change input', function (){
        var qtyCount = $(this).val();
        var productId = $(this).data('product-id');
        var productPrice = $(this).data('price');
        var packageCount = $(this).data('package');
        var max = $(this).attr('max');

        if (qtyCount !== '' && max !== '' && Number(qtyCount) > Number(max)) {
            $(this).val(max);
            if (!$(this).data('warnedMaxShown')) {
                var msgs = (typeof window.getLimitedStockWarnings === 'function') ? window.getLimitedStockWarnings(max, $(this).attr('data-unit') || undefined) : null;
                if (typeof toastr !== 'undefined') {
                    if (msgs && msgs.length) {
                        var html = msgs.join('<br/><br/>');
                        toastr.options = Object.assign({}, toastr.options, { escapeHtml: false });
                        toastr["warning"](html);
                    } else {
                        toastr["warning"]('Доступно только ' + max);
                    }
                }
                $(this).data('warnedMaxShown', true);
            }
            qtyCount = max;
        } else {
            $(this).data('warnedMaxShown', false);
        }

        var result = (qtyCount*productPrice)/packageCount;
        var formatted = result.toFixed(2).replace('.',',');

        let isInTableView = $(this).closest('#productsTableView').length > 0;
        let isInListView = $(this).closest('#productsListView').length > 0;

        if (isInTableView) {
            $('#productsTableView .product-card-summary-' + productId).html(formatted);
        } else if (isInListView) {
            $('#productsListView .product-card-summary-' + productId).html(formatted);
        } else {
            $('.product-card-summary-' + productId).html(formatted);
        }
    });

    $('.product-qty-item').on('blur', function (){
        if ($(this).val() === '') {
            $(this).val($(this).attr('min'));
            $(this).trigger('change');
        }
    });

  $(".filter-select").select2();
  $(".product-qty").select2({

  });
  $(".select-sort-per-page").select2({
      minimumResultsForSearch: -1
  });
  $(".select-2-container").select2({

  });
  $(".qty-select .product-qty-page").select2({});
  $(".icon-block a.user").click(function(){
      Fancybox.show([{ src: "#loginModal", type: "inline" }]);
  });

    $("#cart-auth-login-btn").click(function(){
        Fancybox.show([{ src: "#loginModal", type: "inline" }]);
    });

  $("a.auth").click(function(){
      Fancybox.show([{ src: "#loginModal", type: "inline" }]);
  });

    $(".btn-sales-period").click(function(){
        Fancybox.show([{ src: "#salesPeriodModal", type: "inline" }]);
    });

  $('#btn-header-catalog').click(function(){
      $(this).toggleClass('show');
      $('#header-catalog-action').toggleClass('show');
  });
    $(document).on('click', function(e) {
        if (!$(e.target).closest(".btn-header-catalog-wrap").length) {
            $('#header-catalog-action').removeClass('show');
            $('#btn-header-catalog').removeClass('show');
        }
        e.stopPropagation();
    });
    $('.toggle').click(function(e) {
        e.preventDefault();

        var $this = $(this);

        if ($this.next().hasClass('show')) {
            $this.next().removeClass('show');
            $this.next().slideUp(350);
        } else {
            $this.parent().parent().find('li .inner').removeClass('show');
            $this.parent().parent().find('li .inner').slideUp(350);
            $this.next().toggleClass('show');
            $this.next().slideToggle(350);
        }

        $("li a.toggle").not(this).removeClass('expanded'); //if clicking off from this toggle, will collapse all other list items

        $this.parents('.inner').siblings('a.toggle').addClass("expanded"); // ensures all ancestors of this class will also remain expanded

        $this.toggleClass("expanded"); // to expand or collapse arrow on click (toggle)
    });

    $('.togglePassword').click(function(){
        if ($(this).parent().find('input[type=password]').attr('type') === 'password') {
            $(this).parent().find('input[type=password]').attr('type', 'text');
        } else {
            $(this).parent().find('input[type=text]').attr('type', 'password');
        }
    });

    $('.toggle').dblclick(function(e){
        e.preventDefault();
        var href = $(this).attr('href');
        window.location = href;
    });

    Fancybox.bind('[data-fancybox-product]', {
        hash : false,
        Carousel : {
            infinite: false,
        }
    });

    Fancybox.bind('[data-fancybox^="product-gallery-"]', {
        hash : false,
        Carousel : {
            infinite: false,
        },
        Thumbs : {
            autoStart: true,
            axis: "x"
        },
        Toolbar : {
            display: [
                { id: "prev", position: "center" },
                { id: "counter", position: "center" },
                { id: "next", position: "center" },
                "zoom",
                "slideshow",
                "fullscreen",
                "download",
                "thumbs",
                "close"
            ]
        }
    });

    // Обработчик для ПК версии
    $('.col-theme-filters .theme-toggle-list li .theme-toggle-item-title').click(function () {

        var content = $(this).next('.theme-toggle-item-content');

        if (content.is(':hidden')) {
            content.slideDown('0').css('display', 'flex');
            $(this).children('.theme-toggle-item-title i').css('transform', 'rotate(90deg)');
        } else {
            content.slideUp('0');
            $(this).children('.theme-toggle-item-title i').css('transform', 'rotate(0deg)');
        }

    });

    // Обработчик для модального окна (работает для всех модальных окон: brand, category, shop)
    $('#filtersModal .col-theme-filters-modal .theme-toggle-list li .theme-toggle-item-title').click(function () {

        var content = $(this).next('.theme-toggle-item-content');

        if (content.is(':hidden')) {
            content.slideDown('0').css('display', 'flex');
            $(this).children('.theme-toggle-item-title i').css('transform', 'rotate(90deg)');
        } else {
            content.slideUp('0');
            $(this).children('.theme-toggle-item-title i').css('transform', 'rotate(0deg)');
        }

    });

    // Для модального окна (работает для всех модальных окон: brand, category, shop)
    let inputsModal = $('#filtersModal .col-theme-filters-modal .theme-toggle-item-content').children('.theme-checkbox');
    inputsModal.each(function(){
        if ($(this).is(':checked')) {
            $(this).parent('.theme-toggle-item-content').css('display', 'flex');
        }
    });

    // Для ПК фильтра
    let inputsPC = $('.col-theme-filters .theme-toggle-item-content').children('.theme-checkbox');
    inputsPC.each(function(){
        if ($(this).is(':checked')) {
            $(this).parent('.theme-toggle-item-content').css('display', 'flex');
        }
    });
    // let inputs = $('.theme-toggle-item-content').children('.theme-checkbox');
    //
    // inputs.each(function(){
    //    if ($(this).is(':checked')) {
    //        $(this).parent('.theme-toggle-item-content').css('display', 'flex');
    //    }
    // });
});

$(document).ready(function(){

    // Range slider для ПК версии (вне модального окна)
    const pcContainer = document.querySelector(".col-theme-filters");
    if (pcContainer) {
        const rangevalue = pcContainer.querySelector(".slider .progress");
        const rangeInputvalue = pcContainer.querySelectorAll(".range-input input");
        const priceInputvalue = pcContainer.querySelectorAll(".price-input input");

        let priceGap = 1;


    for (let i = 0; i < priceInputvalue.length; i++) {

        priceInputvalue[i].addEventListener("input", e => {

            // Parse min and max values of the range input
            let minp = parseInt(priceInputvalue[0].value);
            let maxp = parseInt(priceInputvalue[1].value);
            let diff = maxp - minp

            if (minp < 0) {
                alert("minimum price cannot be less than 0");
                priceInputvalue[0].value = 0;
                minp = 0;
            }

            // Validate the input values
            if (maxp > 10000) {
                alert("maximum price cannot be greater than 10000");
                priceInputvalue[1].value = 10000;
                maxp = 10000;
            }

            if (minp > maxp - priceGap) {
                priceInputvalue[0].value = maxp - priceGap;
                minp = maxp - priceGap;

                if (minp < 0) {
                    priceInputvalue[0].value = 0;
                    minp = 0;
                }
            }

            // Check if the price gap is met
            // and max price is within the range
            if (diff >= priceGap && maxp <= rangeInputvalue[1].max) {
                if (e.target.className === "min-input") {
                    rangeInputvalue[0].value = minp;
                    let value1 = rangeInputvalue[0].max;
                    rangevalue.style.left = `${(minp / value1) * 100}%`;
                }
                else {
                    rangeInputvalue[1].value = maxp;
                    let value2 = rangeInputvalue[1].max;
                    rangevalue.style.right =
                        `${100 - (maxp / value2) * 100}%`;
                }
            }
        });
    }

    for (let i = 0; i < rangeInputvalue.length; i++) {
        rangeInputvalue[i].addEventListener("input", e => {
            let minVal =
                parseInt(rangeInputvalue[0].value);
            let maxVal =
                parseInt(rangeInputvalue[1].value);

            let diff = maxVal - minVal

            // Check if the price gap is exceeded
            if (diff < priceGap) {

                // Check if the input is the min range input
                if (e.target.className === "min-range") {
                    rangeInputvalue[0].value = maxVal - priceGap;
                }
                else {
                    rangeInputvalue[1].value = minVal + priceGap;
                }
            }
            else {

                // Update price inputs and range progress
                priceInputvalue[0].value = minVal;
                priceInputvalue[1].value = maxVal;
                rangevalue.style.left =
                    `${(minVal / rangeInputvalue[0].max) * 100}%`;
                rangevalue.style.right =
                    `${100 - (maxVal / rangeInputvalue[1].max) * 100}%`;
            }
        });
    }
    }
});

$(document).ready(function () {
    document.addEventListener('DOMContentLoaded', function() {
        const sortSelect = document.querySelector('.sort-select')
        const filterForm = document.getElementById('filterForm')
        const sortInput = document.getElementById('sortInput')

        if (sortSelect && filterForm && sortInput) {
            sortSelect.addEventListener('change', function() {
                sortInput.value = this.value
                filterForm.submit()
            })
        }
    })
});

document.addEventListener("DOMContentLoaded", (() => {
    const catalogNavBarMenu = document.querySelector(".catalog-navbar");
    // Проверяем, что это старый вариант меню (без data-mobile-menu-code)
    if (catalogNavBarMenu && !catalogNavBarMenu.dataset.mobileMenuCode) {
        const catalog = catalogNavBarMenu.querySelector(".catalog");
        if (catalog) {
            const body = document.body;
            const catalogBtn = document.querySelector(".catalog-btn");
            const catalogCloseBtn = catalog.querySelector(".catalog__close-btn");
            const secondColumn = catalog.querySelector(".catalog__second-column");
            const secondColumnList = catalog.querySelectorAll(".catalog__second-column .column-catalog__item");
            // const thirdColumn = document.querySelector(".catalog__third-column");
            // const thirdColumnList = document.querySelectorAll(".catalog__third-column .column-catalog__item");
            const allSecondColumnLinks = catalog.querySelectorAll(".catalog__second-column .drop-menu-list__link");
            let mainCurrentLink = null;
            let secondCurrenLink = null;
            
            function getBack(event) {
                event.stopPropagation();
                if (event.target.classList.contains("column-catalog__back")) {
                    event.preventDefault();
                    const currentCulmn = event.target.closest(".column-catalog");
                    if (currentCulmn) {
                        currentCulmn.classList.remove("_active");
                        let columnCatalogItem = currentCulmn.querySelector(".column-catalog__item--active");
                        if (columnCatalogItem) columnCatalogItem.classList.remove("column-catalog__item--active");
                        let activeLink = currentCulmn.querySelector(".drop-menu-list__link._active");
                        if (activeLink) activeLink.classList.remove("_active");
                    }
                }
            }
            
            function openCatalog(event) {
                event.stopPropagation();
                if (event.target.classList.contains("catalog-btn") || event.target.closest(".catalog-btn")) {
                    const isActive = catalogNavBarMenu.classList.contains("_active");
                    if (isActive) {
                        closeMenu();
                    } else {
                        catalogNavBarMenu.classList.add("_active");
                        catalog.classList.add("catalog--active");
                        body.classList.add("body-lock");
                        body.addEventListener("click", removeCatalog);
                    }
                }
            }
            
            function removeCatalog({target}) {
                if (target.classList.contains("catalog") || target.closest(".catalog")) return;
                closeMenu();
            }
            
            function openSecondColumn(event) {
                const target = event.target;
                const link = target.closest(".main-column-catalog__link");
                
                if (link && link.hasAttribute("data-main-category")) {
                    event.preventDefault();
                    event.stopPropagation();
                    
                    if (mainCurrentLink) mainCurrentLink.classList.remove("_active");
                    if (secondCurrenLink) secondCurrenLink.classList.remove("_active");
                    
                    link.classList.add("_active");
                    mainCurrentLink = link;
                    
                    if (secondColumn) {
                        secondColumn.classList.add("_active");
                        const elemId = link.getAttribute("data-main-category");
                        [...secondColumnList].forEach((elem => {
                            elem.classList.remove("column-catalog__item--active");
                            if (elem.id === elemId) elem.classList.add("column-catalog__item--active");
                        }));
                    }
                    
                    return false;
                }
            }
            
            function closeBtnHeadler({target}) {
                if (target.classList.contains("catalog__close-btn") || target.closest(".catalog__close-btn")) {
                    closeMenu();
                }
            }
            
            function closeMenu() {
                catalogNavBarMenu.classList.remove("_active");
                catalog.classList.remove("catalog--active");
                if (secondColumn) secondColumn.classList.remove("_active");
                if (mainCurrentLink) mainCurrentLink.classList.remove("_active");
                if (secondCurrenLink) secondCurrenLink.classList.remove("_active");
                [...secondColumnList].forEach((elem => {
                    elem.classList.remove("column-catalog__item--active");
                }));
                body.classList.remove("body-lock");
                body.removeEventListener("click", removeCatalog);
            }
            
            if (catalogBtn) {
                catalogBtn.addEventListener("click", openCatalog);
            }
            catalog.addEventListener("click", function(event) {
                getBack(event);
                openSecondColumn(event);
            });
            if (catalogCloseBtn) {
                catalogCloseBtn.addEventListener("click", closeBtnHeadler);
            }
        }
    }
}));
// mobile down menu
document.addEventListener("DOMContentLoaded", () => {
    const searchNavBarMenu = document.querySelector(".search-navbar");
    const otherNavBarMenu = document.querySelector(".other-navbar");
    const catalogNavBarMenu = document.querySelector(".catalog-navbar");
    const searchMenu = document.querySelector(".search-menu-navbar");

    const btnSearch = document.querySelector(".navbar-menu__link_search");
    const btnOther = document.querySelector(".navbar-menu__link_other");
    const btnCatalog = document.querySelector(".navbar-menu__link_catalog");

    const btnOpenSearchMenu = document.querySelector(".catalog-navbar__search");
    const btnCloseSearchMenu = document.querySelector(".search-menu-navbar__close");

    function closeAllMenus() {
        searchNavBarMenu?.classList.remove("_active");
        otherNavBarMenu?.classList.remove("_active");
        catalogNavBarMenu?.classList.remove("_active");
    }

    if (btnSearch && searchNavBarMenu) {
        btnSearch.addEventListener("click", () => {
            const isActive = searchNavBarMenu.classList.contains("_active");
            closeAllMenus();
            if (!isActive) {
                searchNavBarMenu.classList.add("_active");
            }
        });
    }

    if (btnOther && otherNavBarMenu) {
        btnOther.addEventListener("click", () => {
            const isActive = otherNavBarMenu.classList.contains("_active");
            closeAllMenus();
            if (!isActive) {
                otherNavBarMenu.classList.add("_active");
            }
        });
    }

    if (btnCatalog && catalogNavBarMenu) {
        const mobileMenuCode = catalogNavBarMenu.dataset.mobileMenuCode;
        const mobileContainer = catalogNavBarMenu.querySelector('[data-mobile-menu-container]');
        const mobileLoading = catalogNavBarMenu.querySelector('[data-mobile-menu-loading]');
        const translateLoadError = catalogNavBarMenu.dataset.translateLoadError || 'Ошибка загрузки меню';
        const translateInvalidResponse = catalogNavBarMenu.dataset.translateInvalidResponse || 'Неверный формат ответа';
        const translateLoadErrorMessage = catalogNavBarMenu.dataset.translateLoadErrorMessage || 'Ошибка загрузки меню. Пожалуйста, обновите страницу.';

        // Если это новый вариант меню (с data-mobile-menu-code), используем новый код
        if (mobileMenuCode && mobileContainer) {

        let isMobileMenuLoaded = false;
        let isMobileMenuLoading = false;
        const mobileCategoryContentCache = {};

        function loadMobileMenuContent() {
            isMobileMenuLoading = true;
            if (mobileLoading) mobileLoading.style.display = 'flex';
            if (mobileContainer) mobileContainer.style.display = 'none';

            const locale = document.documentElement.lang || 'ru';
            fetch(`/api/v1/mega-menu/${mobileMenuCode}/mobile-html`, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-Localization': locale
                }
            })
            .then(response => {
                if (!response.ok) {
                    if (response.status === 404) {
                        return response.json().then(err => {
                            return {
                                success: false,
                                message: err.message || translateLoadError,
                                html: ''
                            };
                        }).catch(() => {
                            return {
                                success: false,
                                message: translateLoadError,
                                html: ''
                            };
                        });
                    }
                    return response.json().then(err => {
                        throw new Error(err.message || translateLoadError);
                    }).catch(() => {
                        throw new Error(translateLoadError);
                    });
                }
                return response.json();
            })
            .then(data => {
                if (data && typeof data === 'object' && data.success === true && data.html) {
                    if (mobileContainer) {
                        mobileContainer.innerHTML = data.html;
                        mobileContainer.style.display = 'block';
                    }
                    if (mobileLoading) mobileLoading.style.display = 'none';
                    isMobileMenuLoaded = true;
                    initializeMobileMenuInteractions();
                } else {
                    if (mobileLoading) mobileLoading.style.display = 'none';
                    closeMobileMenu();
                }
            })
            .catch(error => {
                console.error('Ошибка загрузки мобильного мега-меню:', error);
                if (mobileLoading) mobileLoading.style.display = 'none';
                closeMobileMenu();
                
                if (mobileContainer) {
                    const closeBtnHtml = '<button class="catalog__close-btn _icon-close" type="button"></button>';
                    mobileContainer.innerHTML = '<div class="catalog__error"><div class="catalog__error-content">' + closeBtnHtml + '<p>' + translateLoadErrorMessage + '</p></div></div>';
                    mobileContainer.style.display = 'block';
                    
                    const errorCloseBtn = mobileContainer.querySelector('.catalog__close-btn');
                    if (errorCloseBtn) {
                        errorCloseBtn.addEventListener('click', function(e) {
                            e.preventDefault();
                            e.stopPropagation();
                            closeMobileMenu();
                        });
                    }
                }
            })
            .finally(() => {
                isMobileMenuLoading = false;
            });
        }

        function loadCategoryContent(itemId, link) {
            if (mobileCategoryContentCache[itemId]) {
                showCategoryContent(itemId, link);
                return;
            }

            const catalog = catalogNavBarMenu.querySelector('.catalog');
            if (!catalog) return;

            const secondColumn = catalog.querySelector('.catalog__second-column');
            if (!secondColumn) return;

            const loadingIndicator = document.createElement('div');
            loadingIndicator.className = 'catalog__loading';
            loadingIndicator.innerHTML = '<div class="mega-menu__spinner"></div>';
            loadingIndicator.style.display = 'flex';
            
            secondColumn.innerHTML = '';
            secondColumn.appendChild(loadingIndicator);
            secondColumn.classList.add('_active');

            const locale = document.documentElement.lang || 'ru';
            fetch(`/api/v1/mega-menu/${mobileMenuCode}/mobile-category/${itemId}/content`, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-Localization': locale
                }
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(err => {
                        throw new Error(err.message || 'Ошибка загрузки контента');
                    }).catch(() => {
                        throw new Error('Ошибка загрузки контента');
                    });
                }
                return response.json();
            })
            .then(data => {
                if (data && typeof data === 'object' && data.success === true && data.html) {
                    mobileCategoryContentCache[itemId] = data.html;
                    showCategoryContent(itemId, link);
                } else {
                    throw new Error(data?.message || 'Неверный формат ответа');
                }
            })
            .catch(error => {
                console.error('Ошибка загрузки контента категории:', error);
                if (secondColumn) {
                    secondColumn.innerHTML = '<div class="catalog__error"><div class="catalog__error-content"><p>Ошибка загрузки контента. Пожалуйста, обновите страницу.</p></div></div>';
                }
            });
        }

        function showCategoryContent(itemId, link) {
            if (!mobileCategoryContentCache[itemId]) return;

            const catalog = catalogNavBarMenu.querySelector('.catalog');
            if (!catalog) return;

            const secondColumn = catalog.querySelector('.catalog__second-column');
            if (secondColumn) {
                secondColumn.innerHTML = mobileCategoryContentCache[itemId];
                secondColumn.classList.add('_active');
                
                const categoryItem = secondColumn.querySelector(`[data-category-id="${itemId}"]`);
                if (categoryItem) {
                    categoryItem.classList.add('column-catalog__item--active');
                }

                const closeBtn = secondColumn.querySelector('.column-catalog__close');
                if (closeBtn) {
                    closeBtn.addEventListener('click', function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        closeCategoryContent();
                    });
                }

                const backBtn = secondColumn.querySelector('.column-catalog__back');
                if (backBtn) {
                    backBtn.addEventListener('click', function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        closeCategoryContent();
                    });
                }
            }

            const mainColumnLinks = catalog.querySelectorAll('.main-column-catalog__link.catalog-category-link');
            mainColumnLinks.forEach(function(l) {
                l.classList.remove('_active');
            });
            if (link) {
                link.classList.add('_active');
            }
        }

        function closeCategoryContent() {
            const catalog = catalogNavBarMenu.querySelector('.catalog');
            if (!catalog) return;

            const secondColumn = catalog.querySelector('.catalog__second-column');
            if (secondColumn) {
                secondColumn.classList.remove('_active');
                const activeItem = secondColumn.querySelector('.column-catalog__item--active');
                if (activeItem) {
                    activeItem.classList.remove('column-catalog__item--active');
                }
            }
            const mainColumnLinks = catalog.querySelectorAll('.main-column-catalog__link.catalog-category-link');
            mainColumnLinks.forEach(function(link) {
                link.classList.remove('_active');
            });
        }

        function closeMobileMenu() {
            const catalog = catalogNavBarMenu.querySelector('.catalog');
            if (catalog) {
                const secondColumn = catalog.querySelector('.catalog__second-column');
                if (secondColumn) secondColumn.classList.remove('_active');
            }
            document.body.classList.remove('body-lock');
            catalogNavBarMenu.classList.remove('_active');
        }

        function initializeMobileMenuInteractions() {
            const catalog = catalogNavBarMenu.querySelector('.catalog');
            if (!catalog) return;

            const catalogCloseBtn = catalog.querySelector('.catalog__close-btn');
            const mainColumn = catalog.querySelector('.catalog__main-column');
            const secondColumn = catalog.querySelector('.catalog__second-column');

            function handleCatalogClick(event) {
                const target = event.target;
                
                if (target.classList.contains('column-catalog__back') || 
                    target.classList.contains('column-catalog__close') ||
                    target.closest('.column-catalog__back') ||
                    target.closest('.column-catalog__close')) {
                    event.preventDefault();
                    event.stopPropagation();
                    closeCategoryContent();
                    return;
                }

                const link = target.closest('.main-column-catalog__link.catalog-category-link');
                if (link && link.hasAttribute('data-main-category')) {
                    event.preventDefault();
                    event.stopImmediatePropagation();
                    
                    const itemId = link.getAttribute('data-main-category');
                    loadCategoryContent(itemId, link);
                }
            }

            function handleCloseClick(event) {
                if (event.target.classList.contains('catalog__close-btn') || event.target.closest('.catalog__close-btn')) {
                    event.preventDefault();
                    event.stopPropagation();
                    closeMobileMenu();
                }
            }

            if (mainColumn) {
                mainColumn.removeEventListener('click', handleCatalogClick);
                mainColumn.addEventListener('click', handleCatalogClick);
            }

            if (secondColumn) {
                secondColumn.removeEventListener('click', handleCatalogClick);
                secondColumn.addEventListener('click', handleCatalogClick);
            }

            if (catalogCloseBtn) {
                catalogCloseBtn.removeEventListener('click', handleCloseClick);
                catalogCloseBtn.addEventListener('click', handleCloseClick);
            }
        }

        btnCatalog.addEventListener("click", () => {
            const isActive = catalogNavBarMenu.classList.contains("_active");
            closeAllMenus();
            if (!isActive) {
                catalogNavBarMenu.classList.add("_active");
                document.body.classList.add("body-lock");
                if (!isMobileMenuLoaded && !isMobileMenuLoading) {
                    loadMobileMenuContent();
                } else if (isMobileMenuLoaded) {
                    initializeMobileMenuInteractions();
                }
            }
        });
        }
        // Старый вариант меню обрабатывается в отдельном блоке выше (строки 1056-1155)
    }

    if (btnOpenSearchMenu && searchMenu) {
        btnOpenSearchMenu.addEventListener("click", (event) => {
            event.stopPropagation();
            searchMenu.classList.add("_active");
        });
    }

    if (btnCloseSearchMenu && searchMenu) {
        btnCloseSearchMenu.addEventListener("click", (event) => {
            event.stopPropagation();
            searchMenu.classList.remove("_active");
        });
    }
});
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('filtersModal');
    const openBtn = document.querySelector('[data-bs-target="#filtersModal"]');
    const closeBtn = document.querySelector('[data-bs-dismiss="modal"]');
    const cancelBtn = document.querySelector('.modal-footer .btn-secondary');

    function openModal() {
        modal.style.display = 'block';
        modal.classList.add('show');
        document.body.classList.add('modal-open');

        const backdrop = document.createElement('div');
        backdrop.className = 'modal-backdrop fade show';
        document.body.appendChild(backdrop);

        initializeRangeSlider();
    }

    function closeModal() {
        modal.style.display = 'none';
        modal.classList.remove('show');
        document.body.classList.remove('modal-open');

        const backdrop = document.querySelector('.modal-backdrop');
        if (backdrop) {
            backdrop.remove();
        }
    }

    function initializeRangeSlider() {
        const rangevalue = modal.querySelector(".slider .progress");
        const rangeInputvalue = modal.querySelectorAll(".range-input input");
        const priceInputvalue = modal.querySelectorAll(".price-input input");

        if (!rangevalue || rangeInputvalue.length === 0 || priceInputvalue.length === 0) {
            return;
        }

        let priceGap = 1;

        for (let i = 0; i < priceInputvalue.length; i++) {
            priceInputvalue[i].addEventListener("input", e => {
                let minp = parseInt(priceInputvalue[0].value);
                let maxp = parseInt(priceInputvalue[1].value);
                let diff = maxp - minp;

                if (minp < 0) {
                    alert("minimum price cannot be less than 0");
                    priceInputvalue[0].value = 0;
                    minp = 0;
                }

                if (maxp > 10000) {
                    alert("maximum price cannot be greater than 10000");
                    priceInputvalue[1].value = 10000;
                    maxp = 10000;
                }

                if (minp > maxp - priceGap) {
                    priceInputvalue[0].value = maxp - priceGap;
                    minp = maxp - priceGap;

                    if (minp < 0) {
                        priceInputvalue[0].value = 0;
                        minp = 0;
                    }
                }

                if (diff >= priceGap && maxp <= rangeInputvalue[1].max) {
                    if (e.target.className === "input-min") {
                        rangeInputvalue[0].value = minp;
                        let value1 = rangeInputvalue[0].max;
                        rangevalue.style.left = `${(minp / value1) * 100}%`;
                    }
                    else {
                        rangeInputvalue[1].value = maxp;
                        let value2 = rangeInputvalue[1].max;
                        rangevalue.style.right = `${100 - (maxp / value2) * 100}%`;
                    }
                }
            });
        }

        for (let i = 0; i < rangeInputvalue.length; i++) {
            rangeInputvalue[i].addEventListener("input", e => {
                let minVal = parseInt(rangeInputvalue[0].value);
                let maxVal = parseInt(rangeInputvalue[1].value);
                let diff = maxVal - minVal;

                if (diff < priceGap) {
                    if (e.target.className === "range-min") {
                        rangeInputvalue[0].value = maxVal - priceGap;
                    }
                    else {
                        rangeInputvalue[1].value = minVal + priceGap;
                    }
                }
                else {
                    priceInputvalue[0].value = minVal;
                    priceInputvalue[1].value = maxVal;
                    rangevalue.style.left = `${(minVal / rangeInputvalue[0].max) * 100}%`;
                    rangevalue.style.right = `${100 - (maxVal / rangeInputvalue[1].max) * 100}%`;
                }
            });
        }

        setInitialRangeValues();
    }

    function setInitialRangeValues() {
        const rangevalue = modal.querySelector(".slider .progress");
        const rangeInputvalue = modal.querySelectorAll(".range-input input");
        const priceInputvalue = modal.querySelectorAll(".price-input input");

        if (rangevalue && rangeInputvalue.length >= 2 && priceInputvalue.length >= 2) {
            const minVal = parseInt(rangeInputvalue[0].value);
            const maxVal = parseInt(rangeInputvalue[1].value);

            rangevalue.style.left = `${(minVal / rangeInputvalue[0].max) * 100}%`;
            rangevalue.style.right = `${100 - (maxVal / rangeInputvalue[1].max) * 100}%`;
        }
    }

    if (openBtn) {
        openBtn.addEventListener('click', openModal);
    }

    if (closeBtn) {
        closeBtn.addEventListener('click', closeModal);
    }

    if (cancelBtn) {
        cancelBtn.addEventListener('click', closeModal);
    }

    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            closeModal();
        }
    });

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && modal.classList.contains('show')) {
            closeModal();
        }
    });
});
// Show sticky mobile header script and scroll to top btn
document.addEventListener('DOMContentLoaded', function () {
    const scrollBtn = document.getElementById('scroll_to_top_btn');
    const stickyHeader = document.querySelector('.mobile-sticky-header');
    const mainHeader = document.getElementById('header');
    const footer = document.querySelector('footer');

    if (!scrollBtn || !stickyHeader || !mainHeader || !footer) return;

    // Скрыть кнопку при загрузке
    scrollBtn.style.display = 'none';

    // Показать кнопку только при скролле вниз
    window.addEventListener('scroll', function () {
        if (window.scrollY > 100) {
            scrollBtn.style.display = '';
        } else {
            scrollBtn.style.display = 'none';
        }
    });

    // Observer для sticky header
    const headerObserver = new IntersectionObserver(function (entries) {
    if (!entries[0].isIntersecting) {
    stickyHeader.style.display = 'flex';
    scrollBtn.classList.add('fixed');
    } else {
        stickyHeader.style.display = 'none';
        scrollBtn.classList.remove('fixed');
    }
    }, { threshold: 0 });
    headerObserver.observe(mainHeader);

    // Observer для футера
    const footerObserver = new IntersectionObserver(function (entries) {
    if (entries[0].isIntersecting) {
    scrollBtn.classList.remove('fixed');
    scrollBtn.classList.add('in-footer');
    } else {
        scrollBtn.classList.remove('in-footer');
        if (!mainHeader.getBoundingClientRect().top >= 0) {
        scrollBtn.classList.add('fixed');
    }
    }
    }, {
        root: null,
        threshold: 0,
    });
    footerObserver.observe(footer);
});
// change products list view (table/list)
document.addEventListener('DOMContentLoaded', function() {
    const btnTable = document.getElementById('viewTable');
    const btnList = document.getElementById('viewList');
    const tableView = document.getElementById('productsTableView');
    const listView = document.getElementById('productsListView');
    function setViewMode(mode) {
        if (mode === 'list') {
            tableView.style.display = 'none';
            listView.style.display = '';
            btnList.classList.add('active');
            btnTable.classList.remove('active');
        } else {
            tableView.style.display = '';
            listView.style.display = 'none';
            btnTable.classList.add('active');
            btnList.classList.remove('active');
        }
        localStorage.setItem('brandViewMode', mode);
    }
    btnTable.addEventListener('click', function() { setViewMode('table'); });
    btnList.addEventListener('click', function() { setViewMode('list'); });
    const savedMode = localStorage.getItem('brandViewMode');
    if (savedMode === 'list') {
        setViewMode('list');
    }
});
// open sort options for products pages
document.addEventListener('DOMContentLoaded', function() {
    const dropdown = document.querySelector('.sort-dropdown');
    const toggle = dropdown.querySelector('.sort-dropdown-toggle');
    const menu = dropdown.querySelector('.sort-dropdown-menu');
    const options = menu.querySelectorAll('.sort-option');
    let opened = false;
    function openMenu() {
        menu.style.display = 'block';
        opened = true;
    }
    function closeMenu() {
        menu.style.display = 'none';
        opened = false;
    }
    toggle.addEventListener('click', function(e) {
        e.preventDefault();
        if (opened) {
            closeMenu();
        } else {
            openMenu();
        }
    });
    document.addEventListener('click', function(e) {
        if (!dropdown.contains(e.target)) {
            closeMenu();
        }
    });
    options.forEach(option => {
        option.addEventListener('click', function(e) {
            e.preventDefault();
            const sort = this.getAttribute('data-sort');
            const url = new URL(window.location.href);
            url.searchParams.set('sort', sort === 'price_desc' ? '-price' : sort);
            window.location.href = url.toString();
        });
    });
});

class SearchHistory {
    constructor(inputSelector, dropdownSelector, listSelector, clearButtonSelector) {
        this.input = document.querySelector(inputSelector);
        this.dropdown = document.querySelector(dropdownSelector);
        this.list = document.querySelector(listSelector);
        this.clearButton = document.querySelector(clearButtonSelector);
        this.debounceTimer = null;
        this.currentMode = 'history';
        
        if (!this.input || !this.dropdown || !this.list || !this.clearButton) {
            return;
        }
        
        this.init();
    }
    
    init() {
        this.input.addEventListener('focus', () => {
            if (this.input.value.trim() === '') {
                this.loadAndShowHistory();
            } else {
                this.loadAndShowSuggestions(this.input.value);
            }
        });
        
        this.input.addEventListener('input', () => {
            clearTimeout(this.debounceTimer);
            
            const query = this.input.value.trim();
            
            if (query === '') {
                this.loadAndShowHistory();
            } else {
                this.debounceTimer = setTimeout(() => {
                    this.loadAndShowSuggestions(query);
                }, 300);
            }
        });
        
        this.clearButton.addEventListener('click', () => this.clearHistory());
        
        document.addEventListener('click', (e) => {
            if (!this.dropdown.contains(e.target) && !this.input.contains(e.target)) {
                this.hideHistory();
            }
        });
    }
    
    loadAndShowHistory() {
        this.currentMode = 'history';
        fetch('/search/history')
            .then(response => response.json())
            .then(data => {
                if (data.success && data.data.length > 0) {
                    this.renderHistory(data.data);
                    this.showHistory();
                } else {
                    this.hideHistory();
                }
            })
            .catch(error => {
                console.error('Ошибка загрузки истории поиска:', error);
            });
    }
    
    loadAndShowSuggestions(query) {
        this.currentMode = 'suggestions';
        
        const locale = document.documentElement.lang || 'ru';
        
        fetch('/search/suggestions?query=' + encodeURIComponent(query) + '&locale=' + locale)
            .then(response => response.json())
            .then(data => {
                if (data.success && data.data.length > 0) {
                    this.renderSuggestions(data.data);
                    this.showHistory();
                } else {
                    this.hideHistory();
                }
            })
            .catch(error => {
                console.error('Ошибка загрузки подсказок:', error);
            });
    }
    
    renderHistory(items) {
        this.list.innerHTML = '';
        
        const emptyText = this.clearButton.getAttribute('data-empty-text');
        
        if (items.length === 0) {
            this.list.innerHTML = '<div class="search-history-empty">' + emptyText + '</div>';
            return;
        }
        
        items.forEach(query => {
            const item = document.createElement('div');
            item.className = 'search-history-item';
            
            const textSpan = document.createElement('span');
            textSpan.className = 'search-history-item-text';
            textSpan.textContent = query;
            textSpan.addEventListener('click', () => {
                this.input.value = query;
                this.input.form.submit();
            });
            
            const deleteBtn = document.createElement('button');
            deleteBtn.className = 'search-history-item-delete';
            deleteBtn.innerHTML = '<i class="icon-close"></i>';
            deleteBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                this.deleteHistoryItem(query);
            });
            
            item.appendChild(textSpan);
            item.appendChild(deleteBtn);
            this.list.appendChild(item);
        });
    }
    
    renderSuggestions(items) {
        this.list.innerHTML = '';
        
        if (items.length === 0) {
            return;
        }
        
        items.forEach(suggestion => {
            const item = document.createElement('div');
            item.className = 'search-suggestion-item';
            
            const icon = document.createElement('i');
            if (suggestion.type === 'product') {
                icon.className = 'icon-search search-suggestion-icon';
            } else if (suggestion.type === 'category') {
                icon.className = 'icon-radop-bars search-suggestion-icon';
            } else if (suggestion.type === 'brand') {
                icon.className = 'icon-star search-suggestion-icon';
            }
            
            const textSpan = document.createElement('span');
            textSpan.className = 'search-suggestion-text';
            textSpan.textContent = suggestion.text;
            
            item.appendChild(icon);
            item.appendChild(textSpan);
            
            item.addEventListener('click', () => {
                this.input.value = suggestion.text;
                this.input.form.submit();
            });
            
            this.list.appendChild(item);
        });
    }
    
    showHistory() {
        this.updateHeaderTitle();
        this.dropdown.style.display = 'block';
    }
    
    hideHistory() {
        this.dropdown.style.display = 'none';
    }
    
    updateHeaderTitle() {
        const headerTitle = this.dropdown.querySelector('.search-history-title');
        if (!headerTitle) return;
        
        if (this.currentMode === 'suggestions') {
            headerTitle.textContent = headerTitle.getAttribute('data-suggestions-title') || 'Похожие запросы';
            this.clearButton.style.display = 'none';
        } else {
            headerTitle.textContent = headerTitle.getAttribute('data-history-title') || 'История поиска';
            this.clearButton.style.display = 'flex';
        }
    }
    
    clearHistory() {
        const emptyText = this.clearButton.getAttribute('data-empty-text');
        
        fetch('/search/history/clear', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                this.list.innerHTML = '<div class="search-history-empty">' + emptyText + '</div>';
                setTimeout(() => this.hideHistory(), 1000);
            }
        })
        .catch(error => {
            console.error('Ошибка очистки истории:', error);
        });
    }
    
    deleteHistoryItem(query) {
        fetch('/search/history/delete', {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ query: query })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                this.loadAndShowHistory();
            }
        })
        .catch(error => {
            console.error('Ошибка удаления элемента:', error);
        });
    }
}

document.addEventListener('DOMContentLoaded', function() {
    new SearchHistory('.search-desktop', '#search-history-dropdown', '#search-history-list', '#search-history-clear-desktop');
    new SearchHistory('.search-mobile-header', '#search-history-dropdown-mobile-header', '#search-history-list-mobile-header', '#search-history-clear-mobile-header');
    new SearchHistory('.search-sticky', '#search-history-dropdown-sticky', '#search-history-list-sticky', '#search-history-clear-sticky');
    new SearchHistory('.search-mobile-navbar', '#search-history-dropdown-mobile', '#search-history-list-mobile', '#search-history-clear-mobile');
});
