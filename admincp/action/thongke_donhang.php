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
$thaythe['title']='Thống kê đơn hàng';
$thaythe['title_action']='Thống kê đơn hàng';
$limit=10;
$homnay=date('d');
$thangnay=intval(date('m'));
$namnay=date('Y');
$date  = mktime(0, 0, 0, $thangnay, $homnay, $namnay);
$week  = (int)date('W', $date);
$ngay_dau=mktime(0,0,0,01,01,date('Y'));
$ngay_cuoi=mktime(0,0,0,12,31,date('Y'));
if($thangnay==2){
    if(checkdate(02,29,$namnay)==true){
        $ngay_dau_thang=mktime(0,0,0,$thangnay,1,$namnay);
        $ngay_cuoi_thang=mktime(0,0,0,$thangnay,29,$namnay);
        for ($i=1; $i <=29 ; $i++) {
            if($i<10){
                $list_ngay.='0'.$i.',';
            }else{
                $list_ngay.=$i.',';
            }
        }
    }else{
        $ngay_dau_thang=mktime(0,0,0,$thangnay,1,$namnay);
        $ngay_cuoi_thang=mktime(0,0,0,$thangnay,28,$namnay);
        for ($i=1; $i <=20 ; $i++) { 
            if($i<10){
                $list_ngay.='0'.$i.',';
            }else{
                $list_ngay.=$i.',';
            }
        }

    }
}else if(in_array($thangnay, array('1','3','5','7','8','10','12'))==true){
    $ngay_dau_thang=mktime(0,0,0,$thangnay,1,$namnay);
    $ngay_cuoi_thang=mktime(0,0,0,$thangnay,31,$namnay);
    for ($i=1; $i <=31 ; $i++) { 
        if($i<10){
            $list_ngay.='0'.$i.',';
        }else{
            $list_ngay.=$i.',';
        }
    }
}else{
    $ngay_dau_thang=mktime(0,0,0,$thangnay,1,$namnay);
    $ngay_cuoi_thang=mktime(0,0,0,$thangnay,30,$namnay);
    for ($i=1; $i <=30 ; $i++) { 
        if($i<10){
            $list_ngay.='0'.$i.',';
        }else{
            $list_ngay.=$i.',';
        }
    }
}
$list_ngay=substr($list_ngay, 0,-1);
$ngay_tuan=$check->day_from_monday(date('d-m-Y'));
$ngay_dau_tuan=mktime(0,0,0,$thangnay,$ngay_tuan[0],$namnay);
$ngay_cuoi_tuan=mktime(0,0,0,$thangnay,$ngay_tuan[6],$namnay);
$thongke=json_decode($class_index->thongke_donhang($conn,$ngay_dau,$ngay_cuoi),true);
$thongke_thang=json_decode($class_index->thongke_donhang_thang($conn,$thangnay,$namnay,$ngay_dau_thang,$ngay_cuoi_thang),true);
$bien=array(
    'footer'=>$skin->skin_normal('skin_admin/footer'),
    'nam'=>$namnay,
    'thang'=>$thangnay,
    'list_ngay'=>$list_ngay,
    'data_donhang'=>$thongke['data_donhang'],
    'data_hoanthanh'=>$thongke['data_hoanthanh'],
    'data_vanchuyen'=>$thongke['data_vanchuyen'],
    'data_cho'=>$thongke['data_cho'],
    'data_hoan'=>$thongke['data_hoan'],
    'data_huy'=>$thongke['data_huy'],
    'data_thang'=>$thongke_thang['data_thang'],
    'data_hoanthanh_thang'=>$thongke_thang['data_hoanthanh_thang'],
    'data_vanchuyen_thang'=>$thongke_thang['data_vanchuyen_thang'],
    'data_huy_thang'=>$thongke_thang['data_huy_thang'],
    'data_hoan_thang'=>$thongke_thang['data_hoan_thang'],
    'data_cho_thang'=>$thongke_thang['data_cho_thang'],
);
$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/thongke_donhang',$bien);  
?>