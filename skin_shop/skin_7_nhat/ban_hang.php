<?php
$class_index=$tlca_do->load_skin($s,'class_shop');
$giaodien = json_decode($index_setting['giaodien'], true);
// if(isset($_SESSION['muakem'])){
// 	foreach ($_SESSION['main_product'] as $key => $value) {
// 		$list_main_id.=$value.',';
// 		$thongtin_muakem=mysqli_query($conn,"SELECT * FROM deal WHERE FIND_IN_SET($value,main_product)>0 AND date_start<='$hientai' AND date_end>='$hientai' AND loai='muakem' AND shop='$shop' ORDER BY id DESC LIMIT 1");
// 		$r_mk=mysqli_fetch_assoc($thongtin_muakem);
// 		$list_id_mk.=$r_mk['sub_id'].',';
// 		$list_sub_product[]=json_decode($r_mk['sub_product'],true);
// 	}
// 	foreach ($list_sub_product as $key => $value) {
// 		foreach ($value as $k => $v) {
// 			$list_s[$k]=$v;
// 		}
// 	}
// 	$list_main_id=substr($list_main_id, 0,-1);
// 	$tach_list_main_id=explode(',', $list_main_id);
// 	$list_id_mk=substr($list_id_mk, 0,-1);
// 	$tach_list_id_mk=explode(',', $list_id_mk);
// 	$list_id_check='';
// 	foreach ($_SESSION['cart'] as $key => $value) {
// 		$list_id.=$key.',';
// 		if($_SESSION['cart'][$key]['flash_sale']==1){
// 			$thongtin_check=mysqli_query($conn,"SELECT * FROM deal WHERE FIND_IN_SET($key,main_product)>0 AND date_start<='$hientai' AND date_end>='$hientai' AND loai='flash_sale' AND shop='$shop' ORDER BY id DESC LIMIT 1");
// 			$r_ck=mysqli_fetch_assoc($thongtin_check);
// 			$list_check_product[]=json_decode($r_ck['sub_product'],true);
// 		}
// 	}
// 	foreach ($list_check_product as $key => $value) {
// 		foreach ($value as $k => $v) {
// 			$list_c[$k]=$v;
// 		}
// 	}
// 	$list_id=substr($list_id, 0,-1);
// 	$thongtin_cart=mysqli_query($conn,"SELECT * FROM sanpham_shop WHERE id IN ($list_id) AND shop='$shop' ORDER BY FIELD(id,$list_id) ASC");
// 	while($r_cart=mysqli_fetch_assoc($thongtin_cart)){
// 		$id_sp=$r_cart['id'];
// 		if($_SESSION['cart'][$id_sp]['tang']==1){
// 			$r_cart['ten_sanpham']='<span class="color_red">[Quà tặng]</span> '.$r_cart['tieu_de'];
// 			$tongtien+=0;
// 			$r_cart['thanhtien']=0;
// 			$r_cart['gia_moi']=0;
// 			$r_cart['quantity']=1;
// 			$list_shopcart.=$skin->skin_replace('skin_shop/'.$s.'/tpl/box_li/li_shopcart_tang',$r_cart);
// 			$list_shopcart_mobile.=$skin->skin_replace('skin_shop/'.$s.'/tpl/box_li/li_shopcart_mobile_tang',$r_cart);
// 		}else if(in_array($id_sp, $tach_list_id_mk)==true){
// 			$r_cart['ten_sanpham']='<span class="color_red">[Deal sốc]</span> '.$r_cart['tieu_de'];
// 			if($list_s[$id_sp]['gia']!=''){
// 				$tongtien+=preg_replace('/[^0-9]/', '', $list_s[$id_sp]['gia'])*$_SESSION['cart'][$id_sp]['quantity'];
// 				$r_cart['thanhtien']=number_format(preg_replace('/[^0-9]/', '', $list_s[$id_sp]['gia'])*$_SESSION['cart'][$id_sp]['quantity']);
// 				$r_cart['gia_moi']=number_format(preg_replace('/[^0-9]/', '', $list_s[$id_sp]['gia']));
// 				$r_cart['quantity']=$_SESSION['cart'][$id_sp]['quantity'];
// 			}else{
// 				$gia_moi=$r_cart['gia_moi'] - ($r_cart['gia_moi']/100)*$list_s[$id_sp]['sale'];
// 				$tongtien+=$gia_moi*$_SESSION['cart'][$id_sp]['quantity'];
// 				$r_cart['thanhtien']=number_format($gia_moi*$_SESSION['cart'][$id_sp]['quantity']);
// 				$r_cart['gia_moi']=number_format($gia_moi);
// 				$r_cart['quantity']=$_SESSION['cart'][$id_sp]['quantity'];
// 			}
// 			$list_shopcart.=$skin->skin_replace('skin_shop/'.$s.'/tpl/box_li/li_shopcart_dealsoc',$r_cart);
// 			$list_shopcart_mobile.=$skin->skin_replace('skin_shop/'.$s.'/tpl/box_li/li_shopcart_mobile_dealsoc',$r_cart);
// 		}else if(isset($list_c[$id_sp])){
// 			$r_cart['ten_sanpham']='<span class="color_red">[Flash Sale]</span> '.$r_cart['tieu_de'];
// 			$tongtien+=preg_replace('/[^0-9]/', '', $list_c[$id_sp]['gia'])*$_SESSION['cart'][$id_sp]['quantity'];
// 			$r_cart['thanhtien']=number_format(preg_replace('/[^0-9]/', '', $list_c[$id_sp]['gia'])*$_SESSION['cart'][$id_sp]['quantity']);
// 			$r_cart['gia_moi']=number_format(preg_replace('/[^0-9]/', '', $list_c[$id_sp]['gia']));
// 			$r_cart['quantity']=$_SESSION['cart'][$id_sp]['quantity'];
// 			$list_shopcart.=$skin->skin_replace('skin_shop/'.$s.'/tpl/box_li/li_shopcart',$r_cart);
// 			$list_shopcart_mobile.=$skin->skin_replace('skin_shop/'.$s.'/tpl/box_li/li_shopcart_mobile',$r_cart);
// 		}else{
// 			$r_cart['ten_sanpham']=$r_cart['tieu_de'];
// 			$tongtien+=$r_cart['gia_moi']*$_SESSION['cart'][$id_sp]['quantity'];
// 			$r_cart['thanhtien']=number_format($r_cart['gia_moi']*$_SESSION['cart'][$id_sp]['quantity']);
// 			$r_cart['gia_moi']=number_format($r_cart['gia_moi']);
// 			$r_cart['quantity']=$_SESSION['cart'][$id_sp]['quantity'];
// 			$list_shopcart.=$skin->skin_replace('skin_shop/'.$s.'/tpl/box_li/li_shopcart',$r_cart);
// 			$list_shopcart_mobile.=$skin->skin_replace('skin_shop/'.$s.'/tpl/box_li/li_shopcart_mobile',$r_cart);
// 		}
// 	}
// 	$total_price = number_format($tongtien) . 'đ';
// }else{
// 	foreach ($_SESSION['cart'] as $key => $value) {
// 		$list_id .= $key . ',';
// 		if($_SESSION['cart'][$key]['flash_sale']==1){
// 			$thongtin_check=mysqli_query($conn,"SELECT * FROM deal WHERE FIND_IN_SET($key,main_product)>0 AND date_start<='$hientai' AND date_end>='$hientai' AND loai='flash_sale' AND shop='$shop' ORDER BY id DESC LIMIT 1");
// 			$r_ck=mysqli_fetch_assoc($thongtin_check);
// 			$list_check_product[]=json_decode($r_ck['sub_product'],true);
// 		}
// 	}
// 	foreach ($list_check_product as $key => $value) {
// 		foreach ($value as $k => $v) {
// 			$list_c[$k]=$v;
// 		}
// 	}
// 	$list_id = substr($list_id, 0, -1);
// 	$thongtin_cart = mysqli_query($conn, "SELECT * FROM sanpham_shop WHERE id IN ($list_id) AND shop='$shop' ORDER BY FIELD(id,$list_id)");
// 	while ($r_cart = mysqli_fetch_assoc($thongtin_cart)) {
// 		$id_sp = $r_cart['id'];
// 		if($_SESSION['cart'][$id_sp]['tang']==1){
// 			$r_cart['ten_sanpham']='<span class="color_red">[Quà tặng]</span> '.$r_cart['tieu_de'];
// 			$tongtien+=0;
// 			$r_cart['thanhtien']=0;
// 			$r_cart['gia_moi']=0;
// 			$r_cart['quantity']=1;
// 			$list_shopcart.=$skin->skin_replace('skin_shop/'.$s.'/tpl/box_li/li_shopcart_tang',$r_cart);
// 			$list_shopcart_mobile.=$skin->skin_replace('skin_shop/'.$s.'/tpl/box_li/li_shopcart_mobile_tang',$r_cart);
// 		}else if(isset($list_c[$id_sp])){
// 			$r_cart['ten_sanpham']='<span class="color_red">[Flash Sale]</span> '.$r_cart['tieu_de'];
// 			$tongtien += preg_replace('/[^0-9]/', '', $list_c[$id_sp]['gia']) * $_SESSION['cart'][$id_sp]['quantity'];
// 			$r_cart['thanhtien'] = number_format(preg_replace('/[^0-9]/', '', $list_c[$id_sp]['gia']) * $_SESSION['cart'][$id_sp]['quantity']);
// 			$r_cart['gia_moi'] = number_format(preg_replace('/[^0-9]/', '', $list_c[$id_sp]['gia']));
// 			$r_cart['quantity'] = $_SESSION['cart'][$id_sp]['quantity'];
// 			$list_shopcart.=$skin->skin_replace('skin_shop/'.$s.'/tpl/box_li/li_shopcart',$r_cart);
// 			$list_shopcart_mobile.=$skin->skin_replace('skin_shop/'.$s.'/tpl/box_li/li_shopcart_mobile',$r_cart);
// 		}else{
// 			$r_cart['ten_sanpham']=$r_cart['tieu_de'];
// 			$tongtien += $r_cart['gia_moi'] * $_SESSION['cart'][$id_sp]['quantity'];
// 			$r_cart['thanhtien'] = number_format($r_cart['gia_moi'] * $_SESSION['cart'][$id_sp]['quantity']);
// 			$r_cart['gia_moi'] = number_format($r_cart['gia_moi']);
// 			$r_cart['quantity'] = $_SESSION['cart'][$id_sp]['quantity'];
// 			$list_shopcart.=$skin->skin_replace('skin_shop/'.$s.'/tpl/box_li/li_shopcart',$r_cart);
// 			$list_shopcart_mobile.=$skin->skin_replace('skin_shop/'.$s.'/tpl/box_li/li_shopcart_mobile',$r_cart);
// 		}
// 	}
// 	//$tongtien = number_format($total_price) . 'đ';
// }
$limit=48;
if(!isset($_COOKIE['user_id'])){
	$thongbao="Bạn hiện chưa đăng nhập.";
	$replace=array(
		'title'=>'Bạn chưa đăng nhập tài khoản',
		'thongbao'=>$thongbao,
		'link'=>'/dang-nhap.html'
	);
	echo $skin->skin_replace('skin_shop/'.$s.'/tpl/chuyenhuong',$replace);
	exit();
}else{
	$box_header=$skin->skin_normal('skin_shop/'.$s.'/tpl/box_header_login');
	$header_menu_mobile=$skin->skin_normal('skin_shop/'.$s.'/tpl/header_menu_mobile_login');
	$class_member=$tlca_do->load('class_member');
	$tach_token=json_decode($check->token_login_decode($_COOKIE['user_id']),true);
	$user_id=$tach_token['user_id'];
	$user_info=$class_member->user_info($conn,$_COOKIE['user_id']);
	if($user_info['dropship']==1){
		$thongbao="Hệ thống đang chuyển hướng.";
		$replace=array(
			'title'=>'Đang chuyển hướng tới trang bán hàng',
			'thongbao'=>$thongbao,
			'link'=>'/dropship/'
		);
		echo $skin->skin_replace('skin_shop/'.$s.'/tpl/chuyenhuong',$replace);
		exit();		
	}
}
if($r_cat['cat_main']==0){
	$list_category_sub=$tach_category['list_main'];
}else{
	$thongtin_sub=mysqli_query($conn,"SELECT * FROM category_sanpham_shop WHERE cat_main='{$r_cat['cat_id']}' AND shop='{$r_shop['user_id']}'");
	$total_sub=mysqli_num_rows($thongtin_sub);
	if($total_sub>0){
		while($r_sub=mysqli_fetch_assoc($thongtin_sub)){
			$list_category_sub.='<li class=""><a href="/san-pham/'.$r_sub['cat_blank'].'.html" class="nav-link" title="'.$r_sub['cat_tieude'].'">'.$r_sub['cat_tieude'].'</a></li>';
		}
	}else{
		$thongtin_sub_main=mysqli_query($conn,"SELECT * FROM category_sanpham_shop WHERE cat_main='{$r_cat['cat_main']}' AND shop='{$r_shop['user_id']}'");
		while($r_sub_main=mysqli_fetch_assoc($thongtin_sub_main)){
			if($r_cat['cat_id']==$r_sub_main['cat_id']){
				$list_category_sub.='<li class="active"><a href="/san-pham/'.$r_sub_main['cat_blank'].'.html" class="nav-link" title="'.$r_sub_main['cat_tieude'].'">'.$r_sub_main['cat_tieude'].'</a></li>';
			}else{
				$list_category_sub.='<li class=""><a href="/san-pham/'.$r_sub_main['cat_blank'].'.html" class="nav-link" title="'.$r_sub_main['cat_tieude'].'">'.$r_sub_main['cat_tieude'].'</a></li>';
			}
		}
	}
}
if($user_info['dropship']==2){
	$text_dropship=$skin->skin_normal('skin_shop/'.$s.'/tpl/dropship_wait');
}else{
	$text_dropship=$skin->skin_normal('skin_shop/'.$s.'/tpl/dropship_reg');
}
$tach_category=json_decode($class_index->list_category($conn,$r_shop['user_id']),true);
if($r_cat['cat_main']==0){
	$list_category_sub=$tach_category['list_main'];
}else{
	$thongtin_sub=mysqli_query($conn,"SELECT * FROM category_sanpham_shop WHERE cat_main='{$r_cat['cat_id']}' AND shop='{$r_shop['user_id']}'");
	$total_sub=mysqli_num_rows($thongtin_sub);
	if($total_sub>0){
		while($r_sub=mysqli_fetch_assoc($thongtin_sub)){
			$list_category_sub.='<li class=""><a href="/san-pham/'.$r_sub['cat_blank'].'.html" class="nav-link" title="'.$r_sub['cat_tieude'].'">'.$r_sub['cat_tieude'].'</a></li>';
		}
	}else{
		$thongtin_sub_main=mysqli_query($conn,"SELECT * FROM category_sanpham_shop WHERE cat_main='{$r_cat['cat_main']}' AND shop='{$r_shop['user_id']}'");
		while($r_sub_main=mysqli_fetch_assoc($thongtin_sub_main)){
			if($r_cat['cat_id']==$r_sub_main['cat_id']){
				$list_category_sub.='<li class="active"><a href="/san-pham/'.$r_sub_main['cat_blank'].'.html" class="nav-link" title="'.$r_sub_main['cat_tieude'].'">'.$r_sub_main['cat_tieude'].'</a></li>';
			}else{
				$list_category_sub.='<li class=""><a href="/san-pham/'.$r_sub_main['cat_blank'].'.html" class="nav-link" title="'.$r_sub_main['cat_tieude'].'">'.$r_sub_main['cat_tieude'].'</a></li>';
			}
		}
	}
}
$tach_menu=json_decode($class_index->list_menu($conn,$s,$r_shop['user_id']),true);
$tach_category=json_decode($class_index->list_category($conn,$r_shop['user_id']),true);
$google_analytics=str_replace('<script>// <![CDATA[', '<script>', $index_setting['google_analytics']);
$google_analytics=str_replace('// ]]>', '', $google_analytics);
$script_chat=str_replace('<script>// <![CDATA[', '<script>', $index_setting['script_footer']);
$script_chat=str_replace('// ]]>', '', $script_chat);
$sql = "SELECT name, value FROM index_setting WHERE name IN ('banner_mot', 'banner_2','banner_mot_text', 'banner_2_text', 'modal_header')";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Lỗi truy vấn: " . mysqli_error($conn));
}

