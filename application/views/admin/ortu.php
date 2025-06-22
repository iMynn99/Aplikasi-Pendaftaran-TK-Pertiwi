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
                    <a class="btn btn-primary btn-sm" href="<?= base_url('admin/tambahortu') ?>">Tambah Orang Tua</a>
                </div>
                <div class="col text-right">
                    <a class="btn btn-success btn-sm" href="<?= base_url('admin/ortu/cetak/all') ?>"><i
                            class="fas fa-fw fa-print"></i> Cetak</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Nama User</th>
                            <th>Nama Ayah</th>
                            <th>NIK Ayah</th>
                            <th>Kelahiran Ayah</th>
                            <th>Pendidikan Ayah</th>
                            <th>Pekerjaan Ayah</th>
                            <th>Nama Ibu</th>
                            <th>NIK Ibu</th>
                            <th>Kelahiran Ibu</th>
                            <th>Pendidikan Ibu</th>
                            <th>Pekerjaan Ibu</th>
                            <th>Nomor Telepon</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($ortu as $o) : ?>
                        <tr>
                            <td><?= $o['nama_siswa']; ?></td>
                            <td><?= $o['nama_ayah']; ?></td>
                            <td><?= $o['nik_ayah']; ?></td>
                            <td><?= date('d F Y', strtotime($o['lahir_ayah'])); ?></td>
                            <td><?= $o['pend_ayah']; ?></td>
                            <td><?= $o['kerja_ayah']; ?></td>
                            <td><?= $o['nama_ibu']; ?></td>
                            <td><?= $o['nik_ibu']; ?></td>
                            <td><?= date('d F Y', strtotime($o['lahir_ibu'])); ?></td>
                            <td><?= $o['pend_ibu']; ?></td>
                            <td><?= $o['kerja_ibu']; ?></td>
                            <td><?= $o['no_telepon']; ?></td>
                            <td>
                                <a href="<?= base_url('admin/ortu/' . $o['id_ortu']); ?>" class="btn btn-success"><i
                                        class="fas fa-fw fa-edit"></i></a><br><br>
                                <a href="<?= base_url('admin/hapusortu/' . $o['id_ortu']); ?>" class="btn btn-danger"
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