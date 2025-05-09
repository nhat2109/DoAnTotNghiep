<?php
			$thuong_hieu=intval($_REQUEST['thuong_hieu']);
			$loai=addslashes($_REQUEST['loai']);
			$kieu=addslashes($_REQUEST['kieu']);
			if (isset($_COOKIE['drop_kho'])) {
				$kho = addslashes(strip_tags($_COOKIE['drop_kho']));
			} else {
				$kho = 'kho';
			}
			$thongtin=mysqli_query($conn,"SELECT * FROM banner_qc WHERE thuong_hieu='$thuong_hieu'");
			$r_tt=mysqli_fetch_assoc($thongtin);
			if($loai=='add_sanpham'){
				if($kieu=='mobile'){
					$list = $class_index->list_kq_timkiem_sanpham_thuonghieu_add($conn,$user_info['leader'],$user_info['gia_leader'],'mobile', $kho, $thuong_hieu);
				}else{
					$list = $class_index->list_kq_timkiem_sanpham_thuonghieu_add($conn,$user_info['leader'],$user_info['gia_leader'],'laptop', $kho, $thuong_hieu);
					$list = '<tr>
						<th style="text-align: center;width: 50px;" class="hide_mobile">STT</th>
						<th style="text-align: center;width: 120px;" class="hide_mobile">Minh họa</th>
						<th style="text-align: left;">Tên sản phẩm</th>
						<th style="text-align: center;width: 100px;" class="hide_mobile">Tồn kho</th>
						<th style="text-align: center;width: 100px;" class="hide_mobile">Giá niêm yết</th>
						<th style="text-align: center;width: 100px;" class="hide_mobile">Giá nhập</th>
						<th style="text-align: center;width: 160px;" class="hide_mobile">Giá bán tối thiểu</th>
						<th style="text-align: center;width: 180px;">Hành động</th>
					</tr>' . $list;
				}
			}else if($loai=='add_donhang_drop'){
				$thongtin_follow=mysqli_query($conn,"SELECT * FROM sanpham_follow WHERE user_id='$user_id'");
				$total_follow=mysqli_num_rows($thongtin_follow);
				if($total_follow==0){
					$list_follow='';
				}else{
					$r_fl=mysqli_fetch_assoc($thongtin_follow);
					$list_follow=$r_fl['sanpham'];
				}
				if($kieu=='mobile'){
					$list = $class_index->list_kq_timkiem_sanpham_thuonghieu($conn,$list_follow,$user_info['leader'],$user_info['gia_leader'],'mobile', $kho, $thuong_hieu);
				}else{
					$list = $class_index->list_kq_timkiem_sanpham_thuonghieu($conn,$list_follow,$user_info['leader'],$user_info['gia_leader'],'laptop', $kho, $thuong_hieu);
					$list = ' <tr>
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
			                </tr>' . $list;
				}
			}else if($loai=='list_link_affiliate'){
				if($kieu=='mobile'){
					$list = $class_index->list_kq_timkiem_link_affiliate_thuonghieu($conn,$user_id,$user_info['leader'],$user_info['gia_leader'],'mobile', $kho, $thuong_hieu);
				}else{
					$list = $class_index->list_kq_timkiem_link_affiliate_thuonghieu($conn,$user_id,$user_info['leader'],$user_info['gia_leader'],'laptop', $kho, $thuong_hieu);
					$list = '<tr>
								<th style="text-align: center;width: 50px;" class="hide_mobile">STT</th>
								<th style="text-align: center;width: 120px;" class="hide_mobile">Minh họa</th>
								<th style="text-align: left;">Tên sản phẩm</th>
								<th style="text-align: center;width: 120px;" class="hide_mobile">Hoa hồng</th>
								<th style="text-align: center;width: 120px;" class="hide_mobile">Total click</th>
								<th style="text-align: center;width: 80px;" class="hide_mobile">Cookie</th>
								<th style="text-align: center;width: 80px;" class="hide_mobile">Hành động</th>
							</tr>' . $list;
				}
			}
			$info = array(
				'ok' => 1,
				'list' => $list,
				'cover'=>$r_tt['cover'],
				'noi_dung'=>$r_tt['noi_dung'],
				'kieu'=>$kieu
			);
			echo json_encode($info);
?>