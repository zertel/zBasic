<pre><?php
z(3,4,array('name'=>'Yeni ürü'));


 $_Urun=z(1); 

 foreach ($_Urun as $key => $urun) { ?>

<h1><?php _z($urun,'name') ?></h1>


<?php } ?>



<?php z(2,array('name'=>'Yeni ürün 1')) ;

$urun=z(1,4);
echo $urun['name'];

?>