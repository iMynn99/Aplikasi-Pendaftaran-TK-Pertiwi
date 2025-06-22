<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Laporan Data</h1>
    <h5>Pada tanggal <?= $tgl_awal ?> sampai <?= $tgl_akhir ?></h5>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>ID User</th>
                <th>ID Pembayaran</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Status</th>
                <th>Tanggal Bayar</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no = 1;
            foreach ($bayar as $b): ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= htmlspecialchars($b['id_login']); ?></td>
                    <td><?= htmlspecialchars($b['id_pembayaran']); ?></td>
                    <td><?= htmlspecialchars($b['nama_siswa']); ?></td>
                    <td><?= htmlspecialchars($b['email']); ?></td>
                    <td><?= htmlspecialchars($b['status']); ?></td>
                    <td><?= htmlspecialchars($b['tgl_bayar']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
<script>
    window.print();
</script>
</html>