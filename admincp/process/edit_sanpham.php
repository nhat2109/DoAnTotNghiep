<?php

if (!isset($_COOKIE['emin_id'])) {
    $ok = 0;
    $thongbao = 'Bạn chưa đăng nhập';
} else {
    if(in_array('sanpham', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
        echo json_encode(array('ok'=>0,'thongbao'=>'Bạn không có quyền thực hiện hành động này'));
        exit();	
    }
    $tieu_de = addslashes(strip_tags($_REQUEST['tieu_de']));
    $kho = intval(preg_replace('/[^0-9]/', '', $_REQUEST['kho']));
    $kho_hcm = intval(preg_replace('/[^0-9]/', '', $_REQUEST['kho_hcm']));
    $box_noibat=intval($_REQUEST['box_noibat']);
    $cat_ma=intval($_REQUEST['cat_ma']);
    $box_banchay=intval($_REQUEST['box_banchay']);
    $box_flash=intval($_REQUEST['box_flash']);
    $anh = addslashes(strip_tags($_REQUEST['anh']));
    $link = addslashes(strip_tags($_REQUEST['link']));
    $link_old = addslashes(strip_tags($_REQUEST['link_old']));
    $category = addslashes(strip_tags($_REQUEST['category']));
    $noiban = addslashes(strip_tags($_REQUEST['noiban']));
    $thuong_hieu = addslashes(strip_tags($_REQUEST['thuong_hieu']));
    $list_phanloai=$_REQUEST['phan_loai'];
    $tach_phanloai=json_decode('['.$list_phanloai.']',true);
    $info = addslashes(strip_tags($_REQUEST['info']));
    $info=substr($info, 0,-1);
    $noibat = addslashes($_REQUEST['noibat']);
    $noidung = addslashes($_REQUEST['noidung']);
    $title = addslashes(strip_tags($_REQUEST['title']));
    $description = addslashes(strip_tags($_REQUEST['description']));
    $duoi = $check->duoi_file($_FILES['file']['name']);
    $id=intval($_REQUEST['id']);
    $thongtin=mysqli_query($conn,"SELECT *, count(*) AS total FROM sanpham WHERE id='$id'");
    $r_tt=mysqli_fetch_assoc($thongtin);
    $noti=0;
    if($r_tt['total']==0){
        $ok=0;
        $thongbao='Thất bại! Sản phẩm không tồn tại';
    }else if($tieu_de==''){
        $ok=0;
        $thongbao='Thất bại! Chưa nhập tên sản phẩm';
    }else if($list_phanloai==''){
        $ok=0;
        $thongbao='Thất bại! Không có phân loại sản phẩm';
    }else{
        $gia_cu = (int)preg_replace('/[^0-9]/', '', $tach_phanloai[0]['gia_cu']);
        $gia_moi = (int)preg_replace('/[^0-9]/', '', $tach_phanloai[0]['gia_moi']);
        $gia_drop = (int)preg_replace('/[^0-9]/', '', $tach_phanloai[0]['gia_drop']);
        $gia_ctv = (int)preg_replace('/[^0-9]/', '', $tach_phanloai[0]['gia_ctv']);
        $drop_min = (int)preg_replace('/[^0-9]/', '', $tach_phanloai[0]['drop_min']);
        $ma_sp=addslashes($tach_phanloai[0]['ma_sp']);
        $can_nang=(int)preg_replace('/[^0-9]/', '', $tach_phanloai[0]['can_nang']);
        $color=intval($tach_phanloai[0]['color']);
        $size=intval($tach_phanloai[0]['size']);
        if($link==$link_old){
            if (in_array($duoi, array('jpg', 'jpeg', 'png', 'gif','webp')) == true) {
                $minh_hoa = '/uploads/minh-hoa/' . $check->blank($tieu_de) . '-' . time() . '.' . $duoi;
                move_uploaded_file($_FILES['file']['tmp_name'], '..' . $minh_hoa);
                @unlink('..'.$r_tt['minh_hoa']);
                mysqli_query($conn, "UPDATE sanpham SET ma_sanpham='$ma_sp',tieu_de='$tieu_de',minh_hoa='$minh_hoa',cat='$category',gia_cu='$gia_cu',gia_moi='$gia_moi',gia_drop='$gia_drop',drop_min='$drop_min',gia_ctv='$gia_ctv',ctv_min='$drop_min',noi_ban='$noiban',noi_bat='$noibat',noi_dung='$noidung',mau='$color',thuong_hieu='$thuong_hieu',size='$size',thongtin='$info',can_nang='$can_nang',anh='$anh',kho='$kho',kho_hcm='$kho_hcm',box_noibat='$box_noibat',cat_ma='$cat_ma',box_flash='$box_flash',box_banchay='$box_banchay',title='$title',description='$description' WHERE id='$id'");
                mysqli_query($conn,"UPDATE sanpham_shop SET minh_hoa='$minh_hoa' WHERE sp_id='$id'");
            } else {
                mysqli_query($conn, "UPDATE sanpham SET ma_sanpham='$ma_sp',tieu_de='$tieu_de',cat='$category',gia_cu='$gia_cu',gia_moi='$gia_moi',gia_drop='$gia_drop',drop_min='$drop_min',gia_ctv='$gia_ctv',ctv_min='$drop_min',noi_ban='$noiban',noi_bat='$noibat',cat_ma='$cat_ma',noi_dung='$noidung',mau='$color',thuong_hieu='$thuong_hieu',size='$size',thongtin='$info',can_nang='$can_nang',anh='$anh',kho='$kho',kho_hcm='$kho_hcm',box_noibat='$box_noibat',box_flash='$box_flash',box_banchay='$box_banchay',title='$title',description='$description' WHERE id='$id'");
            }
            if($kho!=$r_tt['kho'] AND $gia_moi!=$r_tt['gia_moi']){
                $noti=1;
                if($kho==0){
                    $noidung_notification='Thông báo hết hàng: Sản phẩm <b>'.$tieu_de.'</b>';
                }else{
                    $noidung_notification='Thông báo điều chỉnh giá và tồn kho: Sản phẩm <b>'.$tieu_de.'</b>';
                }
                mysqli_query($conn, "INSERT INTO notification(user_id,sp_id,noi_dung,doc,bo_phan,admin,date_post)VALUES('{$user_info['id']}','0','$noidung_notification','','san_pham','0'," . time() . ")");
            }else if($kho!=$r_tt['kho']){
                $noti=1;
                if($kho==0){
                    $noidung_notification='Thông báo hết hàng: Sản phẩm <b>'.$tieu_de.'</b>';
                }else{
                    $noidung_notification='Thông báo cập nhật tồn kho: Sản phẩm <b>'.$tieu_de.'</b>';
                }
                mysqli_query($conn, "INSERT INTO notification(user_id,sp_id,noi_dung,doc,bo_phan,admin,date_post)VALUES('{$user_info['id']}','0','$noidung_notification','','san_pham','0'," . time() . ")");
            }else if($gia_moi!=$r_tt['gia_moi']){
                $noti=1;
                $noidung_notification='Thông báo điều chỉnh giá: Sản phẩm <b>'.$tieu_de.'</b>';
                mysqli_query($conn, "INSERT INTO notification(user_id,sp_id,noi_dung,doc,bo_phan,admin,date_post)VALUES('{$user_info['id']}','0','$noidung_notification','','san_pham','0'," . time() . ")");
            }
            $thongbao = 'Sửa sản phẩm thành công';
            $ok = 1;
        }else{
            $thongtin_seo = mysqli_query($conn, "SELECT *, count(*) AS total FROM seo WHERE link='$link' AND loai='sanpham'");
            $r_seo = mysqli_fetch_assoc($thongtin_seo);
            if ($r_seo['total'] == 0) {
                if (in_array($duoi, array('jpg', 'jpeg', 'png', 'gif','webp')) == true) {
                    $minh_hoa = '/uploads/minh-hoa/' . $check->blank($tieu_de) . '-' . time() . '.' . $duoi;
                    move_uploaded_file($_FILES['file']['tmp_name'], '..' . $minh_hoa);
                    @unlink('..'.$r_tt['minh_hoa']);
                    mysqli_query($conn, "UPDATE sanpham SET ma_sanpham='$ma_sp',tieu_de='$tieu_de',minh_hoa='$minh_hoa',link='$link',cat='$category',gia_cu='$gia_cu',gia_moi='$gia_moi',gia_drop='$gia_drop',drop_min='$drop_min',gia_ctv='$gia_ctv',ctv_min='$drop_min',noi_ban='$noiban',noi_bat='$noibat',cat_ma='$cat_ma',noi_dung='$noidung',mau='$mau',thuong_hieu='$thuong_hieu',size='$size',thongtin='$info',can_nang='$can_nang',anh='$anh',kho='$kho',kho_hcm='$kho_hcm',box_noibat='$box_noibat',box_flash='$box_flash',box_banchay='$box_banchay',title='$title',description='$description' WHERE id='$id'");
                    mysqli_query($conn,"UPDATE sanpham_shop SET minh_hoa='$minh_hoa' WHERE sp_id='$id'");
                } else {
                    mysqli_query($conn, "UPDATE sanpham SET ma_sanpham='$ma_sp',tieu_de='$tieu_de',cat='$category',link='$link',gia_cu='$gia_cu',gia_moi='$gia_moi',gia_drop='$gia_drop',drop_min='$drop_min',gia_ctv='$gia_ctv',ctv_min='$drop_min',noi_ban='$noiban',noi_bat='$noibat',cat_ma='$cat_ma',noi_dung='$noidung',mau='$mau',thuong_hieu='$thuong_hieu',size='$size',thongtin='$info',can_nang='$can_nang',anh='$anh',kho='$kho',kho_hcm='$kho_hcm',box_noibat='$box_noibat',box_flash='$box_flash',box_banchay='$box_banchay',title='$title',description='$description' WHERE id='$id'");
                }
                if($kho!=$r_tt['kho'] AND $gia_moi!=$r_tt['gia_moi']){
                    $noti=1;
                    if($kho==0){
                        $noidung_notification='Thông báo hết hàng: Sản phẩm <b>'.$tieu_de.'</b>';
                    }else{
                        $noidung_notification='Thông báo điều chỉnh giá và tồn kho: Sản phẩm <b>'.$tieu_de.'</b>';
                    }
                    mysqli_query($conn, "INSERT INTO notification(user_id,sp_id,noi_dung,doc,bo_phan,admin,date_post)VALUES('{$user_info['id']}','0','$noidung_notification','','san_pham','0'," . time() . ")");
                }else if($kho!=$r_tt['kho']){
                    $noti=1;
                    if($kho==0){
                        $noidung_notification='Thông báo hết hàng: Sản phẩm <b>'.$tieu_de.'</b>';
                    }else{
                        $noidung_notification='Thông báo cập nhật tồn kho: Sản phẩm <b>'.$tieu_de.'</b>';
                    }
                    mysqli_query($conn, "INSERT INTO notification(user_id,sp_id,noi_dung,doc,bo_phan,admin,date_post)VALUES('{$user_info['id']}','0','$noidung_notification','','san_pham','0'," . time() . ")");
                }else if($gia_moi!=$r_tt['gia_moi']){
                    $noti=1;
                    $noidung_notification='Thông báo điều chỉnh giá: Sản phẩm <b>'.$tieu_de.'</b>';
                    mysqli_query($conn, "INSERT INTO notification(user_id,sp_id,noi_dung,doc,bo_phan,admin,date_post)VALUES('{$user_info['id']}','0','$noidung_notification','','san_pham','0'," . time() . ")");
                }
                mysqli_query($conn, "UPDATE seo SET link='$link' WHERE link='$link_old' AND loai='sanpham'");
                $thongbao = 'Sửa sản phẩm thành công';
                $ok = 1;
            } else {
                $ok = 0;
                $thongbao = "Thất bại! Link xem đã tồn tại";
            }
        }
        $list_id='';
        foreach ($tach_phanloai as $key => $value) {
            $id_pl=intval($value['id']);
            if($id_pl>0){
                $list_id.=$id_pl.',';
            }
        }
        if($list_id==''){
            mysqli_query($conn,"DELETE FROM phanloai_sanpham WHERE sp_id='$id'");
        }else{
            $list_id=substr($list_id, 0,-1);
            mysqli_query($conn,"DELETE FROM phanloai_sanpham WHERE sp_id='$id' AND id NOT IN ($list_id)");
        }
        foreach ($tach_phanloai as $key => $value) {
            $id_pl=intval($value['id']);
            $gia_cu = (int)preg_replace('/[^0-9]/', '', $value['gia_cu']);
            $gia_moi = (int)preg_replace('/[^0-9]/', '', $value['gia_moi']);
            $gia_drop = (int)preg_replace('/[^0-9]/', '', $value['gia_drop']);
            $gia_ctv = (int)preg_replace('/[^0-9]/', '', $value['gia_ctv']);
            $drop_min = (int)preg_replace('/[^0-9]/', '', $value['drop_min']);
            $ma_sp=addslashes($value['ma_sp']);
            $can_nang=(int)preg_replace('/[^0-9]/', '', $value['can_nang']);
            $color=addslashes($value['color']);
            $size=addslashes($value['size']);
            $ten_color=addslashes($value['ten_color']);
            $ma_mau=addslashes($value['ma_mau']);
            $ten_size=addslashes($value['ten_size']);
            if($id_pl>0){
                mysqli_query($conn,"UPDATE phanloai_sanpham SET ma_sp='$ma_sp',ma_mau='$ma_mau',color='$color',size='$size',ten_color='$ten_color',ten_size='$ten_size',can_nang='$can_nang',gia_cu='$gia_cu',gia_moi='$gia_moi',gia_drop='$gia_drop',gia_ctv='$gia_ctv',drop_min='$drop_min' WHERE id='$id_pl'");
            }else{
                $user_id=$user_info['id'];
                mysqli_query($conn,"INSERT INTO phanloai_sanpham(user_id,sp_id,ma_sp,color,size,ten_color,ma_mau,ten_size,can_nang,gia_cu,gia_moi,gia_drop,gia_ctv,drop_min,date_post)VALUES('$user_id','$id','$ma_sp','$color','$size','$ten_color','$ma_mau','$ten_size','$can_nang','$gia_cu','$gia_moi','$gia_drop','$gia_ctv','$drop_min','$hientai')");
            }
        }
    }
}
$info = array(
    'ok' => $ok,
    'noti'=>$noti,
    'thongbao' => $thongbao,
);
echo json_encode($info);?>