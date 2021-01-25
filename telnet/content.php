<div class="row">
    <div class="col-sm-4 text-center">
      <h3>MENU</h3>
      <!-- <a class="btn btn-sm btn-success" href="<?= $host."?pop=DAWUHAN";?>">DAWUHAN</a>
      <a class="btn btn-sm btn-primary" href="<?= $host."?pop=YOSOWILANGUN";?>">YOSOWILANGUN</a> -->
      <form action="" method="post">
    <select required class="form-control" name="lokasi" onchange="this.form.submit();">
    <!-- <select required class="form-control" name="lokasi"> -->
      <!-- <option value="">--Pilih POP--</option>	 -->
		  <option value="DWH">DAWUHAN</option>	
		  <option value="YSW">YOSOWILANGUN</option>	
	</select><br>
  <input required type="text" class="form-control" value="<?= $_GET['sn']?>" name="comand" autofocus placeholder="Masukan SN disini..."><br>

  </form>
    </div>
    <div class="col-sm-4">
      <h3 style="text-align:center">Kirim Wa</h3>
    <?php
      $lokasi=$_GET['pop'];
      $onu=$_GET['onu'];
    
if(isset($_POST['reset'])){
  if($lokasi=="DWH"){
    $result = $telnet->Connect('192.168.212.2','zte','zte');
  }elseif ($lokasi=="YSW") {
    $result = $telnet->Connect('192.168.212.3','zte','zte');
  }
  $telnet->DoCommand("config t", $result);
  $telnet->DoCommand("pon-onu-mng $onu", $result);
  $telnet->DoCommand("restore factory", $result);
  $telnet->DoCommand("reboot", $result);
  echo "<meta http-equiv='refresh' content='5;url=http://example.com/'/>";

}elseif(isset($_POST['reboot'])){
    echo"";
}

if($_GET['onu']){
  if($lokasi=="DWH"){
    $result = $telnet->Connect('192.168.212.2','zte','zte');
  }elseif ($lokasi=="YSW") {
    $result = $telnet->Connect('192.168.212.3','zte','zte');
  }
	$telnet->DoCommand("show onu running config $onu", $result);
	$user        ="username";
	$pcc      =strpos($result,$user);
	$dw=substr($result,$pcc+9,9);

  $telnet->DoCommand("show pon power attenuation $onu", $result);
	$rx       	 =' Rx:';
	$pccrx      =strpos($result,$rx);
	$dbm=substr($result,$pccrx+4,3)." dBm";
  $pass="12345678";

  $telnet->DoCommand("show run interface $onu", $result);
	$up       	 ='upstream';
	$pccup      =strpos($result,$up);
  $mb=substr($result,$pccup+9,4);
  $pattern = "/([^0-9.+]+)/";
	$mbps = preg_replace($pattern,'',$mb)." Mbps";
	
	$telnet->DoCommand("show gpon remote-onu ip-host $onu", $result);
	$cari        ="Current IP address:";
	$posisi      =strpos($result,$cari);
	$hasil=substr($result,$posisi,35);
	$pattern = "/([^0-9.+]+)/";
	$angka2 = preg_replace($pattern,'',$hasil);
  if($angka2=="0.0.0.0"){
    header("Refresh:0");
  ?>
  <div class="preloader">
      <div class="loading">
        <div class="spinner-border" role="status">
        </div>
      </div>
    </div>  
  <?php }

} ?>

<textarea ondblclick="myFunction();" name="" id="kopi" class="form-control" rows="6">
<?=$dw?> 
<?=$dbm?>


<?=$pass?>

<?=$mbps?>
</textarea>
<br>
<form action="" method="post">
<a class="btn btn-sm btn-primary" href="http://<?php echo $angka2?>"onclick="window.open('http://<?php echo $angka2?>','newwindow',  'width=800,height=600'); return false;">Remote</a>
<a class="btn btn-sm btn-success" href="<?= $host;?>">Refresh</a>
<input type="submit" value="reboot" name="reboot" class="btn btn-sm btn-warning" onclick="return confirm('Are you sure?')">
<input type="submit" value="reset" name="reset" class="btn pull-right btn-sm btn-danger"  onclick="return confirm('Are you sure?')">
</form>
</div>
    <div class="col-sm-4">
      <h3 class="text">Urutan Port</h3>        
      <p>
      1 BIRU      <br>
      2 ORANGE    <br>
      3 HIJAU     <br> 
      4 COKLAT    <br>
      5 ABU-ABU   <br>
      6 PUTIH     <br>
      7 MERAH     <br>
      8 HITAM   
      </p>
    </div>
  </div>

    <script>
        function myFunction() {
        var copyText = document.getElementById("kopi");
        copyText.select();
        document.execCommand("copy");
        alert("Copied the text: " + copyText.value);
        }
    </script>