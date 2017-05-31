<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class m_data extends CI_Model {
	
	public function get_data_latih_array(){
		$query = " SELECT * FROM data_latih";
		$data_latih = $this->db->query($query)->result_array();
		return $data_latih;
	}
	public function get_data_latih75_array(){
		$query = " SELECT * FROM data_latih75";
		$data_latih = $this->db->query($query)->result_array();
		return $data_latih;
	}
	public function get_data_uji25_array(){
		$query = " SELECT * FROM data_uji25";
		$data_latih = $this->db->query($query)->result_array();
		return $data_latih;
	}
	public function get_data_latih_array64(){
		$query = " SELECT * FROM latih_64";
		$data_latih = $this->db->query($query)->result_array();
		return $data_latih;
	}
	public function get_data_uji_array64(){
		$query = " SELECT * FROM uji_64";
		$data_latih = $this->db->query($query)->result_array();
		return $data_latih;
	}
	public function get_data_latih_array76(){
		$query = " SELECT * FROM latih_76";
		$data_latih = $this->db->query($query)->result_array();
		return $data_latih;
	}
	public function get_data_uji_array76(){
		$query = " SELECT * FROM uji_76";
		$data_latih = $this->db->query($query)->result_array();
		return $data_latih;
	}
	public function get_data_latih($acc){
		$query = " SELECT * FROM latih_".$acc;
		$data_latih = $this->db->query($query)->result_array();
		return $data_latih;
	}
	public function get_data_uji($acc){
		$query = " SELECT * FROM uji_".$acc;
		$data_latih = $this->db->query($query)->result_array();
		return $data_latih;
	}
}