<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="row">
        <div class="col-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Cetak Laporan Pembayaran</h6>
                </div>
                <div class="card-body mb-2">
                    <form action="<?= base_url('admin/cetak'); ?>" method="post">
                        <div class="row pb-3">
                            <div class="col-lg-4">
                                <label for="start_date">Dari Tanggal</label>
                                <input type="date" class="form-control" id="start_date" name="tgl_awal" required>
                            </div>
                            <div class="col-lg-4">
                                <label for="end_date">Sampai Tanggal</label>
                                <input type="date" class="form-control" id="end_date" name="tgl_akhir" required>
                            </div>
                            <div class="col-lg-4 text-right">
                                <br>
                                <button type="submit" class="btn btn-block btn-primary"> Cetak PDF</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Cetak Laporan Data Siswa</h6>
                </div>
                <div class="card-body">

                    <div class="row my-4">
                        <div class="col-lg-12">
                            <a href="<?= base_url('admin/laporan/cetak/siswa/all'); ?>" class="btn btn-block btn-primary"> Cetak Semua Data</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- /.container-fluid -->

</div>
<!-- End of Main Content -->


</div>