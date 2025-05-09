<?php
$web=$_SERVER['HTTP_HOST'];
$web=str_replace('www.', '', $web);
$web_root=array('doantotnghiep.vn','socdo.vn');
if(in_array($web, $web_root)==false){
	include('./shop/addon_deal.php');
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
$id=intval($url_query['id']);
$thongtin=mysqli_query($conn,"SELECT *,count(*) AS total FROM sanpham WHERE id='$id' ORDER BY id DESC LIMIT 1");
$r_tt=mysqli_fetch_assoc($thongtin);
if($r_tt['total']==0){
	$thongbao="Dữ liệu không tồn tại.";
	$replace=array(
		'title'=>'Dữ liệu không tồn tại',
		'thongbao'=>$thongbao,
		'link'=>'/'
	);
	echo $skin->skin_replace('skin/chuyenhuong',$replace);
	exit();
}
if(strlen($r_tt['anh'])>3){
	$tach_anh=explode(",", $r_tt['anh']);
	$im=0;
	foreach ($tach_anh as $key => $value) {
		$im++;
		if($im==1){
			$img_big='<a href="'.$value.'" onclick="return:false;"><img src="'.$value.'">';
		}
		$pt['src']=$value;
		$pt['tieu_de']=$r_tt['tieu_de'];
		$list_big.=$skin->skin_replace('skin/box_li/li_big',$pt);
	}
}
if(strlen($r_tt['thongtin'])>3){
	$tach_thongso=explode('|', $r_tt['thongtin']);
	foreach ($tach_thongso as $key => $value) {
		$tach_value=explode('&&', $value);
		$list_thongso.='<tr><td>'.$tach_value[0].'</td><td>'.$tach_value[1].'</td></tr>';
	}
}else{
	$list_thongso='<tr><td colspan="2">Đang cập nhật</td></tr>';
}
if($r_tt['mau']!=''){
	$mau=$r_tt['mau'];
	$thongtin_mau=mysqli_query($conn,"SELECT * FROM mau_sanpham WHERE id IN($mau) ORDER BY thu_tu ASC");
	$m=0;
	while($r_m=mysqli_fetch_assoc($thongtin_mau)){
		$m++;
		if($m==1){
			$list_mau.='<div class="li_mausac">
                            <input type="radio" name="mau" value="'.$r_m['id'].'" checked="checked" id="mau_'.$r_m['id'].'">
                            <label for="mau_'.$r_m['id'].'">
                                 '.$r_m['tieu_de'].'
                                <img class="img-check" src="/skin_shop/css/images/select-pro.png?v=508" alt="'.$r_m['tieu_de'].'">
                            </label>
                        </div>';

		}else{
			$list_mau.='<div class="li_mausac">
                            <input type="radio" name="mau" value="'.$r_m['id'].'" id="mau_'.$r_m['id'].'">
                            <label for="mau_'.$r_m['id'].'">
                                 '.$r_m['tieu_de'].'
                                <img class="img-check" src="/skin_shop/css/images/select-pro.png?v=508" alt="'.$r_m['tieu_de'].'">
                            </label>
                        </div>';
		}
	}
	$option_mau='<div class="box_select_mausac">
                    <label for="">Màu sắc</label>
                    <div class="list_mausac">
                    '.$list_mau.'
                    </div>
                </div>';
}else{
	$option_mau='';
}
if($r_tt['size']!=''){
	$size=$r_tt['size'];
	$thongtin_size=mysqli_query($conn,"SELECT * FROM kich_co WHERE id IN($size) ORDER BY thu_tu ASC");
	$ss=0;
	while($r_size=mysqli_fetch_assoc($thongtin_size)){
		$ss++;
		if($ss==1){
			$list_size.='<div class="li_mausac">
                            <input type="radio" name="size" value="'.$r_size['tieu_de'].'" checked="checked" id="size_'.$r_size['id'].'">
                            <label for="size_'.$r_size['id'].'">
                                 '.$r_size['tieu_de'].'
                                <img class="img-check" src="/skin_shop/css/images/select-pro.png?v=508" alt="Đỏ">
                            </label>
                        </div>';
		}else{
			$list_size.='<div class="li_mausac">
                            <input type="radio" name="size" value="'.$r_size['tieu_de'].'" id="size_'.$r_size['id'].'">
                            <label for="size_'.$r_size['id'].'">
                                 '.$r_size['tieu_de'].'
                                <img class="img-check" src="/skin_shop/css/images/select-pro.png?v=508" alt="Đỏ">
                            </label>
                        </div>';
		}
	}
	$option_size='<div class="box_select_mausac">
                    <label for="">Kích cỡ</label>
                    <div class="list_mausac">
                    '.$list_size.'
                    </div>
                </div>';
}else{
	$option_size='';
}
if($r_tt['kho']>0){
	$r_tt['tinh_trang']='Còn hàng';
	$disabled='';
	$text_button='Thêm vào giỏ hàng';
}else{
	$r_tt['tinh_trang']='Hết hàng';
	$disabled=' disabled';
	$text_button='Hết Hàng';
}
if($r_tt['kho']>50){
    $r_tt['text_flash_sale']='<div class="flashsale__label">còn lại <b class="flashsale__sold-qty">'.$r_tt['kho'].'</b> sản phẩm</div>';
}else{
    $r_tt['text_flash_sale']='<div class="flashsale__label">🔥 Sắp hết hàng</div>';
}
if($r_tt['gia_cu']>$r_tt['gia_moi']){
    $giam=ceil((($r_tt['gia_cu'] - $r_tt['gia_moi'])/$r_tt['gia_cu'])*100);
    $r_tt['label_sale']='<div class="label_product"><div class="label_wrapper">-'.$giam.'%</div></div>';
}else{
    $r_tt['label_sale']='';
}
$phantram=100 - ($r_tt['kho']/100)*100;
if($r_tt['thuong_hieu']!=''){
	$thongtin_thuonghieu=mysqli_query($conn,"SELECT * FROM thuong_hieu WHERE id='{$r_tt['thuong_hieu']}'");
	$r_th=mysqli_fetch_assoc($thongtin_thuonghieu);
	$thuong_hieu='<span class="first_status">Thương hiệu:<span class="status_name">
                        '.$r_th['tieu_de'].'
                    </span>
                    <span class="line">&nbsp;&nbsp;|&nbsp;&nbsp;</span>
                </span>';

}else{
	$thuong_hieu='';
}
$sp_id=$r_tt['id'];
if(!isset($_SESSION['daxem'][$sp_id])){
	$_SESSION['daxem'][$sp_id]=$sp_id;
}
$list_id=implode(",",$_SESSION['daxem']);
$view_new=$r_tt['view'] + 1;
mysqli_query($conn,"UPDATE sanpham SET view='$view_new' WHERE id='{$r_tt['id']}'");
$tach_menu=json_decode($class_index->list_menu($conn),true);
$tach_banner=json_decode($class_index->list_banner($conn),true);
$tach_list_category=json_decode($class_index->list_category($conn),true);
$link_xem=(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$hientai=time();
$thongtin_deal=mysqli_query($conn,"SELECT *,count(*) AS total FROM deal WHERE date_start<'$hientai' AND date_end>='$hientai' AND FIND_IN_SET($sp_id,main_product) ORDER BY id DESC LIMIT 1");
$r_deal=mysqli_fetch_assoc($thongtin_deal);
if($r_deal['total']>0){
	$box_deal_soc=$skin->skin_normal('skin/box_deal_soc');
	$sub_product=$r_deal['sub_id'];
	$tach_sub_product=json_decode($r_deal['sub_product'],true);
	$thongtin_sub_product=mysqli_query($conn,"SELECT * FROM sanpham WHERE id IN ($sub_product) ORDER BY id DESC");
	while($r_sub_product=mysqli_fetch_assoc($thongtin_sub_product)){
		$sp=$r_sub_product['id'];
		if($tach_sub_product[$sp]['gia']!=''){
			if($r_sub_product['gia_cu']>$tach_sub_product[$sp]['gia']){
			    $giam=ceil((($r_sub_product['gia_cu'] - $tach_sub_product[$sp]['gia'])/$r_sub_product['gia_cu'])*100);
			    $r_sub_product['label_sale']='<div class="label_product"><div class="label_wrapper">-'.$giam.'%</div></div>';
			}else{
			    $r_sub_product['label_sale']='';
			}
			$r_sub_product['thanhtien']=number_format($tach_sub_product[$sp]['gia']);
			$r_sub_product['gia_cu']=number_format($r_sub_product['gia_cu']);
			$r_sub_product['gia_moi']=number_format($tach_sub_product[$sp]['gia']);
		}else{
			$gioi_moi=$r_sub_product['gia_moi'] - ($r_sub_product['gia_moi']/100)*$tach_sub_product[$sp]['sale'];
			if($r_sub_product['gia_cu']>$gia_moi){
			    $giam=ceil((($r_sub_product['gia_cu'] - $gia_moi)/$r_sub_product['gia_cu'])*100);
			    $r_sub_product['label_sale']='<div class="label_product"><div class="label_wrapper">-'.$giam.'%</div></div>';
			}else{
			    $r_sub_product['label_sale']='';
			}
			$r_sub_product['gia_cu']=number_format($r_sub_product['gia_cu']);
			$r_sub_product['gia_moi']=number_format($gia_moi);
			$r_sub_product['thanhtien']=number_format($gia_moi);
		}
		$list_muakem.=$skin->skin_replace('skin/box_li/li_muakem_dealsoc',$r_sub_product);
	}
}else{
	$box_deal_soc='';
}
$list_danhmuc_top=json_decode($class_index->list_category_danhmuc_top($conn),true);
$replace=array(
	'header'=>$skin->skin_normal('skin/header'),
	'box_header'=>$box_header,
	'list_danhmuc' => $list_danhmuc_top['list_parent'],
	'list_danhmuc_sub' => $list_danhmuc_top['list_sub'],
	'box_deal_soc'=>$box_deal_soc,
	'footer'=>$skin->skin_normal('skin/footer'),
	'script_footer'=>$skin->skin_normal('skin/script_footer'),
	'mobile_menu'=>$mobile_menu,
	'title'=>$r_tt['title'],
	'description'=>$r_tt['description'],
	'site_name'=>$index_setting['site_name'],
	'limit'=>$limit,
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
	'list_category_mobile'=>$tach_list_category['list_mobile'],
	'lienhe'=>$index_setting['lienhe'],
	'photo'=>$index_setting['photo'],
	'phantrang'=>$phantrang,
	'fanpage'=>$index_setting['fanpage'],
	'name'=>$user_info['name'],
	'avatar'=>$user_info['avatar'],
	'gioithieu'=>$index_setting['gioithieu'],
	'tieu_de'=>$r_tt['tieu_de'],
	'noidung'=>$r_tt['noi_dung'],
	'list_big'=>$list_big,
	'img_big'=>$img_big,
	'list_thongso'=>$list_thongso,
	'option_mau'=>$option_mau,
	'option_size'=>$option_size,
	'text_button'=>$text_button,
	'disabled'=>$disabled,
	'tinh_trang'=>$r_tt['tinh_trang'],
	'thuong_hieu'=>$thuong_hieu,
	'gia_moi'=>number_format($r_tt['gia_moi']),
	'gia_cu'=>number_format($r_tt['gia_cu']),
	'noi_bat'=>$r_tt['noi_bat'],
	'text_flash_sale'=>$r_tt['text_flash_sale'],
	'phantram'=>$phantram,
	'sp_id'=>$r_tt['id'],
	'link'=>$r_tt['link'],
	'minh_hoa'=>$r_tt['minh_hoa'],
	'banner_top'=>$tach_banner['top'],
	'label_sale'=>$r_tt['label_sale'],
	'list_muakem'=>$list_muakem,
	'list_danhmuc_noibat_timkiem'=>$class_index->list_category_noibat_timkiem($conn), // chức năng tìm kiếm nâng cao
	'dropship'=>$user_info['dropship'],
	);
echo $skin->skin_replace('skin/addon_deal',$replace);
?>