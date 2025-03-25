<?php
// Check if the user_id cookie is set before attempting to use it  
if (isset($_COOKIE['user_id'])) {  
    // Xóa cookie bằng cách đặt thời gian hết hạn trong quá khứ  
    setcookie("user_id", '', time() - 3600, '/');  
}  

include('./includes/tlca_world.php');  
$check=$tlca_do->load('class_check');  
$class_index=$tlca_do->load('class_shop');  
$thongbao="Đăng xuất thành công.";  
$replace=array(  
    'title'=>'Đăng xuất thành công',  
    'thongbao'=>$thongbao,  
    'link'=>'/'  
);  
echo $skin->skin_replace('skin_shop/skin_1/chuyenhuong',$replace);
?>
