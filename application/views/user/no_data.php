<div class="no-data">
    <h2>Kamu Belum melengkapi <?= $judul;?></h2>
    <p>Silahkan Lengkapi terlebih dahulu</p>
    <div style="text-align: center;"></div>
    <a href="
    <?= $judul == 'Data Diri' ? base_url('user/data/form') : base_url('user/ortu/form'); ?>
    " class="btn-back">Lengkapi</a>
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