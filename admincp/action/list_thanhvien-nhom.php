<?php
if(in_array('nhom', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
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
$thaythe['title']='Danh sách thành viên nhóm';
$thaythe['title_action']='Danh sách thành viên nhóm';
$limit=100;
$id=preg_replace('/[^0-9a-zA-Z_-]/', '', $url_query['id']);
$thongtin=mysqli_query($conn,"SELECT *, count(*) AS total FROM nhom WHERE id='$id'");
$r_tt=mysqli_fetch_assoc($thongtin);
if($r_tt['total']==0){
    $thongbao="Nhóm không tồn tại...";
    $replace=array(
        'title'=>'Nhóm không tồn tại...',
        'description'=>$index_setting['description'],
        'thongbao'=>$thongbao,
        'link_chuyen'=>'/admincp/list-nhom'
    );
    echo $skin->skin_replace('skin_cpanel/chuyenhuong',$replace);
    exit();
}else{

}
$list_id=$r_tt['thanhvien'];
$thongke=mysqli_query($conn,"SELECT count(*) AS total FROM user_info WHERE user_id IN($list_id)");
$r_tk=mysqli_fetch_assoc($thongke);
$total_page=ceil($r_tk['total']/$limit);
$bien=array(
    'tieu_de'=>$r_tt['tieu_de'],
    'id'=>$id,
    'list_thanhvien'=>$class_index->list_thanhvien_nhom($conn,$id,$list_id,$r_tt['nhomtruong'],$page,$limit),
    'phantrang'=>$class_index->phantrang_timkiem($page,$total_page,'/admincp/list-thanhvien-nhom?id='.$id)
);
$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/list_thanhvien_nhom',$bien);
?>