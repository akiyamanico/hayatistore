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
<body>
    <div id="wrapper">
        <!-- Navigation -->
        <?php 
		include "../inc.session.php";
		include "../inc.fungsi.php";
		include "../koneksi.php";
		include "header-and-menu.php";
		?>

        <div id="page-wrapper">
            <p>&nbsp;</p>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                           Detail Iterasi Produk
                      </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                        <p><a class="btn btn-sm btn-info" href="mining.php">
                        	<i class="fa fa-arrow-left"> Kembali</i></a></p>
                          <table class="table table-bordered table-hover">
					<?php
                        $centroid  = mysql_query("SELECT * FROM centroid Order By id ASC");
                      while( $d_cent	 = mysql_fetch_array($centroid)){
                    ?>
                      <tr>
                        <td>
                        <?php echo $d_cent['id']?> = <?php echo $d_cent['cx']?> ; <?php echo $d_cent['cy']?>
                        </td>
                      </tr>
                    <?php }?>
                    </table>
                          <table class="table table-bordered table-hover">
                            <thead>
                              <tr>
                                <th>id_produk</th>
                                <th>Nama Produk</th>
                                <th>Stok</th>
                                <th>Penjualan</th>
                                <th width="15%">Cluster</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                              <?php
                                    $sql_tab_data2 	= "SELECT * FROM produk JOIN 
                                                            kategori ON produk.id_kategori = kategori.id_kategori JOIN
                                                            penjualan ON produk.id_produk = penjualan.id_produk WHERE produk.id_produk='".$_GET['id_produk']."'";
                                    $query_tab_data2= mysql_query($sql_tab_data2);
        
                                    $d = mysql_fetch_array($query_tab_data2);
                                    $hg = $d['stok'];
                                    $tot= $d['total'];
                                        
                                    $bc   = $d['id_produk'];
                                    $nama = $d['nama'];
                              ?>
                                <td><?php echo $bc ?></td>
                                <td><?php echo $nama?></td>
                                <td><?php echo $hg?></td>
                                <td><?php echo $tot?></td>
                                <td>M = {<?php echo $hg?> ; <?php echo $tot?>}</td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                        <div class="panel-body">
                          <table class="table table-bordered">
                    <thead>
                      <tr>
                        <?php
                          $sql_cek_1 = "SELECT Iterasi_1 FROM proses_mining WHERE 
										Iterasi_1 = 1 AND Iterasi_2 = 0 OR
										Iterasi_1 = 0 AND Iterasi_2 = 1";
                          $cs1 = mysql_num_rows(mysql_query($sql_cek_1));
                          if ($cs1 == 0){ 
                                ?> 
                                <th colspan="2" style="text-align:center">Iterasi 1</th> 
                                <th colspan="2" style="text-align:center">Iterasi 2</th> 
                                <?php
                          }else if ($cs1 > 0) {
                              $sql_cek_2 = "SELECT Iterasi_2 FROM proses_mining WHERE 
											Iterasi_2 = 1 AND Iterasi_3 = 0 OR
											Iterasi_2 = 0 AND Iterasi_3 = 1";
                              $cs2 = mysql_num_rows(mysql_query($sql_cek_2));
                              
                              if ($cs2 == 0){ 
                                  ?> 
                                  <th colspan="2" style="text-align:center">Iterasi 1</th> 
                                  <th colspan="2" style="text-align:center">Iterasi 2</th>
                                  <th colspan="2" style="text-align:center">Iterasi 3</th>
                                  <?php 
                              }else if ($cs2 > 0) {
                                  $sql_cek_3 = "SELECT Iterasi_3 FROM proses_mining WHERE 
                                      Iterasi_3 = 1 AND Iterasi_4 = 0 OR
                                      Iterasi_3 = 0 AND Iterasi_4 = 1";
                                  $cs3 = mysql_num_rows(mysql_query($sql_cek_3));
                                  if ($cs3 == 0){ 
                                      ?> 
                                      <th colspan="2" style="text-align:center">Iterasi 1</th> 
                                      <th colspan="2" style="text-align:center">Iterasi 2</th>
                                      <th colspan="2" style="text-align:center">Iterasi 3</th>
                                      <th colspan="2" style="text-align:center">Iterasi 4</th> 
                                      <?php 
                                  }else if ($cs3 > 0) {
                                      $sql_cek_4 = "SELECT Iterasi_4 FROM proses_mining WHERE 
                                          Iterasi_4 = 1 AND Iterasi_5 = 0 OR
                                          Iterasi_4 = 0 AND Iterasi_5 = 1";
                                      $cs4 = mysql_num_rows(mysql_query($sql_cek_4));
                                      if ($cs4 == 0){ 
                                            ?> 
                                            <th colspan="2" style="text-align:center">Iterasi 1</th> 
                                            <th colspan="2" style="text-align:center">Iterasi 2</th>
                                            <th colspan="2" style="text-align:center">Iterasi 3</th>
                                            <th colspan="2" style="text-align:center">Iterasi 4</th>
                                            <th colspan="2" style="text-align:center">Iterasi 5</th>
                                            <?php 
                                      } else if ($cs4 > 0) {
                                          $sql_cek_5 = "SELECT Iterasi_5 FROM proses_mining WHERE 
                                              Iterasi_5 = 1 AND Iterasi_6 = 0 OR
                                              Iterasi_5 = 0 AND Iterasi_6 = 1";
                                          $cs5 = mysql_num_rows(mysql_query($sql_cek_5));
                                          if ($cs5 == 0){ 
                                                ?> 
                                                <th colspan="2" style="text-align:center">Iterasi 1</th> 
                                                <th colspan="2" style="text-align:center">Iterasi 2</th>
                                                <th colspan="2" style="text-align:center">Iterasi 3</th>
                                                <th colspan="2" style="text-align:center">Iterasi 4</th>
                                                <th colspan="2" style="text-align:center">Iterasi 5</th>
                                                <th colspan="2" style="text-align:center">Iterasi 6</th>
                                                <?php 
                                          } else if ($cs5 > 0) {
                                              $sql_cek_6 = "SELECT Iterasi_6 FROM proses_mining WHERE 
                                                  Iterasi_6 = 1 AND Iterasi_7 = 0 OR
                                                  Iterasi_6 = 0 AND Iterasi_7 = 1";
                                              $cs6 = mysql_num_rows(mysql_query($sql_cek_6));
                                              if ($cs6 == 0){ 
                                                    ?> 
                                                    <th colspan="2" style="text-align:center">Iterasi 1</th> 
                                                    <th colspan="2" style="text-align:center">Iterasi 2</th>
                                                    <th colspan="2" style="text-align:center">Iterasi 3</th>
                                                    <th colspan="2" style="text-align:center">Iterasi 4</th>
                                                    <th colspan="2" style="text-align:center">Iterasi 5</th>
                                                    <th colspan="2" style="text-align:center">Iterasi 6</th>
                                                    <th colspan="2" style="text-align:center">Iterasi 7</th>  
                                                    <?php 
                                              }
                                          }
                                      }
                                  }
                              }
                          }
                          ?>
                      </tr>
                    </thead>
                    <tbody>
                    <?php
						$c1  = mysql_fetch_array(mysql_query("SELECT * FROM centroid WHERE id='C1'"));
                      	$c2  = mysql_fetch_array(mysql_query("SELECT * FROM centroid WHERE id='C2'"));
						$c3  = mysql_fetch_array(mysql_query("SELECT * FROM centroid WHERE id='C3'"));
						$c4  = mysql_fetch_array(mysql_query("SELECT * FROM centroid WHERE id='C4'"));
						$c5  = mysql_fetch_array(mysql_query("SELECT * FROM centroid WHERE id='C5'"));
						$c6  = mysql_fetch_array(mysql_query("SELECT * FROM centroid WHERE id='C6'"));
						$c7  = mysql_fetch_array(mysql_query("SELECT * FROM centroid WHERE id='C7'"));
                      	$c8  = mysql_fetch_array(mysql_query("SELECT * FROM centroid WHERE id='C8'"));
						$c9  = mysql_fetch_array(mysql_query("SELECT * FROM centroid WHERE id='C9'"));
						$c10  = mysql_fetch_array(mysql_query("SELECT * FROM centroid WHERE id='C10'"));
						$c11  = mysql_fetch_array(mysql_query("SELECT * FROM centroid WHERE id='C11'"));
						$c12  = mysql_fetch_array(mysql_query("SELECT * FROM centroid WHERE id='C12'"));
						$c13  = mysql_fetch_array(mysql_query("SELECT * FROM centroid WHERE id='C13'"));
						$c14  = mysql_fetch_array(mysql_query("SELECT * FROM centroid WHERE id='C14'"));
						
						$c3x = number_format($c3['cx'],2);   $c7x = number_format($c7['cx'],2);
						$c3y = number_format($c3['cy'],2);   $c7y = number_format($c7['cy'],2);
						$c4x = number_format($c4['cx'],2);   $c8x = number_format($c8['cx'],2);
						$c4y = number_format($c4['cy'],2);   $c8y = number_format($c8['cy'],2);
						$c5x = number_format($c5['cx'],2);   $c9x = number_format($c9['cx'],2);
						$c5y = number_format($c5['cy'],2);   $c9y = number_format($c9['cy'],2);
						$c6x = number_format($c6['cx'],2);   $c10x = number_format($c10['cx'],2);
						$c6y = number_format($c6['cy'],2);   $c10y = number_format($c10['cy'],2);
						
						$c11x = number_format($c11['cx'],2); $c13x = number_format($c13['cx'],2);
						$c11y = number_format($c11['cy'],2); $c13y = number_format($c13['cy'],2); 
						$c12x = number_format($c12['cx'],2); $c14x = number_format($c14['cx'],2);
						$c12y = number_format($c12['cy'],2); $c14y = number_format($c14['cy'],2); 
						
                        $sql_tab_iterasi = "SELECT * FROM proses_mining INNER JOIN
                                                     produk ON proses_mining.id_produk = produk.id_produk WHERE 
													 proses_mining.id_proses = '".$_GET['id_proses']."' ORDER BY produk.nama ASC";
                        $query_tab_iterasi = mysql_query($sql_tab_iterasi);
                        $no=0;
                        while ($dti = mysql_fetch_array($query_tab_iterasi)){
                            $sql_tab_data 	= "SELECT * FROM produk JOIN 
                                                    kategori ON produk.id_kategori = kategori.id_kategori JOIN
                                                    penjualan ON produk.id_produk = penjualan.id_produk WHERE produk.id_produk='".$dti['id_produk']."'";
                            $query_tab_data	= mysql_query($sql_tab_data);
                            $d = mysql_fetch_array($query_tab_data);
                            $hg = $d['stok'];
                            $tot= $d['total'];
                                
                            $bc   = $dti['id_produk'];
                            $nama = $dti['nama'];
                            $no++;
                            $Dc_1 = number_format($dti['Distance1'],2);		$Dc_7 = number_format($dti['Distance7'],2);
                            $Dc_2 = number_format($dti['Distance2'],2);		$Dc_8 = number_format($dti['Distance8'],2);	
                            $Dc_3 = number_format($dti['Distance3'],2);		$Dc_9 = number_format($dti['Distance9'],2);
                            $Dc_4 = number_format($dti['Distance4'],2);		$Dc_10 = number_format($dti['Distance10'],2);
                            $Dc_5 = number_format($dti['Distance5'],2);		$Dc_11 = number_format($dti['Distance11'],2);
                            $Dc_6 = number_format($dti['Distance6'],2);		$Dc_12 = number_format($dti['Distance12'],2);
                                                                            $Dc_13 = number_format($dti['Distance13'],2);
                                                                            $Dc_14 = number_format($dti['Distance14'],2);
                            
                            if (($dti['Distance1'] < $dti['Distance2']) or 
                                  ($dti['Distance5'] < $dti['Distance6']) or 
                                    ($dti['Distance9'] < $dti['Distance10']) or
                                        ($dti['Distance13'] < $dti['Distance14'])){
                                          $Dc_1 = "<span class='text-red'>$Dc_1</span>";
                                          $Dc_5 = "<span class='text-red'>$Dc_5</span>";
                                          $Dc_9 = "<span class='text-red'>$Dc_9</span>";
                                          $Dc_13 = "<span class='text-red'>$Dc_13</span>";
                            }
                            
                            if (($dti['Distance2'] < $dti['Distance1']) or
                                  ($dti['Distance6'] < $dti['Distance5']) or
                                    ($dti['Distance10'] < $dti['Distance9'])){
                                      $Dc_2 = "<span class='text-red'>$Dc_2</span>";
                                      $Dc_6 = "<span class='text-red'>$Dc_6</span>";
                                      $Dc_10 = "<span class='text-red'>$Dc_10</span>";
                            }
                            
                            if (($dti['Distance3'] < $dti['Distance4']) or 
                                  ($dti['Distance7'] < $dti['Distance8']) or
                                    ($dti['Distance11'] < $dti['Distance12'])){
                                      $Dc_3 = "<span class='text-blue'>$Dc_3</span>";
                                      $Dc_7 = "<span class='text-blue'>$Dc_7</span>";
                                      $Dc_11= "<span class='text-blue'>$Dc_11</span>";
                            }
                            if (($dti['Distance4'] < $dti['Distance3']) or 
                                  ($dti['Distance8'] < $dti['Distance7']) or
                                    ($dti['Distance12'] < $dti['Distance11'])){
                                      $Dc_4 = "<span class='text-blue'>$Dc_4</span>";
                                      $Dc_8 = "<span class='text-blue'>$Dc_8</span>";
                                      $Dc_12 = "<span class='text-blue'>$Dc_12</span>";
                            }
                        ?>
                        
                      <tr>
                        
                          <?php
                          $sql_cek_1 = "SELECT Iterasi_1 FROM proses_mining WHERE 
                                    Iterasi_1 = 1 AND Iterasi_2 = 0 OR
                                    Iterasi_1 = 0 AND Iterasi_2 = 1";
                          $cs1 = mysql_num_rows(mysql_query($sql_cek_1));
                          if ($cs1 == 0){ 
                                ?> 
                                <td align="center">
                                D = &radic; (<?php echo $hg?>-<?php echo $c1['cx']?>)&sup2; + (<?php echo $tot?>-<?php echo $c1['cy']?>)&sup2; = <?php echo $Dc_1?></td>
                                <td align="center">
								D = &radic; (<?php echo $hg?>-<?php echo $c2['cx']?>)&sup2; + (<?php echo $tot?>-<?php echo $c2['cy']?>)&sup2; = <?php echo $Dc_2?></td>
                                <td align="center">
								D = &radic; (<?php echo $hg?>-<?php echo $c3x?>)&sup2; + (<?php echo $tot?>-<?php echo $c3y?>)&sup2; = <?php echo $Dc_3?></td>
                                <td align="center">
								D = &radic; (<?php echo $hg?>-<?php echo $c4x?>)&sup2; + (<?php echo $tot?>-<?php echo $c4y?>)&sup2; = <?php echo $Dc_4?></td>
                                <?php
                          }else if ($cs1 > 0) {
                              $sql_cek_2 = "SELECT Iterasi_2 FROM proses_mining WHERE 
                                    Iterasi_2 = 1 AND Iterasi_3 = 0 OR
                                    Iterasi_2 = 0 AND Iterasi_3 = 1";
                              $cs2 = mysql_num_rows(mysql_query($sql_cek_2));
                              
                              if ($cs2 == 0){ 
                                  ?> 
                                    <td align="center">
                                D = &radic; (<?php echo $hg?>-<?php echo $c1['cx']?>)&sup2; + (<?php echo $tot?>-<?php echo $c1['cy']?>)&sup2; = <?php echo $Dc_1?></td>
                                <td align="center">
								D = &radic; (<?php echo $hg?>-<?php echo $c2['cx']?>)&sup2; + (<?php echo $tot?>-<?php echo $c2['cy']?>)&sup2; = <?php echo $Dc_2?></td>
                                <td align="center" bgcolor="#DDDDDD">
								D = &radic; (<?php echo $hg?>-<?php echo $c3x?>)&sup2; + (<?php echo $tot?>-<?php echo $c3y?>)&sup2; = <?php echo $Dc_3?></td>
                                <td align="center" bgcolor="#DDDDDD">
								D = &radic; (<?php echo $hg?>-<?php echo $c4x?>)&sup2; + (<?php echo $tot?>-<?php echo $c4y?>)&sup2; = <?php echo $Dc_4?></td>
                                    <td align="center">
								D = &radic; (<?php echo $hg?>-<?php echo $c5x?>)&sup2; + (<?php echo $tot?>-<?php echo $c5y?>)&sup2; = <?php echo $Dc_5?></td>
                                <td align="center">
								D = &radic; (<?php echo $hg?>-<?php echo $c6x?>)&sup2; + (<?php echo $tot?>-<?php echo $c6y?>)&sup2; = <?php echo $Dc_6?></td>
                                  <?php 
                              }else if ($cs2 > 0) {
                                  $sql_cek_3 = "SELECT Iterasi_3 FROM proses_mining WHERE 
                                      Iterasi_3 = 1 AND Iterasi_4 = 0 OR
                                      Iterasi_3 = 0 AND Iterasi_4 = 1";
                                  $cs3 = mysql_num_rows(mysql_query($sql_cek_3));
                                  if ($cs3 == 0){ 
                                      ?> 
                                        D = &radic; (<?php echo $hg?>-<?php echo $c1['cx']?>)&sup2; + (<?php echo $tot?>-<?php echo $c1['cy']?>)&sup2; = <?php echo $Dc_1?></td>
                                        <td align="center">
                                        D = &radic; (<?php echo $hg?>-<?php echo $c2['cx']?>)&sup2; + (<?php echo $tot?>-<?php echo $c2['cy']?>)&sup2; = <?php echo $Dc_2?></td>
                                        <td align="center" bgcolor="#DDDDDD">
                                        D = &radic; (<?php echo $hg?>-<?php echo $c3x?>)&sup2; + (<?php echo $tot?>-<?php echo $c3y?>)&sup2; = <?php echo $Dc_3?></td>
                                        <td align="center" bgcolor="#DDDDDD">
                                        D = &radic; (<?php echo $hg?>-<?php echo $c4x?>)&sup2; + (<?php echo $tot?>-<?php echo $c4y?>)&sup2; = <?php echo $Dc_4?></td>
                                            <td align="center">
                                        D = &radic; (<?php echo $hg?>-<?php echo $c5x?>)&sup2; + (<?php echo $tot?>-<?php echo $c5y?>)&sup2; = <?php echo $Dc_5?></td>
                                        <td align="center">
                                        D = &radic; (<?php echo $hg?>-<?php echo $c6x?>)&sup2; + (<?php echo $tot?>-<?php echo $c6y?>)&sup2; = <?php echo $Dc_6?></td> 
                                        <td align="center" bgcolor="#DDDDDD">
										D = &radic; (<?php echo $hg?>-<?php echo $c7x?>)&sup2; + (<?php echo $tot?>-<?php echo $c7y?>)&sup2; = <?php echo $Dc_7?></td>
                                        <td align="center" bgcolor="#DDDDDD">
										D = &radic; (<?php echo $hg?>-<?php echo $c8x?>)&sup2; + (<?php echo $tot?>-<?php echo $c8y?>)&sup2; = <?php echo $Dc_8?></td>
                                      <?php 
                                  }else if ($cs3 > 0) {
                                      $sql_cek_4 = "SELECT Iterasi_4 FROM proses_mining WHERE 
                                          Iterasi_4 = 1 AND Iterasi_5 = 0 OR
                                          Iterasi_4 = 0 AND Iterasi_5 = 1";
                                      $cs4 = mysql_num_rows(mysql_query($sql_cek_4));
                                      if ($cs4 == 0){ 
                                            ?> 
                                            D = &radic; (<?php echo $hg?>-<?php echo $c1['cx']?>)&sup2; + (<?php echo $tot?>-<?php echo $c1['cy']?>)&sup2; = <?php echo $Dc_1?></td>
                                            <td align="center">
                                            D = &radic; (<?php echo $hg?>-<?php echo $c2['cx']?>)&sup2; + (<?php echo $tot?>-<?php echo $c2['cy']?>)&sup2; = <?php echo $Dc_2?></td>
                                            <td align="center" bgcolor="#DDDDDD">
                                            D = &radic; (<?php echo $hg?>-<?php echo $c3x?>)&sup2; + (<?php echo $tot?>-<?php echo $c3y?>)&sup2; = <?php echo $Dc_3?></td>
                                            <td align="center" bgcolor="#DDDDDD">
                                            D = &radic; (<?php echo $hg?>-<?php echo $c4x?>)&sup2; + (<?php echo $tot?>-<?php echo $c4y?>)&sup2; = <?php echo $Dc_4?></td>
                                                <td align="center">
                                            D = &radic; (<?php echo $hg?>-<?php echo $c5x?>)&sup2; + (<?php echo $tot?>-<?php echo $c5y?>)&sup2; = <?php echo $Dc_5?></td>
                                            <td align="center">
                                            D = &radic; (<?php echo $hg?>-<?php echo $c6x?>)&sup2; + (<?php echo $tot?>-<?php echo $c6y?>)&sup2; = <?php echo $Dc_6?></td> 
                                            <td align="center" bgcolor="#DDDDDD">
                                            D = &radic; (<?php echo $hg?>-<?php echo $c7x?>)&sup2; + (<?php echo $tot?>-<?php echo $c7y?>)&sup2; = <?php echo $Dc_7?></td>
                                            <td align="center" bgcolor="#DDDDDD">
                                            D = &radic; (<?php echo $hg?>-<?php echo $c8x?>)&sup2; + (<?php echo $tot?>-<?php echo $c8y?>)&sup2; = <?php echo $Dc_8?></td> 
                                            <td align="center">
											D = &radic; (<?php echo $hg?>-<?php echo $c9x?>)&sup2; + (<?php echo $tot?>-<?php echo $c9y?>)&sup2; = <?php echo $Dc_9?></td>
                                            <td align="center">
											D = &radic; (<?php echo $hg?>-<?php echo $c10x?>)&sup2; + (<?php echo $tot?>-<?php echo $c10y?>)&sup2; = <?php echo $Dc_10?></td>
                                            <?php 
                                      } else if ($cs4 > 0) {
                                          $sql_cek_5 = "SELECT Iterasi_5 FROM proses_mining WHERE 
                                              Iterasi_5 = 1 AND Iterasi_6 = 0 OR
                                              Iterasi_5 = 0 AND Iterasi_6 = 1";
                                          $cs5 = mysql_num_rows(mysql_query($sql_cek_5));
                                          if ($cs5 == 0){ 
                                                ?> 
                                                <td align="center"><?php echo $Dc_1?></td>
                                                <td align="center"><?php echo $Dc_2?></td>
                                                <td align="center"><?php echo $Dc_3?></td>
                                                <td align="center"><?php echo $Dc_4?></td>
                                                <td align="center"><?php echo $Dc_5?></td>
                                                <td align="center"><?php echo $Dc_6?></td> 
                                                <td align="center"><?php echo $Dc_7?></td>
                                                <td align="center"><?php echo $Dc_8?></td> 
                                                <td align="center"><?php echo $Dc_9?></td>
                                                <td align="center"><?php echo $Dc_10?></td>
                                                <td align="center"><?php echo $Dc_11?></td>
                                                <td align="center"><?php echo $Dc_12?></td> 
                                                <?php 
                                          } else if ($cs5 > 0) {
                                              $sql_cek_6 = "SELECT Iterasi_6 FROM proses_mining WHERE 
                                                  Iterasi_6 = 1 AND Iterasi_7 = 0 OR
                                                  Iterasi_6 = 0 AND Iterasi_7 = 1";
                                              $cs6 = mysql_num_rows(mysql_query($sql_cek_6));
                                              if ($cs6 == 0){ 
                                                    ?> 
                                                    <td align="center"><?php echo $Dc_1?></td>
                                                    <td align="center"><?php echo $Dc_2?></td>
                                                    <td align="center"><?php echo $Dc_3?></td>
                                                    <td align="center"><?php echo $Dc_4?></td>
                                                    <td align="center"><?php echo $Dc_5?></td>
                                                    <td align="center"><?php echo $Dc_6?></td> 
                                                    <td align="center"><?php echo $Dc_7?></td>
                                                    <td align="center"><?php echo $Dc_8?></td> 
                                                    <td align="center"><?php echo $Dc_9?></td>
                                                    <td align="center"><?php echo $Dc_10?></td>
                                                    <td align="center"><?php echo $Dc_11?></td>
                                                    <td align="center"><?php echo $Dc_12?></td>
                                                    <td align="center"><?php echo $Dc_13?></td>
                                                    <td align="center"><?php echo $Dc_14?></td>
                                                    <?php 
                                              }
                                          }
                                      }
                                  }
                              }
                          }
                      }
                    ?>
                    
                    </tbody>
                  </table>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="../vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../vendor/metisMenu/metisMenu.min.js"></script>

    <!-- DataTables JavaScript -->
    <script src="../vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="../vendor/datatables-responsive/dataTables.responsive.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });
    </script>

</body>

</html>
