<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="row">
        <div class="col-md-5">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Tagihan</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-borderless">
                            <thead>
                                <tr>
                                    <th>ID Pembayaran</th>
                                    <th>Nominal</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><?= $tagihan['id_pembayaran']; ?></td>
                                    <td><?= number_format($tagihan['nominal'], 0, ',', '.'); ?></td>
                                    <td><?= $tagihan['status'] == 'sudah' ? 'Lunas' : 'Belum Lunas'; ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div>
                        <h4>Silahkan transfer ke:</h4>
                        <br>
                        <p>No. Rekening : 123123</p>
                        <p>Atas Nama : TK Pertiwi</p>
                        <p>Bank : ABC</p>
                    </div>
                    <br />
                    <?php if (!$tagihan['bukti']): ?>
                    <div class="text-center">
                        <form action="<?= base_url('user/pembayaran/manual/upload') ?>" method="post"
                            enctype="multipart/form-data">
                            <div class="form-group">
                                <label>Upload Bukti Transfer</label>
                                <input type="file" name="bukti" class="form-control" required>
                            </div>
                            <input type="hidden" name="id_pembayaran" value="<?= $tagihan['id_pembayaran'] ?>">
                            <button type="submit" class="btn btn-primary">Upload</button>
                        </form>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>