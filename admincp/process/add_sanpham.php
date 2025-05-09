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
    $list_phanloai=$_REQUEST['phan_loai'];
    $tach_phanloai=json_decode('['.$list_phanloai.']',true);
    $box_noibat=intval($_REQUEST['box_noibat']);
    $cat_ma=intval($_REQUEST['cat_ma']);
    $box_banchay=intval($_REQUEST['box_banchay']);
    $box_flash=intval($_REQUEST['box_flash']);
    $anh = addslashes(strip_tags($_REQUEST['anh']));
    $link = addslashes(strip_tags($_REQUEST['link']));
    $category = addslashes(strip_tags($_REQUEST['category']));
    $noiban = addslashes(strip_tags($_REQUEST['noiban']));
    $thuong_hieu = addslashes(strip_tags($_REQUEST['thuong_hieu']));
    $info = addslashes(strip_tags($_REQUEST['info']));
    $info=substr($info, 0,-1);
    $noibat = addslashes($_REQUEST['noibat']);
    $noidung = addslashes($_REQUEST['noidung']);
    $title = addslashes(strip_tags($_REQUEST['title']));
    $description = addslashes(strip_tags($_REQUEST['description']));
    $duoi = $check->duoi_file($_FILES['file']['name']);
    if($tieu_de==''){
        $ok=0;
        $thongbao='Thất bại! Chưa nhập tên sản phẩm';
    }else if(in_array($duoi, array('jpg', 'jpeg', 'png', 'gif','webp')) == false){
        $ok=0;
        $thongbao='Thất bại! Chưa chọn hình minh họa';
    }else if($list_phanloai==''){
        $ok=0;
        $thongbao='Thất bại! Không có phân loại sản phẩm';
    }else{
        $thongtin = mysqli_query($conn, "SELECT *, count(*) AS total FROM seo WHERE link='$link' AND loai='sanpham'");
        $r_tt = mysqli_fetch_assoc($thongtin);
        $noti=0;
        if ($r_tt['total'] == 0) {
            $minh_hoa = '/uploads/minh-hoa/' . $check->blank($tieu_de) . '-' . time() . '.' . $duoi;
            move_uploaded_file($_FILES['file']['tmp_name'], '..' . $minh_hoa);
            $thongbao = 'Thêm sản phẩm thành công';
            $ok = 1;
            $gia_cu = (int)preg_replace('/[^0-9]/', '', $tach_phanloai[0]['gia_cu']);
            $gia_moi = (int)preg_replace('/[^0-9]/', '', $tach_phanloai[0]['gia_moi']);
            $gia_drop = (int)preg_replace('/[^0-9]/', '', $tach_phanloai[0]['gia_drop']);
            $drop_min = (int)preg_replace('/[^0-9]/', '', $tach_phanloai[0]['drop_min']);
            $gia_ctv = (int)preg_replace('/[^0-9]/', '', $tach_phanloai[0]['gia_ctv']);
            $ma_sp=addslashes($tach_phanloai[0]['ma_sp']);
            $can_nang=(int)preg_replace('/[^0-9]/', '', $tach_phanloai[0]['can_nang']);
            $color=intval($tach_phanloai[0]['color']);
            $size=intval($tach_phanloai[0]['size']);
            mysqli_query($conn, "INSERT INTO sanpham(ma_sanpham,tieu_de,minh_hoa,link,cat,gia_cu,gia_moi,gia_drop,drop_min,gia_ctv,ctv_min,noi_ban,noi_bat,noi_dung,mau,thuong_hieu,size,thongtin,can_nang,anh,sale,kho,kho_hcm,box_flash,box_banchay,box_noibat,ban,title,description,view,cat_ma,date_post)VALUES('$ma_sp','$tieu_de','$minh_hoa','$link','$category','$gia_cu','$gia_moi','$gia_drop','$drop_min','$gia_ctv','$drop_min','$noiban','$noibat','$noidung','$color','$thuong_hieu','$size','$info','$can_nang','$anh','0','$kho','$kho_hcm','$box_flash','$box_banchay','$box_noibat','0','$title','$description','0','0',".time().")");
            $thongtin_sp=mysqli_query($conn,"SELECT * FROM sanpham ORDER BY id DESC LIMIT 1");
            $r_sp=mysqli_fetch_assoc($thongtin_sp);
            $sp_id=$r_sp['id'];
            $user_id=$user_info['id'];
            foreach ($tach_phanloai as $key => $value) {
                $gia_cu = (int)preg_replace('/[^0-9]/', '', $value['gia_cu']);
                $gia_moi = (int)preg_replace('/[^0-9]/', '', $value['gia_moi']);
                $gia_drop = (int)preg_replace('/[^0-9]/', '', $value['gia_drop']);
                $gia_ctv = (int)preg_replace('/[^0-9]/', '', $value['gia_ctv']);
                $drop_min = (int)preg_replace('/[^0-9]/', '', $value['drop_min']);
                $ma_sp=addslashes($value['ma_sp']);
                $can_nang=(int)preg_replace('/[^0-9]/', '', $value['can_nang']);
                $color=$value['color'];
                $size=$value['size'];
                $ten_color=addslashes($value['ten_color']);
                $ma_mau=addslashes($value['ma_mau']);
                $ten_size=addslashes($value['ten_size']);
                mysqli_query($conn,"INSERT INTO phanloai_sanpham(user_id,sp_id,ma_sp,color,size,ten_color,ma_mau,ten_size,can_nang,gia_cu,gia_moi,gia_drop,gia_ctv,drop_min,date_post)VALUES('$user_id','$sp_id','$ma_sp','$color','$size','$ten_color','$ma_mau','$ten_size','$can_nang','$gia_cu','$gia_moi','$gia_drop','$gia_ctv','$drop_min','$hientai')");
            }
            mysqli_query($conn, "INSERT INTO seo (loai,link)VALUES('sanpham','$link')");
            $noti=1;
            $noidung_notification='Sản phẩm mới: '.$tieu_de;
            mysqli_query($conn, "INSERT INTO notification(user_id,sp_id,noi_dung,doc,bo_phan,admin,date_post)VALUES('{$user_info['id']}','0','$noidung_notification','','san_pham','0'," . time() . ")");
        } else {
            $ok = 0;
            $thongbao = "Link xem đã tồn tại";
        }
    }

}
$info = array(
    'ok' => $ok,
    'noti'=>$noti,
    'thongbao' => $thongbao,
);
echo json_encode($info);
?>