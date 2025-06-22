<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="row ml-4 m-4">
        <div class="col-md-4 p-2">
            <table class="table table-borderless">
                <tbody>
                    <tr>
                        <th scope="row">Nama Ayah</th>
                        <td><?= $ortu['nama_ayah']; ?></td>
                    </tr>
                    <tr>
                        <th scope="row">NIK Ayah</th>
                        <td><?= $ortu['nik_ayah']; ?></td>
                    </tr>
                    <tr>
                        <th scope="row">Tanggal Lahir Ayah</th>
                        <td><?= date('d F Y', strtotime($ortu['lahir_ayah'])); ?></td>
                    </tr>
                    <tr>
                        <th scope="row">Pendidikan Ayah</th>
                        <td><?= $ortu['pend_ayah']; ?></td>
                    </tr>
                    <tr>
                        <th scope="row">Pekerjaan Ayah</th>
                        <td><?= $ortu['kerja_ayah']; ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-md-2"></div>
        <div class="col-md-4 p-2">
            <table class="table table-borderless">
                <tbody>
                    <tr>
                        <th scope="row">Nama Ibu</th>
                        <td><?= $ortu['nama_ibu']; ?></td>
                    </tr>
                    <tr>
                        <th scope="row">NIK Ibu</th>
                        <td><?= $ortu['nik_ibu']; ?></td>
                    </tr>
                    <tr>
                        <th scope="row">Tanggal Lahir Ibu</th>
                        <td><?= date('d F Y', strtotime($ortu['lahir_ibu'])); ?></td>
                    </tr>
                    <tr>
                        <th scope="row">Pendidikan Ibu</th>
                        <td><?= $ortu['pend_ibu']; ?></td>
                    </tr>
                    <tr>
                        <th scope="row">Pekerjaan Ibu</th>
                        <td><?= $ortu['kerja_ibu']; ?></td>
                    </tr>
                    <tr>
                        <th scope="row">Nomor Telepon</th>
                        <td><?= $ortu['no_telepon']; ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="row ml-4 p-2">
        <div class="col-md-4">

            <a href="<?= base_url('user/pembayaran'); ?>" class="btn btn-primary">Pembayaran</a>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->