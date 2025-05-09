<?php 
if (!isset($_COOKIE['emin_id'])) {
    $ok = 0;
    $thongbao = 'Bạn chưa đăng nhập';
} else {
    if(in_array('price', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
        echo json_encode(array('ok'=>0,'thongbao'=>'Bạn không có quyền thực hiện hành động này'.$user_info['emin_group']));
        exit();
    }
    $id=intval($_REQUEST['id']);
    $thongbao = 'Sửa khoảng giá thành công';
    $ok = 1;
    $kieu = addslashes(strip_tags($_REQUEST['kieu']));
    $price = preg_replace('/[^0-9]/', '', $_REQUEST['price']);
    $min_price = preg_replace('/[^0-9]/', '', $_REQUEST['min_price']);
    $max_price = preg_replace('/[^0-9]/', '', $_REQUEST['max_price']);
    $thu_tu=intval($_REQUEST['thu_tu']);
    if($kieu=='nho'){
        mysqli_query($conn, "UPDATE khoang_gia SET min_price='0',max_price='$price',kieu='$kieu',thu_tu='$thu_tu' WHERE id='$id'");
    }else if($kieu=='lon'){
        mysqli_query($conn, "UPDATE khoang_gia SET min_price='$price',max_price='0',kieu='$kieu',thu_tu='$thu_tu' WHERE id='$id'");
    }else{
        mysqli_query($conn, "UPDATE khoang_gia SET min_price='$min_price',max_price='$max_price',kieu='$kieu',thu_tu='$thu_tu' WHERE id='$id'");
    }
}
$info = array(
    'ok' => $ok,
    'thongbao' => $thongbao,
);
echo json_encode($info);?>