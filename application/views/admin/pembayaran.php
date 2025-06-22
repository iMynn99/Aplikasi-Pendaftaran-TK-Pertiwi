<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Tabel <?= $title; ?></h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID User</th>
                            <th>ID Pembayaran</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Tanggal Bayar</th>
                            <th>Bukti Bayar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($bayar as $b) : ?>
                            <tr>
                                <td><?= $b['id_login']; ?></td>
                                <td><?= $b['id_pembayaran']; ?></td>
                                <td><?= $b['nama_siswa']; ?></td>
                                <td><?= $b['email']; ?></td>
                                <td>
                                    <?php if ($b['status'] == 'sudah') : ?>
                                        <span class="badge badge-success">Di Bayar</span>
                                    <?php elseif ($b['status'] == 'menunggu') : ?>
                                        <span class="badge badge-warning">Menunggu</span>
                                    <?php else : ?>
                                        <span class="badge badge-danger">Belum Bayar</span>
                                    <?php endif; ?>
                                <td>
                                    <?php if ($b['tgl_bayar'] == null) : ?>
                                        <span class="badge badge-warning">Belum Bayar</span>
                                    <?php else : ?>
                                        <?= date('h:m:s d F Y', strtotime($b['tgl_bayar'])); ?>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($b['metode'] == 'auto'): ?>
                                        <span class="badge badge-secondary">Bayar Otomatis</span>
                                    <?php elseif ($b['metode'] == 'manual'): ?>
                                        <a class="badge badge-primary" href="<?= base_url('assets/img/bukti/' . $b['bukti']) ?>" target="_blank">Lihat Bukti</a>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($b['status'] == 'menunggu'): ?>
                                        <a class="badge badge-success" href="<?= base_url('admin/pembayaran/acc/' . $b['id_pembayaran']) ?>" target="_self">Acc</a>
                                        <a class="badge badge-danger" href="<?= base_url('admin/pembayaran/tolak/' . $b['id_pembayaran']) ?>" target="_self">Tolak</a>
                                    <?php else: ?>
                                        <span class="badge badge-secondary">-</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->