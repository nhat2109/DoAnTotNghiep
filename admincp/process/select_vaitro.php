<?php 
if (!isset($_COOKIE['emin_id'])) {
    $ok = 0;
    $thongbao = 'Bạn chưa đăng nhập';
} else {
    if(in_array('nhom', explode(',', $user_info['emin_group']))==false AND $user_info['emin_group']!=1){
        echo json_encode(array('ok'=>0,'thongbao'=>'Bạn không có quyền thực hiện hành động này'.$user_info['emin_group']));
        exit();
    }
    $user_id=intval($_REQUEST['user_id']);
    $vaitro=intval($_REQUEST['vaitro']);
    $nhom=intval($_REQUEST['nhom']);
    $thongtin=mysqli_query($conn,"SELECT * FROM nhom WHERE id='$nhom'");
    $r_tt=mysqli_fetch_assoc($thongtin);
    $thongbao = 'Lưu thay đổi thành công';
    $ok = 1;
    if($vaitro==1){
        mysqli_query($conn, "UPDATE nhom SET nhomtruong='$user_id' WHERE id='$nhom'");
    }else{
        if($r_tt['nhomtruong']==$user_id){
            mysqli_query($conn, "UPDATE nhom SET nhomtruong='' WHERE id='$nhom'");
        }
    }
}
$info = array(
    'ok' => $ok,
    'thongbao' => $thongbao,
);
echo json_encode($info);?>