	<?php 
		// #5 yani 'say' seçeneği: Veritabanı tablosundaki satırları sayar. Aynı okuma işlemi gibi çalışır fakat sadece sayısal olarak satır adeti döndürür.

		// Kategori id'si 5 olan ürünlerin adetini öğren
		$urunAdeti = z(5,"WHERE kategori_id='5'",'id','urun');
		echo $urunAdeti;
	?>