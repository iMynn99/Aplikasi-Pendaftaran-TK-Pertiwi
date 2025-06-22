<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <?php if ($this->session->flashdata('message')) : ?> <div class="row mt-3">
        <div class="col-md-12">
            <?= $this->session->flashdata('message'); ?>
        </div>
    </div>
    <?php endif; ?>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="row">
                <div class="col">
                    <a class="btn btn-primary btn-sm" href="<?= base_url('admin/tambahsiswa') ?>">Tambah Siswa</a>
                </div>
                <div class="col text-right">
                    <a class="btn btn-success btn-sm" href="<?= base_url('admin/siswa/cetak/all') ?>"><i
                            class="fas fa-fw fa-print"></i> Cetak</a>
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
                            <th>Kelas</th>
                            <th>Alamat</th>
                            <th>NIK</th>
                            <th>Kelahiran</th>
                            <th>Jenis Kelamin</th>
                            <th>Tanggal Daftar</th>
                            <th>Email</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($siswa as $s) : ?>
                        <tr>
                            <td><?= $s['nis']; ?></td>
                            <td><?= $s['nama_siswa']; ?></td>
                            <td><?= ($s['status_pendaftaran'] == 'approved') ? $s['nama_kelas'] : 'Belum Ditentukan'; ?>
                            </td>
                            <td><?= $s['alamat']; ?></td>
                            <td><?= $s['nik']; ?></td>
                            <td><?= $s['tempat_lahir']; ?>, <?= date('d F Y', strtotime($s['tgl_lahir'])); ?></td>
                            <td><?= $s['jenis_kelamin']; ?></td>
                            <td><?= date('d F Y', strtotime($s['created_at'])); ?></td>
                            <td><?= $s['email']; ?></td>
                            <td>
                                <a href="<?= base_url('admin/siswa/' . $s['id_siswa']); ?>" class="btn btn-success"><i
                                        class="fas fa-fw fa-edit"></i></a>
                                <a href="<?= base_url('admin/hapussiswa/' . $s['id_siswa']); ?>" class="btn btn-danger"
                                    onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');"><i
                                        class="fas fa-fw fa-trash"></i></a>
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