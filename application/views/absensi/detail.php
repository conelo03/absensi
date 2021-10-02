<div class="row mb-2">
    <h4 class="col-xs-12 col-sm-6 mt-0">Detail Absen</h4>
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
                        <div class="dropdown d-inline">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="droprop-action" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-print"></i>
                                Export Laporan
                            </button>
                            <div class="dropdown-menu" aria-labelledby="droprop-action">
                                <a href="<?= base_url('absensi/export_pdf/' . $this->uri->segment(3) . "?bulan=$bulan&tahun=$tahun") ?>" class="dropdown-item" target="_blank"><i class="fa fa-file-pdf-o"></i> PDF</a>
                                <a href="<?= base_url('absensi/export_excel/' . $this->uri->segment(3) . "?bulan=$bulan&tahun=$tahun") ?>" class="dropdown-item" target="_blank"><i class="fa fa-file-excel-o"></i> Excel</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>            
            <div class="card-body">
                <h4 class="card-title mb-4">Absen Bulan : <?= bulan($bulan) . ' ' . $tahun ?></h4>
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Jam Masuk</th>
                            <th>Jam Keluar</th>
                            <?php if(is_level('Manager')):?>
                            <th>Aksi</th>
                            <?php endif;?>
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
                                    <?php if(is_level('Manager')):?>
                                    <td>
                                        <a href="#" class="btn btn-primary btn-sm btn-edit-jam" data-toggle="modal" data-target="#edit-jam<?= $h['id_user']?>"><i class="fa fa-edit"></i> Edit</a>
                                    </td>
                                    <?php endif;?>
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
<?php foreach($absen as $i => $h): ?>
<div class="modal-wrapper">
    <div class="modal fade" id="edit-jam<?= $h['id_user']?>" tabindex="-1" role="dialog" aria-labelledby="edit-jam-label" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="<?= base_url('Absensi/absen_pulang/') ?>" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title" id="edit-jam-label">Edit Jam Pulang<span id="edit-keterangan"></span></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="start">Tanggal :</label>
                            <input type="hidden" name="id_user" value="<?= $h['id_user']?>" id="edit-id-jam">
                            <input type="date" name="tgl" class="form-control" required="reuired" />
                            <label for="start">Jam Pulang :</label>
                            <input type="time" name="jam_pulang" class="form-control" placeholder="Jam Mulai" required="reuired" />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>
