<?php
if(in_array('thongbao', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
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
$thaythe['title']='Sửa thông báo';
$thaythe['title_action']='Sửa thông báo';
$id=preg_replace('/[^0-9]/', '', $url_query['id']);
$thongtin=mysqli_query($conn,"SELECT *, count(*) AS total FROM thongbao WHERE id='$id'");
$r_tt=mysqli_fetch_assoc($thongtin);
if($r_tt['total']==0){
    $thongbao="Dữ liệu không tồn tại...";
    $replace=array(
        'title'=>'Dữ liệu không tồn tại...',
        'description'=>$index_setting['description'],
        'thongbao'=>$thongbao,
        'link_chuyen'=>'/admincp/list-thongbao'
    );
    echo $skin->skin_replace('skin_cpanel/chuyenhuong',$replace);
    exit();
}
$tach_noidang=explode(',', $r_tt['noi_dang']);
if(in_array('all', $tach_noidang)==true){
    $noidang_all='<div class="li_input" id="noiban_all"><input type="checkbox" name="noi_dang[]" checked value="all"> Tất cả</div>';
}else{
    $noidang_all='<div class="li_input" id="noiban_all"><input type="checkbox" name="noi_dang[]" value="all"> Tất cả</div>';
}
if(in_array('drop', $tach_noidang)==true){
    $noidang_drop='<div class="li_input" id="noidang_drop"><input type="checkbox" name="noi_dang[]" checked value="drop"> Drop</div>';
}else{
    $noidang_drop='<div class="li_input" id="noidang_drop"><input type="checkbox" name="noi_dang[]" value="drop"> Drop</div>';
}
if(in_array('ctv', $tach_noidang)==true){
    $noidang_ctv='<div class="li_input" id="noidang_ctv"><input type="checkbox" name="noi_dang[]" checked value="ctv"> Cộng tác viên</div>';
}else{
    $noidang_ctv='<div class="li_input" id="noidang_ctv"><input type="checkbox" name="noi_dang[]" value="ctv"> Cộng tác viên</div>';
}
$r_tt['noi_dang']=$noidang_all.''.$noidang_drop.''.$noidang_ctv;
$r_tt['date_post']=date('H:i:s d/m/Y',$r_tt['date_post']);
$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/edit_thongbao',$r_tt);
?>