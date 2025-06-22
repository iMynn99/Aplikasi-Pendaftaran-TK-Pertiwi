<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>


    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Siswa <?= str_replace('Data Siswa ', '', $title); ?>
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>NIS</th>
                            <th>Nama Siswa</th>
                            <th>Jenis Kelamin</th>
                            <th>Alamat</th>
                            <th>Kelas</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($siswa_kelas)) : ?>
                        <?php $i = 1; ?>
                        <?php foreach ($siswa_kelas as $siswa) : ?>
                        <tr>
                            <td><?= $i++; ?></td>
                            <td><?= $siswa['nis']; ?></td>
                            <td><?= $siswa['nama_siswa']; ?></td>
                            <td><?= ($siswa['jenis_kelamin'] == 'L') ? 'Laki-laki' : 'Perempuan'; ?></td>
                            <td><?= $siswa['alamat']; ?></td>
                            <td><?= $siswa['nama_kelas']; ?></td>
                        </tr>
                        <?php endforeach; ?>
                        <?php else : ?>
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada data siswa untuk kelas ini.</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>