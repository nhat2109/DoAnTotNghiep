<?php
	$thaythe['title'] = 'Thêm đơn hàng mới';
	$step = $url_query['step'];
	$step = addslashes(strip_tags($step));
	if ($step == 2) {
		$thaythe['title_action'] = 'Thêm đơn hàng mới';
		$list_id='';
		foreach ($_SESSION['drop_cart'] as $key => $value) {
			if (intval($key) > 0) {
				$list_id .= $key . ',';
			}
			if (intval($value['pl']) > 0) {
				$list_pl .= $value['pl'] . ',';
			}
		}
		if($list_id==''){

		}else{
			$list_id = substr($list_id, 0, -1);
		}
		if($list_pl==''){

		}else{
			$list_pl = substr($list_pl, 0, -1);
		}
		if($list_id==''){
			$thongbao = "Không có sản phẩm nào trong giỏ hàng...";
			$replace = array(
				'title' => 'Không có sản phẩm nào trong giỏ hàng...',
				'description' => $index_setting['description'],
				'thongbao' => $thongbao,
				'link_chuyen' => '/ncc/add-donhang-drop',
			);
			echo $skin->skin_replace('skin_ncc/chuyenhuong', $replace);
			exit();
		}
		$thongtin_phanloai=mysqli_query($conn, "SELECT * FROM phanloai_sanpham WHERE sp_id IN ($list_id) AND id IN ($list_pl) ORDER BY FIELD(id,$list_pl)");
		$product_pl=array();
		while($r_pl=mysqli_fetch_assoc($thongtin_phanloai)){
			$sp_pl=$r_pl['sp_id'];
			$product_pl[$sp_pl]['gia_cu']=$r_pl['gia_cu'];
			$product_pl[$sp_pl]['gia_moi']=$r_pl['gia_moi'];
			$product_pl[$sp_pl]['gia_drop']=$r_pl['gia_drop'];
			$product_pl[$sp_pl]['gia_ncc']=$r_pl['gia_ncc'];
			$product_pl[$sp_pl]['drop_min']=$r_pl['drop_min'];
			$product_pl[$sp_pl]['color']=$r_pl['color'];
			$product_pl[$sp_pl]['size']=$r_pl['size'];
		}
		$thongtin_cart = mysqli_query($conn, "SELECT * FROM sanpham WHERE id IN ($list_id) ORDER BY FIELD(id,$list_id)");
		while ($r_cart = mysqli_fetch_assoc($thongtin_cart)) {
			$id_sp = $r_cart['id'];
			$kho = $_SESSION['drop_cart'][$id_sp]['kho'];
			//if($_SESSION['drop_cart'][$id_sp]['quantity']<=$r_cart[$kho]){
			if($user_info['leader']==1 OR $user_info['gia_leader']==1){
				$total_price += $product_pl[$id_sp]['gia_drop'] * $_SESSION['drop_cart'][$id_sp]['quantity'];
				$r_cart['thanhtien'] = number_format($product_pl[$id_sp]['gia_drop'] * $_SESSION['drop_cart'][$id_sp]['quantity']);
				$r_cart['gia_nhap'] = number_format($product_pl[$id_sp]['gia_drop']);
			}else{
				$total_price += $product_pl[$id_sp]['gia_ncc'] * $_SESSION['drop_cart'][$id_sp]['quantity'];
				$r_cart['thanhtien'] = number_format($product_pl[$id_sp]['gia_ncc'] * $_SESSION['drop_cart'][$id_sp]['quantity']);
				$r_cart['gia_nhap'] = number_format($product_pl[$id_sp]['gia_ncc']);
			}
			$r_cart['quantity'] = $_SESSION['drop_cart'][$id_sp]['quantity'];
			$color = $_SESSION['drop_cart'][$id_sp]['color'];
			$size = $_SESSION['drop_cart'][$id_sp]['size'];
			$list_id_color=array();
			$list_id_size=array();
			$r_cart['list_size']='';
			$r_cart['list_color']='';
			if($size==''){
				$r_cart['list_size']='';
			}else{
				$thongtin_phanloai = mysqli_query($conn, "SELECT * FROM phanloai_sanpham WHERE sp_id='$id_sp' ORDER BY id ASC");
				$m = 0;
				while ($r_pl = mysqli_fetch_assoc($thongtin_phanloai)) {
					$m++;
					if ($r_pl['size'] == $_SESSION['drop_cart'][$id_sp]['size']) {
						if(in_array($r_pl['size'], $list_id_size)==false){
							$list_id_size[].=$r_pl['size'];
							if($user_info['leader']==1 OR $user_info['gia_leader']==1){
								$list_size .= '<option value="'.$r_pl['size'].'" gia="'.$r_pl['gia_drop'].'" selected>'.$r_pl['ten_size'].'</option>';
							}else{
								$list_size .= '<option value="'.$r_pl['size'].'"  gia="'.$r_pl['gia_ncc'].'" selected>'.$r_pl['ten_size'].'</option>';
							}
						}
						if($color==$r_pl['color']){
							if(in_array($r_pl['color'], $list_id_color)==false){
								$list_id_color[].=$r_pl['color'];
								$list_color.='<option value="'.$r_pl['color'].'" pl="'.$r_pl['id'].'" selected>'.$r_pl['ten_color'].'</option>';
							}
						}else{
							if(in_array($r_pl['color'], $list_id_color)==false){
								$list_id_color[].=$r_pl['color'];
								$list_color.='<option value="'.$r_pl['color'].'" pl="'.$r_pl['id'].'">'.$r_pl['ten_color'].'</option>';
							}	
						}
					} else {
						if(in_array($r_pl['size'], $list_id_size)==false){
							$list_id_size[].=$r_pl['size'];
							if($user_info['leader']==1 OR $user_info['gia_leader']==1){
								$list_size .= '<option value="'.$r_pl['size'].'" gia="'.$r_pl['gia_drop'].'">'.$r_pl['ten_size'].'</option>';
							}else{
								$list_size .= '<option value="'.$r_pl['size'].'" gia="'.$r_pl['gia_ncc'].'">'.$r_pl['ten_size'].'</option>';
							}
						}
					}
				}
				$r_cart['list_size'] = '<select name="size[]" sp_id="'.$id_sp.'">'.$list_size.'</select>';
				unset($list_size);
				$r_cart['list_color'] = '<select name="color[]" sp_id="'.$id_sp.'">'.$list_color.'</select>';
				unset($list_color);
			}
			$list_shopcart .= $skin->skin_replace('skin_ncc/box_action/li_shopcart', $r_cart);
			unset($list_id_color);
			unset($list_id_size);

			//}else{

			//}
		}
		$r_tt['total_cart'] = count($_SESSION['drop_cart']);
		$r_tt['list_sanpham'] = $list_shopcart;
		$total_price = number_format($total_price) . 'đ';
		$r_tt['total_price'] = $total_price;
		$r_tt['option_thuonghieu'] = $class_index->list_option_brand($conn, 0, '');
		$r_tt['list_banner_qc'] = $class_index->list_banner_qc($conn, 5);
		$thaythe['box_right'] = $skin->skin_replace('skin_ncc/box_action/add_donhang_drop_step2', $r_tt);
	} else if ($step == 3) {
		$type = $url_query['type'];
		if($type=='gopdon'){
			if(isset($_SESSION['don'])){
				unset($_SESSION['don']);
			}
		}
		$thaythe['title_action'] = 'Thêm đơn hàng mới';
		$list_id='';
		$list_pl='';
		foreach ($_SESSION['drop_cart'] as $key => $value) {
			if (intval($key) > 0) {
				$list_id .= $key . ',';
			}
			if (intval($value['pl']) > 0) {
				$list_pl .= $value['pl'] . ',';
			}
		}
		if($list_id==''){
			$thongbao = "Không có sản phẩm nào trong giỏ hàng...";
			$replace = array(
				'title' => 'Không có sản phẩm nào trong giỏ hàng...',
				'description' => $index_setting['description'],
				'thongbao' => $thongbao,
				'link_chuyen' => '/ncc/add-donhang-drop',
			);
			echo $skin->skin_replace('skin_ncc/chuyenhuong', $replace);
			exit();
		}
		$list_id = substr($list_id, 0, -1);
		$list_pl = substr($list_pl, 0, -1);
		$thongtin_phanloai=mysqli_query($conn, "SELECT * FROM phanloai_sanpham WHERE sp_id IN ($list_id) AND id IN ($list_pl) ORDER BY FIELD(id,$list_pl)");
		$product_pl=array();
		while($r_pl=mysqli_fetch_assoc($thongtin_phanloai)){
			$sp_pl=$r_pl['sp_id'];
			$product_pl[$sp_pl]['gia_cu']=$r_pl['gia_cu'];
			$product_pl[$sp_pl]['gia_moi']=$r_pl['gia_moi'];
			$product_pl[$sp_pl]['gia_drop']=$r_pl['gia_drop'];
			$product_pl[$sp_pl]['gia_ncc']=$r_pl['gia_ncc'];
			$product_pl[$sp_pl]['drop_min']=$r_pl['drop_min'];
			$product_pl[$sp_pl]['color']=$r_pl['color'];
			$product_pl[$sp_pl]['size']=$r_pl['size'];
			$product_pl[$sp_pl]['ten_color']=$r_pl['ten_color'];
			$product_pl[$sp_pl]['ten_size']=$r_pl['ten_size'];
		}
		if($user_info['leader']==1 OR $user_info['gia_leader']==1){
			$thongtin_cart = mysqli_query($conn, "SELECT * FROM sanpham WHERE id IN ($list_id) ORDER BY gia_drop DESC");
		}else{
			$thongtin_cart = mysqli_query($conn, "SELECT * FROM sanpham WHERE id IN ($list_id) ORDER BY gia_ncc DESC");
		}
		$sp_g=0;
		while ($r_cart = mysqli_fetch_assoc($thongtin_cart)) {
			$id_sp = $r_cart['id'];
			$color = $_SESSION['drop_cart'][$id_sp]['color'];
			$size = $_SESSION['drop_cart'][$id_sp]['size'];
			$list_id_color=array();
			$list_id_size=array();
			$r_cart['list_size']='';
			$r_cart['list_color']='';
			if($size==''){
				$r_cart['list_size']='';
			}else{
				$thongtin_phanloai = mysqli_query($conn, "SELECT * FROM phanloai_sanpham WHERE sp_id='$id_sp' ORDER BY id ASC");
				$m = 0;
				while ($r_pl = mysqli_fetch_assoc($thongtin_phanloai)) {
					$m++;
					if ($r_pl['size'] == $_SESSION['drop_cart'][$id_sp]['size']) {
						if(in_array($r_pl['size'], $list_id_size)==false){
							$list_id_size[].=$r_pl['size'];
							if($user_info['leader']==1 OR $user_info['gia_leader']==1){
								$list_size .= '<option value="'.$r_pl['size'].'" gia="'.$r_pl['gia_drop'].'" selected>'.$r_pl['ten_size'].'</option>';
							}else{
								$list_size .= '<option value="'.$r_pl['size'].'"  gia="'.$r_pl['gia_ncc'].'" selected>'.$r_pl['ten_size'].'</option>';
							}
						}
						if($color==$r_pl['color']){
							if(in_array($r_pl['color'], $list_id_color)==false){
								$list_id_color[].=$r_pl['color'];
								$list_color.='<option value="'.$r_pl['color'].'" pl="'.$r_pl['id'].'" selected>'.$r_pl['ten_color'].'</option>';
							}
						}else{
							if(in_array($r_pl['color'], $list_id_color)==false){
								$list_id_color[].=$r_pl['color'];
								$list_color.='<option value="'.$r_pl['color'].'" pl="'.$r_pl['id'].'">'.$r_pl['ten_color'].'</option>';
							}	
						}
					} else {
						if(in_array($r_pl['size'], $list_id_size)==false){
							$list_id_size[].=$r_pl['size'];
							if($user_info['leader']==1 OR $user_info['gia_leader']==1){
								$list_size .= '<option value="'.$r_pl['size'].'" gia="'.$r_pl['gia_drop'].'">'.$r_pl['ten_size'].'</option>';
							}else{
								$list_size .= '<option value="'.$r_pl['size'].'" gia="'.$r_pl['gia_ncc'].'">'.$r_pl['ten_size'].'</option>';
							}
						}
					}
				}
				$r_cart['list_size'] = '<select name="size[]" sp_id="'.$id_sp.'">'.$list_size.'</select>';
				unset($list_size);
				$r_cart['list_color'] = '<select name="color[]" sp_id="'.$id_sp.'">'.$list_color.'</select>';
				unset($list_color);
			}
			unset($list_id_color);
			unset($list_id_size);
			if($type=='gopdon'){
				for ($i=0; $i < $_SESSION['drop_cart'][$id_sp]['quantity']; $i++) { 
					$sp_g++;
					if($sp_g==1){
						$giam_g=0;
					}else if($sp_g==2){
						$giam_g=0;
					}else if($sp_g==3){
						$giam_g=2;
					}else if($sp_g==4){
						$giam_g=3;
					}else if($sp_g==5){
						$giam_g=5;
					}else{
						$giam_g=0;
					}
					$r_cart['i']=$sp_g;
					$r_cart['giam']=$giam_g;
					if($user_info['leader']==1 OR $user_info['gia_leader']==1){
						//$total_price += $r_cart['gia_drop'] * 1;
						$total_gia_ban += $r_cart['gia_moi'] * 1;
						$thanhtien = $product_pl[$id_sp]['gia_drop'] * 1;
						$thanhtien_gop = $thanhtien - ($thanhtien/100)*$giam_g;
						$total_price += $thanhtien - ($thanhtien/100)*$giam_g;
						$r_cart['thanhtien']=number_format($thanhtien);
						$r_cart['thanhtien_gop']=number_format($thanhtien_gop);
						$r_cart['gia_nhap'] = number_format($product_pl[$id_sp]['gia_drop']);
					}else{
						//$total_price += $r_cart['gia_ncc'] * 1;
						$total_gia_ban += $r_cart['gia_moi'] * 1;
						$thanhtien = $product_pl[$id_sp]['gia_ncc'] * 1;
						$thanhtien_gop=$thanhtien - ($thanhtien/100)*$giam_g;
						$total_price += $thanhtien - ($thanhtien/100)*$giam_g;
						$r_cart['thanhtien']=number_format($thanhtien);
						$r_cart['thanhtien_gop']=number_format($thanhtien_gop);
						$r_cart['gia_nhap'] = number_format($product_pl[$id_sp]['gia_ncc']);				
					}
					if($product_pl[$id_sp]['ten_size']==''){
						$r_cart['ten_size']='';
					}else{
						$r_cart['ten_size']='<div class="size">'.$product_pl[$id_sp]['ten_size'].'</div>';
					}
					if($product_pl[$id_sp]['ten_color']==''){
						$r_cart['ten_color']='';
					}else{
						$r_cart['ten_color']='<div class="color">'.$product_pl[$id_sp]['ten_color'].'</div>';
					}
					$r_cart['quantity'] = $_SESSION['drop_cart'][$id_sp]['quantity'];
					if($sp_g<3){
						$list_shopcart .= $skin->skin_replace('skin_ncc/box_action/li_shopcart_gopdon_no_right', $r_cart);
					}else if($sp_g<=5){
						$list_shopcart .= $skin->skin_replace('skin_ncc/box_action/li_shopcart_gopdon_right', $r_cart);
					}else{
						$list_shopcart .= $skin->skin_replace('skin_ncc/box_action/li_shopcart_gopdon_no_right', $r_cart);
					}
					
				}
			}else{
				if($user_info['leader']==1 OR $user_info['gia_leader']==1){
					$total_price += $product_pl[$id_sp]['gia_drop'] * $_SESSION['drop_cart'][$id_sp]['quantity'];
					$total_gia_ban += $product_pl[$id_sp]['gia_moi'] * $_SESSION['drop_cart'][$id_sp]['quantity'];
					$r_cart['thanhtien'] = number_format($product_pl[$id_sp]['gia_drop'] * $_SESSION['drop_cart'][$id_sp]['quantity']);
					$r_cart['gia_nhap'] = number_format($product_pl[$id_sp]['gia_drop']);
				}else{
					$total_price += $product_pl[$id_sp]['gia_ncc'] * $_SESSION['drop_cart'][$id_sp]['quantity'];
					$total_gia_ban += $product_pl[$id_sp]['gia_moi'] * $_SESSION['drop_cart'][$id_sp]['quantity'];
					$r_cart['thanhtien'] = number_format($product_pl[$id_sp]['gia_ncc'] * $_SESSION['drop_cart'][$id_sp]['quantity']);
					$r_cart['gia_nhap'] = number_format($product_pl[$id_sp]['gia_ncc']);				
				}
				if($product_pl[$id_sp]['ten_size']==''){
					$r_cart['ten_size']='';
				}else{
					$r_cart['ten_size']='<div class="size">'.$product_pl[$id_sp]['ten_size'].'</div>';
				}
				if($product_pl[$id_sp]['ten_color']==''){
					$r_cart['ten_color']='';
				}else{
					$r_cart['ten_color']='<div class="color">'.$product_pl[$id_sp]['ten_color'].'</div>';
				}
				$r_cart['quantity'] = $_SESSION['drop_cart'][$id_sp]['quantity'];
				$list_shopcart .= $skin->skin_replace('skin_ncc/box_action/li_shopcart_right', $r_cart);
			}
		}
		$phi_ship = 0;
		$total_price = $total_price + $phi_ship;
		$r_tt['total_cart'] = count($_SESSION['drop_cart']);
		$r_tt['list_sanpham'] = $list_shopcart;
		$total_price_text=$total_price;
		$total_price = number_format($total_price) . 'đ';
		$r_tt['total_price'] = $total_price;
		$r_tt['total_price_text']=$total_price_text;
		$r_tt['cod']=number_format($total_gia_ban);
		$r_tt['phi_ship']=$phi_ship;
		$r_tt['phi_ship_text']=number_format($phi_ship).'đ';
		$r_tt['option_tinh'] = $class_viettel->option_tinh('');
		if($type=='san'){
			$thaythe['box_right'] = $skin->skin_replace('skin_ncc/box_action/add_donhang_drop_step3', $r_tt);
		}else if($type=='gopdon'){
			$thaythe['box_right'] = $skin->skin_replace('skin_ncc/box_action/add_donhang_gopdon_step3', $r_tt);
		}else{
			$thaythe['box_right'] = $skin->skin_replace('skin_ncc/box_action/add_donhang_ncc_step3', $r_tt);
		}
	} else {
		$brand=addslashes(strip_tags($url_query['brand']));
		$sort=addslashes(strip_tags($url_query['sort']));
		$cat=addslashes(strip_tags($url_query['cat']));
		$key=addslashes(strip_tags($url_query['key']));
		if($brand==''){
			$where_brand='';
		}else{
			$where_brand=" AND thuong_hieu='$brand'";
		}
		if($cat==''){
			$where_cat='';
		}else{
			$where_cat=" AND FIND_IN_SET($cat,cat)>0";
		}
		if($key==''){
			$where_key='';
		}else{
			if(strpos($key, ' ')==false){
				$where_key=" AND tieu_de LIKE '%$key%'";
			}else{
				$tach_key=explode(' ', $key);
				foreach ($tach_key as $k => $v) {
					if($v==''){
					}else{
						$where_key.=" AND tieu_de LIKE '%$v%'";
					}
				}
			}
		}
		$link_hientai=$_SERVER['REQUEST_URI'];
		if (isset($_COOKIE['drop_kho'])) {
			$kho = addslashes(strip_tags($_COOKIE['drop_kho']));
		} else {
			$kho = 'kho';
		}
		$r_tt['total_cart'] = count((array)$_SESSION['drop_cart']);
		$limit = 50;
		$thongke = mysqli_query($conn, "SELECT *, count(*) AS total FROM sanpham WHERE (noi_ban LIKE '%drop%' OR noi_ban LIKE '%all%') AND kho>'0' $where_brand $where_cat $where_key  ORDER BY id DESC");
		$r_tk = mysqli_fetch_assoc($thongke);
		$total_page = ceil($r_tk['total'] / $limit);
		if(strpos($link_hientai, '?')!==false AND strpos($link_hientai, '?page=')==false){
			$link_phantrang=str_replace('&page='.$page, '', $link_hientai);
			$phantrang=$class_index->phantrang_timkiem($page, $total_page, $link_phantrang);
		}else{
			$sort='time-desc';
			$link_phantrang='/ncc/add-donhang-drop';
			$phantrang=$class_index->phantrang($page, $total_page, $link_phantrang);
		}
		$r_tt['option_thuonghieu'] = $class_index->list_option_brand($conn, 0, $brand);
		$r_tt['list_banner_qc'] = $class_index->list_banner_qc($conn, 5);
		$r_tt['option_category'] = $class_index->list_option_danhmuc($conn, $cat);
		$r_tt['phantrang'] = $phantrang;
		$thaythe['title_action'] = 'Nhà cung cấp nổi bật';
		$thongtin_follow=mysqli_query($conn,"SELECT * FROM sanpham_follow WHERE user_id='$user_id'");
		$total_follow=mysqli_num_rows($thongtin_follow);
		if($total_follow==0){
			$list_follow='';
		}else{
			$r_fl=mysqli_fetch_assoc($thongtin_follow);
			$list_follow=$r_fl['sanpham'];
		}
		if($check->is_mobile()==true){
			$r_tt['list_sanpham'] = $class_index->list_sanpham_drop($conn,$user_id,$list_follow,$user_info['leader'],$user_info['gia_leader'],'mobile', $kho,$brand,$cat,$key,$sort, $page, $limit);
			$thaythe['box_right'] = $skin->skin_replace('skin_ncc/box_action/add_donhang_drop_step1_mobile', $r_tt);
		}else{
			$r_tt['list_sanpham'] = $class_index->list_sanpham_drop($conn,$user_id,$list_follow,$user_info['leader'],$user_info['gia_leader'],'laptop', $kho,$brand,$cat,$key,$sort, $page, $limit);
			$thaythe['box_right'] = $skin->skin_replace('skin_ncc/box_action/add_donhang_drop_step1', $r_tt);
		}
	}
?>