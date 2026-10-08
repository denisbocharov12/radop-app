
            /*
             * Auto-submit: checkboxes apply immediately, price inputs and the
             * slider after a pause so dragging or typing "1250" does not fire
             * a navigation per step.
             */
            document.addEventListener('DOMContentLoaded', function () {
                var form = document.querySelector('[data-sf-filter-form]');
                if (!form) return;

                /* Auto-apply only where the form is a permanent sidebar. In the
                   phone drawer each tick would reload the page and close the
                   drawer mid-selection, so there the "Apply" button submits. */
                var desktop = window.matchMedia('(min-width: 1024px)');
                var timer = null;

                function submitSoon(delay) {
                    /* Живое обновление выдачи берёт это на себя (ТЗ 48). */
                    if (document.documentElement.dataset.sfLiveFilter === '1') return;
                    if (!desktop.matches) return;
                    clearTimeout(timer);
                    timer = setTimeout(function () { form.requestSubmit ? form.requestSubmit() : form.submit(); }, delay);
                }

                form.querySelectorAll('input[type=checkbox]').forEach(function (box) {
                    box.addEventListener('change', function () { submitSoon(0); });
                });

                /* Two-handle price slider bound to the number inputs. */
                var range = form.querySelector('[data-sf-price-range]');
                var fromInput = form.querySelector('[data-sf-price-from]');
                var toInput = form.querySelector('[data-sf-price-to]');

                if (range && fromInput && toInput) {
                    var min = Number(range.dataset.min) || 0;
                    var max = Number(range.dataset.max) || 1000;
                    var span = Math.max(1, max - min);
                    var minHandle = range.querySelector('[data-sf-range-min]');
                    var maxHandle = range.querySelector('[data-sf-range-max]');
                    var fill = range.querySelector('[data-sf-range-fill]');

                    var paint = function () {
                        var lo = Math.min(Number(minHandle.value), Number(maxHandle.value));
                        var hi = Math.max(Number(minHandle.value), Number(maxHandle.value));
                        fill.style.left = ((lo - min) / span * 100) + '%';
                        fill.style.right = (100 - (hi - min) / span * 100) + '%';
                    };

                    var fromHandles = function (event) {
                        var lo = Number(minHandle.value);
                        var hi = Number(maxHandle.value);
                        if (lo > hi) {
                            if (event.target === minHandle) minHandle.value = hi; else maxHandle.value = lo;
                        }
                        fromInput.value = Number(minHandle.value) > min ? minHandle.value : '';
                        toInput.value = Number(maxHandle.value) < max ? maxHandle.value : '';
                        paint();
                        submitSoon(700);
                    };

                    var fromNumbers = function () {
                        minHandle.value = Math.min(Math.max(Number(fromInput.value) || min, min), max);
                        maxHandle.value = toInput.value === '' ? max : Math.min(Math.max(Number(toInput.value), min), max);
                        paint();
                        submitSoon(700);
                    };

                    minHandle.addEventListener('input', fromHandles);
                    maxHandle.addEventListener('input', fromHandles);
                    fromInput.addEventListener('input', fromNumbers);
                    toInput.addEventListener('input', fromNumbers);
                    paint();
                }

                /* Empty price bounds and an unset sort would otherwise travel as
                   filter[price][from]= and sort= in the address. */
                form.addEventListener('submit', function () {
                    /* A typed "from 400 to 250" would match nothing; read it as 250–400. */
                    if (fromInput && toInput && fromInput.value !== '' && toInput.value !== ''
                        && Number(fromInput.value) > Number(toInput.value)) {
                        var swap = fromInput.value;
                        fromInput.value = toInput.value;
                        toInput.value = swap;
                    }

                    form.querySelectorAll('input[type=number], input[name=sort]').forEach(function (input) {
                        if (input.value === '') input.disabled = true;
                    });
                });

                /* Длинные группы (категории, характеристики) раскрываются по
                   месту: своя прокрутка внутри группы прячет часть значений и
                   спорит с прокруткой страницы. */
                form.querySelectorAll('[data-sf-more-toggle]').forEach(function (button) {
                    var group = button.closest('details');
                    if (!group) return;

                    var extras = group.querySelectorAll('[data-sf-more-item]');
                    var open = false;

                    button.addEventListener('click', function () {
                        open = !open;
                        extras.forEach(function (item) { item.classList.toggle('hidden', !open); });
                        button.textContent = open ? button.dataset.labelLess : button.dataset.labelMore;
                    });
                });
                /* ТЗ 42, 43: первые семь брендов, остальное по кнопке; поиск по списку. */
                var brandBox = form.querySelector('[data-sf-brand-filter]');
                if (brandBox) {
                var toggle = brandBox.querySelector('[data-sf-brand-toggle]');
                    var extras = brandBox.querySelectorAll('[data-sf-brand-extra]');
                    var expanded = false;

                    if (toggle) {
                        toggle.addEventListener('click', function () {
                            expanded = !expanded;
                            extras.forEach(function (el) { el.classList.toggle('hidden', !expanded); });
                            toggle.textContent = expanded ? toggle.dataset.labelLess : toggle.dataset.labelMore;
                        });
                    }

                    var search = brandBox.querySelector('[data-sf-brand-search]');
                    if (search) {
                        search.addEventListener('input', function () {
                            var term = search.value.trim().toLowerCase();
                            if (toggle) { toggle.classList.toggle('hidden', term !== ''); }
                            brandBox.querySelectorAll('[data-sf-brand-option]').forEach(function (option) {
                                var matches = option.dataset.sfBrandOption.indexOf(term) !== -1;
                                var hiddenByCollapse = option.hasAttribute('data-sf-brand-extra') && !expanded;
                                option.classList.toggle('hidden', term === '' ? hiddenByCollapse : !matches);
                            });
                        });
                    }
                }

                var reset = document.getElementById('filterResetBtn');
                if (reset) {
                    reset.addEventListener('click', function () {
                        var url = new URL(form.action || window.location.href);
                        url.searchParams.delete('filter');
                        url.searchParams.delete('page');
                        url.searchParams.delete('sort');
                        window.location.href = url.toString();
                    });
                }
            });
        