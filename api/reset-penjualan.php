<style>
.loader {
    position: fixed;
    left: 0px;
    top: 0px;
    width: 100%;
    height: 100%;
    z-index: 9999;
    background: url("js/load.gif") 50% 50% no-repeat rgb(249,249,249);
    opacity: .8;
}
</style>
<script src="js/jquery2.2.4jquery.min.js"></script>
<script type="text/javascript">
$(window).load(function() {
    $(".loader").fadeOut("slow");
});
</script>
<div class="loader"></div>

<?php
	include "../inc.session.php";
	include "../koneksi.php";
	
	$p_id   = $_GET['id'];
	$yes = mysql_query("UPDATE penjualan SET JAN='0', FEB='0', MAR='0',APR='0',MEI='0',JUN='0',JUL='0',AGUST='0',SEPT='0',OKT='0',NOV='0',DES='0',total='0' WHERE id_penjualan='$p_id'");
	if($yes){
	echo "<meta http-equiv='refresh' content='0; url=penjualan.php'>";
	}
?>
