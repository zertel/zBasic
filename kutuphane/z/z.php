<?Php
function z($a=NULL,$b=NULL,$c=NULL,$d=NULL){
	
	if(is_array($a)){
		if(is_array($c)){
			if((!empty($b)||$b=='0')&&(!empty($d)||$d=='0')){
				return !empty($c[$a[$b]][$d])?$c[$a[$b]][$d]:'';
			}
		}
		else if(!empty($b)||$b=='0'){
			if(empty($c)){
				return !empty($a[$b])?$a[$b]:'';
			}
			else if(is_string($c)){
				$x=NULL;
				if($c=='sayi'){
					if(empty($d))$d=2;
					else if($d>1000){$x=1;$d-=1000;}
				}
				return !empty($a[$b])?z($c,$a[$b],$d,$x):'';
			}
		}
	}

	static 
	$con=array(),
	$ini=array('oturum_oe'=>'z_','cerez_oe'=>'z_','cerez_sure'=>2600000,'default_time'=>'Europe/Istanbul','date'=>'Y-m-d','datetime'=>'Y-m-d H:i:s','tarih'=>'d.m.Y','tarihsaat'=>'d.m.Y H:i','saat'=>'H:i','tarihsaniye'=>'d.m.Y H:i:s','gunay'=>'d.m','gun'=>'d','ay'=>'m','yil'=>'Y','t_low'=>false,'ayr_t'=>'ayar','id_stl'=>'id','dil'=>'tr',
		'ekle_etiket_temizle'=>true, 'ekle_izinli_etiket'=>'<br>,<b>,<strong>,<u>,<i>,<span>,<h1>,<h2>,<h3>,<h4>,<h5>,<h6>,<p>,<div>,<main>,<section>,<article>,<ul>,<ol>,<li>',
		'aylar_ekli'=>array('','Ocağın','Şubatın','Martın','Nisanın','Mayısın','Haziranın','Temmuzun','Ağustosun','Eylülün','Ekimin','Kasımın','Aralığın'),
		'gun_eki'=>array('','inde','sinde','ünde','ünde','inde','sında','sinde','inde','unda','unda',
							'inde','sinde','ünde','ünde','inde','sında','sinde','inde','unda','sinde',
							'inde','sinde','ünde','ünde','inde','sında','sinde','inde','unda','unda',
						'inde')
	),
	$z=array('oku','ekle','guncelle','sil','say','tablo','post','get','value','file','session','cookie','lgn','lgna','ini','date','datetime','host','sw','do','de','ds','dl','ke','ks','rb','ra','ze','za','tarih','tarihsaat','url','durum','sifrele','tarihsaniye','sayi','gurupla','sorgucikar','getyonet','birlestir','git','maskele','sutunlar','form','yukle','ayar','icerik','dizigurupla','metin','yenidendiz','gunay','gun','ay','yil','ayingununde','buyukharf','saat','kardesgrupla','keyvaluedizilimi','cokludil','keysizoku','keysizsorgudetay');
	
	$snc=NULL;
			

	switch($a){
		// VERİTABANI SORGULARI
		case 1: case $z[0]:
			$sd='';$tek=0;if(!empty($b)){
				if(is_numeric($b)){
					$sd="WHERE ".$ini['id_stl']."='".$b."' LIMIT 1";$tek++;
				}
				else if(is_array($b) && is_string(key($b))){
					$sdx='';
					if(!empty($b['GROUP'])){
						$sdx.=' GROUP '.str_replace(array("'",'"','`'),'',$b['GROUP']);
						unset($b['GROUP']);
					}
					if(!empty($b['ORDER'])){
						$sdx.=' ORDER '.str_replace(array("'",'"','`'),'',$b['ORDER']);
						unset($b['ORDER']);
					}
					if(!empty($b['LIMIT'])){
						$sdx.=' LIMIT '.str_replace(array("'",'"','`'),'',$b['LIMIT']);
						unset($b['LIMIT']);
					}

					
					$_SDQ=array();
					if(count($b)){
						foreach ($b as $k=>$v) {
							if(!empty($sd)){
								$sd.=' AND';
							}
							if(is_array($v)){

								if(is_string($v[0])){
									switch ($v[0]) {
										case 'IN':
											$inSd='';
											foreach ($v[1] as $vi=>$vv) {
												if(!empty($inSd)){
													$inSd.=',';
												}
												$inSd.=':'.$k.$vi;
												$_SDV[$k.$vi]=$vv;	
											}
											$sd.=" `".$k."` IN (".(!empty($inSd)?$inSd:'0').")";
											break;
										
										default:
											$sd.=" `".$k."` ".$v[0]." :".$k;
											$_SDV[$k]=$v[1];	
											break;
									}
								}
								else if(is_array($v[0])){
									foreach ($v as $vi=>$vv) {
										if($vi>0){
											$sd.=" AND";	
										}
										$sd.=" `".$k."` ".$vv[0]." :".$k.$vi;
										$_SDV[$k.$vi]=$vv[1];
									}
								}

							}
							else {				
								$sd.=" ".$k."=:".$k;
								$_SDV[$k]=$v;
							}
						}
					}
					$sd=!empty($sd)?'WHERE'.$sd:'';
					$sd.=$sdx;
				}
				else if($b=='son'){
					$sd="ORDER BY ".$c." DESC LIMIT 1";$tek++;
				}
				else{
					$sd=$b;
				}
			}
			if(empty($c)){
				$c='*';
			}
			else if(strpos($c,',')===false){
				$tek+=2;
			}
			if(!empty($d)){
				z(6,$d);
			}
			$srg="SELECT ".$c." FROM ".$con['vt'].".".$con['oe'].$con['t']." ".$sd.";";
			if($tek==3){
				$pre=$GLOBALS['pdo']->prepare($srg);
				$pre->execute();
				$snc=$pre->fetchColumn();
			}
			else if($tek==2){
				$pre=$GLOBALS['pdo']->prepare($srg);
				$pre->execute();
				foreach( $pre->fetchAll(PDO::FETCH_NUM) as $x){
					if(empty($snc)){
						$snc=Array();
					}
					$snc[]=$x[0];
				}
			}
			else if($tek==1){
				$pre=$GLOBALS['pdo']->prepare($srg);
				$pre->execute();
				$snc=$pre->fetch(PDO::FETCH_ASSOC);
			}
			else{
				$pre=$GLOBALS['pdo']->prepare($srg);
				if(!empty($_SDV)){
					$pre->execute($_SDV);
				}
				else{
					$pre->execute();
				}
				foreach($pre->fetchAll(PDO::FETCH_ASSOC) as $x){
					if(empty($snc)){
						$snc=Array();
					}
					$snc[]=$x;
				}
			}
			return $snc;
		break;
		case 2: case $z[1]:
			if(!empty($b))require(__DIR__.'/e.php');
		break;
		case 3: case $z[2]:
			if(!empty($c))require(__DIR__.'/g.php');
		break;
		case 4: case $z[3]:
			if(!empty($b))require(__DIR__.'/s.php');
		break;
		case 5: case $z[4]:
			require(__DIR__.'/c.php');
		break;
		case 6: case $z[5]:
			if(!empty($b)){if(!empty($ini['t_low']))$b=strtolower($b);$con['t']=$b;}else $snc=!empty($con['t'])?$con['t']:'';
		break;
		case'con':
			require(__DIR__.'/cn.php');
		break;
		case'ayr':
			if(!empty($ini['ayr_t'])){$xat=z(6);if(empty($b)||is_array($b)){$_X=z(1,NULL,NULL,$ini['ayr_t']);if(!empty($_X)){foreach($_X as $x)$b[$x['ad']]=$x['a']+$x['s']+$x['m'];}$snc=$b;}else if(is_string($b)){z(6,$ini['ayr_t']);$x=array('a'=>0,'s'=>0,'m'=>'');$x[empty($d)?'m':$d]=$c;$snc=z(3,"WHERE ad='".$b."'",$x);}z(6,$xat);}
		break;
		
		
		// FORM, ÇEREZ ve OTURUM VERİLERİ
		case 7: case $z[6]:
			if(!empty($b)){
				if(!empty($_POST[$b]) && is_array($_POST[$b])){
					$snc=$_POST[$b];
					if(!empty($c)){
						foreach ($snc as $key => $val) {
							if(!empty($val) && is_string($val) && !preg_match('/^'.(is_string($c)?$c:$c[$key]).'$/', $val)){
								$snc[$key]='';
							}
						}
					}
				}
				else if(!empty($_POST[$b]) && is_string($_POST[$b])){
					if(empty($c) || preg_match('/^'.(is_string($c)?$c:$c[$b]).'$/', $_POST[$b])){
						$snc=$_POST[$b];
					}
					else{
						$snc='';
					}
				}
			}
			else{
				$snc=$_POST;
				if(!empty($c)){
					foreach ($snc as $key => $val) {
						if(!empty($val) && is_string($val) && (is_array($c) && !empty($c[$key])) && !preg_match('/^'.(is_string($c)?$c:$c[$key]).'$/', $val)){
							$snc[$key]='';
						}
					}
				}
			}
		break;
		case 8: case $z[7]:
			if(!empty($b)){if(!empty($_GET[$b])){if(empty($c))$snc=$_GET[$b];else if($c=='sayi') $snc=z(36,$_GET[$b]);}}else{$snc=$_GET;}
		break;
		case 9: case $z[8]:
			if(!empty($b)){if(!empty($_POST[$b]))$snc=$_POST[$b];else if(!empty($_GET[$b]))$snc=$_GET[$b];else $snc=$c;}else $snc=array_merge($_POST,$_GET);
		break;
		case 10: case $z[9]:
			require(__DIR__.'/ff.php');
		break;
		case 11: case $z[10]:
			if(!empty($b)){if($c!==NULL){if($c!==''){$_SESSION[$ini['oturum_oe'].$b]=$c;}else{unset($_SESSION[$ini['oturum_oe'].$b]);}}else{if(!empty($_SESSION[$ini['oturum_oe'].$b])){$snc=$_SESSION[$ini['oturum_oe'].$b];}}}else $snc=$_SESSION;
		break;
		case 12: case $z[11]:
			if(!empty($b)){if($c!==NULL){setcookie($ini['cerez_oe'].$b,json_encode($c),time()+$ini['cerez_sure']);}else{if(!empty($_COOKIE[$ini['cerez_oe'].$b])){$snc=json_decode($_COOKIE[$ini['cerez_oe'].$b],1);}}}else $snc=$_COOKIE;
		break;
		case 13: case $z[12]:
			$lgnx=z(11,'lgn');if(!empty($b)&&is_string($b)&&!empty($lgnx[$b]))return $lgnx[$b];
			else if($b===NULL&&!empty($lgnx))return true;
			require(__DIR__.'/lgn.php');
		break;
		case 14: case $z[13]:
			if(!empty($b))require(__DIR__.'/lgna.php');else $snc=$ini['lgna'];
		break;
		
		
		// AYARLAR ve SABİTLER
		case 15: case $z[14]:
			require(__DIR__.'/ini.php');
		break;
		case 16: case $z[15]:
			if(empty($b))$snc=date($ini['date']);else $snc=date($ini['date'],strtotime($b));
		break;
		case 17: case $z[16]:
			if(empty($b))$snc=date($ini['datetime']);else $snc=date($ini['datetime'],strtotime($b));
		break;
		case 18: case $z[17]:
			$snc=$_SERVER['HTTP_HOST'];
		break;
		case 19: case $z[18]:
			if(!empty($b))$snc=!empty($_SERVER[$b])?$_SERVER[$b]:NULL;else $snc=$_SERVER;
		break;
		
		
		// DOSYA ve KLASÖRLER
		case 20: case $z[19]:
			if(!empty($b))require(__DIR__.'/do.php');
		break;
		case 21: case $z[20]:
			if(!empty($b))require(__DIR__.'/de.php');
		break;
		case 22: case $z[21]:
			if(!empty($b))require(__DIR__.'/ds.php');
		break;
		case 23: case $z[22]:
			require(__DIR__.'/dl.php');
		break;
		case 24: case $z[23]:
			if(!empty($b))require(__DIR__.'/ke.php');
		break;
		case 25: case $z[24]:
			if(!empty($b))require(__DIR__.'/ks.php');
		break;
		
		
		// ARAÇLAR ve AYARLARI
		case 26: case $z[25]:
		break;
		case 27: case $z[26]:
		break;
		case 28: case $z[27]:
		break;
		case 29: case $z[28]:
		break;
		
		
		// MİNİ FONKSİYONLAR
		case 30: case $z[29]:
			$b=!empty($b)?strtotime($b):time();$snc=date(!empty($c)?$c:$ini['tarih'],$b);
		break;
		case 31: case $z[30]:
			$b=!empty($b)?strtotime($b):time();$snc=date($ini['tarihsaat'],$b);
		break;
		case 32: case $z[31]:
			$b=empty($b)?'.':$b=urlencode($b);if($b=='geri')$b=z(19,'HTTP_REFERER');if(empty($c))$snc=$b;else{if(is_array($c))require(__DIR__.'/url.php');else $snc=$b.$c;}
		break;
		case 33: case $z[32]:
			if(!empty($b))if(!empty($c))z(11,$b,$c);else{$snc=z(11,$b);z(11,$b,'');}
		break;
		case 34: case $z[33]:
			if(!empty($b)){$x1=Array(0,1,2,3,4,5,6,7,8,9);$x2=Array('d','e','x','r','g','c','o','v','y','w');if(!empty($c)){$snc=str_replace($x2,$x1,substr($b,20));if(substr($b,0,20)!=substr(md5($snc),0,20))$snc=NULL;}else $snc=substr(md5($b),0,20).str_replace($x1,$x2,$b);}
		break;
		case 35: case $z[34]:
			$b=!empty($b)?strtotime($b):time();$snc=date($ini['tarihsaniye'],$b);
		break;
		case 36: case $z[35]:  //sayi
			if(empty($d))return !empty($c)?str_replace('.',',',round($b,$c)):(!empty($b)?(float)str_replace(array(',','%','₺','$','€','£'),array('.','','','','',''),$b):0);else{$b=str_replace(',','.',number_format((float)$b,$c));$x=strlen($b);if($b[$x-$c-1]=='.')$b[$x-$c-1]=',';if($c>2)if($b[$x-1]=='0')$b[$x-1]='';return $b;}
		break;
		case 37: case $z[36]:  //gurupla
			if(!empty($b)){if(empty($c))$c=$ini['id_stl'];$x=array();if(empty($d)){foreach($b as $y)$x[$y[$c]]=$y;}else if(is_string($d)) foreach($b as $y)$x[$y[$c]]=$y[$d]; else foreach($b as $y)$x[]=$y[$c];return $x;}
		break;
		case 38: case $z[37]:  //sorgucikar
			if(!empty($b)){if(empty($c))$c=$ini['id_stl'];if(empty($d))$d=$ini['id_stl'];$x='';$v=array();foreach($b as $y){if(!in_array($y[$c], $v)){$v[]=$y[$c];if(!empty($x))$x.=' OR ';$x.=$d."='".(!empty($y[$c])?$y[$c]:'')."'";}}return '('.$x.')';}
		break;
		case 39: case $z[38]:  //getyonet
			if(!empty($b)){if(empty($c))$_QS=explode('&',$_SERVER['QUERY_STRING']);if(!empty($_QS))foreach($_QS as $fe){$exp=explode('=',$fe);if(!empty($exp[0])&&$exp[1]){if(!isset($b[$exp[0]])){$b[$exp[0]]=$exp[1];}}}return http_build_query($b);}
		break;
		case 40: case $z[39]:  //birlestir
			$x=array();if(!empty($b)&&is_array($b)&&count($b))foreach($b as $k=>$v)$x[$k]=$v;if(!empty($c)&&is_array($c)&&count($c))foreach($c as $k=>$v)$x[$k]=$v;if(!empty($d)&&is_array($d)&&count($d))foreach($d as $k=>$v)$x[$k]=$v;return $x;
		break;
		case 41: case $z[40]:  //git
			if(!empty($b)){if(is_array($b))header('location: ?'.z(39,$b)); else if($b=='geri'){ header('location: '.z(19,'HTTP_REFERER')); } else if($b=='yenile'){ header('location: '.z(19,'REQUEST_URI')); } else header('location: '.$b);die;}
		break;
		case 42: case $z[41]:  //maskele
			if(!empty($c))preg_match_all("'{{(.*?)}}'si",$c,$m);if(!empty($m)){$aln=implode(',',$m[1]);$x=z(1,$b,$aln,$d);if(!empty($x)){if(!is_numeric($b)&&$b!='son')foreach($x as $fe)$snc.=str_replace($m[0],$fe,$c);else $snc=str_replace($m[0],$x,$c);}}
		break;
		case 43: case $z[42]:  //sutunlar
			if(!empty($b)){z(6,$b);}$srg="SHOW COLUMNS FROM ".$con['vt'].".".$con['oe'].$con['t'].";";$q=$GLOBALS['pdo']->prepare($srg);$q->execute();$snc=$q->fetchAll(PDO::FETCH_ASSOC);
		break;
		case 44: case $z[43]: //form
			if(!empty($b))require(__DIR__.'/form.php');
		break;
		case 45: case $z[44]: //yukle
			if(!empty($c))require(__DIR__.'/yukle.php');
		break;
		case 46: case $z[45]: //ayar
			if(!empty($b))require(__DIR__.'/ayar.php');
		break;
		case 47: case $z[46]: //icerik
			static $_Icerik,$iceriki=0;
			if(empty($b))$b=++$iceriki;
			if(empty($c))$c=$GLOBALS['SA'];
			if(!empty($c)){
				if(empty($_Icerik[$c])){
					$xtbl=z(6);
					$_Icerik[$c]=z(37,z(1,"WHERE sayfa='".$c."'",'ad,icerik','icerik'),'ad');
					z(6,$xtbl);
				}
				if(empty($_Icerik[$c][$b]['icerik'])){
					$xtbl=z(6);
					if(z(2,array(
						'sayfa'=>$c,
						'ad'=>$b,
						'icerik'=>$c.' sayfasının '.$b.'. içeriği'
					),'icerik')){
						$_Icerik[$c][$b]['icerik']=$c.' sayfasının '.$b.'. içeriği';
					}
					z(6,$xtbl);
				}
				if(!empty($_Icerik[$c][$b]['icerik'])){
					$snc=$_Icerik[$c][$b]['icerik'];
				}
			}
		break;
		case 48: case $z[47]:  //dizigurupla
			if(!empty($b)){if(empty($c))$c=$ini['id_stl'];$x=array();if(empty($d)){
				foreach($b as $y){
					if(empty($x[$y[$c]])) $x[$y[$c]]=array();
					$x[$y[$c]][]=$y;
				}
			}else if(is_string($d)) foreach($b as $y){
				if(empty($x[$y[$c]])) $x[$y[$c]]=array();
				$x[$y[$c]][]=$y[$d];
			} else foreach($b as $y)$x[]=$y[$c];
			return $x;}
		break;
		case 49: case $z[48]:  //metin
			$snc=str_replace("
", '<br>', $b);
		break;
		case 50: case $z[49]: //yenidendiz (dizi postu gruplar)
			$x=array();
			if(!empty($b)&&!empty($c)){
				$c=key($b);
				if(!empty($b[$c])){
					$d=key($b[$c]);
					if(!is_numeric($d)){
						foreach ($b as $k1=>$v1) {
							if(!isset($x[$k1])){
								$x[$k1]=array();
							}
							foreach ($b[$c][$d] as $i=>$v) {
								if(!isset($x[$k1][$i])){
									$x[$k1][$i]=array();
								}
								foreach ($v1 as $k2=>$v2) {
									if(!isset($x[$k1][$i][$k2])){
										$x[$k1][$i][$k2]=$b[$k1][$k2][$i];
									}
								}
							}
						}
					}
				}
			}
			else if(!empty($b)){
				$c=key($b);
				foreach ($b[$c] as $i=>$v) {
					if(!isset($x[$i])){
						$x[$i]=array();
					}
					foreach ($b as $k1=>$v1) {
						if(!isset($x[$i][$k1])){
							$x[$i][$k1]=$b[$k1][$i];
						}
					}
				}
			}
			if(!empty($x)){
				$snc=$x;
			}
		break;
		case 51: case $z[50]: // gunay
			$b=!empty($b)?strtotime($b):time();$snc=date($ini['gunay'],$b);
		break;
		case 52: case $z[51]: // gun
			$b=!empty($b)?strtotime($b):time();$snc=date($ini['gun'],$b);
		break;
		case 53: case $z[52]: // ay
			$b=!empty($b)?strtotime($b):time();$snc=date($ini['ay'],$b);
		break;
		case 54: case $z[53]: // yil
			$b=!empty($b)?strtotime($b):time();$snc=date($ini['yil'],$b);
		break;
		case 55: case $z[54]: // ayingununde
			$b=!empty($b)?strtotime($b):time();
			$xay=date('n',$b);
			$xgun=date('j',$b);
			$snc=$ini['aylar_ekli'][$xay].'&nbsp;'.$xgun.'\''.$ini['gun_eki'][$xgun];
		break;
		case 56: case $z[55]:
			if(!empty($b)){
				$buyukharf=array("İ","I","Ü","Ğ","Ş","Ö","Ç");
				$kucukharf=array("i","ı","ü","ğ","ş","ö","ç");
				$snc=strtoupper(str_replace($kucukharf,$buyukharf,$b));
			}
		break;
		case 57: case $z[56]:
			$b=!empty($b)?strtotime($b):time();$snc=date($ini['saat'],$b);
		break;
		case 58: case $z[57]: // kardesgrupla
			// $_YeniDizi=z( 58, $_Dizi, array('iplikno_ID','nesne_IDmarka','lot') );
			if(!empty($b) && !empty($c) ){
				if(count($c)==3){
					$x=array();
					foreach ($b[$c[0]] as $fei=>$fed) {
						if(!isset($x[$fed])){
							$x[$fed]=array();
						}
						if(isset($b[$c[1]][$fei])){
							if(!isset($x[$fed][ $b[$c[1]][$fei] ])){
								$x[$fed][ $b[$c[1]][$fei] ]=array();
							}
							$x[$fed][ $b[$c[1]][$fei] ][] = $b[$c[2]][$fei];
						}
					}
					$snc=$x;
				}
				else if(count($c)==4){
					$x=array();
					foreach ($b[$c[0]] as $fei=>$fed) {
						if(!isset($x[$fed])){
							$x[$fed]=array();
						}
						if(isset($b[$c[1]][$fei])){
							if(!isset($x[$fed][ $b[$c[1]][$fei] ])){
								$x[$fed][ $b[$c[1]][$fei] ]=array();
							}

							if(isset($b[$c[2]][$fei])){
								if(!isset($x[$fed][ $b[$c[1]][$fei] ][ $b[$c[2]][$fei] ])){
									$x[$fed][ $b[$c[1]][$fei] ][ $b[$c[2]][$fei] ]=array();
								}
								$x[$fed][ $b[$c[1]][$fei] ][ $b[$c[2]][$fei] ][] = !empty($b[$c[3]][$fei])?$b[$c[3]][$fei]:'';
							}
						}
					}
					$snc=$x;
				}
			}
		break;
		case 59: case $z[58]: // keyvaluedizilimi
			if(!empty($b) && !empty($c) && !empty($d) ){
				$x=array();
				foreach ($b as $fed) {
					if(!empty($fed[$c])){
						$x[$fed[$c]]=$fed[$d];
					}
				}
				$snc=$x;
			}
		break;
		case 60: case $z[59]: // cokludil
			if(!empty($b) ){
				if(empty($d)){
					$d=z(6);
				}
				if(empty($c)){
					$c=z('ini','dil');
				}
				$b=z(37,$b);
				$b_tr=z(1,"WHERE ".z(38,$b,'id',$d.'_id'),'',$d.'_'.$c);
				if(!empty($b_tr)){
					foreach ($b_tr as $btr) {
						if(!empty($b[$btr[$d.'_id']])){
							$btrId=$btr[$d.'_id'];
							unset($btr[$d.'_id']);
							$b[$btrId]=array_merge($b[$btrId],$btr);
						}
					}
				}
				$snc=$b;
			}
		break;


		case 61: case $z[60]: // keysizoku
			$sd='';
			$_SDV=array();
			if(!empty($b) && is_array($b) && is_string(key($b))){
				$sdx='';
				if(!empty($b['GROUP'])){
					$sdx.=' GROUP '.str_replace(array("'",'"','`'),'',$b['GROUP']);
					unset($b['GROUP']);
				}
				if(!empty($b['ORDER'])){
					$sdx.=' ORDER '.str_replace(array("'",'"','`'),'',$b['ORDER']);
					unset($b['ORDER']);
				}
				if(!empty($b['LIMIT'])){
					$sdx.=' LIMIT '.str_replace(array("'",'"','`'),'',$b['LIMIT']);
					unset($b['LIMIT']);
				}

				$_SDQ=array();
				if(count($b)){
					foreach ($b as $k=>$v) {
						if(!empty($sd)){
							$sd.=' AND';
						}
						if(is_array($v)){

							if(is_string($v[0])){
								switch ($v[0]) {
									case 'IN':
										$inSd='';
										foreach ($v[1] as $vi=>$vv) {
											if(!empty($inSd)){
												$inSd.=',';
											}
											$inSd.=':'.$k.$vi;
											$_SDV[$k.$vi]=$vv;	
										}
										$sd.=" `".$k."` IN (".(!empty($inSd)?$inSd:'0').")";
										break;
									
									default:
										$sd.=" `".$k."` ".$v[0]." :".$k;
										$_SDV[$k]=$v[1];	
										break;
								}
							}
							else if(is_array($v[0])){
								foreach ($v as $vi=>$vv) {
									if($vi>0){
										$sd.=" AND";	
									}
									$sd.=" `".$k."` ".$vv[0]." :".$k.$vi;
									$_SDV[$k.$vi]=$vv[1];
								}
							}

						}
						else {				
							$sd.=" ".$k."=:".$k;
							$_SDV[$k]=$v;
						}
					}
				}
				$sd=!empty($sd)?'WHERE'.$sd:'';
				$sd.=$sdx;
			}
			if(empty($c)){
				$c='*';
			}
			if(!empty($d)){
				z(6,$d);
			}
			$srg="SELECT ".$c." FROM ".$con['vt'].".".$con['oe'].$con['t']." ".$sd.";";
			$pre=$GLOBALS['pdo']->prepare($srg);
			$pre->execute($_SDV);
			return $pre->fetchAll(PDO::FETCH_NUM);
		break;

		case 62: case $z[61]: // keysizsorgudetay
			if(!empty($b)){
				if(empty($c)){
					$c=0;
				}
				$in=array();
				foreach ($b as $i=>$bv) {
					$in[]=$bv[$c];
				}
				$snc=array('IN',$in);
			}
			else{
				$snc="0";
			}
		break;
		
		
		// KURULUM ve BİLGİ
		case'info':
			require(__DIR__.'/zinf.php');
		break;
		case'z':
			if(!empty($b))if(count($b)==count($z))$z=$b;else $snc=$z;
		break;
		default:
			if(empty($a))
				$snc='z 1.35.4';
			else {
				$pre=$GLOBALS['pdo']->prepare($a);
				$pre->execute();
				foreach($pre->fetchAll(PDO::FETCH_ASSOC) as $x){
					if(empty($snc)){
						$snc=Array();
					}
					$snc[]=$x;
				}
			}
	}
	return $snc;
}
function _z($a=NULL,$b=NULL,$c=NULL,$d=NULL){print_r(z($a,$b,$c,$d));}
function jz($a=NULL,$b=NULL,$c=NULL,$d=NULL){$snc=z($a,$b,$c,$d);return is_array($snc)?json_encode($snc):json_decode($snc,true);}
function _jz($a=NULL,$b=NULL,$c=NULL,$d=NULL){print_r(jz($a,$b,$c,$d));}
?>