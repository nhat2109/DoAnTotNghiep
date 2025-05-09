<?php

if(in_array('sanpham', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
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
$thaythe['title']='Chỉnh sửa sản phẩm';
$thaythe['title_action']='Chỉnh sửa sản phẩm';
$id=preg_replace('/[^0-9]/', '', $url_query['id']);
$thongtin=mysqli_query($conn,"SELECT *, count(*) AS total FROM sanpham WHERE id='$id'");
$r_tt=mysqli_fetch_assoc($thongtin);
if($r_tt['total']==0){
    $thongbao="Sản phẩm không tồn tại...";
    $replace=array(
        'title'=>'Sản phẩm không tồn tại...',
        'description'=>$index_setting['description'],
        'thongbao'=>$thongbao,
        'link_chuyen'=>'/admincp/list-sanpham'
    );
    echo $skin->skin_replace('skin_cpanel/chuyenhuong',$replace);
    exit();
}
if(strlen($r_tt['anh'])>3){
    $tach_anh=explode(",", $r_tt['anh']);
    foreach ($tach_anh as $key => $value) {
        $pt['src']=$value;
        $list_anh.=$skin->skin_replace('skin_cpanel/box_action/li_photo',$pt);
    }
}
$r_tt['list_photo']=$list_anh;
$tach_main_category=json_decode($class_index->list_div_main_category_sanpham($conn,$r_tt['cat']),true);
$tach_sub_category=json_decode($class_index->list_div_sub_category_sanpham($conn,$tach_main_category['list_id'],$r_tt['cat']),true);
$tach_sub_sub_category=json_decode($class_index->list_div_sub_sub_category_sanpham($conn,$tach_sub_category['list_id'],$r_tt['cat']),true);
$r_tt['option_main_category']=$tach_main_category['list'];
$r_tt['option_sub_category']=$tach_sub_category['list'];
$r_tt['option_sub_sub_category']=$tach_sub_sub_category['list'];
$r_tt['option_brand']=$class_index->list_option_brand($conn,$r_tt['thuong_hieu']);
$r_tt['list_phanloai']=$class_index->list_phanloai($conn,$r_tt['id']);
if(strlen($r_tt['thongtin'])>2){
    $tach_info=explode('|', $r_tt['thongtin']);
    foreach ($tach_info as $key => $value) {
        $tach_value=explode('&&', $value);
        $list_info.=$skin->skin_replace('skin_cpanel/box_action/li_info',$tach_value);
    }
    $r_tt['list_info']=$list_info;
}else{
    $r_tt['list_info']='';
}
if($r_tt['ma_sanpham']!=''){
    if(strpos($r_tt['ma_sanpham'], '|')!==false){
        $tach_ma_sanpham=explode('|', $r_tt['ma_sanpham']);
        foreach ($tach_ma_sanpham as $key => $value) {
            $tach_value=explode('&&', $value);
            $list_ma.=$skin->skin_replace('skin_cpanel/box_action/li_ma_sanpham',$tach_value);
        }
    }else{
        $tach_ma_sanpham=explode('&&', $r_tt['ma_sanpham']);
        $list_ma.=$skin->skin_replace('skin_cpanel/box_action/li_ma_sanpham',$tach_ma_sanpham);
    }
    $r_tt['list_ma']=$list_ma;
}else{
    $r_tt['list_ma']='';
}
$tach_noiban=explode(',', $r_tt['noi_ban']);
if(in_array('all', $tach_noiban)==true){
    $noiban_all='<div class="li_input" id="noiban_all"><input type="checkbox" name="noiban[]" checked value="all"> Tất cả</div>';
}else{
    $noiban_all='<div class="li_input" id="noiban_all"><input type="checkbox" name="noiban[]" value="all"> Tất cả</div>';
}
if(in_array('socdo', $tach_noiban)==true){
    $noiban_socdo='<div class="li_input" id="noiban_socdo"><input type="checkbox" name="noiban[]" checked value="socdo"> Socdo.vn</div>';
}else{
    $noiban_socdo='<div class="li_input" id="noiban_socdo"><input type="checkbox" name="noiban[]" value="socdo"> Socdo.vn</div>';
}
if(in_array('drop', $tach_noiban)==true){
    $noiban_drop='<div class="li_input" id="noiban_drop"><input type="checkbox" name="noiban[]" checked value="drop"> Drop</div>';
}else{
    $noiban_drop='<div class="li_input" id="noiban_drop"><input type="checkbox" name="noiban[]" value="drop"> Drop</div>';
}
if(in_array('ctv', $tach_noiban)==true){
    $noiban_ctv='<div class="li_input" id="noiban_ctv"><input type="checkbox" name="noiban[]" checked value="ctv"> Cộng tác viên</div>';
}else{
    $noiban_ctv='<div class="li_input" id="noiban_ctv"><input type="checkbox" name="noiban[]" value="ctv"> Cộng tác viên</div>';
}
$r_tt['noi_ban']=$noiban_all.''.$noiban_socdo.''.$noiban_drop.''.$noiban_ctv;
$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/edit_sanpham',$r_tt);
?>