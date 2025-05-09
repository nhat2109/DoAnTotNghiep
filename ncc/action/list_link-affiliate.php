<?php
	$thaythe['title'] = 'Danh sách link affiliate';
	$thaythe['title_action'] = 'Danh sách link affiliate';
	$limit = 50;
	$brand=addslashes(strip_tags($url_query['brand']));
	$sort=addslashes(strip_tags($url_query['sort']));
	$cat=addslashes(strip_tags($url_query['cat']));
	$key=addslashes(strip_tags($url_query['key']));
	if($brand==''){
		$where_brand='';
	}else{
		$where_brand="thuong_hieu='$brand'";
	}
	if($cat==''){
		$where_cat='';
	}else{
		if($where_brand==''){
			$where_cat=" FIND_IN_SET($cat,cat)>0";
		}else{
			$where_cat=" AND FIND_IN_SET($cat,cat)>0";
		}
	}
	if($key==''){
		$where_key='';
	}else{
		if($where_brand!='' OR $where_cat!=''){
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
		}else{
			if(strpos($key, ' ')==false){
				$where_key=" tieu_de LIKE '%$key%'";
			}else{
				$tach_key=explode(' ', $key);
				$u=0;
				foreach ($tach_key as $k => $v) {
					if($v==''){
					}else{
						$u++;
						if($u==1){
							$where_key.=" tieu_de LIKE '%$v%'";
						}else{
							$where_key.=" AND tieu_de LIKE '%$v%'";
						}
					}
				}
			}

		}
	}
	$link_hientai=$_SERVER['REQUEST_URI'];
	if($brand!='' OR $cat!='' OR $key!=''){
		$thongke = mysqli_query($conn, "SELECT *, count(*) AS total FROM sanpham WHERE ".$where_brand." ".$where_cat."".$where_key." ORDER BY id DESC");
	}else{
		$thongke = mysqli_query($conn, "SELECT *, count(*) AS total FROM sanpham ORDER BY id DESC");
	}
	$r_tk = mysqli_fetch_assoc($thongke);
	$total_page = ceil($r_tk['total'] / $limit);
	if(strpos($link_hientai, '?')!==false AND strpos($link_hientai, '?page=')==false){
		$link_phantrang=str_replace('&page='.$page, '', $link_hientai);
		$phantrang=$class_index->phantrang_timkiem($page, $total_page, $link_phantrang);
	}else{
		$sort='time-desc';
		$link_phantrang='/ncc/list-link-affiliate';
		$phantrang=$class_index->phantrang($page, $total_page, $link_phantrang);
	}
	$r_tt['option_thuonghieu'] = $class_index->list_option_brand($conn, 0, $brand);
	$r_tt['list_banner_qc'] = $class_index->list_banner_qc($conn, 5);
	$r_tt['option_category'] = $class_index->list_option_danhmuc($conn, $cat);
	$r_tt['phantrang'] = $phantrang;
	$thaythe['title_action'] = 'Nhà cung cấp nổi bật';
	if($check->is_mobile()==true){
		$r_tt['list_sanpham'] = $class_index->list_link_affiliate($conn,$user_id,'mobile',$brand,$cat,$key,$sort, $page, $limit);
		$thaythe['box_right'] = $skin->skin_replace('skin_ncc/box_action/list_link_affiliate_mobile', $r_tt);
	}else{
		$r_tt['list_sanpham'] = $class_index->list_link_affiliate($conn,$user_id,'laptop',$brand,$cat,$key,$sort, $page, $limit);
		$thaythe['box_right'] = $skin->skin_replace('skin_ncc/box_action/list_link_affiliate', $r_tt);
	}
?>