<?php
    if(in_array('quantri', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
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
    $thaythe['title']='Chỉnh sửa quản trị';
    $thaythe['title_action']='Chỉnh sửa quản trị';
    $id=preg_replace('/[^0-9]/', '', $url_query['id']);
    $thongtin=mysqli_query($conn,"SELECT *, count(*) AS total FROM emin_info WHERE id='$id'");
    $r_tt=mysqli_fetch_assoc($thongtin);
    if($r_tt['total']==0){
        $thongbao="Quản trị viên không tồn tại...";
        $replace=array(
            'title'=>'Quản trị viên không tồn tại...',
            'description'=>$index_setting['description'],
            'thongbao'=>$thongbao,
            'link_chuyen'=>'/admincp/list-quantri'
        );
        echo $skin->skin_replace('skin_cpanel/chuyenhuong',$replace);
        exit();
    }
    if(strpos($r_tt['emin_group'], ',')!==false){
        $tach_group=explode(',', $r_tt['emin_group']);
        foreach ($tach_group as $key => $value) {
            $list_group.='$("#input_'.$value.' input").prop(\'checked\', true);';
        }
    }else if(strlen($r_tt['emin_group'])==1){
        $list_group.='$("input[type=checkbox]").prop(\'checked\', true);';
    }else if($r_tt['emin_group']!=''){
        $list_group.='$("#input_'.$r_tt['emin_group'].' input").prop(\'checked\', true);';
    }else{
        $list_group='';
    }
    $r_tt['list_group']=$list_group;
    $thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/edit_quantri',$r_tt);
?>