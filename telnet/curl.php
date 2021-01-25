<?php
$ch = curl_init();
$data=array(
'username'=>'yogo',
'pass'=>'1sampai5',
);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_URL, "https://contoh.com/login.php");
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookie-name.txt');  
curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookie-name.txt');
$hasil=curl_exec($ch);
curl_close ($ch);
echo $hasil;
?>