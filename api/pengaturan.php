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

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="../vendor/morrisjs/morris.css" rel="stylesheet">

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
		<?php
		 include "../inc.session.php";
		 include "header-and-menu.php";
		 include "../koneksi.php";
		 ?>
        <div id="page-wrapper">
        	<p>&nbsp;</p>
            <div class="row">
                <div class="col-lg-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <i class="fa fa-key fa-fw"></i> Ganti Password
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            
							<?php
                            if(isset($_POST['btnsave'])){
                                // Baca form
                                $txtPassBaru= $_POST['txtpassbaru'];
                                $txtPassBaru2=$_POST['txtpassbaru2'];
                                $txtPassLama= $_POST['txtpasslama'];
                                
                                // Validasi Password lama (harus benar)
                                $sqlCek = "SELECT * FROM user WHERE username='".$_SESSION['ECI_User']."' AND password ='".md5($txtPassLama)."'";
                                $qryCek = mysql_query($sqlCek)  or die ("Query Periksa Password Salah : ".mysql_error());
                                if(mysql_num_rows($qryCek) <1){
                                    echo "<div class='alert alert-danger alert-dismissible' role='alert'>
                                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                    <span aria-hidden='true'>&times;</span></button>
                                    <strong>Password Lama Salah</strong>.
                                    </div>";
                                    
                                }else{
                                    if (trim($txtPassBaru) != trim($txtPassBaru2)) {
                                        echo "<div class='alert alert-info alert-dismissible' role='alert'>
                                        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                        <span aria-hidden='true'>&times;</span></button>
                                        <strong>Password Baru Tidak Sama</strong>.
                                        </div>";	
                                    }else{
                                    # SIMPAN DATA KE DATABASE. Jika tidak menemukan pesan error, simpan data ke database
                                    $mySql	= "UPDATE user SET password='".md5($txtPassBaru)."'";
                                    $myQry	= mysql_query($mySql);
                                    if($myQry){
                                        echo "<div class='alert alert-success alert-dismissible' role='alert'>
                                        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                        <span aria-hidden='true'>&times;</span></button>
                                        <strong>Password Berhasil Di Ganti</strong>.
                                        </div>";
                                        }
                                    }
                                }
                            }
                            
                            ?>
                             <form role="form" action="pengaturan.php" method="post" enctype="multipart/form-data" name="frmpass">
                                <div class="col-lg-10 col-lg-offset-1">
                                    <p>&nbsp;</p>
                                    <div class="form-group">
                                        <label>Password Lama</label>
                                        <input type="password" name="txtpasslama" required class="form-control" placeholder="Password Lama">
                                    </div>
                                    <div class="form-group">
                                        <label>Password Baru</label>
                                        <input type="password" name="txtpassbaru" required class="form-control" placeholder="Password Baru">
                                    </div>
                                    <div class="form-group">
                                        <label>Ulangi Password Baru</label>
                                        <input type="password" name="txtpassbaru2" required class="form-control" placeholder="Ulangi Password Baru">
                                    </div>
                                    <div class="form-group" align="right">
                                        <Button type="submit" name="btnsave" class="btn btn-sm btn-success">Update</Button>
                                    </div>
                                    
                                </div>
                            </form>
                            
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-4 -->
            </div>
            <!-- /.row -->
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

    <!-- Morris Charts JavaScript -->
    <script src="../vendor/raphael/raphael.min.js"></script>
    <script src="../vendor/morrisjs/morris.min.js"></script>
    <script src="../data/morris-data.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

</body>

</html>
