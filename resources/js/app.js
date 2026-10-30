import Alpine from 'alpinejs';
import {
    createIcons, Mountain, ShoppingBag, Menu, X, ChevronDown, ArrowUpRight, MapPin, CalendarDays,
    Tent, Backpack, BedDouble, BedSingle, CookingPot, Lamp, Flame, Search, Wallet, PackageCheck,
    Camera, MessageCircle, Mail, TriangleAlert, Compass, User,
} from 'lucide';

window.Alpine = Alpine;

/**
 * Komponen pengecekan ketersediaan.
 * Tahap backend: ganti submit GET ke /katalog dengan fetch ke endpoint stok/alokasi unit.
 */
Alpine.data('availability', (initial = {}) => ({
    mulai: initial.mulai ?? '',
    selesai: initial.selesai ?? '',
    today: new Date(Date.now() - new Date().getTimezoneOffset() * 60000).toISOString().slice(0, 10),
    error: '',

    get hari() {
        if (!this.mulai || !this.selesai) return 0;
        const d = (new Date(this.selesai) - new Date(this.mulai)) / 86400000;
        return d >= 0 ? d + 1 : 0; // tanggal mulai & selesai sama = 1 hari
    },
    get ringkasan() {
        if (!this.hari) return 'Pilih tanggal mulai dan selesai untuk melihat lama sewa.';
        const f = (s) => new Date(s + 'T00:00:00').toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
        return `${f(this.mulai)} sampai ${f(this.selesai)} · ${this.hari} hari sewa`;
    },
    validate() {
        this.error = '';
        if (!this.mulai || !this.selesai) this.error = 'Tanggal mulai dan selesai wajib diisi.';
        else if (this.mulai < this.today) this.error = 'Tanggal mulai tidak boleh sudah berlalu.';
        else if (this.selesai < this.mulai) this.error = 'Tanggal selesai tidak boleh lebih awal dari tanggal mulai.';
        return !this.error;
    },
    submit(e) { if (this.validate()) e.target.submit(); },
    syncEnd() { if (this.selesai && this.selesai < this.mulai) this.selesai = this.mulai; },
}));

Alpine.start();

createIcons({
    icons: {
        Mountain, ShoppingBag, Menu, X, ChevronDown, ArrowUpRight, MapPin, CalendarDays, Tent, Backpack,
        BedDouble, BedSingle, CookingPot, Lamp, Flame, Search, Wallet, PackageCheck, Camera, MessageCircle,
        Mail, TriangleAlert, Compass, User,
    },
});
