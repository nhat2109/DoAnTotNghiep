<?php
			$thaythe['title'] = 'Theo dõi sản phẩm quan tâm';
			$thaythe['title_action'] = 'Theo dõi sản phẩm quan tâm';
			$key=addslashes(strip_tags($_REQUEST['key']));
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
			$limit = 100;
			if (isset($_COOKIE['drop_kho'])) {
				$kho = addslashes(strip_tags($_COOKIE['drop_kho']));
			} else {
				$kho = 'kho';
			}
			$kieu=addslashes($_REQUEST['kieu']);
			$thongtin_follow=mysqli_query($conn,"SELECT * FROM sanpham_follow WHERE user_id='$user_id'");
			$total_follow=mysqli_num_rows($thongtin_follow);
			if($total_follow==0){
				$bien=array(
					'list'=>'',
					'phantrang'=>''
				);
			}else{
				$r_fl=mysqli_fetch_assoc($thongtin_follow);
				$list_id=$r_fl['sanpham'];
				if($list_id==''){
					$bien=array(
						'list'=>'',
						'phantrang'=>''
					);
				}else{
					$thongke = mysqli_query($conn, "SELECT count(*) AS total FROM sanpham WHERE id IN ($list_id) $where_key");
					$r_tk = mysqli_fetch_assoc($thongke);
					$total_page = ceil($r_tk['total'] / $limit);
					if($kieu=='mobile'){
						$list=$class_index->list_timkiem_sanpham_follow($conn,$list_id,$user_info['leader'],$user_info['gia_leader'],$kieu, $kho,$key,'kho-asc');

					}else{
						$list='<tr>
			                <th style="text-align: center;width: 50px;" class="hide_mobile">STT</th>
			                <th style="text-align: center;width: 120px;" class="hide_mobile">Minh họa</th>
			                <th style="text-align: center;width: 120px;" class="hide_mobile">Mã sản phẩm</th>
			                <th style="text-align: left;">Tên sản phẩm</th>
			                <th style="text-align: center;width: 100px;" class="hide_mobile">Giá niêm yết</th>
			                <th style="text-align: center;width: 100px;" class="hide_mobile">Giá bán</th>
			                <th style="text-align: center;width: 120px;" class="hide_mobile">Giá bán tối thiểu</th>
			                <th style="text-align: center;width: 100px;">Giá nhập</th>
			                <th style="text-align: center;width: 100px;" class="hide_mobile">Kho</th>
			                <th style="text-align: center;width: 200px;">Hành động</th>
			            </tr>'.$class_index->list_timkiem_sanpham_follow($conn,$list_id,$user_info['leader'],$user_info['gia_leader'],$kieu, $kho,$key,'kho-asc');
					}
					$bien = array(
						'ok'=>1,
						'list' =>$list,
						'phantrang' => $class_index->phantrang($page, $total_page, '/ncc/list-sanpham-follow'),
					);
				}
			}
			echo json_encode($bien);
?>