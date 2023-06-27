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
                           Data Produk
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                        <?php 
							$p_id = $_GET['id'];
							$p_nm = $_GET['nm'];
							$lnm  = str_replace('-',' ',$p_nm);
							$yes   = mysql_query("DELETE FROM produk WHERE id_produk='$p_id' AND nama='$lnm'");
							if($yes){
							$yes1  = mysql_query("DELETE FROM penjualan WHERE id_produk='$p_id'");
							$yes2  = mysql_query("DELETE FROM proses_mining WHERE id_produk='$p_id'");

								echo "<div class='alert alert-success alert-dismissable'>
										<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
										Berhasil Menghapus produk
									  </div>";
									  echo "<meta http-equiv='refresh' content='0; url=produk.php'>";
							}
						
						?>
                        <p><a class="btn btn-sm btn-success" href="produk-tambah.php">
                        	<i class="fa fa-plus-square"> Tambah Produk</i></a></p>
                            
                            <form role="form" action="produk.php" method="post" enctype="multipart/form-data" name="frmkry">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>Produk</th>
                                        <th>Jenis</th>
                                        <th>Stok</th>
                                        <th>Harga (Rp.)</th>
                                        <th width="15%">Tools</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
								$q = "SELECT * FROM produk ORDER BY nama ASC, id_kategori ASC";
								$r = mysql_query($q,$server);
								while($d = mysql_fetch_array($r)){
								$id= $d['id_produk'];
								$nm= $d['nama'];
								$q2 = "SELECT * FROM kategori where id_kategori = '$d[id_kategori]'";
								$r2 = mysql_query($q2,$server);
								$d2 = mysql_fetch_array($r2);
								$kt= $d2['kategori'];
								$st= $d['stok'];
								$hg= format_rupiah($d['harga']);
								
                                ?>
                                    <tr>
                                        <td><?php echo $nm;?></td>
                                        <td class="center"><?php echo $kt;?></td>
                                        <td class="center"><?php echo $st;?></td>
                                        <td><?php echo $hg;?></td>
                                        <td class="center">
                                            <a class="btn btn-xs btn-warning" href="karyawan-blokir.php?id=<?php echo $id;?>">
                                            	<i class="fa fa-pencil"></i> Edit
                                            </a>
                                            <a class="btn btn-xs btn-danger" 
                                               href="produk-hapus.php?id=<?php echo $id;?>&nm=<?php 
											   $lnm = str_replace(' ','-',$nm);
											   echo $lnm;?>">
                                            	<i class="fa fa-trash"></i> Hapus
                                            </a>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                            </form>
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
