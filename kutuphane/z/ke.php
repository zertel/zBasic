<?Php 
if(!file_exists($b)){
	$b=str_replace("\\", '/', $b);
	if(!strpos($b,'/')){
		$snc=mkdir($b);
	}
	else{
		$_Kls=explode('/',$b);
		$xi=0;
		$yol='';
		foreach($_Kls as $kls){
			if(!empty($yol)){
				$yol.='/';
			}
			$yol.=$kls;
			if(!file_exists($yol)){
				if(mkdir($yol)){
					$xi++;
				}
			}
			else {
				$xi++;
			}
		}
		if($xi==count($_Kls)){
			$snc=true;
		}
	}
}
?>