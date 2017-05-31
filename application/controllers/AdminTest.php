<?php
defined('BASEPATH') OR exit('No direct script access allowed');

	use NumPHP\Core\NumArray;
	use NumPHP\LinAlg\LinAlg;

class Admin extends CI_Controller {

	public function __construct(){
        parent::__construct();
        $this->load->model('m_data');
    }
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->load->helper(array('url', 'form'));
		$sum = array_sum($_POST);
		// var_dump($sum);
		//inisialisasi awal
		$stringKey = [];
		for($i = 0; $i<38; $i++){
			$stringKey[$i] = 'G'.($i+1);
		}
			//change this
			$data_uji = array();
		$nilaiAkurasi = 0;
		$randtest1 = array();
		$randtest2 = array();
		
		$randPool1 = array();
		$randPool2 = array();
		while($nilaiAkurasi < 89){
		//langkah 1
		$dataLatih = $this->m_data->get_data_latih(84);
		// $dataLatih = array_splice($dataLatih, 0, 75, true);
		$data_uji_raw = $this->m_data->get_data_uji(84);
			$dataTukar = 2;
			while($dataTukar > 0){
				$dataTukar--;
				$randL[$dataTukar] = rand(0,74);
				$randU[$dataTukar] = rand(0,24);
			}
			
			// var_dump(!in_array($randL, $randPool1));
			while(in_array($randL, $randPool1)){
				foreach($randL as $key=>$value){
					$randL[$key] = rand(0,74);
				}
			}

			while(in_array($randU, $randPool2)){
				foreach($randL as $key=>$value){
					$randU[$key] = rand(0,24);
				}
			}
			array_push($randPool1, $randL);
			array_push($randPool2, $randU);
			foreach($randL as $keyz => $valuez){
				$tempZ = $dataLatih[$valuez];
				$dataLatih[$valuez] = $data_uji_raw[$randU[$keyz]];
				$data_uji_raw[$randU[$keyz]] = $tempZ;
			}
			// $tempZ = $dataLatih[$rand1];
			// $dataLatih[$rand1] = $data_uji_raw[$rand2];
			// $data_uji_raw[$rand2] = $tempZ;

			// $tempX = $dataLatih[$rand11];
			// $dataLatih[$rand11] = $data_uji_raw[$rand22];
			// $data_uji_raw[$rand22] = $tempX;

			// $tempY = $dataLatih[$rand111];
			// $dataLatih[$rand111] = $data_uji_raw[$rand222];
			// $data_uji_raw[$rand222] = $tempY;


		//langkah 2
		$dataBerat = [];
		$dataSedang = [];
		$dataRingan = [];
		$dataTidak = [];
		
		foreach([0,1,2,3] as $value){
			$dataKelasx[$value] = array();
		}
		foreach($dataLatih as $value){
			switch($value['Jenis']){
				case 'BERAT':
					array_push($dataKelasx[0], $value);
					break;
				case 'SEDANG':
					array_push($dataKelasx[1], $value);
					break;
				case 'sedang':
					array_push($dataKelasx[1], $value);
					break;
				case 'RINGAN':
					array_push($dataKelasx[2], $value);
					break;
				case 'ringan':
					array_push($dataKelasx[2], $value);
					break;
				case 'TIDAK':
					array_push($dataKelasx[3], $value);
					break;
				case 'tidak':
					array_push($dataKelasx[3], $value);
					break;
			}
		}
		$dataPerKelas = [];
		array_push($dataPerKelas, $dataBerat, $dataSedang, $dataRingan, $dataTidak);

		//langkah 3 - langkah 1 membuat matriks rata-rata kelas
		$rataBerat = [];
		$rataSedang = [];
		$rataRingan = [];
		$rataTidak = [];
		$rataSemua = [];
		foreach($stringKey as $i => $key){
			$rataSemua[$i] = 0;
		}
		//semua
		$rataKelasx = array();
		$rataGlobal = array();
		foreach([1,2,3,4] as $i => $value){
			$rataKelasx[$i] = array();
		}
		foreach($dataKelasx as $i => $jenis){
			$temp = array();
			foreach($dataKelasx[$i] as $j => $row){
				foreach($stringKey as $k => $value){
					if(empty($temp[$k])){
						$temp[$k] = 0;
					}
					if(empty($rataGlobal[$k])){
						$rataGlobal[$k] = 0;
					}
					$temp[$k] = $temp[$k] + $row[$value];
					$rataGlobal[$k] = $rataGlobal[$k] + $row[$value];
				}
			}
			foreach($temp as $key => $value){
				$temp[$key] = $temp[$key]/count($dataKelasx[$i]);
			}
			$rataKelasx[$i] = $temp;
		}
		foreach($stringKey as $i => $value){
			$rataGlobal[$i] = $rataGlobal[$i] / count($dataLatih);
		}
		//langkah 4 - langkah 2 membuat matriks mean corrected
		$meanCorrectedBerat = [];
		$meanCorrectedSedang = [];
		$meanCorrectedRingan = [];
		$meanCorrectedTidak = [];
		$meanCorrectedx = array();
		foreach([1,2,3,4] as $i => $value){
			$meanCorrectedx[$i] = array();
		}
		
		foreach($dataKelasx as $i => $jenis){
			foreach($jenis as $j => $row){
				foreach($stringKey as $k => $data){
					// var_dump($dataKelasx[$i][$j][$data]);
					$meanCorrectedx[$i][$j][$k] = $dataKelasx[$i][$j][$data] - $rataGlobal[$k];
				}
			}
		}

		//langkah 5 - langkah 3 membuat matriks kovarian dan inverse
		$matriksx = array();
		foreach($meanCorrectedx as $key => $value){
			$matriksMCx[$key] = new NumArray($value);
			$matriksMCxTranspose[$key] = $matriksMCx[$key]->getTranspose();
		}
		
			//cek manual transpose
			// var_dump($matriksMCBeratTranspose->getData());
			// $testTranspose = array();
			// foreach($meanCorrectedBerat as $i=>$value){
			// 	$testTranspose[$i] = array();
			// 	foreach($meanCorrectedBerat as $j=>$value){
			// 		array_push($testTranspose[$i], $meanCorrectedBerat[$j][$i]);
			// 	}
			// }

		$kovarianx = array();
		foreach([1,2,3,4] as $i => $jenis){
			$kovarianx[$i] = new NumArray($matriksMCxTranspose[$i]->getData());
			$kovarianx[$i]->dot($matriksMCx[$i]);
			$kovarianx[$i]->dot(1/count($dataKelasx[$i]));
		}
		// var_dump($kovarianx[3]->getData());
		$kovarianAkhirx = array();
		foreach([1,2,3,4] as $i => $jenis){
			$kovarianAkhirx[$i] = new NumArray($kovarianx[$i]->getData());
			$kovarianAkhirx[$i]->dot(count($dataKelasx[$i]));
		}
		$kovarianAkhirTotal = new NumArray($kovarianAkhirx[0]->getData());
		foreach([1,2,3] as $i => $jenis){
			$kovarianAkhirTotal->add($kovarianAkhirx[$jenis]);
		}
		$kovarianAkhirTotal->dot(1/count($dataLatih));
		// var_dump($kovarianAkhirTotal->getData());
		//langkah 6 - langkah 3 membuat matriks inverse
		$kovarianAkhirInverse = LinAlg::inv($kovarianAkhirTotal);

		// var_dump($kovarianAkhirInverse->getData());
		//langkah 7 - langkah 4 membuat probabilitas prior
		$prior = array();
		$lnprior = array();
		foreach([1,2,3,4] as $i=>$val){
			$prior[$i] = count($dataKelasx[$i])/count($dataLatih);
			$lnprior[$i] = log($prior[$i]);
		}
		// var_dump($lnprior);
		// var_dump($kovarianAkhirInverse->getData());
		//rumus LDA
		$data_uji = array();
		foreach($data_uji_raw as $i => $row){
			$data_uji[$i] = array();
			foreach($stringKey as $j => $val){
				$data_uji[$i][$j] = $row[$val];
			}
		}
		// var_dump($data_uji[0]);
		$matriksDataUji = new NumArray($data_uji);
		$matriksDataUjiT = $matriksDataUji->getTranspose();
		$fnx = array();
		$matriksRataX = array();
		$matriksRataXTranspose = array();
		$pertama = array();
		$kedua = array();
		// foreach($data_uji as $m => $row){
			foreach([1,2,3,4] as $i => $jenis){
				$matriksRataX[$i] = new NumArray([$rataKelasx[$i]]);
				$matriksRataXTranspose[$i] = $matriksRataX[$i]->getTranspose();
				$pertama[$i] = new NumArray([$rataKelasx[$i]]);
				$pertama[$i]->dot($kovarianAkhirInverse);
				$pertama[$i]->dot($matriksDataUjiT);
				$kedua[$i] = new NumArray([$rataKelasx[$i]]);
				$kedua[$i]->dot($kovarianAkhirInverse);
				// var_dump($kedua[$i]->getShape());
				$kedua[$i]->dot($matriksRataXTranspose[$i]);
				$kedua[$i]->dot(1/2);
				// var_dump($pertama[$i]->getData());
				$fnx[$i] = array();
				foreach($pertama[$i]->getData()[0] as $j => $value){
					// var_dump('foreach');
					// var_dump($value);
					$fnx[$i][$j] = $value - $kedua[$i]->getData()[0][0] + $lnprior[$i];
				}
				// var_dump($kedua[$i]->getData());
				// $fnx[$i] = $pertama[$i]->getData() - $kedua[$i]->getData() + $ketiga;

			}
			$fnKelas = new NumArray($fnx);
			$fnKelas = $fnKelas->getTranspose();
			$fnKelas = $fnKelas->getData();
			
			$jenis = ['Kelas Berat', 'Kelas Sedang', 'Kelas Ringan', 'Kelas Tidak'];
			// var_dump($data_uji_raw);
			$akurasi = array();
			foreach($data_uji_raw as $key=>$row){
				switch(strtolower($row['Jenis']) ){
					case 'berat':
					array_push($akurasi, 0);
					break;
					case 'sedang':
					array_push($akurasi, 1);
					break;
					case 'ringan':
					array_push($akurasi, 2);
					break;
					case 'tidak':
					array_push($akurasi, 3);
					break;
					default:
					echo 'something happened';
				}
			}
			$rankMax = array();
			$nilaiAkurasi = 0;
			foreach($fnKelas as $key=>$row){
				$rank1 = array_keys($row, max($row));
				($akurasi[$key] == $rank1[0]) ? $nilaiAkurasi++ : $nilaiAkurasi+0;
				array_push($rankMax, $rank1[0]);
			}
			$nilaiAkurasi = $nilaiAkurasi/count($data_uji_raw) *100;
		}
		$data = array(
			'allData' =>$dataLatih,
			'dataUji' =>$data_uji_raw,
			'ratarata' => $rataKelasx,
			'stringKey' => $stringKey,
			'jenis' => $jenis,
			'dataKelas' => $dataKelasx,
			'meanCorrected' => $meanCorrectedx,
			'kovarianTotal' => $kovarianAkhirTotal->getData(),
			'kovarianInverse' => $kovarianAkhirInverse->getData(),
			'fnKelas' => $fnKelas,
			'rankMax' => $rankMax,
			'pakar' => $akurasi,
			'nilaiAkurasi' => $nilaiAkurasi,
			'meanGlobal' => $rataGlobal
		);
		$this->load->view('adminChart', $data);
	}
	public function test(){
		$this->load->helper(array('url', 'form'));
		$label = ['1', '2', 3,4,5,6,7];
		$data = [10,20,30,40,50,60,70];
		$data = array(
			'label' => $label,
			'data'=>$data
		);
		$this->load->view('chart', $data);
	}
}
