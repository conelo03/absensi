<?php
defined('BASEPATH') OR die('No direct script access allowed!');

class Absensi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_login();
        date_default_timezone_set('Asia/Jakarta');
        $this->load->model('Absensi_model', 'absensi');
        $this->load->model('Karyawan_model', 'karyawan');
        $this->load->model('Jam_model', 'jam');
        $this->load->model('User_model', 'user');
        $this->load->helper('Tanggal');
    }

    public function index($menu)
    {
        if (is_level('Karyawan')) {
            return $this->detail_absensi();
        } else {
            return $this->list_karyawan($menu);
        }
    }

    public function list_karyawan($menu)
    {
        $data['karyawan'] = $this->karyawan->get_all();
        $data['menu'] = $menu;
        return $this->template->load('template', 'absensi/list_karyawan', $data);
    }

    public function data_izin($id_user)
    {
        $bulan = @$this->input->get('bulan') ? $this->input->get('bulan') : date('m');
        $tahun = @$this->input->get('tahun') ? $this->input->get('tahun') : date('Y');
        $id_user = $id_user;
        $data['user'] = $this->user->find_by('id_user', $id_user, true);
        $data['karyawan'] = $this->karyawan->find($id_user);
        $data['izin'] = $this->db->select('*')
                                ->where('id_user', $id_user)
                                ->where("DATE_FORMAT(tanggal, '%m') = ", $bulan)
                                ->where("DATE_FORMAT(tanggal, '%Y') = ", $tahun)
                                ->get('izin')->result_array();
        $data['bulan'] = $bulan;
        $data['tahun'] = $tahun;
        $data['all_bulan'] = bulan();
        return $this->template->load('template', 'list_izin', $data);
    }

    public function export_izin()
    {
        $this->load->library('pdf');
        $id_user = @$this->uri->segment(3) ? $this->uri->segment(3) : $this->session->userdata('id_user');
        $bulan = @$this->input->get('bulan') ? $this->input->get('bulan') : date('m');
        $tahun = @$this->input->get('tahun') ? $this->input->get('tahun') : date('Y');
        $data['user'] = $this->user->find_by('id_user', $id_user, true);
        $data['karyawan'] = $this->karyawan->find($id_user);
        $data['izin'] = $this->db->select('*')
                                ->where('id_user', $id_user)
                                ->where("DATE_FORMAT(tanggal, '%m') = ", $bulan)
                                ->where("DATE_FORMAT(tanggal, '%Y') = ", $tahun)
                                ->get('izin')->result_array();
        $data['bulan'] = $bulan;
        $data['tahun'] = $tahun;
        $data['all_bulan'] = bulan();
        $html_content = $this->load->view('print_izin', $data, true);
        $filename = 'Data Izin ' . $data['karyawan']->nama . ' - ' . bulan($data['bulan']) . ' ' . $data['tahun'] . '.pdf';

        $this->pdf->loadHtml($html_content);

        $this->pdf->set_paper('a4','potrait');
        
        $this->pdf->render();
        $this->pdf->stream($filename, ['Attachment' => 1]);
    }

    public function data_cuti_istimewa($id_user)
    {
        $bulan = @$this->input->get('bulan') ? $this->input->get('bulan') : date('m');
        $tahun = @$this->input->get('tahun') ? $this->input->get('tahun') : date('Y');
        $data['bulan'] = $bulan;
        $data['tahun'] = $tahun;
        $data['all_bulan'] = bulan();
        $id_user = $id_user;
        $data['user'] = $this->user->find_by('id_user', $id_user, true);
        $data['karyawan'] = $this->karyawan->find($id_user);
        $data['cuti'] = $this->db->select('*')
                                ->where('id_user', $id_user)
                                ->where('jenis_cuti', 'istimewa')
                                ->where("DATE_FORMAT(tanggal_mulai, '%m') = ", $bulan)
                                ->where("DATE_FORMAT(tanggal_mulai, '%Y') = ", $tahun)
                                ->get('cuti')->result_array();
        return $this->template->load('template', 'list_cuti_istimewa', $data);
    }

    public function export_cuti_istimewa()
    {
        $this->load->library('pdf');
        $id_user = @$this->uri->segment(3) ? $this->uri->segment(3) : $this->session->userdata('id_user');
        $bulan = @$this->input->get('bulan') ? $this->input->get('bulan') : date('m');
        $tahun = @$this->input->get('tahun') ? $this->input->get('tahun') : date('Y');
        $data['user'] = $this->user->find_by('id_user', $id_user, true);
        $data['karyawan'] = $this->karyawan->find($id_user);
        $data['cuti'] = $this->db->select('*')
                                ->where('id_user', $id_user)
                                ->where('jenis_cuti', 'istimewa')
                                ->where("DATE_FORMAT(tanggal_mulai, '%m') = ", $bulan)
                                ->where("DATE_FORMAT(tanggal_mulai, '%Y') = ", $tahun)
                                ->get('cuti')->result_array();
        $data['bulan'] = $bulan;
        $data['tahun'] = $tahun;
        $data['all_bulan'] = bulan();
        $html_content = $this->load->view('print_cuti_istimewa', $data, true);
        $filename = 'Data Cuti istimewa ' . $data['karyawan']->nama . ' - ' . bulan($data['bulan']) . ' ' . $data['tahun'] . '.pdf';

        $this->pdf->loadHtml($html_content);

        $this->pdf->set_paper('a4','potrait');
        
        $this->pdf->render();
        $this->pdf->stream($filename, ['Attachment' => 1]);
    }

    public function data_cuti_biasa($id_user)
    {
        $bulan = @$this->input->get('bulan') ? $this->input->get('bulan') : date('m');
        $tahun = @$this->input->get('tahun') ? $this->input->get('tahun') : date('Y');
        $data['bulan'] = $bulan;
        $data['tahun'] = $tahun;
        $data['all_bulan'] = bulan();
        $id_user = $id_user;
        $data['user'] = $this->user->find_by('id_user', $id_user, true);
        $data['karyawan'] = $this->karyawan->find($id_user);
        $data['cuti'] = $this->db->select('*')
                                ->where('id_user', $id_user)
                                ->where('jenis_cuti', 'biasa')
                                ->where("DATE_FORMAT(tanggal_mulai, '%m') = ", $bulan)
                                ->where("DATE_FORMAT(tanggal_mulai, '%Y') = ", $tahun)
                                ->get('cuti')->result_array();
        return $this->template->load('template', 'list_cuti_biasa', $data);
    }

    public function export_cuti_biasa()
    {
        $this->load->library('pdf');
        $id_user = @$this->uri->segment(3) ? $this->uri->segment(3) : $this->session->userdata('id_user');
        $bulan = @$this->input->get('bulan') ? $this->input->get('bulan') : date('m');
        $tahun = @$this->input->get('tahun') ? $this->input->get('tahun') : date('Y');
        $data['user'] = $this->user->find_by('id_user', $id_user, true);
        $data['karyawan'] = $this->karyawan->find($id_user);
        $data['cuti'] = $this->db->select('*')
                                ->where('id_user', $id_user)
                                ->where('jenis_cuti', 'biasa')
                                ->where("DATE_FORMAT(tanggal_mulai, '%m') = ", $bulan)
                                ->where("DATE_FORMAT(tanggal_mulai, '%Y') = ", $tahun)
                                ->get('cuti')->result_array();
        $data['bulan'] = $bulan;
        $data['tahun'] = $tahun;
        $data['all_bulan'] = bulan();
        $html_content = $this->load->view('print_cuti_biasa', $data, true);
        $filename = 'Data Cuti Biasa ' . $data['karyawan']->nama . ' - ' . bulan($data['bulan']) . ' ' . $data['tahun'] . '.pdf';

        $this->pdf->loadHtml($html_content);

        $this->pdf->set_paper('a4','potrait');
        
        $this->pdf->render();
        $this->pdf->stream($filename, ['Attachment' => 1]);
    }

    public function konfirmasi_cuti($id_cuti,$id_user)
    {
        $data = [
            'status' => '1',
        ];

        $result = $this->db->update('cuti', $data, ['id_cuti' => $id_cuti]);
        if ($result) {
            $response = [
                'status' => 'success',
                'message' => 'Pengajuan Cuti berhasil dikonfirmasi!'
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Pengajuan Cuti gagal disimpan!'
            ];
        }
        
        $this->session->set_flashdata('response', $response);
        redirect('Absensi/data_cuti_biasa/'.$id_user);
    }

    public function form_izin()
    {
        $id_user = $this->session->id_user;
        $data['user'] = $this->user->find_by('id_user', $id_user, true);
        return $this->template->load('template', 'form_izin', $data);
    }

    public function input_form_izin()
    {
        $bukti=$this->upload_bukti();
        $post = $this->input->post();
        $data = [
            'id_user' => $post['id_user'],
            'tanggal' => $post['tanggal'],
            'alasan' => $post['alasan'],
            'bukti' => $bukti,
        ];

        $result = $this->db->insert('izin', $data);
        if ($result) {
            $response = [
                'status' => 'success',
                'message' => 'Form Izin berhasil disimpan!'
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Form Izin gagal disimpan!'
            ];
        }
        
        $this->session->set_flashdata('response', $response);
        redirect('Absensi/form_izin');
    }

    public function upload_bukti()
    {
        $config = [
            'upload_path' => './assets/img/bukti_izin',
            'allowed_types' => 'gif|jpg|png',
            'file_name' => round(microtime(date('dY')))
        ];

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('bukti')) {
            return 'default.jpg';
        } else {
            $data_foto = $this->upload->data();
            return $data_foto['file_name'];
        }

        
    }

    public function cuti()
    {
        $id_user = $this->session->id_user;
        $data['user'] = $this->user->find_by('id_user', $id_user, true);
        return $this->template->load('template', 'form_cuti', $data);
    }

    public function cuti_istimewa()
    {
        $id_user = $this->session->id_user;
        $data['user'] = $this->user->find_by('id_user', $id_user, true);
        $data['istimewa'] = true;
        return $this->template->load('template', 'form_cuti', $data);
    }

    public function input_form_cuti_istimewa()
    {
        $post = $this->input->post();
        $id_user = $post['id_user'];
        $tgl_pecah = explode('-', $post['tanggal_mulai']);
        $tgl = $post['tanggal_mulai'];
        $tahun = $tgl_pecah[0];
        $get_cuti = $this->db->query("SELECT sum(lama_hari) as lama_hari FROM cuti where id_user='$id_user' and jenis_cuti='istimewa' and tanggal_mulai like '$tahun%'")->row_array();

        if($get_cuti['lama_hari'] >= 6){
            $response = [
                'status' => 'error',
                'message' => 'Batas Cuti sudah maksimal'
            ];
            $this->session->set_flashdata('response', $response);
            redirect('Absensi/cuti');
        }

        $tgl1 = new Datetime($post['tanggal_mulai']);
        $tgl2 = new Datetime($post['tanggal_selesai']);
        $lama_hari = $tgl2->diff($tgl1)->days + 1;

        $cek_cuti = $this->db->query("SELECT * FROM cuti where id_user != '$id_user' and tanggal_mulai='$tgl'")->num_rows();

        if($get_cuti['lama_hari'] + $lama_hari >6){
            $response = [
                'status' => 'error',
                'message' => 'Masa Cuti anda melebihi batas maksimal'
            ];
            $this->session->set_flashdata('response', $response);
            redirect('Absensi/cuti');
        }elseif($cek_cuti >= 3){
            $response = [
                'status' => 'error',
                'message' => 'Mohon maaf cuti tidak boleh melebihi 3 Karyawan dari tanggal tersebut.'
            ];
            $this->session->set_flashdata('response', $response);
            redirect('Absensi/cuti');
        }
        $data = [
            'id_user' => $post['id_user'],
            'tanggal_mulai' => $post['tanggal_mulai'],
            'tanggal_selesai' => $post['tanggal_selesai'],
            'keterangan_cuti' => $post['keterangan_cuti'],
            'lama_hari' => $lama_hari,
            'jenis_cuti' => 'istimewa',
            'status' => '1',
        ];

        $result = $this->db->insert('cuti', $data);
        if ($result) {
            $response = [
                'status' => 'success',
                'message' => 'Form Cuti berhasil disimpan!'
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Form Cuti gagal disimpan!'
            ];
        }
        
        $this->session->set_flashdata('response', $response);
        redirect('Absensi/cuti');
    }

    public function cuti_biasa()
    {
        $id_user = $this->session->id_user;
        $data['user'] = $this->user->find_by('id_user', $id_user, true);
        $data['biasa'] = true;
        $data['karyawan'] = $this->karyawan->find($id_user);
        $data['cuti'] = $this->db->get_where('cuti', ['id_user' => $id_user, 'jenis_cuti' =>'biasa'])->result_array();
        return $this->template->load('template', 'form_cuti', $data);
    }

    public function input_form_cuti_biasa()
    {
        $post = $this->input->post();
        $id_user = $post['id_user'];
        $tgl_pecah = explode('-', $post['tanggal_mulai']);
        $tahun = $tgl_pecah[0];

        $tgl1 = new Datetime($post['tanggal_mulai']);
        $tgl2 = new Datetime($post['tanggal_selesai']);
        $lama_hari = $tgl2->diff($tgl1)->days + 1;

        $data = [
            'id_user' => $post['id_user'],
            'tanggal_mulai' => $post['tanggal_mulai'],
            'tanggal_selesai' => $post['tanggal_selesai'],
            'keterangan_cuti' => $post['keterangan_cuti'],
            'lama_hari' => $lama_hari,
            'jenis_cuti' => 'biasa',
            'status' => '0',
        ];

        $result = $this->db->insert('cuti', $data);
        if ($result) {
            $response = [
                'status' => 'success',
                'message' => 'Form Cuti berhasil disimpan! Silahkan menunggu konfirmasi dari atasan'
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Form Cuti gagal disimpan!'
            ];
        }
        
        $this->session->set_flashdata('response', $response);
        redirect('Absensi/cuti');
    }

    public function detail_absensi()
    {
        $data = $this->detail_data_absen();
        return $this->template->load('template', 'absensi/detail', $data);
    }

    public function rekap_absensi()
    {
        $data = $this->data_rekap_absen();
        return $this->template->load('template', 'absensi/rekap_absensi', $data);
    }

    public function check_absen()
    {
        $now = date('H:i:s');
        $data['jam'] = $this->absensi->get_jam_by_time($now)->num_rows();
        $data['absen'] = $this->absensi->absen_harian_user($this->session->id_user)->num_rows();
        return $this->template->load('template', 'absensi/absen', $data);
    }

    public function absen()
    {
        if (@$this->uri->segment(3)) {
            $keterangan = ucfirst($this->uri->segment(3));
        } else {
            $absen_harian = $this->absensi->absen_harian_user($this->session->id_user)->num_rows();
            $keterangan = ($absen_harian < 2 && $absen_harian < 1) ? 'Masuk' : 'Pulang';
        }

            $data = [
                'tgl' => date('Y-m-d'),
                'waktu' => date('H:i:s'),
                'keterangan' => $keterangan,
                'id_user' => $this->session->id_user
            ];

        


        $get_absen_row = $this->db->get_where('absensi', ['tgl' => $data['tgl'], 'id_user' => $data['id_user'], 'keterangan' => $keterangan] )->num_rows();
        if($get_absen_row > 0){
            $this->session->set_flashdata('response', [
                    'status' => 'error',
                    'message' => 'Anda sudah absen '.$keterangan.' hari ini'
                ]);
            redirect('absensi/detail_absensi');
        }else{
            $result = $this->absensi->insert_data($data);

            if($keterangan == 'Pulang'){
                $get_absen = $this->db->get_where('absensi', ['tgl' => $data['tgl'], 'id_user' => $data['id_user'], 'keterangan' => 'Masuk'] )->row_array();
                $jam_masuk = strtotime($get_absen['waktu']);
                $jam_pulang = strtotime($data['waktu']);
                $waktu_is_akhir = strtotime('17:00:00');

                $menit = ($jam_pulang - $waktu_is_akhir);
                $jml_jam = round($menit/(3600), 2);
                if ($jml_jam > 0){
                    $jml_lembur = round($jml_jam, 2);
                } else {
                    $jml_lembur = 0;
                }

                $kehadiran = 'Hadir';
                $id_user = $this->session->id_user;
                $get_user = $this->db->get_where('users', ['id_user' => $id_user])->row_array();
                $pend_terakhir = $get_user['pendidikan_terakhir'];
                $get_gp = $this->db->get_where('gaji_pokok', ['pendidikan_terakhir' => $pend_terakhir])->row_array();
                $gp = $get_gp['gaji_pokok'];

                if(is_weekend(date('Y-m-d'))){
                    $upah_lembur = (2 * $gp / 173)*$jml_lembur;
                } else {
                    $upah_lembur = (1 * $gp / 173)*$jml_lembur;
                }
                
                $data_rekap = [
                    'tgl' => date('Y-m-d'),
                    'jml_jam' => $jml_jam,
                    'kehadiran' => $kehadiran,
                    'jml_lembur' => $jml_lembur,
                    'upah_lembur' => $upah_lembur,
                    'id_user' => $this->session->id_user
                ];
                $this->db->insert('rekap_absensi', $data_rekap);
            }
            if ($result) {
                $this->session->set_flashdata('response', [
                    'status' => 'success',
                    'message' => 'Absensi berhasil dicatat'
                ]);
            } else {
                $this->session->set_flashdata('response', [
                    'status' => 'error',
                    'message' => 'Absensi gagal dicatat'
                ]);
            }
        redirect('absensi/detail_absensi');
        }
        
    }

    public function absen_pulang()
    {
        $keterangan = 'Pulang';
        $post = $this->input->post();
        $id_user = $post['id_user'];
        $data = [
            'tgl' => $post['tgl'],
            'waktu' => $post['jam_pulang'],
            'keterangan' => 'Pulang',
            'id_user' => $id_user,
        ];
        


        $get_absen_row = $this->db->get_where('absensi', ['tgl' => $data['tgl'], 'id_user' => $data['id_user'], 'keterangan' => $keterangan] )->num_rows();
        if($get_absen_row > 0){
            $this->session->set_flashdata('response', [
                    'status' => 'error',
                    'message' => 'Anda sudah absen '.$keterangan.' hari ini'
                ]);
            redirect('absensi/detail_absensi/'.$id_user);
        }else{
            $result = $this->absensi->insert_data($data);

            if($keterangan == 'Pulang'){
                $get_absen = $this->db->get_where('absensi', ['tgl' => $data['tgl'], 'id_user' => $data['id_user'], 'keterangan' => 'Masuk'] )->row_array();
                $jam_masuk = strtotime($get_absen['waktu']);
                $jam_pulang = strtotime($data['waktu']);
                $waktu_is_akhir = strtotime('17:00:00');

                $menit1 = ($jam_pulang - $jam_masuk);
                $menit = ($jam_pulang - $waktu_is_akhir);
                $jml_jam = round($menit1/(3600), 2);
                $jml_lembur = round($menit/(3600), 2);
                if ($jml_lembur > 0){
                    $jml_lembur = round($jml_jam, 2);
                } else {
                    $jml_lembur = 0;
                }

                $kehadiran = 'Hadir';
                $id_user = $id_user;
                $get_user = $this->db->get_where('users', ['id_user' => $id_user])->row_array();
                $pend_terakhir = $get_user['pendidikan_terakhir'];
                $get_gp = $this->db->get_where('gaji_pokok', ['pendidikan_terakhir' => $pend_terakhir])->row_array();
                $gp = $get_gp['gaji_pokok'];

                if(is_weekend(date('Y-m-d'))){
                    $upah_lembur = (2 * $gp / 173)*$jml_lembur;
                } else {
                    $upah_lembur = (1 * $gp / 173)*$jml_lembur;
                }
                
                $data_rekap = [
                    'tgl' => date('Y-m-d'),
                    'jml_jam' => $jml_jam,
                    'kehadiran' => $kehadiran,
                    'jml_lembur' => $jml_lembur,
                    'upah_lembur' => $upah_lembur,
                    'id_user' => $id_user
                ];
                $this->db->insert('rekap_absensi', $data_rekap);
            }
            if ($result) {
                $this->session->set_flashdata('response', [
                    'status' => 'success',
                    'message' => 'Absensi berhasil dicatat'
                ]);
            } else {
                $this->session->set_flashdata('response', [
                    'status' => 'error',
                    'message' => 'Absensi gagal dicatat'
                ]);
            }
        redirect('absensi/detail_absensi/'.$id_user);
        }
        
    }

    public function export_pdf()
    {
        $this->load->library('pdf');
        $data = $this->detail_data_absen();
        $html_content = $this->load->view('absensi/print_pdf', $data, true);
        $filename = 'Absensi ' . $data['karyawan']->nama . ' - ' . bulan($data['bulan']) . ' ' . $data['tahun'] . '.pdf';

        $this->pdf->loadHtml($html_content);
        $this->pdf->set_paper('a4','potrait');

        
        $this->pdf->render();
        $this->pdf->stream($filename, ['Attachment' => 1]);
    }

    public function export_rekap_pdf()
    {
        $this->load->library('pdf');
        $data = $this->data_rekap_absen();
        $html_content = $this->load->view('absensi/print_rekap_pdf', $data, true);
        $filename = 'Absensi ' . $data['karyawan']->nama . ' - ' . bulan($data['bulan']) . ' ' . $data['tahun'] . '.pdf';

        $this->pdf->loadHtml($html_content);
        $this->pdf->set_paper('a4','landscape');
        
        $this->pdf->render();
        $this->pdf->stream($filename, ['Attachment' => 1]);
    }

    public function export_excel()
    {
            include_once APPPATH . 'third_party/PHPExcel.php';
            $data = $this->detail_data_absen();
            $hari = $data['hari'];
            $absen = $data['absen'];
            $excel = new PHPExcel();

            $excel->getProperties()
                    ->setCreator('IndoExpress')
                    ->setLastModifiedBy('IndoExpress')
                    ->setTitle('Data Absensi')
                    ->setSubject('Absensi')
                    ->setDescription('Absensi' . $data['karyawan']->nama . ' bulan ' . bulan($data['bulan']) . ', ' . $data['tahun'])
                    ->setKeyWords('data absen');

            $style_col = [
                'font' => ['bold' => true],
                'alignment' => [
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                ],
                'borders' => [
                    'top' => ['style' => PHPExcel_Style_Border::BORDER_THIN],
                    'bottom' => ['style' => PHPExcel_Style_Border::BORDER_THIN],
                    'right' => ['style' => PHPExcel_Style_Border::BORDER_THIN],
                    'left' => ['style' => PHPExcel_Style_Border::BORDER_THIN],
                ]
            ];

            $style_row = [
                'alignment' => [
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                ],
                'borders' => [
                    'top' => ['style' => PHPExcel_Style_Border::BORDER_THIN],
                    'bottom' => ['style' => PHPExcel_Style_Border::BORDER_THIN],
                    'right' => ['style' => PHPExcel_Style_Border::BORDER_THIN],
                    'left' => ['style' => PHPExcel_Style_Border::BORDER_THIN],
                ]
            ];

            $style_row_libur = [
                'fill' => [
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => ['rgb' => '343A40']
                ],
                'font' => [
                    'color' => ['rgb' => 'FFFFFF']
                ],
                'alignment' => [
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                ],
                'borders' => [
                    'top' => ['style' => PHPExcel_Style_Border::BORDER_THIN],
                    'bottom' => ['style' => PHPExcel_Style_Border::BORDER_THIN],
                    'right' => ['style' => PHPExcel_Style_Border::BORDER_THIN],
                    'left' => ['style' => PHPExcel_Style_Border::BORDER_THIN],
                ]
            ];

            $style_row_tidak_masuk = [
                'fill' => [
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => ['rgb' => 'DC3545']
                ],
                'font' => [
                    'color' => ['rgb' => 'FFFFFF']
                ],
                'alignment' => [
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                ],
                'borders' => [
                    'top' => ['style' => PHPExcel_Style_Border::BORDER_THIN],
                    'bottom' => ['style' => PHPExcel_Style_Border::BORDER_THIN],
                    'right' => ['style' => PHPExcel_Style_Border::BORDER_THIN],
                    'left' => ['style' => PHPExcel_Style_Border::BORDER_THIN],
                ]
            ];

            $style_telat = [
                'font' => [
                    'color' => ['rgb' => 'DC3545']
                ]
            ];

            $style_lembur = [
                'font' => [
                    'color' => ['rgb' => '28A745']
                ]
            ];

            $excel->setActiveSheetIndex(0)->setCellValue('A1', 'Nama : ' . $data['karyawan']->nama);
            $excel->getActiveSheet()->mergeCells('A1:D1');
            $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
            $excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(12);

            $excel->setActiveSheetIndex(0)->setCellValue('A2', 'Divisi : ' . $data['karyawan']->nama_divisi);
            $excel->getActiveSheet()->mergeCells('A2:D2');
            $excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
            $excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(12);

            $excel->setActiveSheetIndex(0)->setCellValue('A3', '');
            $excel->getActiveSheet()->mergeCells('A3:D3');

            $excel->setActiveSheetIndex(0)->setCellValue('A4', 'Data Absensi Bulan ' . bulan($data['bulan']) . ', ' . $data['tahun']);
            $excel->getActiveSheet()->mergeCells('A4:D4');
            $excel->getActiveSheet()->getStyle('A4')->getFont()->setBold(true);
            $excel->getActiveSheet()->getStyle('A4')->getFont()->setSize(12);

            $excel->setActiveSheetIndex(0)->setCellValue('A5', 'NO');
            $excel->setActiveSheetIndex(0)->setCellValue('B5', 'Tanggal');
            $excel->setActiveSheetIndex(0)->setCellValue('C5', 'Jam Masuk');
            $excel->setActiveSheetIndex(0)->setCellValue('D5', 'Jam Keluar');

            $excel->getActiveSheet()->getStyle('A5')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('B5')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('C5')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('D5')->applyFromArray($style_col);

            $numrow = 6;
            foreach ($hari as $i => $h) {
                $absen_harian = array_search($h['tgl'], array_column($absen, 'tgl')) !== false ? $absen[array_search($h['tgl'], array_column($absen, 'tgl'))] : '';

                $excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, ($i+1));
                $excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $h['hari'] . ', ' . $h['tgl']);
                $excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, is_weekend($h['tgl']) ? 'Libur Akhir Pekan' : check_jam(@$absen_harian['jam_masuk'], 'masuk', true)['text']);
                $excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, is_weekend($h['tgl']) ? 'Libur Akhir Pekan' : check_jam(@$absen_harian['jam_pulang'], 'pulang', true)['text']);

                if (check_jam(@$absen_harian['jam_masuk'], 'masuk', true)['status'] == 'telat') {
                    $excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_telat);
                }

                if (check_jam(@$absen_harian['jam_pulang'], 'pulang', true)['status'] == 'lembur') {
                    $excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style_lembur);
                }

                if (is_weekend($h['tgl'])) {
                    $excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_row_libur);
                    $excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style_row_libur);
                    $excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row_libur);
                    $excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style_row_libur);
                } elseif ($absen_harian == '') {
                    $excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_row_tidak_masuk);
                    $excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style_row_tidak_masuk);
                    $excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row_tidak_masuk);
                    $excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style_row_tidak_masuk);
                } else {
                    $excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_row);
                    $excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style_row);
                    $excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row);
                    $excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style_row);
                }
                $numrow++;
            }

            $excel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
            $excel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
            $excel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
            $excel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
            $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);

            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename="Absensi ' . $data['karyawan']->nama . ' - ' . bulan($data['bulan']) . ' ' . $data['tahun'] . '.xlsx"'); // Set nama file excel nya
            header('Cache-Control: max-age=0');

            $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
            $write->save('php://output');
    }

    public function export_rekap_excel()
    {

            include_once APPPATH . 'third_party/PHPExcel.php';
            $data = $this->data_rekap_absen();
            $hari = $data['hari'];
            $absen = $data['absen'];
            $excel = new PHPExcel();

            $excel->getProperties()
                    ->setCreator('IndoExpress')
                    ->setLastModifiedBy('IndoExpress')
                    ->setTitle('Data Absensi')
                    ->setSubject('Absensi')
                    ->setDescription('Absensi' . $data['karyawan']->nama . ' bulan ' . bulan($data['bulan']) . ', ' . $data['tahun'])
                    ->setKeyWords('data absen');

            $style_col = [
                'font' => ['bold' => true],
                'alignment' => [
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                ],
                'borders' => [
                    'top' => ['style' => PHPExcel_Style_Border::BORDER_THIN],
                    'bottom' => ['style' => PHPExcel_Style_Border::BORDER_THIN],
                    'right' => ['style' => PHPExcel_Style_Border::BORDER_THIN],
                    'left' => ['style' => PHPExcel_Style_Border::BORDER_THIN],
                ]
            ];

            $style_row = [
                'alignment' => [
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                ],
                'borders' => [
                    'top' => ['style' => PHPExcel_Style_Border::BORDER_THIN],
                    'bottom' => ['style' => PHPExcel_Style_Border::BORDER_THIN],
                    'right' => ['style' => PHPExcel_Style_Border::BORDER_THIN],
                    'left' => ['style' => PHPExcel_Style_Border::BORDER_THIN],
                ]
            ];

            $style_row_libur = [
                'fill' => [
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => ['rgb' => '343A40']
                ],
                'font' => [
                    'color' => ['rgb' => 'FFFFFF']
                ],
                'alignment' => [
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                ],
                'borders' => [
                    'top' => ['style' => PHPExcel_Style_Border::BORDER_THIN],
                    'bottom' => ['style' => PHPExcel_Style_Border::BORDER_THIN],
                    'right' => ['style' => PHPExcel_Style_Border::BORDER_THIN],
                    'left' => ['style' => PHPExcel_Style_Border::BORDER_THIN],
                ]
            ];

            $style_row_tidak_masuk = [
                'fill' => [
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => ['rgb' => 'DC3545']
                ],
                'font' => [
                    'color' => ['rgb' => 'FFFFFF']
                ],
                'alignment' => [
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                ],
                'borders' => [
                    'top' => ['style' => PHPExcel_Style_Border::BORDER_THIN],
                    'bottom' => ['style' => PHPExcel_Style_Border::BORDER_THIN],
                    'right' => ['style' => PHPExcel_Style_Border::BORDER_THIN],
                    'left' => ['style' => PHPExcel_Style_Border::BORDER_THIN],
                ]
            ];

            $style_telat = [
                'font' => [
                    'color' => ['rgb' => 'DC3545']
                ]
            ];

            $style_lembur = [
                'font' => [
                    'color' => ['rgb' => '28A745']
                ]
            ];

            $excel->setActiveSheetIndex(0)->setCellValue('A1', 'Nama : ' . $data['karyawan']->nama);
            $excel->getActiveSheet()->mergeCells('A1:H1');
            $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
            $excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(12);

            $excel->setActiveSheetIndex(0)->setCellValue('A2', 'Divisi : ' . $data['karyawan']->nama_divisi);
            $excel->getActiveSheet()->mergeCells('A2:H2');
            $excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
            $excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(12);

            $excel->setActiveSheetIndex(0)->setCellValue('A3', '');
            $excel->getActiveSheet()->mergeCells('A3:H3');

            $excel->setActiveSheetIndex(0)->setCellValue('A4', 'Data Absensi Bulan ' . bulan($data['bulan']) . ', ' . $data['tahun']);
            $excel->getActiveSheet()->mergeCells('A4:H4');
            $excel->getActiveSheet()->getStyle('A4')->getFont()->setBold(true);
            $excel->getActiveSheet()->getStyle('A4')->getFont()->setSize(12);

            $excel->setActiveSheetIndex(0)->setCellValue('A5', 'NO');
            $excel->setActiveSheetIndex(0)->setCellValue('B5', 'Tanggal');
            $excel->setActiveSheetIndex(0)->setCellValue('C5', 'Jam Masuk');
            $excel->setActiveSheetIndex(0)->setCellValue('D5', 'Jam Keluar');
            $excel->setActiveSheetIndex(0)->setCellValue('E5', 'Jumlah Jam');
            $excel->setActiveSheetIndex(0)->setCellValue('F5', 'Kehadiran');
            $excel->setActiveSheetIndex(0)->setCellValue('G5', 'Jam Lembur');
            $excel->setActiveSheetIndex(0)->setCellValue('H5', 'Upah Lembur');

            $excel->getActiveSheet()->getStyle('A5')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('B5')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('C5')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('D5')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('E5')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('F5')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('G5')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('H5')->applyFromArray($style_col);

            $numrow = 6;
            foreach ($absen as $i => $h) {
                $absen_harian = array_search($h['tgl'], array_column($absen, 'tgl')) !== false ? $absen[array_search($h['tgl'], array_column($absen, 'tgl'))] : '';

                $excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, ($i+1));
                $excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $h['tgl']);
                $excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, check_jam(@$absen_harian['jam_masuk'], 'masuk', true)['text']);
                $excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, check_jam(@$absen_harian['jam_pulang'], 'pulang', true)['text']);
                $excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $h['jml_jam'].' Jam');
                $excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $h['kehadiran']);
                $excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $h['jml_lembur'].' Jam');
                $excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, 'Rp '.number_format($h['upah_lembur']),2,',','.');

                $excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($style_row);
                $numrow++;
            }

            $excel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
            $excel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
            $excel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
            $excel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
            $excel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
            $excel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
            $excel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
            $excel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
            $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);

            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename="Absensi ' . $data['karyawan']->nama . ' - ' . bulan($data['bulan']) . ' ' . $data['tahun'] . '.xlsx"'); // Set nama file excel nya
            header('Cache-Control: max-age=0');

            $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
            $write->save('php://output');
    }

    private function detail_data_absen()
    {
        $id_user = @$this->uri->segment(3) ? $this->uri->segment(3) : $this->session->userdata('id_user');
        $bulan = @$this->input->get('bulan') ? $this->input->get('bulan') : date('m');
        $tahun = @$this->input->get('tahun') ? $this->input->get('tahun') : date('Y');
            
        $data['karyawan'] = $this->karyawan->find($id_user);
            $data['absen'] = $this->absensi->get_absen($id_user, $bulan, $tahun);
            $data['jam_kerja'] = (array) $this->jam->get_all();
            $data['all_bulan'] = bulan();
            $data['bulan'] = $bulan;
            $data['tahun'] = $tahun;
            $data['hari'] = hari_bulan($bulan, $tahun);

            return $data;
    }

    private function data_rekap_absen()
    {
            $id_user = @$this->uri->segment(3) ? $this->uri->segment(3) : $this->session->userdata('id_user');
            $bulan = @$this->input->get('bulan') ? $this->input->get('bulan') : date('m');
            $tahun = @$this->input->get('tahun') ? $this->input->get('tahun') : date('Y');
            
            $data['karyawan'] = $this->karyawan->find($id_user);
            $data['absen'] = $this->absensi->rekap_absensi($id_user, $bulan, $tahun);
            $data['jam_kerja'] = (array) $this->jam->get_all();
            $data['all_bulan'] = bulan();
            $data['bulan'] = $bulan;
            $data['tahun'] = $tahun;
            $data['hari'] = hari_bulan($bulan, $tahun);

            return $data;  
        
    }

    public function laporan_absensi()
    {
        $bulan = @$this->input->get('bulan') ? $this->input->get('bulan') : date('m');
        $tahun = @$this->input->get('tahun') ? $this->input->get('tahun') : date('Y');
        $data['bulan'] = $bulan;
        $data['tahun'] = $tahun;
        $data['all_bulan'] = bulan();
        $data['absensi'] = $this->db->get_where('users',['level' => 'Karyawan'])->result_array();
        return $this->template->load('template', 'laporan_absensi', $data);
    }

    public function export_laporan_absensi()
    {
        $this->load->library('pdf');
        $bulan = @$this->input->get('bulan') ? $this->input->get('bulan') : date('m');
        $tahun = @$this->input->get('tahun') ? $this->input->get('tahun') : date('Y');
        $data['bulan'] = $bulan;
        $data['tahun'] = $tahun;
        $data['all_bulan'] = bulan();
        $data['absensi'] = $this->db->get_where('users',['level' => 'Karyawan'])->result_array();
        $html_content = $this->load->view('print_laporan_absensi', $data, true);
        $filename = 'Laporan Absensi Bulan '.$bulan.' '. $tahun . '.pdf';

        $this->pdf->loadHtml($html_content);

        $this->pdf->set_paper('a4','landscape');
        
        $this->pdf->render();
        $this->pdf->stream($filename, ['Attachment' => 1]);
    }
}


/* End of File: d:\Ampps\www\project\absen-pegawai\application\controllers\Absensi.php */