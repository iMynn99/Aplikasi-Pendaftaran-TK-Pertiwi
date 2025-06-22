<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Bukti Pembayaran</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 40px;
            font-size: 14px;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header img {
            max-height: 100px;
        }

        .title {
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            text-decoration: underline;
            margin-bottom: 20px;
        }

        .section {
            margin-bottom: 15px;
        }

        .section h4 {
            margin-bottom: 5px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 3px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td {
            padding: 5px 10px;
            vertical-align: top;
        }

        .footer {
            text-align: right;
            margin-top: 40px;
        }

        .footer p {
            margin: 0;
        }
    </style>
</head>

<body>

    <div class="header">
        <img src="<?= base_url('assets/img/doc/tk.png') ?>" alt="Logo Sekolah">
        <h2>TK PERTIWI BOJONGWETAN</h2>
        <p>Jl. Sekar Arum Desa Bojongwetan Kec. Bojong Kode Pos 51156</p>
    </div>

    <div class="title">BUKTI PEMBAYARAN</div>

    <div class="section">
        <div style="display: grid; grid-template-columns: auto 1fr; gap: 20px; margin-top: 50px;margin-bottom: 100px;">
            <div><strong>Nama Peserta Didik</strong></div>
            <div>: <?= $siswa['nama_siswa'] ?></div>

            <div><strong>Tanggal Pembayaran</strong></div>
            <div>: <?= date('d F Y', strtotime($tagihan['tgl_bayar'])) ?></div>

            <div><strong>Jumlah</strong></div>
            <div>: Rp <?= number_format($tagihan['nominal'], 0, ',', '.') ?></div>

            <div><strong>ID Pembayaran</strong></div>
            <div>: <?= $tagihan['id_pembayaran'] ?></div>

            <div><strong>Status</strong></div>
            <div>: <span style="color: green; font-weight: bold;">LUNAS</span></div>
        </div>
    </div>

    <div class="footer">
        <p><?= date('d F Y') ?></p>
        <br><br><br>
        <p><strong>Panitia Penerimaan</strong></p>
        <img src="data:image/jpeg;base64,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">
    </div>

    <script>
        window.print();
    </script>

</body>

</html>