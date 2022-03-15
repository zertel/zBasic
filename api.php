<?Php session_start();ob_start();
/*

BU SAYFA sitenin api isteklerine cevap verir

*/

// Gerekli kütüphaneleri ve varsayılan ayarları yükle
require(__DIR__.'/ayar.php');

// istenilen sayfayı sayfa klasöründen import eder
if(preg_match('/^[a-z_]{4,32}$/', z(8,'s') )){

	switch (z(8,'s')) {
		case 'deneme':
			echo 'api çalıştı';
			break;
		
		default:
			_z(8,'s');
			break;
	}
}

// çıktıyı JSON olarak istersek
header("Content-Type: application/json; charset=utf-8");
//echo json_encode( !empty($_S[$_GET['s']]) ? $_S[$_GET['s']] : $_S['s1'] );*/
ob_end_flush();
?>

