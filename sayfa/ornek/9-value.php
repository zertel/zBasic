	<?php 
		// #9 yani 'value' seçeneği: Hem _GET hem de _POST iki request değerinide beraber okur. Diğerlerinin aksine 3. parametre yardımı ile varsayılan değer özelliği de vardır.


		// KULLANIM ÖRNEKLERİ
		// Tüm get ve post request verilerini çek ve değişkene yükle
		$_Request=z(9);
		echo !empty($_Request['id']) ? $_Request['id'] : ''; // Getten gelen id değerini ekrana bas
		
		echo '<br>';
		
		echo !empty($_Request['soyad']) ? $_Request['soyad'] : ''; // Posttan veya Getten gelen soyad değerini ekrana bas

		echo '<br>';

		// Posttan veya Getten gelen bir request değerini ekrana bas
		_z(9,'soyad');

		echo '<br>';

		// Posttan veya Getten gelen veri var ise o değeri yok ise varsayılan değeri ekrana bas
		_z(9,'ad','Misafir'); // 'ad' değeri gönderilmemiş ise 'Misafir' değerini ekrana bas

	?>
