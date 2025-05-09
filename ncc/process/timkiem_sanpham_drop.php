<?php
			$key = addslashes(strip_tags($_REQUEST['key']));
			if (isset($_COOKIE['drop_kho'])) {
				$kho = addslashes(strip_tags($_COOKIE['drop_kho']));
			} else {
				$kho = 'kho';
			}
			$kieu=addslashes($_REQUEST['kieu']);
			$thongtin_follow=mysqli_query($conn,"SELECT * FROM sanpham_follow WHERE user_id='$user_id'");
			$total_follow=mysqli_num_rows($thongtin_follow);
			if($total_follow==0){
				$list_follow='';
			}else{
				$r_fl=mysqli_fetch_assoc($thongtin_follow);
				$list_follow=$r_fl['sanpham'];
			}
			if($kieu=='mobile'){
				$list = $class_index->list_kq_timkiem_sanpham_drop($conn,$list_follow,$user_info['leader'],$user_info['gia_leader'],'mobile', $kho, $key);
			}else{
				$list = $class_index->list_kq_timkiem_sanpham_drop($conn,$list_follow,$user_info['leader'],$user_info['gia_leader'],'laptop', $kho, $key);
				$list = '<tr>
	                    <th style="text-align: center;width: 50px;" class="hide_mobile">STT</th>
	                    <th style="text-align: center;width: 120px;" class="hide_mobile">Minh họa</th>
	                    <th style="text-align: center;width: 120px;" class="hide_mobile">Mã sản phẩm</th>
	                    <th style="text-align: left;">Tên sản phẩm</th>
	                    <th style="text-align: center;width: 100px;" class="hide_mobile">Giá niêm yết</th>
	                    <th style="text-align: center;width: 100px;" class="hide_mobile">Giá bán</th>
	                    <th style="text-align: center;width: 120px;" class="hide_mobile">Giá bán tối thiểu</th>
	                    <th style="text-align: center;width: 100px;">Giá nhập</th>
	                    <th style="text-align: center;width: 100px;">Kho</th>
	                    <th style="text-align: center;width: 180px;">Hành động</th>
	                </tr>' . $list;
			}
			$info = array(
				'ok' => 1,
				'list' => $list,
				'kieu'=>$kieu
			);
			echo json_encode($info);
?>