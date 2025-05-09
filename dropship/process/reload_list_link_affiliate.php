<?php
			$kieu=addslashes($_REQUEST['kieu']);
			$limit = 50;
			if (isset($_COOKIE['drop_kho'])) {
				$kho = addslashes(strip_tags($_COOKIE['drop_kho']));
			} else {
				$kho = 'kho';
			}
			if($kieu=='mobile'){
				$list = $class_index->list_link_affiliate($conn,$user_id,'mobile', 1, $limit);
			}else{
				$list = '			<tr>
				<th style="text-align: center;width: 50px;" class="hide_mobile">STT</th>
				<th style="text-align: center;width: 120px;" class="hide_mobile">Minh họa</th>
				<th style="text-align: left;">Tên sản phẩm</th>
				<th style="text-align: center;width: 120px;" class="hide_mobile">Hoa hồng</th>
				<th style="text-align: center;width: 120px;" class="hide_mobile">Total click</th>
				<th style="text-align: center;width: 80px;" class="hide_mobile">Cookie</th>
			</tr>'.$class_index->list_link_affiliate($conn,$user_id,'laptop', 1, $limit);
			}
			$info = array(
				'list' => $list,
				'page' => 2,
				'kieu'=>$kieu
			);
			echo json_encode($info);
?>