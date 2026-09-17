document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-status-picker]').forEach(picker => {
        const summary = picker.querySelector('summary');
        picker.addEventListener('change', event => {
            if (event.target.name !== 'status') return;
            picker.querySelector('[data-status-label]').textContent = event.target.value || 'Semua status';
            picker.open = false;
            summary.focus();
        });
        picker.addEventListener('keydown', event => {
            if (event.key === 'Escape') { picker.open = false; summary.focus(); }
        });
        document.addEventListener('click', event => {
            if (!picker.contains(event.target)) picker.open = false;
        });
    });
    const logoutDialog = document.querySelector('#logoutDialog');
    document.querySelectorAll('[data-logout]').forEach(link => {
        link.addEventListener('click', event => {
            if (logoutDialog && typeof logoutDialog.showModal === 'function') {
                event.preventDefault();
                logoutDialog.showModal();
            }
        });
    });
    document.querySelector('[data-cancel-logout]')?.addEventListener('click', () => logoutDialog.close());
    const clickable = 'button, .btn, .nav-link, .sidebar-bottom a, .notification-button, .page-button';
    const press = event => {
        const target = event.target.closest(clickable);
        if (!target || target.disabled) return;
        target.classList.add('is-pressed');
        setTimeout(() => target.classList.remove('is-pressed'), 220);
    };
    document.addEventListener('pointerdown', press);
    document.addEventListener('keydown', event => {
        if (event.key === 'Enter' || event.key === ' ') press(event);
    });
    const types = {'On Duty':['Operasional Lapangan','Administrasi','Rapat / Koordinasi','Training'],'Off Duty':['Istirahat','Sakit','Pemulihan Pasca Operasi'],'Perjalanan Dinas':['Site Visit','Meeting Proyek','Pelatihan'],'Cuti':['Cuti Tahunan','Cuti Sakit','Cuti Khusus']};
    const modal = document.querySelector('#activityModal');
    const form = document.querySelector('[data-activity-form]');
    const substatus = document.querySelector('[data-sub-status]');
    const setSubstatus = (type, selected = '') => { if (substatus) substatus.innerHTML = '<option value="">Pilih sub kategori</option>' + (types[type] || []).map(item => `<option ${item === selected ? 'selected' : ''}>${item}</option>`).join(''); };
    const closeModal = () => modal?.classList.remove('open');
    document.querySelector('[data-open-modal]')?.addEventListener('click', () => { form.reset(); form.querySelector('[name=id]').value = ''; document.querySelector('[data-modal-title]').textContent = 'Tambah Aktivitas'; substatus.innerHTML = '<option value="">Pilih jenis terlebih dahulu</option>'; modal.classList.add('open'); });
    document.querySelectorAll('[data-close-modal]').forEach(button => button.addEventListener('click', closeModal));
    modal?.addEventListener('click', event => { if (event.target === modal) closeModal(); });
    document.querySelectorAll('[name=jenis]').forEach(radio => radio.addEventListener('change', event => setSubstatus(event.target.value)));
    document.querySelectorAll('[data-edit-activity]').forEach(button => button.addEventListener('click', () => { const item = JSON.parse(button.closest('tr').dataset.activity); form.querySelector('[name=id]').value = item.id; form.querySelector('[name=tanggal]').value = item.tanggal; form.querySelector('[name=kegiatan]').value = item.kegiatan; form.querySelector(`[name=jenis][value="${item.jenis}"]`).checked = true; setSubstatus(item.jenis, item.sub_status); document.querySelector('[data-modal-title]').textContent = 'Ubah Data'; modal.classList.add('open'); }));
    form?.addEventListener('submit', event => { const activity = form.querySelector('[name=kegiatan]'); if (activity.value.trim().length < 5) { event.preventDefault(); activity.setCustomValidity('Kegiatan minimal harus terdiri dari 5 karakter.'); activity.reportValidity(); activity.addEventListener('input', () => activity.setCustomValidity(''), {once:true}); } });
    document.querySelectorAll('[data-toast]').forEach(toast => setTimeout(() => { toast.style.opacity = 0; setTimeout(() => toast.remove(), 250); }, 4200));
    document.querySelector('[data-toggle-sidebar]')?.addEventListener('click', () => document.body.classList.toggle('sidebar-collapsed'));
    document.querySelectorAll('[data-table]').forEach(table => {
        const panel = table.closest('.panel');
        const footer = panel?.querySelector('[data-pagination]');
        if (!footer) return;
        const selector = panel.querySelector('[data-page-size]');
        const rows = Array.from(table.tBodies[0].rows);
        let page = 1;
        const draw = () => {
            const size = Number(selector?.value || 10);
            const pages = Math.max(1, Math.ceil(rows.length / size));
            page = Math.min(page, pages);
            const start = (page - 1) * size;
            rows.forEach((row, index) => {
                row.hidden = index < start || index >= start + size;
            });
            footer.replaceChildren();
            const summary = document.createElement('span');
            summary.className = 'pagination-summary';
            summary.textContent = rows.length
                ? 'Menampilkan ' + (start + 1) + '–' + Math.min(start + size, rows.length) + ' dari ' + rows.length + ' data'
                : 'Belum ada data';
            footer.append(summary);
            if (pages === 1) return;
            const button = (label, target, disabled, current = false) => {
                const node = document.createElement('button');
                node.type = 'button';
                node.className = 'page-button' + (current ? ' active' : '');
                node.textContent = label;
                node.disabled = disabled;
                if (current) node.setAttribute('aria-current', 'page');
                node.addEventListener('click', () => { page = target; draw(); });
                footer.append(node);
            };
            button('‹ Sebelumnya', page - 1, page === 1);
            for (let i = Math.max(1, page - 2); i <= Math.min(pages, page + 2); i++) {
                button(String(i), i, false, i === page);
            }
            button('Berikutnya ›', page + 1, page === pages);
        };
        selector?.addEventListener('change', () => { page = 1; draw(); });
        draw();
    });
});
