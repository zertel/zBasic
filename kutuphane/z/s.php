<?Php
$sd='';
if(!empty($b)){
	if(is_numeric($b)){
		$sd="WHERE ID='".$b."' LIMIT 1";
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

		$dgr=array();
		if(count($b)){
			foreach ($b as $k=>$v) {
				if(!empty($sd)){
					$sd.=' AND';
				}
				if(is_array($v)){	
					$sd.=" ".$k.$v[0].":".$k;
					$dgr[$k]=$v[1];	
				}
				else {				
					$sd.=" ".$k."=:".$k;
					$dgr[$k]=$v;
				}
			}
		}
		$sd=!empty($sd)?'WHERE'.$sd:'';
		$sd.=$sdx;
	}
	else if($b=='son'){
		$sd="ORDER BY ID DESC LIMIT 1";
	}
	else{
		$sd=$b;
	}
}
if(!empty($c)){
	z(6,$c);
}
$srg="DELETE FROM `".$con['vt']."`.`".$con['oe'].$con['t']."` ".$sd.";";
$snc=$GLOBALS['pdo']->prepare($srg)->execute($dgr);
?>