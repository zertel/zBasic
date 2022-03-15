<?php
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
		$c='id';
	}
	if(!empty($d)){
		z(6,$d);
	}
	$srg="SELECT COUNT(".$c.") FROM `".$con['vt']."`.`".$con['oe'].$con['t']."` ".$sd.";";
	$pre=$GLOBALS['pdo']->prepare($srg);
	$pre->execute($_SDV);
	$snc=!empty($pre)?$pre->fetchColumn():0;
?>