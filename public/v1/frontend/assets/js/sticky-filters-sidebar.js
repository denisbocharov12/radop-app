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

    function ensurePlaceholder(sidebar) {
        var parent = sidebar.parentElement;
        if (!parent) return null;
        var existing = parent.querySelector('.' + PLACEHOLDER_CLASS);
        if (existing) return existing;
        var placeholder = document.createElement('div');
        placeholder.className = PLACEHOLDER_CLASS + ' col-12 col-md-3  col-theme-md-3';
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
        return r.bottom + getScrollY();
    }

    // Read fresh layout coordinates from the placeholder (which stays in flow).
    // The sidebar itself is position:fixed so its rect is stale after resize.
    function getFreshRect(sidebar) {
        var parent = sidebar.parentElement;
        var placeholder = parent ? parent.querySelector('.' + PLACEHOLDER_CLASS) : null;
        var source = placeholder || sidebar;
        var rect = source.getBoundingClientRect();
        var scrollY = getScrollY();
        var style = window.getComputedStyle(sidebar);
        var marginBottom = parseFloat(style.marginBottom) || MARGIN_BOTTOM;
        var height = sidebar.offsetHeight;
        var width = source.offsetWidth;
        if (placeholder) {
            width = placeholder.offsetWidth;
        }
        var docTop = rect.top + scrollY;
        return {
            top: docTop,
            height: height,
            bottom: docTop + height + marginBottom,
            width: width,
            left: rect.left + (window.pageXOffset || document.documentElement.scrollLeft)
        };
    }

    function updateSidebar(sidebar) {
        var rect = getFreshRect(sidebar);
        var scrollY = getScrollY();
        var vh = window.innerHeight;
        var rowBottom = getRowBottom(sidebar);

        var visibleHeight = vh - TOP_OFFSET;
        var sidebarTallerThanVisible = rect.height > visibleHeight;

        var state;
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

        if (state === '') {
            sidebar.classList.remove(CLASS_STICKY_TOP, CLASS_STICKY_BOTTOM);
            sidebar.style.left = '';
            sidebar.style.width = '';
            sidebar.style.top = '';
            sidebar.style.bottom = '';
            removePlaceholder(sidebar);
            return;
        }

        // Ensure placeholder exists so the layout doesn't collapse
        var placeholder = ensurePlaceholder(sidebar);
        if (placeholder) {
            setPlaceholderSize(placeholder, rect.width, rect.height);
        }

        if (state === 'top') {
            sidebar.classList.remove(CLASS_STICKY_BOTTOM);
            sidebar.classList.add(CLASS_STICKY_TOP);
            sidebar.style.left = rect.left + 'px';
            sidebar.style.width = rect.width + 'px';
            sidebar.style.bottom = '';
        } else if (state === 'bottom') {
            sidebar.classList.remove(CLASS_STICKY_TOP);
            sidebar.classList.add(CLASS_STICKY_BOTTOM);
            sidebar.style.left = rect.left + 'px';
            sidebar.style.width = rect.width + 'px';
            sidebar.style.top = '';
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

    // On resize: temporarily un-fix the sidebar so the placeholder reflows
    // to the correct position, then re-apply sticky with fresh coordinates.
    function resetAndUpdate(sidebar) {
        var wasTop = sidebar.classList.contains(CLASS_STICKY_TOP);
        var wasBottom = sidebar.classList.contains(CLASS_STICKY_BOTTOM);
        if (!wasTop && !wasBottom) {
            updateSidebar(sidebar);
            return;
        }
        // Temporarily remove fixed positioning so placeholder reflows
        sidebar.classList.remove(CLASS_STICKY_TOP, CLASS_STICKY_BOTTOM);
        sidebar.style.left = '';
        sidebar.style.width = '';
        sidebar.style.top = '';
        sidebar.style.bottom = '';
        // Force a sync reflow so the placeholder takes its natural position
        void sidebar.offsetWidth;
        // Now re-evaluate with fresh layout
        updateSidebar(sidebar);
    }

    function onResize() {
        if (!resizeTicking) {
            resizeTicking = true;
            requestAnimationFrame(function () {
                resizeTicking = false;
                for (var i = 0; i < sidebars.length; i++) {
                    if (document.contains(sidebars[i])) {
                        resetAndUpdate(sidebars[i]);
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
