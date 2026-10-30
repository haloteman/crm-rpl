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

window.Alpine = Alpine;
Alpine.start();