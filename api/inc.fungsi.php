<?php
ini_set("session.cookie_domain", '.dev.local');
session_set_cookie_params(3600, '/', '.dev.local');
if(!isset($_SESSION)) {
   session_start();
}
// csrf code add here (see below...)
$http_origin = $_SERVER['HTTP_ORIGIN'];
if ($http_origin == "http://dev.local:3000" || $http_origin == "http://localhost:3300"){
    header("Access-Control-Allow-Origin: $http_origin");
}
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Headers: X-Requested-With, Origin, Content-Type, X-CSRF-Token, Accept');
// code starts here
$_SESSION['test'] = 'whatever';
session_write_close();
function waktu($waktu){
	$jam = substr($waktu,0,2);
	$menit = substr($waktu,3,2);
	return $jam.':'.$menit;
}

function penjumlahan_waktu($time1, $time2) {
  $times = array($time1, $time2);
  $seconds = 00;
  foreach ($times as $time)
  {
    list($hour,$minute,$second) = explode(':', $time);
	$seconds += $hour*3600;
	$seconds += $minute*60;
	$seconds += $second;
	}
	$hours = floor($seconds/3600);
	$seconds -= $hours*3600;
	$minutes = floor($seconds/60);
	$seconds -= $minutes*60;
	return "{$hours}:{$minutes}:{$seconds}";
	}

function selisih_waktu($jam1,$jam2) {
	$jam_start = substr($jam1,0,2);
	$menit_start = substr($jam1,3,2);
	$jam_end = substr($jam2,0,2);
	$menit_end = substr($jam2,3,2);
	  
	$date_awal  = new DateTime($jam_start.":".$menit_start);
	$date_akhir = new DateTime($jam_end.":".$menit_end);
	$selisih = $date_akhir->diff($date_awal);
	
	$jam = $selisih->format('%h');
	$menit = $selisih->format('%i');
	 
	 if($menit >= 0 && $menit <= 9){
	   $menit = "0".$menit;
	 }
	 if($jam >= 0 && $jam <= 9){
	   $jam = "0".$jam;
	 }
	 
	$hasil = $jam.":".$menit;
	
	return $hasil;
}

function bln_indonesia($bulan) {
$array_bulan=array("01"=>"Januari",
"02"=>"Feb",
"03"=>"Mar",
"04"=>"April",
"05"=>"Mei",
"06"=>"Juni",
"07"=>"Juli",
"08"=>"Agustus",
"09"=>"September",
"10"=>"Oktober",
"11"=>"Nopember",
"12"=>"Desember");
$bln_temp=explode("-",$bulan);
$bln=$bln_temp[1];
$thn=$bln_temp[0];
$nama_bulan=$array_bulan[$bln];
return $nama_bulan." ".$thn;
}

function tgl_indo2($bulan) {
$array_bulan=array(
"01"=>"Jan",
"02"=>"Feb",
"03"=>"Mar",
"04"=>"Apr",
"05"=>"Mei",
"06"=>"Jun",
"07"=>"Jul",
"08"=>"Agust",
"09"=>"Sept",
"10"=>"Okt",
"11"=>"Nov",
"12"=>"Des");
$bln_temp=explode("-",$bulan);
$tgl=$bln_temp[2];
$bln=$bln_temp[1];
$thn=$bln_temp[0];
$nama_bulan=$array_bulan[$bln];
return $tgl." ".$nama_bulan." ".$thn;
}


//fungsi untuk format tanggal indonesia
function tgl_indo($tgl){
	$tanggal = substr($tgl,8,2);
	$bulan = getBulan(substr($tgl,5,2));
	$tahun = substr($tgl,0,4);
	return $tanggal.' '.$bulan.' '.$tahun;		 
}
function waktu_indo($tgl){
	$tanggal = substr($tgl,8,2);
	$bulan = getBulan(substr($tgl,5,2));
	$tahun = substr($tgl,0,4);
	$waktu = substr($tgl,11,8);
	return $tanggal.' '.$bulan.' '.$tahun.' '.$waktu;		 
}	
function getBulan($bln){
	switch ($bln){
		case 1: return "Januari"; break;
		case 2: return "Februari"; break;
		case 3: return "Maret"; break;
		case 4: return "April"; break;
		case 5: return "Mei"; break;
		case 6: return "Juni"; break;
		case 7: return "Juli"; break;
		case 8: return "Agustus"; break;
		case 9: return "September"; break;
		case 10: return "Oktober"; break;
		case 11: return "November"; break;
		case 12: return "Desember"; break;
	}
}

//fungsi2 untuk combobox
function combotgl($awal, $akhir, $var, $terpilih){
  echo "<select name=$var>";
  for ($i=$awal; $i<=$akhir; $i++){
    $lebar=strlen($i);
    switch($lebar){
      case 1:
      {
        $g="0".$i;
        break;     
      }
      case 2:
      {
        $g=$i;
        break;     
      }      
    }  
    if ($i==$terpilih)
      echo "<option value=$g selected>$g</option>";
    else
      echo "<option value=$g>$g</option>";
  }
  echo "</select> ";
}

function combobln($awal, $akhir, $var, $terpilih){
  echo "<select name=$var>";
  for ($bln=$awal; $bln<=$akhir; $bln++){
    $lebar=strlen($bln);
    switch($lebar){
      case 1:
      {
        $b="0".$bln;
        break;     
      }
      case 2:
      {
        $b=$bln;
        break;     
      }      
    }  
      if ($bln==$terpilih)
         echo "<option value=$b selected>$b</option>";
      else
        echo "<option value=$b>$b</option>";
  }
  echo "</select> ";
}

