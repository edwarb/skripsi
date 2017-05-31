<?php

	use NumPHP\Core\NumArray;
	use NumPHP\LinAlg\LinAlg;

class Home extends CI_Controller {

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
	public function index(){
		$this->load->helper(array('url', 'form'));
		$this->load->view('index');
	}
	
	public function tabel(){
		$this->load->helper(array('url', 'form'));
		// $this->load->view('header');
		$this->load->view('tabel');
	}
	public function form(){
		$this->load->helper(array('url', 'form'));
		$text = array_map('str_getcsv', file('pert2.csv'));
		$pertanyaan = array();
		foreach($text as $key=>$row){
			foreach($row as $value){
				array_push($pertanyaan, $value);
			}
		}
		$data = array("pertanyaan"=>$pertanyaan);
		// $this->load->view('header');
		$this->load->view('radio', $data);
	}
	public function jawaban(){
		var_dump($_POST);
	}

public function hasil(){

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
			foreach($_POST as $val){
				array_push($data_uji, $val);
			}
		//langkah 1
		$dataLatih = $this->m_data->get_data_latih_array();

		//langkah 2
		$dataBerat = [];
		$dataSedang = [];
		$dataRingan = [];
		$dataTidak = [];
		foreach($dataLatih as $value){
			switch($value['Jenis']){
				case 'BERAT':
					array_push($dataBerat, $value);
					break;
				case 'SEDANG':
					array_push($dataSedang, $value);
					break;
				case 'RINGAN':
					array_push($dataRingan, $value);
					break;
				case 'TIDAK':
					array_push($dataTidak, $value);
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
		
		//berat
		foreach($dataBerat as $key => $value){
			foreach($stringKey as $i => $val){
				if(empty($rataBerat[$i])){
					$rataBerat[$i] = 0;
				}
				$rataBerat[$i] = $rataBerat[$i] + $value[$val];
			}
		}
		foreach($rataBerat as $key => $value){
			$rataSemua[$key] = $rataSemua[$key] + $value;
			$rataBerat[$key] = $value/count($dataBerat);
		}

		//sedang
		foreach($dataSedang as $key => $value){
			foreach($stringKey as $i => $val){
				if(empty($rataSedang[$i])){
					$rataSedang[$i] = 0;
				}
				$rataSedang[$i] = $rataSedang[$i] + $value[$val];
			}
		}
		foreach($rataSedang as $key => $value){
			$rataSemua[$key] = $rataSemua[$key] + $value;
			$rataSedang[$key] = $value/count($dataSedang);
		}

		//ringan
		foreach($dataRingan as $key => $value){
			foreach($stringKey as $i => $val){
				if(empty($rataRingan[$i])){
					$rataRingan[$i] = 0;
				}
				$rataRingan[$i] = $rataRingan[$i] + $value[$val];
			}
		}
		foreach($rataRingan as $key => $value){
			$rataSemua[$key] = $rataSemua[$key] + $value;
			$rataRingan[$key] = $value/count($dataRingan);
		}
		
		//tidak
		foreach($dataTidak as $key => $value){
			foreach($stringKey as $i => $val){
				if(empty($rataTidak[$i])){
					$rataTidak[$i] = 0;
				}
				$rataTidak[$i] = $rataTidak[$i] + $value[$val];
			}
		}
		foreach($rataTidak as $key => $value){
			$rataSemua[$key] = $rataSemua[$key] + $value;
			$rataTidak[$key] = $value/count($dataTidak);
		}
		
		foreach($stringKey as $i => $key){
			$rataSemua[$i] = $rataSemua[$i]/100;
		}

		//langkah 4 - langkah 2 membuat matriks mean corrected
		$meanCorrectedBerat = [];
		$meanCorrectedSedang = [];
		$meanCorrectedRingan = [];
		$meanCorrectedTidak = [];

		//Berat
		foreach($dataBerat as $i => $value){
			foreach($stringKey as $j => $string){
				$meanCorrectedBerat[$i][$j] = $dataBerat[$i][$string] - $rataSemua[$j];
			}
		}

		//Sedang
		foreach($dataSedang as $i => $value){
			foreach($stringKey as $j => $string){
				$meanCorrectedSedang[$i][$j] = $dataSedang[$i][$string] - $rataSemua[$j];
			}
		}

		//Ringan
		foreach($dataRingan as $i => $value){
			foreach($stringKey as $j => $string){
				$meanCorrectedRingan[$i][$j] = $dataRingan[$i][$string] - $rataSemua[$j];
			}
		}

		//Tidak
		foreach($dataTidak as $i => $value){
			foreach($stringKey as $j => $string){
				$meanCorrectedTidak[$i][$j] = $dataTidak[$i][$string] - $rataSemua[$j];
			}
		}
		
			

		//langkah 5 - langkah 3 membuat matriks kovarian dan inverse
		$matriksMCBerat = new NumArray($meanCorrectedBerat);
		$matriksMCSedang = new NumArray($meanCorrectedSedang);
		$matriksMCRingan = new NumArray($meanCorrectedRingan);
		$matriksMCTidak = new NumArray($meanCorrectedTidak);

		$matriksMCBeratTranspose = $matriksMCBerat->getTranspose();
		$matriksMCSedangTranspose = $matriksMCSedang->getTranspose();
		$matriksMCRinganTranspose = $matriksMCRingan->getTranspose();
		$matriksMCTidakTranspose = $matriksMCTidak->getTranspose();

			//cek manual transpose
			// var_dump($matriksMCBeratTranspose->getData());
			// $testTranspose = array();
			// foreach($meanCorrectedBerat as $i=>$value){
			// 	$testTranspose[$i] = array();
			// 	foreach($meanCorrectedBerat as $j=>$value){
			// 		array_push($testTranspose[$i], $meanCorrectedBerat[$j][$i]);
			// 	}
			// }
		
		$kovarianBerat = new NumArray($matriksMCBeratTranspose->getData());
		$kovarianBerat->dot($matriksMCBerat);
		$kovarianBerat->dot(1/count($dataBerat));

		$kovarianSedang = new NumArray($matriksMCSedangTranspose->getData());
		$kovarianSedang->dot($matriksMCSedang);
		$kovarianSedang->dot(1/count($dataSedang));

		$kovarianRingan = new NumArray($matriksMCRinganTranspose->getData());
		$kovarianRingan->dot($matriksMCRingan);
		$kovarianRingan->dot(1/count($dataRingan));

		$kovarianTidak = new NumArray($matriksMCTidakTranspose->getData());
		$kovarianTidak->dot($matriksMCTidak);
		$kovarianTidak->dot(1/count($dataTidak));

			//kovarian akhir
			$kovarianAkhirBerat = new NumArray($kovarianBerat->getData());
			$kovarianAkhirBerat->dot(count($dataBerat));

			$kovarianAkhirSedang = new NumArray($kovarianSedang->getData());
			$kovarianAkhirSedang->dot(count($dataSedang));

			$kovarianAkhirRingan = new NumArray($kovarianRingan->getData());
			$kovarianAkhirRingan->dot(count($dataRingan));

			$kovarianAkhirTidak = new NumArray($kovarianTidak->getData());
			$kovarianAkhirTidak->dot(count($dataTidak));

			// var_dump($kovarianAkhirTidak->getData());
			$kovarianAkhir = new NumArray(0);
			$kovarianAkhir->add($kovarianAkhirBerat);
			$kovarianAkhir->add($kovarianAkhirSedang);
			$kovarianAkhir->add($kovarianAkhirRingan);
			$kovarianAkhir->add($kovarianAkhirTidak);
			$kovarianAkhir->dot(1/count($dataLatih));
			
		//langkah 6 - langkah 3 membuat matriks inverse
		$kovarianAkhirInverse = LinAlg::inv($kovarianAkhir);

		//langkah 7 - langkah 4 membuat probabilitas prior
		$priorBerat = count($dataBerat)/count($dataLatih);
		$priorSedang = count($dataSedang)/count($dataLatih);
		$priorRingan = count($dataRingan)/count($dataLatih);
		$priorTidak = count($dataTidak)/count($dataLatih);

		$lnBerat = log($priorBerat);
		$lnSedang = log($priorSedang);
		$lnRingan = log($priorRingan);
		$lnTidak = log($priorTidak);
		
		// var_dump($kovarianAkhirInverse->getData());
		//rumus LDA
		$matriksDataUji = new NumArray($data_uji);
			//fn Berat
			$fnBerat = 0;
			$matriksRataBerat = new NumArray([$rataBerat]);
			$matriksRataBeratTranspose = $matriksRataBerat->getTranspose();
			$pertama = new NumArray([$rataBerat]);
			$matriksDataUjiTranspose = $matriksDataUji->getTranspose();
			$pertama->dot($kovarianAkhirInverse);
			$pertama->dot($matriksDataUjiTranspose);
			$kedua = new NumArray([$rataBerat]);
			$kedua->dot($kovarianAkhirInverse);
			$kedua->dot($matriksRataBeratTranspose);
			$kedua->dot(1/2);
			$ketiga = log(count($dataBerat)/count($dataLatih));
			$fnBerat = $pertama->getData()[0] - $kedua->getData()[0][0] + $ketiga;
			//fn Sedang
			$fnSedang = 0;
			$matriksRataSedang = new NumArray([$rataSedang]);
			$matriksRataSedangTranspose = $matriksRataSedang->getTranspose();
			$pertama = new NumArray([$rataSedang]);
			$matriksDataUjiTranspose = $matriksDataUji->getTranspose();
			$pertama->dot($kovarianAkhirInverse);
			$pertama->dot($matriksDataUjiTranspose);
			$kedua = new NumArray([$rataSedang]);
			$kedua->dot($kovarianAkhirInverse);
			$kedua->dot($matriksRataSedangTranspose);
			$kedua->dot(1/2);
			$ketiga = log(count($dataSedang)/count($dataLatih));
			$fnSedang = $pertama->getData()[0] - $kedua->getData()[0][0] + $ketiga;
			//fn Ringan
			$fnRingan = 0;
			$matriksRataRingan = new NumArray([$rataRingan]);
			$matriksRataRinganTranspose = $matriksRataRingan->getTranspose();
			$pertama = new NumArray([$rataRingan]);
			$matriksDataUjiTranspose = $matriksDataUji->getTranspose();
			$pertama->dot($kovarianAkhirInverse);
			$pertama->dot($matriksDataUjiTranspose);
			$kedua = new NumArray([$rataRingan]);
			$kedua->dot($kovarianAkhirInverse);
			$kedua->dot($matriksRataRinganTranspose);
			$kedua->dot(1/2);
			$ketiga = log(count($dataRingan)/count($dataLatih));
			$fnRingan = $pertama->getData()[0] - $kedua->getData()[0][0] + $ketiga;
			//fn Tidak
			$fnTidak = 0;
			$matriksRataTidak = new NumArray([$rataTidak]);
			$matriksRataTidakTranspose = $matriksRataTidak->getTranspose();
			$pertama = new NumArray([$rataTidak]);
			$matriksDataUjiTranspose = $matriksDataUji->getTranspose();
			$pertama->dot($kovarianAkhirInverse);
			$pertama->dot($matriksDataUjiTranspose);
			$kedua = new NumArray([$rataTidak]);
			$kedua->dot($kovarianAkhirInverse);
			$kedua->dot($matriksRataTidakTranspose);
			$kedua->dot(1/2);
			$ketiga = log(count($dataTidak)/count($dataLatih));
			$fnTidak = $pertama->getData()[0] - $kedua->getData()[0][0] + $ketiga;

		$indeks = ['berat', 'sedang', 'ringan', 'tidak'];

		$allfn = array($fnBerat, $fnSedang, $fnRingan, $fnTidak);
		//persentase
		// var_dump($allfn);
		$totalAllFn = array_sum($allfn);
		$percent = array(
			$fnBerat/$totalAllFn *100,
			$fnSedang/$totalAllFn *100,
			$fnRingan/$totalAllFn *100,
			$fnTidak/$totalAllFn *100
		);
		foreach($percent as $i=>$value){
			$percent[$i] = number_format($value, 2, '.', '');
		}
		$indexMaxRank = array_search(max($allfn), $allfn);
		
		$data = array(
			'allData' =>$dataLatih,
			'rank1' => $indexMaxRank,
			'string' => $stringKey,
			'allfn' => $allfn,
			'percent' => $percent
		);
		// $data = array('rank1'=> $indexMaxRank);
		$this->load->view('tabel', $data);

	}

	public function some(){
		$this->load->helper(array('url', 'form'));
		$text = array_map('str_getcsv', file('pert2.csv'));
		$pertanyaan = array();
		foreach($text as $key=>$row){
			foreach($row as $value){
				array_push($pertanyaan, $value);
			}
		}
		$data = array("pertanyaan"=>$pertanyaan);
		$this->load->view('header');
		$this->load->view('form', $data);
	}
	public function test(){
		$this->load->helper(array('url', 'form'));
		$text = array_map('str_getcsv', file('pert2.csv'));
		
		var_dump($text);
	}
}
