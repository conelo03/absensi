<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Absen <?= $karyawan->nama ?> bulan <?= bulan($bulan) . ', ' . $tahun ?></title>

    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>">
</head>
<body>
    <div class="row mt-2">
        <div class="mt-2">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex">
                            <div class="float-left">
                                <table class="table">
                                    <tr>
                                        <th class="border-0 py-0">Nama</th>
                                        <th class="border-0 py-0">:</th>
                                        <th class="border-0 py-0"><?= $karyawan->nama ?></th>
                                    </tr>
                                    <tr>
                                        <th class="border-0 py-0">Divisi</th>
                                        <th class="border-0 py-0">:</th>
                                        <th class="border-0 py-0"><?= $karyawan->nama_divisi ?></th>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title mb-4">Absen Bulan : <?= bulan($bulan) . ' ' . $tahun ?></h5>
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Jam Masuk</th>
                                        <th>Jam Keluar</th>
                                        <th>Jumlah Jam</th>
                                        <th>Kehadiran</th>
                                        <th>Jam Lembur</th>
                                        <th>Upah Lembur</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if($absen): ?>
                                        <?php foreach($absen as $i => $h): ?>
                                            <?php
                                                $absen_harian = array_search($h['tgl'], array_column($absen, 'tgl')) !== false ? $absen[array_search($h['tgl'], array_column($absen, 'tgl'))] : '';
                                            ?>
                                            <tr <?= ($absen_harian == '') ? 'class="bg-danger text-white"' : '' ?>>
                                                <td><?= ($i+1) ?></td>
                                                <td><?= $h['tgl'] ?></td>
                                                <td><?= check_jam(@$absen_harian['jam_masuk'], 'masuk') ?></td>
                                                <td><?= check_jam(@$absen_harian['jam_pulang'], 'pulang') ?></td>
                                                <td><?= $h['jml_jam'] ?> jam</td>
                                                <td><?= $h['kehadiran'] ?></td>
                                                <td><?= $h['jml_lembur'] ?> jam</td>
                                                <td><?= "Rp. ".number_format($h['upah_lembur'],2,',','.') ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td class="bg-light" colspan="4">Tidak ada data absen</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>