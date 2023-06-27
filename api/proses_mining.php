<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>ALGORITMA K-MEANS</title>

    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">
    <link href="../vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">
    <link href="../vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

  <body class="skin-blue layout-top-nav">
    <div class="wrapper">
      
      <header class="main-header">               
        <?php 
		include "../inc.session.php";
		include "../inc.fungsi.php";
		include "../koneksi.php";
		include "header-and-menu.php";
		?>
      </header>
      <!-- Full Width Column -->
      <div class="content-wrapper">
<?php 
// code starts here

// Proses Mining (1)

//mencari nilai C1 (x,y)
$sql_cmh   = "SELECT MAX(stok) AS MaxH FROM produk";
$query_cmh = mysql_query($sql_cmh); 
$data_cmh  = mysql_fetch_array($query_cmh);
$max_harga = $data_cmh['MaxH'];

$sql_ctp   = "SELECT MAX(total) AS MaxJ FROM penjualan";
$query_ctp = mysql_query($sql_ctp); 
$data_ctp  = mysql_fetch_array($query_ctp);
$max_jual  = $data_ctp['MaxJ'];

$sql_cj    = "SELECT id_produk FROM produk";
$query_cj  = mysql_query($sql_cj); 
$jlh_data  = mysql_num_rows($query_cj);

//----------------------------------------------------------------------------------------------------------
$centroid1  = mysql_fetch_array(mysql_query("SELECT * FROM centroid WHERE id='C1'"));
$c1x = $centroid1['cx'];
$c1y = $centroid1['cy'];

$centroid2  = mysql_fetch_array(mysql_query("SELECT * FROM centroid WHERE id='C2'"));
$c2x = $centroid2['cx'];
$c2y = $centroid2['cy'];
mysql_query("DELETE FROM centroid WHERE id = 'C3'");
mysql_query("DELETE FROM centroid WHERE id = 'C4'");
mysql_query("DELETE FROM centroid WHERE id = 'C5'");
mysql_query("DELETE FROM centroid WHERE id = 'C6'");
mysql_query("DELETE FROM centroid WHERE id = 'C7'");
mysql_query("DELETE FROM centroid WHERE id = 'C8'");
mysql_query("DELETE FROM centroid WHERE id = 'C9'");
mysql_query("DELETE FROM centroid WHERE id = 'C10'");
mysql_query("DELETE FROM centroid WHERE id = 'C11'");
mysql_query("DELETE FROM centroid WHERE id = 'C12'");
mysql_query("DELETE FROM centroid WHERE id = 'C13'");
mysql_query("DELETE FROM centroid WHERE id = 'C14'");
//----------------------------------------------------------------------------------------------------------

