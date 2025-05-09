<?php
if(in_array('motcham', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
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
$thaythe['title']='Nội dung bán hàng';
$thaythe['title_action']='Nội dung bán hàng';
$limit=25;
$id=preg_replace('/[^0-9]/', '', $url_query['id']);
$thongtin=mysqli_query($conn,"SELECT * FROM sanpham WHERE id='$id'");
$r_tt=mysqli_fetch_assoc($thongtin);
$thongke=mysqli_query($conn,"SELECT count(*) AS total FROM list_share_sanpham WHERE sp_id='$id'");
$r_tk=mysqli_fetch_assoc($thongke);
$total_page=ceil($r_tk['total']/$limit);
$bien=array(
    'tieu_de'=>$r_tt['tieu_de'],
    'id'=>$id,
    'list_noidung'=>$class_index->list_share_sanpham($conn,$id,$page,$limit),
    'phantrang'=>$class_index->phantrang_timkiem($page,$total_page,'/admincp/list-share-sahsanpham?id='.$id)
);
$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/list_share_sanpham',$bien);
?>