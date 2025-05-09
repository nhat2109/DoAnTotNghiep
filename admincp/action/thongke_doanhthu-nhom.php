<?php 
    if(in_array('thongke', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
		$thongbao="Bạn không có quyền truy cập...";
		$replace=array(
			'title'=>'Bạn không có quyền truy cập...',
			'description'=>$index_setting['description'],
			'thongbao'=>$thongbao,
			'link_chuyen'=>'/admincp/dashboard'
		);
		echo $skin->skin_replace('skin_cpanel/chuyenhuong',$replace);
		exit();		
	}
	$id=preg_replace('/[^0-9a-zA-Z_-]/', '', $url_query['id']);
	$thongtin=mysqli_query($conn,"SELECT * FROM nhom WHERE id='$id'");
	$r_tt=mysqli_fetch_assoc($thongtin);
	$thaythe['title']='Báo cáo doanh thu '.$r_tt['tieu_de'];
	$thaythe['title_action']='Báo cáo doanh thu '.$r_tt['tieu_de'];
	$end=date('d/m/Y');
	$date_end=date('d');
	$month_end=date('m');
	$year_end=date('Y');
	$end_time=mktime(23,59,59,$month_end,$date_end,$year_end);
	$begin_time=$end_time - 31*24*3600;
	$begin=date('d/m/Y',$begin_time);
	$thongke=json_decode($class_index->thongke_doanhthu_nhom($conn,$r_tt['thanhvien'],$begin_time,$end_time),true);
	$bien=array(
		'tieu_de'=>$r_tt['tieu_de'],
		'id'=>$id,
		'end'=>$end,
		'begin'=>$begin,
		'doanhthu_hoanthanh'=>number_format($thongke['doanhthu_hoanthanh']),
		'doanhthu_giao'=>number_format($thongke['doanhthu_vanchuyen']),
		'doanhthu_cho'=>number_format($thongke['doanhthu_cho']),
		'doanhthu_tiepnhan'=>number_format($thongke['doanhthu_tiepnhan']),
		'doanhthu_huy'=>number_format($thongke['doanhthu_huy']),
		'doanhthu_hoan'=>number_format($thongke['doanhthu_hoan']),
		'donhang_hoanthanh'=>number_format($thongke['donhang_hoanthanh']),
		'donhang_giao'=>number_format($thongke['donhang_vanchuyen']),
		'donhang_huy'=>number_format($thongke['donhang_huy']),
		'donhang_cho'=>number_format($thongke['donhang_cho']),
		'donhang_tiepnhan'=>number_format($thongke['donhang_tiepnhan']),
		'donhang_hoan'=>number_format($thongke['donhang_hoan']),
		'list_doanhthu_thanhvien'=>$class_index->list_doanhthu_thanhvien_nhom($conn,$r_tt['thanhvien'],$r_tt['nhomtruong'],$begin_time,$end_time),
	);
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/thongke_doanhthu_nhom',$bien);
?>