//mengambil data di database untuk dilakukan pencarian jarak pusat ke cluster
$sql = mysql_query("SELECT penjualan.id_produk, penjualan.total, produk.stok FROM produk JOIN 
						   penjualan ON produk.id_produk = penjualan.id_produk ORDER BY produk.nama ASC");

while ($d = mysql_fetch_array($sql)){
	$bc = $d['id_produk'];
	$tot = $d['total'];
	$hg = $d['stok'];
	
	//pencarian jarak pusat ke cluster
	//D1
	$iterasi1D1 = sqrt((pow(($d['stok']-$c1x),2))+(pow(($tot-$c1y),2)));
	
	//D2
	$iterasi1D2 = sqrt((pow(($d['stok']-$c2x),2))+(pow(($tot-$c2y),2)));
	
	if ($iterasi1D1 < $iterasi1D2){
		$anggota_I1 = "1";
	}else{
		$anggota_I1 = "0";
	}
	
	//Menyimpan ke database
	$mySql	= "UPDATE proses_mining SET Iterasi_1 = '".$anggota_I1."',
									  Distance1 = '".$iterasi1D1."',
									  Distance2 = '".$iterasi1D2."', 
									  Iterasi_2= '0', Distance3 = '0', Distance4 = '0',
									  Iterasi_3= '0', Distance5 = '0', Distance6 = '0',
									  Iterasi_4= '0', Distance7 = '0', Distance8 = '0',
									  Iterasi_5= '0', Distance9 = '0', Distance10 = '0',
									  Iterasi_6= '0', Distance11 ='0',Distance12 = '0',
									  Iterasi_7= '0', Distance13 = '0',Distance14 = '0'
									  WHERE id_produk = '".$bc."'";
	mysql_query($mySql);
}

//Proses Iterasi 2 ----------------------------------------------------------------------------------------------

	//Mencari C1 Baru
	$cek_C1		= mysql_num_rows(mysql_query("SELECT id_produk FROM proses_mining WHERE Iterasi_1 = '1' "));
	$data_C1x_N	= mysql_fetch_array(mysql_query("SELECT SUM(stok) AS H_produk FROM produk INNER JOIN proses_mining ON produk.id_produk = proses_mining.id_produk WHERE proses_mining.Iterasi_1 = '1'"));
	$JH_C1x_N	= $data_C1x_N['H_produk'];
	
	$data_C1y_N	= mysql_fetch_array(mysql_query("SELECT SUM(total) AS J_jual FROM penjualan INNER JOIN proses_mining ON penjualan.id_produk = proses_mining.id_produk WHERE proses_mining.Iterasi_1 = '1'"));
	$JJ_C1y_N	= $data_C1y_N['J_jual'];
	
	//Mencari C2 Baru
	$cek_C2		= mysql_num_rows(mysql_query("SELECT id_produk FROM proses_mining WHERE Iterasi_1 = '0' "));
	$data_C2x_N	= mysql_fetch_array(mysql_query("SELECT SUM(stok) AS H_produk FROM produk INNER JOIN proses_mining ON produk.id_produk = proses_mining.id_produk WHERE proses_mining.Iterasi_1 = '0'"));
	$JH_C2x_N	= $data_C2x_N['H_produk'];
	
	$data_C2y_N	= mysql_fetch_array(mysql_query("SELECT SUM(total) AS J_jual FROM penjualan INNER JOIN proses_mining ON penjualan.id_produk = proses_mining.id_produk WHERE proses_mining.Iterasi_1 = '0'"));
	$JJ_C2y_N	= $data_C2y_N['J_jual'];
	//----------------------------------------------------------------------------------------------------------
	$C1x_New	= ($JH_C1x_N / $cek_C1);
	$C1y_New	= ($JJ_C1y_N / $cek_C1);
	
	$C2x_New	= ($JH_C2x_N / $cek_C2);
	$C2y_New	= ($JJ_C2y_N / $cek_C2);
	$cekdb3		= mysql_query("SELECT * FROM centroid WHERE id='C3'");
	$statuscek3 = mysql_num_rows($cekdb3);
	$cekdb4 	= mysql_query("SELECT * FROM centroid WHERE id='C4'");
	$statuscek4 = mysql_num_rows($cekdb4);
	if ($statuscek3 == 0){
		mysql_query("INSERT INTO centroid values ('C3','$C1x_New','$C1y_New')");
	}else{
		mysql_query("UPDATE centroid SET cx = '$C1x_New', cy='$C1y_New' WHERE id = 'C3'");
	}
	if ($statuscek4 == 0){
		mysql_query("INSERT INTO centroid values ('C4','$C2x_New','$C2y_New')");
	}else{
		mysql_query("UPDATE centroid SET cx = '$C2x_New', cy='$C2y_New' WHERE id = 'C4'");
	}
	mysql_query("DELETE FROM centroid WHERE id = 'C5'");
	mysql_query("DELETE FROM centroid WHERE id = 'C6'");
	mysql_query("DELETE FROM centroid WHERE id = 'C7'");
	mysql_query("DELETE FROM centroid WHERE id = 'C8'");
	mysql_query("DELETE FROM centroid WHERE id = 'C9'");
	mysql_query("DELETE FROM centroid WHERE id = 'C10'");
	mysql_query("DELETE FROM centroid WHERE id = 'C11'");
	mysql_query("DELETE FROM centroid WHERE id = 'C12'");
	mysql_query("DELETE FROM centroid WHERE id = 'C13'");
	mysql_query("DELETE FROM centroid WHERE id = 'C14'");
	//----------------------------------------------------------------------------------------------------------
	
//mengambil data di database untuk dilakukan pencarian jarak pusat ke cluster
$sql2 = mysql_query("SELECT penjualan.id_produk, penjualan.total, produk.stok FROM produk JOIN 
						   penjualan ON produk.id_produk = penjualan.id_produk ORDER BY id_produk ASC");
while ($d2 = mysql_fetch_array($sql2)){
	
	$bc = $d2['id_produk'];
	$tot = $d2['total'];
	$hg = $d2['stok'];
	
	//pencarian jarak pusat ke cluster
	//D1 
	$iterasi2D1 = sqrt((pow(($d2['stok']-$C1x_New),2))+(pow(($tot-$C1y_New),2)));
	
	//D2
	$iterasi2D2 = sqrt((pow(($d2['stok']-$C2x_New),2))+(pow(($tot-$C2y_New),2)));
	
	if ($iterasi2D1 < $iterasi2D2){
		$anggotaC = 1;
	}else if ($iterasi2D1 > $iterasi2D2){
		$anggotaC = 0;
	}else{$anggotaC = 2;}
	
	//Menyimpan ke database
	$mySql2	= "UPDATE proses_mining SET Iterasi_2 = '".$anggotaC."',
									  Distance3 = '".$iterasi2D1."',
									  Distance4 = '".$iterasi2D2."',
									  Iterasi_3= '0', Distance5 = '0', Distance6 = '0',
									  Iterasi_4= '0', Distance7 = '0', Distance8 = '0',
									  Iterasi_5= '0', Distance9 = '0', Distance10 = '0',
									  Iterasi_6= '0', Distance11 ='0',Distance12 = '0',
									  Iterasi_7= '0', Distance13 = '0',Distance14 = '0'
									  WHERE id_produk = '".$bc."'";
	mysql_query($mySql2);
}

//Proses Iterasi 3 ----------------------------------------------------------------------------------------------
//Cek Iterasi C1 dan C2, Apakah sudah sama atau belum -----------------------------------------------------------

$alert = "
	 	<div id='page-wrapper'>
			<p>&nbsp;</p>
            <div class='row'>
            	<div class='col-lg-12'>
                	<div class='text-center'>
					  <div class='col-lg-10 col-lg-offset-1'>
					  <div class='alert alert-success alert-dismissible' role='alert'>
						<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
						  <span aria-hidden='true'>&times;</span>
						</button>Selesai Menghitung Euclidean Distance.
					  </div>
					  </div>
				</div>
			</div>
		</div>";

$sql_info 	= "SELECT Iterasi_1 FROM proses_mining WHERE 
					Iterasi_1 = 1 AND Iterasi_2 = 0 OR
					Iterasi_1 = 0 AND Iterasi_2 = 1";
$cek_j_c1_c2	= mysql_num_rows(mysql_query($sql_info));
if ($cek_j_c1_c2 == 0){
	echo "$alert";
}else if ($cek_j_c1_c2 > 0){
	
	//Mencari C1 Baru
	$cek_C1		= mysql_num_rows(mysql_query("SELECT id_produk FROM proses_mining WHERE Iterasi_2 = '1' "));
	$data_C1x_N	= mysql_fetch_array(mysql_query("SELECT SUM(stok) AS H_produk FROM produk INNER JOIN proses_mining ON produk.id_produk = proses_mining.id_produk WHERE proses_mining.Iterasi_2 = '1'"));
	$JH_C1x_N	= $data_C1x_N['H_produk'];
	
	$data_C1y_N	= mysql_fetch_array(mysql_query("SELECT SUM(total) AS J_jual FROM penjualan INNER JOIN proses_mining ON penjualan.id_produk = proses_mining.id_produk WHERE proses_mining.Iterasi_2 = '1'"));
	$JJ_C1y_N	= $data_C1y_N['J_jual'];
	
	//Mencari C2 Baru
	$cek_C2		= mysql_num_rows(mysql_query("SELECT id_produk FROM proses_mining WHERE Iterasi_2 = '0' "));
	$data_C2x_N	= mysql_fetch_array(mysql_query("SELECT SUM(stok) AS H_produk FROM produk INNER JOIN proses_mining ON produk.id_produk = proses_mining.id_produk WHERE proses_mining.Iterasi_2 = '0'"));
	$JH_C2x_N	= $data_C2x_N['H_produk'];
	
	$data_C2y_N	= mysql_fetch_array(mysql_query("SELECT SUM(total) AS J_jual FROM penjualan INNER JOIN proses_mining ON penjualan.id_produk = proses_mining.id_produk WHERE proses_mining.Iterasi_2 = '0'"));
	$JJ_C2y_N	= $data_C2y_N['J_jual'];
	//----------------------------------------------------------------------------------------------------------
	$C1x_New	= ($JH_C1x_N / $cek_C1);
	$C1y_New	= ($JJ_C1y_N / $cek_C1);
	
	$C2x_New	= ($JH_C2x_N / $cek_C2);
	$C2y_New	= ($JJ_C2y_N / $cek_C2);
	
	$cekdb5		= mysql_query("SELECT * FROM centroid WHERE id='C5'");
	$statuscek5 = mysql_num_rows($cekdb5);
	$cekdb6 	= mysql_query("SELECT * FROM centroid WHERE id='C6'");
	$statuscek6 = mysql_num_rows($cekdb6);
	if ($statuscek5 == 0){
		mysql_query("INSERT INTO centroid values ('C5','$C1x_New','$C1y_New')");
	}else{
		mysql_query("UPDATE centroid SET cx = '$C1x_New', cy='$C1y_New' WHERE id = 'C5'");
	}
	if ($statuscek6 == 0){
		mysql_query("INSERT INTO centroid values ('C6','$C2x_New','$C2y_New')");
	}else{
		mysql_query("UPDATE centroid SET cx = '$C2x_New', cy='$C2y_New' WHERE id = 'C6'");
	}
	mysql_query("DELETE FROM centroid WHERE id = 'C7'");
	mysql_query("DELETE FROM centroid WHERE id = 'C8'");
	mysql_query("DELETE FROM centroid WHERE id = 'C9'");
	mysql_query("DELETE FROM centroid WHERE id = 'C10'");
	mysql_query("DELETE FROM centroid WHERE id = 'C11'");
	mysql_query("DELETE FROM centroid WHERE id = 'C12'");
	mysql_query("DELETE FROM centroid WHERE id = 'C13'");
	mysql_query("DELETE FROM centroid WHERE id = 'C14'");

	//----------------------------------------------------------------------------------------------------------
	
//mengambil data di database untuk dilakukan pencarian jarak pusat ke cluster
$sql2 = mysql_query("SELECT penjualan.id_produk, penjualan.total, produk.stok FROM produk JOIN 
						   penjualan ON produk.id_produk = penjualan.id_produk ORDER BY id_produk ASC");
while ($d2 = mysql_fetch_array($sql2)){
	
	$bc = $d2['id_produk'];
	$tot = $d2['total'];
	$hg = $d2['stok'];
	
	//pencarian jarak pusat ke cluster
	//D1 
	$iterasi2D1 = sqrt((pow(($d2['stok']-$C1x_New),2))+(pow(($tot-$C1y_New),2)));
	
	//D2
	$iterasi2D2 = sqrt((pow(($d2['stok']-$C2x_New),2))+(pow(($tot-$C2y_New),2)));
	
	if ($iterasi2D1 < $iterasi2D2){
		$anggotaC = 1;
	}else if ($iterasi2D1 > $iterasi2D2){
		$anggotaC = 0;
	}else{$anggotaC = 2;}
	
	//Menyimpan ke database
	$mySql2	= "UPDATE proses_mining SET Iterasi_3 = '".$anggotaC."',
									  Distance5 = '".$iterasi2D1."',
									  Distance6 = '".$iterasi2D2."',
									  Iterasi_4= '0', Distance7 = '0', Distance8 = '0',
									  Iterasi_5= '0', Distance9 = '0', Distance10 = '0',
									  Iterasi_6= '0', Distance11 ='0',Distance12 = '0',
									  Iterasi_7= '0', Distance13 = '0',Distance14 = '0'
									  WHERE id_produk = '".$bc."'";
	mysql_query($mySql2);
}
	
	//Proses Iterasi 4 ----------------------------------------------------------------------------------------------
	
	//Cek Iterasi C2 dan C3, Apakah sudah sama atau belum
	$sql_info 	= "SELECT Iterasi_3 FROM proses_mining WHERE 
					Iterasi_2 = 1 AND Iterasi_3 = 0 OR
					Iterasi_2 = 0 AND Iterasi_3 = 1";
	$cek_j_c2_c3	= mysql_num_rows(mysql_query($sql_info));
	if ($cek_j_c2_c3 == 0){
		echo "$alert";
	}else if ($cek_j_c2_c3 > 0){
		//Mencari C1 Baru
		$cek_C1		= mysql_num_rows(mysql_query("SELECT id_produk FROM proses_mining WHERE Iterasi_3 = '1' "));
		$data_C1x_N	= mysql_fetch_array(mysql_query("SELECT SUM(stok) AS H_produk FROM produk INNER JOIN proses_mining ON produk.id_produk = proses_mining.id_produk WHERE proses_mining.Iterasi_3 = '1'"));
		$JH_C1x_N	= $data_C1x_N['H_produk'];
		
		$data_C1y_N	= mysql_fetch_array(mysql_query("SELECT SUM(total) AS J_jual FROM penjualan INNER JOIN proses_mining ON penjualan.id_produk = proses_mining.id_produk WHERE proses_mining.Iterasi_3 = '1'"));
		$JJ_C1y_N	= $data_C1y_N['J_jual'];
		
		//Mencari C2 Baru
		$cek_C2		= mysql_num_rows(mysql_query("SELECT id_produk FROM proses_mining WHERE Iterasi_3 = '0' "));
		$data_C2x_N	= mysql_fetch_array(mysql_query("SELECT SUM(stok) AS H_produk FROM produk INNER JOIN proses_mining ON produk.id_produk = proses_mining.id_produk WHERE proses_mining.Iterasi_3 = '0'"));
		$JH_C2x_N	= $data_C2x_N['H_produk'];
		
		$data_C2y_N	= mysql_fetch_array(mysql_query("SELECT SUM(total) AS J_jual FROM penjualan INNER JOIN proses_mining ON penjualan.id_produk = proses_mining.id_produk WHERE proses_mining.Iterasi_3 = '0'"));
		$JJ_C2y_N	= $data_C2y_N['J_jual'];
		//----------------------------------------------------------------------------------------------------------
		$C1x_New	= ($JH_C1x_N / $cek_C1);
		$C1y_New	= ($JJ_C1y_N / $cek_C1);
		
		$C2x_New	= ($JH_C2x_N / $cek_C2);
		$C2y_New	= ($JJ_C2y_N / $cek_C2);
		
		$cekdb7		= mysql_query("SELECT * FROM centroid WHERE id='C7'");
		$statuscek7 = mysql_num_rows($cekdb7);
		$cekdb8 	= mysql_query("SELECT * FROM centroid WHERE id='C8'");
		$statuscek8 = mysql_num_rows($cekdb8);
		if ($statuscek7 == 0){
			mysql_query("INSERT INTO centroid values ('C7','$C1x_New','$C1y_New')");
		}else{
			mysql_query("UPDATE centroid SET cx = '$C1x_New', cy='$C1y_New' WHERE id = 'C7'");
		}
		if ($statuscek8 == 0){
			mysql_query("INSERT INTO centroid values ('C8','$C2x_New','$C2y_New')");
		}else{
			mysql_query("UPDATE centroid SET cx = '$C2x_New', cy='$C2y_New' WHERE id = 'C8'");
		}
		mysql_query("DELETE FROM centroid WHERE id = 'C9'");
		mysql_query("DELETE FROM centroid WHERE id = 'C10'");
		mysql_query("DELETE FROM centroid WHERE id = 'C11'");
		mysql_query("DELETE FROM centroid WHERE id = 'C12'");
		mysql_query("DELETE FROM centroid WHERE id = 'C13'");
		mysql_query("DELETE FROM centroid WHERE id = 'C14'");
		//----------------------------------------------------------------------------------------------------------
		
	//mengambil data di database untuk dilakukan pencarian jarak pusat ke cluster
	$sql2 = mysql_query("SELECT penjualan.id_produk, penjualan.total, produk.stok FROM produk JOIN 
						   penjualan ON produk.id_produk = penjualan.id_produk ORDER BY id_produk ASC");
		while ($d2 = mysql_fetch_array($sql2)){
			
			$bc = $d2['id_produk'];
			$tot = $d2['total'];
			$hg = $d2['stok'];
		
		//pencarian jarak pusat ke cluster
		//D1 
		$iterasi2D1 = sqrt((pow(($d2['stok']-$C1x_New),2))+(pow(($tot-$C1y_New),2)));
		
		//D2
		$iterasi2D2 = sqrt((pow(($d2['stok']-$C2x_New),2))+(pow(($tot-$C2y_New),2)));
		
		if ($iterasi2D1 < $iterasi2D2){
			$anggotaC = 1;
		}else if ($iterasi2D1 > $iterasi2D2){
			$anggotaC = 0;
		}else{$anggotaC = 2;}
		
		//Menyimpan ke database
		$mySql2	= "UPDATE proses_mining SET Iterasi_4 = '".$anggotaC."',
										  Distance7 = '".$iterasi2D1."',
										  Distance8 = '".$iterasi2D2."',
										  Iterasi_5= '0', Distance9 = '0', Distance10 = '0',
										  Iterasi_6= '0', Distance11 ='0',Distance12 = '0',
										  Iterasi_7= '0', Distance13 = '0',Distance14 = '0'
										  WHERE id_produk = '".$bc."'";
		mysql_query($mySql2);
		}
		
		//Proses Iterasi 5 ----------------------------------------------------------------------------------------------
		
		//Cek Iterasi C3 dan C4, Apakah sudah sama atau belum
		$sql_info 	= "SELECT Iterasi_3 FROM proses_mining WHERE 
						Iterasi_3 = 1 AND Iterasi_4 = 0 OR
						Iterasi_3 = 0 AND Iterasi_4 = 1";
		$cek_j_c3_c4	= mysql_num_rows(mysql_query($sql_info));
		if ($cek_j_c3_c4 == 0){
			echo "$alert";
		}else if ($cek_j_c3_c4 > 0){
			
			//Mencari C1 Baru
				$cek_C1		= mysql_num_rows(mysql_query("SELECT id_produk FROM proses_mining WHERE Iterasi_4 = '1' "));
				$data_C1x_N	= mysql_fetch_array(mysql_query("SELECT SUM(stok) AS H_produk FROM produk INNER JOIN proses_mining ON produk.id_produk = proses_mining.id_produk WHERE proses_mining.Iterasi_4 = '1'"));
				$JH_C1x_N	= $data_C1x_N['H_produk'];
				
				$data_C1y_N	= mysql_fetch_array(mysql_query("SELECT SUM(total) AS J_jual FROM penjualan INNER JOIN proses_mining ON penjualan.id_produk = proses_mining.id_produk WHERE proses_mining.Iterasi_4 = '1'"));
				$JJ_C1y_N	= $data_C1y_N['J_jual'];
				
				//Mencari C2 Baru
				$cek_C2		= mysql_num_rows(mysql_query("SELECT id_produk FROM proses_mining WHERE Iterasi_4 = '0' "));
				$data_C2x_N	= mysql_fetch_array(mysql_query("SELECT SUM(stok) AS H_produk FROM produk INNER JOIN proses_mining ON produk.id_produk = proses_mining.id_produk WHERE proses_mining.Iterasi_4 = '0'"));
				$JH_C2x_N	= $data_C2x_N['H_produk'];
				
				$data_C2y_N	= mysql_fetch_array(mysql_query("SELECT SUM(total) AS J_jual FROM penjualan INNER JOIN proses_mining ON penjualan.id_produk = proses_mining.id_produk WHERE proses_mining.Iterasi_4 = '0'"));
				$JJ_C2y_N	= $data_C2y_N['J_jual'];
				//----------------------------------------------------------------------------------------------------------
				$C1x_New	= ($JH_C1x_N / $cek_C1);
				$C1y_New	= ($JJ_C1y_N / $cek_C1);
				
				$C2x_New	= ($JH_C2x_N / $cek_C2);
				$C2y_New	= ($JJ_C2y_N / $cek_C2);
				
				$cekdb9		= mysql_query("SELECT * FROM centroid WHERE id='C9'");
				$statuscek9 = mysql_num_rows($cekdb9);
				$cekdb10 	= mysql_query("SELECT * FROM centroid WHERE id='C10'");
				$statuscek10 = mysql_num_rows($cekdb10);
				if ($statuscek9 == 0){
					mysql_query("INSERT INTO centroid values ('C9','$C1x_New','$C1y_New')");
				}else{
					mysql_query("UPDATE centroid SET cx = '$C1x_New', cy='$C1y_New' WHERE id = 'C9'");
				}
				if ($statuscek10 == 0){
					mysql_query("INSERT INTO centroid values ('C10','$C2x_New','$C2y_New')");
				}else{
					mysql_query("UPDATE centroid SET cx = '$C2x_New', cy='$C2y_New' WHERE id = 'C10'");
				}
				mysql_query("DELETE FROM centroid WHERE id = 'C11'");
				mysql_query("DELETE FROM centroid WHERE id = 'C12'");
				mysql_query("DELETE FROM centroid WHERE id = 'C13'");
				mysql_query("DELETE FROM centroid WHERE id = 'C14'");
				//----------------------------------------------------------------------------------------------------------
				
			//mengambil data di database untuk dilakukan pencarian jarak pusat ke cluster
			$sql2 = mysql_query("SELECT penjualan.id_produk, penjualan.total, produk.stok FROM produk JOIN 
						   penjualan ON produk.id_produk = penjualan.id_produk ORDER BY id_produk ASC");
				while ($d2 = mysql_fetch_array($sql2)){
					
					$bc = $d2['id_produk'];
					$tot = $d2['total'];
					$hg = $d2['stok'];
				
				//pencarian jarak pusat ke cluster
				//D1 
				$iterasi2D1 = sqrt((pow(($d2['stok']-$C1x_New),2))+(pow(($tot-$C1y_New),2)));
				
				//D2
				$iterasi2D2 = sqrt((pow(($d2['stok']-$C2x_New),2))+(pow(($tot-$C2y_New),2)));
				
				if ($iterasi2D1 < $iterasi2D2){
					$anggotaC = 1;
				}else if ($iterasi2D1 > $iterasi2D2){
					$anggotaC = 0;
				}else{$anggotaC = 2;}
				
				//Menyimpan ke database
				$mySql2	= "UPDATE proses_mining SET Iterasi_5 = '".$anggotaC."',
												  Distance9 = '".$iterasi2D1."',
												  Distance10 = '".$iterasi2D2."',
												  Iterasi_6= '0', Distance11 ='0',Distance12 = '0',
												  Iterasi_7= '0', Distance13 = '0',Distance14 = '0'
												  WHERE id_produk = '".$bc."'";
				mysql_query($mySql2);
			}
			
			//Proses Iterasi 6 ----------------------------------------------------------------------------------------------
			//Cek Iterasi C4 dan C5, Apakah sudah sama atau belum
			$sql_info 	= "SELECT Iterasi_4 FROM proses_mining WHERE 
							Iterasi_4 = 1 AND Iterasi_5 = 0 OR
							Iterasi_4 = 0 AND Iterasi_5 = 1";
			$cek_j_c4_c5	= mysql_num_rows(mysql_query($sql_info));
			if ($cek_j_c4_c5 == 0){
				echo "$alert";
			}else if ($cek_j_c4_c5 > 0){
				
				//Mencari C1 Baru
					$cek_C1		= mysql_num_rows(mysql_query("SELECT id_produk FROM proses_mining WHERE Iterasi_5 = '1' "));
					$data_C1x_N	= mysql_fetch_array(mysql_query("SELECT SUM(stok) AS H_produk FROM produk INNER JOIN proses_mining ON produk.id_produk = proses_mining.id_produk WHERE proses_mining.Iterasi_5 = '1'"));
					$JH_C1x_N	= $data_C1x_N['H_produk'];
					
					$data_C1y_N	= mysql_fetch_array(mysql_query("SELECT SUM(total) AS J_jual FROM penjualan INNER JOIN proses_mining ON penjualan.id_produk = proses_mining.id_produk WHERE proses_mining.Iterasi_5 = '1'"));
					$JJ_C1y_N	= $data_C1y_N['J_jual'];
					
					//Mencari C2 Baru
					$cek_C2		= mysql_num_rows(mysql_query("SELECT id_produk FROM proses_mining WHERE Iterasi_5 = '0' "));
					$data_C2x_N	= mysql_fetch_array(mysql_query("SELECT SUM(stok) AS H_produk FROM produk INNER JOIN proses_mining ON produk.id_produk = proses_mining.id_produk WHERE proses_mining.Iterasi_5 = '0'"));
					$JH_C2x_N	= $data_C2x_N['H_produk'];
					
					$data_C2y_N	= mysql_fetch_array(mysql_query("SELECT SUM(total) AS J_jual FROM penjualan INNER JOIN proses_mining ON penjualan.id_produk = proses_mining.id_produk WHERE proses_mining.Iterasi_5 = '0'"));
					$JJ_C2y_N	= $data_C2y_N['J_jual'];
					//----------------------------------------------------------------------------------------------------------
					$C1x_New	= ($JH_C1x_N / $cek_C1);
					$C1y_New	= ($JJ_C1y_N / $cek_C1);
					
					$C2x_New	= ($JH_C2x_N / $cek_C2);
					$C2y_New	= ($JJ_C2y_N / $cek_C2);
					
					$cekdb11	= mysql_query("SELECT * FROM centroid WHERE id='C11'");
					$statuscek11= mysql_num_rows($cekdb11);
					$cekdb12 	= mysql_query("SELECT * FROM centroid WHERE id='C12'");
					$statuscek12= mysql_num_rows($cekdb12);
					if ($statuscek11 == 0){
						mysql_query("INSERT INTO centroid values ('C11','$C1x_New','$C1y_New')");
					}else{
						mysql_query("UPDATE centroid SET cx = '$C1x_New', cy='$C1y_New' WHERE id = 'C11'");
					}
					if ($statuscek12 == 0){
						mysql_query("INSERT INTO centroid values ('C12','$C2x_New','$C2y_New')");
					}else{
						mysql_query("UPDATE centroid SET cx = '$C2x_New', cy='$C2y_New' WHERE id = 'C12'");
					}
					mysql_query("DELETE FROM centroid WHERE id = 'C13'");
					mysql_query("DELETE FROM centroid WHERE id = 'C14'");
					//----------------------------------------------------------------------------------------------------------
					
				//mengambil data di database untuk dilakukan pencarian jarak pusat ke cluster
				$sql2 = mysql_query("SELECT penjualan.id_produk, penjualan.total, produk.stok FROM produk JOIN 
						   penjualan ON produk.id_produk = penjualan.id_produk ORDER BY id_produk ASC");
				while ($d2 = mysql_fetch_array($sql2)){
					
					$bc = $d2['id_produk'];
					$tot = $d2['total'];
					$hg = $d2['stok'];
					
					//pencarian jarak pusat ke cluster
					//D1 
					$iterasi2D1 = sqrt((pow(($d2['stok']-$C1x_New),2))+(pow(($tot-$C1y_New),2)));
					
					//D2
					$iterasi2D2 = sqrt((pow(($d2['stok']-$C2x_New),2))+(pow(($tot-$C2y_New),2)));
					
					if ($iterasi2D1 < $iterasi2D2){
						$anggotaC = 1;
					}else if ($iterasi2D1 > $iterasi2D2){
						$anggotaC = 0;
					}else{$anggotaC = 2;}
					
					//Menyimpan ke database
					$mySql2	= "UPDATE proses_mining SET Iterasi_6 = '".$anggotaC."',
													  Distance11 = '".$iterasi2D1."',
													  Distance12 = '".$iterasi2D2."',
													  Iterasi_7= '0', Distance13 = '0',Distance14 = '0'
													  WHERE id_produk = '".$bc."'";
					mysql_query($mySql2);
				}	
				
				//Proses Iterasi 7 ----------------------------------------------------------------------------------------------
				//Cek Iterasi C5 dan C6, Apakah sudah sama atau belum
				$sql_info 	= "SELECT Iterasi_6 FROM proses_mining WHERE 
								Iterasi_5 = 1 AND Iterasi_6 = 0 OR
								Iterasi_5 = 0 AND Iterasi_6 = 1";
				$cek_j_c5_c6	= mysql_num_rows(mysql_query($sql_info));
				if ($cek_j_c5_c6 == 0){
					echo "$alert";
				}else if ($cek_j_c5_c6 > 0){
					
					//Mencari C1 Baru
						$cek_C1		= mysql_num_rows(mysql_query("SELECT id_produk FROM proses_mining WHERE Iterasi_6 = '1' "));
						$data_C1x_N	= mysql_fetch_array(mysql_query("SELECT SUM(stok) AS H_produk FROM produk INNER JOIN proses_mining ON produk.id_produk = proses_mining.id_produk WHERE proses_mining.Iterasi_6 = '1'"));
						$JH_C1x_N	= $data_C1x_N['H_produk'];
						
						$data_C1y_N	= mysql_fetch_array(mysql_query("SELECT SUM(total) AS J_jual FROM penjualan INNER JOIN proses_mining ON penjualan.id_produk = proses_mining.id_produk WHERE proses_mining.Iterasi_6 = '1'"));
						$JJ_C1y_N	= $data_C1y_N['J_jual'];
						
						//Mencari C2 Baru
						$cek_C2		= mysql_num_rows(mysql_query("SELECT id_produk FROM proses_mining WHERE Iterasi_6 = '0' "));
						$data_C2x_N	= mysql_fetch_array(mysql_query("SELECT SUM(stok) AS H_produk FROM produk INNER JOIN proses_mining ON produk.id_produk = proses_mining.id_produk WHERE proses_mining.Iterasi_6 = '0'"));
						$JH_C2x_N	= $data_C2x_N['H_produk'];
						
						$data_C2y_N	= mysql_fetch_array(mysql_query("SELECT SUM(total) AS J_jual FROM penjualan INNER JOIN proses_mining ON penjualan.id_produk = proses_mining.id_produk WHERE proses_mining.Iterasi_6 = '0'"));
						$JJ_C2y_N	= $data_C2y_N['J_jual'];
						//----------------------------------------------------------------------------------------------------------
						$C1x_New	= ($JH_C1x_N / $cek_C1);
						$C1y_New	= ($JJ_C1y_N / $cek_C1);
						
						$C2x_New	= ($JH_C2x_N / $cek_C2);
						$C2y_New	= ($JJ_C2y_N / $cek_C2);
						
						$cekdb13	= mysql_query("SELECT * FROM centroid WHERE id='C13'");
						$statuscek13= mysql_num_rows($cekdb13);
						$cekdb14 	= mysql_query("SELECT * FROM centroid WHERE id='C14'");
						$statuscek14= mysql_num_rows($cekdb14);
						if ($statuscek13 == 0){
							mysql_query("INSERT INTO centroid values ('C13','$C1x_New','$C1y_New')");
						}else{
							mysql_query("UPDATE centroid SET cx = '$C1x_New', cy='$C1y_New' WHERE id = 'C13'");
						}
						if ($statuscek14 == 0){
							mysql_query("INSERT INTO centroid values ('C14','$C2x_New','$C2y_New')");
						}else{
							mysql_query("UPDATE centroid SET cx = '$C2x_New', cy='$C2y_New' WHERE id = 'C14'");
						}
						//----------------------------------------------------------------------------------------------------------
						
					//mengambil data di database untuk dilakukan pencarian jarak pusat ke cluster
					$sql2 = mysql_query("SELECT penjualan.id_produk, penjualan.total, produk.stok FROM produk JOIN 
						   penjualan ON produk.id_produk = penjualan.id_produk ORDER BY id_produk ASC");
					while ($d2 = mysql_fetch_array($sql2)){
						
						$bc = $d2['id_produk'];
						$tot = $d2['total'];
						$hg = $$sql = mysql_query("SELECT penjualan.id_produk, penjualan.total, produk.stok FROM produk JOIN 
						   penjualan ON produk.id_produk = penjualan.id_produk ORDER BY id_produk ASC");
						
						//pencarian jarak pusat ke cluster
						//D1 
						$iterasi2D1 = sqrt((pow(($d2['stok']-$C1x_New),2))+(pow(($tot-$C1y_New),2)));
						
						//D2
						$iterasi2D2 = sqrt((pow(($d2['stok']-$C2x_New),2))+(pow(($tot-$C2y_New),2)));
						
						if ($iterasi2D1 < $iterasi2D2){
							$anggotaC = 1;
						}else if ($iterasi2D1 > $iterasi2D2){
							$anggotaC = 0;
						}else{$anggotaC = 2;}
						
						//Menyimpan ke database
						$mySql2	= "UPDATE proses_mining SET Iterasi_6 = '".$anggotaC."',
														  Distance13 = '".$iterasi2D1."',
														  Distance14 = '".$iterasi2D2."' 
														  WHERE id_produk = '".$bc."'";
						mysql_query($mySql2);
					}
				}
			}
		}
	}
}
	include "../koneksi.php";
	$idmax = mysql_fetch_array(mysql_query("SELECT * FROM centroid ORDER BY id DESC Limit 0,1"));
	$idmax2 = str_replace("C","",$idmax['id']);
	$idmax2 = $idmax2 - 1;
	$idmax2 = "C".$idmax2;
	// Centroid
	$titikx = mysql_query("SELECT * FROM centroid where id='".$idmax['id']."'");
	$titiky = mysql_query("SELECT * FROM centroid where id='".$idmax2."'");
	$x = mysql_fetch_array($titikx);
	$y = mysql_fetch_array($titiky);
	
	$dx = $x['cx'];
	$dy = $x['cy'];
	$d2x = $y['cx'];
	$d2y = $y['cy'];
	
	$myFilec = "centroid.php";
	$fhc = fopen($myFilec, 'w') or die("can't open file");
	$yourVariablec = "<?php \$datx = array($dx,$d2x); 
	\$daty = array($dy,$d2y); ?>\n";
	fwrite($fhc, $yourVariablec);
	fclose($fhc);
	
	// titik
	$cekiterasi3 = mysql_num_rows(mysql_query("SELECT * FROM proses_mining where Iterasi_3 ='1'"));
	$cekiterasi4 = mysql_num_rows(mysql_query("SELECT * FROM proses_mining where Iterasi_4 ='1'"));
	$cekiterasi5 = mysql_num_rows(mysql_query("SELECT * FROM proses_mining where Iterasi_5 ='1'"));
	$cekiterasi6 = mysql_num_rows(mysql_query("SELECT * FROM proses_mining where Iterasi_6 ='1'"));
	$cekiterasi7 = mysql_num_rows(mysql_query("SELECT * FROM proses_mining where Iterasi_7 ='1'"));
	
	if($cekiterasi3 == 0){ 
		$qryh = mysql_query("SELECT * FROM proses_mining where Iterasi_2 ='1'");
		$qryo = mysql_query("SELECT * FROM proses_mining where Iterasi_2 ='0'");
		$DS ="Distance3";
		$DS2 ="Distance4";
	}else
	if($cekiterasi4 == 0){ 
		$qryh = mysql_query("SELECT * FROM proses_mining where Iterasi_3 ='1'"); 
		$qryo = mysql_query("SELECT * FROM proses_mining where Iterasi_3 ='0'");
		$DS ="Distance5";
		$DS2 ="Distance6";
	}else
	if($cekiterasi5 == 0){
		$qryh = mysql_query("SELECT * FROM proses_mining where Iterasi_4 ='1'"); 
		$qryo = mysql_query("SELECT * FROM proses_mining where Iterasi_4 ='0'");
		$DS ="Distance7";
		$DS2 ="Distance8";
	}else
	if($cekiterasi6 == 0){
		$qryh = mysql_query("SELECT * FROM proses_mining where Iterasi_5 ='1'"); 
		$qryo = mysql_query("SELECT * FROM proses_mining where Iterasi_5 ='0'");
		$DS ="Distance9";
		$DS2 ="Distance10";
	}else
	if($cekiterasi7 == 0){ 
		$qryh = mysql_query("SELECT * FROM proses_mining where Iterasi_6 ='1'");
		$qryo = mysql_query("SELECT * FROM proses_mining where Iterasi_6 ='0'"); 
		$DS ="Distance11";
		$DS2 ="Distance12";
	}
	
	mysql_query("TRUNCATE data_titik");
	mysql_query("INSERT INTO data_titik VALUES ('x','')");
	mysql_query("INSERT INTO data_titik VALUES ('y','')");
	mysql_query("INSERT INTO data_titik VALUES ('x1','')");
	mysql_query("INSERT INTO data_titik VALUES ('y1','')");
	while($titikx2 = mysql_fetch_array($qryh)){
		$qryambildatax = mysql_query("SELECT * FROM data_titik WHERE id='x'");
		$dataisix = mysql_fetch_array($qryambildatax);
		$qryambildatay = mysql_query("SELECT * FROM data_titik WHERE id='y'");
		$dataisiy = mysql_fetch_array($qryambildatay);
		$data_lamax = $dataisix['titik'];
		$data_lamay = $dataisiy['titik'];
		
		$dx2 = number_format($titikx2[$DS],2);
		$dy2 = number_format($titikx2[$DS2],2);
		if($data_lamax == ""){
		$databarux = $dx2.",";
		$databaruy = $dy2.",";
		}else{
		$databarux = $data_lamax.$dx2.",";
		$databaruy = $data_lamay.$dy2.",";
		}
		mysql_query("UPDATE data_titik SET titik ='$databarux' WHERE id='x'");
		mysql_query("UPDATE data_titik SET titik ='$databaruy' WHERE id='y'");
	}
	while($titikx3 = mysql_fetch_array($qryo)){
		$qryambildatax3 = mysql_query("SELECT * FROM data_titik WHERE id='x1'");
		$dataisix3 = mysql_fetch_array($qryambildatax3);
		$qryambildatay3 = mysql_query("SELECT * FROM data_titik WHERE id='y1'");
		$dataisiy3 = mysql_fetch_array($qryambildatay3);
		$data_lamax3 = $dataisix3['titik'];
		$data_lamay3 = $dataisiy3['titik'];
		
		$dx3 = number_format($titikx3[$DS],2);
		$dy3 = number_format($titikx3[$DS2],2);
		if($data_lamax3 == ""){
		$databarux3 = $dx3.",";
		$databaruy3 = $dy3.",";
		}else{
		$databarux3 = $data_lamax3.$dx3.",";
		$databaruy3 = $data_lamay3.$dy3.",";

		}
		mysql_query("UPDATE data_titik SET titik ='$databarux3' WHERE id='x1'");
		mysql_query("UPDATE data_titik SET titik ='$databaruy3' WHERE id='y1'");
	}
	
	$ambildatax  = mysql_fetch_array(mysql_query("SELECT * FROM data_titik where id ='x'"));
	$ambildatax1 = mysql_fetch_array(mysql_query("SELECT * FROM data_titik where id ='x1'"));
	$ambildatay  = mysql_fetch_array(mysql_query("SELECT * FROM data_titik where id ='y'"));
	$ambildatay1 = mysql_fetch_array(mysql_query("SELECT * FROM data_titik where id ='y1'"));
	$isidatax  = $ambildatax['titik'];
	$isidatax1 = $ambildatax1['titik'];
	
	$isidatay  = $ambildatay['titik'];
	$isidatay1 = $ambildatay1['titik'];
	
	//$data_1 = $isidatax.$isidatax1;
	//$data_2 = $isidatay.$isidatay1;
	
	$myFile = "titik.php";
	$fh = fopen($myFile, 'w') or die("can't open file");
	$yourVariable = 
	"<?php \$datax = array($isidatax); \$datay = array($isidatay);\$datax2 = array($isidatax1); \$datay2 = array($isidatay1); ?>\n";
	fwrite($fh, $yourVariable);
	fclose($fh);
	
echo "<meta http-equiv='refresh' content='0; url=mining.php'>";
?>
	</div>
    	</div>
	<!-- jQuery 2.1.3 -->
    <script src="plugins/jQuery/jQuery-2.1.3.min.js"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <!-- SlimScroll -->
    <script src="plugins/slimScroll/jquery.slimScroll.min.js" type="text/javascript"></script>
    <!-- FastClick -->
    <script src='plugins/fastclick/fastclick.min.js'></script>
    <!-- AdminLTE App -->
    <script src="dist/js/app.min.js" type="text/javascript"></script>
    <!-- DATA TABES SCRIPT -->
    <script src="plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
    <script src="plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
    <!-- page script -->
    <script type="text/javascript">
      $(function () {
        $('#example2').dataTable({
          "bPaginate": true,
          "bLengthChange": true,
          "bFilter": true,
          "bSort": false,
          "bInfo": true,
          "bAutoWidth": false
        });
      });
    </script>
  </body>
</html>