<?php
include('./includes/tlca_world.php');
include_once("./class.phpmailer.php");
$check=$tlca_do->load('class_check');
$action=addslashes($_REQUEST['action']);
$class_index=$tlca_do->load('class_index');
$class_member=$tlca_do->load('class_member');
$page=intval($_REQUEST['page']);
if($page<1){
	$page=1;
}
$limit=100;
$start=$page*$limit - $limit;
$thongtin=mysqli_query($conn,"SELECT * FROM sanpham_shop ORDER BY id ASC LIMIT $start,$limit");
while($r_tt=mysqli_fetch_assoc($thongtin)){
	if(strpos($r_tt['size'], ',')!==false){
		$tach_size=explode(',', $r_tt['size']);
		foreach ($tach_size as $key => $value) {
			$thongtin_check=mysqli_query($conn,"SELECT *,count(*) AS total FROM kich_co WHERE goc='$value' AND shop='{$r_tt['shop']}' ORDER BY id ASC");
			$r_check=mysqli_fetch_assoc($thongtin_check);
			if($r_check['total']>0){
				$list_size.=$r_check['id'].',';

			}else{
				$thongtin_kichco=mysqli_query($conn,"SELECT *,count(*) AS total FROM kich_co WHERE id='$value' AND goc='0'");
				$r_kc=mysqli_fetch_assoc($thongtin_kichco);
				if($r_kc['total']>0){
					mysqli_query($conn,"INSERT INTO kich_co(shop,tieu_de,thu_tu,goc)VALUES('{$r_tt['shop']}','{$r_kc['tieu_de']}','{$r_kc['thu_tu']}','{$r_kc['id']}')");
					echo "INSERT INTO kich_co(shop,tieu_de,thu_tu,goc)VALUES('{$r_tt['shop']}','{$r_kc['tieu_de']}','{$r_kc['thu_tu']}','{$r_kc['id']}')<br>";
				}
			}
		}
		if($list_size!=''){
			$list_size=substr($list_size, 0,-1);
			mysqli_query($conn,"UPDATE sanpham_shop SET size='$list_size' WHERE id='{$r_tt['id']}'");
			echo "UPDATE sanpham_shop SET size='$list_size' WHERE id='{$r_tt['id']}'<br>";
			unset($list_size);
		}
	}else{
		$thongtin_check=mysqli_query($conn,"SELECT *,count(*) AS total FROM kich_co WHERE goc='{$r_tt['size']}' AND shop='{$r_tt['shop']}' ORDER BY id ASC");
		$r_check=mysqli_fetch_assoc($thongtin_check);
		if($r_check['total']>0){
			mysqli_query($conn,"UPDATE sanpham_shop SET size='{$r_check['id']}' WHERE id='{$r_tt['id']}'");
			echo "UPDATE sanpham_shop SET size='{$r_check['id']}' WHERE id='{$r_tt['id']}'<br>";

		}else{
			$thongtin_kichco=mysqli_query($conn,"SELECT *,count(*) AS total FROM kich_co WHERE id='{$r_tt['size']}' AND goc='0'");
			$r_kc=mysqli_fetch_assoc($thongtin_kichco);
			if($r_kc['total']>0){
				mysqli_query($conn,"INSERT INTO kich_co(shop,tieu_de,thu_tu,goc)VALUES('{$r_tt['shop']}','{$r_kc['tieu_de']}','{$r_kc['thu_tu']}','{$r_kc['id']}')");
				echo "INSERT INTO kich_co(shop,tieu_de,thu_tu,goc)VALUES('{$r_tt['shop']}','{$r_kc['tieu_de']}','{$r_kc['thu_tu']}','{$r_kc['id']}')<br>";
			}
		}
	}
}
$page++;
	echo "<title> Thông báo hệ thống </title>";
    echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>";
    echo "<center><font color=red>Đang chuyển hướng!</font></center>";
    echo "<meta http-equiv='refresh' content='3;url=/update_kichco_sanpham.php?page=".$page."'>"; 
?>