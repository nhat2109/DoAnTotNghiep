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
$thaythe['title']='Thống kê drop';
$thaythe['title_action']='Thống kê drop';
$start_today=mktime(0,0,0,date('m'),date('d'),date('Y'));
$end_today=mktime(23,59,59,date('m'),date('d'),date('Y'));
$end_homqua=$end_today - 24*3600;
$start_homqua=$start_today - 24*3600;
$thongke_dangky=mysqli_query($conn,"SELECT count(*) AS total FROM user_info WHERE created>='$start_today' AND dropship='1' AND created<='$end_today'");
$r_dk=mysqli_fetch_assoc($thongke_dangky);
$thongke_naptien=mysqli_query($conn,"SELECT * FROM naptien WHERE update_post>='$start_today' AND update_post<='$end_today' AND status='1'");
while($r_nt=mysqli_fetch_assoc($thongke_naptien)){
    $i++;
    $u=$r_nt['user_id'];
    $list_nt[$u]['user_id']=$u;
    $list_nt[$u]['tongtien']+=$r_nt['sotien'];

}
$total_giaodich=$i;
$total_nap=count((array)$list_nt);
$thongke_dangky_homqua=mysqli_query($conn,"SELECT count(*) AS total FROM user_info WHERE created>='$start_homqua' AND dropship='1' AND created<='$end_homqua'");
$r_dk_hq=mysqli_fetch_assoc($thongke_dangky_homqua);
$thongke_naptien_homqua=mysqli_query($conn,"SELECT * FROM naptien WHERE update_post>='$start_homqua' AND update_post<='$end_homqua' AND status='1'");
while($r_nt_hq=mysqli_fetch_assoc($thongke_naptien_homqua)){
    $k++;
    $us=$r_nt_hq['user_id'];
    $list_nt_hq[$us]['user_id']=$u;
    $list_nt_hq[$us]['tongtien']+=$r_nt_hq['sotien'];

}
$total_giaodich_homqua=$k;
$total_nap_homqua=count((array)$list_nt_hq);
$thongtin_chinhthuc=mysqli_query($conn,"SELECT count(*) AS total FROM user_info WHERE dropship='1' AND chinh_thuc='1'");
$r_ct=mysqli_fetch_assoc($thongtin_chinhthuc);
$end=date('d/m/Y');
$date_end=date('d');
$month_end=date('m');
$year_end=date('Y');
$end_time=mktime(23,59,59,$month_end,$date_end,$year_end);
$end_time_homqua=$end_today - 24*3600;
$begin_time=$end_time - 31*24*3600;
$begin_time_homqua=$start_today - 24*3600;

$begin=date('d/m/Y',$begin_time);
$bien=array(
    'footer'=>$skin->skin_normal('skin_admin/footer'),
    'end'=>$end,
    'begin'=>$begin,
    'total_chinhthuc'=>number_format($r_ct['total']),
    'total_dangky'=>$r_dk['total'],
    'total_nap'=>number_format($total_nap),
    'total_giaodich'=>number_format($total_giaodich),
    'total_dangky_homqua'=>$r_dk_hq['total'],
    'total_nap_homqua'=>number_format($total_nap_homqua),
    'total_giaodich_homqua'=>number_format($total_giaodich_homqua),
    'homqua'=>date('d/m/Y',$begin_time_homqua),
    'list'=>$class_index->thongke_drop($conn,$begin_time,$end_time),
);
$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/thongke_drop',$bien);  
?>