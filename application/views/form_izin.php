<div class="row">

    <div class="col-12 col-md-12">
        <div class="card">
            <form action="<?= base_url('Absensi/input_form_izin') ?>" method="post" enctype="multipart/form-data">
                <div class="card-header">
                    <h4 class="card-title">Form Izin</h4>
                </div>
                <div class="card-body border-top py-0 my-3">
                    <div class="row">
                        <div class="col-xs-12 col-sm-6">
                            <div class="form-group">
                                <label for="nik">NIk : </label>
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
                                <label for="tanggal">Tanggal : </label>
                                <input type="date" name="tanggal" class="form-control" placeholder="Masukan NIK Karyawan" required="reuqired" />
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <div class="form-group">
                                <?php
                                $get_div=$this->db->get_where('divisi', ['id_divisi' => $user->divisi])->row();
                                ?>
                                <label for="divisi">Divisi : </label>
                                <input type="text" name="divisi" id="divisi" value="<?= $get_div->nama_divisi ?>" class="form-control" placeholder="Masukana Nama Lengkap Karyawan" required="reuqired" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body border-top py-0 my-3">
                    <div class="row">
                        <div class="col-xs-12 col-sm-6">
                            <div class="form-group">
                                <label for="alasan">Alasan Izin</label>
                                <input type="text" name="alasan" id="alasan" value="" class="form-control" placeholder="" required="reuqired" />
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <div class="form-group">
                                <label for="bukti">Upload Bukti</label>
                                <input type="file" name="bukti" class="form-control" id="input-foto" aria-describedby="input-foto" accept="image/*">
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