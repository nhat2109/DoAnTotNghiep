<?php
			$page = intval($_REQUEST['page']);
			$kieu=addslashes($_REQUEST['kieu']);
			$page++;
			$limit = 25;
			$list_dang='';
			$thongtin_dang=mysqli_query($conn,"SELECT * FROM sanpham_shop WHERE shop='$user_id' AND sp_id>'0'");
			while($r_dang=mysqli_fetch_assoc($thongtin_dang)){
				$list_dang.=$r_dang['sp_id'].',';
			}
			if($list_dang==''){
			}else{
				$list_dang=substr($list_dang, 0,-1);
			}
			if (isset($_COOKIE['drop_kho'])) {
				$kho = addslashes(strip_tags($_COOKIE['drop_kho']));
			} else {
				$kho = 'kho';
			}
			if($kieu=='mobile'){
				$list = $class_index->list_sanpham($conn,$user_info['leader'],$user_info['gia_leader'],'mobile', $kho,$list_dang, $user_id, $page, $limit);
			}else{
				$list = $class_index->list_sanpham($conn,$user_info['leader'],$user_info['gia_leader'],'laptop', $kho,$list_dang, $user_id, $page, $limit);

			}
			$info = array(
				'list' => $list,
				'page' => $page,
				'kieu'=>$kieu
			);
			echo json_encode($info);
?>