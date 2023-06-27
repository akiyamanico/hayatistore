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
                           Data Penjualan
                      </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                        <p><a class="btn btn-sm btn-success" href="penjualan-update.php">
                        	<i class="fa fa-edit"> Edit Data Penjualan</i></a></p>
                            <table width="100%" class="table table-striped table-responsive table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>&nbsp;</th>
                                        <th colspan="13" class="text-center">Bulan Ke-</th>
                                        <th>&nbsp;</th>
                                    </tr>
                                    <tr>
                                        <th>Produk</th>
                                        <th>1</th>
                                        <th>2</th>
                                        <th>3</th>
                                        <th>4</th>
                                        <th>5</th>
                                        <th>6</th>
                                        <th>7</th>
                                        <th>8</th>
                                        <th>9</th>
                                        <th>10</th>
                                        <th>11</th>
                                        <th>12</th>
                                        <th>Total</th>
                                        <th>Tools</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
								$q = "SELECT * FROM penjualan ORDER BY id_produk DESC";
								$r = mysql_query($q,$server);
								while($d = mysql_fetch_array($r)){
								$idPen = $d['id_penjualan'];
								$idPrd = $d['id_produk'];
								$q2 = "SELECT * FROM produk WHERE id_produk = '".$idPrd."'";
								$r2 = mysql_query($q2);
								$d2 = mysql_fetch_array($r2);
								$nm = $d2['nama'];
								
								$b1 = $d['JAN'];
								$b2 = $d['FEB'];
								$b3 = $d['MAR'];
								$b4 = $d['APR'];
								$b5 = $d['MEI'];
								$b6 = $d['JUN'];
								$b7 = $d['JUL'];
								$b8 = $d['AGUST'];
								$b9 = $d['SEPT'];
								$b10= $d['OKT'];
								$b11= $d['NOV'];
								$b12= $d['DES'];
								$tot = $b1 + $b2 + $b3 + $b4 + $b5 + $b6 + $b7 + $b8 + $b9 + $b10 + $b11 + $b12;
								mysql_query("UPDATE penjualan set total = '$tot' WHERE id_penjualan='$idPen'");
								
								?>
                                    <tr>
                                        <td><?php echo $nm;?></td>
                                        <td align="center" bgcolor="#E4E4E4"><?php echo $b1?></td>
                                        <td align="center"><?php echo $b2?></td>
                                        <td align="center" bgcolor="#E4E4E4"><?php echo $b3?></td>
                                        <td align="center"><?php echo $b4?></td>
                                        <td align="center" bgcolor="#E4E4E4"><?php echo $b5?></td>
                                        <td align="center"><?php echo $b6?></td>
                                        <td align="center" bgcolor="#E4E4E4"><?php echo $b7?></td>
                                        <td align="center"><?php echo $b8?></td>
                                        <td align="center" bgcolor="#E4E4E4"><?php echo $b9?></td>
                                        <td align="center"><?php echo $b10?></td>
                                        <td align="center" bgcolor="#E4E4E4"><?php echo $b11?></td>
                                        <td align="center"><?php echo $b12?></td>
                                        <td align="center" bgcolor="#D4D4D4"><?php echo $tot?></td>
                                        <td class="center">
                                            <a class="btn btn-xs btn-danger" href="reset-penjualan.php?id=<?php echo $idPen;?>">
                                            	<i class="fa fa-reply-all"></i> Reset
                                            </a>
                                        </td>
                                    </tr>
                                    <?php } ?>
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
