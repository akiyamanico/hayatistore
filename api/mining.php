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
	<style>
	.loader {
		position: fixed;
		left: 10px;
		top: 0px;
		width: 100%;
		height: 100%;
		z-index: 9999;
		background: url("js/load.gif") 50% 50% no-repeat rgb(249,249,249);
		opacity: .8;
	}
	</style>
	<script src="js/jquery2.2.4jquery.min.js"></script>
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
		include "inc.session.php";
		include "inc.fungsi.php";
		include "koneksi.php";
		include "header-and-menu.php";
		?>

        <div id="page-wrapper">
            <p>&nbsp;</p>
            
            <div class="row">
            	<div class="col-lg-12">
                	<div class="text-center">
                    	<div class='col-lg-10 col-lg-offset-1 text-center'>
                          <div class='alert alert-info alert-dismissible' role='alert'>
                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                              <span aria-hidden='true'>&times;</span>
                            </button><i class="fa fa-xs fa-info-circle"></i> Jika melakukan perubahan data produk, data titik pusat, dan data penjualan. Lakukan perhitungan ulang hasil <br>[algoritma K-Means] dengan menekan tombol dibawah ini!!
                          </div>
                          </div>
                          <?php
						  if(isset($_POST['btnex'])){
							  echo "<div class='loader'></div>";
							  echo "<meta http-equiv='refresh' content='0; url=proses_mining.php'>";
							  }
                          ?>
                        <form role="form" name="form" method="post" enctype="multipart/form-data">  
                        <button type="submit" name="btnex" class="btn btn-lg btn-success"> <i class="fa fa-fw fa-refresh"></i> Hitung Ulang Euclidean Distance (Algoritma K-Means)</button>
                        </form>
                    </div>
                </div>
            </div>
            
                <p>&nbsp;</p>
                <div class="col-lg-12">
                	<div class="panel panel-primary">
                        <div class="panel-heading">Centroid</div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                        	<p><a href="hasil.php" class="btn btn-success"><i class="fa fa-fw fa-universal-access"></i> Hasil</a>
                               <a href="diagram.php" target="_blank" class="btn btn-sm btn-info">
                           <i class="fa fa-fw fa-cube"></i> Diagram</a></p>
                            <table class="table table-bordedanger table-hover">
                            <?php
							   	$centroid  = mysql_query("SELECT * FROM centroid");
							  while( $d_cent	 = mysql_fetch_array($centroid)){
							?>
                              <tr>
                            	<td>
								<?php echo $d_cent['id']?> = <?php echo $d_cent['cx']?> ; <?php echo $d_cent['cy']?>
                                <?php if(($d_cent['id'] == 'C1') or ($d_cent['id'] == 'C2')){}else{ ?>
								<a href="detail-c.php?c=<?php echo $d_cent['id']?>" class="btn btn-xs btn-success pull-right"><i class="fa fa-eye"></i> Pencarian Nilai <?php echo $d_cent['id']?></a>
								<?php } ?>
                                </td>
                              </tr>
                            <?php }?>
                            </table>
                          <table class="table table-bordedanger table-hover">
                            <thead>
                              <tr>
                                <th>Nama Produk</th>
                                <th width="15%">Cluster</th>
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
                                  <th width="2%">Detail</th>
                              </tr>
                            </thead>
                            <tbody>
                            <?php
                                $sql_tab_iterasi = "SELECT * FROM proses_mining INNER JOIN
															 produk ON proses_mining.id_produk = produk.id_produk ORDER BY produk.nama ASC";
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
									
                           		?>
                                
                              <tr>
                                <td><?php echo $nama?></td>
                                <td>M<?php echo $no?> = {<?php echo $hg?> ; <?php echo $tot?>}</td>
                                  <?php
                                  $sql_cek_1 = "SELECT Iterasi_1 FROM proses_mining WHERE 
								  			Iterasi_1 = 1 AND Iterasi_2 = 0 OR
										 	Iterasi_1 = 0 AND Iterasi_2 = 1";
								  $cs1 = mysql_num_rows(mysql_query($sql_cek_1));
								  if ($cs1 == 0){ 
										?> 
                                        <td align="center" bgcolor="#BBBBBB"><?php echo $Dc_1?></td>
                                        <td align="center" bgcolor="#BBBBBB"><?php echo $Dc_2?></td>
                                        <td align="center"><?php echo $Dc_3?></td>
                                        <td align="center"><?php echo $Dc_4?></td>
										<?php
								  }else if ($cs1 > 0) {
									  $sql_cek_2 = "SELECT Iterasi_2 FROM proses_mining WHERE 
								  			Iterasi_2 = 1 AND Iterasi_3 = 0 OR
										 	Iterasi_2 = 0 AND Iterasi_3 = 1";
								  	  $cs2 = mysql_num_rows(mysql_query($sql_cek_2));
									  
									  if ($cs2 == 0){ 
										  ?> 
                                          	<td align="center" bgcolor="#BBBBBB"><?php echo $Dc_1?></td>
                                            <td align="center" bgcolor="#BBBBBB"><?php echo $Dc_2?></td>
                                            <td align="center"><?php echo $Dc_3?></td>
                                            <td align="center"><?php echo $Dc_4?></td>
                                            <td align="center" bgcolor="#BBBBBB"><?php echo $Dc_5?></td>
                                            <td align="center" bgcolor="#BBBBBB"><?php echo $Dc_6?></td>
										  <?php 
									  }else if ($cs2 > 0) {
										  $sql_cek_3 = "SELECT Iterasi_3 FROM proses_mining WHERE 
											  Iterasi_3 = 1 AND Iterasi_4 = 0 OR
											  Iterasi_3 = 0 AND Iterasi_4 = 1";
								  	  	  $cs3 = mysql_num_rows(mysql_query($sql_cek_3));
										  if ($cs3 == 0){ 
										  	  ?> 
                                              	<td align="center" bgcolor="#BBBBBB"><?php echo $Dc_1?></td>
                                                <td align="center" bgcolor="#BBBBBB"><?php echo $Dc_2?></td>
                                                <td align="center"><?php echo $Dc_3?></td>
                                                <td align="center"><?php echo $Dc_4?></td>
                                                <td align="center" bgcolor="#BBBBBB"><?php echo $Dc_5?></td>
                                                <td align="center" bgcolor="#BBBBBB"><?php echo $Dc_6?></td> 
                                                <td align="center"><?php echo $Dc_7?></td>
                                                <td align="center"><?php echo $Dc_8?></td>
											  <?php 
										  }else if ($cs3 > 0) {
										  	  $sql_cek_4 = "SELECT Iterasi_4 FROM proses_mining WHERE 
											  	  Iterasi_4 = 1 AND Iterasi_5 = 0 OR
											  	  Iterasi_4 = 0 AND Iterasi_5 = 1";
											  $cs4 = mysql_num_rows(mysql_query($sql_cek_4));
											  if ($cs4 == 0){ 
													?> 
													<td align="center" bgcolor="#BBBBBB"><?php echo $Dc_1?></td>
                                                    <td align="center" bgcolor="#BBBBBB"><?php echo $Dc_2?></td>
                                                    <td align="center"><?php echo $Dc_3?></td>

                                                    <td align="center"><?php echo $Dc_4?></td>
                                                    <td align="center" bgcolor="#BBBBBB"><?php echo $Dc_5?></td>
                                                    <td align="center" bgcolor="#BBBBBB"><?php echo $Dc_6?></td> 
                                                    <td align="center"><?php echo $Dc_7?></td>
                                                    <td align="center"><?php echo $Dc_8?></td> 
                                                    <td align="center" bgcolor="#BBBBBB"><?php echo $Dc_9?></td>
                                                    <td align="center" bgcolor="#BBBBBB"><?php echo $Dc_10?></td>
                                                    <?php 
											  } else if ($cs4 > 0) {
												  $sql_cek_5 = "SELECT Iterasi_5 FROM proses_mining WHERE 
													  Iterasi_5 = 1 AND Iterasi_6 = 0 OR
													  Iterasi_5 = 0 AND Iterasi_6 = 1";
												  $cs5 = mysql_num_rows(mysql_query($sql_cek_5));
											  	  if ($cs5 == 0){ 
														?> 
														<td align="center" bgcolor="#BBBBBB"><?php echo $Dc_1?></td>
                                                        <td align="center" bgcolor="#BBBBBB"><?php echo $Dc_2?></td>
                                                        <td align="center"><?php echo $Dc_3?></td>
                                                        <td align="center"><?php echo $Dc_4?></td>
                                                        <td align="center" bgcolor="#BBBBBB"><?php echo $Dc_5?></td>
                                                        <td align="center" bgcolor="#BBBBBB"><?php echo $Dc_6?></td> 
                                                        <td align="center"><?php echo $Dc_7?></td>
                                                        <td align="center"><?php echo $Dc_8?></td> 
                                                        <td align="center" bgcolor="#BBBBBB"><?php echo $Dc_9?></td>
                                                        <td align="center" bgcolor="#BBBBBB"><?php echo $Dc_10?></td>
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
															<td align="center" bgcolor="#BBBBBB"><?php echo $Dc_1?></td>
                                                            <td align="center" bgcolor="#BBBBBB"><?php echo $Dc_2?></td>
                                                            <td align="center"><?php echo $Dc_3?></td>
                                                            <td align="center"><?php echo $Dc_4?></td>
                                                            <td align="center" bgcolor="#BBBBBB"><?php echo $Dc_5?></td>
                                                            <td align="center" bgcolor="#BBBBBB"><?php echo $Dc_6?></td> 
                                                            <td align="center"><?php echo $Dc_7?></td>
                                                            <td align="center"><?php echo $Dc_8?></td> 
                                                            <td align="center" bgcolor="#BBBBBB"><?php echo $Dc_9?></td>
                                                            <td align="center" bgcolor="#BBBBBB"><?php echo $Dc_10?></td>
                                                            <td align="center"><?php echo $Dc_11?></td>
                                                            <td align="center"><?php echo $Dc_12?></td>
                                                            <td align="center" bgcolor="#BBBBBB"><?php echo $Dc_13?></td>
                                                            <td align="center" bgcolor="#BBBBBB"><?php echo $Dc_14?></td>
															<?php 
													  }
												  }
											  }
										  }
									  }
								  }
							  ?><th><a href="detail.php?id_proses=<?php echo $dti['id_proses']?>&id_produk=<?php echo $dti['id_produk']?>" class="btn btn-xs btn-success"><i class="fa fa-eye"></i></a></th>
                            <?php
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
