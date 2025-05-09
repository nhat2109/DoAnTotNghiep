<?php
error_reporting(0);
$web=$_SERVER['HTTP_HOST'];
$web=str_replace('www.', '', $web);
$web_root=array('doantotnghiep.vn','socdo.vn','socmoi.vn','soc.vn','beta.socdo.vn','beta.vn');
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
if (!isset($_COOKIE['user_id'])) {
    $thongbao = "Hệ thống đang chuyển hướng.";
    $replace = array(
        'title' => 'Hệ thống đang chuyển hướng',
        'thongbao' => $thongbao,
        'link_chuyen' => '/dangky-ncc.html'
    );
    echo $skin->skin_replace('skin_shop/giaoviec/tpl/chuyenhuong', $replace);
    exit();
}
$hientai=time();
$box_header = $skin->skin_normal('skin/box_header_login');
$mobile_menu = $skin->skin_normal('skin/mobile_menu_login');
$class_member = $tlca_do->load('class_member');
$tach_token = json_decode($check->token_login_decode($_COOKIE['user_id']), true);
$user_id = $tach_token['user_id'];
$user_info = $class_member->user_info($conn, $_COOKIE['user_id']);
if ($user_info['total'] == 0) {
	$thongbao = "Thông tin không hợp lệ.";
	$replace = array(
		'title' => 'Thông tin không hợp lệ.',
		'thongbao' => $thongbao,
		'link_chuyen' => '/dang-xuat.html'
	);
	echo $skin->skin_replace('skin_shop/giaoviec/tpl/chuyenhuong', $replace);
	exit();
}
if($user_info['ctv']!=1){
	$thongbao = "Tài khoản không được phép truy cập.";
	$replace = array(
		'title' => 'Tài khoản không được phép truy cập.',
		'thongbao' => $thongbao,
		'link_chuyen' => '/'
	);
	echo $skin->skin_replace('skin_shop/giaoviec/tpl/chuyenhuong', $replace);
	exit();
}
$thongtin_giaoviec_user=mysqli_query($conn,"SELECT * FROM emin_giaoviec_info WHERE location_giaoviec='$user_id'");
$total_giaoviec_user=mysqli_num_rows($thongtin_giaoviec_user);
if($total_giaoviec_user==0){
	mysqli_query($conn,"INSERT INTO emin_giaoviec_info (username,password,email,name,avatar,mobile,address,bo_phan,emin_group,logined,created,id_phongban,role,chuc_vu,sep,location_giaoviec,so_cccd,ngay_cap_cccd,noi_cap_cccd,so_hopdong,han_hopdong,loai_hinh_hd,role_admin) VALUES ('{$user_info['username']}','{$user_info['password']}','{$user_info['email']}','{$user_info['name']}','{$user_info['avatar']}','{$user_info['mobile']}','{$user_info['dia_chi']}','all','1','$hientai','$hientai','0','all','Admin','sep','$user_id','$so_cccd','$ngay_cap_cccd','$noi_cap_cccd','$so_hopdong','$han_hopdong','chinh_thuc','1')");
}
$token=$_COOKIE['user_id'];
mysqli_query($conn,"INSERT INTO user_token (token,user_id,date_post) VALUES ('$token','$user_id','$hientai')");
$thongtin_setup=mysqli_query($conn,"SELECT * FROM domain_giaoviec WHERE user_id='$user_id'");
$total_setup=mysqli_num_rows($thongtin_setup);
if($total_setup>0){
	$r_setup=mysqli_fetch_assoc($thongtin_setup);
	$domain=$r_setup['domain'];
	$thongbao = "Hệ thống đang chuyển hướng.";
	$replace = array(
		'title' => 'Hệ thống đang chuyển hướng.',
		'thongbao' => $thongbao,
		'link_chuyen' => 'https://'.$domain.'/?token='.$token
	);
	echo $skin->skin_replace('skin_shop/giaoviec/tpl/chuyenhuong', $replace);
	exit();
}
// nhatthem
$list_danhmuc_top = json_decode($class_index->list_category_danhmuc_top($conn), true);

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
	'title'=>'Thiết lập tên miền',
	'description'=>$index_setting['description'],
	'site_name'=>$index_setting['site_name'],
	'limit'=>$limit,
	// nhatthem
	'list_danhmuc' => $list_danhmuc_top['list_parent'],
	'list_danhmuc_sub' => $list_danhmuc_top['list_sub'],

	'logo'=>$index_setting['logo'],
	'text_footer'=>$index_setting['text_footer'],
	'text_contact_footer'=>$index_setting['text_contact_footer'],
	'text_about'=>$index_setting['text_about'],
	'link_xem'=>$link_xem,
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
	);
echo $skin->skin_replace('skin/setup_domain',$replace);
?>