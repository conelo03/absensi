<?php
defined('BASEPATH') OR die('No direct script access allowed!');

class Absensi_model extends CI_Model 
{
    public function get_absen($id_user, $bulan, $tahun)
    {
            $this->db->select("DATE_FORMAT(a.tgl, '%d-%m-%Y') AS tgl, a.waktu AS jam_masuk, a.id_user as id_user, (SELECT waktu FROM absensi al WHERE al.tgl = a.tgl AND id_user = '$id_user' AND al.keterangan != a.keterangan) AS jam_pulang");
            $this->db->where('id_user', $id_user);
            $this->db->where("DATE_FORMAT(tgl, '%m') = ", $bulan);
            $this->db->where("DATE_FORMAT(tgl, '%Y') = ", $tahun);
            $this->db->group_by("tgl");
            $result = $this->db->get('absensi a');
            

        return $result->result_array();
    }

    public function rekap_absensi($id_user, $bulan, $tahun){
        $result = $this->db->query("SELECT DATE_FORMAT(a.tgl, '%d-%m-%Y') as tgl, a.waktu as jam_masuk, (select ab.waktu from absensi ab where a.id_user=ab.id_user and a.tgl=ab.tgl and a.keterangan != ab.keterangan) as jam_pulang, r.jml_jam,r.kehadiran,r.jml_lembur,r.upah_lembur FROM absensi a join rekap_absensi r on r.id_user=a.id_user and r.tgl=a.tgl WHERE a.id_user='$id_user' and DATE_FORMAT(r.tgl, '%m')='$bulan' and DATE_FORMAT(r.tgl, '%Y')='$tahun' group by a.tgl ");
        return $result->result_array();
    }

    public function absen_harian_user($id_user)
    {
        $today = date('Y-m-d');
        $this->db->where('tgl', $today);
        $this->db->where('id_user', $id_user);
        $data = $this->db->get('absensi');
        return $data;
    }

    public function insert_data($data)
    {
        $result = $this->db->insert('absensi', $data);
        return $result;
    }

    public function get_jam_by_time($time)
    {
        $this->db->where('start', $time, '<=');
        $this->db->or_where('finish', $time, '>=');
        $data = $this->db->get('jam');
        return $data;
    }
}



/* End of File: d:\Ampps\www\project\absen-pegawai\application\models\Absensi_model.php */