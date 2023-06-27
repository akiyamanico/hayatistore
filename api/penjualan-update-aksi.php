<?php include "../session.php";?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>ALGORITMA K-MEANS</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <link href="dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
    <link href="plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
    <link href="dist/ionicons.min.css" rel="stylesheet" type="text/css" />
    <link href="dist/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="../../https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="../../https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="skin-blue layout-top-nav">
    <div class="wrapper">
      
      <header class="main-header">               
		<?php 
		include"koneksi.php";
		include"menu.php";
		include"inc.fungsi.php";
		
		?>
      </header>
      <!-- Full Width Column -->
      <div class="content-wrapper">
        <div class="container-fluid">
          <!-- Content Header (Page header) -->
          <section class="content-header">
            <h1>Produk</h1>
            
            <ol class="breadcrumb">
              <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
              <li class="active">Penjualan</li>
            </ol>
          </section>

          <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Data Penjualan</h3>
                  <p></p>
                  <a href="produk-tools.php?aksi=input&token=<?php echo md5("input")?>" class="btn btn-sm btn-success">
                  <i class="fa fa-fw fa-money"></i> UPDATE DATA PENJUALAN</a>
                  <br>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <form role="form" action="#.php" method="post" enctype="multipart/form-data" name="frmpenjualan">
                  <table id="example2" class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th width="5%">Barcode</th>
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
                        <th>#</th>
                      </tr>
                    </thead>
                    <tbody>
					<?php
						$sql = mysql_query("SELECT * FROM penjualan ORDER BY barcode ASC");
						while ($d = mysql_fetch_array($sql)){
						$id = $d['id_penjualan'];
						$bc = $d['barcode'];
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
						$query_produk = mysql_query("SELECT * FROM produk WHERE barcode ='$bc'");
						$data_produk  = mysql_fetch_array($query_produk);
						$nm = $data_produk['nama'];
						
					?>
                      <tr>
                        <td><?php echo $bc?></td>
                        <td><?php echo $nm?></td>
                        <td align="center" bgcolor="#E4E4E4">
                        	<input name="upb1" type="text" class="form-control" style="width:50px" value="<?php echo $b1?>" maxlength="4"></td>
                        <td align="center">
                        	<input name="upb2" type="text" class="form-control" style="width:50px" value="<?php echo $b2?>" maxlength="4"></td>
                        <td align="center" bgcolor="#E4E4E4">
					    	<input name="upb3" type="text" class="form-control" style="width:50px" value="<?php echo $b3?>" maxlength="4"></td>
                        <td align="center">
							<input name="upb4" type="text" class="form-control" style="width:50px" value="<?php echo $b4?>" maxlength="4"></td>
                        <td align="center" bgcolor="#E4E4E4">
							<input name="upb5" type="text" class="form-control" style="width:50px" value="<?php echo $b5?>" maxlength="4"></td>
                        <td align="center">
							<input name="upb6" type="text" class="form-control" style="width:50px" value="<?php echo $b6?>" maxlength="4"></td>
                        <td align="center" bgcolor="#E4E4E4">
							<input name="upb7" type="text" class="form-control" style="width:50px" value="<?php echo $b7?>" maxlength="4"></td>
                        <td align="center">
							<input name="upb8" type="text" class="form-control" style="width:50px" value="<?php echo $b8?>" maxlength="4"></td>
                        <td align="center" bgcolor="#E4E4E4">
							<input name="upb9" type="text" class="form-control" style="width:50px" value="<?php echo $b9?>" maxlength="4"></td>
                        <td align="center">
							<input name="upb10" type="text" class="form-control" style="width:50px" value="<?php echo $b10?>" maxlength="4"></td>
                        <td align="center" bgcolor="#E4E4E4">
							<input name="upb11" type="text" class="form-control" style="width:50px" value="<?php echo $b11?>" maxlength="4"></td>
                        <td align="center">
							<input name="upb12" type="text" class="form-control" style="width:50px" value="<?php echo $b12?>" maxlength="4"></td>
                        <td align="center" bgcolor="#D4D4D4"><?php echo $tot?></td>
                        <td>
                        <a href="produk-tools.php?produk=<?php echo $id?>&aksi=edit&token=<?php echo md5("edit")?>" class="btn btn-xs btn-warning" onClick="return confirm('Apakah anda yakin mengubah produk &quot;<?php echo $nm?>&quot; ?')">
                        	<i class="fa fa-fw fa-gear"></i> Update</a>
                        </td>
                      </tr>
                    <?php }?>
                    </tbody>
                  </table>
                  </form>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->
        </div><!-- /.container -->
      </div><!-- /.content-wrapper -->
      <?php include"footer.php";?>
    </div><!-- ./wrapper -->

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
