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

		$xdgr=array();
		if(count($b)){
			foreach ($b as $k=>$v) {
				if(!empty($sd)){
					$sd.=' AND';
				}
				if(is_array($v)){	
					$sd.=" ".$k.$v[0].":".$k;
					$xdgr[$k]=$v[1];	
				}
				else {				
					$sd.=" ".$k."=:".$k;
					$xdgr[$k]=$v;
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
$set='';
if(is_array($c)){
	$dgr=$c;
	foreach($c as $x[0]=>$x[1]){
		if(is_array($x[1]))$dgr[$x[0]]=json_encode($x[1]);
		if(!empty($set)){
			$set.=',';
		}
		$set.="`".$x[0]."` = :".$x[0];
	}
	if(!empty($d)){
		z(6,$d);
	}
}
else {
	$set="`".$c."` = :".$c;
	$dgr=array($c=>$d);
}
if(!empty($set)){
	$srg="UPDATE `".$con['vt']."`.`".$con['oe'].$con['t']."` SET ".$set." ".$sd;
	if(!empty($xdgr)){
		$dgr=array_merge($dgr,$xdgr);
	}
	$snc=$GLOBALS['pdo']->prepare($srg)->execute($dgr);
}
else{
	$snc = false;
}
?>