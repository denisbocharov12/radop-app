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
  $("#main-banner").slick({
    autoplay: true,
    dots: true,
    autoplaySpeed: 3000,
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
            dots: true,
            arrows: false,
            slidesToScroll: 3,
          },
        },
        {
          breakpoint: 768,
          settings: {
            dots: true,
            swipe: true,
            arrows: false,
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
          dots: true,
          arrows: false,
          slidesToScroll: 1,
        },
      },
      {
        breakpoint: 768,
        settings: {
          dots: true,
          swipe: true,
          arrows: false,
          slidesToShow: 2,
          slidesToScroll: 1,
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
            dots: true,
            arrows: false,
            slidesToScroll: 1,
          },
        },
        {
          breakpoint: 768,
          settings: {
            dots: true,
            swipe: true,
            arrows: false,
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
        if ($(this).scrollTop() > 105) {
            $('#header-js-sticky').addClass('header-js-sticky container');
        } else {
            $('#header-js-sticky').removeClass('header-js-sticky container');
            if ($('.row-header-catalog .header-catalog').hasClass('show')) {
                $('.row-header-catalog .header-catalog').removeClass('show');
            }
        }
    });
    $("a.scroll-element").click(function(e) {
        e.preventDefault();
        var target = $(this).data("anchor");

        $('html, body').animate({scrollTop:$('#'+target).offset().top - 300}, 300, 'linear');
    });

    $('.btn-quantity-product').click(function (){
        var qtyCount = $(this).parent().parent('.qty-block').find('.product-qty-item').val();
        var productId = $(this).parent().parent('.qty-block').find('.product-qty-item').data('product-id');
        var productPrice = $(this).parent().parent('.qty-block').find('.product-qty-item').data('price');
        var packageCount = $(this).parent().parent('.qty-block').find('.product-qty-item').data('package');

        var changedElement = $('#product-card-summary-'+productId);
        var result = (qtyCount*productPrice)/packageCount;

        changedElement.html(result.toFixed(2).replace('.',','));
    });

    $('.product-qty-item').on('change', function (){
        var qtyCount = $(this).val();
        var productId = $(this).data('product-id');
        var productPrice = $(this).data('price');
        var packageCount = $(this).data('package');

        var changedElement = $('#product-card-summary-'+productId);
        var result = (qtyCount*productPrice)/packageCount;

        changedElement.html(result.toFixed(2).replace('.',','));
    })

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

    $('.theme-toggle-list li .theme-toggle-item-title').click(function () {

        var content = $(this).next('.theme-toggle-item-content');

        if (content.is(':hidden')) {
            content.slideDown('0').css('display', 'flex');
            $(this).children('.theme-toggle-item-title i').css('transform', 'rotate(90deg)');
        } else {
            content.slideUp('0');
            $(this).children('.theme-toggle-item-title i').css('transform', 'rotate(0deg)');
        }

    });

    let inputs = $('.theme-toggle-item-content').children('.theme-checkbox');

    inputs.each(function(){
       if ($(this).is(':checked')) {
           $(this).parent('.theme-toggle-item-content').css('display', 'flex');
       }
    });
});


