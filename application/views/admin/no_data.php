<div class="no-data">
    <h2>Data tidak tersedia</h2>
    <p>Tidak ada data pada tanggal <?= $tgl_awal ?> sampai <?= $tgl_akhir ?></p>
    <div style="text-align: center;"></div>
    <a href="javascript:history.back()" class="btn-back">Kembali</a>
</div>

<style>
    .btn-back {
        display: inline-block;
        margin-top: 20px;
        padding: 10px 20px;
        background-color: #007bff;
        color: #fff;
        text-decoration: none;
        border-radius: 5px;
        font-family: Arial, sans-serif;
    }

    .btn-back:hover {
        background-color: #0056b3;
    }
</style>

<style>
    .no-data {
        text-align: center;
        margin-top: 50px;
        font-family: Arial, sans-serif;
    }

    .no-data h2 {
        color: #555;
    }

    .no-data p {
        color: #777;
    }
</style>
</div>