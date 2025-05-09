<?php
	$thaythe['title'] = 'Chi tiết đơn hàng';
	$thaythe['title_action'] = 'Chi tiết đơn hàng';
	$id = preg_replace('/[^0-9]/', '', $url_query['id']);
	$thongtin = mysqli_query($conn, "SELECT *, count(*) AS total FROM donhang_ctv WHERE id='$id' AND user_id='$user_id'");
	$r_tt = mysqli_fetch_assoc($thongtin);
	if ($r_tt['total'] == 0) {
		$thongbao = "Đơn hàng không tồn tại...";
		$replace = array(
			'title' => 'Đơn hàng không tồn tại...',
			'description' => $index_setting['description'],
			'thongbao' => $thongbao,
			'link_chuyen' => '/dropship/list-donhang-socdo',
		);
		echo $skin->skin_replace('skin_dropship/chuyenhuong', $replace);
		exit();
	}
	$r_tt['date_post'] = date('H:i:s d/m/Y', $r_tt['date_post']);
	$tach_sanpham = json_decode($r_tt['sanpham'], true);
	foreach ($tach_sanpham as $key => $value) {
		if ($value['size'] != '') {
			$value['size'] = ' - Size: ' . $value['size'];
		}
		if ($value['color'] != '') {
			$value['color'] = ' - Màu: ' . $value['color'];
		}
		if($value['ma_sanpham']!=''){
			$value['ma_sanpham']=$value['ma_sanpham'];
		}else{
			$value['ma_sanpham']='';
		}
		if($value['gia_ctv']!=''){
			$value['gia_ctv']=$value['gia_ctv'];
		}else{
			$value['gia_ctv']='';
		}
		if($value['gia_moi']!=''){
			$value['gia_moi']=$value['gia_moi'];
		}else{
			$value['gia_moi']='';
		}
		if($value['giam']!=''){
			$value['giam']=$value['giam'];
		}else{
			$value['giam']='0';
		}
		$list_sanpham .= $skin->skin_replace('skin_dropship/box_action/li_sanpham_order', $value);
	}
	$r_tt['list_sanpham'] = $list_sanpham;
	if($id<36){
		$thontin_huyen=mysqli_query($conn,"SELECT huyen_moi.*,tinh_moi.tieu_de AS ten_tinh FROM huyen_moi INNER JOIN tinh_moi ON tinh_moi.id=huyen_moi.tinh WHERE huyen_moi.id='{$r_tt['huyen']}'");
		$r_h = mysqli_fetch_assoc($thontin_huyen);
		$r_tt['ten_tinh'] = $r_h['ten_tinh'];
		$r_tt['ten_huyen'] = $r_h['tieu_de'];
	}
    if($r_tt['status']==1){
        $r_tt['status']='Đã tiếp nhận đơn';
    }else if($r_tt['status']==2){
        $r_tt['status']='Đã giao đơn vị vận chuyển';
    }else if($r_tt['status']==3){
        $r_tt['status']='Đã yêu cầu hủy đơn';
    }else if($r_tt['status']==4){
        $r_tt['status']='Đã hủy đơn';
    }else if($r_tt['status']==5){
        $r_tt['status']='Giao thành công';
    }else{
        $r_tt['status']='Chờ xử lý';
    }
    if($r_tt['chiu_ship']=='shop'){
    	$r_tt['chiu_ship']='Người bán chịu phí';
    	$tong_thu=number_format($r_tt['cod']);
    }else{
    	if($r_tt['phi_ship']>0){
    		$tong_thu=$r_tt['cod'] + $r_tt['phi_ship'];
    	}else{
    		$tong_thu=$r_tt['cod'];
    	}
    	$tong_thu=number_format($tong_thu);
    	$r_tt['chiu_ship']='Khách hàng chịu phí';
    }
	if($r_tt['phi_ship']>0){
		$r_tt['phi_ship']=number_format($r_tt['phi_ship']).'đ';
	}else{
		$r_tt['phi_ship']='Miễn phí';
	}
	$r_tt['tamtinh'] = number_format($r_tt['tamtinh']);
	$r_tt['giam'] = number_format($r_tt['giam']);
	$r_tt['tongtien'] = number_format($r_tt['tongtien']);
	$r_tt['cod'] = number_format($r_tt['cod']);
	$r_tt['tong_thu'] = $tong_thu;
	$r_tt['hoahong'] = number_format($r_tt['hoahong']);
	$thaythe['box_right'] = $skin->skin_replace('skin_dropship/box_action/edit_donhang_socdo', $r_tt);
?>