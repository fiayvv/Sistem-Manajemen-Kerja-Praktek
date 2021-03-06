<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class File extends CI_Controller {
	function __construct(){
		parent::__construct();
		if($this->session->userdata('masuk') !=TRUE){
            $url=base_url('administrator');
            redirect($url);
        };
        $this->load->model('m_daftar');
		$this->load->library('upload');
	}

	public function index()
	{
		$nama1 = $this->session->userdata('ses_id');
		$isi['status'] = $this->db->query("SELECT file_id FROM file_siswa WHERE siswa_id = '$nama1'")->num_rows();
		$isi['daftar'] = $this->db->query("SELECT * FROM daftar WHERE siswa_id = '$nama1'")->row_array();
		$isi['proyek'] = $this->db->query("SELECT * FROM proyek WHERE siswa_id = '$nama1'")->row_array();
		$isi['file'] = $this->db->query("SELECT * FROM file_siswa WHERE siswa_id = '$nama1'")->row_array();
		$isi['laporan'] = $this->db->query("SELECT * FROM laporan WHERE siswa_id = '$nama1'")->row_array();
		$this->load->view('depan/file',$isi);
	}

	function simpan(){
				$config['upload_path'] = './asset/file/daftar/'; //path folder
	            $config['allowed_types'] = 'pdf|zip'; //type yang dapat diakses bisa anda sesuaikan
	            $config['max_size'] = 0;
				$config['encrypt_name'] = FALSE;

	            $this->upload->initialize($config);
	            if ($this->upload->do_upload('file1'))
	                {
	                        $data = $this->upload->data();
	                        $file1=$data['file_name'];
				}else{
	                    $this->load->view('mahasiswa/halaman');
	            }

	            $config['upload_path'] = './asset/file/daftar/'; //path folder
	            $config['allowed_types'] = 'pdf|zip'; //type yang dapat diakses bisa anda sesuaikan
	            $config['max_size'] = 0;
				$config['encrypt_name'] = FALSE;

	            $this->upload->initialize($config);
	            if ($this->upload->do_upload('file2'))
	                {
	                        $data = $this->upload->data();
	                        $file2=$data['file_name'];
				}else{
	                    $this->load->view('mahasiswa/halaman');
	            }

	       	$id_admin=strip_tags($this->session->userdata('ses_id'));
	        $nama_file=strip_tags($this->input->post('nama'));
			$status=0;

			$this->m_daftar->simpan_file($id_admin,$file1,$file2,$status);
			echo $this->session->set_flashdata('msg','success');
			redirect('mahasiswa/halaman');		
	}
}