<?php
defined('BASEPATH') OR exit('No direct script access allowed');


	use NumPHP\Core\NumArray;
	use NumPHP\LinAlg\LinAlg;
	use Underscore\Types\Arrays;

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
		
		$data_uji = array();
		$nilaiAkurasi = 0;
		$nilaiAkurasiArray = array();
		$randtest1 = array();
		$randtest2 = array();
		
		$randPool1 = array();
		$randPool2 = array();
		$ulangan1 = 0;
		$ulangan2 = 1;
		$dataSemua = array();
		foreach([0,1,2,3,4] as $ulang){
		$dataSemua[$ulang] = array();
		//langkah 1
		$dataLatih = $this->m_data->get_data_latih(88);
		$data_uji_raw = $this->m_data->get_data_uji(88);

		//langkah 2
		$dataBerat = [];
		$dataSedang = [];
		$dataRingan = [];
		$dataTidak = [];
		
		foreach([0,1,2,3] as $value){
			$dataKelasx[$value] = array();
		}
		foreach($dataLatih as $value){
			switch(strtolower($value['Jenis'])){
				case 'berat':
					array_push($dataKelasx[0], $value);
					break;
				case 'sedang':
					array_push($dataKelasx[1], $value);
					break;
				case 'ringan':
					array_push($dataKelasx[2], $value);
					break;
				case 'tidak':
					array_push($dataKelasx[3], $value);
					break;
			}
		}
		//kurangin data latih
		foreach($dataKelasx as $key=>$value){
			// shuffle($dataKelasx[$key]);
			// array_splice($dataKelasx[$key], count($dataKelasx[$key])-$ulangan);
		}
			array_splice($dataKelasx[0], count($dataKelasx[0])-$ulangan1);
			array_splice($dataKelasx[3], count($dataKelasx[3])-$ulangan1);
			array_splice($dataKelasx[1], count($dataKelasx[1])-($ulangan2-1));
			array_splice($dataKelasx[2], count($dataKelasx[2])-($ulangan2-1));
		$ulangan1 += 2;
		$ulangan2 += 3;
		
		$dataLatih = array();
		foreach($dataKelasx as $row){
			foreach($row as $value){
				array_push($dataLatih, $value);
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
		$jumlah_keseluruhan = 0;
		foreach($dataKelasx as $key => $value){
			$jumlah_keseluruhan = $jumlah_keseluruhan + count($value);
		}

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
		$kovarianAkhirTotal->dot(1/$jumlah_keseluruhan);
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
			
			array_push($nilaiAkurasiArray, $nilaiAkurasi);
			array_push($dataSemua[$ulang], $dataLatih); //0
			array_push($dataSemua[$ulang], $rataKelasx); //1
			array_push($dataSemua[$ulang], $dataKelasx); //2
			array_push($dataSemua[$ulang], $meanCorrectedx); //3
			array_push($dataSemua[$ulang], $kovarianAkhirTotal->getData()); //4
			array_push($dataSemua[$ulang], $kovarianAkhirInverse->getData()); //5
			array_push($dataSemua[$ulang], $fnKelas); //6
			array_push($dataSemua[$ulang], $rankMax); //7
			array_push($dataSemua[$ulang], $nilaiAkurasi); //8
			array_push($dataSemua[$ulang], $rataGlobal); //9
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
			'meanGlobal' => $rataGlobal,
			'nilaiAkurasiArray' => $nilaiAkurasiArray,
			'dataSemua' => $dataSemua
		);
		$this->load->view('adminData', $data);
	}
	public function testSkripsi(){
		$dataLatih = $this->m_data->get_data_latih(88);
		$data_uji_raw = $this->m_data->get_data_uji(88);
		$dataKelasx = $this->pemisahan_kelas($dataLatih);
		$jenis = ['Kelas Berat', 'Kelas Sedang', 'Kelas Ringan', 'Kelas Tidak'];
		// $dataKelasx = $this->pengujian2($dataKelasx, $val);
		// var_dump($data_uji_raw);
		var_dump($dataKelasx );
		
	}

	public function dataSeimbang(){
		$this->load->helper(array('url', 'form'));
		$sum = array_sum($_POST);
		//inisialisasi awal
		$nilaiAkurasiArray = array();
		$dataSemua = array();
		$jenis = ['Kelas Berat', 'Kelas Sedang', 'Kelas Ringan', 'Kelas Tidak'];

		foreach([11] as $ulang=>$val){
			$dataSemua[$ulang] = array();
			$stringKey = [];
			for($i = 0; $i<38; $i++){
				$stringKey[$i] = 'G'.($i+1);
			}
			
			//langkah 1
			

			$datanya = $this->m_data->get_data_latih_array();
			// var_dump($datanya);
			// $mom = $this->pemisahan_kelas($datanya);
			// var_dump($mom);
			// $hapusin = [10, 14, 21, 22, 32, 51, 59, 62, 63, 66, 79, 85, 90];
			// for($i=0; $i<count($hapusin); $i++){
			// 	array_splice($datanya, $hapusin[$i]-$i, 1);
			// }
			$dataLatih = $datanya;
			// $data_uji_raw = $datanya;
			
			// $dataLatih = $this->m_data->get_data_latih(88);
			// $data_uji_raw = $this->m_data->get_data_uji(88);

			// $data_uji_raw = $this->m_data->get_data_latih(88);
			// var_dump($dataLatih);
			//langkah 2
			$dataKelasx = $this->pemisahan_kelas($dataLatih);

			//pengujian 2
			$dataKelasx = $this->pengujian2($dataKelasx, 11); //11 - 9
			// var_dump($dataLatih);
			$dataLatih = $this->pengujian3($dataKelasx);
			$data_uji_raw = $this->pengujian3($dataKelasx);
			// $rre = $this->pengujian3($dataKelasx);
			// var_dump($rre);
			//langkah 3 - langkah 1 membuat matriks rata-rata kelas
			$rataKelasx = $this->rata_perkelas($dataKelasx, $stringKey);
			$rataGlobal = $this->rata_global($dataKelasx, $stringKey);

			//langkah 4 - langkah 2 membuat matriks mean corrected
			$meanCorrectedx = $this->mean_corrected($dataKelasx, $stringKey, $rataGlobal);
			
			//langkah 5 - langkah 3 membuat matriks kovarian dan inverse
			$kovarianAkhirTotal = $this->matriks_kovarian($meanCorrectedx, $dataKelasx, $dataLatih);
			
			//langkah 6 - langkah 3 membuat matriks inverse
			$kovarianAkhirInverse = LinAlg::inv($kovarianAkhirTotal);
			
			//langkah 7 - langkah 4 membuat probabilitas prior
			$prior = array();
			$lnprior = array();
			foreach([1,2,3,4] as $i=>$val){
				$prior[$i] = count($dataKelasx[$i])/count($dataLatih);
				$lnprior[$i] = log($prior[$i]);
			}
			//rumus lda
			$fnKelas = $this->fnKelas($data_uji_raw, $stringKey, $rataKelasx, $kovarianAkhirInverse, $lnprior)[0];
			// $fnKelas = $this->fnKelas2($data_uji_raw, $stringKey, $rataKelasx, $kovarianAkhirInverse, $lnprior, $dataKelasx)[0];
			// $nilaiAkurasi = $this->lda_based($data_uji_raw, $stringKey, $rataKelasx, $kovarianAkhirInverse, $lnprior)[1];

			$rankMax = $this->lda_based($fnKelas, $data_uji_raw)[0];
			$nilaiAkurasi = $this->lda_based($fnKelas, $data_uji_raw)[1];
			$pakar = $this->pakarMatriks($data_uji_raw);

			array_push($dataSemua[$ulang], $dataLatih); //0
			array_push($dataSemua[$ulang], $rataKelasx); //1
			array_push($dataSemua[$ulang], $dataKelasx); //2
			array_push($dataSemua[$ulang], $meanCorrectedx); //3
			array_push($dataSemua[$ulang], $kovarianAkhirTotal->getData()); //4
			array_push($dataSemua[$ulang], $kovarianAkhirInverse->getData()); //5
			array_push($dataSemua[$ulang], $fnKelas); //6
			array_push($dataSemua[$ulang], $rankMax); //7
			array_push($dataSemua[$ulang], $nilaiAkurasi); //8
			array_push($dataSemua[$ulang], $rataGlobal); //9
		}
		$data = array(
			'dataSemua' => $dataSemua,
			'dataUji' => $data_uji_raw,
			'stringKey' => $stringKey,
			'jenis' => $jenis,
			'pakar' => $pakar
		);

		$this->load->view('adminData', $data);
	}

	public function mom(){
		$dataLatih = $this->m_data->get_data_latih(88);
		echo json_encode($dataLatih);
	}

	public function testAjax(){
		$this->load->helper(array('url', 'form'));
		$this->load->view('testAjax');
	}

	public function pemisahan_kelas($dataLatih){
		$dataKelasx = array();
		foreach([0,1,2,3] as $value){
			$dataKelasx[$value] = array();
		}
		foreach($dataLatih as $value){
			switch(strtolower($value['Jenis'])){
				case 'berat':
					array_push($dataKelasx[0], $value);
					break;
				case 'sedang':
					array_push($dataKelasx[1], $value);
					break;
				case 'ringan':
					array_push($dataKelasx[2], $value);
					break;
				case 'tidak':
					array_push($dataKelasx[3], $value);
					break;
			}
		}
		return $dataKelasx;
	}

	public function rata_perkelas($dataKelasx, $stringKey){
		$rataKelasx = array();
		$rataGlobal = array();
		foreach([1,2,3,4] as $i => $value){
			$rataKelasx[$i] = array();
		}
		$jumlahAll = 0;
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
				$jumlahAll++;
			}
			foreach($temp as $key => $value){
				$temp[$key] = $temp[$key]/count($dataKelasx[$i]);
			}
			$rataKelasx[$i] = $temp;
		}
		foreach($stringKey as $i => $value){
			$rataGlobal[$i] = $rataGlobal[$i] / $jumlahAll;
		}
		return $rataKelasx;
	}
	
	public function rata_global($dataKelasx, $stringKey){
		$rataGlobal = array();
		$jumlahAll = 0;
		foreach($dataKelasx as $i => $jenis){
			foreach($dataKelasx[$i] as $j => $row){
				foreach($stringKey as $k => $value){
					if(empty($rataGlobal[$k])){
						$rataGlobal[$k] = 0;
					}
					$rataGlobal[$k] = $rataGlobal[$k] + $row[$value];
				}
				$jumlahAll++;
			}
		}
		foreach($stringKey as $i => $value){
			$rataGlobal[$i] = $rataGlobal[$i] / $jumlahAll;
		}
		return $rataGlobal;
	}

	public function mean_corrected($dataKelasx, $stringKey, $rataGlobal){
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
		// var_dump($meanCorrectedx);
		return $meanCorrectedx;
	}

	public function matriks_kovarian($meanCorrectedx, $dataKelasx, $dataLatih){
		$matriksx = array();
		$jumlah_keseluruhan = 0;
		foreach($dataKelasx as $key => $value){
			$jumlah_keseluruhan = $jumlah_keseluruhan + count($value);
		}
		// var_dump($jumlah_keseluruhan);
		foreach($meanCorrectedx as $key => $value){
			$matriksMCx[$key] = new NumArray($value);
			$matriksMCxTranspose[$key] = $matriksMCx[$key]->getTranspose();
		}

		$kovarianx = array();
		foreach([1,2,3,4] as $i => $jenis){
			$kovarianx[$i] = new NumArray($matriksMCxTranspose[$i]->getData());
			$kovarianx[$i]->dot($matriksMCx[$i]);
			$kovarianx[$i]->dot(1/count($dataKelasx[$i]));
		}
		// var_dump($kovarianx);
		$kovarianAkhirx = array();
		foreach([1,2,3,4] as $i => $jenis){
			$kovarianAkhirx[$i] = new NumArray($kovarianx[$i]->getData());
			$kovarianAkhirx[$i]->dot(count($dataKelasx[$i]));
		}
		// var_dump($kovarianAkhirx);
		$kovarianAkhirTotal = new NumArray($kovarianAkhirx[0]->getData());
		foreach([1,2,3] as $i => $jenis){
			$kovarianAkhirTotal->add($kovarianAkhirx[$jenis]);
		}
		$kovarianAkhirTotal->dot(1/$jumlah_keseluruhan);
		// var_dump($kovarianAkhirTotal);
		return $kovarianAkhirTotal;
	}

	public function fnKelas2($data_uji_raw, $stringKey, $rataKelasx, $kovarianAkhirInverse, $lnprior, $dataKelasx){
		$data_uji = array();
		// var_dump($dataKelasx);
		// var_dump($data_uji_raw);
		foreach($data_uji_raw as $i => $row){
			$data_uji[$i] = array();
			foreach($stringKey as $j => $val){
				// var_dump($row);
				$data_uji[$i][$j] = $row[$val];
			}
		}
		// var_dump($data_uji);
		$databanyak = 0;
		foreach($dataKelasx as $i=>$row){
			$data_uji[$databanyak] = array();
			foreach($stringKey as $j => $val){
				var_dump($j);
				$data_uji[$databanyak][$j] = $row[$val];
			}
		}
		// var_dump($dataKelasx);
		// var_dump($data_uji);
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
			
			return array($fnKelas);
	}
	public function fnKelas($data_uji_raw, $stringKey, $rataKelasx, $kovarianAkhirInverse, $lnprior){
		$data_uji = array();
		foreach($data_uji_raw as $i => $row){
			$data_uji[$i] = array();
			foreach($stringKey as $j => $val){
				$data_uji[$i][$j] = $row[$val];
			}
		}
		// var_dump($data_uji);
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
			
			return array($fnKelas);
	}
	public function lda_based($fnKelas, $data_uji_raw){
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
		return array($rankMax, $nilaiAkurasi);
	}

	public function pakarMatriks($data_uji_raw){
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
		return $akurasi;
	}
	public function pengujian2($dataKelasx, $pembagi){
		foreach($dataKelasx as $key=>$val){
			$dataKelasx[$key] = $this->kurangin($val,$pembagi);
		}
		return $dataKelasx;
	}
	public function pengujian3($dataKelasx){
		$balikin = [];
		$i = 0;
		foreach($dataKelasx as $key => $val){
			foreach($val as $kkey =>  $vval){
				$balikin[$i] = $vval;
				$i++;
			}
		}
		return $balikin;
	}
	public function kurangin($data_perkelas, $pembagi){
		$size = sizeOf($data_perkelas);
		$sizeBagi = floor($size/$pembagi);
		$batasBawah = 0;
		$batasAtas = $pembagi;
		$data_return = array();
		for($i=$batasAtas; $i>=$batasBawah; $i--){
			$data_return[] = $data_perkelas[$i];
		}
		return $data_return;
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
