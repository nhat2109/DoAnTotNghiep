<?php
error_reporting(0);
$web=$_SERVER['HTTP_HOST'];
$web=str_replace('www.', '', $web);
$web_root=array('doantotnghiep.vn','socdo.vn','socmoi.vn','soc.vn','beta.socdo.vn');
$param_url = parse_url($_SERVER['REQUEST_URI']);
parse_str($param_url['query'], $url_query);
$page=addslashes($url_query['page']);
$page=intval($page);
if($page>1){
	$page=$page;
	$title_page=' - Page '.$page;
}else{
	$page=1;
	$title_page='';
}

$sort=addslashes($url_query['sort']);
$affgroup=intval($url_query['affgroup']);
if($affgroup>0){
	if(isset($_COOKIE['affgroup'])){
		setcookie("affgroup",$_COOKIE['affgroup'],time() - 3600,'/');
		setcookie("affgroup",$affgroup,time() + 1296000,'/');
	}else{
		setcookie("affgroup",$affgroup,time() + 1296000,'/');
	}
}
if(in_array($web, $web_root)==false){
	include('./shop/dangky.php');
	exit();
}
include('./includes/tlca_world.php');
$check=$tlca_do->load('class_check');
$class_index=$tlca_do->load('class_index');

$setting=mysqli_query($conn,"SELECT * FROM index_setting ORDER BY name ASC");
while ($r_s=mysqli_fetch_assoc($setting)) {
	$index_setting[$r_s['name']]=$r_s['value'];
}
$limit = 48;

if (isset($_COOKIE['user_id'])) {
  
	$form_display ='none'; 
	$box_display = 'block'; 
	$box_header=$skin->skin_normal('skin/box_header_login');
	$mobile_menu=$skin->skin_normal('skin/mobile_menu_login');

}else{
	$form_display ='block'; 
	$box_display = 'none'; 
	$box_header = $skin->skin_normal('skin/box_header');
	$mobile_menu = $skin->skin_normal('skin/mobile_menu');
}



// if (isset($_COOKIE['user_id'])) {
//     // $thongbao = "Hệ thống đang chuyển hướng.";
//     // $replace = array(
//     //     'title' => 'Hệ thống đang chuyển hướng',
//     //     'thongbao' => $thongbao,
//     //     'link' => '/ncc/login'
//     // );
//     echo $skin->skin_replace('skin/chuyenhuong', $replace);
//     exit();
// } else {
//     $box_header = $skin->skin_normal('skin/box_header');
//     $mobile_menu = $skin->skin_normal('skin/mobile_menu');
// }


$list_danhmuc_top=json_decode($class_index->list_category_danhmuc_top($conn),true);
$tach_menu=json_decode($class_index->list_menu($conn),true);
$tach_banner=json_decode($class_index->list_banner($conn),true);
$tach_list_category=json_decode($class_index->list_category($conn),true);
$link_xem=(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$replace=array(
	
	'header'=>$skin->skin_normal('skin/header'),
	'box_header'=>$box_header,
	'footer'=>$skin->skin_normal('skin/footer'),
	'script_footer'=>$skin->skin_normal('skin/script_footer'),
	'mobile_menu'=>$mobile_menu,
	'title'=>'Đăng ký nhà cung cấp',
	'description'=>$index_setting['description'],
	'site_name'=>$index_setting['site_name'],
	'limit'=>$limit,
	'logo'=>$index_setting['logo'],
	'text_footer'=>$index_setting['text_footer'],
	'text_contact_footer'=>$index_setting['text_contact_footer'],
	'text_about'=>$index_setting['text_about'],
	'link_xem'=>$link_xem,
	'list_danhmuc' => $list_danhmuc_top['list_parent'],
	'list_danhmuc_sub' => $list_danhmuc_top['list_sub'],
	'link_facebook'=>$index_setting['link_facebook'],
	'link_youtube'=>$index_setting['link_youtube'],
	'link_twitter'=>$index_setting['link_twitter'],
	'link_instagram'=>$index_setting['link_instagram'],
	'text_hotline'=>$index_setting['text_hotline'],
	'hotline'=>$index_setting['hotline'],
	'hotline_number'=>preg_replace('/[^0-9]/', '', $index_setting['hotline']),
	'menu_chinhsach'=>$tach_menu['chinhsach'],
	'menu_huongdan'=>$tach_menu['huongdan'],
	'menu_left'=>$tach_menu['left'],
	'list_category'=>$tach_list_category['list'],
	'list_category_top'=>$tach_list_category['list_top'],
	'list_category_mobile'=>$tach_list_category['list_mobile'],
	'option_tinh'=>$class_index->list_option_tinh($conn, $id),
	'photo'=>$index_setting['photo'],
	'phantrang'=>$phantrang,
	'fanpage'=>$index_setting['fanpage'],
	'name'=>$user_info['name'],
	'avatar'=>$user_info['avatar'],
	'banner_top'=>$tach_banner['top'],
	'lienhe'=>$index_setting['lienhe'],
	'email'=>addslashes($url_query['email']),
	'list_danhmuc_noibat_timkiem'=>$class_index->list_category_noibat_timkiem($conn), // chức năng tìm kiếm nâng cao
	'ctv'=>$user_info['ctv'],
	'error'=>$error ?? '',
	// 'show_options' => $show_options ? 'block' : 'none', // Truyền biến để điều khiển hiển thị box
	'form_display' => $form_display, // Truyền giá trị display cho form
    'box_display' => $box_display,   // Truyền giá trị display cho box
	);
echo $skin->skin_replace('skin/dangky_ncc',$replace);
?>