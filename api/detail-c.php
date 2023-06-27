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
                      Detail Nilai <strong><?php echo $_GET['c']?></strong> </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                        <p><a class="btn btn-sm btn-info" href="mining.php">
                        	<i class="fa fa-arrow-left"> Kembali</i></a></p>
                        	<p>Cx</p>
                            <table class="table table-bordered table-hover">
                    <tbody>
                      <tr>
                      <?php
					  		$nilai_C = $_GET['c'];
							if($nilai_C == 'C3'){ $carix = 'proses_mining.Iterasi_1 = 1'; }else
							if($nilai_C == 'C4'){ $carix = 'proses_mining.Iterasi_1 = 0'; }else
							if($nilai_C == 'C5'){ $carix = 'proses_mining.Iterasi_2 = 1'; }else
							if($nilai_C == 'C6'){ $carix = 'proses_mining.Iterasi_2 = 0'; }else
							if($nilai_C == 'C7'){ $carix = 'proses_mining.Iterasi_3 = 1'; }else
							if($nilai_C == 'C8'){ $carix = 'proses_mining.Iterasi_3 = 0'; }else
							if($nilai_C == 'C9'){ $carix = 'proses_mining.Iterasi_4 = 1'; }else
							if($nilai_C == 'C10'){ $carix = 'proses_mining.Iterasi_4 = 0'; }else
							if($nilai_C == 'C11'){ $carix = 'proses_mining.Iterasi_5 = 1'; }else
							if($nilai_C == 'C12'){ $carix = 'proses_mining.Iterasi_5 = 0'; }else
							if($nilai_C == 'C13'){ $carix = 'proses_mining.Iterasi_6 = 1'; }else
							if($nilai_C == 'C14'){ $carix = 'proses_mining.Iterasi_6 = 0'; }
							
							
							echo "<td width='80%'> ( ";
							$qry_cx  = mysql_query("SELECT * FROM proses_mining WHERE $carix");
							$jumlahx  = mysql_num_rows($qry_cx);
							while($dcx = mysql_fetch_array($qry_cx)){
								$stok = mysql_fetch_array(mysql_query("SELECT stok FROM produk WHERE id_produk='".$dcx['id_produk']."'"));
							echo "$stok[stok] "." + ";
							}
							echo " ) / $jumlahx</td>";
							
							$qry_cx2 = mysql_query("SELECT sum(stok) AS JSTOK FROM produk JOIN proses_mining ON 
													proses_mining.id_produk = produk.id_produk WHERE $carix");
							$dcx2 = mysql_fetch_array($qry_cx2);
							$cx = $dcx2['JSTOK']/$jumlahx;
					  ?>
                      	<td><?php echo $dcx2['JSTOK']?> / <?php echo $jumlahx?> = <?php echo $cx?></td>
					  </tr>
                    </tbody>
                  </table>
                  <p>Cy</p>
                  <table class="table table-bordered">
                    <tbody>
                    <?php
						echo "<td width='80%'> ( ";
							$qry_cy  = mysql_query("SELECT * FROM proses_mining WHERE $carix");
							$jumlahy  = mysql_num_rows($qry_cy);
                      		while($dcy = mysql_fetch_array($qry_cy)){
								$stok = mysql_fetch_array(mysql_query("SELECT total FROM penjualan WHERE id_produk='".$dcy['id_produk']."'"));
							echo "$stok[total] "." + ";
							}
							echo " ) / $jumlahy</td>";
							
							$qry_cy2 = mysql_query("SELECT sum(total) AS JSTOK FROM penjualan JOIN proses_mining ON 
													proses_mining.id_produk = penjualan.id_produk WHERE $carix");
							$dcy2 = mysql_fetch_array($qry_cy2);
							$cy = $dcy2['JSTOK']/$jumlahy;
					  ?>
                      	<td><?php echo $dcy2['JSTOK']?> / <?php echo $jumlahy?> = <?php echo $cy?></td>
                    </tr>
                    
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
