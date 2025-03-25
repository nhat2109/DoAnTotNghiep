<?php
include('./includes/tlca_world.php');
$check=$tlca_do->load('class_check');
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
$thongtin_shop=mysqli_query($conn,"SELECT *,count(*) AS total FROM user_info WHERE domain='$web' ORDER BY user_id DESC LIMIT 1");
$r_shop=mysqli_fetch_assoc($thongtin_shop);
$shop=$r_shop['user_id'];
$brand=addslashes(strip_tags($url_query['brand']));
$color=addslashes(strip_tags($url_query['color']));
$price=addslashes(strip_tags($url_query['price']));
$size=addslashes(strip_tags($url_query['size']));
$sort=addslashes(strip_tags($url_query['sort']));
if(isset($url_query['sort'])){
	if($sort=='price-ascending'){
		$order='gia_moi ASC';
	}else if($sort=='price-descending'){
		$order='gia_moi DESC';
	}else if($sort=='title-ascending'){
		$order='tieu_de ASC';
	}else if($sort=='title-descending'){
		$order='tieu_de DESC';
	}else if($sort=='created-ascending'){
		$order='date_post ASC';
	}else if($sort=='created-descending'){
		$order='date_post DESC';
	}else if($sort=='best-selling'){
		$order='ban DESC';
	}else{
		$order='date_post DESC';
	}
}else{
	$order='date_post DESC';
	$sort='created-descending';
}
if(isset($url_query['color']) AND strpos($color, '*')!==false){
	$tach_color=explode('*', $color);
	$c=0;
	foreach ($tach_color as $key => $value) {
		$c++;
		if($c==1){
			$color_where.='(FIND_IN_SET('.$value.',mau)>0 OR ';
		}else if($c==count($tach_color)){
			$color_where.='FIND_IN_SET('.$value.',mau)>0) ';
		}else{
			$color_where.='FIND_IN_SET('.$value.',mau)>0 OR ';
		}
	}
}else if(isset($url_query['color'])){
	$color_where='FIND_IN_SET('.$color.',mau)>0';
}else{
	$color_where='';
}
if(isset($url_query['size']) AND strpos($size, '*')!==false){
	$tach_size=explode('*', $size);
	$s=0;
	foreach ($tach_size as $key => $value) {
		$s++;
		if($s==1){
			if($color_where!=''){
				$size_where.='AND (FIND_IN_SET('.$value.',size)>0 OR ';
			}else{
				$size_where.='(FIND_IN_SET('.$value.',size)>0 OR ';
			}
		}else if($s==count($tach_size)){
			$size_where.='FIND_IN_SET('.$value.',size)>0) ';
		}else{
			$size_where.='FIND_IN_SET('.$value.',size)>0 OR ';
		}
	}
}else if(isset($url_query['size'])){
	if($color_where!=''){
		$size_where='AND FIND_IN_SET('.$size.',size)>0';
	}else{
		$size_where='FIND_IN_SET('.$size.',size)>0';
	}
}else{
	$size_where='';
}
if(isset($url_query['brand']) AND strpos($brand, '*')!==false){
	$tach_brand=explode('*', $brand);
	$b=0;
	foreach ($tach_brand as $key => $value) {
		$b++;
		if($b==1){
			if($color_where!='' OR $size_where!=''){
				$brand_where.='AND (FIND_IN_SET('.$value.',thuong_hieu)>0 OR ';
			}else{
				$brand_where.='(FIND_IN_SET('.$value.',thuong_hieu)>0 OR ';
			}
		}else if($b==count($tach_brand)){
			$brand_where.='FIND_IN_SET('.$value.',thuong_hieu)>0) ';
		}else{
			$brand_where.='FIND_IN_SET('.$value.',thuong_hieu)>0 OR ';
		}
	}
}else if(isset($url_query['brand'])){
	if($color_where!='' OR $size_where!=''){
		$brand_where='AND FIND_IN_SET('.$brand.',thuong_hieu)>0';
	}else{
		$brand_where='FIND_IN_SET('.$brand.',thuong_hieu)>0';
	}
}else{
	$brand_where='';
}
if(isset($url_query['price']) AND strpos($price, '*')!==false){
	$tach_price=explode('*', $price);
	$p=0;
	foreach ($tach_price as $key => $value) {
		$p++;
		$tach_value=explode('-', $value);
		if($p==1){
			if($color_where!='' OR $size_where!='' OR $brand_where!=''){
				if($tach_value[0]==0){
					$max_price=$tach_value[1];
					$price_where.="AND (gia_moi<='".$max_price."' OR ";
				}else if($tach_value[1]==999999999999){
					$min_price=$tach_value[0];
					$price_where.="AND (gia_moi>='".$min_price."' OR ";
				}else{
					$min_price=$tach_value[0];
					$max_price=$tach_value[1];
					$price_where.="AND ((gia_moi>='".$min_price."' AND gia_moi<='".$max_price."') OR ";
				}					
			}else{
				if($tach_value[0]==0){
					$max_price=$tach_value[1];
					$price_where.="(gia_moi<='".$max_price."' OR ";
				}else if($tach_value[1]==999999999999){
					$min_price=$tach_value[0];
					$price_where.="(gia_moi>='".$min_price."' OR ";
				}else{
					$min_price=$tach_value[0];
					$max_price=$tach_value[1];
					$price_where.="((gia_moi>='".$min_price."' AND gia_moi<='".$max_price."') OR ";
				}
			}
		}else if($p==count($tach_price)){
			if($color_where!='' OR $size_where!='' OR $brand_where!=''){
				if($tach_value[0]==0){
					$max_price=$tach_value[1];
					$price_where.="gia_moi<='".$max_price."')";
				}else if($tach_value[1]==999999999999){
					$min_price=$tach_value[0];
					$price_where.="gia_moi>='".$min_price."')";
				}else{
					$min_price=$tach_value[0];
					$max_price=$tach_value[1];
					$price_where.="(gia_moi>='".$min_price."' AND gia_moi<='".$max_price."')) ";
				}					
			}else{
				if($tach_value[0]==0){
					$max_price=$tach_value[1];
					$price_where.="gia_moi<='".$max_price."')";
				}else if($tach_value[1]==999999999999){
					$min_price=$tach_value[0];
					$price_where.="gia_moi>='".$min_price."')";
				}else{
					$min_price=$tach_value[0];
					$max_price=$tach_value[1];
					$price_where.="(gia_moi>='".$min_price."' AND gia_moi<='".$max_price."')) ";
				}
			}
		}else{
			if($color_where!='' OR $size_where!='' OR $brand_where!=''){
				if($tach_value[0]==0){
					$max_price=$tach_value[1];
					$price_where.="gia_moi<='".$max_price."' OR ";
				}else if($tach_value[1]==999999999999){
					$min_price=$tach_value[0];
					$price_where.="gia_moi>='".$min_price."' OR";
				}else{
					$min_price=$tach_value[0];
					$max_price=$tach_value[1];
					$price_where.="(gia_moi>='".$min_price."' AND gia_moi<='".$max_price."') OR ";
				}					
			}else{
				if($tach_value[0]==0){
					$max_price=$tach_value[1];
					$price_where.="gia_moi<='".$max_price."' OR ";
				}else if($tach_value[1]==999999999999){
					$min_price=$tach_value[0];
					$price_where.="gia_moi>='".$min_price."' OR ";
				}else{
					$min_price=$tach_value[0];
					$max_price=$tach_value[1];
					$price_where.="(gia_moi>='".$min_price."' AND gia_moi<='".$max_price."') OR ";
				}
			}
		}
	}
}else if(isset($url_query['price'])){
	$tach_price=explode('-', $price);
	if($color_where!='' OR $size_where!='' OR $brand_where!=''){
		if($tach_price[0]==0){
			$max_price=$tach_price[1];
			$price_where="AND gia_moi<='".$max_price."'";
		}else if($tach_price[1]==999999999999){
			$min_price=$tach_price[0];
			$price_where="AND gia_moi>='".$min_price."'";
		}else{
			$min_price=$tach_price[0];
			$max_price=$tach_price[1];
			$price_where="AND gia_moi>='".$min_price."' AND gia_moi<='".$max_price."'";
		}
	}else{
		if($tach_price[0]==0){
			$max_price=$tach_price[1];
			$price_where="gia_moi<='".$max_price."'";
		}else if($tach_price[1]==999999999999){
			$min_price=$tach_price[0];
			$price_where="gia_moi>='".$min_price."'";
		}else{
			$min_price=$tach_price[0];
			$max_price=$tach_price[1];
			$price_where="gia_moi>='".$min_price."' AND gia_moi<='".$max_price."'";
		}
	}
}else{
	$price_where='';
}
$limit=40;

