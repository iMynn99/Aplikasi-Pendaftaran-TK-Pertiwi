<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Formulir Data Diri Calon Siswa</h6>
        </div>
        <div class="card-body mb-2">

            <div class="card-body">
                <form method="post" action="<?php echo base_url('user/data/form/update'); ?>" enctype="multipart/form-data">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-floating mb-3 mb-md-0">
                                <label for="nama">Nama</label>
                                <input class="form-control" id="nama" name="nama" type="text" placeholder="Nama" required value="<?= isset($siswa['nama_siswa']) ? $siswa['nama_siswa'] : ''; ?>" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <label for="nik">NIK</label>
                                <input class="form-control" id="nik" name="nik" type="number" placeholder="NIK" required value="<?= isset($siswa['nik']) ? $siswa['nik'] : ''; ?>" />
                            </div>
                        </div>
                    </div>
                    <div class="form-floating mb-3">
                        <label for="email">Email</label>
                        <input class="form-control" id="email" name="email" type="email" placeholder="nama@contoh.com" required value="<?= isset($user['email']) ? $user['email'] : ''; ?>" />
                    </div>

                    <div class="form-floating mb-3">
                        <label for="alamat">Alamat</label>
                        <textarea class="form-control" name="alamat" id="alamat" rows="2"><?= isset($siswa['alamat']) ? $siswa['alamat'] : ''; ?></textarea>
                    </div>

                    <div class="row mb-3">
                        <div class="col md-6">
                            <div class="form-floating mb-6">
                                <label for="tempat_lahir">Tempat Lahir</label>
                                <input class="form-control" id="tempat_lahir" name="tempat_lahir" type="text" placeholder="Tempat Lahir" required value="<?= isset($siswa['tempat_lahir']) ? $siswa['tempat_lahir'] : ''; ?>" />
                            </div>
                        </div>
                        <div class="col md-6">
                            <div class="form-floating mb-6">
                                <label for="tgl_lahir">Tanggal Lahir</label>
                                <input class="form-control" id="tgl_lahir" name="tgl_lahir" type="date" placeholder="Tanggal Lahir" required value="<?= isset($siswa['tgl_lahir']) ? $siswa['tgl_lahir'] : ''; ?>" />
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col md-6">
                            <div class="form-floating mb-6">
                                <label for="usia">Usia</label>
                                <input class="form-control" id="usia" name="usia" type="number" placeholder="Usia" required value="<?= isset($siswa['usia']) ? $siswa['usia'] : ''; ?>" />
                            </div>
                        </div>
                        <div class="col md-6">
                            <div class="form-floating mb-6">
                                <label for="anak_ke">Anak Ke</label>
                                <input class="form-control" id="anak_ke" name="anak_ke" type="number" placeholder="Anak Ke" required value="<?= isset($siswa['anak_ke']) ? $siswa['anak_ke'] : ''; ?>" />
                            </div>
                        </div>
                    </div>

                    <div class="form-floating mb-3">
                        <label for="jenis_kelamin">Jenis Kelamin</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="kelamin" id="kelamin1" value="L" <?= isset($siswa['jenis_kelamin']) && $siswa['jenis_kelamin'] == 'L' ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="kelamin1">
                                Laki-laki
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="kelamin" id="kelamin2" value="P" <?= isset($siswa['jenis_kelamin']) && $siswa['jenis_kelamin'] == 'P' ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="kelamin2">
                                Perempuan
                            </label>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col md-6">
                            <div class="form-floating mb-6">
                                <label for="agama">Agama</label>
                                <input class="form-control" id="agama" name="agama" type="text" placeholder="Agama" required value="<?= isset($siswa['agama']) ? $siswa['agama'] : ''; ?>" />
                            </div>
                        </div>
                        <div class="col md-6">
                            <div class="form-floating mb-6">
                                <label for="kewarganegaraan">Kewarganegaraan</label>
                                <input class="form-control" id="kewarganegaraan" name="kewarganegaraan" type="text" placeholder="Kewarganegaraan" required value="<?= isset($siswa['kewarganegaraan']) ? $siswa['kewarganegaraan'] : ''; ?>" />
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="form-floating mb-6">
                            <label for="image">Foto</label>
                            <input type="file" name="image" class="form-control" required>
                        </div>
                    </div>

                    <div class="mt-4 mb-0">
                        <div class="d-grid"><button class="btn btn-primary" type="submit">Simpan</button></div>
                    </div>
                </form>
            </div>

        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->