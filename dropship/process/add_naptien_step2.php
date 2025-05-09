<?php
			$id=intval($_REQUEST['id']);
			$thongtin=mysqli_query($conn,"SELECT * FROM naptien WHERE id='$id' AND user_id='$user_id'");
			$total=mysqli_num_rows($thongtin);
			$hientai=time();
			if($total==0){
				$ok=0;
				$thongbao='Thất bại! Dữ liệu không tồn tại';
				$html='';
			}else{
				$ok=1;
				$thongbao='Thành công! Vui lòng chờ xác nhận';
				mysqli_query($conn,"UPDATE naptien SET status='3' WHERE id='$id' AND user_id='$user_id'");
				$noidung_noti='Có người vừa hoàn thành nạp tiền';
				$html=$skin->skin_normal('skin_dropship/box_action/add_naptien_step3');
			}
			$info = array(
				'ok' => $ok,
				'thongbao' => $thongbao,
				'html'=>$html
			);
			echo json_encode($info);
?>