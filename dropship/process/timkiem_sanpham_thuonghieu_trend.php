<?php
	$thuong_hieu = addslashes(strip_tags($_REQUEST['thuong_hieu']));
	$kieu=addslashes($_REQUEST['kieu']);
	if (isset($_COOKIE['drop_kho'])) {
		$kho = addslashes(strip_tags($_COOKIE['drop_kho']));
	} else {
		$kho = 'kho';
	}
	if($kieu=='mobile'){
		$list = $class_index->list_kq_timkiem_sanpham_thuonghieu_trend($conn,$user_info['leader'],$user_info['gia_leader'],'mobile', $kho, $user_id, $thuong_hieu);
		$kieu="mobile";
	}else{
		$kieu="laptop";
	$list = $class_index->list_kq_timkiem_sanpham_thuonghieu_trend($conn,$user_info['leader'],$user_info['gia_leader'],'laptop', $kho, $user_id, $thuong_hieu);
	$list = '<tr>
		<th style="text-align: center;width: 50px;" class="hide_mobile">STT</th>
		<th style="text-align: center;width: 120px;" class="hide_mobile">Minh họa</th>
		<th style="text-align: left;">Tên sản phẩm</th>
		<th style="text-align: center;width: 100px;" class="hide_mobile">Tồn kho</th>
		<th style="text-align: center;width: 100px;" class="hide_mobile">Giá niêm yết</th>
		<th style="text-align: center;width: 100px;" class="hide_mobile">Giá nhập</th>
		<th style="text-align: center;width: 160px;" class="hide_mobile">Giá bán tối thiểu</th>
<th style="text-align: center;width: 160px;" class="hide_mobile">Giá bán gợi ý</th>
		<th style="text-align: center;width: 180px;">Hành động</th>
	</tr>' . $list;
	}
	$info = array(
		'ok' => 1,
		'list' => $list,
		'kieu'=>$kieu
	);
	echo json_encode($info);
?>