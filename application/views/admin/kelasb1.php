<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="row">
                <div class="col">
                    <h6 class="m-0 font-weight-bold text-primary">Tabel <?= $title; ?></h6>
                </div>
                <div class="col text-right">
                    <a class="btn btn-success btn-sm" href="<?= base_url('admin/siswa/cetak/all') ?>"><i class="fas fa-fw fa-print"></i> Cetak</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>NIS</th>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>NIK</th>
                            <th>Kelahiran</th>
                            <th>Jenis Kelamin</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($siswa as $s) : ?>
                            <tr>
                                <td><?= $s['nis']; ?></td>
                                <td><?= $s['nama_siswa']; ?></td>
                                <td><?= $s['alamat']; ?></td>
                                <td><?= $s['nik']; ?></td>
                                <td><?= $s['tempat_lahir']; ?>, <?= date('d F Y', strtotime($s['tgl_lahir'])); ?></td>
                                <td><?= $s['jenis_kelamin']; ?></td>
                                <td>
                                    <a href="<?= base_url('admin/siswa/' . $s['id_siswa']); ?>" class="btn btn-success"><i class="fas fa-fw fa-edit"></i></a>
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