$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $data[$row['name']] = $row['value'];
}

$replace = array(
	'modal_header' => $data['modal_header'], // Ghi đè giá trị của modal_header
	'header'=>$skin->skin_normal('skin_shop/'.$s.'/tpl/header'),
	'box_header'=>$box_header,
	'footer'=>$skin->skin_normal('skin_shop/'.$s.'/tpl/footer'),
	'script_footer'=>$skin->skin_normal('skin_shop/'.$s.'/tpl/script_footer'),
	'title'=>'Đăng ký tài khoản bán hàng',
	'description'=>$index_setting['description'],
	'site_name'=>$index_setting['site_name'],
	'limit'=>$limit,
	'logo'=>$index_setting['logo'],
	'text_footer'=>$index_setting['text_footer'],
	'google_analytics'=>$google_analytics,
	'script_chat'=>$script_chat,
	'list_category_sub'=>$list_category_sub,
	'list_category_sub'=>$list_category_sub,
	'text_contact_footer'=>$index_setting['text_contact_footer'],
	'text_about'=>$index_setting['text_about'],
	'link_xem'=>$index_setting['link_domain'],
	'hotline'=>$index_setting['hotline'],
	'hotline_number'=>preg_replace('/[^0-9]/', '',$index_setting['hotline']),
	'text_hotline'=>$index_setting['text_hotline'],
	'link_facebook'=>$index_setting['link_facebook'],
	'link_google'=>$index_setting['link_google'],
	'link_youtube'=>$index_setting['link_youtube'],
	'link_twitter'=>$index_setting['link_twitter'],
	'link_instagram'=>$index_setting['link_instagram'],
	'bg_backgroud'=>$giaodien['background'],
	'bg_header'=>$giaodien['header'],
	'bg_topbar'=>$giaodien['topbar'],
	'bg_hotline'=>$giaodien['hotline'],
	'bg_menu'=>$giaodien['menu'],
	'bg_title_menu'=>$giaodien['title_menu'],
	'bg_title_box'=>$giaodien['title_box'],
	'bg_button_top'=>$giaodien['button_top'],
	'bg_subcribe'=>$giaodien['subcribe'],
	'bg_top_menu_mobile'=>$giaodien['top_menu_mobile'],
	'bg_label_sale'=>$giaodien['label_sale'],
	'bg_ma_giamgia'=>$giaodien['ma_giamgia'],
	'bg_top_footer'=>$giaodien['top_footer'],
	'bg_bottom_footer'=>$giaodien['bottom_footer'],
	'color_text_top_footer'=>$giaodien['text_top_footer'],
	'color_text_bottom_footer'=>$giaodien['text_bottom_footer'],
	'bg_timkiem'=>$giaodien['timkiem'],
	'bg_nhantin'=>$giaodien['nhantin'],
	'color_text_title_top_footer'=>$giaodien['text_title_top_footer'],
	'menu_chinhsach'=>$tach_menu['chinhsach'],
	'menu_huongdan'=>$tach_menu['huongdan'],
	'menu_top'=>$tach_menu['top'],
	'list_category_nav'=>$tach_category['list'],
	'list_category_left'=>$tach_category['list_left'],
	'photo'=>$index_setting['photo'],
	'phantrang'=>$phantrang,
	'fanpage'=>$index_setting['fanpage'],
	'name'=>$user_info['name'],
	'avatar'=>$user_info['avatar'],
	'email'=>$user_info['email'],
	'ngay_sinh'=>$user_info['ngaysinh'],
	'dien_thoai'=>$user_info['mobile'],
	'username'=>$user_info['username'],
	'date_reg'=>date('d/m/Y',$user_info['created']),
	'dia_chi'=>$user_info['dia_chi'],
	'ngay'=>date('d'),
	'thang'=>date('m'),
	'nam'=>date('Y'),
	'text_dropship'=>$text_dropship,
	'gioithieu_dropship'=>$index_setting['gioithieu_dropship'],
	'tongtien'=>number_format($tongtien),
	'shop'=>$r_shop['user_id'],
	'box_banner' => $skin->skin_normal('skin_shop/' . $s . '/tpl/box_banner'),
	'noidung_header' => $_SESSION['noidung_header'], // Ghi đè giá trị của noidung_header
	);
echo $skin->skin_replace('skin_shop/'.$s.'/tpl/ban_hang',$replace);
?>