	<?php 
		// #6 yani 'tablo' seçeneği: aynı veritabanı seçer gibi bir tablo seçmeye yarar (Bu özellik ya kullanılmamalı ya da kullanırken çok dikkatli olunmalıdır.) 


		// KULLANIM ÖRNEKLERİ
		// "urun" isimli tabloyu seç (Aşağıda bir çok defa bu tablo üzerine sorgu yapacağız)
		z(6,'urun');



		// Seçilmiş tablonun tüm satırlarını oku ve değişkene ata
		$_Urun=z(1);

		// Seçilmiş tablonun tüm satırlarını oku ve ekrana bas
		_z(1);

		// Seçilmiş tablonun tüm satırlarını oku ve ekrana JSON formatında bas
		_jz(1);

		// Seçilmiş tabloya yeni satır ekle
		z(2,array( 
			'ad'=>'Yeni Ürün',
			'aciklama'=>'#6 tablo örneğini test ederken eklendi.'
		));


	?>