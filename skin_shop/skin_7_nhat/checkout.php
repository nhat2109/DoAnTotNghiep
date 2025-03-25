<?php
$class_index=$tlca_do->load_skin($s,'class_shop');
$giaodien = json_decode($index_setting['giaodien'], true);
$limit=10;
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
if(isset($_COOKIE['user_id'])){
	$box_header=$skin->skin_normal('skin_shop/'.$s.'/tpl/box_header_login');
	$class_member=$tlca_do->load('class_member');
	$tach_token=json_decode($check->token_login_decode($_COOKIE['user_id']),true);
	$user_id=$tach_token['user_id'];
	$user_info=$class_member->user_info($conn,$_COOKIE['user_id']);
}else{
	$box_header=$skin->skin_normal('skin_shop/'.$s.'/tpl/box_header');
}
$tach_menu=json_decode($class_index->list_menu($conn,$s,$r_shop['user_id']),true);
$tach_category=json_decode($class_index->list_category($conn,$r_shop['user_id']),true);
$hientai=time();
$thongtin_khuyenmai=mysqli_query($conn,"SELECT * FROM coupon WHERE shop='$shop' AND start<='$hientai' AND expired>='$hientai' ORDER BY id ASC");
while($r_km=mysqli_fetch_assoc($thongtin_khuyenmai)){
	$ma=$r_km['ma'];
	$list_km[$ma]['giam']=$r_km['giam'];
	$list_km[$ma]['loai']=$r_km['loai'];
	$list_km[$ma]['kieu']=$r_km['kieu'];
	$list_km[$ma]['sanpham']=$r_km['sanpham'];
}
if($step==1 OR $step==2){
	if(count((array)$_SESSION['cart'])==0){
		$thongbao="Bạn chưa chọn sản phẩm nào.";
		$replace=array(
			'title'=>'Chưa chọn sản phẩm',
			'thongbao'=>$thongbao,
			'link'=>'/'
		);
		echo $skin->skin_replace('skin_shop/'.$s.'/tpl/chuyenhuong',$replace);
		exit();
	}
	foreach ($_SESSION['cart'] as $key => $value) {
		$list_id.=$key.',';
	}
	$list_id=substr($list_id, 0,-1);
	if(isset($_SESSION['coupon'])){
		$thongtin_counpon=mysqli_query($conn,"SELECT *,count(*) AS total FROM coupon WHERE ma='{$_SESSION['coupon']}' AND shop='$shop'");
		$r_coupon=mysqli_fetch_assoc($thongtin_counpon);
		if($r_coupon['kieu']=='sanpham'){
			$tach_list_id=explode(',', $list_id);
			$tach_sanpham_id=explode(',', $r_coupon['sanpham']);
			$id_apdung=array_intersect($tach_sanpham_id, $tach_list_id);
			$total_id=count($id_apdung);
		}
	}
	if(isset($_SESSION['muakem'])){
		foreach ($_SESSION['main_product'] as $key => $value) {
			$list_main_id.=$value.',';
			$thongtin_muakem=mysqli_query($conn,"SELECT * FROM deal WHERE FIND_IN_SET($value,main_product)>0 AND date_start<='$hientai' AND date_end>='$hientai' AND loai='muakem' AND shop='$shop' ORDER BY id DESC LIMIT 1");
			$r_mk=mysqli_fetch_assoc($thongtin_muakem);
			$list_id_mk.=$r_mk['sub_id'].',';
			$list_sub_product[]=json_decode($r_mk['sub_product'],true);
		}
		foreach ($list_sub_product as $key => $value) {
			foreach ($value as $k => $v) {
				$list_s[$k]=$v;
			}
		}
		$list_main_id=substr($list_main_id, 0,-1);
		$tach_list_main_id=explode(',', $list_main_id);
		$list_id_mk=substr($list_id_mk, 0,-1);
		$tach_list_id_mk=explode(',', $list_id_mk);
		$list_id_check='';
		foreach ($_SESSION['cart'] as $key => $value) {
			if($_SESSION['cart'][$key]['flash_sale']==1){
				$thongtin_check=mysqli_query($conn,"SELECT * FROM deal WHERE FIND_IN_SET($key,main_product)>0 AND date_start<='$hientai' AND date_end>='$hientai' AND loai='flash_sale' AND shop='$shop' ORDER BY id DESC LIMIT 1");
				$r_ck=mysqli_fetch_assoc($thongtin_check);
				$list_check_product[]=json_decode($r_ck['sub_product'],true);
			}
		}
		foreach ($list_check_product as $key => $value) {
			foreach ($value as $k => $v) {
				$list_c[$k]=$v;
			}
		}
		$thongtin_cart=mysqli_query($conn,"SELECT * FROM sanpham_shop WHERE id IN ($list_id) AND shop='$shop' ORDER BY FIELD(id,$list_id) ASC");
		while($r_cart=mysqli_fetch_assoc($thongtin_cart)){
			$id_sp=$r_cart['id'];
						if($r_cart['can_nang']==''){
				$can_nang+=0;
			}else{
				$can_nang+=str_replace(',', '.', $r_cart['can_nang'])*$_SESSION['cart'][$id_sp]['quantity'];
			}
			if($_SESSION['cart'][$id_sp]['tang']==1){
				$r_cart['ten_sanpham']='<span class="color_red">[Quà tặng]</span> '.$r_cart['tieu_de'];
				$tamtinh+=0;
				$r_cart['thanhtien']=0;
				$r_cart['gia_moi']=0;
				$r_cart['quantity']=1;
			}else if(in_array($id_sp, $tach_list_id_mk)==true){
				$r_cart['ten_sanpham']='<span class="color_red">[Deal sốc]</span> '.$r_cart['tieu_de'];
				if($list_s[$id_sp]['gia']!=''){
					foreach ($list_km as $kkk => $vvv) {
						if($vvv['kieu']=='all'){
							if($vvv['loai']=='phantram'){
								$ggg=(preg_replace('/[^0-9]/', '', $list_s[$id_sp]['gia'])*$_SESSION['cart'][$id_sp]['quantity']/100)*$vvv['giam'];
								$list_giam[$kkk]+=ceil($ggg);
							}else{
								$list_giam[$kkk]+=$vvv['giam'];
							}
						}else{
							$tach_apdung=explode(',', $vvv['sanpham']);
							if(in_array($id_sp, $tach_apdung)==true){
								if($vvv['loai']=='phantram'){
									$ggg=(preg_replace('/[^0-9]/', '', $list_s[$id_sp]['gia'])*$_SESSION['cart'][$id_sp]['quantity']/100)*$vvv['giam'];
									$list_giam[$kkk]+=ceil($ggg);
								}else{
									$list_giam[$kkk]+=$vvv['giam'];
								}
							}

						}
					}
					$tamtinh+=preg_replace('/[^0-9]/', '', $list_s[$id_sp]['gia'])*$_SESSION['cart'][$id_sp]['quantity'];
					$r_cart['thanhtien']=number_format(preg_replace('/[^0-9]/', '', $list_s[$id_sp]['gia'])*$_SESSION['cart'][$id_sp]['quantity']);
					$r_cart['gia_moi']=number_format(preg_replace('/[^0-9]/', '', $list_s[$id_sp]['gia']));
					$r_cart['quantity']=$_SESSION['cart'][$id_sp]['quantity'];
				}else{
					$gia_moi=$r_cart['gia_moi'] - ($r_cart['gia_moi']/100)*$list_s[$id_sp]['sale'];
					$tamtinh+=$gia_moi*$_SESSION['cart'][$id_sp]['quantity'];
					foreach ($list_km as $kkk => $vvv) {
						if($vvv['kieu']=='all'){
							if($vvv['loai']=='phantram'){
								$ggg=($gia_moi*$_SESSION['cart'][$id_sp]['quantity']/100)*$vvv['giam'];
								$list_giam[$kkk]+=ceil($ggg);
							}else{
								$list_giam[$kkk]+=$vvv['giam'];
							}
						}else{
							$tach_apdung=explode(',', $vvv['sanpham']);
							if(in_array($id_sp, $tach_apdung)==true){
								if($vvv['loai']=='phantram'){
									$ggg=($gia_moi*$_SESSION['cart'][$id_sp]['quantity']/100)*$vvv['giam'];
									$list_giam[$kkk]+=ceil($ggg);
								}else{
									$list_giam[$kkk]+=$vvv['giam'];
								}
							}

						}
					}
					$r_cart['thanhtien']=number_format($gia_moi*$_SESSION['cart'][$id_sp]['quantity']);
					$r_cart['gia_moi']=number_format($gia_moi);
					$r_cart['quantity']=$_SESSION['cart'][$id_sp]['quantity'];
				}
			}else if(isset($list_c[$id_sp])){
				$r_cart['ten_sanpham']='<span class="color_red">[Flash Sale]</span> '.$r_cart['tieu_de'];
				$tamtinh+=preg_replace('/[^0-9]/', '', $list_c[$id_sp]['gia'])*$_SESSION['cart'][$id_sp]['quantity'];
				foreach ($list_km as $kkk => $vvv) {
					if($vvv['kieu']=='all'){
						if($vvv['loai']=='phantram'){
							$ggg=(preg_replace('/[^0-9]/', '', $list_c[$id_sp]['gia']) * $_SESSION['cart'][$id_sp]['quantity']/100)*$vvv['giam'];
							$list_giam[$kkk]+=ceil($ggg);
						}else{
							$list_giam[$kkk]+=$vvv['giam'];
						}
					}else{
						$tach_apdung=explode(',', $vvv['sanpham']);
						if(in_array($id_sp, $tach_apdung)==true){
							if($vvv['loai']=='phantram'){
								$ggg=(preg_replace('/[^0-9]/', '', $list_c[$id_sp]['gia']) * $_SESSION['cart'][$id_sp]['quantity']/100)*$vvv['giam'];
								$list_giam[$kkk]+=ceil($ggg);
							}else{
								$list_giam[$kkk]+=$vvv['giam'];
							}
						}

					}
				}
				$r_cart['thanhtien']=number_format(preg_replace('/[^0-9]/', '', $list_c[$id_sp]['gia'])*$_SESSION['cart'][$id_sp]['quantity']);
				$r_cart['gia_moi']=number_format(preg_replace('/[^0-9]/', '', $list_c[$id_sp]['gia']));
				$r_cart['quantity']=$_SESSION['cart'][$id_sp]['quantity'];
			}else{
				$r_cart['ten_sanpham']=$r_cart['tieu_de'];
				$tamtinh+=$r_cart['gia_moi']*$_SESSION['cart'][$id_sp]['quantity'];
				foreach ($list_km as $kkk => $vvv) {
					if($vvv['kieu']=='all'){
						if($vvv['loai']=='phantram'){
							$ggg=($r_cart['gia_moi'] * $_SESSION['cart'][$id_sp]['quantity']/100)*$vvv['giam'];
							$list_giam[$kkk]+=ceil($ggg);
						}else{
							$list_giam[$kkk]+=$vvv['giam'];
						}
					}else{
						$tach_apdung=explode(',', $vvv['sanpham']);
						if(in_array($id_sp, $tach_apdung)==true){
							if($vvv['loai']=='phantram'){
								$ggg=($r_cart['gia_moi'] * $_SESSION['cart'][$id_sp]['quantity']/100)*$vvv['giam'];
								$list_giam[$kkk]+=ceil($ggg);
							}else{
								$list_giam[$kkk]+=$vvv['giam'];
							}
						}

					}
				}
				$r_cart['thanhtien']=number_format($r_cart['gia_moi']*$_SESSION['cart'][$id_sp]['quantity']);
				$r_cart['gia_moi']=number_format($r_cart['gia_moi']);
				$r_cart['quantity']=$_SESSION['cart'][$id_sp]['quantity'];
			}
			$list_product.=$skin->skin_replace('skin_shop/'.$s.'/tpl/box_li/li_product_checkout',$r_cart);
		}
		//$total_price = number_format($tongtien) . 'đ';
	}else{
		foreach ($_SESSION['cart'] as $key => $value) {
			if($_SESSION['cart'][$key]['flash_sale']==1){
				$thongtin_check=mysqli_query($conn,"SELECT * FROM deal WHERE FIND_IN_SET($key,main_product)>0 AND date_start<='$hientai' AND date_end>='$hientai' AND loai='flash_sale' AND shop='$shop' ORDER BY id DESC LIMIT 1");
				$r_ck=mysqli_fetch_assoc($thongtin_check);
				$list_check_product[]=json_decode($r_ck['sub_product'],true);
			}
		}
		foreach ($list_check_product as $key => $value) {
			foreach ($value as $k => $v) {
				$list_c[$k]=$v;
			}
		}
		$thongtin_cart = mysqli_query($conn, "SELECT * FROM sanpham_shop WHERE id IN ($list_id) AND shop='$shop' ORDER BY FIELD(id,$list_id)");
		while ($r_cart = mysqli_fetch_assoc($thongtin_cart)) {
			$id_sp = $r_cart['id'];
						if($r_cart['can_nang']==''){
				$can_nang+=0;
			}else{
				$can_nang+=str_replace(',', '.', $r_cart['can_nang'])*$_SESSION['cart'][$id_sp]['quantity'];
			}
			if($_SESSION['cart'][$id_sp]['tang']==1){
				$r_cart['ten_sanpham']='<span class="color_red">[Quà tặng]</span> '.$r_cart['tieu_de'];
				$tamtinh+=0;
				$r_cart['thanhtien']=0;
				$r_cart['gia_moi']=0;
				$r_cart['quantity']=1;
				$list_product.=$skin->skin_replace('skin_shop/'.$s.'/tpl/box_li/li_product_checkout',$r_cart);
			}else if(isset($list_c[$id_sp])){
				$r_cart['ten_sanpham']='<span class="color_red">[Flash Sale]</span> '.$r_cart['tieu_de'];
				$tamtinh += preg_replace('/[^0-9]/', '', $list_c[$id_sp]['gia']) * $_SESSION['cart'][$id_sp]['quantity'];
				foreach ($list_km as $kkk => $vvv) {
					if($vvv['kieu']=='all'){
						if($vvv['loai']=='phantram'){
							$ggg=(preg_replace('/[^0-9]/', '', $list_c[$id_sp]['gia']) * $_SESSION['cart'][$id_sp]['quantity']/100)*$vvv['giam'];
							$list_giam[$kkk]+=ceil($ggg);
						}else{
							$list_giam[$kkk]+=$vvv['giam'];
						}
					}else{
						$tach_apdung=explode(',', $vvv['sanpham']);
						if(in_array($id_sp, $tach_apdung)==true){
							if($vvv['loai']=='phantram'){
								$ggg=(preg_replace('/[^0-9]/', '', $list_c[$id_sp]['gia']) * $_SESSION['cart'][$id_sp]['quantity']/100)*$vvv['giam'];
								$list_giam[$kkk]+=ceil($ggg);
							}else{
								$list_giam[$kkk]+=$vvv['giam'];
							}
						}

					}
				}
				$r_cart['thanhtien'] = number_format(preg_replace('/[^0-9]/', '', $list_c[$id_sp]['gia']) * $_SESSION['cart'][$id_sp]['quantity']);
				$r_cart['gia_moi'] = number_format(preg_replace('/[^0-9]/', '', $list_c[$id_sp]['gia']));
				$r_cart['quantity'] = $_SESSION['cart'][$id_sp]['quantity'];
				$list_product.=$skin->skin_replace('skin_shop/'.$s.'/tpl/box_li/li_product_checkout',$r_cart);
			}else{
				$r_cart['ten_sanpham']=$r_cart['tieu_de'];
				$tamtinh += $r_cart['gia_moi'] * $_SESSION['cart'][$id_sp]['quantity'];
				foreach ($list_km as $kkk => $vvv) {
					if($vvv['kieu']=='all'){
						if($vvv['loai']=='phantram'){
							$ggg=($r_cart['gia_moi'] * $_SESSION['cart'][$id_sp]['quantity']/100)*$vvv['giam'];
							$list_giam[$kkk]+=ceil($ggg);
						}else{
							$list_giam[$kkk]+=$vvv['giam'];
						}
					}else{
						$tach_apdung=explode(',', $vvv['sanpham']);
						if(in_array($id_sp, $tach_apdung)==true){
							if($vvv['loai']=='phantram'){
								$ggg=($r_cart['gia_moi'] * $_SESSION['cart'][$id_sp]['quantity']/100)*$vvv['giam'];
								$list_giam[$kkk]+=ceil($ggg);
							}else{
								$list_giam[$kkk]+=$vvv['giam'];
							}
						}

					}
				}
				$r_cart['thanhtien'] = number_format($r_cart['gia_moi'] * $_SESSION['cart'][$id_sp]['quantity']);
				$r_cart['gia_moi'] = number_format($r_cart['gia_moi']);
				$r_cart['quantity'] = $_SESSION['cart'][$id_sp]['quantity'];
				$list_product.=$skin->skin_replace('skin_shop/'.$s.'/tpl/box_li/li_product_checkout',$r_cart);
			}
		}
		//$tongtien = number_format($total_price) . 'đ';
	}
	if(isset($_SESSION['coupon'])){
		if($r_coupon['total']==0){
			$giam=0;
			$coupon='';
		}else{
			if($r_coupon['expired']>time()){
				$ma_giam=$_SESSION['coupon'];
				$giam=$list_giam[$ma_giam];
				$coupon=$_SESSION['coupon'];

			}else{
				$giam=0;
				$coupon='';

			}
		}
	}else{
		$giam=0;
		$coupon='';
	}
	if($can_nang<=5){
		$phi_ship=28000;
		$tongtien = $tamtinh - $giam + $phi_ship;
	}else{
		$phi_ship=28000 + ($can_nang - 5)*6000;
		//$tongtien=$tamtinh - $giam + 25000;
		$tongtien=$tamtinh - $giam + $phi_ship;
	}
	if(isset($_SESSION['thanhtoan'])){
		$thanhtoan=$_SESSION['thanhtoan'];
	}else{
		$thanhtoan='cod';
	}
}
if($step==3){
	if(isset($_SESSION['ma_don'])){
		$thongtin_order=mysqli_query($conn,"SELECT * FROM donhang_shop WHERE ma_don='{$_SESSION['ma_don']}'");
		$r_order=mysqli_fetch_assoc($thongtin_order);
	}else{
		$thongbao="Giao dịch đã quá hạn để xem chi tiết.";
		$replace=array(
			'title'=>'Giao dịch đã quá hạn để xem chi tiết.',
			'thongbao'=>$thongbao,
			'link'=>'/'
		);
		echo $skin->skin_replace('skin_shop/'.$s.'/tpl/chuyenhuong',$replace);
		exit();
	}
}
foreach ($list_giam as $key => $value) {
	$r_g['ma']=$key;
	$r_g['giam']=number_format($value);
	$list_ma_giam.=$skin->skin_replace('skin_shop/'.$s.'/tpl/box_li/li_giam',$r_g);
}
if(strlen($list_ma_giam)<10){
	$box_ma_giam='';
}else{
	$box_ma_giam=$skin->skin_normal('skin_shop/'.$s.'/tpl/box_ma_giam');
}
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
	'box_ma_giam'=>$box_ma_giam,
	'list_category_sub'=>$list_category_sub,
	'footer'=>$skin->skin_normal('skin_shop/'.$s.'/tpl/footer'),
	'script_footer'=>$skin->skin_normal('skin_shop/'.$s.'/tpl/script_footer'),
	'title'=>'Giỏ hàng',
	'description'=>$index_setting['description'],
	'site_name'=>$index_setting['site_name'],
	'limit'=>$limit,
	'logo'=>$index_setting['logo'],
	'text_footer'=>$index_setting['text_footer'],
	'google_analytics'=>$google_analytics,
	'script_chat'=>$script_chat,
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
	'lienhe'=>$index_setting['lienhe'],
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
	'shop'=>$r_shop['user_id'],
	'box_banner' => $skin->skin_normal('skin_shop/' . $s . '/tpl/box_banner'),
	'noidung_header' => $_SESSION['noidung_header'], // Ghi đè giá trị của noidung_header
	);
if($step==2){
	echo $skin->skin_replace('skin_shop/'.$s.'/tpl/checkout_step_2',$replace);
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
	foreach ($tach_sanpham as $key => $value) {
		$list_product.=$skin->skin_replace('skin_shop/'.$s.'/tpl/box_li/li_product_checkout_step_3',$value);
	}
	if($r_order['phi_ship']>0){
		$replace['phi_ship']=number_format($r_order['phi_ship']).'đ';
	}else{
		$replace['phi_ship']='Miễn phí';
	}
	$replace['list_product']=$list_product;
	$replace['tamtinh']=number_format($r_order['tamtinh']);
	$replace['tongtien']=number_format($r_order['tongtien']);
	$replace['giam']=number_format($r_order['giam']);
	
	echo $skin->skin_replace('skin_shop/'.$s.'/tpl/checkout_step_3',$replace);
}else{
	echo $skin->skin_replace('skin_shop/'.$s.'/tpl/checkout_step_1',$replace);
}
?>