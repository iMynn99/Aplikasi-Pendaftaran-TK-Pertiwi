<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Kartu Pelajar</title>
    <style>
    @page {
        size: 8.5cm 5.5cm;
        margin: 0;
    }

    @media print {
        body {
            background-color: aliceblue !important;
            color: #333 !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        .header h2,
        .header p,
        .content div {
            color: #333 !important;
        }
    }

    body {
        background-color: aliceblue;
        font-family: Arial, sans-serif;
        padding: 5px;
        font-size: 10px;
        color: #333;
        margin: 0;
        width: 8.5cm;
        height: 5.5cm;
        box-sizing: border-box;
        overflow: hidden;
    }

    .header {
        display: flex;
        align-items: center;
        margin-top: 5px;
        margin-bottom: 2px;
        padding-bottom: 2px;
        border-bottom: 1px solid #eee;
    }

    .header img {
        max-height: 35px;
        margin-right: 8px;
        /* Tambah jarak kanan logo dari teks */
    }

    .header div {
        line-height: 1.1;
        flex-grow: 1;
        text-align: center;
    }

    .header h2 {
        margin: 0;
        font-size: 12px;
        font-weight: bold;
    }

    .header p {
        margin: 0;
        font-size: 7px;
    }

    .title {
        text-align: center;
        font-size: 10px;
        font-weight: bold;
        text-decoration: underline;
        margin-top: 5px;
        margin-bottom: 20px;
    }

    .section {
        margin-bottom: 0;
    }

    .content {
        display: grid;
        grid-template-columns: 1.5cm 1fr;
        gap: 8px;
        /* Tambah jarak antar kolom (foto dan teks) */
        margin-top: 8px;
        margin-left: 5px;
        margin-right: 5px;
    }

    .content div {
        font-size: 9px;
        margin-bottom: 4px;
        /* Tambah jarak bawah setiap baris data (NIS, Nama, dll.) */
        line-height: 1.2;
    }

    .foto-siswa {
        display: flex;
        /* Gunakan flexbox untuk memusatkan gambar */
        justify-content: center;
        /* Pusatkan horizontal */
        align-items: center;
        /* Pusatkan vertikal */
        padding: 2px;
        /* Tambahkan sedikit padding di sekitar gambar jika perlu */
    }

    .foto-siswa img {
        width: 100%;
        max-width: 1.8cm;
        height: auto;
        display: block;
        object-fit: cover;
    }
    </style>
</head>

<body>

    <div class="header">
        <img src="<?= base_url('assets/img/doc/tk.png') ?>" alt="Logo Sekolah">
        <div>
            <h2>TK PERTIWI BOJONGWETAN</h2>
            <p>Jl. Sekar Arum, Desa Bojongwetan Kec. Bojong, 51156</p>
        </div>
    </div>

    <div class="title">KARTU PELAJAR</div>

    <div class="section">
        <div class="content">
            <div class="foto-siswa">
                <img src="<?= base_url('assets/img/profile/' . $user['image']) ?>" alt="Foto Siswa">
            </div>
            <div>
                <div><strong>NIS :</strong> <?= $siswa['nis'] ?></div>
                <div><strong>Nama :</strong> <?= $siswa['nama_siswa'] ?></div>

                <div><strong>Tempat/Tanggal Lahir :</strong> <?= $siswa['tempat_lahir'] ?>,
                    <?= date('d F Y', strtotime($siswa['tgl_lahir'])) ?></div>

                <div><strong>Alamat :</strong> <?= $siswa['alamat'] ?></div>
                <div><strong>Kelas :</strong> <?= $siswa['nama_kelas'] ?></div>
            </div>
        </div>
    </div>

    <script>
    window.print();
    </script>
</body>

</html>