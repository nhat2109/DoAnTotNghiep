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
	$thaythe['title']='Báo cáo doanh thu seeding shopee';
	$thaythe['title_action']='Báo cáo doanh thu seeding shopee';
	$end=date('d/m/Y');
	$date_end=date('d');
	$month_end=date('m');
	$year_end=date('Y');
	$end_time=mktime(23,59,59,$month_end,$date_end,$year_end);
	$begin_time=$end_time - 31*24*3600;
	$begin=date('d/m/Y',$begin_time);
	$thongke=json_decode($class_index->thongke_seeding($conn,$begin_time,$end_time),true);
	$bien=array(
		'footer'=>$skin->skin_normal('skin_admin/footer'),
		'end'=>$end,
		'begin'=>$begin,
		'doanhthu_wait'=>number_format($thongke['doanhthu_wait']),
		'doanhthu_run'=>number_format($thongke['doanhthu_run']),
		'doanhthu_finish'=>number_format($thongke['doanhthu_finish']),
		'donhang_wait'=>number_format($thongke['donhang_wait']),
		'donhang_run'=>number_format($thongke['donhang_run']),
		'donhang_finish'=>number_format($thongke['donhang_finish']),
	);
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/thongke_seeding',$bien);
?>