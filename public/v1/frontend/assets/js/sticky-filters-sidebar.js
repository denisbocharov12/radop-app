(function () {
    'use strict';

    var TOP_OFFSET = 80;
    var MARGIN_BOTTOM = 40;
    var SELECTOR = '.col-theme-filters:not(.col-theme-filters-modal)';
    var CLASS_STICKY_TOP = 'is-sticky-top';
    var CLASS_STICKY_BOTTOM = 'is-sticky-bottom';
    var PLACEHOLDER_CLASS = 'col-theme-filters-placeholder';

    var scrollTicking = false;
    var resizeTicking = false;
    var sidebars = [];

    function getScrollY() {
        return window.pageYOffset || document.documentElement.scrollTop;
    }

    function getSidebarRect(sidebar, placeholder) {
        var el = placeholder || sidebar;
        var rect = el.getBoundingClientRect();
        var scrollY = getScrollY();
        var docTop = rect.top + scrollY;
        var style = window.getComputedStyle(sidebar);
        var marginBottom = parseFloat(style.marginBottom) || MARGIN_BOTTOM;
        var height = sidebar.offsetHeight;
        var width = sidebar.offsetWidth;
        if (placeholder) {
            height = placeholder.offsetHeight;
            width = placeholder.offsetWidth;
        }
        return {
            top: docTop,
            height: height,
            bottom: docTop + height + marginBottom,
            width: width,
            left: rect.left + (window.pageXOffset || document.documentElement.scrollLeft)
        };
    }

    function ensurePlaceholder(sidebar) {
        var parent = sidebar.parentElement;
        if (!parent) return null;
        var existing = parent.querySelector('.' + PLACEHOLDER_CLASS);
        if (existing) return existing;
        var placeholder = document.createElement('div');
        placeholder.className = PLACEHOLDER_CLASS + ' col-12 col-md-3';
        placeholder.setAttribute('aria-hidden', 'true');
        parent.insertBefore(placeholder, sidebar);
        return placeholder;
    }

    function removePlaceholder(sidebar) {
        var parent = sidebar.parentElement;
        if (!parent) return;
        var placeholder = parent.querySelector('.' + PLACEHOLDER_CLASS);
        if (placeholder) placeholder.remove();
    }

    function setPlaceholderSize(placeholder, width, height) {
        placeholder.style.height = height + 'px';
        placeholder.style.minHeight = height + 'px';
    }

    function getRowBottom(sidebar) {
        var row = sidebar.parentElement;
        if (!row) return Infinity;
        var r = row.getBoundingClientRect();
        return r.bottom + (window.pageYOffset || document.documentElement.scrollTop);
    }

    function updateSidebar(sidebar) {
        var placeholder = sidebar.parentElement ? sidebar.parentElement.querySelector('.' + PLACEHOLDER_CLASS) : null;
        var rect = getSidebarRect(sidebar, placeholder || null);
        var scrollY = getScrollY();
        var vh = window.innerHeight;
        var rowBottom = getRowBottom(sidebar);
        var state = null;

        var visibleHeight = vh - TOP_OFFSET;
        var sidebarTallerThanVisible = rect.height > visibleHeight;

        if (scrollY <= rect.top - TOP_OFFSET) {
            state = '';
        } else if (scrollY + vh >= rowBottom) {
            state = '';
        } else if (scrollY + vh >= rect.bottom && sidebarTallerThanVisible) {
            state = 'bottom';
        } else if (scrollY >= rect.top - TOP_OFFSET) {
            state = 'top';
        } else {
            state = '';
        }

        var hadSticky = sidebar.classList.contains(CLASS_STICKY_TOP) || sidebar.classList.contains(CLASS_STICKY_BOTTOM);

        if (state === '') {
            sidebar.classList.remove(CLASS_STICKY_TOP, CLASS_STICKY_BOTTOM);
            sidebar.style.left = '';
            sidebar.style.width = '';
            removePlaceholder(sidebar);
            return;
        }

        if (state === 'top') {
            var fixLeft, fixWidth;
            if (!hadSticky) {
                fixLeft = sidebar.getBoundingClientRect().left;
                fixWidth = sidebar.offsetWidth;
                var phTop = ensurePlaceholder(sidebar);
                setPlaceholderSize(phTop, fixWidth, rect.height);
            } else {
                fixLeft = sidebar.getBoundingClientRect().left;
                fixWidth = sidebar.offsetWidth;
            }
            sidebar.classList.remove(CLASS_STICKY_BOTTOM);
            sidebar.classList.add(CLASS_STICKY_TOP);
            sidebar.style.left = fixLeft + 'px';
            sidebar.style.width = fixWidth + 'px';
            sidebar.style.bottom = '';
            return;
        }

        if (state === 'bottom') {
            var fixLeftBottom, fixWidthBottom;
            if (!hadSticky) {
                fixLeftBottom = sidebar.getBoundingClientRect().left;
                fixWidthBottom = sidebar.offsetWidth;
                var phBottom = ensurePlaceholder(sidebar);
                setPlaceholderSize(phBottom, fixWidthBottom, rect.height);
            } else {
                fixLeftBottom = sidebar.getBoundingClientRect().left;
                fixWidthBottom = sidebar.offsetWidth;
            }
            sidebar.classList.remove(CLASS_STICKY_TOP);
            sidebar.classList.add(CLASS_STICKY_BOTTOM);
            sidebar.style.left = fixLeftBottom + 'px';
            sidebar.style.width = fixWidthBottom + 'px';
            sidebar.style.top = '';
            return;
        }
    }

    function onScroll() {
        if (!scrollTicking) {
            scrollTicking = true;
            requestAnimationFrame(function () {
                scrollTicking = false;
                for (var i = 0; i < sidebars.length; i++) {
                    if (document.contains(sidebars[i])) {
                        updateSidebar(sidebars[i]);
                    }
                }
            });
        }
    }

    function onResize() {
        if (!resizeTicking) {
            resizeTicking = true;
            requestAnimationFrame(function () {
                resizeTicking = false;
                for (var i = 0; i < sidebars.length; i++) {
                    if (document.contains(sidebars[i])) {
                        updateSidebar(sidebars[i]);
                    }
                }
            });
        }
    }

    function init() {
        sidebars = [].slice.call(document.querySelectorAll(SELECTOR));
        if (sidebars.length === 0) return;
        for (var i = 0; i < sidebars.length; i++) {
            updateSidebar(sidebars[i]);
        }
        window.addEventListener('scroll', onScroll, { passive: true });
        window.addEventListener('resize', onResize);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
