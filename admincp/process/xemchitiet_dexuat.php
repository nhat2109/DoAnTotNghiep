<?php
$id = $_REQUEST['id'];
$thongtin = mysqli_query($conn,"SELECT * FROM dexuat WHERE id = '{$id}'");
$r = mysqli_fetch_assoc($thongtin);
			$r['i'] = $i++;
			$tt_ng = mysqli_query($conn,"SELECT * FROM emin_info WHERE id = '{$r['nguoigui']}'");
			$tt_ng_a = mysqli_fetch_assoc($tt_ng);
			$r['nguoi_dexuat'] = $tt_ng_a['name'];
			$tt_pb = mysqli_query($conn,"SELECT * FROM phong_ban WHERE id ='{$tt_ng_a['id_phongban']}'");
			$tt_pb_a = mysqli_fetch_assoc($tt_pb);
			$r['phongban'] = $tt_pb_a['tieu_de_phongban'];
			$r['thoigian'] = date('H:i:s d-m-Y',$r['thoigian']);
			if ($user_info['sep'] == 'sep') {
				if ($r['trangthai'] === '0') {
					$r['button_all_dexuat'] = "<button name='xacnhan_dexuat' data-id='{$r['id']}'>Xác nhận</button><button name='tuchoi_dexuat' data-id='{$r['id']}'>Từ chối</button>";
					$r['trangthai'] = "Chờ xét duyệt";
				}elseif($r['trangthai'] === '1'){
					$r['button_all_dexuat'] = "Đã phê duyệt";
					$r['trangthai'] = "Đã phê duyệt";
				}elseif($r['trangthai'] === '2'){
					$r['button_all_dexuat'] = "Đã từ chối";
					$r['trangthai'] = "Đã từ chối";
				}
			}else{
				if ($r['trangthai'] === '0') {
					$r['button_all_dexuat'] = "Chờ xét duyệt";
					$r['trangthai'] = "Chờ xét duyệt";
				}elseif($r['trangthai'] === '1'){
					$r['button_all_dexuat'] = "Đã phê duyệt";
					$r['trangthai'] = "Đã phê duyệt";
				}elseif($r['trangthai'] === '2'){
					$r['button_all_dexuat'] = "Đã từ chối";
					$r['trangthai'] = "Đã từ chối";
				}
			}
			$r['created_at'] = date('H:i:s d-m-Y',$r['created_at']);
			$r['thoigian'] = date('H:i:s d-m-Y',$r['thoigian']);
			if ($r['file'] == '' || $r['file'] == "" ) {
				$r['file_name'] = "--";
			}else{
				$r['file_name'] = "<a href='{$r['file']}'>Xem File</a>";
			}
$list = $skin->skin_replace('skin_cpanel/box_action/xemchitiet_dexuat',$r);
echo json_encode($list);