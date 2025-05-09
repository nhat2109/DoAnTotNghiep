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
	$thaythe['title']='Thống kê CTV';
	$thaythe['title_action']='Thống kê CTV';
	$start_today=mktime(0,0,0,date('m'),date('d'),date('Y'));
	$end_today=mktime(23,59,59,date('m'),date('d'),date('Y'));
	$start_homqua=$start_today - 24*3600;
	$end_homqua=$end_today - 24*3600;
	$thongke_dangky=mysqli_query($conn,"SELECT count(*) AS total FROM user_info WHERE created>='$start_today' AND ctv='1' AND created<='$end_today'");
	$r_dk=mysqli_fetch_assoc($thongke_dangky);
	$thongke_donhang=mysqli_query($conn,"SELECT * FROM donhang_ctv WHERE date_post>='$start_today' AND date_post<='$end_today'");
	while($r_dh=mysqli_fetch_assoc($thongke_donhang)){
		$i++;
		$u=$r_dh['user_id'];
		$list_dh[$u]['user_id']=$u;
	}
	$total_giaodich=$i;
	$total_co_don=count((array)$list_nt);
	$thongke_dangky_homqua=mysqli_query($conn,"SELECT count(*) AS total FROM user_info WHERE created>='$start_homqua' AND ctv='1' AND created<='$end_homqua'");
	$r_dk_homqua=mysqli_fetch_assoc($thongke_dangky_homqua);
	$thongke_donhang_homqua=mysqli_query($conn,"SELECT * FROM donhang_ctv WHERE date_post>='$start_homqua' AND date_post<='$end_homqua'");
	while($r_dh_hq=mysqli_fetch_assoc($thongke_donhang_homqua)){
		$k++;
		$us=$r_dh_hq['user_id'];
		$list_dh_hq[$us]['user_id']=$us;
	}
	$total_giaodich_homqua=$k;
	$total_co_don_homqua=count((array)$list_nt_hq);
	$thongtin_chinhthuc=mysqli_query($conn,"SELECT count(*) AS total FROM user_info WHERE ctv='1' AND chinh_thuc='1'");
	$r_ct=mysqli_fetch_assoc($thongtin_chinhthuc);
	$end=date('d/m/Y');
	$date_end=date('d');
	$month_end=date('m');
	$year_end=date('Y');
	$end_time=mktime(23,59,59,$month_end,$date_end,$year_end);
	$begin_time=$end_time - 31*24*3600;
	$begin=date('d/m/Y',$begin_time);
	$bien=array(
		'footer'=>$skin->skin_normal('skin_admin/footer'),
		'end'=>$end,
		'begin'=>$begin,
		'total_dangky'=>number_format($r_dk['total']),
		'total_co_don'=>number_format($total_co_don),
		'total_don'=>number_format($total_giaodich),
		'total_dangky_homqua'=>number_format($r_dk_hq['total']),
		'total_co_don_homqua'=>number_format($total_co_don_homqua),
		'total_don_homqua'=>number_format($total_giaodich_homqua),
		'homqua'=>date('d/m/Y',$start_homqua),
		'list'=>$class_index->thongke_ctv($conn,$begin_time,$end_time),
	);
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/thongke_ctv',$bien);
?>  