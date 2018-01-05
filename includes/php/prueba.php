 <?php

$string="Jeisson_Ibarguen_Maturana_1077448820";
 //echo hash('sha256', $string );

 echo 'SHA-256:      ' . crypt('rasmuslerdorf', '$5$rounds=5000$usesomesillystringforsalt$') . "\n";
 //echo crypt_sha512("$Jei", "Jeisson_Ibarguen_Maturana_1077448820");
 ?>