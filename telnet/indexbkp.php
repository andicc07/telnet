<?php
require_once "PHPTelnet.php";

ini_set('display_errors', '0');
ini_set('display_startup_errors', '0');
error_reporting(E_ALL);
$host="http://192.168.8.202/telnet/";
$telnet = new PHPTelnet();
$telnet->show_connect_error=1;
$result = $telnet->Connect('192.168.212.2','zte','zte');
switch ($result) {
case 1:
echo '[php Telnet] Connect failed: Unable to open network connection';
break; 
case 2:
echo '[php Telnet] Connect failed: Unknown host';
break; 
case 3:
echo '[php Telnet] Connect failed: Login failed';
break; 
case 4:
echo '[php Telnet] Connect failed: Your PHP version does not support PHP Telnet';
break; 
}
if(isset($_POST['comand'])){
	$sn=$_POST['comand'];
	$telnet->DoCommand("show gpon onu by sn $sn", $result);

	$res=str_replace(("POP-DWH-GPON_OLT1#"),'',"$result");
	$res1=str_replace(("Search result"),'',"$res");
	$res2=str_replace(("-----------------"),'',"$res1");
	$res3=str_replace((" "),'',"$res2");
	// echo "<a href='?onu=$res3'>$res3</a><br>";
	echo"<meta http-equiv='refresh' content='0; URL=$host.?onu=$res3'/>";
}?>
<form method="post" action="">
	<input type="text" name="comand" autofocus><br><br>
<?php
if($_GET['onu']){
	$onu=$_GET['onu'];
	// echo $onu."<br>";
	$telnet->DoCommand("show onu running config $onu", $result);
	$user        ="username";
	$pcc      =strpos($result,$user);
	$dw=substr($result,$pcc+9,9);
	// echo $dw."<br>";

	$telnet->DoCommand("show pon power attenuation $onu", $result);
	$rx       	 =' Rx:';
	$pccrx      =strpos($result,$rx);
	$dbm=substr($result,$pccrx+4,3);
	// echo $dbm."<br>";
	
	$telnet->DoCommand("show pon power attenuation $onu", $result);
	$result1=str_replace(array(
		"POP-DWH-GPON_OLT1#","--","OLT","ONU","Attenuation","up"
		),"","$result");
		// echo $result1."<br>";
		// echo"<meta http-equiv='refresh' content='10; URL=http://localhost/telnet'/>";

	$telnet->DoCommand("show gpon remote-onu ip-host $onu", $result);
	$cari        ="Current IP address:";
	$posisi      =strpos($result,$cari);
	$hasil=substr($result,$posisi,35);
	$pattern = "/([^0-9.+]+)/";
	$angka2 = preg_replace($pattern,'',$hasil);
?>
<textarea ondblclick="myFunction();" name="" id="kopi" cols="20" rows="6">
<?=$dw?> 
<?=$dbm?> dBm

12345678
</textarea>
<br><br>
<button>
	<a href="http://<?php echo $angka2?>"onclick="window.open('http://<?php echo $angka2?>','newwindow',  'width=800,height=600'); return false;">Remote</a>
</button>

<button>
	<a href="<?= $host;?>">Refresh</a>
</button>
<?php } ?>

<script>
function myFunction() {
  var copyText = document.getElementById("kopi");
  copyText.select();
  document.execCommand("copy");
}
</script>