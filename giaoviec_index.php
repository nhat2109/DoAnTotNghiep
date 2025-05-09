<?php
$web = $_SERVER['HTTP_HOST'];
$web = str_replace('www.', '', $web);
$web_root = array('doantotnghiep.vn', 'socdo.vn', 'socmoi.vn', 'soc.vn', 'beta.socdo.vn');
if (in_array($web, $web_root) == false) {
	include('./shop/giaoviec_index.php');
}else{
    include('./includes/tlca_world.php');
    $check=$tlca_do->load('class_check');
    $class_index=$tlca_do->load('class_index');
    $thongbao="Dữ liệu không tồn tại.";
    $replace=array(
        'title'=>'Dữ liệu không tồn tại',
        'thongbao'=>$thongbao,
        'link'=>'/'
    );
    echo $skin->skin_replace('skin/chuyenhuong',$replace);
}
?>