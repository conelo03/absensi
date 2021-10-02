<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Data Izin <?= $karyawan->nama ?> bulan <?= bulan($bulan) . ', ' . $tahun ?></title>

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
                            <h5 class="card-title mb-4">Data Izin Bulan : <?= bulan($bulan) . ' ' . $tahun ?></h5>
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Alasan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if($izin): ?>
                                        <?php 
                                        $no=1;
                                        foreach($izin as $i): ?>
                                            <tr>
                                                <td><?= ($no++) ?></td>
                                                <td><?= $i['tanggal'] ?></td>
                                                <td><?= $i['alasan'] ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td class="bg-light" colspan="4">Tidak ada data izin</td>
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
