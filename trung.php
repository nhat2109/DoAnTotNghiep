<?php
include('./includes/tlca_world.php');
$thongtin_naptien=mysqli_query($conn,"SELECT noidung FROM lichsu_chitieu GROUP BY noidung HAVING COUNT(*)>1");
while($r_tt=mysqli_fetch_assoc($thongtin_naptien)){
	echo $r_tt['noidung'].'<br>';
}
