<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Tambah Siswa</h6>
        </div>
        <div class="card-body mb-2">

            <div class="card-body">
                <form method="post" action="<?php echo base_url('admin/simpansiswa') ?>" enctype="multipart/form-data">
                    <div class="form-floating mb-3">
                        <label for="nis">Nomor Induk Siswa <span style="color: red;">*</span></label>
                        <input class="form-control" id="nis" name="nis" name="nis" />
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-floating mb-3 mb-md-0">
                                <label for="nama">Nama <span style="color: red;">*</span></label>
                                <input class="form-control" id="nama" name="nama" type="text" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <label for="nik">NIK <span style="color: red;">*</span></label>
                                <input class="form-control" id="nik" name="nik" type="number" />
                            </div>
                        </div>
                    </div>
                    <div class="form-floating mb-3">
                        <label for="email">Email <span style="color: red;">*</span></label>
                        <input class="form-control" id="email" name="email" name="email" type="email"
                            placeholder="nama@contoh.com" />
                    </div>

                    <div class="form-floating mb-3">
                        <label for="alamat">Alamat <span style="color: red;">*</span></label>
                        <textarea class="form-control" name="alamat" id="alamat" rows="2"></textarea>
                    </div>

                    <div class="row mb-3">
                        <div class="col md-6">
                            <div class="form-floating mb-6">
                                <label for="tempat_lahir">Tempat Lahir <span style="color: red;">*</span></label>
                                <input class="form-control" id="tempat_lahir" name="tempat_lahir" type="text"
                                    placeholder="Tempat Lahir" />
                            </div>
                        </div>
                        <div class="col md-6">
                            <div class="form-floating mb-6">
                                <label for="tgl_lahir">Tanggal Lahir <span style="color: red;">*</span></label>
                                <input class="form-control" id="tgl_lahir" name="tgl_lahir" type="date"
                                    placeholder="Tanggal Lahir" />
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col md-6">
                            <div class="form-floating mb-6">
                                <label for="usia">Usia <span style="color: red;">*</span></label>
                                <input class="form-control" id="usia" name="usia" type="number" />
                            </div>
                        </div>
                        <div class="col md-6">
                            <div class="form-floating mb-6">
                                <label for="anak_ke">Anak Ke</label>
                                <input class="form-control" id="anak_ke" name="anak_ke" type="number" />
                            </div>
                        </div>
                    </div>

                    <div class="form-floating mb-3">
                        <label for="jenis_kelamin">Jenis Kelamin <span style="color: red;">*</span></label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="kelamin" id="kelamin1" value="L">
                            <label class="form-check-label" for="kelamin1">
                                Laki-laki
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="kelamin" id="kelamin2" value="P">
                            <label class="form-check-label" for="kelamin2">
                                Perempuan
                            </label>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col md-6">
                            <div class="form-floating mb-6">
                                <label for="agama">agama <span style="color: red;">*</span></label>
                                <input class="form-control" id="agama" name="agama" type="text" />
                            </div>
                        </div>
                        <div class="col md-6">
                            <div class="form-floating mb-6">
                                <label for="kewarganegaraan">Kewarganegaraan <span style="color: red;">*</span></label>
                                <input class="form-control" id="kewarganegaraan" name="kewarganegaraan" type="text" />
                            </div>
                        </div>
                    </div>

                    <div class="form-floating mb-3">
                        <label for="id_kelas">Kelas <span style="color: red;">*</span></label>
                        <select class="form-control" id="id_kelas" name="id_kelas" required>
                            <option value="">-- Pilih Kelas --</option>
                            <?php foreach ($kelas as $k) : ?>
                            <option value="<?= $k['id_kelas']; ?>">
                                <?= $k['nama_kelas']; ?> (<?= $k['jumlah_siswa']; ?> siswa)
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-floating row mb-3">
                        <div class="mb-6">
                            <label for="image">Foto</label>
                            <input type="file" name="image" class="form-control">
                        </div>
                    </div>

                    <div class="mt-4 mb-0">
                        <div class="d-grid">
                            <button class="btn btn-primary" type="submit">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->