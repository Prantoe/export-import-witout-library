<?php
header("Content-type:application/octet-stream/");
header("Content-Disposition:attachment; filename=$title.xls");
header("Pragma: no-cache");
header("Expires: 0");

?>
<h3>laporan barang masuk tanggal : <?= date('d F Y'); ?></h3>

<table border="1" width="100% ">
    <thead>
        <tr>
            <th>no</th>
            <th>kode barang</th>
            <th>nama barang</th>
            <th>jumlah</th>
            <th>tanggal masuk</th>
        </tr>
    </thead>

    <tbody>
        <?php $i = 1;
        foreach ($semuabarang as $barang) : ?>
            <tr>
                <td><?= $i++ ?></td>
                <td><?= $barang['kode_barang']; ?></td>
                <td><?= $barang['nama_barang']; ?></td>
                <td><?= $barang['jumlah']; ?></td>
                <td><?= date('d F Y', $barang['date_created']); ?></td>

            </tr>
        <?php endforeach; ?>
    </tbody>
</table>