function combothn($awal, $akhir, $var, $terpilih){
  echo "<select name=$var>";
  for ($i=$awal; $i<=$akhir; $i++){
    if ($i==$terpilih)
      echo "<option value=$i selected>$i</option>";
    else
      echo "<option value=$i>$i</option>";
  }
  echo "</select> ";
}

function combonamabln($awal, $akhir, $var, $terpilih){
  $nama_bln=array(1=> "Januari", "Februari", "Maret", "April", "Mei", 
                      "Juni", "Juli", "Agustus", "September", 
                      "Oktober", "November", "Desember");
  echo "<select name=$var>";
  for ($bln=$awal; $bln<=$akhir; $bln++){
      if ($bln==$terpilih)
         echo "<option value=$bln selected>$nama_bln[$bln]</option>";
      else
        echo "<option value=$bln>$nama_bln[$bln]</option>";
  }
  echo "</select> ";
}

//fungsi auto link
function autolink ($str){
  $str = eregi_replace("([[:space:]])((f|ht)tps?:\/\/[a-z0-9~#%@\&:=?+\/\.,_-]+[a-z0-9~#%@\&=?+\/_.;-]+)", "\\1<a href=\"\\2\" target=\"_blank\">\\2</a>", $str); //http
  $str = eregi_replace("([[:space:]])(www\.[a-z0-9~#%@\&:=?+\/\.,_-]+[a-z0-9~#%@\&=?+\/_.;-]+)", "\\1<a href=\"http://\\2\" target=\"_blank\">\\2</a>", $str); // www.
  $str = eregi_replace("([[:space:]])([_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,3})","\\1<a href=\"mailto:\\2\">\\2</a>", $str); // mail
  $str = eregi_replace("^((f|ht)tp:\/\/[a-z0-9~#%@\&:=?+\/\.,_-]+[a-z0-9~#%@\&=?+\/_.;-]+)", "<a href=\"\\1\" target=\"_blank\">\\1</a>", $str); //http
  $str = eregi_replace("^(www\.[a-z0-9~#%@\&:=?+\/\.,_-]+[a-z0-9~#%@\&=?+\/_.;-]+)", "<a href=\"http://\\1\" target=\"_blank\">\\1</a>", $str); // www.
  $str = eregi_replace("^([_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,3})","<a href=\"mailto:\\1\">\\1</a>", $str); // mail
  return $str;
}

//fungsi format rupiah
function format_rupiah($angka){
  $rupiah=number_format($angka,0,',','.');
  return $rupiah;
}

//fungsi seo
function seo_title($s) {
  $c = array (' ');
  $d = array ('-','/','\\',',','.','#',':',';','\'','"','[',']','{','}',')','(','|','`','~','!','@','%','$','^','&','*','=','?','+');
  $s = str_replace($d, '', $s); 
  $s = strtolower(str_replace($c, '-', $s)); 
  return $s;
}

//fungsi badword
function sensor($teks){
    $w = mysql_query("SELECT * FROM katajelek");
    while ($r = mysql_fetch_array($w)){
        $teks = str_ireplace($r['kata'], $r['ganti'], $teks);       
    }
    return $teks;
}  

//fungsi2 untuk upload gambar
function UploadImage($fupload_name){
  //direktori gambar
  $vdir_upload = "../../../foto_produk/";
  $vfile_upload = $vdir_upload . $fupload_name;

  //Simpan gambar dalam ukuran sebenarnya
  move_uploaded_file($_FILES["fupload"]["tmp_name"], $vfile_upload);

  //identitas file asli
  $im_src = imagecreatefromjpeg($vfile_upload);
  $src_width = imageSX($im_src);
  $src_height = imageSY($im_src);

  //Simpan dalam versi small 110 pixel
  //Set ukuran gambar hasil perubahan
  $dst_width = 55;
  $dst_height = ($dst_width/$src_width)*$src_height;

  //proses perubahan ukuran
  $im = imagecreatetruecolor($dst_width,$dst_height);
  imagecopyresampled($im, $im_src, 0, 0, 0, 0, $dst_width, $dst_height, $src_width, $src_height);

  //Simpan gambar
  imagejpeg($im,$vdir_upload . "small_" . $fupload_name);
  
  //Hapus gambar di memori komputer
  imagedestroy($im_src);
  imagedestroy($im);
}

function UploadBanner($fupload_name){
  //direktori banner
  $vdir_upload = "../../../images/";
  $vfile_upload = $vdir_upload . $fupload_name;

  //Simpan gambar dalam ukuran sebenarnya
  move_uploaded_file($_FILES["fupload"]["tmp_name"], $vfile_upload);
}

function UploadFile($fupload_name){
  //direktori file
  $vdir_upload = "../../../files/";
  $vfile_upload = $vdir_upload . $fupload_name;

  //Simpan gambar dalam ukuran sebenarnya
  move_uploaded_file($_FILES["fupload"]["tmp_name"], $vfile_upload);
}
function ratarata_waktu($timeIn,$pembagi){
	$detik = substr($timeIn,6,2);
	$menit = substr($timeIn,3,2);
	$jam   = substr($timeIn,0,2);
	
	$j = $jam *3600;
	$m = $menit * 60;
	$time = $j + $m + $detik;
	$time = floor($time / $pembagi);
	
	$jumlah_jam   = floor($time/3600);
	$sisa = $time % 3600;
	$jumlah_menit = floor($sisa/60);
	$sisa = $sisa % 60;
	$jumlah_detik = floor($sisa/1);
	
	$waktu = $jumlah_jam.':'.$jumlah_menit.':'.$jumlah_detik;
	$time = strtotime(date($waktu));
	$time = date('H:i:s', ($time));
	
	return $time;
}
?>
