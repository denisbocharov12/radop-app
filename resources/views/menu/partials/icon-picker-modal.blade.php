<div id="iconPickerModal"
     x-data="{ open: false }"
     x-show="open"
     x-cloak
     @open-icon-picker.window="open = true"
     @keydown.escape.window="open = false"
     class="fixed inset-0 z-50 flex items-center justify-center p-4"
     style="display: none;">
    <div class="absolute inset-0 bg-black/40" @click="open = false"></div>
    <div class="icon-picker-modal relative w-full max-w-3xl rounded-2xl bg-white shadow-xl">
        <div class="flex items-center justify-between border-b border-gray-200 px-5 py-4">
            <h5 class="text-base font-semibold text-gray-900">Выбор иконки</h5>
            <button type="button" @click="open = false" class="text-gray-400 hover:text-gray-600">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>
        <div class="p-5">
            <div class="icon-picker-search mb-4">
                <input type="text" id="icon-search" placeholder="Поиск иконки..."
                       class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-brand-500 focus:ring-1 focus:ring-brand-500 focus:outline-none">
            </div>
            <div class="icon-grid">
                @php
                    $fontAwesomeIcons = [
                        'fas fa-home', 'fas fa-user', 'fas fa-shopping-cart', 'fas fa-heart',
                        'fas fa-star', 'fas fa-search', 'fas fa-bell', 'fas fa-envelope',
                        'fas fa-phone', 'fas fa-map-marker-alt', 'fas fa-calendar', 'fas fa-clock',
                        'fas fa-cog', 'fas fa-bars', 'fas fa-times', 'fas fa-check',
                        'fas fa-plus', 'fas fa-minus', 'fas fa-edit', 'fas fa-trash',
                        'fas fa-save', 'fas fa-download', 'fas fa-upload', 'fas fa-share',
                        'fas fa-print', 'fas fa-image', 'fas fa-video', 'fas fa-music',
                        'fas fa-file', 'fas fa-folder', 'fas fa-link', 'fas fa-external-link-alt',
                        'fas fa-arrow-left', 'fas fa-arrow-right', 'fas fa-arrow-up', 'fas fa-arrow-down',
                        'fas fa-chevron-left', 'fas fa-chevron-right', 'fas fa-chevron-up', 'fas fa-chevron-down',
                        'fas fa-angle-left', 'fas fa-angle-right', 'fas fa-angle-up', 'fas fa-angle-down',
                        'fas fa-info-circle', 'fas fa-question-circle', 'fas fa-exclamation-circle',
                        'fas fa-check-circle', 'fas fa-times-circle', 'fas fa-ban',
                        'fas fa-lock', 'fas fa-unlock', 'fas fa-key', 'fas fa-shield-alt',
                        'fas fa-tag', 'fas fa-tags', 'fas fa-bookmark', 'fas fa-flag',
                        'fas fa-thumbs-up', 'fas fa-thumbs-down', 'fas fa-comment', 'fas fa-comments',
                        'fas fa-share-alt', 'fas fa-retweet', 'fas fa-fire', 'fas fa-bolt',
                        'fas fa-gift', 'fas fa-trophy', 'fas fa-medal', 'fas fa-crown',
                        'fas fa-gem', 'fas fa-coins', 'fas fa-dollar-sign', 'fas fa-euro-sign',
                        'fas fa-pound-sign', 'fas fa-ruble-sign', 'fas fa-shopping-bag', 'fas fa-shopping-basket',
                        'fas fa-store', 'fas fa-box', 'fas fa-truck', 'fas fa-shipping-fast',
                        'fas fa-warehouse', 'fas fa-pallet', 'fas fa-credit-card', 'fas fa-wallet',
                        'fas fa-receipt', 'fas fa-file-invoice', 'fas fa-chart-line', 'fas fa-chart-bar',
                        'fas fa-chart-pie', 'fas fa-chart-area', 'fas fa-users', 'fas fa-user-friends',
                        'fas fa-user-plus', 'fas fa-user-minus', 'fas fa-user-cog', 'fas fa-user-shield',
                        'fas fa-user-tie', 'fas fa-user-md', 'fas fa-building', 'fas fa-industry',
                        'fas fa-briefcase', 'fas fa-handshake', 'fas fa-globe', 'fas fa-language',
                        'fas fa-map', 'fas fa-compass', 'fas fa-road', 'fas fa-car',
                        'fas fa-plane', 'fas fa-train', 'fas fa-bus', 'fas fa-bicycle',
                        'fas fa-walking', 'fas fa-hotel', 'fas fa-utensils', 'fas fa-coffee',
                        'fas fa-wine-glass', 'fas fa-pizza-slice', 'fas fa-hamburger', 'fas fa-ice-cream',
                        'fas fa-apple-alt', 'fas fa-lemon', 'fas fa-pepper-hot', 'fas fa-fish',
                        'fas fa-cheese', 'fas fa-bread-slice', 'fas fa-egg', 'fas fa-seedling',
                        'fas fa-leaf', 'fas fa-tree', 'fas fa-mountain', 'fas fa-water',
                        'fas fa-sun', 'fas fa-moon', 'fas fa-cloud', 'fas fa-snowflake',
                        'fas fa-umbrella', 'fas fa-rainbow', 'fas fa-wind', 'fas fa-gamepad',
                        'fas fa-dice', 'fas fa-chess', 'fas fa-puzzle-piece', 'fas fa-football-ball',
                        'fas fa-basketball-ball', 'fas fa-baseball-ball', 'fas fa-volleyball-ball', 'fas fa-swimming-pool',
                        'fas fa-dumbbell', 'fas fa-running', 'fas fa-biking', 'fas fa-book',
                        'fas fa-book-open', 'fas fa-graduation-cap', 'fas fa-school', 'fas fa-university',
                        'fas fa-chalkboard-teacher', 'fas fa-pencil-alt', 'fas fa-pen', 'fas fa-highlighter',
                        'fas fa-eraser', 'fas fa-paperclip', 'fas fa-sticky-note', 'fas fa-clipboard',
                        'fas fa-clipboard-list', 'fas fa-tasks', 'fas fa-check-square', 'fas fa-list',
                        'fas fa-list-ul', 'fas fa-list-ol', 'fas fa-th-list', 'fas fa-table',
                        'fas fa-columns', 'fas fa-th', 'fas fa-th-large', 'fas fa-desktop',
                        'fas fa-laptop', 'fas fa-tablet-alt', 'fas fa-mobile-alt', 'fas fa-mouse',
                        'fas fa-keyboard', 'fas fa-headphones', 'fas fa-microphone', 'fas fa-camera',
                        'fas fa-camera-retro', 'fas fa-film', 'fas fa-tv', 'fas fa-satellite-dish',
                        'fas fa-satellite', 'fas fa-wifi', 'fas fa-signal', 'fas fa-broadcast-tower',
                        'fas fa-server', 'fas fa-database', 'fas fa-hdd', 'fas fa-memory',
                        'fas fa-microchip', 'fas fa-plug', 'fas fa-battery-full', 'fas fa-power-off',
                        'fas fa-toggle-on', 'fas fa-toggle-off', 'fas fa-lightbulb', 'fas fa-smoking',
                        'fas fa-exclamation-triangle', 'fas fa-radiation', 'fas fa-skull-crossbones', 'fas fa-biohazard',
                        'fas fa-first-aid', 'fas fa-band-aid', 'fas fa-pills', 'fas fa-capsules',
                        'fas fa-syringe', 'fas fa-thermometer', 'fas fa-stethoscope', 'fas fa-heartbeat',
                        'fas fa-lungs', 'fas fa-brain', 'fas fa-tooth', 'fas fa-eye',
                        'fas fa-eye-slash', 'fas fa-glasses', 'fas fa-wheelchair', 'fas fa-crutch',
                        'fas fa-accessible-icon', 'fas fa-baby', 'fas fa-child', 'fas fa-user-graduate',
                        'fas fa-user-nurse', 'fas fa-user-injured', 'fas fa-user-astronaut', 'fas fa-user-secret',
                        'fas fa-user-slash', 'fas fa-user-times', 'fas fa-user-lock', 'fas fa-user-check',
                        'fas fa-user-clock', 'fas fa-user-edit', 'fas fa-user-ninja', 'fas fa-users-cog',
                        'fas fa-user-tag', 'fas fa-user-group', 'fas fa-user-large', 'fas fa-user-pen',
                    ];
                    $customIcons = [
                        'icon-home', 'icon-user', 'icon-cart', 'icon-heart', 'icon-star',
                        'icon-search', 'icon-bell', 'icon-mail', 'icon-phone', 'icon-location',
                        'icon-calendar', 'icon-clock', 'icon-settings', 'icon-menu', 'icon-close',
                        'icon-check', 'icon-plus', 'icon-minus', 'icon-edit', 'icon-delete',
                    ];
                    $allIcons = array_merge($fontAwesomeIcons, $customIcons);
                @endphp
                @foreach($allIcons as $icon)
                    <div class="icon-picker-item" data-icon-class="{{ $icon }}" data-icon-name="{{ str_replace(['fas fa-', 'icon-'], '', $icon) }}"
                         @click="$dispatch('icon-picked', { iconClass: '{{ $icon }}' }); open = false">
                        <i class="{{ $icon }}"></i>
                        <span>{{ str_replace(['fas fa-', 'icon-'], '', $icon) }}</span>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="flex justify-end gap-3 border-t border-gray-200 px-5 py-4">
            <button type="button" @click="open = false" class="btn-secondary">Закрыть</button>
        </div>
    </div>
</div>
