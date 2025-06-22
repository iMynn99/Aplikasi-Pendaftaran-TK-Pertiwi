<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Formulir Data Orang Tua</h6>
        </div>
        <div class="card-body mb-2">

            <div class="card-body">
                <form method="post" action="<?php echo base_url('user/ortu/form/update'); ?>">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-floating mb-3 mb-md-0">
                                <label for="nama_ayah">Nama Ayah</label>
                                <input class="form-control" id="nama_ayah" name="nama_ayah" type="text" placeholder="Nama Ayah" value="<?= isset($ortu['nama_ayah']) ? $ortu['nama_ayah'] : ''; ?>" required />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <label for="nik_ayah">NIK Ayah</label>
                                <input class="form-control" id="nik_ayah" name="nik_ayah" type="number" placeholder="NIK Ayah" value="<?= isset($ortu['nik_ayah']) ? $ortu['nik_ayah'] : ''; ?>" required />
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-floating mb-3 mb-md-0">
                                <label for="lahir_ayah">Tanggal Lahir Ayah</label>
                                <input class="form-control" id="lahir_ayah" name="lahir_ayah" type="date" placeholder="Tanggal Lahir Ayah" value="<?= isset($ortu['lahir_ayah']) ? $ortu['lahir_ayah'] : ''; ?>" required />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <label for="pend_ayah">Pendidikan Ayah</label>
                                <select class="form-control" id="pend_ayah" name="pend_ayah" required>
                                    <option value="sd" <?= isset($ortu['pend_ayah']) && $ortu['pend_ayah'] == 'sd' ? 'selected' : ''; ?>>SD</option>
                                    <option value="smp" <?= isset($ortu['pend_ayah']) && $ortu['pend_ayah'] == 'smp' ? 'selected' : ''; ?>>SMP</option>
                                    <option value="sma" <?= isset($ortu['pend_ayah']) && $ortu['pend_ayah'] == 'sma' ? 'selected' : ''; ?>>SMA</option>
                                    <option value="s1" <?= isset($ortu['pend_ayah']) && $ortu['pend_ayah'] == 's1' ? 'selected' : ''; ?>>S1</option>
                                    <option value="s2" <?= isset($ortu['pend_ayah']) && $ortu['pend_ayah'] == 's2' ? 'selected' : ''; ?>>S2</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-floating mb-3">
                        <label for="kerja_ayah">Pekerjaan Ayah</label>
                        <select class="form-control" id="kerja_ayah" name="kerja_ayah" required>
                            <option value="pns" <?= isset($ortu['kerja_ayah']) && $ortu['kerja_ayah'] == 'pns' ? 'selected' : ''; ?>>PNS</option>
                            <option value="wiraswasta" <?= isset($ortu['kerja_ayah']) && $ortu['kerja_ayah'] == 'wiraswasta' ? 'selected' : ''; ?>>Wiraswasta</option>
                            <option value="buruh" <?= isset($ortu['kerja_ayah']) && $ortu['kerja_ayah'] == 'buruh' ? 'selected' : ''; ?>>Buruh</option>
                            <option value="lainnya" <?= isset($ortu['kerja_ayah']) && $ortu['kerja_ayah'] == 'lainnya' ? 'selected' : ''; ?>>Lainnya</option>
                        </select>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-floating mb-3 mb-md-0">
                                <label for="nama_ibu">Nama Ibu</label>
                                <input class="form-control" id="nama_ibu" name="nama_ibu" type="text" placeholder="Nama Ibu" value="<?= isset($ortu['nama_ibu']) ? $ortu['nama_ibu'] : ''; ?>" required />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <label for="nik_ibu">NIK Ibu</label>
                                <input class="form-control" id="nik_ibu" name="nik_ibu" type="number" placeholder="NIK Ibu" value="<?= isset($ortu['nik_ibu']) ? $ortu['nik_ibu'] : ''; ?>" required />
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-floating mb-3 mb-md-0">
                                <label for="lahir_ibu">Tanggal Lahir Ibu</label>
                                <input class="form-control" id="lahir_ibu" name="lahir_ibu" type="date" placeholder="Tanggal Lahir Ibu" value="<?= isset($ortu['lahir_ibu']) ? $ortu['lahir_ibu'] : ''; ?>" required />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <label for="pend_ibu">Pendidikan Ibu</label>
                                <select class="form-control" id="pend_ibu" name="pend_ibu" required>
                                    <option value="sd" <?= isset($ortu['pend_ibu']) && $ortu['pend_ibu'] == 'sd' ? 'selected' : ''; ?>>SD</option>
                                    <option value="smp" <?= isset($ortu['pend_ibu']) && $ortu['pend_ibu'] == 'smp' ? 'selected' : ''; ?>>SMP</option>
                                    <option value="sma" <?= isset($ortu['pend_ibu']) && $ortu['pend_ibu'] == 'sma' ? 'selected' : ''; ?>>SMA</option>
                                    <option value="s1" <?= isset($ortu['pend_ibu']) && $ortu['pend_ibu'] == 's1' ? 'selected' : ''; ?>>S1</option>
                                    <option value="s2" <?= isset($ortu['pend_ibu']) && $ortu['pend_ibu'] == 's2' ? 'selected' : ''; ?>>S2</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-floating mb-3">
                        <label for="kerja_ibu">Pekerjaan Ibu</label>
                        <select class="form-control" id="kerja_ibu" name="kerja_ibu" required>
                            <option value="pns" <?= isset($ortu['kerja_ibu']) && $ortu['kerja_ibu'] == 'pns' ? 'selected' : ''; ?>>PNS</option>
                            <option value="wiraswasta" <?= isset($ortu['kerja_ibu']) && $ortu['kerja_ibu'] == 'wiraswasta' ? 'selected' : ''; ?>>Wiraswasta</option>
                            <option value="ibu_rumah" <?= isset($ortu['kerja_ibu']) && $ortu['kerja_ibu'] == 'ibu_rumah' ? 'selected' : ''; ?>>Ibu Rumah Tangga</option>
                            <option value="lainnya" <?= isset($ortu['kerja_ibu']) && $ortu['kerja_ibu'] == 'lainnya' ? 'selected' : ''; ?>>Lainnya</option>
                        </select>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-floating mb-3 mb-md-0">
                                <label for="no_telepon">Nomor Telepon</label>
                                <input class="form-control" id="no_telepon" name="no_telepon" type="text" placeholder="Nomor Telepon" value="<?= isset($ortu['no_telepon']) ? $ortu['no_telepon'] : ''; ?>" required />
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