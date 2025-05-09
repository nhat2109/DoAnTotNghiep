<?php
			$thongtin=mysqli_query($conn,"SELECT * FROM donhang WHERE user_id='$user_id'");
			while($r_tt=mysqli_fetch_assoc($thongtin)){
				$tongtien+=$r_tt['tongtien'];
			}
			if($user_info['leader']==1){
				$ok=0;
				$thongbao='Thất bại! Bạn hiện đang là nhà bán chuyên nghiệp';
			}else if($tongtien<5000000 AND $user_info['gia_leader']==0 AND $user_info['doitac']!='knv'){
				$ok=0;
				$thongbao='Thất bại! Doanh thu của bạn chưa đủ';
			}else if($user_info['user_money']<$ss_setting['phi_leader']){
				$ok=0;
				$thongbao='Thất bại! Số tiền trong tài khoản không đủ';
			}else{
				$truoc=$user_info['user_money'];
				$conlai=$user_info['user_money'] - $ss_setting['phi_leader'];
				$so_tien=$ss_setting['phi_leader'];
				$noidung='Đăng ký làm nhà bán chuyên nghiệp';
				$hientai=time();
				if($user_info['aff']>0){
					$thongtin_gioithieu=mysqli_query($conn,"SELECT * FROM user_info WHERE user_id='{$user_info['aff']}'");
					$r_gt=mysqli_fetch_assoc($thongtin_gioithieu);
					$thuong=intval($ss_setting['phi_leader'])/2;
					$them=$r_gt['user_money'] + $thuong;
					$noidung_thuong='Hoa hồng '.$user_info['name'].' - '.$user_info['mobile'].' lên làm nhà bán chuyên nghiệp';
					mysqli_query($conn,"UPDATE user_info SET user_money='$them' WHERE user_id='{$r_gt['user_id']}'");
					mysqli_query($conn, "INSERT INTO lichsu_chitieu(user_id,sotien,truoc,sau,noidung,date_post)VALUES('{$r_gt['user_id']}','$thuong','{$r_gt['user_money']}','$them','$noidung_thuong'," . time() . ")");
				}
				mysqli_query($conn,"UPDATE user_info SET leader='1',leader_start='$hientai',user_money='$conlai' WHERE user_id='$user_id'");
				mysqli_query($conn, "INSERT INTO lichsu_chitieu(user_id,sotien,truoc,sau,noidung,date_post)VALUES('$user_id','$so_tien','$truoc','$conlai','$noidung'," . time() . ")");
				$ok=1;
				$thongbao='Thành công! Bạn đã trở thành nhà bán chuyên nghiệp';
			}
			$info=array(
				'ok'=>$ok,
				'thongbao'=>$thongbao
			);
			echo json_encode($info);
?>