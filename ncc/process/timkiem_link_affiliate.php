<?php
			$key = addslashes(strip_tags($_REQUEST['key']));
			if (isset($_COOKIE['drop_kho'])) {
				$kho = addslashes(strip_tags($_COOKIE['drop_kho']));
			} else {
				$kho = 'kho';
			}
			$kieu=addslashes($_REQUEST['kieu']);
			if($kieu=='mobile'){
				$list = $class_index->list_kq_timkiem_link_affiliate($conn,$user_id,$user_info['leader'],$user_info['gia_leader'],'mobile', $kho, $key);
			}else{
				$list = $class_index->list_kq_timkiem_link_affiliate($conn,$user_id,$user_info['leader'],$user_info['gia_leader'],'laptop', $kho, $key);
				$list = '<tr>
							<th style="text-align: center;width: 50px;" class="hide_mobile">STT</th>
							<th style="text-align: center;width: 120px;" class="hide_mobile">Minh họa</th>
							<th style="text-align: left;">Tên sản phẩm</th>
							<th style="text-align: center;width: 120px;" class="hide_mobile">Hoa hồng</th>
							<th style="text-align: center;width: 120px;" class="hide_mobile">Total click</th>
							<th style="text-align: center;width: 80px;" class="hide_mobile">Cookie</th>
	                </tr>' . $list;
			}
			$info = array(
				'ok' => 1,
				'list' => $list,
				'kieu'=>$kieu
			);
			echo json_encode($info);
?>