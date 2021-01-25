<?php
require_once "PHPTelnet.php";
ini_set('display_errors', '0');
$host="http://192.168.8.202/telnet/";
$telnet = new PHPTelnet();
// $pop=$_GET['pop'];
// if(!$pop){
//   $lokasi="DAWUHAN";
// }
// $lokasi=$pop;
// $lokasi="DAWUHAN";
// $lokasi="YOSOWILANGUN"; 

if(isset($_POST['comand'])){
  $sn=$_POST['comand'];
  $lokasi=$_POST['lokasi'];
  if($lokasi=="DWH"){
    $result = $telnet->Connect('192.168.212.2','zte','zte');
    $res=str_replace(("POP-DWH-GPON_OLT1#"),'',"$result");

  }elseif ($lokasi=="YSW") {
    $result = $telnet->Connect('192.168.212.3','zte','zte');
  	$res=str_replace(("POP-YOSO-GPON_OLT1#"),'',"$result");
  }

  
  $telnet->DoCommand("show gpon onu by sn $sn", $result);
  if($lokasi=="DWH"){
    $res=str_replace(("POP-DWH-GPON_OLT1#"),'',"$result");
  }elseif ($lokasi=="YSW") {
  	$res=str_replace(("POP-YOSO-GPON_OLT1#"),'',"$result");
  }
	$res1=str_replace(("Search result"),'',"$res");
	$res2=str_replace(("-----------------"),'',"$res1");
	$res3=str_replace((" "),'',"$res2");
  echo"<meta http-equiv='refresh' content='0; URL=$host?pop=$lokasi&sn=$sn&onu=$res3'/>";
}?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>SNONT</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">  
  <script src="http://code.jquery.com/jquery-2.2.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <style type="text/css">
      .preloader {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 9999;
        background-color: #fff;
      }
      .preloader .loading {
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%,-50%);
        font: 14px arial;
      }
    </style>
    <script type="text/javascript">
 window.onload = function() { jam(); }

 function jam() {
  var e = document.getElementById('jam'),
  d = new Date(), h, m, s;
  h = d.getHours();
  m = set(d.getMinutes());
  s = set(d.getSeconds());

  e.innerHTML = h +':'+ m +':'+ s;

  setTimeout('jam()', 1000);
 }

 function set(e)X {
  e = e < 10 ? '0'+ e : e;
  return e;
 }
 </script>
  </head>
  <body>

<div class="jumbotron text-center">
  <h1>HAI KUCUR <br> <i class="fa fa-coffee" aria-hidden="true"></i></h1>
  <h3 id="jam"></h3>
  <p>Jangan Lupa Ngopi Hari ini :)</p> 
</div>
<!-- <img class="img-responsive" src="https://unsplash.it/1200/500?random=4"> -->
<div class="container">
  <?php include "content.php"?>
</div>
</body>
<script type="text/javascript">
$(window).load(function() {
    $(".preloader").fadeOut("4000");
});
</script>
</html>