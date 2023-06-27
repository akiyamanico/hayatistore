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
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">
    <link href="../vendor/morrisjs/morris.css" rel="stylesheet">
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
		//include "../inc.pro-antrian.php";
		include "header-and-menu.php";
		include "../inc.fungsi.php";
		include "../inc.newkode.php";
		$now = date('Ymd');
		?>
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Dashboard</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <?php
				$q2 = "SELECT * FROM antrian WHERE status = 'antri'";
				$r2 = mysql_query($q2);
				$jpitch = mysql_num_rows($r2);
				?>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                            	<div class="col-xs-2">
                                    <i class="fa fa-users fa-3x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo $jpitch;?></div>
                                    <div>Antrian!</div>
                                </div>
                            </div>
                        </div>
                        <a href="antrian.php">
                            <div class="panel-footer">
                                <span class="pull-left">Lihat</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                
				<?php
				$qpitch = "SELECT * FROM pitch";
				$rpitch = mysql_query($qpitch);
				while($dpitch = mysql_fetch_array($rpitch)){
					$p_id  = $dpitch['id_pitch'];
					$p_nama  = $dpitch['nama_pitch'];
					$p_status = $dpitch['status'];
					$p_aktif  = $dpitch['aktif'];
					
					$sp_an = "SELECT id_antrian FROM antrian WHERE id_pitch = '$p_id'";
					$rp_an = mysql_query($sp_an);
					$d_an = mysql_fetch_array($rp_an);
					$id_pel_an   = $d_an['id_antrian'];
					
					if ($dpitch['ket'] == 'close'){
						$p_ket    = "Off";
						}else{
						$p_ket    = $dpitch['ket'];
						}
					
					if ($p_status == 0){$warna = 'red';$icon = "fa-ban";}else{$warna = 'green';}
					
					
                ?>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-<?php echo $warna?>">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-2">
                                    <i class="fa fa-flag fa-3x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">&nbsp;</div>
                                    <div><?php echo $p_nama?></div>
                                </div>
                            </div>
                        </div>
                        <?php if ($p_ket == 'sibuk'){?>
						
                        <a href="selesai.php?pitch=<?php echo $p_id; ?>&pel=<?php echo $id_pel_an; ?>">
                            <div class="panel-footer">
                            	<span class="pull-left">Selesai</span>
                                <span class="pull-right"><i class="fa fa-check"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
						<?php } ?>
                        <?php if ($p_ket != 'sibuk'){?>
                        
                        <div class="panel-footer">
                            <span class="pull-left"><?php echo $p_ket?></span>
                            <div class="clearfix"></div>
                        </div>
                        <?php } ?>
                    </div>
                </div>
                <?php }?>
                
                <div class="col-lg-10">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            Daftar Antrian
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                            <a class="btn btn-sm btn-primary" href="antrian.php"><i class="fa fa-navicon"></i> Detail</a><br><br>
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>#Antrian</th>
                                            <th>Nama</th>
                                            <th>Mobil</th>
                                            <th>No Polisi</th>
                                            <th width="5%" >#</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
										$q = "SELECT * FROM antrian WHERE status = 'antri' limit 0,5";
										$r = mysql_query($q);
										while( $d = mysql_fetch_array($r)){
										$antrian 	= $d['nomor_antrian'];
										$id_pel		= $d['id_antrian'];
										$qpel = "SELECT * FROM pelanggan WHERE id_antrian = '$id_pel'";
										$rpel = mysql_query($qpel);
										$dpel = mysql_fetch_array($rpel);
										$nama = $dpel['pemilik'];
										$mobil= $dpel['merk_mobil'];
										$plat = $dpel['nomor_polisi'];
										?>
                                        <tr>
                                            <td><?php echo $antrian;?></td>
                                            <td><?php echo $nama;?></td>
                                            <td><?php echo $mobil;?></td>
                                            <td><?php echo $plat;?></td>
                                            <td>
                                            <a class="btn btn-sm btn-danger" href="antrian-hapus.php?no=<?php echo $antrian;?>&id=<?php echo $id_pel;?>">
                                            <i class="fa fa-trash"></i> Batal</a>
                                            </td>
                                        </tr>
                                        <?php }?>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-8 -->
                <div class="col-lg-10">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                           Daftar Proses Pengeringan</div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <form role="form" action="antrian.php" method="post" enctype="multipart/form-data" name="frmkry">
                            <a class="btn btn-sm btn-primary" href="pengeringan.php"><i class="fa fa-navicon"></i> Detail</a><br><br>
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                      <th>Tgl Masuk</th>
                                      <th> Antrian</th>
                                      <th>Pemilik</th>
                                        <th>Nomor Polisi</th>
                                        <th>Mobil</th>
                                        <th width="20%">Tools</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
								$q_ = "SELECT * FROM pelanggan WHERE status = 'Pengeringan' ORDER BY tgl_masuk DESC";
								$r_ = mysql_query($q_);
								while($d = mysql_fetch_array($r_)){
								$nomor_antrian= $d['nomor_antrian'];
								$id_antrian= $d['id_antrian'];
								$pemilik= $d['pemilik'];
								$nomor_polisi= $d['nomor_polisi'];
								$merk_mobil= $d['merk_mobil'];
								$warna= $d['warna'];
								$tgl_masuk= tgl_indo($d['tgl_masuk']);
								$jam_masuk= $d['jam_masuk'];
								$jam_keluar= $d['jam_keluar'];
								?>
                                    <tr>
                                      <td><?php echo $tgl_masuk;?></td>
                                      <td><?php echo $nomor_antrian;?></td>
                                      <td><?php echo $pemilik;?></td>
                                        <td><?php echo $nomor_polisi;?></td>
                                        <td><?php echo $merk_mobil;?></td>
                                        <td class="center">
											<a class="btn btn-sm btn-success" href="pengeringan-selesai-dashboard.php?id=<?php echo $id_antrian;?>">
                                            	<i class="fa fa-check"></i> Selesai
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
                <!-- /.col-lg-8 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="../vendor/metisMenu/metisMenu.min.js"></script>
    <script src="../vendor/raphael/raphael.min.js"></script>
    <script src="../vendor/morrisjs/morris.min.js"></script>
    <script src="../data/morris-data.js"></script>
    <script src="../dist/js/sb-admin-2.js"></script>
    
</body>

</html>
