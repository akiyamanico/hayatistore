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
                <div class="col-lg-8">
                    <div class="panel panel-primary">
                        <div class="panel-heading">Titik Pusat Cluster</div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                          <form role="form" name="form2" method="post" enctype="multipart/form-data">
                          <table class="table table-bordered table-striped">
                            <thead>
                              <tr>
                                <th>Centroid</th>
                                <th width="20%">#</th>
                              </tr>
                            </thead>
                            <tbody>
                            <?php
                                $sql = mysql_query("SELECT * FROM centroid WHERE id='C1' OR id ='C2' ORDER BY id ASC LIMIT 0,2");
                                while ($d = mysql_fetch_array($sql)){
                                $id = $d['id'];
                                $cx = $d['cx'];
                                $cy = $d['cy'];
                            ?>
                              <tr>
                                <td>&nbsp<?php echo $id?> ( <?php echo $cx?> , <?php echo $cy?>  )</td>
                                <td>
                                <a href="titik-pusat.php?id=<?php echo $id;?>" class="btn btn-xs btn-warning"><i class="fa fa-fw fa-pencil"></i> Edit</a>
                                </td>
                              </tr>
                              <?php }?>
                            </tbody>
                          </table>
                          </form>
                        
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-8 -->
                <?php 
				$ID = isset($_GET['id']) ? $_GET['id'] : '';
				if ($ID!=''){
				?>
                <div class="col-lg-4">
                    <div class="panel panel-primary">
                        <div class="panel-heading">Edit Titik Pusat Cluster</div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                        <?php
						
						if(isset($_POST['btnsimpan'])){
							$txtid= strtoupper($_POST['txtid']);
							$txtx = $_POST['txtx'];
							$txty = $_POST['txty'];
							
							$mySql	= "UPDATE centroid SET cx ='".$txtx."', cy ='".$txty."' WHERE  id ='".$txtid."'";
							$myQry	= mysql_query($mySql);
							if($myQry){
								echo "<div class='alert alert-success'>
									Centroid berhasil simpan!
								</div>";
								echo "<meta http-equiv='refresh' content='0; url=titik-pusat.php'>";
							}
						}
						$data =mysql_fetch_array(mysql_query("SELECT * FROM centroid WHERE id ='".$ID."'"));
						?>
						<form role="form" name="form input" method="post" enctype="multipart/form-data">
							<div class="form-group">
							  <label for="id"> Kode</label>
							  <input type="text" readonly class="form-control" id="id" name="txtid" placeholder="C1 atau C2" title="Titik Pusat Cluster x" value="<?php echo $data['id']?>">
							</div>
							<div class="form-group">
							  <label for="x"> Cx</label>
							  <input type="text" autofocus required="required" class="form-control" id="x" name="txtx" placeholder="Cx" title="Titik Pusat Cluster x" value="<?php echo $data['cx']?>">
							</div>
							<div class="form-group">
							  <label for="y"> Cy</label>
							  <input type="text" autofocus required="required" class="form-control" id="y" name="txty" placeholder="Cy" title="Titik Pusat Cluster y" value="<?php echo $data['cy']?>">
							</div>
							<div class="box-footer">
								<button type="submit" name="btnsimpan" class="btn btn-primary">Simpan</button>
							</div>
						</form>
                        
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-4 -->
                <?php }?>
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