<?php
include './includes/tlca_world.php';
include_once "./class.phpmailer.php";
$check = $tlca_do->load('class_check');
$action = addslashes(strip_tags($_REQUEST['action']));
$class_index = $tlca_do->load('class_index');
$class_member = $tlca_do->load('class_member');
$setting = mysqli_query($conn, "SELECT * FROM index_setting ORDER BY name ASC");
while ($r_s = mysqli_fetch_assoc($setting)) {
	$index_setting[$r_s['name']] = $r_s['value'];
}
$thongtin_tb_moi=mysqli_query($conn,"SELECT * FROM thongbao_don ORDER BY date_post DESC LIMIT 1");
$r_tb_m=mysqli_fetch_assoc($thongtin_tb_moi);
$gio=intval(date('H'));
$gioi_han=time() - $r_tb_m['date_post'];
$post=rand(0,9);
if($gio<5){
	$time_rand=rand(300,600);
}else if($gio>=5 AND $gio<7){
	$time_rand=rand(120,600);
	if($gioi_han>$time_rand AND in_array($post, array('1','3','5','7','8'))==true){
		$thongtin_dh=mysqli_query($conn,"SELECT * FROM donhang ORDER BY rand() DESC LIMIT 1");
		$r_tt_dh=mysqli_fetch_assoc($thongtin_dh);
		$hientai=time();
		$ngay_thang_dh=date('d-m-Y',$hientai);
		$ho=array('Nguyễn','Trần','Lê','Phạm','Hoàng','Huỳnh','Bùi','Phan','Vũ','Võ','Đặng','Đỗ','Hồ','Ngô','Dương','Lý');
		$thongtin_user_dh=mysqli_query($conn,"SELECT * FROM user_info WHERE name NOT LIKE '%demo%' AND name NOT LIKE '%Test%' AND name NOT LIKE '%test%' AND name NOT LIKE '%Demo%' ORDER BY rand() DESC LIMIT 1");
		$r_u_dh=mysqli_fetch_assoc($thongtin_user_dh);
		$tach_ten_dh=explode(' ', $r_u_dh['name']);
		$dau_ten_dh=$tach_ten_dh[0];
		$ho_without_dau = array_diff($ho, array($dau_ten_dh));
		// Lấy ngẫu nhiên một phần tử trong mảng mới
		$ho_chon = $ho_without_dau[array_rand($ho_without_dau)];
		$tach_ten_dh[0]=$ho_chon;
		$ten_moi= implode(' ', $tach_ten_dh);
		$list_mang_dh='086,096,097,097,032,033,034,035,036,037,038,039,091,094,088,083,084,085,081,082,089,090,093,070,079,077,076,078';
		$mang_dh=explode(',', $list_mang_dh);
		$dau_so_dh=substr($r_u_dh['mobile'], 0,3);
		$dauso_without_dau = array_diff($mang_dh, array($dau_so_dh));
		// Lấy ngẫu nhiên một phần tử trong mảng mới
		$dauso_chon = $dauso_without_dau[array_rand($dauso_without_dau)];
		$so_moi=$dauso_chon.''.substr($r_u_dh['mobile'], 3);
		mysqli_query($conn, "INSERT INTO thongbao_don(user_id,ho_ten,dien_thoai,tam_tinh,tong_tien,thich,ngay,date_post)VALUES('0','$ten_moi','$so_moi','{$r_tt_dh['tamtinh']}','{$r_tt_dh['tongtien']}','','$ngay_thang_dh','$hientai')");
		echo "Đã post";
	}else{
		echo 'Không Post';
	}
}else if($gio>=22 AND $gio<=23){
	$time_rand=rand(200,300);
	if($gioi_han>$time_rand AND in_array($post, array('1','3','5','7','8'))==true){
		$thongtin_dh=mysqli_query($conn,"SELECT * FROM donhang ORDER BY rand() DESC LIMIT 1");
		$r_tt_dh=mysqli_fetch_assoc($thongtin_dh);
		$hientai=time();
		$ngay_thang_dh=date('d-m-Y',$hientai);
		$ho=array('Nguyễn','Trần','Lê','Phạm','Hoàng','Huỳnh','Bùi','Phan','Vũ','Võ','Đặng','Đỗ','Hồ','Ngô','Dương','Lý');
		$thongtin_user_dh=mysqli_query($conn,"SELECT * FROM user_info WHERE name NOT LIKE '%demo%' AND name NOT LIKE '%Test%' AND name NOT LIKE '%test%' AND name NOT LIKE '%Demo%' ORDER BY rand() DESC LIMIT 1");
		$r_u_dh=mysqli_fetch_assoc($thongtin_user_dh);
		$tach_ten_dh=explode(' ', $r_u_dh['name']);
		$dau_ten_dh=$tach_ten_dh[0];
		$ho_without_dau = array_diff($ho, array($dau_ten_dh));
		// Lấy ngẫu nhiên một phần tử trong mảng mới
		$ho_chon = $ho_without_dau[array_rand($ho_without_dau)];
		$tach_ten_dh[0]=$ho_chon;
		$ten_moi= implode(' ', $tach_ten_dh);
		$list_mang_dh='086,096,097,097,032,033,034,035,036,037,038,039,091,094,088,083,084,085,081,082,089,090,093,070,079,077,076,078';
		$mang_dh=explode(',', $list_mang_dh);
		$dau_so_dh=substr($r_u_dh['mobile'], 0,3);
		$dauso_without_dau = array_diff($mang_dh, array($dau_so_dh));
		// Lấy ngẫu nhiên một phần tử trong mảng mới
		$dauso_chon = $dauso_without_dau[array_rand($dauso_without_dau)];
		$so_moi=$dauso_chon.''.substr($r_u_dh['mobile'], 3);
		mysqli_query($conn, "INSERT INTO thongbao_don(user_id,ho_ten,dien_thoai,tam_tinh,tong_tien,thich,ngay,date_post)VALUES('0','$ten_moi','$so_moi','{$r_tt_dh['tamtinh']}','{$r_tt_dh['tongtien']}','','$ngay_thang_dh','$hientai')");
		echo "Đã post";
	}else{
		echo 'Không Post';
	}
}else{
	$time_rand=rand(50,200);
	if($gioi_han>$time_rand AND in_array($post, array('1','3','5','7','8'))==true){
		$thongtin_dh=mysqli_query($conn,"SELECT * FROM donhang ORDER BY rand() DESC LIMIT 1");
		$r_tt_dh=mysqli_fetch_assoc($thongtin_dh);
		$hientai=time();
		$ngay_thang_dh=date('d-m-Y',$hientai);
		$ho=array('Nguyễn','Trần','Lê','Phạm','Hoàng','Huỳnh','Bùi','Phan','Vũ','Võ','Đặng','Đỗ','Hồ','Ngô','Dương','Lý');
		$thongtin_user_dh=mysqli_query($conn,"SELECT * FROM user_info WHERE name NOT LIKE '%demo%' AND name NOT LIKE '%Test%' AND name NOT LIKE '%test%' AND name NOT LIKE '%Demo%' ORDER BY rand() DESC LIMIT 1");
		$r_u_dh=mysqli_fetch_assoc($thongtin_user_dh);
		$tach_ten_dh=explode(' ', $r_u_dh['name']);
		$dau_ten_dh=$tach_ten_dh[0];
		$ho_without_dau = array_diff($ho, array($dau_ten_dh));
		// Lấy ngẫu nhiên một phần tử trong mảng mới
		$ho_chon = $ho_without_dau[array_rand($ho_without_dau)];
		$tach_ten_dh[0]=$ho_chon;
		$ten_moi= implode(' ', $tach_ten_dh);
		$list_mang_dh='086,096,097,097,032,033,034,035,036,037,038,039,091,094,088,083,084,085,081,082,089,090,093,070,079,077,076,078';
		$mang_dh=explode(',', $list_mang_dh);
		$dau_so_dh=substr($r_u_dh['mobile'], 0,3);
		$dauso_without_dau = array_diff($mang_dh, array($dau_so_dh));
		// Lấy ngẫu nhiên một phần tử trong mảng mới
		$dauso_chon = $dauso_without_dau[array_rand($dauso_without_dau)];
		$so_moi=$dauso_chon.''.substr($r_u_dh['mobile'], 3);
		mysqli_query($conn, "INSERT INTO thongbao_don(user_id,ho_ten,dien_thoai,tam_tinh,tong_tien,thich,ngay,date_post)VALUES('0','$ten_moi','$so_moi','{$r_tt_dh['tamtinh']}','{$r_tt_dh['tongtien']}','','$ngay_thang_dh','$hientai')");
		echo "Đã post";
	}else{
		echo 'Không Post';
	}
}
echo "<br>";
echo ceil($time_rand/60);	
?>