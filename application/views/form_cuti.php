<div class="row mb-2">
    <h4 class="col-xs-12 col-sm-6 mt-0">Pilih Cuti</h4>
    <div class="col-xs-12 col-sm-6 ml-auto text-right">
        <form action="" method="get">
            <div class="row">
                <div class="col ">
                    <a href="<?php echo base_url().'Absensi/cuti_istimewa'?>" class="btn btn-primary btn-fill btn-block">Cuti Istimewa</a>
                </div>
                <div class="col ">
                    <a href="<?php echo base_url().'Absensi/cuti_biasa'?>" class="btn btn-primary btn-fill btn-block">Cuti Biasa</a>
                </div>
            </div>
        </form>
    </div>
</div>
<?php if (isset($istimewa)):?>
<div class="row">
    <div class="col-12 col-md-12">
        <div class="card">
            <form action="<?= base_url('Absensi/input_form_cuti_istimewa') ?>" method="post" enctype="multipart/form-data">
                <div class="card-header">
                    <h4 class="card-title">Form Cuti Istimewa</h4>
                </div>
                <div class="card-body border-top py-0 my-3">
                    <div class="row">
                        <div class="col-xs-12 col-sm-6">
                            <div class="form-group">
                                <label for="nik">NIk : </label>
                                <?php
                                $get_div=$this->db->get_where('divisi', ['id_divisi' => $user->divisi])->row();
                                ?>
                                <input type="hidden" name="divisi" id="divisi" value="<?= $get_div->nama_divisi ?>" class="form-control" placeholder="Masukana Nama Lengkap Karyawan" required="reuqired" />
                                <input type="hidden" name="id_user" value="<?= $user->id_user ?>">
                                <input type="text" name="nik" id="nik" value="<?= $user->nik ?>" class="form-control" placeholder="Masukan NIK Karyawan" disabled required="reuqired" />
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <div class="form-group">
                                <label for="nama">Nama Lengkap : </label>
                                <input type="text" name="nama" id="nama" value="<?= $user->nama ?>" class="form-control" placeholder="Masukana Nama Lengkap Karyawan" disabled required="reuqired" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-6">
                            <div class="form-group">
                                <label for="tanggal">Tanggal Mulai: </label>
                                <input type="date" name="tanggal_mulai" class="form-control" placeholder="Masukan NIK Karyawan" required="reuqired" />
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <div class="form-group">
                                <label for="tanggal">Tanggal Selesai: </label>
                                <input type="date" name="tanggal_selesai" class="form-control" placeholder="Masukan NIK Karyawan" required="reuqired" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12">
                            <div class="form-group">
                                <?php
                                $get_div=$this->db->get_where('divisi', ['id_divisi' => $user->divisi])->row();
                                ?>
                                <label for="divisi">Dengan ini mengajukan cuti untuk : </label>
                                <input type="text" name="keterangan_cuti" id="divisi" class="form-control" placeholder="" required="reuqired" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row w-100">
                        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
                            <button type="submit" class="btn btn-primary btn-block">Simpan <i class="fa fa-save"></i></button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php elseif (isset($biasa)):?>
<div class="row">
    <div class="col-12 col-md-12">
        <div class="card">
            <form action="<?= base_url('Absensi/input_form_cuti_biasa') ?>" method="post" enctype="multipart/form-data">
                <div class="card-header">
                    <h4 class="card-title">Form Cuti Biasa</h4>
                </div>
                <div class="card-body border-top py-0 my-3">
                    <div class="row">
                        <div class="col-xs-12 col-sm-6">
                            <div class="form-group">
                                <label for="nik">NIk : </label>
                                <?php
                                $get_div=$this->db->get_where('divisi', ['id_divisi' => $user->divisi])->row();
                                ?>
                                <input type="hidden" name="divisi" id="divisi" value="<?= $get_div->nama_divisi ?>" class="form-control" placeholder="Masukana Nama Lengkap Karyawan" required="reuqired" />
                                <input type="hidden" name="id_user" value="<?= $user->id_user ?>">
                                <input type="text" name="nik" id="nik" value="<?= $user->nik ?>" class="form-control" placeholder="Masukan NIK Karyawan" disabled required="reuqired" />
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <div class="form-group">
                                <label for="nama">Nama Lengkap : </label>
                                <input type="text" name="nama" id="nama" value="<?= $user->nama ?>" class="form-control" placeholder="Masukana Nama Lengkap Karyawan" disabled required="reuqired" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-6">
                            <div class="form-group">
                                <label for="tanggal">Tanggal Mulai: </label>
                                <input type="date" name="tanggal_mulai" class="form-control" placeholder="Masukan NIK Karyawan" required="reuqired" />
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <div class="form-group">
                                <label for="tanggal">Tanggal Selesai: </label>
                                <input type="date" name="tanggal_selesai" class="form-control" placeholder="Masukan NIK Karyawan" required="reuqired" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12">
                            <div class="form-group">
                                <?php
                                $get_div=$this->db->get_where('divisi', ['id_divisi' => $user->divisi])->row();
                                ?>
                                <label for="divisi">Dengan ini mengajukan cuti untuk : </label>
                                <input type="text" name="keterangan_cuti" id="divisi" class="form-control" placeholder="" required="reuqired" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row w-100">
                        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
                            <button type="submit" class="btn btn-primary btn-block">Simpan <i class="fa fa-save"></i></button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
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
                </div>
            </div>            
            <div class="card-body">
                <h4 class="card-title mb-4">Data Cuti Biasa</h4>
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal Mulai</th>
                            <th>Tanggal Selesai</th>
                            <th>Lama Hari</th>
                            <th>Status</th>
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
                                    <td><?php if ($i['status'] == 0){ echo 'Pending';} else { echo 'ACC';} ?></td>
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

<?php endif; ?>