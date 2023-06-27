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
                <?php
					 
                if(isset($_POST['btnupdate'])){
                        $upbc = $_POST['upbc'];
						$chkcount = count($upbc);
							
						for ($i=0; $i<$chkcount; $i++){	
							$upbc[$i] = $_POST['upbc'][$i];
							$up1[$i] = $_POST['upb1'][$i];
							$up2[$i] = $_POST['upb2'][$i];
							$up3[$i] = $_POST['upb3'][$i];
							$up4[$i] = $_POST['upb4'][$i];
							$up5[$i] = $_POST['upb5'][$i];
							$up6[$i] = $_POST['upb6'][$i];
							$up7[$i] = $_POST['upb7'][$i];
							$up8[$i] = $_POST['upb8'][$i];
							$up9[$i] = $_POST['upb9'][$i];
							$up10[$i] = $_POST['upb10'][$i];
							$up11[$i] = $_POST['upb11'][$i];
							$up12[$i] = $_POST['upb12'][$i];
							$hasil[$i] = $up1[$i] + $up2[$i] + $up3[$i] + $up4[$i] + $up5[$i] + $up6[$i] + $up7[$i] + $up8[$i] + $up9[$i] + $up10[$i] + $up11[$i] + $up12[$i];
							$mySql	= "UPDATE penjualan SET JAN = '".$up1[$i]."',
														  FEB = '".$up2[$i]."',
														  MAR = '".$up3[$i]."',
														  APR = '".$up4[$i]."',
														  MEI = '".$up5[$i]."',
														  JUN = '".$up6[$i]."',
														  JUL = '".$up7[$i]."',
														  AGUST = '".$up8[$i]."',
														  SEPT = '".$up9[$i]."',
														  OKT = '".$up10[$i]."',
														  NOV = '".$up11[$i]."',
														  DES = '".$up12[$i]."',
														  total = '".$hasil[$i]."' WHERE id_produk  = '".$upbc[$i]."'";
                            $myQry	= mysql_query($mySql);
						}
                               echo "<div class='alert alert-success alert-dismissible' role='alert'>
									<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Data penjualan berhasil diupdate.</div>";
					}
				?>
                
                  <form role="form" method="post" enctype="multipart/form-data" name="frmpenjualan">
                  <a href="penjualan.php" class="btn btn-sm btn-info"><i class="fa fa-fw fa-arrow-left"></i> Kembali</a>
                  <a href="penjualan.php" class="btn btn-sm btn-danger"><i class="fa fa-fw fa-close"></i> Batal</a>
                  <button type="submit" name="btnupdate" class="btn btn-sm btn-success" onClick="return confirm('Apakah anda yakin mengubah jumlah penjualan produk &quot;<?php echo $nm?>&quot; ?')"><i class="fa fa-fw fa-save"></i> Simpan/Update</button>
                  
                  <br><br>
                  <table id="dataTables-example" class="table table-responsive table-bordered table-hover">
                    <thead>
                      <tr>
                        <th>Nama</th>
                        <th width="5%" bgcolor="#E4E4E4">JAN</th>
                        <th width="5%">FEB</th>
                        <th width="5%" bgcolor="#E4E4E4">MAR</th>
                        <th width="5%">APR</th>
                        <th width="5%" bgcolor="#E4E4E4">MEI</th>
                        <th width="5%">JUN</th>
                        <th width="5%" bgcolor="#E4E4E4">JUL</th>
                        <th width="5%">AGUST</th>
                        <th width="5%" bgcolor="#E4E4E4">SEP</th>
                        <th width="5%">OKT</th>
                        <th width="5%" bgcolor="#E4E4E4">NOV</th>
                        <th width="5%">DES</th>
                        <th width="5%" bgcolor="#D4D4D4">TOTAL</th>
                      </tr>
                    </thead>
                    <tbody>
					<?php
						$sql = mysql_query("SELECT * FROM penjualan ORDER BY id_produk ASC");
						
						while ($d = mysql_fetch_array($sql)){
						$id = $d['id_penjualan'];
						$bc = $d['id_produk'];
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
						$query_produk = mysql_query("SELECT * FROM produk WHERE id_produk ='$bc'");
						$data_produk  = mysql_fetch_array($query_produk);
						$nm = $data_produk['nama'];
                    ?>
                    
                      <tr>
                        <td><input name="upbc[]" type="hidden"value="<?php echo $bc?>"><?php echo $nm?></td>
                        <td align="center" bgcolor="#E4E4E4">
                        	<input name="upb1[]" type="text" class="form-control" style="width:50px" value="<?php echo $b1?>" maxlength="4"></td>
                        <td align="center">
                        	<input name="upb2[]" type="text" class="form-control" style="width:50px" value="<?php echo $b2?>" maxlength="4"></td>
                        <td align="center" bgcolor="#E4E4E4">
					    	<input name="upb3[]" type="text" class="form-control" style="width:50px" value="<?php echo $b3?>" maxlength="4"></td>
                        <td align="center">
							<input name="upb4[]" type="text" class="form-control" style="width:50px" value="<?php echo $b4?>" maxlength="4"></td>
                        <td align="center" bgcolor="#E4E4E4">
							<input name="upb5[]" type="text" class="form-control" style="width:50px" value="<?php echo $b5?>" maxlength="4"></td>
                        <td align="center">
							<input name="upb6[]" type="text" class="form-control" style="width:50px" value="<?php echo $b6?>" maxlength="4"></td>
                        <td align="center" bgcolor="#E4E4E4">
							<input name="upb7[]" type="text" class="form-control" style="width:50px" value="<?php echo $b7?>" maxlength="4"></td>
                        <td align="center">
							<input name="upb8[]" type="text" class="form-control" style="width:50px" value="<?php echo $b8?>" maxlength="4"></td>
                        <td align="center" bgcolor="#E4E4E4">
							<input name="upb9[]" type="text" class="form-control" style="width:50px" value="<?php echo $b9?>" maxlength="4"></td>
                        <td align="center">
							<input name="upb10[]" type="text" class="form-control" style="width:50px" value="<?php echo $b10?>" maxlength="4"></td>
                        <td align="center" bgcolor="#E4E4E4">
							<input name="upb11[]" type="text" class="form-control" style="width:50px" value="<?php echo $b11?>" maxlength="4"></td>
                        <td align="center">
							<input name="upb12[]" type="text" class="form-control" style="width:50px" value="<?php echo $b12?>" maxlength="4"></td>
                        <td align="center" bgcolor="#D4D4D4"><?php echo $tot?></td>
                      </tr>
                    <?php 
						}
					?>
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
</div>


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
