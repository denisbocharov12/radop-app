/* ============================================================
   Radop — Admin panel runtime (Alpine.js + Lucide + Axios)
   Loaded only on modern (Tailwind) admin pages via @vite.
   ============================================================ */
import Alpine from 'alpinejs';
import collapse from '@alpinejs/collapse';
import axios from 'axios';
import { createIcons, icons } from 'lucide';

Alpine.plugin(collapse);
window.Alpine = Alpine;

/* ---- Axios defaults (CSRF) ---- */
window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
const csrf = document.head.querySelector('meta[name="csrf-token"]');
if (csrf) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = csrf.content;
}

/* ---- Lucide icons (re-callable for dynamically injected markup) ---- */
function renderIcons() {
    try { createIcons({ icons }); } catch (e) { /* noop */ }
}
window.renderIcons = renderIcons;

/* ---- Global stores ---- */
Alpine.store('sidebar', {
    open: localStorage.getItem('sidebarOpen') !== 'false',
    mobileOpen: false,
    toggle() {
        this.open = !this.open;
        localStorage.setItem('sidebarOpen', this.open);
    },
    toggleMobile() { this.mobileOpen = !this.mobileOpen; },
    closeMobile() { this.mobileOpen = false; },
});

Alpine.store('toast', {
    items: [],
    add(message, type = 'success', duration = 4000) {
        const id = Date.now() + Math.random();
        this.items.push({ id, message, type });
        setTimeout(() => this.remove(id), duration);
    },
    remove(id) { this.items = this.items.filter((t) => t.id !== id); },
});

/* ---- Reusable data components ---- */
// `floating: true` positions the menu with fixed coords anchored to the
// trigger, so it escapes ancestor overflow clipping (e.g. a short data-table
// card with overflow-hidden). Plain `dropdown` keeps absolute positioning.
Alpine.data('dropdown', (opts = {}) => ({
    open: false,
    floating: opts.floating || false,
    toggle() { this.open ? this.close() : this.show(); },
    show() {
        this.open = true;
        if (this.floating) this.$nextTick(() => this.place());
    },
    close() { this.open = false; },
    place() {
        const t = this.$refs.trigger, m = this.$refs.menu;
        if (!t || !m) return;
        m.style.position = 'fixed';
        m.style.margin = '0';
        m.style.right = 'auto';
        const r = t.getBoundingClientRect();
        let left = r.right - m.offsetWidth;       // align right edges
        let top = r.bottom + 4;
        if (top + m.offsetHeight > window.innerHeight - 8) {
            top = Math.max(8, r.top - m.offsetHeight - 4); // flip up
        }
        if (left < 8) left = 8;
        m.style.left = left + 'px';
        m.style.top = top + 'px';
    },
}));

// Global delete-confirmation modal. Triggered via
// $dispatch('open-delete', { url, name }) from <x-table-actions>.
Alpine.data('confirmDelete', () => ({
    show: false,
    url: '',
    name: '',
    loading: false,
    open(url, name = '') {
        this.url = url;
        this.name = name;
        this.show = true;
    },
    close() {
        this.show = false;
        this.url = '';
        this.name = '';
        this.loading = false;
    },
    async confirm() {
        if (!this.url) return;
        this.loading = true;
        try {
            await axios.delete(this.url);
            Alpine.store('toast').add('Успешно удалено', 'success');
            setTimeout(() => window.location.reload(), 500);
        } catch (e) {
            Alpine.store('toast').add(
                e?.response?.data?.message || 'Ошибка при удалении',
                'error'
            );
            this.loading = false;
            this.close();
        }
    },
}));

// Command palette — global search over nav (opened with Ctrl/Cmd+K)
Alpine.data('commandPalette', () => ({
    open: false,
    q: '',
    active: 0,
    items: window.__navItems || [],
    get results() {
        const s = this.q.trim().toLowerCase();
        if (!s) return this.items;
        return this.items.filter((i) => (i.label + ' ' + (i.group || '')).toLowerCase().includes(s));
    },
    toggle() {
        this.open = !this.open;
        if (this.open) {
            this.q = '';
            this.active = 0;
            this.$nextTick(() => { if (this.$refs.input) this.$refs.input.focus(); renderIcons(); });
        }
    },
    close() { this.open = false; },
    move(d) {
        const n = this.results.length;
        if (!n) return;
        this.active = (this.active + d + n) % n;
    },
    go() {
        const r = this.results[this.active];
        if (r) window.location.href = r.url;
    },
}));

/* ---- Boot ---- */
document.addEventListener('alpine:initialized', renderIcons);
document.addEventListener('DOMContentLoaded', renderIcons);

// Global keyboard shortcuts: Ctrl/Cmd+K = search, Ctrl/Cmd+B = toggle sidebar
document.addEventListener('keydown', (e) => {
    if (!(e.ctrlKey || e.metaKey)) return;
    const k = e.key.toLowerCase();
    if (k === 'k') {
        e.preventDefault();
        window.dispatchEvent(new CustomEvent('command-palette-toggle'));
    } else if (k === 'b') {
        e.preventDefault();
        Alpine.store('sidebar').toggle();
    }
});

Alpine.start();
