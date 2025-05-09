<?php
$web=$_SERVER['HTTP_HOST'];
$web=str_replace('www.', '', $web);
$web_root=array('doantotnghiep.vn','socdo.vn','socmoi.vn','soc.vn','beta.socdo.vn');
if(in_array($web, $web_root)==false){
	include('./shop/index.php');
	exit();
}
include('./includes/tlca_world.php');
$check=$tlca_do->load('class_check');
$class_index=$tlca_do->load('class_index');
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
$setting=mysqli_query($conn,"SELECT * FROM index_setting ORDER BY name ASC");
while ($r_s=mysqli_fetch_assoc($setting)) {
	$index_setting[$r_s['name']]=$r_s['value'];
}
$limit=48;
if(isset($_COOKIE['user_id'])){
	$box_header=$skin->skin_normal('skin/box_header_login');
	$mobile_menu=$skin->skin_normal('skin/mobile_menu_login');
	$class_member=$tlca_do->load('class_member');
	$tach_token=json_decode($check->token_login_decode($_COOKIE['user_id']),true);
	$user_id=$tach_token['user_id'];
	$user_info=$class_member->user_info($conn,$_COOKIE['user_id']);
	if($user_info['dropship']>0){
		$box_header=$skin->skin_normal('skin/box_header_dropship_login');
	}else if($user_info['ctv']>0){
		$box_header=$skin->skin_normal('skin/box_header_ctv_login');
	}else{
		$box_header=$skin->skin_normal('skin/box_header_login');
	}
}else{
	$box_header=$skin->skin_normal('skin/box_header');
	$mobile_menu=$skin->skin_normal('skin/mobile_menu');
}
$hientai=time();
$thongtin_deal=mysqli_query($conn,"SELECT * FROM deal WHERE date_end>='$hientai' AND shop='0' AND loai='flash_sale' ORDER BY id DESC");
while($r_d=mysqli_fetch_assoc($thongtin_deal)){
	$list_flashsale_id.=$r_d['main_product'].',';
	$list_check_product[]=json_decode($r_d['sub_product'],true);
}
$list_c=array();
foreach ($list_check_product as $key => $value) {
	foreach ($value as $k => $v) {
		if(!isset($list_c[$k])){
			$list_c[$k]=$v;
		}
	}
}
$list_flashsale_id=substr($list_flashsale_id, 0,-1);
$tach_menu=json_decode($class_index->list_menu($conn),true);
$tach_banner=json_decode($class_index->list_banner($conn),true);
$tach_list_category=json_decode($class_index->list_category($conn),true);
$link_xem=(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$tach_list_flashsale_id = explode(',', $list_flashsale_id);
$list_id=array_unique($tach_list_flashsale_id);
$list_id=implode(',', $list_id);
$thongke=mysqli_query($conn, "SELECT * FROM sanpham WHERE kho>0 AND id IN ($list_id) ORDER BY (gia_cu - gia_moi) DESC");;
$total_tk=mysqli_num_rows($thongke);
$r_tk=mysqli_fetch_assoc($thongke);
		$thongtin_sanpham = mysqli_query($conn, "SELECT * FROM sanpham WHERE kho>0 AND id IN ($list_id) ORDER BY (gia_cu - gia_moi) DESC LIMIT 0,48");
		while ($r_sp = mysqli_fetch_assoc($thongtin_sanpham)) {
			$id_sp = $r_sp['id'];
			$giam = ceil((($r_sp['gia_cu'] - (int)preg_replace('/[^0-9]/', '', $list_c[$id_sp]['gia'])) / $r_sp['gia_cu']) * 100);
			$r_sp['gia_moi'] = number_format((int)preg_replace('/[^0-9]/', '', $list_c[$id_sp]['gia']));
			$r_sp['gia_cu'] = number_format($r_sp['gia_cu']);
			$r_sp['giam']=$giam;
			$r_sp['so_luong']=intval($list_c[$id_sp]['so_luong']);
			$tach_date_start=explode(' ', $list_c[$id_sp]['date_start']);
			$tach_time_start=explode(':', $tach_date_start[0]);
			$tach_ngay_start=explode('/', $tach_date_start[1]);
			$date_start=mktime((int)$tach_time_start[0],(int)$tach_time_start[1],0,(int)$tach_ngay_start[1],(int)$tach_ngay_start[0],(int)$tach_ngay_start[2]);
			$tach_date_end=explode(' ', $list_c[$id_sp]['date_end']);
			$tach_time_end=explode(':', $tach_date_end[0]);
			$tach_ngay_end=explode('/', $tach_date_end[1]);
			$date_end=mktime((int)$tach_time_end[0],(int)$tach_time_end[1],0,(int)$tach_ngay_end[1],(int)$tach_ngay_end[0],(int)$tach_ngay_end[2]);
			$r_sp['time_start']=$date_start - time();
			$r_sp['time']=$date_end - time();
			if($r_sp['time_start']>0){
				$r_sp['text']='Bắt đầu sau';
			}else{
				$r_sp['text']='Còn';
			}
			$list .= $r_sp['tieu_de'].'<br><br>';

		}
		echo $list;
?>