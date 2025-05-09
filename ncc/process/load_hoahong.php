<?php
			$list_id='';
			$list_leader='';
			$list_all='';
			$thongtin_nhom=mysqli_query($conn,"SELECT * FROM user_info WHERE aff='$user_id'");
			while($r_n=mysqli_fetch_assoc($thongtin_nhom)){
				if($r_n['leader']==1){
					$list_leader.=$r_n['user_id'].',';
				}else{
					$list_id.=$r_n['user_id'].',';
				}
				$list_all.=$r_n['user_id'].',';
			}
			if($list_id==''){

			}else{
				$list_id=substr($list_id, 0,-1);
			}
			if($list_leader==''){

			}else{
				$list_leader=substr($list_leader, 0,-1);
			}
			if($list_all==''){

			}else{
				$list_all=substr($list_all, 0,-1);
			}
			$end = addslashes(strip_tags($_REQUEST['time_end']));
			$tach_end = explode('/', $end);
			$date_end = $tach_end[0];
			$month_end = $tach_end[1];
			$year_end = $tach_end[2];
			$end_time = mktime(23, 59, 59, $month_end, $date_end, $year_end);
			$begin = addslashes(strip_tags($_REQUEST['time_begin']));
			$tach_begin = explode('/', $begin);
			$date_begin = $tach_begin[0];
			$month_begin = $tach_begin[1];
			$year_begin = $tach_begin[2];
			$begin_time = mktime(0, 0, 0, $month_begin, $date_begin, $year_begin);
			$thongke = json_decode($class_index->thongke_hoahong($conn,$list_leader, $list_id,$list_all, $begin_time, $end_time), true);
			$ok = 1;
			$thongbao = 'Lấy dữ liệu thành công';
			$bien = array(
				'ok' => $ok,
				'thongbao' => $thongbao,
				'doanhthu_nangcap' => number_format($thongke['doanhthu_nangcap']).' đ',
				'doanhthu_nhom' => number_format($thongke['doanhthu_nhom']).' đ',
				'doanhthu_nhom_gioithieu' => number_format($thongke['doanhthu_nhom_gioithieu']).' đ',
				'doanhthu_tong' => number_format($thongke['doanhthu_tong']).' đ',
				'donhang_nangcap' => number_format($thongke['donhang_nangcap']).' nhà bán',
				'donhang_nhom' => number_format($thongke['donhang_nhom']).' đơn hàng',
				'donhang_nhom_gioithieu' => number_format($thongke['donhang_nhom_gioithieu']).' đơn hàng',
				'donhang_tong' =>' với <span class="donhang_tong">'.number_format($thongke['donhang_tong']).'</span> đơn hàng và <span class="donhang_nangcap">'.number_format($thongke['donhang_nangcap']).'</span> nhà bán nâng cấp',
			);
			echo json_encode($bien);
?>