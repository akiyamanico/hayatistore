<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>ALGORITMA K-MEANS</title>
    <!-- Bootstrap Core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link href="../vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="../vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
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
		include "../koneksi.php";
		include "header-and-menu.php";
		include "../inc.fungsi.php";
		?>
        <?php 
		  
		  $sql_cek_1 = "SELECT Iterasi_1 FROM proses_mining WHERE 
					Iterasi_1 = 1 AND Iterasi_2 = 0 OR
					Iterasi_1 = 0 AND Iterasi_2 = 1";
		  $cs1 = mysql_num_rows(mysql_query($sql_cek_1));
		  if ($cs1 == 0){ 
				$q_supp_c1 = "Iterasi_2 = 1";
				$q_supp_c2 = "Iterasi_2 = 0";
				
		  }else if ($cs1 > 0) {
			  $sql_cek_2 = "SELECT Iterasi_2 FROM proses_mining WHERE 
					Iterasi_2 = 1 AND Iterasi_3 = 0 OR
					Iterasi_2 = 0 AND Iterasi_3 = 1";
			  $cs2 = mysql_num_rows(mysql_query($sql_cek_2));
			  
			  if ($cs2 == 0){ 
				  $q_supp_c1 = "Iterasi_3 = 1";
				  $q_supp_c2 = "Iterasi_3 = 0";
			  }else if ($cs2 > 0) {
				  $sql_cek_3 = "SELECT Iterasi_3 FROM proses_mining WHERE 
					  Iterasi_3 = 1 AND Iterasi_4 = 0 OR
					  Iterasi_3 = 0 AND Iterasi_4 = 1";
				  $cs3 = mysql_num_rows(mysql_query($sql_cek_3));
				  if ($cs3 == 0){ 
					  $q_supp_c1 = "Iterasi_4 = 1";
					  $q_supp_c2 = "Iterasi_4 = 0";
				  }else if ($cs3 > 0) {
					  $sql_cek_4 = "SELECT Iterasi_4 FROM proses_mining WHERE 
						  Iterasi_4 = 1 AND Iterasi_5 = 0 OR
						  Iterasi_4 = 0 AND Iterasi_5 = 1";
					  $cs4 = mysql_num_rows(mysql_query($sql_cek_4));
					  if ($cs4 == 0){ 
							$q_supp_c1 = "Iterasi_5 = 1";
							$q_supp_c2 = "Iterasi_5 = 0";
					  } else if ($cs4 > 0) {
						  $sql_cek_5 = "SELECT Iterasi_5 FROM proses_mining WHERE 
							  Iterasi_5 = 1 AND Iterasi_6 = 0 OR
							  Iterasi_5 = 0 AND Iterasi_6 = 1";
						  $cs5 = mysql_num_rows(mysql_query($sql_cek_5));
						  if ($cs5 == 0){ 
								$q_supp_c1 = "Iterasi_6 = 1";
								$q_supp_c2 = "Iterasi_6 = 0"; 
							  } else if ($cs5 > 0) {
							  $sql_cek_6 = "SELECT Iterasi_6 FROM proses_mining WHERE 
								  Iterasi_6 = 1 AND Iterasi_7 = 0 OR
								  Iterasi_6 = 0 AND Iterasi_7 = 1";
							  $cs6 = mysql_num_rows(mysql_query($sql_cek_6));
							  if ($cs6 == 0){ 
									$q_supp_c1 = "Iterasi_7 = 1";
									$q_supp_c2 = "Iterasi_7 = 0"; 
							  }
						  }
					  }
				  }
			  }
		  }
		  
		  $sql_progg_c1 = "SELECT * FROM proses_mining WHERE $q_supp_c1 ";
		  $jum_progg_c1 = mysql_num_rows(mysql_query($sql_progg_c1));
		  
		  $sql_progg_c2 = "SELECT * FROM proses_mining WHERE $q_supp_c2 ";
		  $jum_progg_c2 = mysql_num_rows(mysql_query($sql_progg_c2));
		  
		  $progg_total  = $jum_progg_c1 + $jum_progg_c2;
		  $c1 = number_format((($jum_progg_c1 / $progg_total)*100),2);
		  $c2 = number_format((($jum_progg_c2 / $progg_total)*100),2);
		 
		  ?>
        <div id="page-wrapper">
        <p>&nbsp;</p>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                           Perbandingan Data Produk Yang Diminati dan Tidak Diminati
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                          <div class="progress">
                          <div class="progress-bar progress-bar-info" aria-valuemin="0" aria-valuemax="100" 
                                        aria-valuenow="<?php echo $c1;?>" style="width:<?php echo $c1 ?>%">
                            <?php echo $c1 ?>%
                          </div>
                          </div>
                          <div class="progress">
                          <div class="progress-bar progress-bar-warning" aria-valuemin="0" aria-valuemax="100" 
                                        aria-valuenow="<?php echo $c2;?>" style="width:<?php echo $c2 ?>%">
                            <?php echo $c2 ?>%
                          </div>
                          </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                           Pengelompokkan Data
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                        <!-- Custom Tabs -->
                        <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs">
                                <li><a href="#tab_iterasi" data-toggle="tab">Produk yang dinikmati</a></li>
                                <li><a href="#hasil" data-toggle="tab">Produk yang kurang diminati</a></li>
                                <div class="tab-content">
                                    <!-- iterasi 1 --> 
                                    <div class="tab-pane active" id="tab_iterasi">
                                    	<p>&nbsp;</p>
                                        <p>&nbsp;</p>
                                        <h3>Daftar produk yang diminati oleh konsumen</h3>
                      					<div class="progress">
                                          <div class="progress-bar progress-bar-info" aria-valuemin="0" aria-valuemax="100" 
                                                        aria-valuenow="<?php echo $c1;?>" style="width:<?php echo $c1 ?>%">
                                           	<?php echo $c1 ?>%
                                          </div>
                                        </div>              	
                                        <table id="tabel_c1" class="table table-bordered table-hover">
                                            <thead>
                                              <tr>
                                                <th width="15%">id_produk</th>
                                                <th>Nama</th>
                                                <th>Jenis</th>
                                                <th>Harga (Rp.)</th>
                                              </tr>
                                            </thead>
                                            <tbody>	
                                            <?php
                                              $sql_hasil_C1 = "SELECT * FROM proses_mining JOIN 
                                                                    produk ON produk.id_produk = proses_mining.id_produk JOIN
                                                                    kategori ON produk.id_kategori = kategori.id_kategori 
                                                                WHERE $q_supp_c1 ";
                                              $query_hasil_C1= mysql_query($sql_hasil_C1);
                                              while ($data_C1 = mysql_fetch_array($query_hasil_C1)){
                                                  $bc_c1 = $data_C1['id_produk'];
                                                  $nm_c1 = $data_C1['nama'];
                                                  $hg_c1 = format_rupiah($data_C1['harga']);
                                                  $sk_c1 = $data_C1['kategori'];
                                              ?>
                                              <tr>
                                                <td><?php echo $bc_c1;?></td>
                                                <td><?php echo $nm_c1;?></td>
                                                <td><?php echo $sk_c1;?></td>
                                                <td><?php echo $hg_c1;?></td>
                                              </tr>
                                              <?php } ?>
                                            </tbody>
                                          </table>
                                    </div><!-- /.tab-pane -->
                                    <div class="tab-pane" id="hasil">
                                    <p>&nbsp;</p>
                                        <p>&nbsp;</p>
                                        <h3>Daftar produk yang kurang diminati oleh konsumen</h3>
                      					<div class="progress">
                                          <div class="progress-bar progress-bar-warning" aria-valuemin="0" aria-valuemax="100" 
                                            aria-valuenow="<?php echo $c2;?>" style="width:<?php echo $c2 ?>%">
                                            <?php echo $c2 ?>%
                                          </div>
                                        </div>
                       					<table id="tabel_c2" class="table table-bordered table-hover">
                                    <thead>
                                      <tr>
                                        <th width="15%">id_produk</th>
                                        <th>Nama</th>
                                        <th>Jenis</th>
                                        <th>Harga (Rp.)</th>
                                      </tr>
                                    </thead>
                                    <tbody>	
                                    <?php
                                      $sql_hasil_C2 = "SELECT * FROM proses_mining JOIN 
                                                            produk ON produk.id_produk = proses_mining.id_produk JOIN
                                                            kategori ON produk.id_kategori = kategori.id_kategori 
                                                        WHERE $q_supp_c2 ";
                                      $query_hasil_C2= mysql_query($sql_hasil_C2);
                                      while ($data_C2 = mysql_fetch_array($query_hasil_C2)){
                                          $bc_c2 = $data_C2['id_produk'];
                                          $nm_c2 = $data_C2['nama'];
                                          $hg_c2 = format_rupiah($data_C2['harga']);
                                          $sk_c2 = $data_C2['kategori'];
                                      ?>
                                      <tr>
                                        <td><?php echo $bc_c2;?></td>
                                        <td><?php echo $nm_c2;?></td>
                                        <td><?php echo $sk_c2;?></td>
                                        <td><?php echo $hg_c2;?></td>
                                      </tr>
                                      <?php } ?>
                                    </tbody>
                                  </table> 
                                    </div><!-- /.tab-pane -->
                                </div><!-- /.tab-content -->
                            </ul>
                        </div><!-- nav-tabs-custom -->
                      <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
        </div>
        <!-- /#page-wrapper -->

    </div>
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
		$('#tabel_c1').dataTable({
          "bPaginate": true,
          "bLengthChange": true,
          "bFilter": true,
          "bSort": false,
          "bInfo": true,
          "bAutoWidth": false
        });
		$('#tabel_c2').dataTable({
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