$thongtin_shop=mysqli_query($conn,"SELECT * FROM user_info WHERE domain='$web' ORDER BY user_id DESC LIMIT 1");
$r_shop=mysqli_fetch_assoc($thongtin_shop);
$setting=mysqli_query($conn,"SELECT * FROM shop_setting WHERE shop='{$r_shop['user_id']}' ORDER BY name ASC");
while ($r_s=mysqli_fetch_assoc($setting)) {
	$index_setting[$r_s['name']]=$r_s['value'];
}
$total_setting=mysqli_num_rows($setting);
if($total_setting<1){
	$ref=$_SERVER["HTTP_REFERER"];
	if(strpos($ref, '/dropship')!==false){
		$link_re='https://socdo.vn/dropship/list-giaodien';
	}else{
		$link_re='https://socdo.vn';
	}
	$thongbao="Gian hàng chưa thiết lập giao diện.";
	$replace=array(
		'title'=>'Gian hàng chưa thiết lập giao diện',
		'thongbao'=>$thongbao,
		'link'=>$link_re
	);
	echo $skin->skin_replace('skin_shop/skin_1/tpl/chuyenhuong',$replace);
	exit();	
}
$s=$index_setting['skin_folder'];
include('skin_shop/'.$s.'/sanpham_category.php');
?>