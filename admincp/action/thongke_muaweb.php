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
$thaythe['title']='Thống kê giao dịch mua web';
$thaythe['title_action']='Thống kê giao dịch mua web';
$start_today=mktime(0,0,0,date('m'),date('d'),date('Y'));
$end_today=mktime(23,59,59,date('m'),date('d'),date('Y'));
$start_homqua=$start_today - 24*3600;
$end_homqua=$end_today - 24*3600;
$tukhoa='Cài đặt giao diện';
$thongke_homnay=mysqli_query($conn,"SELECT * FROM lichsu_chitieu WHERE date_post>='$start_today' AND date_post<='$end_today' AND noidung LIKE '%$tukhoa%'");
while($r_hn=mysqli_fetch_assoc($thongke_homnay)){
    $i++;
    $total_homnay+=$r_hn['sotien'];
}
$total_giaodich_homnay=$i;
$thongke_homqua=mysqli_query($conn,"SELECT * FROM lichsu_chitieu WHERE date_post>='$start_homqua' AND date_post<='$end_homqua' AND noidung LIKE '%$tukhoa%'");
while($r_hq=mysqli_fetch_assoc($thongke_homqua)){
    $k++;
    $total_homqua+=$r_hq['sotien'];
}
$total_giaodich_homqua=$k;
$end=date('d/m/Y');
$date_end=date('d');
$month_end=date('m');
$year_end=date('Y');
$end_time=mktime(23,59,59,$month_end,$date_end,$year_end);
$begin_time=$end_time - 31*24*3600;
$begin=date('d/m/Y',$begin_time);
$tach_data=json_decode($class_index->thongke_muaweb($conn,$begin_time,$end_time),true);
$bien=array(
    'footer'=>$skin->skin_normal('skin_admin/footer'),
    'end'=>$end,
    'begin'=>$begin,
    'total_homqua'=>number_format($total_homqua),
    'total_homnay'=>number_format($total_homnay),
    'total_giaodich_homqua'=>number_format($total_giaodich_homqua),
    'total_giaodich_homnay'=>number_format($total_giaodich_homnay),
    'homqua'=>date('d/m/Y',$start_homqua),
    'homnay'=>date('d/m/Y'),
    'list'=>$tach_data['list'],
    'total_tk'=>number_format($tach_data['tongtien']),
    'total_giaodich_tk'=>number_format($tach_data['total'])
);
$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/thongke_muaweb',$bien);  
?>