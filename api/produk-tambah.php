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
		include "../inc.newkode.php";
		include "../koneksi.php";
		include "header-and-menu.php";
		?>

        <div id="page-wrapper">
            <p>&nbsp;</p>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                           Tambah Data Produk
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                        <?php
						if(isset($_POST['btnsave'])){
							$id = NewKode("produk", "PRO");
							$idPen = NewKode("penjualan", "PNJ");
							$nm = strtoupper($_POST['txtnm']);
							$kt = $_POST['txtkt'];
							$st = $_POST['txtst'];
							$hg = $_POST['txthg'];
							$hg = str_replace(',','',$hg);
							$hg = str_replace('.','',$hg);
							
							// Validasi username
							$sqlCek = "SELECT * FROM produk WHERE nama='$nm'";
							$qryCek = mysql_query($sqlCek,$server);
							if(mysql_num_rows($qryCek) >0){
								echo "<div class='alert alert-warning alert-dismissible' role='alert'>
								<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
								<strong>Produk sudah ada</strong>.
								</div>";
								
							}else{
								# SIMPAN DATA KE DATABASE. Jika tidak menemukan pesan error, simpan data ke database
									$mySql1	= "INSERT INTO produk 	SET id_produk ='".$id."',
																nama ='".$nm."',
																id_kategori ='".$kt."',
																stok ='".$st."',
																harga ='".$hg."'";
									$myQry	= mysql_query($mySql1);
									if($myQry){
										$mySql	= "INSERT INTO penjualan values ('$idPen','$id','0','0','0','0','0','0','0','0','0','0','0','0','0')";
										$myQry	= mysql_query($mySql);
										$mySqla	= "INSERT INTO proses_mining SET id_produk='".$id."'";
										$myQrya	= mysql_query($mySqla);
										echo "<div class='alert alert-success alert-dismissible' role='alert'>
										<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
										<strong>Berhasil menyimpan data, <a href='produk.php'>Lihat</a></strong>.
										</div>";
									}
								}
						}
						
						?>
                         <form role="form" action="produk-tambah.php" method="post" enctype="multipart/form-data" name="frmaddprd">
                            <div class="col-lg-6 col-lg-offset-3">
                                <p>&nbsp;</p>
                                <div class="form-group">
                                    <label>Nama Produk</label>
                                    <input name="txtnm" type="text" required class="form-control" placeholder="Nama Produk">
                                </div>
                                <div class="form-group">
                                    <label>Kategori</label>
                                    <select name="txtkt" required class="form-control">
                                    	<option value="">Pilih</option>
                                        <?php
                                        	$q = mysql_query("SELECT * FROM kategori ORDER by kategori ASC",$server);
											while ($d = mysql_fetch_array($q)){
										?>
                                        <option value="<?php echo $d['id_kategori']?>"><?php echo $d['kategori']?></option>
                                        <?php }?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Jumlah Stok</label>
                                    <input name="txtst" type="number" required class="form-control" placeholder="Jumlah Stok" max="200" min="0">
                                </div>
                                <div class="form-group">
                                    <label>Harga (Rp.)</label>
                                    <input type="text" name="txthg" required class="form-control" placeholder="Harga Produk">
                                </div>
                                <div class="form-group" align="right">
                                    <Button type="submit" name="btnsave" class="btn btn-sm btn-success">
                                    <i class="fa fa-save"></i> Simpan</Button>
                                </div>
                                
                            </div>
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
