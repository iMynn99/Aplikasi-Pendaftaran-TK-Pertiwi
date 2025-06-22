<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Surat Resmi TK PERTIWI</title>
    <style>
    @media print {
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
        }

        .btn,
        nav,
        footer {
            display: none !important;
        }
    }

    .kop-container {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
    }

    .kop-logo {
        flex: 0 0 120px;
        text-align: center;
    }

    .kop-text {
        flex: 1;
        text-align: center;
    }

    .kop-text h5,
    .kop-text h6 {
        margin: 0;
    }

    .kop-text p {
        margin: 5px 0 0 0;
        font-size: 13px;
    }

    .garis-atas {
        border: 1px solid black;
        margin: 10px 0 0 0;
    }

    .garis-bawah {
        border: 0.5px solid black;
        margin: -5px 0 20px 0;
    }

    .biodata-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    .biodata-table td {
        padding: 6px;
        vertical-align: top;
    }

    .biodata-table td:first-child {
        width: 200px;
    }

    .tanda-tangan {
        width: 100%;
        display: flex;
        justify-content: flex-end;
        margin-top: 10px;
        margin-right: 20px;
        /* Opsional: Sesuaikan jika masih terlalu mepet kanan */
    }

    .tanda-tangan div {
        text-align: center;
        max-width: 250px;
        /* Sesuaikan lebar ini agar tidak melebar */
        box-sizing: border-box;
    }

    .tanda-tangan p {
        margin: 0;
        /* Hapus margin default pada paragraf */
        line-height: 1.2;
        /* Sesuaikan nilai ini untuk mengatur jarak antar baris */
        /* Anda bisa mencoba 1.0, 1.1, 1.2 sesuai kerapatan yang diinginkan */
    }

    .tanda-tangan img {
        max-width: 120px;
        /* Sesuaikan lebar gambar tanda tangan */
        height: auto;
        display: block;
        margin: 5px auto;
        /* Memberi sedikit margin atas/bawah pada gambar */
    }
    </style>
</head>

<body>

    <div class="kop-container">
        <div class="kop-logo">
            <img src="<?= base_url('assets/img/doc/tk.png') ?>" width="100">
        </div>
        <div class="kop-text">
            <h6>PENDIDIKAN ANAK USIA DINI</h6>
            <h5><strong>TK PERTIWI BOJONGWETAN</strong></h5>
            <p>Desa Bojongwetan Kecamatan Bojong Kabupaten Pekalongan<br>
                Alamat: Jl. Sekar Arum Desa Bojongwetan Kec. Bojong Kode Pos 51156</p>
        </div>
    </div>

    <hr class="garis-atas">
    <hr class="garis-bawah">

    <div>

        <h5 style="text-align: center; font-weight: bold;">FORMULIR PESERTA DIDIK BARU<br>TAHUN PELAJARAN
            <?= date('Y'); ?></h5>

        <table class="biodata-table">
            <td><b>Biodata Siswa</b></td>
            <tr>
                <td>NIS</td>
                <td>: <?= strtoupper($siswa['nis']) ?></td>
            </tr>
            <tr>
                <td>Nama Lengkap</td>
                <td>: <?= strtoupper($siswa['nama_siswa']) ?></td>
            </tr>
            <tr>
                <td>NIK</td>
                <td>: <?= strtoupper($siswa['nik']) ?></td>
            </tr>
            <tr>
                <td>Tempat, Tanggal Lahir</td>
                <td>: <?= $siswa['tempat_lahir'] ?>, <?= date('d-m-Y', strtotime($siswa['tgl_lahir'])) ?></td>
            </tr>
            <tr>
                <td>Jenis Kelamin</td>
                <td>: <?= strtoupper($siswa['jenis_kelamin']) ?></td>
            </tr>
            <tr>
                <td>Alamat Lengkap</td>
                <td>: <?= strtoupper($siswa['alamat']) ?></td>
            </tr>
            <td><b>Biodata Ortu</b></td>
            <tr>
                <td>Nama Ayah</td>
                <td>: <?= strtoupper($ortu['nama_ayah']) ?></td>
            </tr>
            <tr>
                <td>NIK</td>
                <td>: <?= strtoupper($ortu['nik_ayah']) ?></td>
            </tr>
            <tr>
                <td>Pendidikan Ayah</td>
                <td>: <?= strtoupper($ortu['pend_ayah']) ?></td>
            </tr>
            <tr>
                <td>Pekerjaan Ayah</td>
                <td>: <?= strtoupper($ortu['kerja_ayah']) ?></td>
            </tr>
            <tr>
                <td>Nama Ibu</td>
                <td>: <?= strtoupper($ortu['nama_ibu']) ?></td>
            </tr>
            <tr>
                <td>NIK</td>
                <td>: <?= strtoupper($ortu['nik_ibu']) ?></td>
            </tr>
            <tr>
                <td>Pendidikan Ibu</td>
                <td>: <?= strtoupper($ortu['pend_ibu']) ?></td>
            </tr>
            <tr>
                <td>Pekerjaan Ibu</td>
                <td>: <?= strtoupper($ortu['kerja_ibu']) ?></td>
            </tr>
            <tr>
                <td>Nomor Telepon</td>
                <td>: <?= strtoupper($ortu['no_telepon']) ?></td>
            </tr>
        </table>

        <p
            style="text-align: justify; font-family: 'Times New Roman', Times, serif; font-size: 12pt; margin-top: 30px;">
            Berdasarkan data yang telah diterima, dengan ini kami menyatakan bahwa ananda
            <strong><?= strtoupper($siswa['nama_siswa']) ?></strong> dinyatakan diterima sebagai peserta didik pada
            <strong>Kelas <?= strtoupper($siswa['nama_kelas']) ?></strong> di TK Pertiwi Bojongwetan.
            <br><br>
            Demikian formulir ini kami sampaikan. Atas perhatian dan kerjasamanya, kami ucapkan terima kasih.
        </p>


    </div>

    <div class="tanda-tangan">
        <div>
            <p>Bojongwetan, <?= date('d M Y') ?></p>
            <p><strong>Kepala Sekolah</strong></p>
            <img width="120"
                src="data:image/jpeg;base64,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">
            <br>
            <p><u>Ra'ati S.Pd</u><br>NIP. 1234567890</p>
        </div>
    </div>

    <script>
    window.print();
    </script>
</body>

</html>