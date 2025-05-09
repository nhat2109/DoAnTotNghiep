<?php
$thaythe['title']='Sửa nội dung bán hàng';
$thaythe['title_action']='Sửa nội dung bán hàng';
$id=preg_replace('/[^0-9]/', '', $url_query['id']);
$thongtin=mysqli_query($conn,"SELECT list_share_sanpham.*,sanpham.tieu_de,sanpham.id AS sp_id, count(*) AS total FROM list_share_sanpham LEFT JOIN sanpham ON list_share_sanpham.sp_id=sanpham.id WHERE list_share_sanpham.id='$id'");
$r_tt=mysqli_fetch_assoc($thongtin);
if($r_tt['total']==0){
    $thongbao="Nội dung không tồn tại...";
    $replace=array(
        'title'=>'Sản phẩm không tồn tại...',
        'description'=>$index_setting['description'],
        'thongbao'=>$thongbao,
        'link_chuyen'=>'/ncc/list-sanpham'
    );
    echo $skin->skin_replace('skin_ncc/chuyenhuong',$replace);
    exit();
}
if(strlen($r_tt['minh_hoa'])>3){
    $tach_anh=explode(",", $r_tt['minh_hoa']);
    foreach ($tach_anh as $key => $value) {
        $pt['src']=$value;
        $duoi = $check->duoi_file($value);
        if(in_array($duoi, array('mp4','wmv','mov'))==true){
            $list_anh.=$skin->skin_replace('skin_cpanel/box_action/li_photo_video',$pt);
        }else{
            $list_anh.=$skin->skin_replace('skin_cpanel/box_action/li_photo',$pt);
        }
    }
}
$r_tt['list_photo']=$list_anh;
$thaythe['box_right']=$skin->skin_replace('skin_ncc/box_action/edit_share_sanpham',$r_tt);
?>