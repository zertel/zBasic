<?php /*
Bu dosyayı menü taşıyıcısı olan <ul> etiketinizin içine import ediniz.
<ul> etiketinin içi ayarda tanımlanmış sayfa parçacıkları ile otomatik olarak doldurulmuş olacak.
Örnek kod:
		<ul class="senin-nav-ul-etiketin">
			<?php require(__DIR__.'/menu.php') ?>
		</ul>
*/ ?>
													<?php foreach ($_Sayfa as $sayfa) if(
														(!isset($sayfa['menudeGoster'])||$sayfa['menudeGoster'])
														&& ( (!empty($sayfa['giris']) && !empty($LOGIN)) || !isset($sayfa['giris']) || ($sayfa['giris']===false && empty($LOGIN)) )
														) { 
														?><li <?php if($S==$sayfa['S'])echo 'class="active"' ?>>
															<a href="?s=<?php echo $sayfa['S'] ?>">
																<?php echo $sayfa['ad'] ?>
															</a>
														</li><?php
													} ?>

													<?php /*/ ?>
													ALT SAYFALI VEYA .htaccessiz proje geliştirilecekse bu buloğu aktif edip yukaıdaki bloğu siliniz.
													<?php foreach ($_Sayfa as $sayfa) if(
														(!isset($sayfa['menudeGoster'])||$sayfa['menudeGoster'])
														&& ( (!empty($sayfa['giris']) && !empty($LOGIN)) || !isset($sayfa['giris']) )
														) { 
														?><li <?php if($SA==$sayfa['S'].$sayfa['A'])echo 'class="active"' ?>>
															<a href="?s=<?php echo $sayfa['S'] .(!empty( $sayfa['A'] )?'&a='.$sayfa['A']:''); ?>">
																<?php echo $sayfa['ad'] ?>
															</a>
														</li><?php
													} ?>
													<?php /*/ ?>
