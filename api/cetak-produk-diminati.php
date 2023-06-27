<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Produk Diminati</title>

    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">
    <link href="../vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

</head>

<body>
<?php 
include "../inc.session.php";
include "../koneksi.php";
include "../inc.fungsi.php";
		  
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
?>

    <div class="row">
        <div class="col-lg-12">
            <h2 class="text-center">ALFAMART</small></h2>
            <p class="text-center">Wirotho Agung, RImbo Bujang, Kab. Tebo, Jambi, 37553</p>
    	</div>
    </div>
    <hr>
    <p>Hal : Laporan Data Produk Yang Diminati Konsumen</p>
    <p>&nbsp;</p>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <table id="tabel_c1" class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <th width="5%">No.</th>
                    <th width="15%">Id Produk</th>
                    <th>Nama</th>
                    <th>Jenis</th>
                    <th>Harga (Rp.)</th>
                  </tr>
                </thead>
                <tbody>	
                <?php
				$no=0;
                  $sql_hasil_C1 = "SELECT * FROM proses_mining JOIN 
                                        produk ON produk.id_produk = proses_mining.id_produk JOIN
                                        kategori ON produk.id_kategori = kategori.id_kategori 
                                    WHERE $q_supp_c1 ORDER BY produk.id_produk ASC";
                  $query_hasil_C1= mysql_query($sql_hasil_C1);
                  while ($data_C1 = mysql_fetch_array($query_hasil_C1)){
					  $no++;
                      $bc_c1 = $data_C1['id_produk'];
                      $nm_c1 = $data_C1['nama'];
                      $hg_c1 = format_rupiah($data_C1['harga']);
                      $sk_c1 = $data_C1['kategori'];
                  ?>
                  <tr>
                    <td><?php echo $no;?></td>
                    <td><?php echo $bc_c1;?></td>
                    <td><?php echo $nm_c1;?></td>
                    <td><?php echo $sk_c1;?></td>
                    <td><?php echo $hg_c1;?></td>
                  </tr>
                  <?php } ?>
                </tbody>
              </table>
            <div style="float:right">
            <p align="center">
            <br />
            <br />
            <br />
Jambi, <?php echo"". date("d M Y") ."";?> <br /><br />
</p>
            <p align="center"><br />
  <br />
  <u>___________________</u><br />
              <br />
            </p>
              
            </div> 
        </div>
        <!-- /.col-lg-12 -->
    </div>
    
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="../vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="../vendor/datatables-responsive/dataTables.responsive.js"></script>
	<script>window.print();</script>
</body>

</html>