$(document).ready(function(){

    const rangevalue =
        document.querySelector(".slider .progress");
    const rangeInputvalue =
        document.querySelectorAll(".range-input input");

    let priceGap = 1;


    const priceInputvalue =
        document.querySelectorAll(".price-input input");


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
    const catalog = document.querySelector(".catalog");
    if (catalog) {
        const body = document.body;
        const catalogBtn = document.querySelector(".catalog-btn");
        const catalogCloseBtn = document.querySelector(".catalog__close-btn");
        const secondColumn = document.querySelector(".catalog__second-column");
        const secondColumnList = document.querySelectorAll(".catalog__second-column .column-catalog__item");
        // const thirdColumn = document.querySelector(".catalog__third-column");
        // const thirdColumnList = document.querySelectorAll(".catalog__third-column .column-catalog__item");
        const allSecondColumnLinks = document.querySelectorAll(".catalog__second-column .drop-menu-list__link");
        catalogBtn.addEventListener("click", openCatalog);
        catalog.addEventListener("click", getBack);
        catalog.addEventListener("click", openSecondColumn);
        catalogCloseBtn.addEventListener("click", closeBtnHeadler);
        // secondColumn.addEventListener("click", openThirdColumn);
        let mainCurrentLink = null;
        let secondCurrenLink = null;
        function getBack(event) {
            event.stopPropagation();
            if (event.target.classList.contains("column-catalog__back")) {
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
                catalog.classList.add("catalog--active");
                body.classList.add("body-lock");
                body.addEventListener("click", removeCatalog);
            }
        }
        function removeCatalog({target}) {
            if (target.classList.contains("catalog") || target.closest(".catalog")) return;
            closeMenu();
        }
        function openSecondColumn({target}) {
            console.log(target.classList, target.closest(".main-column-catalog__link"))
            if (target.classList.contains("main-column-catalog__link") || target.closest(".main-column-catalog__link")) {
                mainCurrentLink?.classList.remove("_active");
                secondCurrenLink?.classList.remove("_active");
                // thirdColumn.classList.remove("_active");
                let currentElem = target.closest(".main-column-catalog__link");
                currentElem.classList.add("_active");
                mainCurrentLink = currentElem;
                secondColumn.classList.add("_active");
                const elemId = target.dataset.mainCategory;
                [ ...secondColumnList ].forEach((elem => {
                    elem.classList.remove("column-catalog__item--active");
                    if (elem.id === elemId) elem.classList.add("column-catalog__item--active");
                }));
            }
        }
        function closeBtnHeadler({target}) {
            if (target.classList.contains("catalog__close-btn") || target.closest(".catalog__close-btn")) closeMenu();
        }
        function closeMenu() {
            catalog.classList.remove("catalog--active");
            secondColumn.classList.remove("_active");
            if (mainCurrentLink) mainCurrentLink.classList.remove("_active");
            if (secondCurrenLink) secondCurrenLink.classList.remove("_active");
            [ ...secondColumnList ].forEach((elem => {
                elem.classList.remove("column-catalog__item--active");
            }));
            body.classList.remove("body-lock");
            body.removeEventListener("click", removeCatalog);
        }
    }
}));
document.addEventListener("DOMContentLoaded", (() => {
    const mobileNavBarMenu = document.querySelector(".catalog-navbar");
    if (mobileNavBarMenu) {
        const mobileNavBarMenuBtn = document.querySelector(".navbar-menu__link_catalog");
        const searchMenu = document.querySelector(".search-menu-navbar");
        const openSearchMenuBtn = document.querySelector(".catalog-navbar__search");
        const closeSearchMenuBtn = document.querySelector(".search-menu-navbar__close");
        mobileNavBarMenuBtn.addEventListener("click", navBarCatalogToggle);
        // openSearchMenuBtn.addEventListener("click", searchMenuOpen);
        // closeSearchMenuBtn.addEventListener("click", closeSearchMenu);
        function searchMenuOpen(event) {
            event.stopPropagation();
            if (event.target.closest(".catalog-navbar__search")) searchMenu.classList.add("_active");
        }
        function closeSearchMenu(event) {
            event.stopPropagation();
            if (event.target.closest(".search-menu-navbar__close")) searchMenu.classList.remove("_active");
        }
        function navBarCatalogToggle(event) {
            if (event.target.closest(".navbar-menu__link_catalog")) mobileNavBarMenu.classList.toggle("_active");
        }
    }
}));
document.addEventListener("DOMContentLoaded", (() => {
    const searchNavBarMenu = document.querySelector(".search-navbar");
    if (searchNavBarMenu) {
        const mobileSearchNavBarMenuBtn = document.querySelector(".navbar-menu__link_search");
        mobileSearchNavBarMenuBtn.addEventListener("click", navBarCatalogToggle);
        function navBarCatalogToggle(event) {
            if (event.target.closest(".navbar-menu__link_search")) searchNavBarMenu.classList.toggle("_active");
        }
    }
}));
document.addEventListener("DOMContentLoaded", (() => {
    const otherNavBarMenu = document.querySelector(".other-navbar");
    if (otherNavBarMenu) {
        const mobileOtherNavBarMenuBtn = document.querySelector(".navbar-menu__link_other");
        mobileOtherNavBarMenuBtn.addEventListener("click", navBarCatalogToggle);
        function navBarCatalogToggle(event) {
            if (event.target.closest(".navbar-menu__link_other")) otherNavBarMenu.classList.toggle("_active");
        }
    }
}));
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
// Show sticky mobile header script
document.addEventListener('DOMContentLoaded', function() {
    var stickyHeader = document.querySelector('.mobile-sticky-header');
    var mainHeader = document.getElementById('header');
    if (!stickyHeader || !mainHeader) return;
    var observer = new IntersectionObserver(function(entries) {
        if (entries[0].isIntersecting) {
            stickyHeader.style.display = 'none';
        } else {
            stickyHeader.style.display = 'flex';
        }
    }, { threshold: 0 });
    observer.observe(mainHeader);
});
