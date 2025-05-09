<?php
$web=$_SERVER['HTTP_HOST'];
$web=str_replace('www.', '', $web);
$web_root=array('doantotnghiep.vn','socdo.vn','socmoi.vn','soc.vn','beta.socdo.vn');
if(in_array($web, $web_root)==false){
	include('./shop/checkout.php');
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
$step=addslashes($url_query['step']);
$setting=mysqli_query($conn,"SELECT * FROM index_setting ORDER BY name ASC");
while ($r_s=mysqli_fetch_assoc($setting)) {
	$index_setting[$r_s['name']]=$r_s['value'];
}
$limit=10;
if(isset($_COOKIE['user_id'])){
	$box_header=$skin->skin_normal('skin/box_header_login');
	$mobile_menu=$skin->skin_normal('skin/mobile_menu_login');
	$class_member=$tlca_do->load('class_member');
	$tach_token=json_decode($check->token_login_decode($_COOKIE['user_id']),true);
	$user_id=$tach_token['user_id'];
	$user_info=$class_member->user_info($conn,$_COOKIE['user_id']);
}else{
	$box_header=$skin->skin_normal('skin/box_header');
	$mobile_menu=$skin->skin_normal('skin/mobile_menu');
}
$hientai=time();
if($step==1 OR $step==2){
	if(count($_SESSION['cart'])==0){
		$thongbao="Bạn chưa chọn sản phẩm nào.";
		$replace=array(
			'title'=>'Chưa chọn sản phẩm',
			'thongbao'=>$thongbao,
			'link'=>'/'
		);
		echo $skin->skin_replace('skin/chuyenhuong',$replace);
		exit();
	}
	foreach ($_SESSION['cart'] as $key => $value) {
		$list_id.=$key.',';
	}
	$list_id=substr($list_id, 0,-1);
	$k=0;
	$thongtin_cart = mysqli_query($conn, "SELECT * FROM sanpham WHERE id IN ($list_id) ORDER BY gia_moi DESC");
	while ($r_cart = mysqli_fetch_assoc($thongtin_cart)) {
		$id_sp = $r_cart['id'];
		for ($i=0; $i < $_SESSION['cart'][$id_sp]['quantity']; $i++) { 
			$k++;
			if($k==1){
				$sp_giam=0;
			}else if($k==2){
				$sp_giam=5;
			}else if($k==3){
				$sp_giam=7;
			}else if($k==4){
				$sp_giam=8;
			}else if($k==5){
				$sp_giam=10;
			}else{
				$sp_giam=0;
			}
			$r_cart['i']=$k;
			$can_nang+=str_replace(',', '.', $r_cart['can_nang']);
			$r_cart['ten_sanpham']=$r_cart['tieu_de'];
			$thanhtien=$r_cart['gia_moi'] - ($r_cart['gia_moi']/100)*$sp_giam;
			$tamtinh += $thanhtien;
			$r_cart['thanhtien'] = number_format($thanhtien);
			$r_cart['gia_gop'] = number_format($r_cart['gia_moi']);
			$r_cart['giam']=$sp_giam;
			$r_cart['quantity'] = $_SESSION['cart'][$id_sp]['quantity'];
			if($sp_giam==0){
				$list_product.=$skin->skin_replace('skin/box_li/li_product_checkout_no_gopdon',$r_cart);
			}else{
				$list_product.=$skin->skin_replace('skin/box_li/li_product_checkout_gopdon',$r_cart);
			}
		}
	}
	$phi_ship=0;
	$tongtien=$tamtinh - $giam + $phi_ship;
	if(isset($_SESSION['thanhtoan'])){
		$thanhtoan=$_SESSION['thanhtoan'];
	}else{
		$thanhtoan='cod';
	}
}
if($step==3){
	if(isset($_SESSION['ma_don'])){
		$thongtin_order=mysqli_query($conn,"SELECT * FROM donhang WHERE ma_don='{$_SESSION['ma_don']}'");
		$r_order=mysqli_fetch_assoc($thongtin_order);
	}else{
		$thongbao="Giao dịch đã quá hạn để xem chi tiết.";
		$replace=array(
			'title'=>'Giao dịch đã quá hạn để xem chi tiết.',
			'thongbao'=>$thongbao,
			'link'=>'/'
		);
		echo $skin->skin_replace('skin/chuyenhuong',$replace);
		exit();
	}
}
$list_danhmuc_top=json_decode($class_index->list_category_danhmuc_top($conn),true);
$replace=array(
	'header'=>$skin->skin_normal('skin/header'),
	'box_header'=>$box_header,
	'box_ma_giam'=>$box_ma_giam,
	'list_danhmuc_noibat_timkiem'=>$class_index->list_category_noibat_timkiem($conn), // chức năng tìm kiếm nâng cao
	'footer'=>$skin->skin_normal('skin/footer'),
	'script_footer'=>$skin->skin_normal('skin/script_footer'),
	'mobile_menu'=>$mobile_menu,
	'title'=>'Đặt Hàng',
	'description'=>$index_setting['description'],
	'site_name'=>$index_setting['site_name'],
	'limit'=>$limit,
	'logo'=>$index_setting['logo'],
	'text_footer'=>$index_setting['text_footer'],
	'text_contact_footer'=>$index_setting['text_contact_footer'],
	'text_about'=>$index_setting['text_about'],
	'link_xem'=>$index_setting['link_domain'],
	'text_hotline'=>$index_setting['text_hotline'],
	'link_facebook'=>$index_setting['link_facebook'],
	'link_google'=>$index_setting['link_google'],
	'link_youtube'=>$index_setting['link_youtube'],
	'link_twitter'=>$index_setting['link_twitter'],
	'link_instagram'=>$index_setting['link_instagram'],
	'menu_chinhsach'=>$tach_menu['chinhsach'],
	'menu_huongdan'=>$tach_menu['huongdan'],
	'menu_left'=>$tach_menu['left'],
	'list_category'=>$class_index->list_category($conn),
	'photo'=>$index_setting['photo'],
	'phantrang'=>$phantrang,
	'fanpage'=>$index_setting['fanpage'],
	'name'=>$user_info['name'],
	'email'=>$user_info['email'],
	'mobile'=>$user_info['mobile'],
	'dia_chi'=>$user_info['dia_chi'],
	'avatar'=>$user_info['avatar'],
	'option_tinh'=>$class_index->list_option_tinh($conn,$id),
	'list_product'=>$list_product,
	'tongtien'=>number_format($tongtien),
	'tamtinh'=>number_format($tamtinh),
	'giam'=>number_format($giam),
	'phi_ship'=>number_format($phi_ship).'đ',
	'coupon'=>$coupon,
	'list_giam'=>$list_ma_giam,
	'list_danhmuc'=>$list_danhmuc_top['list_top']
	);
	if($step==2){
		echo $skin->skin_replace('skin/checkout_gopdon_step_2',$replace);
	}else if($step==3){
		$replace['ho_ten']=$r_order['ho_ten'];
		$replace['email']=$r_order['email'];
		$replace['dien_thoai']=$r_order['dien_thoai'];
		$replace['dia_chi']=$r_order['dia_chi'];
		$replace['ma_don']=$r_order['ma_don'];
		$thontin_huyen=mysqli_query($conn,"SELECT huyen_moi.*,tinh_moi.tieu_de AS ten_tinh FROM huyen_moi INNER JOIN tinh_moi ON tinh_moi.id=huyen_moi.tinh WHERE huyen_moi.id='{$r_order['huyen']}'");
		$r_h=mysqli_fetch_assoc($thontin_huyen);
		$replace['tinh']=$r_h['ten_tinh'];
		$replace['huyen']=$r_h['tieu_de'];
		if($r_order['thanhtoan']=='chuyenkhoan'){
			$replace['phuongthuc']='Chuyển khoản ngân hàng';
			$replace['nganhang']=$index_setting['nganhang'];
		}else{
			$replace['phuongthuc']='Thanh toán khi nhận hàng';
			$replace['nganhang']='';
		}
		$tach_sanpham=json_decode($r_order['sanpham'],true);
		$m=0;
		foreach ($tach_sanpham as $key => $value) {
			$m++;
			if($m==1){
				$sp_giam=0;
			}else if($m==2){
				$sp_giam=5;
			}else if($m==3){
				$sp_giam=7;
			}else if($m==4){
				$sp_giam=8;
			}else if($m==5){
				$sp_giam=10;
			}else{
				$sp_giam=0;
			}
			$value['giam']=$sp_giam;
			$value['i']=$m;
			if($sp_giam==0){
				$list_product.=$skin->skin_replace('skin/box_li/li_product_checkout_no_gopdon_step_3',$value);
			}else{
				$list_product.=$skin->skin_replace('skin/box_li/li_product_checkout_gopdon_step_3',$value);
			}
		}
		$replace['list_product']=$list_product;
		$replace['tamtinh']=number_format($r_order['tamtinh']);
		$replace['tongtien']=number_format($r_order['tongtien']);
		$replace['giam']=number_format($r_order['giam']);
		if($r_order['phi_ship']>0){
			$replace['phi_ship']=number_format($r_order['phi_ship']).'đ';
		}else{
			$replace['phi_ship']='Miễn phí';
		}
		echo $skin->skin_replace('skin/checkout_gopdon_step_3',$replace);
	}else{
		echo $skin->skin_replace('skin/checkout_gopdon_step_1',$replace);
	}
?>