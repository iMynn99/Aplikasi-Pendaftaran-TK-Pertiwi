<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="row">
        <div class="col-md-5">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Tagihan</h6>
                </div>
                <div class="card-body">
                    <?php if ($this->session->flashdata('message')): ?>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <?= $this->session->flashdata('message'); ?>
                        </div>
                    </div>
                    <?php endif; ?>
                    <?php if (empty($tagihan)): ?>
                    <div class="alert alert-info text-center" role="alert">
                        Tidak ada tagihan yang ditemukan untuk Anda saat ini.
                    </div>
                    <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-borderless">
                            <thead>
                                <tr>
                                    <th>ID Pembayaran</th>
                                    <th>Nominal</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><?= $tagihan['id_pembayaran']; ?></td>
                                    <td><?= number_format($tagihan['nominal'], 0, ',', '.'); ?></td>
                                    <td>
                                        <?php if ($tagihan['status'] == 'sudah'): ?>
                                        Lunas
                                        <?php elseif ($tagihan['status'] == 'menunggu'): ?>
                                        Menunggu
                                        <?php else: ?>
                                        Belum Bayar
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <?php if (!$tagihan['bukti']): ?>
                    <div class="text-center">
                        <?php if (!empty($snapToken) && $tagihan['status'] != 'sudah'): ?>
                        <button id="pay-button" class="btn btn-primary btn-block">
                            <i class="fa fa-credit-card"></i>
                            Bayar
                        </button>
                        <?php elseif ($tagihan['status'] == 'sudah'): ?>
                        <button class="btn btn-primary btn-block" disabled>
                            <i class="fa fa-credit-card"></i>
                            Sudah Dibayar
                        </button>
                        <?php endif; ?>
                        <a href="<?= base_url('user/pembayaran/manual') ?>" class="btn btn-warning btn-block"
                            <?= $tagihan['status'] == 'sudah' ? 'disabled' : ''; ?>>
                            <i class="fa fa-credit-card"></i>
                            Bayar Manual
                        </a>
                    </div>
                    <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="col-md-1"></div>
        <div class="col-md-5">
            <?php if (!empty($tagihan)): ?>
            <div id="snap-container" style="width: 100%;" class="pb-4 mb-4"></div>
            <?php endif; ?>
        </div>
    </div>

    <?php if (!empty($tagihan) && $tagihan['status'] == 'sudah') : ?>
    <div class="row mt-4">
        <div class="col-md-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Cetak Dokumen</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-borderless">
                            <thead>
                                <tr>
                                    <th>Nama Dokumen</th>
                                    <th>Link</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Formulir</td>
                                    <td><a href="<?= base_url('user/cetakData'); ?>" target="_blank"
                                            class="btn btn-primary">Cetak</a></td>
                                </tr>
                                <tr>
                                    <td>Bukti Pembayaran</td>
                                    <td><a href="<?= base_url('user/cetakBukti'); ?>" target="_blank"
                                            class="btn btn-primary">Cetak</a></td>
                                </tr>
                                <tr>
                                    <td>Kartu Pelajar</td>
                                    <td><?php
                                        if (!empty($siswa) && isset($siswa['status_pendaftaran']) && $siswa['status_pendaftaran'] == 'approved') :
                                        ?>
                                        <a href="<?= base_url('user/cetakKartu'); ?>" target="_blank"
                                            class="btn btn-primary">Cetak</a>
                                        <?php else : ?>
                                        <button class="btn btn-secondary" disabled
                                            title="Pendaftaran belum disetujui">Kartu Tidak Bisa Dicetak</button>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

</div>
</div>
<?php if (!empty($tagihan) && !empty($snapToken)): ?>
<script type="text/javascript">
// For example trigger on button clicked, or any time you need
var payButton = document.getElementById("pay-button");
if (payButton) { // Pastikan tombol ada sebelum menambahkan event listener
    payButton.addEventListener("click", function() {
        window.snap.embed("<?= $snapToken; ?>", {
            embedId: "snap-container",
            onSuccess: function(result) {
                location.reload();
                console.log(result);
            },
            onPending: function(result) {
                console.log(result);
            },
            onError: function(result) {
                console.log(result);
            },
            onClose: function() {}
        });
    });
}
</script>
<?php endif; ?>