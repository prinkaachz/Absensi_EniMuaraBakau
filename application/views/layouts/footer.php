        </section>
    </main>
</div>
<?php
if (!$this->session->userdata('logout_token')) {
    $this->session->set_userdata('logout_token', bin2hex(random_bytes(32)));
}
?>
<dialog id="logoutDialog" class="logout-dialog" aria-labelledby="logoutTitle">
    <h2 id="logoutTitle">Keluar dari akun?</h2>
    <p>Anda yakin ingin keluar? Anda perlu masuk kembali untuk mengakses aktivitas.</p>
    <?= form_open('logout') ?>
        <input type="hidden" name="logout_token" value="<?= html_escape($this->session->userdata('logout_token')) ?>">
        <div class="decision-actions">
            <button class="btn btn-light" type="button" data-cancel-logout autofocus>Batal</button>
            <button class="btn btn-danger" type="submit">Ya, keluar</button>
        </div>
    <?= form_close() ?>
</dialog>
<script src="<?= base_url('assets/js/app.js') ?>?v=20260917d"></script>
</body>
</html>
