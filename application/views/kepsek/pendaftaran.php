<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <?= $this->session->flashdata('message'); ?>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Siswa Menunggu Konfirmasi</h6>
        </div>
        <div class="card-body">
            <?php if (empty($siswa_pending)) : ?>
            <div class="alert alert-info" role="alert">
                Tidak ada pendaftaran siswa yang menunggu konfirmasi saat ini.
            </div>
            <?php else : ?>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>NIS</th>
                            <th>Nama Siswa</th>
                            <th>Email</th>
                            <th>Kelas Diajukan</th>
                            <th>Tanggal Daftar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($siswa_pending as $siswa) : ?>
                        <tr>
                            <td><?= $i++; ?></td>
                            <td><?= $siswa['nis']; ?></td>
                            <td><?= $siswa['nama_siswa']; ?></td>
                            <td><?= $siswa['email']; ?></td>
                            <td><?= $siswa['nama_kelas']; ?></td>
                            <td><?= date('d M Y', strtotime($siswa['created_at'])); ?></td>
                            <td>
                                <form action="<?= base_url('kepsek/konfirmasipendaftaran'); ?>" method="post"
                                    class="d-inline">
                                    <input type="hidden" name="id_siswa" value="<?= $siswa['id_siswa']; ?>">
                                    <div class="form-group mb-2">
                                        <label for="id_kelas_<?= $siswa['id_siswa']; ?>">Pilih Kelas:</label>
                                        <select name="id_kelas_baru" id="id_kelas_<?= $siswa['id_siswa']; ?>"
                                            class="form-control form-control-sm" required>
                                            <?php foreach ($kelas as $k) : ?>
                                            <option value="<?= $k['id_kelas']; ?>"
                                                <?= ($k['id_kelas'] == $siswa['id_kelas']) ? 'selected' : ''; ?>>
                                                <?= $k['nama_kelas']; ?>
                                            </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <button type="submit" name="action" value="approve"
                                        class="btn btn-success btn-sm">Setujui</button>
                                    <button type="submit" name="action" value="reject" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Apakah Anda yakin ingin menolak pendaftaran ini?');">Tolak</button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php endif; ?>
        </div>
    </div>

</div>