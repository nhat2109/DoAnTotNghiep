<?php
$hientai=time();
$noi_dung=addslashes(strip_tags($_REQUEST['noi_dung']));
$thanh_vien=intval($_REQUEST['thanh_vien']);
$thongtin=mysqli_query($conn,"SELECT * FROM user_info WHERE user_id='$thanh_vien'");
$r_tt=mysqli_fetch_assoc($thongtin);
if(strlen($noi_dung)<2){
    $ok=0;
    $thongbao='Chưa nhập nội dung lưu ý';
}else{
    $thongtin=mysqli_query($conn,"SELECT * FROM chat WHERE thanh_vien='$thanh_vien' AND active='1'");
    $total=mysqli_num_rows($thongtin);
    if($total>0){
        $ok=0;
        $thongbao='Thất bại! Thành viên này đang yêu cầu hỗ trợ';
    }else{
        $ok=1;
        $thongbao='Thành công! Liên hệ đã được gửi đi';
        $phien_traodoi=$class_index->creat_random($conn,'phien_traodoi');
        mysqli_query($conn,"INSERT INTO chat(phien,bo_phan,tieu_de,thanh_vien,user_in,user_out,noi_dung,doc,active,date_post)VALUES('$phien_traodoi','{$user_info['bo_phan']}','$noi_dung','$thanh_vien','$thanh_vien','{$user_info['id']}','','0','1','$hientai')");
        $thay=array(
            'ho_ten'=>$r_tt['name'],
            'mobile'=>$r_tt['mobile'],
            'tieu_de'=>$noi_dung,
            'date_post'=>'Vừa xong',
            'phien'=>$phien_traodoi,
            'thanh_vien'=>$thanh_vien,
            'active'=>'active'
        );
        $list=$skin->skin_replace('skin_cpanel/box_action/li_yeucau', $thay);
    }
}
$info=array(
    'ok'=>$ok,
    'thongbao'=>$thongbao,
    'thanh_vien'=>$thanh_vien,
    'ho_ten'=>$r_tt['name'],
    'phien'=>$phien_traodoi,
    'list'=>$list,
    'phien_traodoi'=>$phien_traodoi,
);
echo json_encode($info);
