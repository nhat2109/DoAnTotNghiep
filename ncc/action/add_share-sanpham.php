<?php
$thaythe['title']='Thêm nội dung bán hàng';
$thaythe['title_action']='Thêm nội dung bán hàng';
$id=preg_replace('/[^0-9]/', '', $url_query['id']);
$thongtin=mysqli_query($conn,"SELECT *, count(*) AS total FROM sanpham_shop WHERE id='$id'");
$r_tt=mysqli_fetch_assoc($thongtin);
if($r_tt['total']==0){
    $thongbao="Sản phẩm không tồn tại...";
    $replace=array(
        'title'=>'Sản phẩm không tồn tại...',
        'description'=>$index_setting['description'],
        'thongbao'=>$thongbao,
        'link_chuyen'=>'/ncc/list-sanpham'
    );
    echo $skin->skin_replace('skin_ncc/chuyenhuong',$replace);
    exit();
}
$thaythe['box_right']=$skin->skin_replace('skin_ncc/box_action/add_noidung_bansp',$r_tt);
?> 