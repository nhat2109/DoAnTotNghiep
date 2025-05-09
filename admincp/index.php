<?php
include('../includes/tlca_world.php');
$check=$tlca_do->load('class_check');
$class_index=$tlca_do->load('class_cpanel');
$param_url = parse_url($_SERVER['REQUEST_URI']);
parse_str($param_url['query'], $url_query);
$page=addslashes($url_query['page']);
$skin=$tlca_do->load('class_skin_cpanel');
if(intval($page)<1){
	$page=1;
}else{
	$page=intval($page);
}

if(isset($_REQUEST['action'])){
	$action=addslashes($_REQUEST['action']);
}else{
	$action='dashboard';
}
if(!isset($_COOKIE['emin_id'])){
	$thongbao="Bạn chưa đăng nhập.<br>Đang chuyển hướng tới trang đăng nhập...";
	$replace=array(
		'title'=>'Bạn chưa đăng nhập...',
		'description'=>$index_setting['description'],
		'thongbao'=>$thongbao,
		'link_chuyen'=>'/admincp/login'
	);
	echo $skin->skin_replace('skin_cpanel/chuyenhuong',$replace);
	exit();
}
$class_e_member=$tlca_do->load('class_e_member');
$user_info=$class_e_member->user_info($conn,$_COOKIE['emin_id']);
$user_id=$user_info['id'];
if ($user_info['role'] == 'all') {
		
	$link = '<a href="/admincp/adanhsachnhansu"
><i class="fa fa-plus-circle"></i>Quản lý nhân sự</a
>';

}elseif($user_info['bo_phan'] == 'truong_phong'){
$link = '<a href="/admincp/congviec_cuanhansu"
><i class="fa fa-plus-circle"></i>Công việc</a
>';
}elseif($user_info['role'] == 'nhan_vien'){
$link = '<a href="/admincp/congviec_cuanhansu"
><i class="fa fa-plus-circle"></i>Công việc</a
>';
}
if(intval($user_id)<1){
	$thongbao="Thông tin không hợp lệ...";
	$replace=array(
		'title'=>'Bạn chưa đăng nhập...',
		'description'=>$index_setting['description'],
		'thongbao'=>$thongbao,
		'link_chuyen'=>'/admincp/logout'
	);
	echo $skin->skin_replace('skin_cpanel/chuyenhuong',$replace);
	exit();	
}
$tach_name=explode(' ', $user_info['name']);
$name=$tach_name[count($tach_name) -1];
$setting=mysqli_query($conn,"SELECT * FROM index_setting ORDER BY name ASC");
while ($r_s=mysqli_fetch_assoc($setting)) {
	$index_setting[$r_s['name']]=$r_s['value'];
}

$thongtin_sodu=mysqli_query($conn,"SELECT SUM(user_money) AS total_sodu, SUM(user_money2) AS total_km FROM user_info");
$r_sd=mysqli_fetch_assoc($thongtin_sodu);
$gioihan_donhang=time() - 15*3600*24;
$gioihan_donhang_drop=time() - 3*3600*24;
mysqli_query($conn,"UPDATE donhang SET status='2' WHERE status='1' AND date_update<'$gioihan_donhang_drop'");
mysqli_query($conn,"UPDATE donhang SET status='5' WHERE status='2' AND date_update<'$gioihan_donhang'");
mysqli_query($conn,"UPDATE donhang_ctv SET status='5' WHERE status='2' AND date_update<'$gioihan_donhang'");
$time_xacnhan=time() - 15*60;
$thongtin_naptien=mysqli_query($conn,"UPDATE naptien SET status='2' WHERE status='0' AND date_post<'$time_xacnhan'");

$thaythe=array(
	'header'=>$skin->skin_normal('skin_cpanel/header'),
	'box_menu'=>$skin->skin_normal('skin_cpanel/box_menu'),
	'footer'=>$skin->skin_normal('skin_cpanel/footer'),
	'box_script_footer'=>$skin->skin_normal('skin_cpanel/box_script_footer'),
	'description'=>$index_setting['description'],
	'site_name'=>$index_setting['site_name'],
	// 'phantrang'=>$class_index->phantrang($page,$total_page,'/'),
	'phantrang'=>'',
	'link'=>$link,
	'fullname'=>$user_info['name'],
	'email'=>$user_info['email'],
	'point'=>$user_info['user_money'],
	'bo_phan'=>$user_info['bo_phan'],
	'thanhvien_chat'=>$user_info['id'],
	'name'=>$name,
	'avatar'=>$user_info['avatar'],
	'total_sodu'=>number_format($r_sd['total_sodu']),
	'total_km'=>number_format($r_sd['total_km'])
);

$file_action='action/'.$action.'.php';
if(file_exists($file_action)){
	include($file_action);
}else{
	$thongbao = "Dữ liệu không tồn tại...";
	$replace = array(
		'title' => 'Thiết lập giao diện...',
		'description' => $index_setting['description'],
		'thongbao' => $thongbao,
		'link_chuyen' => '/admincp/',
	);
	echo $skin->skin_replace('skin_dropship/chuyenhuong', $replace);
	exit();
}
echo $skin->skin_replace('skin_cpanel/index',$thaythe);
?>