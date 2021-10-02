<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Data Izin</title>

    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>">
</head>
<body>
    <div class="row mt-2">
        <div class="mt-2">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-4">Laporan Absensi Bulan : <?= bulan($bulan) . ' ' . $tahun ?></h4>
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>NIK</th>
                                        <th>Nama</th>
                                        <th>Divisi</th>
                                        <th>Hadir</th>
                                        <th>Izin</th>
                                        <th>Alfa</th>
                                        <th>Cuti</th>
                                        <th>Jml. Lembur</th>
                                        <th>Upah Lembur</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if($absensi): ?>
                                        <?php 
                                        $no=1;
                                        foreach($absensi as $i):
                                        $id_user=$i['id_user']; 
                                        $id_divisi=$i['divisi']; 
                                        $get_hadir = $this->db->query("SELECT * FROM rekap_absensi where id_user='$id_user' and DATE_FORMAT(tgl, '%m') = '$bulan' and DATE_FORMAT(tgl, '%Y') = '$tahun'")->num_rows();
                                        $get_izin = $this->db->query("SELECT * FROM izin where id_user='$id_user' and DATE_FORMAT(tanggal, '%m') = '$bulan' and DATE_FORMAT(tanggal, '%Y') = '$tahun'")->num_rows();
                                        $get_cuti = $this->db->query("SELECT sum(lama_hari) as cuti FROM cuti where id_user='$id_user' and DATE_FORMAT(tanggal_mulai, '%m') = '$bulan' and DATE_FORMAT(tanggal_mulai, '%Y') = '$tahun'")->row_array();
                                        $get_lembur = $this->db->query("SELECT sum(jml_lembur) as lembur, sum(upah_lembur) as upah FROM rekap_absensi where id_user='$id_user' and DATE_FORMAT(tgl, '%m') = '$bulan' and DATE_FORMAT(tgl, '%Y') = '$tahun'")->row_array();
                                        $get_divisi = $this->db->query("SELECT * FROM divisi where id_divisi='$id_divisi'")->row_array();
                                        ?>
                                            <tr>
                                                <td><?= ($no++) ?></td>
                                                <td><?= $i['nik'] ?></td>
                                                <td><?= $i['nama'] ?></td>
                                                <td><?= $get_divisi['nama_divisi'] ?></td>
                                                <td><?= $get_hadir.' Hari' ?></td>
                                                <td><?= $get_izin.' Hari' ?></td>
                                                <td><?= ' Hari' ?></td>
                                                <td><?= @$get_cuti['cuti'] == 0 ? 0 : $get_cuti['cuti'].' Hari'; ?></td>
                                                <td><?= $get_lembur['lembur'].' Jam' ?></td>
                                                <td><?= 'Rp '.number_format($get_lembur['upah'],0,'','.') ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td class="bg-light" colspan="4">Tidak ada data cuti</td>
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
