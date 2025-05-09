<?php
			$key = addslashes(strip_tags($_REQUEST['key']));
			$kieu=addslashes($_REQUEST['kieu']);
			if (isset($_COOKIE['drop_kho'])) {
				$kho = addslashes(strip_tags($_COOKIE['drop_kho']));
			} else {
				$kho = 'kho';
			}
			if($kieu=='mobile'){
				$list = $class_index->list_kq_timkiem_sanpham_hethang($conn,$user_info['leader'],$user_info['gia_leader'], $kho, $key);
			}else{
				$list = $class_index->list_kq_timkiem_sanpham_hethang($conn,$user_info['leader'],$user_info['gia_leader'], $kho, $key);
				$list = '<tr>
							<th style="text-align: center;width: 50px;" class="hide_mobile">STT</th>
							<th style="text-align: center;width: 120px;" class="hide_mobile">Minh họa</th>
							<th style="text-align: left;">Tên sản phẩm</th>
							<th style="text-align: center;width: 100px;" class="hide_mobile">Giá Nhập</th>
							<th style="text-align: center;width: 100px;" class="hide_mobile">Giá niêm yết</th>
							<th style="text-align: center;width: 100px;" class="hide_mobile">Giá bán lẻ</th>
							<th style="text-align: center;width: 100px;" class="hide_mobile">Kho</th>
							<th style="text-align: center;width: 100px;" class="hide_mobile">View</th>
							<th style="text-align: center;width: 160px;">Hành động</th>
						</tr>' . $list;
			}
			$info = array(
				'ok' => 1,
				'list' => $list,
				'kieu'=>$kieu
			);
			echo json_encode($info);
?>