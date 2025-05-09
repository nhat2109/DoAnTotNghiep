<?php
	$nhiemvu=intval($_REQUEST['nhiemvu']);
	$thongtin=mysqli_query($conn,"SELECT *,count(*) AS total FROM nhiem_vu WHERE id='$nhiemvu'");
	$r_tt=mysqli_fetch_assoc($thongtin);
	if($r_tt['total']==0){
		$ok=0;
		$thongbao='Thất bại! Nhiệm vụ không tồn tại';
	}else{
		$thongtin_lichsu=mysqli_query($conn,"SELECT *,count(*) AS total FROM lichsu_nhiemvu WHERE ngay='{$r_tt['ngay']}' AND user_id='$user_id' ORDER BY id DESC LIMIT 1");
		$r_ls=mysqli_fetch_assoc($thongtin_lichsu);
		if($r_ls['total']==0){
			$thongtin_moi=mysqli_query($conn,"SELECT * FROM lichsu_nhiemvu WHERE user_id='$user_id' ORDER BY id DESC LIMIT 1");
			$r_m=mysqli_fetch_assoc($thongtin_moi);
			$total_moi=mysqli_num_rows($thongtin_moi);
			if($total_moi==0){
				if($r_tt['ngay']==1){
					$ok=1;
					$thongbao='Thành công! Nhiệm vụ đã được mở';
					mysqli_query($conn,"INSERT INTO lichsu_nhiemvu(user_id,ngay,nhiem_vu,hoan_thanh,update_post,date_post)VALUES('$user_id','{$r_tt['ngay']}','$nhiemvu','0','$hientai','$hientai')");
				}else{
					$ok=0;
					$thongbao='Thất bại! Vui lòng mở nhiệm vui theo thứ tự';
				}
			}else{
				$ngay_tiep=$r_m['ngay'] + 1;
				$gioi_han=mktime(18,00,00,04,26,2023);
				if($r_tt['ngay']==3 AND $gioi_han>time()){
					$ok=0;
					$thongbao='Thất bại! Chưa thể mở nhiệm vụ này bây giờ';
				}else{
					if($r_tt['ngay']==$ngay_tiep){
						$ngay_cu=date('d/m/Y',$r_m['date_post']);
						$ngay_moi=date('d/m/Y');
						if($ngay_cu==$ngay_moi){
							$ok=0;
							$thongbao='Thất bại! Vui lòng mở nhiệm vụ này vào hôm sau';
						}else{
							mysqli_query($conn,"INSERT INTO lichsu_nhiemvu(user_id,ngay,nhiem_vu,hoan_thanh,update_post,date_post)VALUES('$user_id','{$r_tt['ngay']}','$nhiemvu','0','$hientai','$hientai')");
							$ok=1;
							$thongbao='Thành công! Nhiệm vụ đã được mở';
						}

					}else{
						$ok=0;
						$thongbao='Thất bại! Vui lòng mở nhiệm vụ theo thứ tự';
					}
				}


			}
		}else{
			$ok=0;
			$thongbao='Thất bại! Nhiệm vụ đã được mở';
		}
	}
	$info=array(
		'ok'=>$ok,
		'thongbao'=>$thongbao,
	);
	echo json_encode($info);
?>