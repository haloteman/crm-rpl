import './bootstrap';

import Alpine from 'alpinejs';


window.copyText = async (text) => {
    try {
        await navigator.clipboard.writeText(text);
    } catch (e) {
        const t = document.createElement('textarea');
        t.value = text;
        document.body.appendChild(t);
        t.select();
        document.execCommand('copy');
        t.remove();
    }
};

Alpine.data('userPage', (cfg) => ({
    modal: null,          // 'add' | 'created' | 'reset' | 'delete' | null
    target: null,         // akun yang sedang dikelola {id, name, nip}
    form: { name: '', role_id: cfg.defaultRole },
    errors: {},
    busy: false,
    creds: { nip: '', password: '', title: '' },
    copied: '',
    timer: null,

    open(name, target = null) {
        this.target = target;
        this.errors = {};
        this.modal = name;
    },
    close() { this.modal = null; },

    async request(url, method, body) {
        this.busy = true;
        this.errors = {};
        try {
            const res = await fetch(url, {
                method,
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                },
                body: body ? JSON.stringify(body) : undefined,
            });
            const data = await res.json().catch(() => ({}));
            if (res.status === 422 && data.errors) {
                this.errors = Object.fromEntries(Object.entries(data.errors).map(([k, v]) => [k, v[0]]));
                return null;
            }
            if (!res.ok) {
                this.errors = { general: data.message || 'Terjadi kesalahan, coba lagi.' };
                return null;
            }
            return data;
        } catch (e) {
            this.errors = { general: 'Tidak bisa terhubung ke server.' };
            return null;
        } finally {
            this.busy = false;
        }
    },

    async submitAdd() {
        const data = await this.request(cfg.storeUrl, 'POST', this.form);
        if (!data) return;
        this.creds = { nip: data.nip, password: data.password, title: 'Akun Berhasil Dibuat' };
        this.modal = 'created';
    },
    async submitReset() {
        const data = await this.request(`${cfg.baseUrl}/${this.target.id}/reset-password`, 'POST');
        if (!data) return;
        this.creds = { nip: data.nip, password: data.password, title: 'Password Berhasil Direset' };
        this.modal = 'created';
    },
    async submitDelete() {
        const data = await this.request(`${cfg.baseUrl}/${this.target.id}`, 'DELETE');
        if (!data) return;
        window.location.reload();
    },
    done() { window.location.reload(); },

    async copy(key, text) {
        await window.copyText(text);
        this.copied = key;
        clearTimeout(this.timer);
        this.timer = setTimeout(() => (this.copied = ''), 1500);
    },
}));

window.Alpine = Alpine;
Alpine.start();