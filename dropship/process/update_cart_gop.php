<?php
	$don=intval($_REQUEST['don']);
	$sp_id=intval($_REQUEST['sp_id']);
	$sl=intval($_REQUEST['sl']);
	$stt=intval($_REQUEST['stt']);
	if(isset($_SESSION['don'])){
		$_SESSION['don'][$don][$stt]=$sp_id;
		foreach ($_SESSION['don'] as $key => $value) {
			foreach ($value as $k => $v) {
				if($v==$sp_id AND $key!=$don){
					unset($_SESSION['don'][$key][$stt]);
				}
			}
		}
	}else{
		$_SESSION['don'][$don][$stt]=$sp_id;
	}
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
		$list_pl = substr($list_pl, 0, -1);
		$thongtin_phanloai=mysqli_query($conn, "SELECT * FROM phanloai_sanpham WHERE sp_id IN ($list_id) AND id IN ($list_pl) ORDER BY FIELD(id,$list_pl)");
		$product_pl=array();
		while($r_pl=mysqli_fetch_assoc($thongtin_phanloai)){
			$sp_pl=$r_pl['sp_id'];
			$product_pl[$sp_pl]['gia_cu']=$r_pl['gia_cu'];
			$product_pl[$sp_pl]['gia_moi']=$r_pl['gia_moi'];
			$product_pl[$sp_pl]['gia_drop']=$r_pl['gia_drop'];
			$product_pl[$sp_pl]['gia_ctv']=$r_pl['gia_ctv'];
			$product_pl[$sp_pl]['drop_min']=$r_pl['drop_min'];
			$product_pl[$sp_pl]['color']=$r_pl['color'];
			$product_pl[$sp_pl]['size']=$r_pl['size'];
			$product_pl[$sp_pl]['can_nang']=$r_pl['can_nang'];
			$product_pl[$sp_pl]['ten_color']=$r_pl['ten_color'];
			$product_pl[$sp_pl]['ten_size']=$r_pl['ten_size'];
		}
		if($user_info['leader']==1 OR $user_info['gia_leader']==1){
			$thongtin_cart = mysqli_query($conn, "SELECT * FROM sanpham WHERE id IN ($list_id) ORDER BY gia_drop DESC");
		}else{
			$thongtin_cart = mysqli_query($conn, "SELECT * FROM sanpham WHERE id IN ($list_id) ORDER BY gia_ctv DESC");
		}
		$sp_g=0;
		while ($r_cart = mysqli_fetch_assoc($thongtin_cart)) {
			$id_sp = $r_cart['id'];
			for ($i=1; $i <= $_SESSION['drop_cart'][$id_sp]['quantity']; $i++) { 
				$sp_g++;
				if($sp_g==1){
					$sp_giam=0;
				}else if($sp_g==2){
					$sp_giam=0;
				}else if($sp_g==3){
					$sp_giam=2;
				}else if($sp_g==4){
					$sp_giam=3;
				}else if($sp_g==5){
					$sp_giam=5;
				}else{
					$sp_giam=0;
				}
				if($user_info['leader']==1 OR $user_info['gia_leader']==1){
					$thanhtien=$product_pl[$id_sp]['gia_drop'];
					$thanhtien_gop=$thanhtien - ($thanhtien/100)*$sp_giam;
					if(isset($_SESSION['don'][1][$sp_g])){
						$tongtien_don[1]+=$thanhtien_gop;
					}else if(isset($_SESSION['don'][2][$sp_g])){
						$tongtien_don[2]+=$thanhtien_gop;
					}else if(isset($_SESSION['don'][3][$sp_g])){
						$tongtien_don[3]+=$thanhtien_gop;
					}else if(isset($_SESSION['don'][4][$sp_g])){
						$tongtien_don[4]+=$thanhtien_gop;
					}else if(isset($_SESSION['don'][5][$sp_g])){
						$tongtien_don[5]+=$thanhtien_gop;
					}
				}else{
					$thanhtien=$product_pl[$id_sp]['gia_ctv'];
					$thanhtien_gop=$thanhtien - ($thanhtien/100)*$sp_giam;
					if(isset($_SESSION['don'][1][$sp_g])){
						$tongtien_don[1]+=$thanhtien_gop;
					}else if(isset($_SESSION['don'][2][$sp_g])){
						$tongtien_don[2]+=$thanhtien_gop;
					}else if(isset($_SESSION['don'][3][$sp_g])){
						$tongtien_don[3]+=$thanhtien_gop;
					}else if(isset($_SESSION['don'][4][$sp_g])){
						$tongtien_don[4]+=$thanhtien_gop;
					}else if(isset($_SESSION['don'][5][$sp_g])){
						$tongtien_don[5]+=$thanhtien_gop;
					}
				}
			}
		}

	}
	$info=array(
		'ok'=>1,
		'tongtien_don'=>$tongtien_don
	);
	echo json_encode($info);
?>