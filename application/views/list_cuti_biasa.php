<div class="row mb-2">
    <h4 class="col-xs-12 col-sm-6 mt-0">Data Cuti Biasa</h4>
    <div class="col-xs-12 col-sm-6 ml-auto text-right">
        <form action="" method="get">
            <div class="row">
                <div class="col">
                    <select name="bulan" id="bulan" class="form-control">
                        <option value="" disabled selected>-- Pilih Bulan --</option>
                        <?php foreach($all_bulan as $bn => $bt): ?>
                            <option value="<?= $bn ?>" <?= ($bn == $bulan) ? 'selected' : '' ?>><?= $bt ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col ">
                    <select name="tahun" id="tahun" class="form-control">
                        <option value="" disabled selected>-- Pilih Tahun</option>
                        <?php for($i = date('Y'); $i >= (date('Y') - 5); $i--): ?>
                            <option value="<?= $i ?>" <?= ($i == $tahun) ? 'selected' : '' ?>><?= $i ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="col ">
                    <button type="submit" class="btn btn-primary btn-fill btn-block">Tampilkan</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header border-bottom">
                <div class="row">
                    <div class="col-xs-12 col-sm-6">
                        <table class="table border-0">
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
                    <div class="col-xs-12 col-sm-6 ml-auto text-right mb-2">
                        <a href="<?= base_url('absensi/export_cuti_biasa/' . $this->uri->segment(3) . "?bulan=$bulan&tahun=$tahun") ?>" class="btn btn-secondary" target="_blank"><i class="fa fa-file-pdf-o"></i> PDF</a>
                    </div>
                </div>
            </div>            
            <div class="card-body">
                <h4 class="card-title mb-4">Cuti Bulan : <?= bulan($bulan) . ' ' . $tahun ?></h4>
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal Mulai</th>
                            <th>Tanggal Selesai</th>
                            <th>Lama Hari</th>
                            <th>Keterangan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($cuti): ?>
                            <?php 
                            $no=1;
                            foreach($cuti as $i): ?>
                                <tr>
                                    <td><?= ($no++) ?></td>
                                    <td><?= $i['tanggal_mulai'] ?></td>
                                    <td><?= $i['tanggal_selesai'] ?></td>
                                    <td><?= $i['lama_hari'].' Hari' ?></td>
                                    <td><?= $i['keterangan_cuti'] ?></td>
                                    <td><?php if ($i['status'] == 0){ echo 'Pending';} else { echo 'ACC';} ?></td>
                                    <td>
                                        <?php if ($i['status'] ==0):?>
                                        <a href="<?= base_url('absensi/konfirmasi_cuti/'.$i['id_cuti']).'/'.$i['id_user'] ?>"  class="btn btn-primary btn-sm btn-konfirmasi" onclick="return false"><i class="fa fa-edit"></i> Konfirmasi</a>
                                        <?php else:?>

                                        <?php endif;?>
                                    </td>
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