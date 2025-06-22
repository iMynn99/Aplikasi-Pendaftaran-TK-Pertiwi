<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="m-4">
        <div class="p-4">
            <div class="p-2">

                <div class="row ml-4">
                    <div class="col-md-6">
                        <div class="">
                            <img src="<?= base_url('assets/img/profile/') . $user['image']; ?>" class="rounded"
                                width="320" alt="...">
                        </div>
                    </div>
                    <div class="col-md-5">
                        <table class="table table-borderless">
                            <tbody>
                                <tr>
                                    <th scope="row">Nama</th>
                                    <td><?= $user['nama']; ?></td>
                                </tr>
                                <tr>
                                    <th scope="row">Nomor Induk Siswa</th>
                                    <td><?= $siswa['nis']; ?></td>
                                </tr>
                                <tr>
                                    <th scope="row">Kelas</th>
                                    <td><?= $siswa['nama_kelas']; ?></td>
                                </tr>
                                <tr>
                                    <th scope="row">NIK</th>
                                    <td><?= $siswa['nik']; ?></td>
                                </tr>
                                <tr>
                                    <th scope="row">Email</th>
                                    <td><?= $user['email']; ?></td>
                                </tr>
                                <tr>
                                    <th scope="row">Alamat</th>
                                    <td><?= $siswa['alamat']; ?></td>
                                </tr>
                                <tr>
                                    <th scope="row">Tempat Lahir</th>
                                    <td><?= $siswa['tempat_lahir']; ?></td>
                                </tr>
                                <tr>
                                    <th scope="row">Tanggal Lahir</th>
                                    <td><?= date('d F Y', strtotime($siswa['tgl_lahir'])); ?></td>
                                </tr>
                                <tr>
                                    <th scope="row">Usia</th>
                                    <td><?= $siswa['usia']; ?> Tahun</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="row ml-4">
                    <div class="col-md-4">

                        <a href="<?= base_url('user/ortu'); ?>" class="btn btn-primary">Data Orang Tua</a>
                    </div>
                </div>



            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->