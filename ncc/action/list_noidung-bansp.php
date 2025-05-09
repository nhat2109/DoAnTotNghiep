<?php
$thaythe['title']='Nội dung bán hàng';
$thaythe['title_action']='Nội dung bán hàng';
$limit=25;
$user_id = (int)$user_id;
$id=preg_replace('/[^0-9]/', '', $url_query['id']);
$thongtin=mysqli_query($conn,"SELECT * FROM sanpham_shop WHERE id='$id'");
$r_tt=mysqli_fetch_assoc($thongtin);
$thongke=mysqli_query($conn,"SELECT count(*) AS total FROM list_share_sanpham WHERE sp_id='$id' AND shop_id='$user_id'");
$r_tk=mysqli_fetch_assoc($thongke);
$total_page=ceil($r_tk['total']/$limit);
$bien=array(
    'tieu_de'=>$r_tt['tieu_de'],
    'id'=>$id,
    'list_noidung'=>$class_index->list_noidung_ban_sanpham($conn,$id,$user_id,$page,$limit),
    'phantrang'=>$class_index->phantrang_timkiem($page,$total_page,'/ncc/list-noidung-bansp?id='.$id)
);
$thaythe['box_right']=$skin->skin_replace('skin_ncc/box_action/list_noidung_bansp',$bien);
// var_dump($bien['list_noidung']);
// die();
?>