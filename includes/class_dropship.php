 <?php
class class_dropship extends class_manage {
	///////////////////
	function list_menu($conn, $shop, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $start;
		$thongtin = mysqli_query($conn, "SELECT * FROM menu_shop WHERE shop='$shop' ORDER BY menu_vitri ASC, menu_thutu ASC LIMIT $start,$limit");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$r_tt['blank'] = $check->blank($r_tt['post_tieude']);
			$i++;
			$r_tt['i'] = $i;
			if ($r_tt['menu_vitri'] == 'top') {
				$r_tt['menu_vitri'] = 'Menu top';
			} else if ($r_tt['menu_vitri'] == 'huongdan') {
				$r_tt['menu_vitri'] = 'Menu hướng dẫn';
			} else if ($r_tt['menu_vitri'] == 'chinhsach') {
				$r_tt['menu_vitri'] = 'Menu chính sách';
			}
			$list .= $skin->skin_replace('skin_dropship/box_action/tr_menu', $r_tt);
		}
		return $list;
	}
	///////////////////
	function list_notification($conn,$user_id,$loai,$page,$limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		if($loai=='all'){
			$thongtin = mysqli_query($conn, "SELECT * FROM notification WHERE admin='0' ORDER BY id DESC LIMIT $start,$limit");
		}else{
			$thongtin = mysqli_query($conn, "SELECT * FROM notification WHERE admin='0' AND (doc IS NULL OR FIND_IN_SET('$user_id', doc) < 1) ORDER BY id DESC LIMIT $start,$limit");
		}
		$i = $start;
		$total=0;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$total++;
			$i++;
			$r_tt['i'] = $i;
			$r_tt['date_post'] = $check->chat_update($r_tt['date_post']);
			if($r_tt['doc']==''){
				$doc=$user_id;
				mysqli_query($conn,"UPDATE notification SET doc='$doc' WHERE id='{$r_tt['id']}'");
			}else{
				$tach_doc=explode(',', $r_tt['doc']);
				if(in_array($user_id, $tach_doc)==true){

				}else{
					$doc=$r_tt['doc'].','.$user_id;
					mysqli_query($conn,"UPDATE notification SET doc='$doc' WHERE id='{$r_tt['id']}'");
				}
			}
			$list .= $skin->skin_replace('skin_dropship/box_action/li_notification', $r_tt);
		}
		$info=array(
			'total'=>$total,
			'list'=>$list
		);
		return json_encode($info);
	}
	/////////////////
	function list_phanloai_color($conn,$sp_id,$size) {
		$skin = $this->load('class_skin');
		$check = $this->load('class_check');
		$thongtin = mysqli_query($conn, "SELECT * FROM phanloai_sanpham WHERE sp_id='$sp_id' AND size='$size' ORDER BY id ASC");
		$i=0;
		$list_id_color=array();
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			if($i==1){
				$r_tt['active']='active';
				$ten_color=$r_tt['ten_color'];
				$sel="selected";
			}else{
				$sel="";
				$r_tt['active']='';
			}
			if(in_array($r_tt['color'], $list_id_color)==false){
				$list_id_color[].=$r_tt['color'];
				$list_option_color.='<option value="'.$r_tt['color'].'" '.$sel.' pl="'.$r_tt['id'].'">'.$r_tt['ten_color'].'</option>';
				$list_color.=$skin->skin_replace('skin/box_li/li_color', $r_tt);
			}
		}
		$bien=array(
			'list_option_color'=>$list_option_color,
			'list_color'=>$list_color,
			'ten_color'=>$ten_color
		);
		return json_encode($bien);
	}
	////////////////////
	function list_nhiemvu($conn,$user_id) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $start;
		$thongtin = mysqli_query($conn, "SELECT nhiem_vu.*,lichsu_nhiemvu.id AS id_lichsu,lichsu_nhiemvu.hoan_thanh FROM nhiem_vu LEFT JOIN lichsu_nhiemvu ON nhiem_vu.id=lichsu_nhiemvu.nhiem_vu AND lichsu_nhiemvu.user_id='$user_id' ORDER BY nhiem_vu.ngay ASC ");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$r_tt['date_post'] = date('H:i:s d/m/Y', $r_tt['date_post']);
			if($i==1){
				$r_tt['active']='active';
			}else{
				$r_tt['active']='';
			}
			if(intval($r_tt['id_lichsu'])>0){
				if($r_tt['hoan_thanh']==1){
					$list .= $skin->skin_replace('skin_dropship/box_action/li_nhiemvu_hoanthanh', $r_tt);
				}else{
					$thongtin_noidung=mysqli_query($conn,"SELECT * FROM noidung_nhiemvu WHERE nhiem_vu='{$r_tt['id']}'");
					while($r_nd=mysqli_fetch_assoc($thongtin_noidung)){
						$list_noidung.='<div class="li_noidung" noidung="'.$r_nd['id'].'">'.$r_nd['tieu_de'].'</div>';
					}
					$r_tt['list_noidung']=$list_noidung;
					$list .= $skin->skin_replace('skin_dropship/box_action/li_nhiemvu_mo', $r_tt);
					unset($list_noidung);
				}
			}else{
				$list .= $skin->skin_replace('skin_dropship/box_action/li_nhiemvu_moi', $r_tt);
			}
			
		}
		return $list;
	}
	////////////////////
	function list_bom($conn, $user_id, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $start;
		$thongtin = mysqli_query($conn, "SELECT bom_hang.*,user_info.username FROM bom_hang LEFT JOIN user_info ON bom_hang.user_id=user_info.user_id ORDER BY bom_hang.id DESC LIMIT $start,$limit");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$r_tt['date_post'] = date('H:i:s d/m/Y', $r_tt['date_post']);
			if ($r_tt['user_id'] == 0) {
				$r_tt['username'] = 'Quản trị';
				$r_tt['action'] = '';
			} else if ($r_tt['user_id'] == $user_id) {
				$r_tt['action'] = '<a href="/dropship/edit-bom?id=' . $r_tt['id'] . '" class="edit">Sửa</a><a href="javascript:;" onclick="confirm_del(\'del\',\'bom\', \'Xác nhận xóa bom hàng\', \'' . $r_tt['id'] . '\');" class="del">Xóa</a>';
			} else {
				$r_tt['action'] = '';
			}
			$list .= $skin->skin_replace('skin_dropship/box_action/tr_bom', $r_tt);
		}
		return $list;
	}
    function creat_random($conn,$loai){
        $skin=$this->load('class_skin_cpanel');
        $check=$this->load('class_check');
        if($loai=='phien_traodoi'){
	        $string=$check->random_string(6);
	        $thongtin=mysqli_query($conn,"SELECT *,count(*) AS total FROM chat WHERE phien='$string'");
	        $r_tt=mysqli_fetch_assoc($thongtin);
	        if($r_tt['total']>0){
	            $this->creat_random($conn,$loai);
	        }else{
	            return $string;
	        }
        }else if($loai=='rut_gon'){
	        $string=$check->random_string(6);
	        $thongtin=mysqli_query($conn,"SELECT *,count(*) AS total FROM rut_gon WHERE rut_gon='$string'");
	        $r_tt=mysqli_fetch_assoc($thongtin);
	        if($r_tt['total']>0){
	            $this->creat_random($conn,$loai);
	        }else{
	            return $string;
	        }
        }else if($loai=='donhang_ctv'){
	        $string=$check->random_number(6);
	        $thongtin=mysqli_query($conn,"SELECT *,count(*) AS total FROM donhang_ctv WHERE ma_don='$string'");
	        $r_tt=mysqli_fetch_assoc($thongtin);
	        if($r_tt['total']>0){
	            $this->creat_random($conn,$loai);
	        }else{
	            return $string;
	        }
        }else if($loai=='donhang_shop'){
	        $string=$check->random_number(6);
	        $thongtin=mysqli_query($conn,"SELECT *,count(*) AS total FROM donhang_shop WHERE ma_don='$string'");
	        $r_tt=mysqli_fetch_assoc($thongtin);
	        if($r_tt['total']>0){
	            $this->creat_random($conn,$loai);
	        }else{
	            return $string;
	        }
        }else if($loai=='donhang'){
	        $string=$check->random_number(6);
	        $thongtin=mysqli_query($conn,"SELECT *,count(*) AS total FROM donhang WHERE ma_don='$string'");
	        $r_tt=mysqli_fetch_assoc($thongtin);
	        if($r_tt['total']>0){
	            $this->creat_random($conn,$loai);
	        }else{
	            return $string;
	        }
        }
    }
	////////////////////
	function list_yeucau($conn,$thanh_vien,$phien){
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$thongtin=mysqli_query($conn,"SELECT chat.*,user_info.name AS ho_ten,user_info.mobile FROM chat INNER JOIN user_info ON chat.thanh_vien=user_info.user_id WHERE chat.user_in='$thanh_vien' OR chat.user_out='$thanh_vien' GROUP BY chat.phien ORDER BY chat.id DESC");
		$i=0;
		$total=mysqli_num_rows($thongtin);
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['date_post']=$check->date_update($r_tt['date_post']);
			if($phien==$r_tt['phien']){
				$r_tt['active']='active';
			}else{
				$r_tt['active']='';
			}
			$list .= $skin->skin_replace('skin_dropship/box_action/li_yeucau', $r_tt);
		}
		return $list;
	}
	////////////////////
	function list_chat($conn,$user_id,$name,$avatar,$user_end, $phien,$sms_id,$limit){
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$thongtin=mysqli_query($conn,"SELECT chat.*,emin_info.avatar,emin_info.name FROM chat LEFT JOIN emin_info ON emin_info.id=chat.user_out WHERE chat.phien='$phien' AND chat.noi_dung!='' AND chat.id<'$sms_id' ORDER BY chat.id DESC LIMIT $limit");
		$total=mysqli_num_rows($thongtin);
		if($total==0){
			$list='';
			$load=0;
		}else{
			if($total<$limit){
				$load=0;
			}else{
				$load=1;
			}
			$i=0;
			$_SESSION['user_end']=$user_end;
			while ($r_tt = mysqli_fetch_assoc($thongtin)) {
				$list_x[$i] = $r_tt;
				$i++;
				if($r_tt['user_out']!=$r_tt['thanh_vien']){
					mysqli_query($conn,"UPDATE chat SET doc='1' WHERE id='{$r_tt['id']}'");
				}
			}
			krsort($list_x);
			foreach ($list_x as $key => $value) {
				if($value['user_out']==$user_id){
					$value['name']=$name;
					$value['avatar']=$avatar;
				}
				$value['noi_dung']=$check->smile($value['noi_dung']);
				if($value['user_out']==$_SESSION['user_end']){
					if($user_id==$_SESSION['user_end']){
						$list.=$skin->skin_replace('skin_dropship/box_action/li_chat_right', $value);
					}else{
						$list.=$skin->skin_replace('skin_dropship/box_action/li_chat_left', $value);
					}
				}else{
					if($value['user_out']==$user_id){
						$list.=$skin->skin_replace('skin_dropship/box_action/li_chat_right_avatar', $value);
					}else{
						$list.=$skin->skin_replace('skin_dropship/box_action/li_chat_left_avatar', $value);
					}
				}
				$_SESSION['user_end']=$value['user_out'];
			}

		}
		$info=array(
			'list'=>$list,
			'load'=>$load
		);
		return json_encode($info);
	}
	////////////////////
	function list_kq_timkiem_bom($conn, $user_id, $key) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $start;
		$thongtin = mysqli_query($conn, "SELECT bom_hang.*,user_info.username FROM bom_hang LEFT JOIN user_info ON bom_hang.user_id=user_info.user_id WHERE bom_hang.ho_ten LIKE '%$key%' OR bom_hang.dien_thoai LIKE '%$key%' OR bom_hang.dia_chi LIKE '%$key%' ORDER BY bom_hang.id DESC");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$r_tt['date_post'] = date('H:i:s d/m/Y', $r_tt['date_post']);
			if ($r_tt['user_id'] == 0) {
				$r_tt['username'] = 'Quản trị';
				$r_tt['action'] = '';
			} else if ($r_tt['user_id'] == $user_id) {
				$r_tt['action'] = '<a href="/dropship/edit-bom?id=' . $r_tt['id'] . '" class="edit">Sửa</a><a href="javascript:;" onclick="confirm_del(\'del\',\'bom\', \'Xác nhận xóa bom hàng\', \'' . $r_tt['id'] . '\');" class="del">Xóa</a>';
			}
			$list .= $skin->skin_replace('skin_dropship/box_action/tr_bom', $r_tt);
		}
		return $list;
	}
	///////////////////
	function list_donhang_nhom($conn, $list_id,$loai,$status,$total, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $total - $start + 1;
		if($loai=='drop'){
			$thongtin = mysqli_query($conn, "SELECT donhang.*,user_info.name,user_info.username FROM donhang INNER JOIN user_info ON user_info.user_id=donhang.user_id WHERE donhang.user_id IN ($list_id) AND donhang.status='$status' ORDER BY donhang.id DESC LIMIT $start,$limit");
			while ($r_tt = mysqli_fetch_assoc($thongtin)) {
				$i--;
				$r_tt['i'] = $i;
				$r_tt['ngay']=date('d/m/Y',$r_tt['date_post']);
				$r_tt['hoahong']=number_format(($r_tt['tamtinh']/100)*5);
				$r_tt['tamtinh']=number_format($r_tt['tamtinh']);
				if($r_tt['status']==0){
					$r_tt['status']='Chờ xử lý';
					$r_tt['thanhtoan_hh']='Chưa thanh toán';
				}else if($r_tt['status']==1){
					$r_tt['status']='Đã tiếp nhận';
					$r_tt['thanhtoan_hh']='Chưa thanh toán';
				}else if($r_tt['status']==2){
					$r_tt['status']='Đang vận chuyển';
					$r_tt['thanhtoan_hh']='Chưa thanh toán';
				}else if($r_tt['status']==4){
					$r_tt['status']='Đã hủy đơn';
					$r_tt['thanhtoan_hh']='';
				}else if($r_tt['status']==5){
					$r_tt['status']='Giao thành công';
					$thongtin_hh=mysqli_query($conn,"SELECT * FROM hoahong_nhom WHERE ma_don='{$r_tt['ma_don']}' AND loai_don='drop'");
					$total_hh=mysqli_num_rows($thongtin_hh);
					if($total_hh==0){
						$r_tt['thanhtoan_hh']='Chưa thanh toán';
					}else{
						$r_hh=mysqli_fetch_assoc($thongtin_hh);
						if($r_hh['status']==1){
							$r_tt['thanhtoan_hh']='Đã thanh toán';
						}else{
							$r_tt['thanhtoan_hh']='Chưa thanh toán';
						}

					}
				}else if($r_tt['status']==6){
					$r_tt['status']='Hoàn đơn';
				}
				$list .= $skin->skin_replace('skin_dropship/box_action/li_don_nhom', $r_tt);
			}
		}else if($loai=='socdo'){
			$thongtin_ctv = mysqli_query($conn, "SELECT donhang_ctv.*,user_info.name,user_info.username FROM donhang_ctv INNER JOIN user_info ON user_info.user_id=donhang_ctv.user_id WHERE donhang_ctv.user_id IN ($list_id) AND donhang_ctv.status='$status' ORDER BY donhang_ctv.id DESC LIMIT $start,$limit");
			while ($r_tt = mysqli_fetch_assoc($thongtin_ctv)) {
				$i--;
				$r_tt['i'] = $i;
				$r_tt['ngay']=date('d/m/Y',$r_tt['date_post']);
				$r_tt['hoahong']=number_format(($r_tt['tamtinh']/100)*5);
				$r_tt['tamtinh']=number_format($r_tt['tamtinh']);
				if($r_tt['status']==0){
					$r_tt['status']='Chờ xử lý';
					$r_tt['thanhtoan_hh']='Chưa thanh toán';
				}else if($r_tt['status']==1){
					$r_tt['status']='Đã tiếp nhận';
					$r_tt['thanhtoan_hh']='Chưa thanh toán';
				}else if($r_tt['status']==2){
					$r_tt['status']='Đang vận chuyển';
					$r_tt['thanhtoan_hh']='Chưa thanh toán';
				}else if($r_tt['status']==4){
					$r_tt['status']='Đã hủy đơn';
					$r_tt['thanhtoan_hh']='';
				}else if($r_tt['status']==5){
					$r_tt['status']='Giao thành công';
					$thongtin_hh=mysqli_query($conn,"SELECT * FROM hoahong_nhom WHERE ma_don='{$r_tt['ma_don']}' AND loai_don='ctv'");
					$total_hh=mysqli_num_rows($thongtin_hh);
					if($total_hh==0){
						$r_tt['thanhtoan_hh']='Chưa thanh toán';
					}else{
						$r_hh=mysqli_fetch_assoc($thongtin_hh);
						if($r_hh['status']==1){
							$r_tt['thanhtoan_hh']='Đã thanh toán';
						}else{
							$r_tt['thanhtoan_hh']='Chưa thanh toán';
						}

					}
				}else if($r_tt['status']==6){
					$r_tt['status']='Hoàn đơn';
				}
				$list .= $skin->skin_replace('skin_dropship/box_action/li_don_nhom', $r_tt);
			}

		}else if($loai=='affiliate'){
			$thongtin_aff = mysqli_query($conn, "SELECT donhang.*,user_info.name,user_info.username FROM donhang INNER JOIN user_info ON user_info.user_id=donhang.user_id WHERE donhang.utm_source IN ($list_id) AND donhang.status='$status' ORDER BY donhang.id DESC LIMIT $start,$limit");
			while ($r_aff = mysqli_fetch_assoc($thongtin_aff)) {
				$i--;
				$r_tt['i'] = $i;
				$r_tt['ngay']=date('d/m/Y',$r_tt['date_post']);
				$r_tt['hoahong']=number_format(($r_tt['tamtinh']/100)*5);
				$r_tt['tamtinh']=number_format($r_tt['tamtinh']);
				if($r_tt['status']==0){
					$r_tt['status']='Chờ xử lý';
					$r_tt['thanhtoan_hh']='Chưa thanh toán';
				}else if($r_tt['status']==1){
					$r_tt['status']='Đã tiếp nhận';
					$r_tt['thanhtoan_hh']='Chưa thanh toán';
				}else if($r_tt['status']==2){
					$r_tt['status']='Đang vận chuyển';
					$r_tt['thanhtoan_hh']='Chưa thanh toán';
				}else if($r_tt['status']==4){
					$r_tt['status']='Đã hủy đơn';
					$r_tt['thanhtoan_hh']='';
				}else if($r_tt['status']==5){
					$r_tt['status']='Giao thành công';
					$thongtin_hh=mysqli_query($conn,"SELECT * FROM hoahong_nhom WHERE ma_don='{$r_tt['ma_don']}' AND loai_don='aff'");
					$total_hh=mysqli_num_rows($thongtin_hh);
					if($total_hh==0){
						$r_tt['thanhtoan_hh']='Chưa thanh toán';
					}else{
						$r_hh=mysqli_fetch_assoc($thongtin_hh);
						if($r_hh['status']==1){
							$r_tt['thanhtoan_hh']='Đã thanh toán';
						}else{
							$r_tt['thanhtoan_hh']='Chưa thanh toán';
						}

					}
				}else if($r_tt['status']==6){
					$r_tt['status']='Hoàn đơn';
				}
				$list .= $skin->skin_replace('skin_dropship/box_action/li_don_nhom', $r_tt);
			}
		}
		return $list;
	}
	////////////////////
	function list_thanhvien_nhom($conn,$user_id, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $start;
		$tach_nhomtruong = explode(',', $list_nhomtruong);
		$thongtin = mysqli_query($conn, "SELECT *,(SELECT count(*) FROM donhang d WHERE d.user_id=u.user_id AND d.status!='3' AND d.status!='4') AS total_donhang,(SELECT count(*) FROM donhang_ctv d_ctv WHERE d_ctv.user_id=u.user_id AND d_ctv.status!='3' AND d_ctv.status!='4') AS total_donhang_ctv,(SELECT sum(tongtien) FROM donhang_ctv d_ctv WHERE d_ctv.user_id=u.user_id AND d_ctv.status!='3' AND d_ctv.status!='4') AS total_doanhso_ctv,(SELECT sum(tongtien) FROM donhang d WHERE d.user_id=u.user_id AND d.status!='3' AND d.status!='4') AS total_doanhso FROM user_info u WHERE aff='$user_id' ORDER BY user_id ASC LIMIT $start,$limit");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			if ($r_tt['user_id']==$user_id) {
				$r_tt['vaitro'] = 'Trưởng nhóm';
			} else {
				$r_tt['vaitro'] = 'Thành viên';
			}
			$r_tt['nhom'] = $nhom;
			$tong_doanhso=$r_tt['total_doanhso'] + $r_tt['total_doanhso_ctv'];
			$total_donhang=$r_tt['total_donhang'] + $r_tt['total_donhang_ctv'];
			$r_tt['total_doanhso'] = number_format($tong_doanhso) . ' đ';
			$r_tt['total_donhang'] = number_format($total_donhang);
			$list .= $skin->skin_replace('skin_dropship/box_action/tr_thanhvien_nhom', $r_tt);
		}
		return $list;
	}
	///////////////////
	function thongke_doanhthu_socdo($conn, $list_id, $dau, $cuoi) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$thongtin = mysqli_query($conn, "SELECT * FROM donhang_ctv WHERE user_id IN ($list_id) AND date_post>='$dau' AND date_post<='$cuoi'");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$ngay = date('d', $r_tt['date_post']);
			$ngay = intval($ngay);
			if ($r_tt['status'] == 6) {
				$hoan++;
				$doanhthu_hoan += $r_tt['tongtien'];
			} else if ($r_tt['status'] == 5) {
				$hoanthanh++;
				$doanhthu_hoanthanh += $r_tt['tongtien'];
			} else if ($r_tt['status'] == 4) {
				$huy++;
				$doanhthu_huy += $r_tt['tongtien'];
			} else if ($r_tt['status'] == 3) {
				$yeucau_huy++;
				$doanhthu_yeucau_huy += $r_tt['tongtien'];
			} else if ($r_tt['status'] == 2) {
				$vanchuyen++;
				$doanhthu_vanchuyen += $r_tt['tongtien'];
			} else if ($r_tt['status'] == 1) {
				$tiepnhan++;
				$doanhthu_tiepnhan += $r_tt['tongtien'];
			} else if ($r_tt['status'] == 0) {
				$cho++;
				$doanhthu_cho += $r_tt['tongtien'];
			}
		}
		$info = array(
			'donhang_hoanthanh' => $hoanthanh,
			'doanhthu_hoanthanh' => $doanhthu_hoanthanh,
			'donhang_vanchuyen' => $vanchuyen,
			'doanhthu_vanchuyen' => $doanhthu_vanchuyen,
			'donhang_huy' => $huy,
			'doanhthu_huy' => $doanhthu_huy,
			'donhang_hoan' => $hoan,
			'doanhthu_hoan' => $doanhthu_hoan,
			'donhang_cho' => $cho,
			'doanhthu_cho' => $doanhthu_cho,
			'donhang_yeucau_huy' => $yeucau_huy,
			'doanhthu_yeucau_huy' => $doanhthu_yeucau_huy,
			'donhang_tiepnhan' => $tiepnhan,
			'doanhthu_tiepnhan' => $doanhthu_tiepnhan,
		);
		return json_encode($info);
	}
	///////////////////
	function thongke_doanhthu_aff($conn, $list_id, $dau, $cuoi) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$thongtin = mysqli_query($conn, "SELECT * FROM donhang WHERE dropship='0' AND utm_source IN ($list_id) AND date_post>='$dau' AND date_post<='$cuoi'");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$ngay = date('d', $r_tt['date_post']);
			$ngay = intval($ngay);
			if ($r_tt['status'] == 6) {
				$hoan++;
				$doanhthu_hoan += $r_tt['tongtien'];
			} else if ($r_tt['status'] == 5) {
				$hoanthanh++;
				$doanhthu_hoanthanh += $r_tt['tongtien'];
			} else if ($r_tt['status'] == 4) {
				$huy++;
				$doanhthu_huy += $r_tt['tongtien'];
			} else if ($r_tt['status'] == 3) {
				$yeucau_huy++;
				$doanhthu_yeucau_huy += $r_tt['tongtien'];
			} else if ($r_tt['status'] == 2) {
				$vanchuyen++;
				$doanhthu_vanchuyen += $r_tt['tongtien'];
			} else if ($r_tt['status'] == 1) {
				$tiepnhan++;
				$doanhthu_tiepnhan += $r_tt['tongtien'];
			} else if ($r_tt['status'] == 0) {
				$cho++;
				$doanhthu_cho += $r_tt['tongtien'];
			}
		}
		$info = array(
			'donhang_hoanthanh' => $hoanthanh,
			'doanhthu_hoanthanh' => $doanhthu_hoanthanh,
			'donhang_vanchuyen' => $vanchuyen,
			'doanhthu_vanchuyen' => $doanhthu_vanchuyen,
			'donhang_huy' => $huy,
			'doanhthu_huy' => $doanhthu_huy,
			'donhang_hoan' => $hoan,
			'doanhthu_hoan' => $doanhthu_hoan,
			'donhang_cho' => $cho,
			'doanhthu_cho' => $doanhthu_cho,
			'donhang_yeucau_huy' => $yeucau_huy,
			'doanhthu_yeucau_huy' => $doanhthu_yeucau_huy,
			'donhang_tiepnhan' => $tiepnhan,
			'doanhthu_tiepnhan' => $doanhthu_tiepnhan,
		);
		return json_encode($info);
	}
	///////////////////
	function thongke_doanhthu($conn, $list_id, $dau, $cuoi) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$thongtin = mysqli_query($conn, "SELECT * FROM donhang WHERE user_id IN ($list_id) AND date_post>='$dau' AND date_post<='$cuoi'");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$ngay = date('d', $r_tt['date_post']);
			$ngay = intval($ngay);
			if ($r_tt['status'] == 6) {
				$hoan++;
				$doanhthu_hoan += $r_tt['tongtien'];
			} else if ($r_tt['status'] == 5) {
				$hoanthanh++;
				$doanhthu_hoanthanh += $r_tt['tongtien'];
			} else if ($r_tt['status'] == 4) {
				$huy++;
				$doanhthu_huy += $r_tt['tongtien'];
			} else if ($r_tt['status'] == 3) {
				$yeucau_huy++;
				$doanhthu_yeucau_huy += $r_tt['tongtien'];
			} else if ($r_tt['status'] == 2) {
				$vanchuyen++;
				$doanhthu_vanchuyen += $r_tt['tongtien'];
			} else if ($r_tt['status'] == 1) {
				$tiepnhan++;
				$doanhthu_tiepnhan += $r_tt['tongtien'];
			} else if ($r_tt['status'] == 0) {
				$cho++;
				$doanhthu_cho += $r_tt['tongtien'];
			}
		}
		$info = array(
			'donhang_hoanthanh' => $hoanthanh,
			'doanhthu_hoanthanh' => $doanhthu_hoanthanh,
			'donhang_vanchuyen' => $vanchuyen,
			'doanhthu_vanchuyen' => $doanhthu_vanchuyen,
			'donhang_huy' => $huy,
			'doanhthu_huy' => $doanhthu_huy,
			'donhang_hoan' => $hoan,
			'doanhthu_hoan' => $doanhthu_hoan,
			'donhang_cho' => $cho,
			'doanhthu_cho' => $doanhthu_cho,
			'donhang_yeucau_huy' => $yeucau_huy,
			'doanhthu_yeucau_huy' => $doanhthu_yeucau_huy,
			'donhang_tiepnhan' => $tiepnhan,
			'doanhthu_tiepnhan' => $doanhthu_tiepnhan,
		);
		return json_encode($info);
	}
	///////////////////
	function thongke_hoahong($conn,$list_leader, $list_id,$list_all, $dau, $cuoi) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$noidung_nangcap='Đăng ký làm nhà bán chuyên nghiệp';
		$thongtin_nangcap = mysqli_query($conn, "SELECT * FROM lichsu_chitieu WHERE user_id IN ($list_all) AND date_post>='$dau' AND date_post<='$cuoi' AND noidung LIKE '%$noidung_nangcap%'");
		while ($r_nc = mysqli_fetch_assoc($thongtin_nangcap)) {
			$ngay = date('d', $r_nc['date_post']);
			$ngay = intval($ngay);
			$donhang_nangcap++;
			if($r_nc['sotien']<0){
				$doanhthu_nangcap += ($r_nc['sotien'])*-1;
			}else{
				$doanhthu_nangcap += $r_nc['sotien'];
			}
		}
		$thongtin = mysqli_query($conn, "SELECT * FROM donhang WHERE user_id IN ($list_id) AND date_post>='$dau' AND date_post<='$cuoi'");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$ngay = date('d', $r_tt['date_post']);
			$ngay = intval($ngay);
			if ($r_tt['status'] == 5) {
				$donhang_nhom++;
				$doanhthu_nhom += $r_tt['tamtinh'];
			}
		}
		$doanhthu_nhom=intval(($doanhthu_nhom/100)*5);
		$thongtin_ctv = mysqli_query($conn, "SELECT * FROM donhang_ctv WHERE user_id IN ($list_id) AND date_post>='$dau' AND date_post<='$cuoi'");
		while ($r_tt_ctv = mysqli_fetch_assoc($thongtin_ctv)) {
			$ngay = date('d', $r_tt_ctv['date_post']);
			$ngay = intval($ngay);
			if ($r_tt_ctv['status'] == 5) {
				$donhang_ctv_nhom++;
				$doanhthu_ctv_nhom += $r_tt_ctv['tamtinh'];
			}
		}
		$doanhthu_ctv_nhom=intval(($doanhthu_ctv_nhom/100)*5);
		$thongtin_aff = mysqli_query($conn, "SELECT * FROM user_info WHERE aff IN ($list_id) AND leader='0'");
		while ($r_aff = mysqli_fetch_assoc($thongtin_aff)) {
			$list_aff=$r_aff['user_id'].',';
		}
		if($list_aff==''){
			$hoahong_gioithieu=0;
			$donhang_nhom_gioithieu=0;

		}else{
			$list_aff=substr($list_aff, 0,-1);
			$thongtin_gioithieu = mysqli_query($conn, "SELECT * FROM donhang WHERE user_id IN ($list_aff) AND date_post>='$dau' AND date_post<='$cuoi'");
			while ($r_gt = mysqli_fetch_assoc($thongtin_gioithieu)) {
				$ngay = date('d', $r_tt['date_post']);
				$ngay = intval($ngay);
				if ($r_gt['status'] == 5) {
					$donhang_nhom_gioithieu++;
					$doanhthu_nhom_gioithieu += $r_gt['tamtinh'];
				}
			}
			$doanhthu_nhom_gioithieu=intval(($doanhthu_nhom/100)*5);
			$hoahong_gioithieu=intval(($doanhthu_nhom_gioithieu/100)*10);
		}
		$donhang_tong=$donhang_nhom + $donhang_ctv_nhom + $donhang_nhom_gioithieu;
		$doanhthu_tong=($doanhthu_nangcap/2) + $hoahong_gioithieu + $doanhthu_nhom + $doanhthu_ctv_nhom;
		$info = array(
			'donhang_nangcap' => $donhang_nangcap,
			'doanhthu_nangcap' => $doanhthu_nangcap/2,
			'donhang_nhom' => $donhang_nhom + $donhang_ctv_nhom,
			'doanhthu_nhom' => $doanhthu_nhom + $doanhthu_ctv_nhom,
			'donhang_nhom_gioithieu' => $donhang_nhom_gioithieu,
			'doanhthu_nhom_gioithieu' => $hoahong_gioithieu,
			'donhang_tong' => $donhang_tong,
			'doanhthu_tong' => $doanhthu_tong,
		);
		return json_encode($info);
	}
	///////////////////
	function thongke_donhang_nhom_nam($conn, $thanhvien, $dau, $cuoi) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$thongtin = mysqli_query($conn, "SELECT * FROM donhang WHERE date_post>='$dau' AND date_post<='$cuoi' AND user_id IN ($thanhvien)");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$month = date('m', $r_tt['date_post']);
			$month = intval($month);
			if ($month == 1) {
				$month_1++;
			} else if ($month == 2) {
				$month_2++;
			} else if ($month == 3) {
				$month_3++;
			} else if ($month == 4) {
				$month_4++;
			} else if ($month == 5) {
				$month_5++;
			} else if ($month == 6) {
				$month_6++;
			} else if ($month == 7) {
				$month_7++;
			} else if ($month == 8) {
				$month_8++;
			} else if ($month == 9) {
				$month_9++;
			} else if ($month == 10) {
				$month_10++;
			} else if ($month == 11) {
				$month_11++;

			} else if ($month == 12) {
				$month_12++;
			}
		}
		$thongtin_ctv = mysqli_query($conn, "SELECT * FROM donhang_ctv WHERE date_post>='$dau' AND date_post<='$cuoi' AND user_id IN ($thanhvien)");
		while ($r_tt_ctv = mysqli_fetch_assoc($thongtin_ctv)) {
			$month = date('m', $r_tt_ctv['date_post']);
			$month = intval($month);
			if ($month == 1) {
				$month_ctv_1++;
			} else if ($month == 2) {
				$month_ctv_2++;
			} else if ($month == 3) {
				$month_ctv_3++;
			} else if ($month == 4) {
				$month_ctv_4++;
			} else if ($month == 5) {
				$month_ctv_5++;
			} else if ($month == 6) {
				$month_ctv_6++;
			} else if ($month == 7) {
				$month_ctv_7++;
			} else if ($month == 8) {
				$month_ctv_8++;
			} else if ($month == 9) {
				$month_ctv_9++;
			} else if ($month == 10) {
				$month_ctv_10++;
			} else if ($month == 11) {
				$month_ctv_11++;

			} else if ($month == 12) {
				$month_ctv_12++;
			}
		}
		$month_1 = $month_1 + $month_ctv_1;
		$month_2 = $month_2 + $month_ctv_2;
		$month_3 = $month_3 + $month_ctv_3;
		$month_4 = $month_4 + $month_ctv_4;
		$month_5 = $month_5 + $month_ctv_5;
		$month_6 = $month_6 + $month_ctv_6;
		$month_7 = $month_7 + $month_ctv_7;
		$month_8 = $month_8 + $month_ctv_8;
		$month_9 = $month_9 + $month_ctv_9;
		$month_10 = $month_10 + $month_ctv_10;
		$month_11 = $month_11 + $month_ctv_11;
		$month_12 = $month_12 + $month_ctv_12;
		return intval($month_1) . ',' . intval($month_2) . ',' . intval($month_3) . ',' . intval($month_4) . ',' . intval($month_5) . ',' . intval($month_6) . ',' . intval($month_7) . ',' . intval($month_8) . ',' . intval($month_9) . ',' . intval($month_10) . ',' . intval($month_11) . ',' . intval($month_12);
	}
	///////////////////
	function thongke_donhang_nhom_thang($conn, $thanhvien, $thang, $nam, $dau, $cuoi) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$thongtin = mysqli_query($conn, "SELECT * FROM donhang WHERE date_post>='$dau' AND date_post<='$cuoi' AND user_id IN($thanhvien)");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$ngay = date('d', $r_tt['date_post']);
			$ngay = intval($ngay);
			if ($thang == 2) {
				if (checkdate(02, 29, $nam) == true) {
					for ($i = 1; $i <= 29; $i++) {
						if ($ngay == $i) {
							$data_ngay[$i]++;
						}
					}
				} else {
					for ($i = 1; $i <= 28; $i++) {
						if ($ngay == $i) {
							$data_ngay[$i]++;
						}
					}

				}
			} else if (in_array($thang, array('1', '3', '5', '7', '8', '10', '12')) == true) {
				for ($i = 1; $i <= 31; $i++) {
					if ($ngay == $i) {
						$data_ngay[$i]++;
					}
				}
			} else {
				for ($i = 1; $i <= 30; $i++) {
					if ($ngay == $i) {
						$data_ngay[$i]++;
					}
				}

			}

		}
		$thongtin_ctv = mysqli_query($conn, "SELECT * FROM donhang_ctv WHERE date_post>='$dau' AND date_post<='$cuoi' AND user_id IN($thanhvien)");
		while ($r_tt_ctv = mysqli_fetch_assoc($thongtin_ctv)) {
			$ngay = date('d', $r_tt_ctv['date_post']);
			$ngay = intval($ngay);
			if ($thang == 2) {
				if (checkdate(02, 29, $nam) == true) {
					for ($i = 1; $i <= 29; $i++) {
						if ($ngay == $i) {
							$data_ngay_ctv[$i]++;
						}
					}
				} else {
					for ($i = 1; $i <= 28; $i++) {
						if ($ngay == $i) {
							$data_ngay_ctv[$i]++;
						}
					}

				}
			} else if (in_array($thang, array('1', '3', '5', '7', '8', '10', '12')) == true) {
				for ($i = 1; $i <= 31; $i++) {
					if ($ngay == $i) {
						$data_ngay_ctv[$i]++;
					}
				}
			} else {
				for ($i = 1; $i <= 30; $i++) {
					if ($ngay == $i) {
						$data_ngay_ctv[$i]++;
					}
				}

			}

		}
		if ($thang == 2) {
			if (checkdate(02, 29, $nam) == true) {
				for ($i = 1; $i <= 29; $i++) {
					$data_thang .= intval($data_ngay[$i] + $data_ngay_ctv[$i]) . ',';
				}
			} else {
				for ($i = 1; $i <= 28; $i++) {
					$data_thang .= intval($data_ngay[$i] + $data_ngay_ctv[$i]) . ',';
				}

			}
		} else if (in_array($thang, array('1', '3', '5', '7', '8', '10', '12')) == true) {
			for ($i = 1; $i <= 31; $i++) {
				$data_thang .= intval($data_ngay[$i] + $data_ngay_ctv[$i]) . ',';
			}
		} else {
			for ($i = 1; $i <= 30; $i++) {
				$data_thang .= intval($data_ngay[$i] + $data_ngay_ctv[$i]) . ',';
			}

		}
		$data_thang = substr($data_thang, 0, -1);
		return $data_thang;
	}
	///////////////////
	function thongke_donhang_nhom_tuan($conn, $thanhvien, $dau, $cuoi) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$thongtin = mysqli_query($conn, "SELECT * FROM donhang WHERE date_post>='$dau' AND date_post<='$cuoi' AND user_id IN ($thanhvien)");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$month = date('m', $r_tt['date_post']);
			$day = date('d', $r_tt['date_post']);
			$year = date('Y', $r_tt['date_post']);
			$wkday = date('l', mktime('0', '0', '0', $month, $day, $year));
			if ($wkday == 'Monday') {
				$mon++;
			} else if ($wkday == 'Tuesday') {
				$tus++;
			} else if ($wkday == 'Wednesday') {
				$web++;
			} else if ($wkday == 'Thursday') {
				$thu++;
			} else if ($wkday == 'Friday') {
				$fri++;
			} else if ($wkday == 'Saturday') {
				$sat++;
			} else if ($wkday == 'Sunday') {
				$sun++;
			}
		}
		$thongtin_ctv = mysqli_query($conn, "SELECT * FROM donhang_ctv WHERE date_post>='$dau' AND date_post<='$cuoi' AND user_id IN ($thanhvien)");
		while ($r_tt_ctv = mysqli_fetch_assoc($thongtin_ctv)) {
			$month = date('m', $r_tt_ctv['date_post']);
			$day = date('d', $r_tt_ctv['date_post']);
			$year = date('Y', $r_tt_ctv['date_post']);
			$wkday = date('l', mktime('0', '0', '0', $month, $day, $year));
			if ($wkday == 'Monday') {
				$mon_ctv++;
			} else if ($wkday == 'Tuesday') {
				$tus_ctv++;
			} else if ($wkday == 'Wednesday') {
				$web_ctv++;
			} else if ($wkday == 'Thursday') {
				$thu_ctv++;
			} else if ($wkday == 'Friday') {
				$fri_ctv++;
			} else if ($wkday == 'Saturday') {
				$sat_ctv++;
			} else if ($wkday == 'Sunday') {
				$sun_ctv++;
			}
		}
		return intval($mon + $mon_ctv) . ',' . intval($tus + $tus_ctv) . ',' . intval($web + $web_ctv) . ',' . intval($thu + $thu_ctv) . ',' . intval($fri + $fri_ctv) . ',' . intval($sat + $sat_ctv) . ',' . intval($sun + $sun_ctv);
	}
	///////////////////
	function thongke_donhang_nam($conn, $user_id, $dau, $cuoi) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$thongtin = mysqli_query($conn, "SELECT * FROM donhang_shop WHERE date_post>='$dau' AND date_post<='$cuoi' AND shop ='$user_id'");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$month = date('m', $r_tt['date_post']);
			$month = intval($month);
			if ($month == 1) {
				$month_1++;
			} else if ($month == 2) {
				$month_2++;
			} else if ($month == 3) {
				$month_3++;
			} else if ($month == 4) {
				$month_4++;
			} else if ($month == 5) {
				$month_5++;
			} else if ($month == 6) {
				$month_6++;
			} else if ($month == 7) {
				$month_7++;
			} else if ($month == 8) {
				$month_8++;
			} else if ($month == 9) {
				$month_9++;
			} else if ($month == 10) {
				$month_10++;
			} else if ($month == 11) {
				$month_11++;

			} else if ($month == 12) {
				$month_12++;
			}
		}
		return intval($month_1) . ',' . intval($month_2) . ',' . intval($month_3) . ',' . intval($month_4) . ',' . intval($month_5) . ',' . intval($month_6) . ',' . intval($month_7) . ',' . intval($month_8) . ',' . intval($month_9) . ',' . intval($month_10) . ',' . intval($month_11) . ',' . intval($month_12);
	}
	///////////////////
	function thongke_donhang_thang($conn, $user_id, $thang, $nam, $dau, $cuoi) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$thongtin = mysqli_query($conn, "SELECT * FROM donhang_shop WHERE date_post>='$dau' AND date_post<='$cuoi' AND shop='$user_id'");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$ngay = date('d', $r_tt['date_post']);
			$ngay = intval($ngay);
			if ($thang == 2) {
				if (checkdate(02, 29, $nam) == true) {
					for ($i = 1; $i <= 29; $i++) {
						if ($ngay == $i) {
							$data_ngay[$i]++;
						}
					}
				} else {
					for ($i = 1; $i <= 28; $i++) {
						if ($ngay == $i) {
							$data_ngay[$i]++;
						}
					}

				}
			} else if (in_array($thang, array('1', '3', '5', '7', '8', '10', '12')) == true) {
				for ($i = 1; $i <= 31; $i++) {
					if ($ngay == $i) {
						$data_ngay[$i]++;
					}
				}
			} else {
				for ($i = 1; $i <= 30; $i++) {
					if ($ngay == $i) {
						$data_ngay[$i]++;
					}
				}

			}

		}
		if ($thang == 2) {
			if (checkdate(02, 29, $nam) == true) {
				for ($i = 1; $i <= 29; $i++) {
					$data_thang .= intval($data_ngay[$i]) . ',';
				}
			} else {
				for ($i = 1; $i <= 28; $i++) {
					$data_thang .= intval($data_ngay[$i]) . ',';
				}

			}
		} else if (in_array($thang, array('1', '3', '5', '7', '8', '10', '12')) == true) {
			for ($i = 1; $i <= 31; $i++) {
				$data_thang .= intval($data_ngay[$i]) . ',';
			}
		} else {
			for ($i = 1; $i <= 30; $i++) {
				$data_thang .= intval($data_ngay[$i]) . ',';
			}

		}
		$data_thang = substr($data_thang, 0, -1);
		return $data_thang;
	}
	///////////////////
	function thongke_donhang_tuan($conn, $user_id, $dau, $cuoi) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$thongtin = mysqli_query($conn, "SELECT * FROM donhang_shop WHERE date_post>='$dau' AND date_post<='$cuoi' AND shop='$user_id'");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$month = date('m', $r_tt['date_post']);
			$day = date('d', $r_tt['date_post']);
			$year = date('Y', $r_tt['date_post']);
			$wkday = date('l', mktime('0', '0', '0', $month, $day, $year));
			if ($wkday == 'Monday') {
				$mon++;
			} else if ($wkday == 'Tuesday') {
				$tus++;
			} else if ($wkday == 'Wednesday') {
				$web++;
			} else if ($wkday == 'Thursday') {
				$thu++;
			} else if ($wkday == 'Friday') {
				$fri++;
			} else if ($wkday == 'Saturday') {
				$sat++;
			} else if ($wkday == 'Sunday') {
				$sun++;
			}
		}
		return intval($mon) . ',' . intval($tus) . ',' . intval($web) . ',' . intval($thu) . ',' . intval($fri) . ',' . intval($sat) . ',' . intval($sun);
	}
	///////////////////
	function list_option_tinh_ninja($conn, $id) {
		$skin = $this->load('class_skin');
		$check = $this->load('class_check');
		$thongtin = mysqli_query($conn, "SELECT * FROM tinh_ninja ORDER BY ten_tinh ASC");
		$i = $start;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			if ($r_tt['ma_tinh'] == $id) {
				$list .= '<option value="' . $r_tt['ma_tinh'] . '" selected>' . $r_tt['ten_tinh'] . '</option>';
			} else {
				$list .= '<option value="' . $r_tt['ma_tinh'] . '">' . $r_tt['ten_tinh'] . '</option>';
			}
		}
		return $list;
	}
	///////////////////
	function list_option_tinh($conn, $id) {
		$skin = $this->load('class_skin');
		$check = $this->load('class_check');
		$thongtin = mysqli_query($conn, "SELECT * FROM tinh_moi ORDER BY tieu_de ASC");
		$i = $start;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			if ($r_tt['id'] == $id) {
				$list .= '<option value="' . $r_tt['id'] . '" selected>' . $r_tt['tieu_de'] . '</option>';
			} else {
				$list .= '<option value="' . $r_tt['id'] . '">' . $r_tt['tieu_de'] . '</option>';
			}
		}
		return $list;
	}
	///////////////////
	function list_option_huyen($conn, $tinh, $id) {
		$skin = $this->load('class_skin');
		$check = $this->load('class_check');
		$thongtin = mysqli_query($conn, "SELECT * FROM huyen_moi WHERE tinh='$tinh' ORDER BY thu_tu ASC");
		$i = $start;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			if ($r_tt['id'] == $id) {
				$list .= '<option value="' . $r_tt['id'] . '" selected>' . $r_tt['tieu_de'] . '</option>';
			} else {
				$list .= '<option value="' . $r_tt['id'] . '">' . $r_tt['tieu_de'] . '</option>';
			}
		}
		return $list;
	}
	///////////////////
	function list_option_xa($conn, $huyen, $id) {
		$skin = $this->load('class_skin');
		$check = $this->load('class_check');
		$thongtin = mysqli_query($conn, "SELECT * FROM xa_moi WHERE huyen='$huyen' ORDER BY thu_tu ASC");
		$i = $start;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			if ($r_tt['id'] == $id) {
				$list .= '<option value="' . $r_tt['id'] . '" selected>' . $r_tt['tieu_de'] . '</option>';
			} else {
				$list .= '<option value="' . $r_tt['id'] . '">' . $r_tt['tieu_de'] . '</option>';
			}
		}
		return $list;
	}
	///////////////////
	function list_option_huyen_ninja($conn, $tinh, $id) {
		$skin = $this->load('class_skin');
		$check = $this->load('class_check');
		$thongtin = mysqli_query($conn, "SELECT * FROM huyen_ninja WHERE ma_tinh='$tinh' ORDER BY ten_huyen ASC");
		$i = $start;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			if ($r_tt['ma_huyen'] == $id) {
				$list .= '<option value="' . $r_tt['ma_huyen'] . '" selected>' . $r_tt['ten_huyen'] . '</option>';
			} else {
				$list .= '<option value="' . $r_tt['ma_huyen'] . '">' . $r_tt['ten_huyen'] . '</option>';
			}
		}
		return $list;
	}
	///////////////////
	function list_option_xa_ninja($conn, $tinh,$huyen, $id) {
		$skin = $this->load('class_skin');
		$check = $this->load('class_check');
		$thongtin = mysqli_query($conn, "SELECT * FROM xa_ninja WHERE ma_tinh='$tinh' AND ma_huyen='$huyen' ORDER BY ten_xa ASC");
		$i = $start;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			if ($r_tt['ma_xa'] == $id) {
				$list .= '<option value="' . $r_tt['ma_xa'] . '" selected>' . $r_tt['ten_xa'] . '</option>';
			} else {
				$list .= '<option value="' . $r_tt['ma_xa'] . '">' . $r_tt['ten_xa'] . '</option>';
			}
		}
		return $list;
	}
	////////////////////
	function list_danhmuc_video($conn) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $start;
		$thongtin = mysqli_query($conn, "SELECT * FROM category_video ORDER BY thu_tu ASC");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$list .= $skin->skin_replace('skin_dropship/box_action/li_danhmuc_video', $r_tt);
		}
		return $list;
	}
	////////////////////
	function list_banner_qc($conn, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $start;
		$thongtin = mysqli_query($conn, "SELECT * FROM banner_qc WHERE active='1' ORDER BY thu_tu ASC LIMIT $limit");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$r_tt['blank'] = $check->blank($r_tt['post_tieude']);
			$i++;
			$r_tt['i'] = $i;
			$list .= $skin->skin_replace('skin_dropship/box_action/tr_banner_qc', $r_tt);
		}
		return $list;
	}
	////////////////////
	function list_slide($conn, $shop, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $start;
		$thongtin = mysqli_query($conn, "SELECT * FROM slide WHERE shop='$shop' ORDER BY thu_tu ASC LIMIT $start,$limit");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$r_tt['blank'] = $check->blank($r_tt['post_tieude']);
			$i++;
			$r_tt['i'] = $i;
			$list .= $skin->skin_replace('skin_dropship/box_action/tr_slide', $r_tt);
		}
		return $list;
	}
	///////////////////
	function list_share_sanpham($conn, $id) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$thongtin = mysqli_query($conn, "SELECT * FROM list_share_sanpham WHERE sp_id='$id' ORDER BY id ASC");
		$i = 0;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$r_tt['date_post'] = date('d/m/Y', $r_tt['date_post']);
			$r_tt['trich']=$check->words($r_tt['noi_dung'],30);
			//$r_tt['noi_dung']=strip_tags('<br><p>',$r_tt['noi_dung']);
			$r_tt['noi_dung']=preg_replace('/ style="(.*?)"/',"", $r_tt['noi_dung']);
			$r_tt['noi_dung']=str_replace('<br>', "<br>\n", $r_tt['noi_dung']);
			$r_tt['noi_dung']=str_replace('<br />', "<br />\n", $r_tt['noi_dung']);
			$r_tt['noi_dung']=str_replace('</p>', "</p>\n", $r_tt['noi_dung']);
			$r_tt['noi_dung']=strip_tags($r_tt['noi_dung']);
			//$r_tt['noi_dung'] = preg_replace("/([\r\n]{4,}|[\n]{2,}|[\r]{2,})/", "\n", $r_tt['noi_dung']);
			//$r_tt['noi_dung']=str_replace("&nbsp;", " ", $r_tt['noi_dung']);
			//$r_tt['noi_dung'] = implode("\n", array_filter(explode("\n", $r_tt['noi_dung'])));
			$tach_anh=explode(',', $r_tt['minh_hoa']);
			foreach ($tach_anh as $key => $value) {
				if(strlen($value)>0){
					$pt['src']=$value;
					$duoi = $check->duoi_file($value);
					if(in_array($duoi, array('mp4','wmv','mov'))==true){
						$list_anh .= $skin->skin_replace('skin_dropship/box_action/li_video_share', $pt);
					}else{
						$list_anh .= $skin->skin_replace('skin_dropship/box_action/li_anh_share', $pt);

					}
				}
			}
			$r_tt['list_anh']=$list_anh;
			if($i==1){
				$r_tt['active_tab']='active';
				$list_tab .= '<div class="li_tab_noidung active" tab_id="'.$r_tt['id'].'">Nội dung '.$i.'</div>';
			}else{
				$r_tt['active_tab']='';
				$list_tab .= '<div class="li_tab_noidung" tab_id="'.$r_tt['id'].'">Nội dung '.$i.'</div>';
			}
			if($check->is_mobile()==true){
				$list .= $skin->skin_replace('skin_dropship/box_action/tr_share_sanpham_mobile', $r_tt);
			}else{
				$list .= $skin->skin_replace('skin_dropship/box_action/tr_share_sanpham_laptop', $r_tt);
			}
			unset($list_anh);
		}
		$info=array(
			'list_tab'=>$list_tab,
			'list'=>$list
		);
		return json_encode($info);
	}
	///////////////////
	function list_share_sanpham_moi($conn, $id) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$thongtin = mysqli_query($conn, "SELECT * FROM list_share_sanpham WHERE sp_id='$id' ORDER BY id ASC");
		$i = 0;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$r_tt['date_post'] = date('d/m/Y', $r_tt['date_post']);
			$r_tt['trich']=$check->words($r_tt['noi_dung'],30);
			$r_tt['noi_dung']=preg_replace('/ style="(.*?)"/',"", $r_tt['noi_dung']);
			$r_tt['noi_dung']=str_replace('<br>', "<br>\n", $r_tt['noi_dung']);
			$r_tt['noi_dung']=str_replace('<br />', "<br />\n", $r_tt['noi_dung']);
			$r_tt['noi_dung']=str_replace('</p>', "</p>\n", $r_tt['noi_dung']);
			$r_tt['noi_dung']=strip_tags($r_tt['noi_dung']);
			$tach_anh=explode(',', $r_tt['minh_hoa']);
			$k=0;
			foreach ($tach_anh as $key => $value) {
				if(strlen($value)>0){
					$pt['src']=$value;
					$duoi = $check->duoi_file($value);
					if(in_array($duoi, array('mp4','wmv','mov'))==true){
						$list_anh .= $skin->skin_replace('skin_dropship/box_action/li_video_share', $pt);
					}else{
						$list_anh .= $skin->skin_replace('skin_dropship/box_action/li_anh_share', $pt);

					}
					$k++;
					if($k==1){
						$list_anh_scr.="{
					        title: 'Ảnh thứ ".$k."',
					        text: 'Mô tả cho ảnh ".$k."',
					        url: 'https://socdo.vn".$value."',
					      }";
					}else if($k<5){
						$list_anh_scr.="\n";
						$list_anh_scr.=",{
					        title: 'Ảnh thứ ".$k."',
					        text: 'Mô tả cho ảnh ".$k."',
					        url: 'https://socdo.vn".$value."',
					      }";
					}

				}
			}
			$r_tt['list_anh']=$list_anh;
			if($i==1){
				$r_tt['active_tab']='active';
				$list_tab .= '<div class="li_tab_noidung active" tab_id="'.$r_tt['id'].'">Nội dung '.$i.'</div>';
			}else{
				$r_tt['active_tab']='';
				$list_tab .= '<div class="li_tab_noidung" tab_id="'.$r_tt['id'].'">Nội dung '.$i.'</div>';
			}
			if($check->is_mobile()==true){
				$list .= $skin->skin_replace('skin_dropship/box_action/tr_share_sanpham_mobile', $r_tt);
			}else{
				$list .= $skin->skin_replace('skin_dropship/box_action/tr_share_sanpham_laptop', $r_tt);
			}
			$list_photo_share[]=$list_anh_scr;
			unset($list_anh_scr);
			unset($list_anh);
		}
		$info=array(
			'list_tab'=>$list_tab,
			'list'=>$list,
			'list_photo_share'=>$list_photo_share
		);
		return json_encode($info);
	}
	////////////////////
	function list_giaodien($conn, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $start;
		$thongtin = mysqli_query($conn, "SELECT * FROM giaodien ORDER BY thu_tu ASC LIMIT $start,$limit");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$r_tt['blank'] = $check->blank($r_tt['post_tieude']);
			$i++;
			$r_tt['i'] = $i;
			if ($r_tt['gia_cu'] > $r_tt['gia_moi']) {
				$r_tt['gia_cu'] = number_format($r_tt['gia_cu']) . 'đ';
			} else {
				$r_tt['gia_cu'] = '';
			}
			if ($r_tt['gia_moi'] == 0) {
				$r_tt['gia_moi'] = 'Miễn phí';
			} else {
				$r_tt['gia_moi'] = number_format($r_tt['gia_moi']) . 'đ';
			}
			$list .= $skin->skin_replace('skin_dropship/box_action/tr_giaodien', $r_tt);
		}
		return $list;
	}
	////////////////////
	function list_video_category($conn,$id, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $start;
		$thongtin = mysqli_query($conn, "SELECT * FROM video WHERE (loai LIKE '%all%' OR loai LIKE '%drop%') AND FIND_IN_SET($id,cat)>0 ORDER BY id DESC LIMIT $start,$limit");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$list .= $skin->skin_replace('skin_dropship/box_action/tr_video', $r_tt);
		}
		return $list;
	}
	////////////////////
	function list_video($conn, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $start;
		$thongtin = mysqli_query($conn, "SELECT * FROM video WHERE loai LIKE '%all%' OR loai LIKE '%drop%' ORDER BY id DESC LIMIT $start,$limit");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$list .= $skin->skin_replace('skin_dropship/box_action/tr_video', $r_tt);
		}
		return $list;
	}
	////////////////////
	function list_idol($conn, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $start;
		$thongtin = mysqli_query($conn, "SELECT * FROM idol WHERE an='0' ORDER BY thu_tu ASC LIMIT $start,$limit");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$list .= $skin->skin_replace('skin_dropship/box_action/tr_idol', $r_tt);
		}
		return $list;
	}
	////////////////////
	function list_dat_live($conn, $user_id, $total, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $total - $start + 1;
		$thongtin = mysqli_query($conn, "SELECT dat_live.*,idol.ho_ten FROM dat_live LEFT JOIN idol ON dat_live.idol=idol.id WHERE dat_live.user_id='$user_id' ORDER BY dat_live.id DESC LIMIT $start,$limit");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i--;
			$r_tt['i'] = $i;
			$r_tt['date_post'] = date('H:i:s d/m/Y', $r_tt['date_post']);
			if ($r_tt['status'] == 1) {
				$r_tt['status'] = 'Hoàn thành';
			} else if ($r_tt['status'] == 2) {
				$r_tt['status'] = 'Đã hủy';
			} else if ($r_tt['status'] == 3) {
				$r_tt['status'] = 'Đã xác nhận';
			} else {
				$r_tt['status'] = 'Chờ xử lý';
			}
			$r_tt['ngan_sach'] = number_format($r_tt['ngan_sach']);
			$r_tt['khung_gio'] = str_replace(':', 'h', $r_tt['khung_gio']);
			$list .= $skin->skin_replace('skin_dropship/box_action/tr_livestream', $r_tt);
		}
		return $list;
	}
	////////////////////
	function list_video_right($conn, $id, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $start;
		$thongtin = mysqli_query($conn, "SELECT * FROM video WHERE (loai LIKE '%all%' OR loai LIKE '%drop%') AND id!='$id' ORDER BY rand() ASC LIMIT $limit");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$list .= $skin->skin_replace('skin_dropship/box_action/tr_video', $r_tt);
		}
		return $list;
	}
	////////////////////
	function list_chitieu($conn, $user_id, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $start;
		$thongtin = mysqli_query($conn, "SELECT lichsu_chitieu.*,user_info.username FROM lichsu_chitieu LEFT JOIN user_info ON lichsu_chitieu.user_id=user_info.user_id WHERE lichsu_chitieu.user_id='$user_id' ORDER BY lichsu_chitieu.id DESC LIMIT $start,$limit");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$r_tt['date_post'] = date('H:i:s d/m/Y', $r_tt['date_post']);
			if (strpos($r_tt['sotien'], '-') !== false) {
				$r_tt['sotien'] = number_format($r_tt['sotien']);
			} else if ($r_tt['truoc'] < $r_tt['sau']) {
				$r_tt['sotien'] = '<span class="color_red">+' . number_format($r_tt['sotien']) . '</span>';
			} else if ($r_tt['truoc'] > $r_tt['sau']) {
				$r_tt['sotien'] = '-' . number_format($r_tt['sotien']);
			} else {
				if (strpos($r_tt['noidung'], 'Đặt hàng drop') !== false) {
					$r_tt['sotien'] = '-' . number_format($r_tt['sotien']);
				} else if (strpos($r_tt['noidung'], 'Mua') !== false) {
					$r_tt['sotien'] = '-' . number_format($r_tt['sotien']);
				} else if (strpos($r_tt['noidung'], 'Cài đặt giao diện') !== false) {
					$r_tt['sotien'] = '-' . number_format($r_tt['sotien']);
				} else if (strpos($r_tt['noidung'], 'Đặt mua tên miền') !== false) {
					$r_tt['sotien'] = '-' . number_format($r_tt['sotien']);
				} else if (strpos($r_tt['noidung'], 'Yêu cầu hỗ trợ cài đặt tên miền') !== false) {
					$r_tt['sotien'] = '-' . number_format($r_tt['sotien']);
				} else if (strpos($r_tt['noidung'], 'hoàn') !== false) {
					$r_tt['sotien'] = '<span class="color_red">+' . number_format($r_tt['sotien']) . '</span>';
				} else if (strpos($r_tt['noidung'], 'Hoàn') !== false) {
					$r_tt['sotien'] = '<span class="color_red">+' . number_format($r_tt['sotien']) . '</span>';
				} else if (strpos($r_tt['noidung'], 'tặng') !== false) {
					$r_tt['sotien'] = '<span class="color_red">+' . number_format($r_tt['sotien']) . '</span>';
				} else if (strpos($r_tt['noidung'], 'Tặng') !== false) {
					$r_tt['sotien'] = '<span class="color_red">+' . number_format($r_tt['sotien']) . '</span>';
				} else if (strpos($r_tt['noidung'], 'thưởng') !== false) {
					$r_tt['sotien'] = '<span class="color_red">+' . number_format($r_tt['sotien']) . '</span>';
				} else if (strpos($r_tt['noidung'], 'Thưởng') !== false) {
					$r_tt['sotien'] = '<span class="color_red">+' . number_format($r_tt['sotien']) . '</span>';
				} else {
					$r_tt['sotien'] = number_format($r_tt['sotien']);
				}
			}
			//$r_tt['sotien'] = number_format($r_tt['sotien']) . ' đ';
			$list .= $skin->skin_replace('skin_dropship/box_action/tr_chitieu', $r_tt);
		}
		return $list;
	}
	////////////////////
	function list_naptien($conn, $user_id, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $start;
		$thongtin = mysqli_query($conn, "SELECT naptien.*,user_info.username FROM naptien LEFT JOIN user_info ON naptien.user_id=user_info.user_id WHERE naptien.user_id='$user_id' ORDER BY naptien.id DESC LIMIT $start,$limit");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$r_tt['date_post'] = date('H:i:s d/m/Y', $r_tt['date_post']);
			$r_tt['sotien'] = number_format($r_tt['sotien']) . ' đ';
			if ($r_tt['status'] == 1) {
				$r_tt['status'] = 'Hoàn thành';
				$r_tt['hanhdong'] = '';
			} else if ($r_tt['status'] == 2) {
				$r_tt['status'] = 'Đã hủy';
				$r_tt['hanhdong'] = '';
			} else if ($r_tt['status'] == 3) {
				$r_tt['status'] = 'Chờ xác nhận';
				$r_tt['hanhdong'] = '';
			} else {
				$r_tt['status'] = 'Chờ xử lý';
				$r_tt['hanhdong'] = '<a href="/dropship/edit-naptien?id=' . $r_tt['id'] . '" class="edit">chi tiết</a>';
			}
			$r_tt['noidung'] = 'naptien ' . $r_tt['username'] . ' ' . $r_tt['id'];
			$list .= $skin->skin_replace('skin_dropship/box_action/tr_naptien', $r_tt);
		}
		return $list;
	}
	////////////////////
	function list_domain($conn, $loai) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $start;
		$thongtin = mysqli_query($conn, "SELECT * FROM domain_price ORDER BY thu_tu ASC");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			if ($loai == 'all') {
				if ($r_tt['loai'] == 'quocte') {
					$list .= '<div class="li_domain li_domain_quocte active"><input type="checkbox" name="loai_domain[]" value="' . $r_tt['domain'] . '"> ' . $r_tt['domain'] . '</div>';
				} else {
					$list .= '<div class="li_domain li_domain_vietnam active"><input type="checkbox" name="loai_domain[]" value="' . $r_tt['domain'] . '"> ' . $r_tt['domain'] . '</div>';
				}
			} else if ($loai == 'quocte') {
				if ($r_tt['loai'] == 'quocte') {
					$list .= '<div class="li_domain li_domain_quocte active"><input type="checkbox" name="loai_domain[]" value="' . $r_tt['domain'] . '"> ' . $r_tt['domain'] . '</div>';
				} else {
					$list .= '<div class="li_domain li_domain_vietnam"><input type="checkbox" name="loai_domain[]" value="' . $r_tt['domain'] . '"> ' . $r_tt['domain'] . '</div>';
				}
			} else if ($loai == 'vietnam') {
				if ($r_tt['loai'] == 'vietnam') {
					$list .= '<div class="li_domain li_domain_vietnam active"><input type="checkbox" name="loai_domain[]" value="' . $r_tt['domain'] . '"> ' . $r_tt['domain'] . '</div>';
				} else {
					$list .= '<div class="li_domain li_domain_quocte"><input type="checkbox" name="loai_domain[]" value="' . $r_tt['domain'] . '"> ' . $r_tt['domain'] . '</div>';
				}
			}
		}
		return $list;
	}
	////////////////////
	function list_ruttien($conn, $user_id, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $start;
		$thongtin = mysqli_query($conn, "SELECT * FROM rut_tien WHERE user_id='$user_id' ORDER BY id DESC LIMIT $start,$limit");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$r_tt['date_post'] = date('H:i:s d/m/Y', $r_tt['date_post']);
			$r_tt['so_tien'] = number_format($r_tt['so_tien']) . ' đ';
			if ($r_tt['status'] == 1) {
				$r_tt['status'] = 'Hoàn thành';
				$r_tt['hanhdong'] = '';
			} else if ($r_tt['status'] == 2) {
				$r_tt['status'] = 'Đã hủy';
				$r_tt['hanhdong'] = '';
			} else {
				$r_tt['status'] = 'Chờ xử lý';
			}
			$list .= $skin->skin_replace('skin_dropship/box_action/tr_ruttien', $r_tt);
		}
		return $list;
	}
	////////////////////
	function list_goi_seeding($conn, $loai) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $start;
		$thongtin = mysqli_query($conn, "SELECT * FROM seeding_shopee WHERE loai='$loai' ORDER BY thu_tu ASC");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			if ($i % 2 == 0) {
				$r_tt['class'] = 'dt-light dt-center';
			} else {
				$r_tt['class'] = 'dt-gray dt-center';
			}
			$tach_uudai = explode("\n", $r_tt['uu_dai']);
			foreach ($tach_uudai as $key => $value) {
				$list_uudai .= '<tr><td>' . $value . '</td></tr>';
			}
			$r_tt['list_uudai'] = $list_uudai;
			unset($list_uudai);
			$r_tt['i'] = $i;
			$r_tt['gia'] = number_format($r_tt['gia']);
			$r_tt['gia_cu'] = number_format($r_tt['gia_cu']);
			$list .= $skin->skin_replace('skin_dropship/box_action/tr_goi_dichvu', $r_tt);

		}
		return $list;
	}
	////////////////////
	function list_coupon($conn, $shop, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $start;
		$thongtin = mysqli_query($conn, "SELECT * FROM coupon WHERE shop='$shop' ORDER BY id DESC LIMIT $start,$limit");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			if ($r_tt['loai'] == 'phantram') {
				$r_tt['giam'] = $r_tt['giam'] . '%';
			} else {
				$r_tt['giam'] = number_format($r_tt['giam']) . 'đ';
			}
			$r_tt['start'] = date('H:i:s d/m/Y', $r_tt['start']);
			$r_tt['expired'] = date('H:i:s d/m/Y', $r_tt['expired']);
			$list .= $skin->skin_replace('skin_dropship/box_action/tr_coupon', $r_tt);
		}
		return $list;
	}
	////////////////////
	function list_deal($conn, $shop, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $start;
		$thongtin = mysqli_query($conn, "SELECT * FROM deal WHERE shop='$shop' AND (loai='muakem' OR loai='tang') ORDER BY id DESC LIMIT $start,$limit");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$r_tt['start'] = date('H:i:s d/m/Y', $r_tt['date_start']);
			$r_tt['end'] = date('H:i:s d/m/Y', $r_tt['date_end']);
			if ($r_tt['loai'] == 'muakem') {
				$r_tt['loai'] = 'Mua kèm deal sốc';
			} else if ($r_tt['loai'] == 'tang') {
				$r_tt['loai'] = 'Mua để nhận quà';
			}
			$list .= $skin->skin_replace('skin_dropship/box_action/tr_deal', $r_tt);
		}
		return $list;
	}
	////////////////////
	function list_flash_sale($conn, $shop, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $start;
		$thongtin = mysqli_query($conn, "SELECT * FROM deal WHERE shop='$shop' AND loai='flash_sale' ORDER BY id DESC LIMIT $start,$limit");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$r_tt['start'] = date('H:i:s d/m/Y', $r_tt['date_start']);
			$r_tt['end'] = date('H:i:s d/m/Y', $r_tt['date_end']);
			if ($r_tt['loai'] == 'muakem') {
				$r_tt['loai'] = 'Mua kèm deal sốc';
			} else if ($r_tt['loai'] == 'tang') {
				$r_tt['loai'] = 'Mua để nhận quà';
			}
			$list .= $skin->skin_replace('skin_dropship/box_action/tr_flash_sale', $r_tt);
		}
		return $list;
	}
	////////////////////
	function list_donhang_affiliate($conn, $user_id, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $start;
		$thongtin = mysqli_query($conn, "SELECT * FROM donhang WHERE utm_source='$user_id' ORDER BY date_post DESC LIMIT $start,$limit");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$r_tt['tongtien'] = number_format($r_tt['tongtien']) . 'đ';
			$r_tt['date_post'] = date('d/m/Y', $r_tt['date_post']);
			if ($r_tt['status'] == 1) {
				$r_tt['status'] = 'Đã tiếp nhận đơn';
				$r_tt['huy'] = '';
			} else if ($r_tt['status'] == 2) {
				$r_tt['status'] = 'Đã giao đơn vị vận chuyển';
				$r_tt['huy'] = '';
			} else if ($r_tt['status'] == 3) {
				$r_tt['status'] = 'Yêu cầu hủy đơn';
				$r_tt['huy'] = '';
			} else if ($r_tt['status'] == 4) {
				$r_tt['status'] = 'Đã hủy đơn';
				$r_tt['huy'] = '';
			} else if ($r_tt['status'] == 5) {
				$r_tt['status'] = 'Giao thành công';
				$r_tt['huy'] = '';
			} else if ($r_tt['status'] == 6) {
				$r_tt['status'] = 'Đã hoàn đơn';
				$r_tt['huy'] = '';
			} else {
				$r_tt['huy'] = '<a href="javascript:;" onclick="confirm_action(\'huy_donhang_drop\', \'Hủy đơn hàng drop\', \'' . $r_tt['id'] . '\')" class="del">hủy</a>';
				$r_tt['status'] = 'Chờ xử lý';
			}
			$tach_sanpham = json_decode($r_tt['sanpham'], true);
			foreach ($tach_sanpham as $key => $value) {
				$s++;
				if ($value['size'] != '') {
					$value['size'] = ' - Size: ' . strtoupper($value['size']);
				}
				if ($value['color'] != '') {
					$value['color'] = ' - Màu: ' . $value['color'];
				}
				$tong_hoahong+=$value['hoa_hong'];
				$list_sanpham .= '+' . $value['tieu_de'] . '' . $value['color'] . '' . $value['size'] . ' - Hoa hồng: '.number_format($value['hoa_hong']).' đ<br>';
			}
			$r_tt['hoa_hong']=number_format(intval($tong_hoahong)).' đ';
			$r_tt['list_sanpham'] = $list_sanpham;
			$list .= $skin->skin_replace('skin_dropship/box_action/tr_donhang_aff', $r_tt);
			unset($list_sanpham);
			unset($tong_hoahong);
		}
		return $list;
	}
	////////////////////
	function list_donhang_socdo($conn, $user_id, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $start;
		$thongtin = mysqli_query($conn, "SELECT * FROM donhang_ctv WHERE user_id='$user_id' ORDER BY date_post DESC LIMIT $start,$limit");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$r_tt['tongtien'] = number_format($r_tt['tongtien']) . 'đ';
			$r_tt['hoahong'] = number_format($r_tt['hoahong']) . 'đ';
			$r_tt['date_post'] = date('d/m/Y', $r_tt['date_post']);
			if ($r_tt['status'] == 1) {
				$r_tt['status'] = 'Đã tiếp nhận đơn';
				$r_tt['huy'] = '';
			} else if ($r_tt['status'] == 2) {
				$r_tt['status'] = 'Đã giao đơn vị vận chuyển';
				$r_tt['huy'] = '';
			} else if ($r_tt['status'] == 3) {
				$r_tt['status'] = 'Yêu cầu hủy đơn';
				$r_tt['huy'] = '';
			} else if ($r_tt['status'] == 4) {
				$r_tt['status'] = 'Đã hủy đơn';
				$r_tt['huy'] = '';
			} else if ($r_tt['status'] == 5) {
				$r_tt['status'] = 'Giao thành công';
				$r_tt['huy'] = '';
			} else if ($r_tt['status'] == 6) {
				$r_tt['status'] = 'Đã hoàn đơn';
				$r_tt['huy'] = '';
			} else {
				$r_tt['huy'] = '<a href="javascript:;" onclick="confirm_action(\'huy_donhang_socdo\', \'Hủy đơn hàng\', \'' . $r_tt['id'] . '\')" class="del">hủy</a>';
				$r_tt['status'] = 'Chờ xử lý';
			}
			$tach_sanpham = json_decode($r_tt['sanpham'], true);
			foreach ($tach_sanpham as $key => $value) {
				$s++;
				if ($value['size'] != '') {
					$value['size'] = ' - Size: ' . strtoupper($value['size']);
				}
				if ($value['color'] != '') {
					$value['color'] = ' - Màu: ' . $value['color'];
				}
				$list_sanpham .= '+' . $value['tieu_de'] . '' . $value['color'] . '' . $value['size'] . '<br>';
			}
			$r_tt['list_sanpham'] = $list_sanpham;
			unset($list_sanpham);
			$list .= $skin->skin_replace('skin_dropship/box_action/tr_donhang_socdo', $r_tt);
		}
		return $list;
	}
	////////////////////
	function list_donhang_drop($conn, $user_id, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $start;
		$thongtin = mysqli_query($conn, "SELECT * FROM donhang WHERE user_id='$user_id' AND dropship='1' ORDER BY date_post DESC LIMIT $start,$limit");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$r_tt['tongtien'] = number_format($r_tt['tongtien']) . 'đ';
			$r_tt['date_post'] = date('d/m/Y', $r_tt['date_post']);
			if ($r_tt['status'] == 1) {
				$r_tt['status'] = 'Đã tiếp nhận đơn';
				$r_tt['huy'] = '';
			} else if ($r_tt['status'] == 2) {
				$r_tt['status'] = 'Đã giao đơn vị vận chuyển';
				$r_tt['huy'] = '';
			} else if ($r_tt['status'] == 3) {
				$r_tt['status'] = 'Yêu cầu hủy đơn';
				$r_tt['huy'] = '';
			} else if ($r_tt['status'] == 4) {
				$r_tt['status'] = 'Đã hủy đơn';
				$r_tt['huy'] = '';
			} else if ($r_tt['status'] == 5) {
				$r_tt['status'] = 'Giao thành công';
				$r_tt['huy'] = '';
			} else if ($r_tt['status'] == 6) {
				$r_tt['status'] = 'Đã hoàn đơn';
				$r_tt['huy'] = '';
			} else {
				$r_tt['huy'] = '<a href="javascript:;" onclick="confirm_action(\'huy_donhang_drop\', \'Hủy đơn hàng drop\', \'' . $r_tt['id'] . '\')" class="del">hủy</a>';
				$r_tt['status'] = 'Chờ xử lý';
			}
			$tach_sanpham = json_decode($r_tt['sanpham'], true);
			foreach ($tach_sanpham as $key => $value) {
				$s++;
				if ($value['size'] != '') {
					$value['size'] = ' - Size: ' . strtoupper($value['size']);
				}
				if ($value['color'] != '') {
					$value['color'] = ' - Màu: ' . $value['color'];
				}
				$list_sanpham .= '+' . $value['tieu_de'] . '' . $value['color'] . '' . $value['size'] . '<br>';
			}
			$r_tt['list_sanpham'] = $list_sanpham;
			unset($list_sanpham);
			$list .= $skin->skin_replace('skin_dropship/box_action/tr_donhang_drop', $r_tt);
		}
		return $list;
	}
	////////////////////
	function list_donhang_moi($conn, $user_id, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $start;
		$ngay=date('d-m-Y');
		if($user_id==''){
			$thongtin = mysqli_query($conn, "SELECT thongbao_don.*,user_info.avatar FROM thongbao_don LEFT JOIN user_info ON thongbao_don.user_id=user_info.user_id WHERE thongbao_don.ngay='$ngay' ORDER BY thongbao_don.date_post ASC");
		}else{
			$thongtin = mysqli_query($conn, "SELECT thongbao_don.*,user_info.avatar FROM thongbao_don LEFT JOIN user_info ON thongbao_don.user_id=user_info.user_id WHERE thongbao_don.user_id='$user_id' AND thongbao_don.ngay='$ngay' ORDER BY thongbao_don.date_post ASC");
		}
		$total=mysqli_num_rows($thongtin);
		if($total==0){
			$list='<p><center>Chưa có đơn nào trong ngày, cần cố gắng hơn!</center></p>';
		}else{
			while ($r_tt = mysqli_fetch_assoc($thongtin)) {
				$i++;
				$r_tt['i'] = $i;
				$r_tt['dien_thoai']=substr($r_tt['dien_thoai'], 0,-3).'xxx';
				$r_tt['tong_tien'] = number_format($r_tt['tong_tien']) . 'đ';
				$r_tt['date_post'] = $check->chat_update($r_tt['date_post']);
				if($r_tt['user_id']>0){
					$u=$r_tt['user_id'];
					$sodon[$u]++;
					if($sodon[$u]>1){
						$noi_dung='Vừa có <b>đơn hàng thứ '.$sodon[$u].'</b> trong ngày';
					}else{
						$noi_dung='Vừa có đơn hàng';
					}
				}else{
					$noi_dung='Vừa có đơn hàng';
				}
				$r_tt['noi_dung']=$noi_dung;
				$list_cu_slide[].= $skin->skin_replace('skin_dropship/box_action/li_donhang_slide', $r_tt);
				$list_cu[].= $skin->skin_replace('skin_dropship/box_action/li_donhang', $r_tt);
			}
			//print_r($list_cu);
			$list_moi=array_reverse($list_cu);
			foreach ($list_moi as $key => $value) {
				$list .= $value;
			}
			$list_moi_slide=array_reverse($list_cu_slide);
			foreach ($list_moi_slide as $key => $value) {
				$list_slide .= $value;
			}
		}
		$info=array(
			'list'=>$list,
			'list_slide'=>$list_slide
		);
		return json_encode($info);
	}
	////////////////////
	function list_donhang($conn, $shop, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $start;
		$thongtin = mysqli_query($conn, "SELECT * FROM donhang_shop WHERE shop='$shop' ORDER BY date_post DESC LIMIT $start,$limit");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$r_tt['tongtien'] = number_format($r_tt['tongtien']) . 'đ';
			$r_tt['date_post'] = date('d/m/Y', $r_tt['date_post']);
			if ($r_tt['status'] == 1) {
				$r_tt['status'] = 'Đã tiếp nhận đơn';
				$r_tt['huy'] = '';
			} else if ($r_tt['status'] == 2) {
				$r_tt['status'] = 'Đã giao đơn vị vận chuyển';
				$r_tt['huy'] = '';
			} else if ($r_tt['status'] == 3) {
				$r_tt['status'] = 'Yêu cầu hủy đơn';
				$r_tt['huy'] = '';
			} else if ($r_tt['status'] == 4) {
				$r_tt['status'] = 'Đã hủy đơn';
				$r_tt['huy'] = '';
			} else if ($r_tt['status'] == 5) {
				$r_tt['status'] = 'Giao thành công';
				$r_tt['huy'] = '';
			} else if ($r_tt['status'] == 6) {
				$r_tt['status'] = 'Đã hoàn đơn';
				$r_tt['huy'] = '';
			} else {
				$r_tt['status'] = 'Chờ xử lý';
			}
			$tach_sanpham = json_decode($r_tt['sanpham'], true);
			foreach ($tach_sanpham as $key => $value) {
				$s++;
				if ($value['size'] != '') {
					$value['size'] = ' - Size: ' . $value['size'];
				}
				if ($value['color'] != '') {
					$value['color'] = ' - Màu: ' . $value['color'];
				}
				$list_sanpham .= '+' . $value['tieu_de'] . '' . $value['color'] . '' . $value['size'] . '<br>';
			}
			$r_tt['list_sanpham'] = $list_sanpham;
			unset($list_sanpham);
			$list .= $skin->skin_replace('skin_dropship/box_action/tr_donhang_shop', $r_tt);
		}
		return $list;
	}
	////////////////////
	function list_category($conn, $shop, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $start;
		$thongtin = mysqli_query($conn, "SELECT * FROM category_shop WHERE shop='$shop' ORDER BY cat_main ASC, cat_thutu ASC LIMIT $start,$limit");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$r_tt['blank'] = $check->blank($r_tt['post_tieude']);
			$i++;
			$r_tt['i'] = $i;
			if ($r_tt['cat_icon'] == '') {
				$r_tt['cat_icon'] = '<span class="icon"><i class="icon icon-movie"></i></span>';
			}
			$list .= $skin->skin_replace('skin_dropship/box_action/tr_category', $r_tt);
		}
		return $list;
	}
	////////////////////
	function list_category_sanpham($conn, $shop, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $start;
		$thongtin = mysqli_query($conn, "SELECT * FROM category_sanpham_shop WHERE shop='$shop' ORDER BY cat_main ASC, cat_thutu ASC LIMIT $start,$limit");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$r_tt['blank'] = $check->blank($r_tt['post_tieude']);
			$i++;
			$r_tt['i'] = $i;
			if ($r_tt['cat_main'] == 0) {
				$r_tt['tieude_main'] = 'Danh mục chính';
			} else {
				$thongtin_main = mysqli_query($conn, "SELECT * FROM category_sanpham_shop WHERE cat_id='{$r_tt['cat_main']}'");
				$r_main = mysqli_fetch_assoc($thongtin_main);
				$r_tt['tieude_main'] = $r_main['cat_tieude'];
			}
			if ($r_tt['cat_icon'] == '') {
				$r_tt['cat_icon'] = '<span class="icon"><i class="icon icon-movie"></i></span>';
			}
			$list .= $skin->skin_replace('skin_dropship/box_action/tr_category_sanpham', $r_tt);
		}
		return $list;
	}
	///////////////////
	function list_option_danhmuc($conn, $id) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$thongtin = mysqli_query($conn, "SELECT * FROM category_sanpham WHERE cat_main='0' ORDER BY cat_thutu ASC");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			if ($r_tt['cat_id'] == $id) {
				$list .= '<option value="' . $r_tt['cat_id'] . '" selected>' . $r_tt['cat_tieude'] . '</option>';
			} else {
				$list .= '<option value="' . $r_tt['cat_id'] . '">' . $r_tt['cat_tieude'] . '</option>';
			}
		}
		return $list;
	}
	///////////////////
	function list_option_category_sanpham($conn, $shop, $id) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$thongtin = mysqli_query($conn, "SELECT * FROM category_sanpham_shop WHERE shop='$shop' ORDER BY cat_thutu ASC");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$r_tt['blank'] = $check->blank($r_tt['post_tieude']);
			$i++;
			if ($r_tt['cat_id'] == $id) {
				$list .= '<option value="' . $r_tt['cat_id'] . '" selected>' . $r_tt['cat_tieude'] . '</option>';
			} else {
				$list .= '<option value="' . $r_tt['cat_id'] . '">' . $r_tt['cat_tieude'] . '</option>';
			}
		}
		return $list;
	}
	///////////////////
	function list_option_category($conn, $shop, $id) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$thongtin = mysqli_query($conn, "SELECT * FROM category_shop WHERE shop='$shop' ORDER BY cat_thutu ASC");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$r_tt['blank'] = $check->blank($r_tt['post_tieude']);
			$i++;
			if ($r_tt['cat_id'] == $id) {
				$list .= '<option value="' . $r_tt['cat_id'] . '" selected>' . $r_tt['cat_tieude'] . '</option>';
			} else {
				$list .= '<option value="' . $r_tt['cat_id'] . '">' . $r_tt['cat_tieude'] . '</option>';
			}
		}
		return $list;
	}
	///////////////////
	function list_option_brand($conn, $shop, $id) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$thongtin = mysqli_query($conn, "SELECT * FROM thuong_hieu WHERE shop='$shop' ORDER BY thu_tu ASC");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			if ($r_tt['id'] == $id) {
				$list .= '<option value="' . $r_tt['id'] . '" selected>' . $r_tt['tieu_de'] . '</option>';
			} else {
				$list .= '<option value="' . $r_tt['id'] . '">' . $r_tt['tieu_de'] . '</option>';
			}
		}
		return $list;
	}
	///////////////////
	function list_option_size($conn, $shop, $id) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$thongtin = mysqli_query($conn, "SELECT * FROM kich_co WHERE shop='$shop' ORDER BY thu_tu ASC");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			if ($r_tt['id'] == $id) {
				$list .= '<option value="' . $r_tt['id'] . '" selected>' . $r_tt['tieu_de'] . '</option>';
			} else {
				$list .= '<option value="' . $r_tt['id'] . '">' . $r_tt['tieu_de'] . '</option>';
			}
		}
		return $list;
	}
	//////////////////////////////////////////////////////////////////
	function list_div_category($conn, $shop, $category) {
		$tach_category = explode(',', $category);
		$thongtin = mysqli_query($conn, "SELECT * FROM category_shop WHERE shop='$shop' ORDER BY cat_thutu ASC");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			if (in_array($r_tt['cat_id'], $tach_category) == true) {
				$list .= '<div class="li_input" id="input_' . $r_tt['cat_id'] . '"><input type="checkbox" name="category[]" value="' . $r_tt['cat_id'] . '" checked> ' . $r_tt['cat_tieude'] . '</div>';
			} else {
				$list .= '<div class="li_input" id="input_' . $r_tt['cat_id'] . '"><input type="checkbox" name="category[]" value="' . $r_tt['cat_id'] . '"> ' . $r_tt['cat_tieude'] . '</div>';
			}
		}
		return $list;
	}
	//////////////////////////////////////////////////////////////////
	function list_div_category_sanpham($conn, $shop, $category) {
		$tach_category = explode(',', $category);
		$thongtin = mysqli_query($conn, "SELECT * FROM category_sanpham_shop WHERE shop='$shop' ORDER BY cat_thutu ASC");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			if (in_array($r_tt['cat_id'], $tach_category) == true) {
				$list .= '<div class="li_input" id="input_' . $r_tt['cat_id'] . '"><input type="checkbox" name="category[]" value="' . $r_tt['cat_id'] . '" checked> ' . $r_tt['cat_tieude'] . '</div>';
			} else {
				$list .= '<div class="li_input" id="input_' . $r_tt['cat_id'] . '"><input type="checkbox" name="category[]" value="' . $r_tt['cat_id'] . '"> ' . $r_tt['cat_tieude'] . '</div>';
			}
		}
		return $list;
	}
	//////////////////////////////////////////////////////////////////
	function list_div_main_category_sanpham($conn, $shop, $category) {
		$tach_category = explode(',', $category);
		$thongtin = mysqli_query($conn, "SELECT * FROM category_sanpham_shop WHERE cat_main='0' AND shop='$shop' ORDER BY cat_main ASC,cat_thutu ASC");
		$total = 0;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$total++;
			if (in_array($r_tt['cat_id'], $tach_category) == true) {
				$list .= '<div class="li_input" id="input_' . $r_tt['cat_id'] . '"><input type="checkbox" name="category[]" value="' . $r_tt['cat_id'] . '" checked> ' . $r_tt['cat_tieude'] . '</div>';
				$list_id .= $r_tt['cat_id'] . ',';
			} else {
				$list .= '<div class="li_input" id="input_' . $r_tt['cat_id'] . '"><input type="checkbox" name="category[]" value="' . $r_tt['cat_id'] . '"> ' . $r_tt['cat_tieude'] . '</div>';
			}

		}
		$list_id = substr($list_id, 0, -1);
		return json_encode(array('list' => $list, 'list_id' => $list_id, 'total' => $total));
	}
	//////////////////////////////////////////////////////////////////
	function list_div_sub_category_sanpham($conn, $shop, $main, $category) {
		$tach_category = explode(',', $category);
		if($main==''){
			$thongtin = mysqli_query($conn, "SELECT * FROM category_sanpham_shop WHERE shop='$shop' ORDER BY cat_main ASC,cat_thutu ASC");
		}else{
			$thongtin = mysqli_query($conn, "SELECT * FROM category_sanpham_shop WHERE cat_main IN ($main) AND shop='$shop' ORDER BY cat_main ASC,cat_thutu ASC");
		}
		$total = 0;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$total++;
			if (in_array($r_tt['cat_id'], $tach_category) == true) {
				$list_id .= $r_tt['cat_id'] . ',';
				$list .= '<div class="li_input li_input_' . $r_tt['cat_main'] . '" id="input_' . $r_tt['cat_id'] . '"><input type="checkbox" name="category[]" main_id="' . $r_tt['cat_main'] . '" value="' . $r_tt['cat_id'] . '" checked> ' . $r_tt['cat_tieude'] . '</div>';
			} else {
				$list .= '<div class="li_input li_input_' . $r_tt['cat_main'] . '" id="input_' . $r_tt['cat_id'] . '"><input type="checkbox" name="category[]" main_id="' . $r_tt['cat_main'] . '" value="' . $r_tt['cat_id'] . '"> ' . $r_tt['cat_tieude'] . '</div>';
			}
		}
		$list_id = substr($list_id, 0, -1);
		return json_encode(array('list' => $list, 'list_id' => $list_id, 'total' => $total));
	}
	//////////////////////////////////////////////////////////////////
	function list_div_sub_sub_category_sanpham($conn, $shop, $main, $category) {
		$tach_category = explode(',', $category);
		if($main==''){
			$thongtin = mysqli_query($conn, "SELECT *,(SELECT cat_main FROM category_sanpham_shop c WHERE category_sanpham_shop.cat_main=c.cat_id) AS main_main FROM category_sanpham_shop WHERE shop='$shop' ORDER BY cat_main ASC,cat_thutu ASC");
		}else{
			$thongtin = mysqli_query($conn, "SELECT *,(SELECT cat_main FROM category_sanpham_shop c WHERE category_sanpham_shop.cat_main=c.cat_id) AS main_main FROM category_sanpham_shop WHERE cat_main IN ($main) AND shop='$shop' ORDER BY cat_main ASC,cat_thutu ASC");
		}
		$total = 0;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$total++;
			if (in_array($r_tt['cat_id'], $tach_category) == true) {
				$list_id .= $r_tt['cat_id'] . ',';
				$list .= '<div class="li_input li_input_' . $r_tt['cat_main'] . ' li_input_main_' . $r_tt['main_main'] . '" id="input_' . $r_tt['cat_id'] . '"><input type="checkbox" name="category[]" value="' . $r_tt['cat_id'] . '" checked> ' . $r_tt['cat_tieude'] . '</div>';
			} else {
				$list .= '<div class="li_input li_input_' . $r_tt['cat_main'] . ' li_input_main_' . $r_tt['main_main'] . '" id="input_' . $r_tt['cat_id'] . '"><input type="checkbox" name="category[]" value="' . $r_tt['cat_id'] . '"> ' . $r_tt['cat_tieude'] . '</div>';
			}
		}
		$list_id = substr($list_id, 0, -1);
		return json_encode(array('list' => $list, 'list_id' => $list_id, 'total' => $total));
	}
	//////////////////////////////////////////////////////////////////
	function list_div_color_sanpham($conn, $color) {
		$tach_color = explode(',', $color);
		$thongtin = mysqli_query($conn, "SELECT * FROM mau_sanpham ORDER BY thu_tu ASC");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			if (in_array($r_tt['id'], $tach_color) == true) {
				$list .= '<div class="li_input" id="input_' . $r_tt['id'] . '"><input type="checkbox" name="color[]" value="' . $r_tt['id'] . '" checked> ' . $r_tt['tieu_de'] . '</div>';
			} else {
				$list .= '<div class="li_input" id="input_' . $r_tt['id'] . '"><input type="checkbox" name="color[]" value="' . $r_tt['id'] . '"> ' . $r_tt['tieu_de'] . '</div>';
			}
		}
		return $list;
	}
	//////////////////////////////////////////////////////////////////
	function list_div_size_sanpham($conn, $shop, $size) {
		$tach_size = explode(',', $size);
		$thongtin = mysqli_query($conn, "SELECT * FROM kich_co WHERE shop='$shop' ORDER BY thu_tu ASC");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			if (in_array($r_tt['id'], $tach_size) == true) {
				$list .= '<div class="li_input" id="input_' . $r_tt['id'] . '" style="text-transform: uppercase;"><input type="checkbox" name="size[]" value="' . $r_tt['id'] . '" checked> ' . $r_tt['tieu_de'] . '</div>';
			} else {
				$list .= '<div class="li_input" id="input_' . $r_tt['id'] . '" style="text-transform: uppercase;"><input type="checkbox" name="size[]" value="' . $r_tt['id'] . '"> ' . $r_tt['tieu_de'] . '</div>';
			}
		}
		return $list;
	}
	///////////////////
	function list_option_main_menu($conn, $shop, $id) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$thongtin = mysqli_query($conn, "SELECT * FROM menu_shop WHERE menu_main='0' AND menu_vitri='top' AND shop='$shop' ORDER BY menu_thutu ASC");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$thongtin_sub = mysqli_query($conn, "SELECT * FROM menu_shop WHERE menu_main='{$r_tt['menu_id']}' AND shop='$shop' ORDER BY menu_thutu ASC");
			$total_sub = mysqli_num_rows($thongtin_sub);
			if ($total_sub == 0) {
				$list_sub = '';
			} else {
				while ($r_s = mysqli_fetch_assoc($thongtin_sub)) {
					if ($r_s['menu_id'] == $id) {
						$list_sub .= '<option value="' . $r_s['menu_id'] . '" disabled selected>-- ' . $r_s['menu_tieude'] . '</option>';
					} else {
						$list_sub .= '<option value="' . $r_s['menu_id'] . '" disabled>-- ' . $r_s['menu_tieude'] . '</option>';
					}
				}
			}
			$i++;
			if ($r_tt['menu_id'] == $id) {
				$list .= '<option value="' . $r_tt['menu_id'] . '" selected>' . $r_tt['menu_tieude'] . '</option>' . $list_sub;
			} else {
				$list .= '<option value="' . $r_tt['menu_id'] . '">' . $r_tt['menu_tieude'] . '</option>' . $list_sub;
			}
			unset($list_sub);
		}
		return $list;
	}
	///////////////////
	function list_option_sanpham($conn, $shop, $id) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$thongtin = mysqli_query($conn, "SELECT * FROM category_sanpham_shop WHERE cat_main='0' AND shop='$shop' ORDER BY cat_thutu ASC");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$thongtin_sub = mysqli_query($conn, "SELECT * FROM category_sanpham_shop WHERE cat_main='{$r_tt['cat_id']}' AND shop='$shop' ORDER BY cat_thutu ASC");
			$total_sub = mysqli_num_rows($thongtin_sub);
			if ($total_sub == 0) {
				$list_sub = '';
			} else {
				while ($r_s = mysqli_fetch_assoc($thongtin_sub)) {
					$thongtin_sub_sub = mysqli_query($conn, "SELECT * FROM category_sanpham_shop WHERE cat_main='{$r_s['cat_id']}' AND shop='$shop' ORDER BY cat_thutu ASC");
					$total_sub_sub = mysqli_num_rows($thongtin_sub_sub);
					if ($total_sub_sub == 0) {
						$list_sub_sub = '';
					} else {
						while ($r_ss = mysqli_fetch_assoc($thongtin_sub_sub)) {
							if ($r_ss['cat_id'] == $id) {
								$list_sub_sub .= '<option value="' . $r_ss['cat_id'] . '" selected>---- ' . $r_ss['cat_tieude'] . '</option>';
							} else {
								$list_sub_sub .= '<option value="' . $r_ss['cat_id'] . '">---- ' . $r_ss['cat_tieude'] . '</option>';
							}
						}
					}
					if ($r_s['cat_id'] == $id) {
						$list_sub .= '<option value="' . $r_s['cat_id'] . '" selected>-- ' . $r_s['cat_tieude'] . '</option>' . $list_sub_sub;
					} else {
						$list_sub .= '<option value="' . $r_s['cat_id'] . '">-- ' . $r_s['cat_tieude'] . '</option>' . $list_sub_sub;
					}
					unset($list_sub_sub);
				}
			}
			$i++;
			if ($r_tt['cat_id'] == $id) {
				$list .= '<option value="' . $r_tt['cat_id'] . '" selected>' . $r_tt['cat_tieude'] . '</option>' . $list_sub;
			} else {
				$list .= '<option value="' . $r_tt['cat_id'] . '">' . $r_tt['cat_tieude'] . '</option>' . $list_sub;
			}
			unset($list_sub);
		}
		return $list;
	}
	///////////////////
	function list_option_main($conn, $shop, $id) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$thongtin = mysqli_query($conn, "SELECT * FROM category_sanpham_shop WHERE cat_main='0' AND shop='$shop' ORDER BY cat_thutu ASC");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$thongtin_sub = mysqli_query($conn, "SELECT * FROM category_sanpham_shop WHERE cat_main='{$r_tt['cat_id']}' AND shop='$shop' ORDER BY cat_thutu ASC");
			$total_sub = mysqli_num_rows($thongtin_sub);
			if ($total_sub == 0) {
				$list_sub = '';
			} else {
				while ($r_s = mysqli_fetch_assoc($thongtin_sub)) {
					if ($r_s['cat_id'] == $id) {
						$list_sub .= '<option value="' . $r_s['cat_id'] . '" selected disabled>-- ' . $r_s['cat_tieude'] . '</option>';
					} else {
						$list_sub .= '<option value="' . $r_s['cat_id'] . '" disabled>-- ' . $r_s['cat_tieude'] . '</option>';
					}
				}
			}
			$i++;
			if ($r_tt['cat_id'] == $id) {
				$list .= '<option value="' . $r_tt['cat_id'] . '" selected>' . $r_tt['cat_tieude'] . '</option>' . $list_sub;
			} else {
				$list .= '<option value="' . $r_tt['cat_id'] . '">' . $r_tt['cat_tieude'] . '</option>' . $list_sub;
			}
			unset($list_sub);
		}
		return $list;
	}
	///////////////////
	function list_option_main_auto($conn, $shop, $id) {
		$tach_id = explode(',', $id);
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$thongtin = mysqli_query($conn, "SELECT * FROM category_sanpham_shop WHERE cat_main='0' AND shop='$shop' ORDER BY cat_thutu ASC");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$thongtin_sub = mysqli_query($conn, "SELECT * FROM category_sanpham_shop WHERE cat_main='{$r_tt['cat_id']}' AND shop='$shop' ORDER BY cat_thutu ASC");
			$total_sub = mysqli_num_rows($thongtin_sub);
			if ($total_sub == 0) {
				$list_sub = '';
				if ($r_tt['cat_id'] == $id) {
					$list .= '<option value="' . $r_tt['cat_id'] . '" selected>' . $r_tt['cat_tieude'] . '</option>' . $list_sub;
				} else {
					$list .= '<option value="' . $r_tt['cat_id'] . '">' . $r_tt['cat_tieude'] . '</option>' . $list_sub;
				}
			} else {
				while ($r_s = mysqli_fetch_assoc($thongtin_sub)) {
					$thongtin_sub_sub = mysqli_query($conn, "SELECT * FROM category_sanpham_shop WHERE cat_main='{$r_s['cat_id']}' AND shop='$shop' ORDER BY cat_thutu ASC");
					$total_sub_sub = mysqli_num_rows($thongtin_sub_sub);
					if ($total_sub_sub == 0) {
						$list_sub_sub = '';
						if ($r_s['cat_id'] == $tach_id[0]) {
							$list_sub .= '<option value="' . $r_s['cat_id'] . '" selected>-- ' . $r_s['cat_tieude'] . '</option>' . $list_sub_sub;
						} else {
							$list_sub .= '<option value="' . $r_s['cat_id'] . '">-- ' . $r_s['cat_tieude'] . '</option>' . $list_sub_sub;
						}
					} else {
						while ($r_ss = mysqli_fetch_assoc($thongtin_sub_sub)) {
							if ($r_ss['cat_id'] == $tach_id[0]) {
								$list_sub_sub .= '<option value="' . $r_ss['cat_id'] . '" selected>---- ' . $r_ss['cat_tieude'] . '</option>';
							} else {
								$list_sub_sub .= '<option value="' . $r_ss['cat_id'] . '">---- ' . $r_ss['cat_tieude'] . '</option>';
							}
						}
						if ($r_s['cat_id'] == $tach_id[0]) {
							$list_sub .= '<option value="' . $r_s['cat_id'] . '" selected>-- ' . $r_s['cat_tieude'] . '</option>' . $list_sub_sub;
						} else {
							$list_sub .= '<option value="' . $r_s['cat_id'] . '">-- ' . $r_s['cat_tieude'] . '</option>' . $list_sub_sub;
						}
					}
					unset($list_sub_sub);
				}
				if ($r_tt['cat_id'] == $tach_id[0]) {
					$list .= '<option value="' . $r_tt['cat_id'] . '" selected>' . $r_tt['cat_tieude'] . '</option>' . $list_sub;
				} else {
					$list .= '<option value="' . $r_tt['cat_id'] . '">' . $r_tt['cat_tieude'] . '</option>' . $list_sub;
				}
			}
			unset($list_sub);
		}
		return $list;
	}
	///////////////////
	function list_option_post($conn, $shop, $link) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$thongtin = mysqli_query($conn, "SELECT * FROM post_shop WHERE shop='$shop' ORDER BY id DESC");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			if ($r_tt['link'] == $link) {
				$list .= '<option value="' . $r_tt['link'] . '" selected>' . $r_tt['tieu_de'] . '</option>';
			} else {
				$list .= '<option value="' . $r_tt['link'] . '">' . $r_tt['tieu_de'] . '</option>';
			}
		}
		return $list;
	}
	////////////////////
	function list_brand($conn, $shop, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $start;
		$thongtin = mysqli_query($conn, "SELECT * FROM thuong_hieu WHERE shop='$shop' ORDER BY thu_tu ASC LIMIT $start,$limit");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$list .= $skin->skin_replace('skin_dropship/box_action/tr_brand', $r_tt);
		}
		return $list;
	}
	////////////////////
	function list_size($conn, $shop, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $start;
		$thongtin = mysqli_query($conn, "SELECT * FROM kich_co WHERE shop='$shop' ORDER BY thu_tu ASC LIMIT $start,$limit");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$list .= $skin->skin_replace('skin_dropship/box_action/tr_size', $r_tt);
		}
		return $list;
	}
	/////////////////
	function list_baiviet($conn, $shop, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$thongtin = mysqli_query($conn, "SELECT * FROM post_shop WHERE shop='$shop' ORDER BY id DESC LIMIT $start,$limit");
		$i = $start;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$list .= $skin->skin_replace('skin_dropship/box_action/tr_baiviet', $r_tt);
		}
		return $list;
	}
	///////////////////
	function list_thongbao($conn, $user_id,$created, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$thongtin = mysqli_query($conn, "SELECT * FROM thongbao WHERE (noi_dang LIKE '%all%' OR noi_dang LIKE '%drop%') AND date_post>='$created' ORDER BY id DESC LIMIT $start,$limit");
		$i = $start;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$tach_doc = explode(',', $r_tt['doc']);
			if (in_array($user_id, $tach_doc) == true) {
				$r_tt['status'] = 'Đã đọc';
			} else {
				$r_tt['status'] = 'Chưa đọc';
			}
			$r_tt['date_post'] = date('d/m/Y', $r_tt['date_post']);
			$list .= $skin->skin_replace('skin_dropship/box_action/tr_thongbao', $r_tt);
		}
		return $list;
	}
	///////////////////
	function list_remarketing($conn, $user_id, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$thongtin = mysqli_query($conn, "SELECT * FROM thongbao_shop WHERE shop='$user_id' ORDER BY id DESC LIMIT $start,$limit");
		$i = $start;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$tach_doc = explode(',', $r_tt['doc']);
			if (in_array($user_id, $tach_doc) == true) {
				$r_tt['status'] = 'Đã đọc';
			} else {
				$r_tt['status'] = 'Chưa đọc';
			}
			$r_tt['date_post'] = date('d/m/Y', $r_tt['date_post']);
			$list .= $skin->skin_replace('skin_dropship/box_action/tr_remarketing', $r_tt);
		}
		return $list;
	}
	///////////////////
	function list_thongbao_right($conn, $id, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$thongtin = mysqli_query($conn, "SELECT * FROM thongbao WHERE id!='$id' ORDER BY id DESC LIMIT $limit");
		$i = $start;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$tach_doc = explode(',', $r_tt['doc']);
			if (in_array($user_id, $tach_doc) == true) {
				$r_tt['status'] = 'Đã đọc';
			} else {
				$r_tt['status'] = 'Chưa đọc';
			}
			$r_tt['date_post'] = date('d/m/Y', $r_tt['date_post']);
			$list .= $skin->skin_replace('skin_dropship/box_action/tr_thongbao_right', $r_tt);
		}
		return $list;
	}
	///////////////////
	function list_lienhe($conn, $shop, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$thongtin = mysqli_query($conn, "SELECT * FROM contact_shop WHERE shop='$shop' ORDER BY id DESC LIMIT $start,$limit");
		$i = $start;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			if ($r_tt['status'] == 1) {
				$r_tt['status'] = 'Đã đọc';
			} else {
				$r_tt['status'] = 'Chưa đọc';
			}
			$r_tt['date_post'] = date('d/m/Y', $r_tt['date_post']);
			$list .= $skin->skin_replace('skin_dropship/box_action/tr_lienhe', $r_tt);
		}
		return $list;
	}
	///////////////////
	function list_nhantin($conn, $shop, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$thongtin = mysqli_query($conn, "SELECT * FROM dangky_nhantin WHERE shop='$shop' ORDER BY id DESC LIMIT $start,$limit");
		$i = $start;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$r_tt['date_post'] = date('d/m/Y', $r_tt['date_post']);
			$list .= $skin->skin_replace('skin_dropship/box_action/tr_nhantin', $r_tt);
		}
		return $list;
	}
	///////////////////
	function list_tichdiem($conn, $shop, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$thongtin = mysqli_query($conn, "SELECT * FROM tich_diem_shop LEFT JOIN user_info ON user_info.user_id=tich_diem_shop.user_id WHERE tich_diem_shop.shop='$shop' ORDER BY tich_diem_shop.id DESC LIMIT $start,$limit");
		$i = $start;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$r_tt['date_post'] = date('d/m/Y', $r_tt['date_post']);
			$list .= $skin->skin_replace('skin_dropship/box_action/tr_tichdiem', $r_tt);
		}
		return $list;
	}
	///////////////////
	function list_thanhvien($conn, $shop, $active, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		if ($active == 'all') {
			$thongtin = mysqli_query($conn, "SELECT * FROM user_info WHERE shop='$shop' ORDER BY user_id DESC LIMIT $start,$limit");
		} else {
			$thongtin = mysqli_query($conn, "SELECT * FROM user_info WHERE shop='$shop' AND active='$active' ORDER BY user_id DESC LIMIT $start,$limit");
		}
		$i = $start;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$r_tt['user_money'] = number_format($r_tt['user_money']);
			$r_tt['user_donate'] = number_format($r_tt['user_donate']);
			$r_tt['created'] = date('d/m/Y', $r_tt['created']);
			if ($r_tt['active'] == 2) {
				$r_tt['tinh_trang'] = 'Tạm khóa';
			} else if ($r_tt['active'] == 3) {
				$r_tt['tinh_trang'] = '<span class="color_red bold">Khóa vĩnh viễn</span>';
			} else {
				$r_tt['tinh_trang'] = 'Bình thường';
			}
			if ($r_tt['loai'] == 1) {
				$r_tt['loai'] = '<span class="color_red bold">Nhóm dịch</span>';
			} else {
				$r_tt['loai'] = 'Thành viên';
			}
			if ($active == 2) {
				$list .= $skin->skin_replace('skin_dropship/box_action/tr_thanhvien_khoa', $r_tt);
			} else if ($active == 3) {
				$list .= $skin->skin_replace('skin_dropship/box_action/tr_thanhvien_khoa_vinhvien', $r_tt);
			} else {
				$list .= $skin->skin_replace('skin_dropship/box_action/tr_thanhvien', $r_tt);
			}
		}
		return $list;
	}
	///////////////////
	function list_sanpham_drop($conn,$user_id,$list_follow,$leader,$gia_leader,$kieu,$kho, $brand,$cat,$key,$sort, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$tach_follow=explode(',', $list_follow);
		if($brand==''){
			$where_brand='';
		}else{
			$where_brand=" AND thuong_hieu='$brand'";
		}
		if($cat==''){
			$where_cat='';
		}else{
			$where_cat=" AND FIND_IN_SET($cat,cat)>0";
		}
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
		if($sort=='time-asc'){
			$thongtin = mysqli_query($conn, "SELECT * FROM sanpham WHERE (noi_ban LIKE '%drop%' OR noi_ban LIKE '%all%') AND kho>'0' AND cat_ma='0' ".$where_brand." ".$where_cat."".$where_key." ORDER BY id ASC LIMIT $start,$limit");
		}else if($sort=='time-desc'){
			$thongtin = mysqli_query($conn, "SELECT * FROM sanpham WHERE (noi_ban LIKE '%drop%' OR noi_ban LIKE '%all%') AND kho>'0' AND cat_ma='0' ".$where_brand." ".$where_cat."".$where_key." ORDER BY id DESC LIMIT $start,$limit");
		}else if($sort=='price-asc'){
			$thongtin = mysqli_query($conn, "SELECT * FROM sanpham WHERE (noi_ban LIKE '%drop%' OR noi_ban LIKE '%all%') AND kho>'0' AND cat_ma='0' ".$where_brand." ".$where_cat."".$where_key." ORDER BY gia_moi ASC LIMIT $start,$limit");
		}else if($sort=='price-desc'){
			$thongtin = mysqli_query($conn, "SELECT * FROM sanpham WHERE (noi_ban LIKE '%drop%' OR noi_ban LIKE '%all%') AND kho>'0' AND cat_ma='0' ".$where_brand." ".$where_cat."".$where_key." ORDER BY gia_moi DESC LIMIT $start,$limit");			
		}else if($sort=='drop-asc'){
			$thongtin = mysqli_query($conn, "SELECT * FROM sanpham WHERE (noi_ban LIKE '%drop%' OR noi_ban LIKE '%all%') AND kho>'0' AND cat_ma='0' ".$where_brand." ".$where_cat."".$where_key." ORDER BY gia_drop ASC LIMIT $start,$limit");			
		}else if($sort=='drop-desc'){
			$thongtin = mysqli_query($conn, "SELECT * FROM sanpham WHERE (noi_ban LIKE '%drop%' OR noi_ban LIKE '%all%') AND kho>'0' AND cat_ma='0' ".$where_brand." ".$where_cat."".$where_key." ORDER BY gia_drop DESC LIMIT $start,$limit");			
		}else if($sort=='name-asc'){
			$thongtin = mysqli_query($conn, "SELECT * FROM sanpham WHERE (noi_ban LIKE '%drop%' OR noi_ban LIKE '%all%') AND kho>'0' AND cat_ma='0' ".$where_brand." ".$where_cat."".$where_key." ORDER BY tieu_de ASC LIMIT $start,$limit");			
		}else if($sort=='name-desc'){
			$thongtin = mysqli_query($conn, "SELECT * FROM sanpham WHERE (noi_ban LIKE '%drop%' OR noi_ban LIKE '%all%') AND kho>'0' AND cat_ma='0' ".$where_brand." ".$where_cat."".$where_key." ORDER BY tieu_de DESC LIMIT $start,$limit");
		}else if($sort=='kho-asc'){
			$thongtin = mysqli_query($conn, "SELECT * FROM sanpham WHERE (noi_ban LIKE '%drop%' OR noi_ban LIKE '%all%') AND kho>'0' AND cat_ma='0' ".$where_brand." ".$where_cat."".$where_key." ORDER BY kho ASC LIMIT $start,$limit");			
		}else if($sort=='kho-desc'){
			$thongtin = mysqli_query($conn, "SELECT * FROM sanpham WHERE (noi_ban LIKE '%drop%' OR noi_ban LIKE '%all%') AND kho>'0' AND cat_ma='0' ".$where_brand." ".$where_cat."".$where_key." ORDER BY kho DESC LIMIT $start,$limit");
		}else{
			$thongtin = mysqli_query($conn, "SELECT * FROM sanpham WHERE (noi_ban LIKE '%drop%' OR noi_ban LIKE '%all%') AND kho>'0' AND cat_ma='0' ".$where_brand." ".$where_cat."".$where_key." ORDER BY id DESC LIMIT $start,$limit");
		}
		$i = $start;
		$k=0;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$thongtin_rutgon=mysqli_query($conn,"SELECT * FROM rut_gon WHERE sp_id='{$r_tt['id']}' AND user_id='$user_id'");
			$total_rutgon=mysqli_num_rows($thongtin_rutgon);
			if($total_rutgon==0){
				$r_tt['rut_gon']='';
			}else{
				$r_rg=mysqli_fetch_assoc($thongtin_rutgon);
				$r_tt['rut_gon']='<input type="text" id="link_rutgon_aff_'.$r_tt['id'].'" name="link_rutgon_aff" value="https://socdo.xyz/v/'.$r_rg['rut_gon'].'">
			<button class="copy_rutgon_aff"><i class="icofont-ui-copy"></i> copy</button>';
			}
			$k++;
			$i++;
			$r_tt['i'] = $i;
			$r_tt['date_post'] = date('d/m/Y', $r_tt['date_post']);
			if($r_tt['drop_min']==0){
				if($leader==1 OR $gia_leader==1){
					$loi_nhuan = $r_tt['gia_moi'] - $r_tt['gia_drop'];
				}else{
					$loi_nhuan = $r_tt['gia_moi'] - $r_tt['gia_ctv'];
				}
			}else{
				if($leader==1 OR $gia_leader==1){
					$loi_nhuan = $r_tt['drop_min'] - $r_tt['gia_drop'];
				}else{
					$loi_nhuan = $r_tt['drop_min'] - $r_tt['gia_ctv'];
				}
			}
			$r_tt['loi_nhuan']=number_format($loi_nhuan);
			if($r_tt['kho']>0){
				$r_tt['display_loinhuan']='';
			}else{
				$r_tt['display_loinhuan']='display:none';
			}
			$r_tt['gia_cu'] = number_format($r_tt['gia_cu']);
			$r_tt['gia_moi'] = number_format($r_tt['gia_moi']);
			if($leader==1 OR $gia_leader==1){
				$r_tt['gia_nhap'] = number_format($r_tt['gia_drop']);
			}else{
				$r_tt['gia_nhap'] = number_format($r_tt['gia_ctv']);

			}
			if ($r_tt['drop_min'] == 0) {
				$r_tt['drop_min'] = 'Không quy định';
			} else {
				$r_tt['drop_min'] = number_format($r_tt['drop_min']);
			}
			if ($kho == 'kho_hcm') {
				$r_tt['kho'] = $r_tt['kho_hcm'];
			} else {
			}
			$thongtin_phanloai=mysqli_query($conn,"SELECT * FROM phanloai_sanpham WHERE sp_id='{$r_tt['id']}'");
			$total_phanloai=mysqli_num_rows($thongtin_phanloai);
			if($total_phanloai==0){
				$list_ma='';
				$r_tt['ten_size']=$r_pl['ten_size'];
				$r_tt['size_active']=$r_pl['size'];
				$r_tt['color_active']=$r_pl['color'];
				$r_tt['pl']=$r_pl['id'];
				$r_tt['size']='';
			}else{
				$u=0;
				while($r_pl=mysqli_fetch_assoc($thongtin_phanloai)){
					$u++;
					$list_ma .= $r_pl['ma_sp'] . ': ' . $r_pl['ten_color'] . '<br>';
					if($u==1){
						$r_tt['ten_size']=$r_pl['ten_size'];
						$r_tt['size_active']=$r_pl['size'];
						$r_tt['color_active']=$r_pl['color'];
						$r_tt['pl']=$r_pl['id'];
						$r_tt['size']=$r_pl['ten_size'];
					}
				}
			}
			$r_tt['list_ma'] = $list_ma;
			unset($list_ma);
			if(in_array($r_tt['id'], $tach_follow)==true){
				$r_tt['class_follow']='fa-check-square';
			}else{
				$r_tt['class_follow']='fa-square-o';
			}
			$r_tt['user_id']=$user_id;
			if($kieu=='mobile'){
				$list .= $skin->skin_replace('skin_dropship/box_action/tr_sanpham_drop_mobile', $r_tt);
			}else{
				$list .= $skin->skin_replace('skin_dropship/box_action/tr_sanpham_drop', $r_tt);
			}
		}
		return $list;
	}
	///////////////////
	function list_sanpham_follow($conn,$list_follow,$leader,$gia_leader,$kieu, $kho,$sort, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$tach_follow=explode(',', $list_follow);
		if($sort=='time-asc'){
			$thongtin = mysqli_query($conn, "SELECT * FROM sanpham WHERE id IN ($list_follow) ORDER BY id ASC LIMIT $start,$limit");
		}else if($sort=='time-desc'){
			$thongtin = mysqli_query($conn, "SELECT * FROM sanpham WHERE id IN ($list_follow) ORDER BY id DESC LIMIT $start,$limit");
		}else if($sort=='price-asc'){
			$thongtin = mysqli_query($conn, "SELECT * FROM sanpham WHERE id IN ($list_follow) ORDER BY gia_moi ASC LIMIT $start,$limit");
		}else if($sort=='price-desc'){
			$thongtin = mysqli_query($conn, "SELECT * FROM sanpham WHERE id IN ($list_follow) ORDER BY gia_moi DESC LIMIT $start,$limit");			
		}else if($sort=='drop-asc'){
			$thongtin = mysqli_query($conn, "SELECT * FROM sanpham WHERE id IN ($list_follow) ORDER BY gia_drop ASC LIMIT $start,$limit");			
		}else if($sort=='drop-desc'){
			$thongtin = mysqli_query($conn, "SELECT * FROM sanpham WHERE id IN ($list_follow) ORDER BY gia_drop DESC LIMIT $start,$limit");			
		}else if($sort=='name-asc'){
			$thongtin = mysqli_query($conn, "SELECT * FROM sanpham WHERE id IN ($list_follow) ORDER BY tieu_de ASC LIMIT $start,$limit");			
		}else if($sort=='name-desc'){
			$thongtin = mysqli_query($conn, "SELECT * FROM sanpham WHERE id IN ($list_follow) ORDER BY tieu_de DESC LIMIT $start,$limit");
		}else if($sort=='kho-asc'){
			$thongtin = mysqli_query($conn, "SELECT * FROM sanpham WHERE id IN ($list_follow) ORDER BY kho ASC LIMIT $start,$limit");			
		}else if($sort=='kho-desc'){
			$thongtin = mysqli_query($conn, "SELECT * FROM sanpham WHERE id IN ($list_follow) ORDER BY kho DESC LIMIT $start,$limit");
		}else{
			$thongtin = mysqli_query($conn, "SELECT * FROM sanpham WHERE id IN ($list_follow) ORDER BY id DESC LIMIT $start,$limit");
		}
		$i = $start;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$r_tt['date_post'] = date('d/m/Y', $r_tt['date_post']);
			if($r_tt['drop_min']==0){
				if($leader==1 OR $gia_leader==1){
					$loi_nhuan = $r_tt['gia_moi'] - $r_tt['gia_drop'];
				}else{
					$loi_nhuan = $r_tt['gia_moi'] - $r_tt['gia_ctv'];
				}
			}else{
				if($leader==1 OR $gia_leader==1){
					$loi_nhuan = $r_tt['drop_min'] - $r_tt['gia_drop'];
				}else{
					$loi_nhuan = $r_tt['drop_min'] - $r_tt['gia_ctv'];
				}
			}
			$r_tt['loi_nhuan']=number_format($loi_nhuan);
			if($r_tt['kho']>0){
				$r_tt['display_loinhuan']='';
			}else{
				$r_tt['display_loinhuan']='display:none';
			}
			$r_tt['gia_cu'] = number_format($r_tt['gia_cu']);
			$r_tt['gia_moi'] = number_format($r_tt['gia_moi']);
			if($leader==1 OR $gia_leader==1){
				$r_tt['gia_nhap'] = number_format($r_tt['gia_drop']);
			}else{
				$r_tt['gia_nhap'] = number_format($r_tt['gia_ctv']);

			}
			if ($r_tt['drop_min'] == 0) {
				$r_tt['drop_min'] = 'Không quy định';
			} else {
				$r_tt['drop_min'] = number_format($r_tt['drop_min']);
			}
			if ($kho == 'kho_hcm') {
				$r_tt['kho'] = $r_tt['kho_hcm'];
			} else {
			}
			$thongtin_phanloai=mysqli_query($conn,"SELECT * FROM phanloai_sanpham WHERE sp_id='{$r_tt['id']}'");
			$total_phanloai=mysqli_num_rows($thongtin_phanloai);
			if($total_phanloai==0){
				$list_ma='';
			}else{
				while($r_pl=mysqli_fetch_assoc($thongtin_phanloai)){
					$list_ma .= $r_pl['ma_sp'] . ': ' . $r_pl['ten_color'] . '<br>';
				}
			}
			$r_tt['list_ma'] = $list_ma;
			unset($list_ma);
			unset($list_ma);
			if(in_array($r_tt['id'], $tach_follow)==true){
				$r_tt['class_follow']='fa-check-square';
			}else{
				$r_tt['class_follow']='fa-square-o';
			}
			if($kieu=='mobile'){
				$list .= $skin->skin_replace('skin_dropship/box_action/tr_sanpham_drop_mobile', $r_tt);
			}else{
				$list .= $skin->skin_replace('skin_dropship/box_action/tr_sanpham_drop', $r_tt);
			}
		}
		return $list;
	}
	///////////////////
	function list_timkiem_sanpham_follow($conn,$list_follow,$leader,$gia_leader,$kieu, $kho,$key,$sort) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$tach_follow=explode(',', $list_follow);
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
		if($sort=='time-asc'){
			$thongtin = mysqli_query($conn, "SELECT * FROM sanpham WHERE id IN ($list_follow) $where_key ORDER BY id ASC");
		}else if($sort=='time-desc'){
			$thongtin = mysqli_query($conn, "SELECT * FROM sanpham WHERE id IN ($list_follow) $where_key ORDER BY id DESC");
		}else if($sort=='price-asc'){
			$thongtin = mysqli_query($conn, "SELECT * FROM sanpham WHERE id IN ($list_follow) $where_key ORDER BY gia_moi ASC");
		}else if($sort=='price-desc'){
			$thongtin = mysqli_query($conn, "SELECT * FROM sanpham WHERE id IN ($list_follow) $where_key ORDER BY gia_moi DESC");			
		}else if($sort=='drop-asc'){
			$thongtin = mysqli_query($conn, "SELECT * FROM sanpham WHERE id IN ($list_follow) $where_key ORDER BY gia_drop ASC");			
		}else if($sort=='drop-desc'){
			$thongtin = mysqli_query($conn, "SELECT * FROM sanpham WHERE id IN ($list_follow) $where_key ORDER BY gia_drop DESC");			
		}else if($sort=='name-asc'){
			$thongtin = mysqli_query($conn, "SELECT * FROM sanpham WHERE id IN ($list_follow) $where_key ORDER BY tieu_de ASC");			
		}else if($sort=='name-desc'){
			$thongtin = mysqli_query($conn, "SELECT * FROM sanpham WHERE id IN ($list_follow) $where_key ORDER BY tieu_de DESC");
		}else if($sort=='kho-asc'){
			$thongtin = mysqli_query($conn, "SELECT * FROM sanpham WHERE id IN ($list_follow) $where_key ORDER BY kho ASC");			
		}else if($sort=='kho-desc'){
			$thongtin = mysqli_query($conn, "SELECT * FROM sanpham WHERE id IN ($list_follow) $where_key ORDER BY kho DESC");
		}else{
			$thongtin = mysqli_query($conn, "SELECT * FROM sanpham WHERE id IN ($list_follow) $where_key ORDER BY id DESC");
		}
		$i = $start;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$r_tt['date_post'] = date('d/m/Y', $r_tt['date_post']);
			$r_tt['gia_cu'] = number_format($r_tt['gia_cu']);
			$r_tt['gia_moi'] = number_format($r_tt['gia_moi']);
			if($leader==1 OR $gia_leader==1){
				$r_tt['gia_nhap'] = number_format($r_tt['gia_drop']);
			}else{
				$r_tt['gia_nhap'] = number_format($r_tt['gia_ctv']);

			}
			if ($r_tt['drop_min'] == 0) {
				$r_tt['drop_min'] = 'Không quy định';
			} else {
				$r_tt['drop_min'] = number_format($r_tt['drop_min']);
			}
			if ($kho == 'kho_hcm') {
				$r_tt['kho'] = $r_tt['kho_hcm'];
			} else {
			}
			$thongtin_phanloai=mysqli_query($conn,"SELECT * FROM phanloai_sanpham WHERE sp_id='{$r_tt['id']}'");
			$total_phanloai=mysqli_num_rows($thongtin_phanloai);
			if($total_phanloai==0){
				$list_ma='';
			}else{
				while($r_pl=mysqli_fetch_assoc($thongtin_phanloai)){
					$list_ma .= $r_pl['ma_sp'] . ': ' . $r_pl['ten_color'] . '<br>';
				}
			}
			$r_tt['list_ma'] = $list_ma;
			unset($list_ma);
			if(in_array($r_tt['id'], $tach_follow)==true){
				$r_tt['class_follow']='fa-check-square';
			}else{
				$r_tt['class_follow']='fa-square-o';
			}
			if($kieu=='mobile'){
				$list .= $skin->skin_replace('skin_dropship/box_action/tr_sanpham_drop_mobile', $r_tt);
			}else{
				$list .= $skin->skin_replace('skin_dropship/box_action/tr_sanpham_drop', $r_tt);
			}
		}
		return $list;
	}
	///////////////////
	function list_link_affiliate($conn,$user_id,$kieu, $brand,$cat,$key,$sort, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		if($brand==''){
			$where_brand='';
		}else{
			$where_brand="sanpham.thuong_hieu='$brand'";
		}
		if($cat==''){
			$where_cat='';
		}else{
			if($where_brand==''){
				$where_cat=" FIND_IN_SET($cat,sanpham.cat)>0";
			}else{
				$where_cat=" AND FIND_IN_SET($cat,sanpham.cat)>0";
			}
		}
		if($key==''){
			$where_key='';
		}else{
			if($where_brand!='' OR $where_cat!=''){
				if(strpos($key, ' ')==false){
					$where_key=" AND sanpham.tieu_de LIKE '%$key%'";
				}else{
					$tach_key=explode(' ', $key);
					foreach ($tach_key as $k => $v) {
						if($v==''){
						}else{
							$where_key.=" AND sanpham.tieu_de LIKE '%$v%'";
						}
					}
				}
			}else{
				if(strpos($key, ' ')==false){
					$where_key=" sanpham.tieu_de LIKE '%$key%'";
				}else{
					$tach_key=explode(' ', $key);
					$u=0;
					foreach ($tach_key as $k => $v) {
						if($v==''){
						}else{
							$u++;
							if($u==1){
								$where_key.=" sanpham.tieu_de LIKE '%$v%'";
							}else{
								$where_key.=" AND sanpham.tieu_de LIKE '%$v%'";
							}
						}
					}
				}

			}
		}
		if($brand!='' OR $cat!='' OR $key!=''){
			if($sort=='time-asc'){
				$thongtin = mysqli_query($conn, "SELECT sanpham.*,rut_gon.rut_gon,rut_gon.click FROM sanpham LEFT JOIN rut_gon ON rut_gon.user_id='$user_id' AND rut_gon.sp_id=sanpham.id  WHERE ".$where_brand." ".$where_cat."".$where_key." GROUP BY sanpham.id ORDER BY sanpham.id ASC LIMIT $start,$limit");
			}else if($sort=='time-desc'){
				$thongtin = mysqli_query($conn, "SELECT sanpham.*,rut_gon.rut_gon,rut_gon.click FROM sanpham LEFT JOIN rut_gon ON rut_gon.user_id='$user_id' AND rut_gon.sp_id=sanpham.id WHERE ".$where_brand." ".$where_cat."".$where_key." GROUP BY sanpham.id ORDER BY sanpham.id DESC LIMIT $start,$limit");
			}else if($sort=='price-asc'){
				$thongtin = mysqli_query($conn, "SELECT sanpham.*,rut_gon.rut_gon,rut_gon.click FROM sanpham LEFT JOIN rut_gon ON rut_gon.user_id='$user_id' AND rut_gon.sp_id=sanpham.id WHERE ".$where_brand." ".$where_cat."".$where_key." GROUP BY sanpham.id ORDER BY sanpham.gia_moi ASC LIMIT $start,$limit");
			}else if($sort=='price-desc'){
				$thongtin = mysqli_query($conn, "SELECT sanpham.*,rut_gon.rut_gon,rut_gon.click FROM sanpham LEFT JOIN rut_gon ON rut_gon.user_id='$user_id' AND rut_gon.sp_id=sanpham.id WHERE ".$where_brand." ".$where_cat."".$where_key." GROUP BY sanpham.id ORDER BY sanpham.gia_moi DESC LIMIT $start,$limit");			
			}else if($sort=='drop-asc'){
				$thongtin = mysqli_query($conn, "SELECT sanpham.*,rut_gon.rut_gon,rut_gon.click FROM sanpham LEFT JOIN rut_gon ON rut_gon.user_id='$user_id' AND rut_gon.sp_id=sanpham.id WHERE ".$where_brand." ".$where_cat."".$where_key." GROUP BY sanpham.id ORDER BY sanpham.gia_drop ASC LIMIT $start,$limit");			
			}else if($sort=='drop-desc'){
				$thongtin = mysqli_query($conn, "SELECT sanpham.*,rut_gon.rut_gon,rut_gon.click FROM sanpham LEFT JOIN rut_gon ON rut_gon.user_id='$user_id' AND rut_gon.sp_id=sanpham.id WHERE ".$where_brand." ".$where_cat."".$where_key." GROUP BY sanpham.id ORDER BY sanpham.gia_drop DESC LIMIT $start,$limit");			
			}else if($sort=='name-asc'){
				$thongtin = mysqli_query($conn, "SELECT sanpham.*,rut_gon.rut_gon,rut_gon.click FROM sanpham LEFT JOIN rut_gon ON rut_gon.user_id='$user_id' AND rut_gon.sp_id=sanpham.id WHERE ".$where_brand." ".$where_cat."".$where_key." GROUP BY sanpham.id ORDER BY sanpham.tieu_de ASC LIMIT $start,$limit");			
			}else if($sort=='name-desc'){
				$thongtin = mysqli_query($conn, "SELECT sanpham.*,rut_gon.rut_gon,rut_gon.click FROM sanpham LEFT JOIN rut_gon ON rut_gon.user_id='$user_id' AND rut_gon.sp_id=sanpham.id WHERE ".$where_brand." ".$where_cat."".$where_key." GROUP BY sanpham.id ORDER BY sanpham.tieu_de DESC LIMIT $start,$limit");
			}else if($sort=='kho-asc'){
				$thongtin = mysqli_query($conn, "SELECT sanpham.*,rut_gon.rut_gon,rut_gon.click FROM sanpham LEFT JOIN rut_gon ON rut_gon.user_id='$user_id' AND rut_gon.sp_id=sanpham.id WHERE ".$where_brand." ".$where_cat."".$where_key." GROUP BY sanpham.id ORDER BY sanpham.kho ASC LIMIT $start,$limit");			
			}else if($sort=='kho-desc'){
				$thongtin = mysqli_query($conn, "SELECT sanpham.*,rut_gon.rut_gon,rut_gon.click FROM sanpham LEFT JOIN rut_gon ON rut_gon.user_id='$user_id' AND rut_gon.sp_id=sanpham.id WHERE ".$where_brand." ".$where_cat."".$where_key." GROUP BY sanpham.id ORDER BY sanpham.kho DESC LIMIT $start,$limit");
			}else{
				$thongtin = mysqli_query($conn, "SELECT sanpham.*,rut_gon.rut_gon,rut_gon.click FROM sanpham LEFT JOIN rut_gon ON rut_gon.user_id='$user_id' AND rut_gon.sp_id=sanpham.id WHERE ".$where_brand." ".$where_cat."".$where_key." GROUP BY sanpham.id ORDER BY sanpham.id DESC LIMIT $start,$limit");
			}
		}else{
			if($sort=='time-asc'){
				$thongtin = mysqli_query($conn, "SELECT sanpham.*,rut_gon.rut_gon,rut_gon.click FROM sanpham LEFT JOIN rut_gon ON rut_gon.user_id='$user_id' AND rut_gon.sp_id=sanpham.id GROUP BY sanpham.id ORDER BY sanpham.id ASC LIMIT $start,$limit");
			}else if($sort=='time-desc'){
				$thongtin = mysqli_query($conn, "SELECT sanpham.*,rut_gon.rut_gon,rut_gon.click FROM sanpham LEFT JOIN rut_gon ON rut_gon.user_id='$user_id' AND rut_gon.sp_id=sanpham.id GROUP BY sanpham.id ORDER BY sanpham.id DESC LIMIT $start,$limit");
			}else if($sort=='price-asc'){
				$thongtin = mysqli_query($conn, "SELECT sanpham.*,rut_gon.rut_gon,rut_gon.click FROM sanpham LEFT JOIN rut_gon ON rut_gon.user_id='$user_id' AND rut_gon.sp_id=sanpham.id GROUP BY sanpham.id ORDER BY sanpham.gia_moi ASC LIMIT $start,$limit");
			}else if($sort=='price-desc'){
				$thongtin = mysqli_query($conn, "SELECT sanpham.*,rut_gon.rut_gon,rut_gon.click FROM sanpham LEFT JOIN rut_gon ON rut_gon.user_id='$user_id' AND rut_gon.sp_id=sanpham.id GROUP BY sanpham.id ORDER BY sanpham.gia_moi DESC LIMIT $start,$limit");			
			}else if($sort=='drop-asc'){
				$thongtin = mysqli_query($conn, "SELECT sanpham.*,rut_gon.rut_gon,rut_gon.click FROM sanpham LEFT JOIN rut_gon ON rut_gon.user_id='$user_id' AND rut_gon.sp_id=sanpham.id GROUP BY sanpham.id ORDER BY sanpham.gia_drop ASC LIMIT $start,$limit");			
			}else if($sort=='drop-desc'){
				$thongtin = mysqli_query($conn, "SELECT sanpham.*,rut_gon.rut_gon,rut_gon.click FROM sanpham LEFT JOIN rut_gon ON rut_gon.user_id='$user_id' AND rut_gon.sp_id=sanpham.id GROUP BY sanpham.id ORDER BY sanpham.gia_drop DESC LIMIT $start,$limit");			
			}else if($sort=='name-asc'){
				$thongtin = mysqli_query($conn, "SELECT sanpham.*,rut_gon.rut_gon,rut_gon.click FROM sanpham LEFT JOIN rut_gon ON rut_gon.user_id='$user_id' AND rut_gon.sp_id=sanpham.id GROUP BY sanpham.id ORDER BY sanpham.tieu_de ASC LIMIT $start,$limit");			
			}else if($sort=='name-desc'){
				$thongtin = mysqli_query($conn, "SELECT sanpham.*,rut_gon.rut_gon,rut_gon.click FROM sanpham LEFT JOIN rut_gon ON rut_gon.user_id='$user_id' AND rut_gon.sp_id=sanpham.id GROUP BY sanpham.id ORDER BY sanpham.tieu_de DESC LIMIT $start,$limit");
			}else if($sort=='kho-asc'){
				$thongtin = mysqli_query($conn, "SELECT sanpham.*,rut_gon.rut_gon,rut_gon.click FROM sanpham LEFT JOIN rut_gon ON rut_gon.user_id='$user_id' AND rut_gon.sp_id=sanpham.id GROUP BY sanpham.id ORDER BY sanpham.kho ASC LIMIT $start,$limit");			
			}else if($sort=='kho-desc'){
				$thongtin = mysqli_query($conn, "SELECT sanpham.*,rut_gon.rut_gon,rut_gon.click FROM sanpham LEFT JOIN rut_gon ON rut_gon.user_id='$user_id' AND rut_gon.sp_id=sanpham.id GROUP BY sanpham.id ORDER BY sanpham.kho DESC LIMIT $start,$limit");
			}else{
				$thongtin = mysqli_query($conn, "SELECT sanpham.*,rut_gon.rut_gon,rut_gon.click FROM sanpham LEFT JOIN rut_gon ON rut_gon.user_id='$user_id' AND rut_gon.sp_id=sanpham.id GROUP BY sanpham.id ORDER BY sanpham.id DESC LIMIT $start,$limit");
			}

		}
		$i = $start;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$r_tt['date_post'] = date('d/m/Y', $r_tt['date_post']);
			$cat=$r_tt['cat'];
			$ko_apdung=0;
			if($cat==''){
				$hoa_hong='0';
			}else{
				$thongtin_cat=mysqli_query($conn,"SELECT * FROM category_sanpham WHERE cat_id IN ($cat) ORDER BY cat_id ASC");
				while($r_c=mysqli_fetch_assoc($thongtin_cat)){
					if($r_c['hoa_hong']=='ko' OR $r_c['hoa_hong']=='khong'){
						$ko_apdung=1;
					}else if($r_c['cat_main']>0){
						if($r_c['hoa_hong']!=''){
							$hoa_hong=($r_tt['gia_moi']/100)*$r_c['hoa_hong'];
						}else{

						}
					}else if($r_c['cat_main']==0){
						$hoa_hong=($r_tt['gia_moi']/100)*intval($r_c['hoa_hong']);
					}
				}
			}
			if($ko_apdung==1){
				$r_tt['hoa_hong']='Không Áp dụng';
			}else{
				$r_tt['hoa_hong']=number_format($hoa_hong).' đ';
			}
			if($r_tt['rut_gon']==''){
				$r_tt['rut_gon']='';
			}else{
				$r_tt['rut_gon']='<input type="text" id="link_rutgon_aff_'.$r_tt['id'].'" name="link_rutgon_aff" value="https://socdo.xyz/v/'.$r_tt['rut_gon'].'">
			<button class="copy_rutgon_aff"><i class="icofont-ui-copy"></i> copy</button>';
			}
			$r_tt['gia_cu'] = number_format($r_tt['gia_cu']);
			$r_tt['gia_moi'] = number_format($r_tt['gia_moi']);
			$r_tt['gia_drop'] = number_format($r_tt['gia_drop']);
			if ($r_tt['drop_min'] == 0) {
				$r_tt['drop_min'] = 'Không quy định';
			} else {
				$r_tt['drop_min'] = number_format($r_tt['drop_min']);
			}
			if ($kho == 'kho_hcm') {
				$r_tt['kho'] = $r_tt['kho_hcm'];
			}
			$r_tt['drop_max'] = number_format($r_tt['drop_max']);
			$r_tt['user_id']=$user_id;
			$r_tt['click']=number_format($r_tt['click']);
			if($kieu=='mobile'){
				$list .= $skin->skin_replace('skin_dropship/box_action/tr_link_aff_mobile', $r_tt);
			}else{
				$list .= $skin->skin_replace('skin_dropship/box_action/tr_link_aff', $r_tt);
			}
		}
		return $list;
	}
	///////////////////
	function list_sanpham($conn,$leader,$gia_leader,$kieu, $kho,$list_dang, $shop, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		if($list_dang==''){
			$thongtin = mysqli_query($conn, "SELECT * FROM sanpham WHERE (noi_ban LIKE '%drop%' OR noi_ban LIKE '%all%') AND cat_ma='0' ORDER BY id DESC LIMIT $start,$limit");
		}else{
			$thongtin = mysqli_query($conn, "SELECT * FROM sanpham WHERE id NOT IN ($list_dang) AND (noi_ban LIKE '%drop%' OR noi_ban LIKE '%all%') AND cat_ma='0' ORDER BY id DESC LIMIT $start,$limit");
		}
		
		$i = $start;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$r_tt['date_post'] = date('d/m/Y', $r_tt['date_post']);
			$r_tt['gia_cu'] = number_format($r_tt['gia_cu']);
			$r_tt['gia_moi'] = number_format($r_tt['gia_moi']);
			if($leader==1 OR $gia_leader==1){
				$r_tt['gia_nhap'] = number_format($r_tt['gia_drop']);
			}else{
				$r_tt['gia_nhap'] = number_format($r_tt['gia_ctv']);
			}
			if ($r_tt['drop_min'] == 0) {
				$r_tt['drop_min'] = 'Không quy định';
			} else {
				$r_tt['drop_min'] = number_format($r_tt['drop_min']);
			}
			if ($kho == 'kho_hcm') {
				$r_tt['kho'] = $r_tt['kho_hcm'];
			}
			$r_tt['drop_max'] = number_format($r_tt['drop_max']);
			if($kieu=='mobile'){
				$list .= $skin->skin_replace('skin_dropship/box_action/tr_sanpham_mobile', $r_tt);
			}else{
				$list .= $skin->skin_replace('skin_dropship/box_action/tr_sanpham', $r_tt);
			}
		}
		return $list;
	}
	///////////////////
	function list_sanpham_trend($conn,$leader,$gia_leader,$kieu, $kho, $shop, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$thongtin = mysqli_query($conn, "SELECT * FROM sanpham_trend INNER JOIN sanpham ON sanpham_trend.sp_id=sanpham.id WHERE sanpham.noi_ban LIKE '%drop%' OR sanpham.noi_ban LIKE '%all%'  ORDER BY sanpham_trend.id DESC LIMIT $start,$limit");
		$i = $start;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$r_tt['date_post'] = date('d/m/Y', $r_tt['date_post']);
			$r_tt['gia_cu'] = number_format($r_tt['gia_cu']);
			$r_tt['gia_moi'] = number_format($r_tt['gia_moi']);
			if($leader==1 OR $gia_leader==1){
				$r_tt['gia_nhap'] = number_format($r_tt['gia_drop']);
			}else{
				$r_tt['gia_nhap'] = number_format($r_tt['gia_ctv']);
			}
			if ($r_tt['drop_min'] == 0) {
				$r_tt['drop_min'] = 'Không quy định';
			} else {
				$r_tt['drop_min'] = number_format($r_tt['drop_min']);
			}
			if ($kho == 'kho_hcm') {
				$r_tt['kho'] = $r_tt['kho_hcm'];
			}
			$r_tt['drop_max'] = number_format($r_tt['drop_max']);
			$r_tt['gia'] = number_format($r_tt['gia']);
			if($kieu=='mobile'){
				$list .= $skin->skin_replace('skin_dropship/box_action/tr_sanpham_trend_add_mobile', $r_tt);
			}else{
				$list .= $skin->skin_replace('skin_dropship/box_action/tr_sanpham_trend_add', $r_tt);
			}

		}
		return $list;
	}
	///////////////////
	function list_sanpham_tuan($conn,$leader,$gia_leader, $kho, $shop, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$hientai = time();
		$thongtin = mysqli_query($conn, "SELECT * FROM sanpham_tuan INNER JOIN sanpham ON sanpham_tuan.sp_id=sanpham.id WHERE sanpham.noi_ban LIKE '%drop%' OR sanpham.noi_ban LIKE '%all%'  ORDER BY sanpham_tuan.id DESC LIMIT $start,$limit");
		$i = $start;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$r_tt['date_post'] = date('d/m/Y', $r_tt['date_post']);
			$r_tt['gia_cu'] = number_format($r_tt['gia_cu']);
			$r_tt['gia_moi'] = number_format($r_tt['gia_moi']);
			if($leader==1 OR $gia_leader==1){
				$r_tt['gia_truoc'] = number_format($r_tt['gia_truoc']);
				$r_tt['gia_tuan'] = number_format($r_tt['gia_tuan']);
			}else{
				if($r_tt['gia_ctv_tuan']==0){
					$gia_ctv= $r_tt['gia_tuan'] + (($r_tt['drop_min'] - $r_tt['gia_tuan'])*0.3);
				}else{
					$gia_ctv= $r_tt['gia_ctv_tuan'];
				}
				if($r_tt['gia_ctv_truoc']==0){
					$gia= $r_tt['gia_truoc'] + (($r_tt['drop_min'] - $r_tt['gia_truoc'])*0.3);
				}else{
					$gia= $r_tt['gia_ctv_truoc'];
				}
				$r_tt['gia_tuan'] = number_format($gia_ctv);
				$r_tt['gia_truoc'] = number_format($gia);
			}
			if ($r_tt['drop_min'] == 0) {
				$r_tt['drop_min'] = 'Không quy định';
			} else {
				$r_tt['drop_min'] = number_format($r_tt['drop_min']);
			}
			if ($r_tt['time_start'] > time()) {
				$r_tt['text_time'] = 'Bắt đầu sau:';
				$r_tt['conlai'] = $r_tt['time_start'] - time();
				$r_tt['status'] = 0;
				$r_tt['thoigian'] = $r_tt['time_end'] - $r_tt['time_start'];
			} else {
				$r_tt['text_time'] = 'Kết thúc sau:';
				$r_tt['conlai'] = $r_tt['time_end'] - time();
				$r_tt['thoigian'] = $r_tt['time_end'] - $r_tt['time_start'];
				$r_tt['status'] = 1;
			}
			if ($kho == 'kho_hcm') {
				$r_tt['kho'] = $r_tt['kho_hcm'];
			}
			$list .= $skin->skin_replace('skin_dropship/box_action/tr_sanpham_tuan', $r_tt);

		}
		return $list;
	}
	///////////////////
	function list_sanpham_shop($conn,$leader,$gia_leader, $domain, $shop, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$thongtin = mysqli_query($conn, "SELECT sanpham_shop.*,sanpham.gia_drop,sanpham.kho FROM sanpham_shop LEFT JOIN sanpham ON sanpham_shop.sp_id=sanpham.id WHERE sanpham_shop.shop='$shop' ORDER BY sanpham_shop.id DESC LIMIT $start,$limit");
		$i = $start;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$r_tt['date_post'] = date('d/m/Y', $r_tt['date_post']);
			$r_tt['gia_cu'] = number_format($r_tt['gia_cu']);
			$r_tt['gia_moi'] = number_format($r_tt['gia_moi']);
			if($leader==1 OR $gia_leader==1){
				$r_tt['gia_nhap'] = number_format($r_tt['gia_drop']);
			}else{
				$r_tt['gia_nhap'] = number_format($r_tt['gia_ctv']);
			}
			$r_tt['domain'] = $domain;
			$list .= $skin->skin_replace('skin_dropship/box_action/tr_sanpham_shop', $r_tt);
		}
		return $list;
	}
	///////////////////
	function list_sanpham_hethang_catma($conn,$leader,$gia_leader, $kho, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$thongtin = mysqli_query($conn, "SELECT * FROM sanpham WHERE cat_ma='1' ORDER BY id DESC LIMIT $start,$limit");
		$i = $start;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$r_tt['date_post'] = date('d/m/Y', $r_tt['date_post']);
			$r_tt['gia_cu'] = number_format($r_tt['gia_cu']);
			$r_tt['gia_moi'] = number_format($r_tt['gia_moi']);
			if($leader==1 OR $gia_leader==1){
				$r_tt['gia_nhap'] = number_format($r_tt['gia_drop']);
			}else{
				$r_tt['gia_nhap'] = number_format($r_tt['gia_ctv']);
			}
			if ($kho == 'kho_hcm') {
				$r_tt['kho'] = $r_tt['kho_hcm'];
			}
			$list .= $skin->skin_replace('skin_dropship/box_action/tr_sanpham_hethang', $r_tt);
		}
		return $list;
	}
	///////////////////
	function list_sanpham_hethang($conn,$leader,$gia_leader, $kho, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		if ($kho == 'kho_hcm') {
			$thongtin = mysqli_query($conn, "SELECT * FROM sanpham WHERE kho_hcm<='10' AND (noi_ban LIKE '%drop%' OR noi_ban LIKE '%all%') ORDER BY id DESC LIMIT $start,$limit");
		} else {
			$thongtin = mysqli_query($conn, "SELECT * FROM sanpham WHERE kho<='10' AND (noi_ban LIKE '%drop%' OR noi_ban LIKE '%all%') ORDER BY id DESC LIMIT $start,$limit");
		}
		$i = $start;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$r_tt['date_post'] = date('d/m/Y', $r_tt['date_post']);
			$r_tt['gia_cu'] = number_format($r_tt['gia_cu']);
			$r_tt['gia_moi'] = number_format($r_tt['gia_moi']);
			if($leader==1 OR $gia_leader==1){
				$r_tt['gia_nhap'] = number_format($r_tt['gia_drop']);
			}else{
				$r_tt['gia_nhap'] = number_format($r_tt['gia_ctv']);
			}
			if ($kho == 'kho_hcm') {
				$r_tt['kho'] = $r_tt['kho_hcm'];
			}
			$list .= $skin->skin_replace('skin_dropship/box_action/tr_sanpham_hethang', $r_tt);
		}
		return $list;
	}
	///////////////////
	function list_kq_timkiem_sanpham_hethang($conn,$leader,$gia_leader, $kho, $key) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$tach_key = explode(' ', $key);
		$k = 0;
		$total_key=count($tach_key);
		if($total_key==1){
			$where = " AND tieu_de LIKE '%$key%'";
		}else{
			foreach ($tach_key as $key => $value) {
				if ($value != '') {
					$k++;
					if ($k == 1) {
						$where .= "AND (tieu_de LIKE '%$value%'";
					}else if($k==$total_key){
						$where .= " AND tieu_de LIKE '%$value%')";
					} else {
						$where .= " AND tieu_de LIKE '%$value%'";
					}
				}
			}
		}
		if($key==''){
			$where='';
		}
		if ($kho == 'kho_hcm') {
			$thongtin = mysqli_query($conn, "SELECT * FROM sanpham WHERE kho_hcm<='10' AND (noi_ban LIKE '%drop%' OR noi_ban LIKE '%all%') $where ORDER BY id DESC");
		} else {
			//echo "SELECT * FROM sanpham WHERE kho<='10' AND (noi_ban LIKE '%drop%' OR noi_ban LIKE '%all%') $where ORDER BY id DESC";
			$thongtin = mysqli_query($conn, "SELECT * FROM sanpham WHERE kho<='10' AND (noi_ban LIKE '%drop%' OR noi_ban LIKE '%all%') $where ORDER BY id DESC");
		}
		$i = 0;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$r_tt['date_post'] = date('d/m/Y', $r_tt['date_post']);
			$r_tt['gia_cu'] = number_format($r_tt['gia_cu']);
			$r_tt['gia_moi'] = number_format($r_tt['gia_moi']);
			if($leader==1 OR $gia_leader==1){
				$r_tt['gia_nhap'] = number_format($r_tt['gia_drop']);
			}else{
				$r_tt['gia_nhap'] = number_format($r_tt['gia_ctv']);
			}
			if ($kho == 'kho_hcm') {
				$r_tt['kho'] = $r_tt['kho_hcm'];
			}
			$list .= $skin->skin_replace('skin_dropship/box_action/tr_sanpham_hethang', $r_tt);
		}
		mysqli_free_result($thongtin);
		if ($i == 0) {
			$list = '<center>Không có kết quả</center>';
		}
		return $list;
	}
	///////////////////
	function thongke_khach_nam($conn, $shop, $dau, $cuoi) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$thongtin = mysqli_query($conn, "SELECT * FROM user_info WHERE created>='$dau' AND created<='$cuoi' AND shop='$shop'");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$month = date('m', $r_tt['created']);
			$month = intval($month);
			if ($month == 1) {
				$month_1++;
			} else if ($month == 2) {
				$month_2++;
			} else if ($month == 3) {
				$month_3++;
			} else if ($month == 4) {
				$month_4++;
			} else if ($month == 5) {
				$month_5++;
			} else if ($month == 6) {
				$month_6++;
			} else if ($month == 7) {
				$month_7++;
			} else if ($month == 8) {
				$month_8++;
			} else if ($month == 9) {
				$month_9++;
			} else if ($month == 10) {
				$month_10++;
			} else if ($month == 11) {
				$month_11++;

			} else if ($month == 12) {
				$month_12++;
			}
		}
		return intval($month_1) . ',' . intval($month_2) . ',' . intval($month_3) . ',' . intval($month_4) . ',' . intval($month_5) . ',' . intval($month_6) . ',' . intval($month_7) . ',' . intval($month_8) . ',' . intval($month_9) . ',' . intval($month_10) . ',' . intval($month_11) . ',' . intval($month_12);
	}
	///////////////////
	function thongke_khach_thang($conn, $shop, $thang, $nam, $dau, $cuoi) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$thongtin = mysqli_query($conn, "SELECT * FROM user_info WHERE created>='$dau' AND created<='$cuoi' AND shop='$shop'");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$ngay = date('d', $r_tt['created']);
			$ngay = intval($ngay);
			if ($thang == 2) {
				if (checkdate(02, 29, $nam) == true) {
					for ($i = 1; $i <= 29; $i++) {
						if ($ngay == $i) {
							$data_ngay[$i]++;
						}
					}
				} else {
					for ($i = 1; $i <= 28; $i++) {
						if ($ngay == $i) {
							$data_ngay[$i]++;
						}
					}

				}
			} else if (in_array($thang, array('1', '3', '5', '7', '8', '10', '12')) == true) {
				for ($i = 1; $i <= 31; $i++) {
					if ($ngay == $i) {
						$data_ngay[$i]++;
					}
				}
			} else {
				for ($i = 1; $i <= 30; $i++) {
					if ($ngay == $i) {
						$data_ngay[$i]++;
					}
				}

			}

		}
		if ($thang == 2) {
			if (checkdate(02, 29, $nam) == true) {
				for ($i = 1; $i <= 29; $i++) {
					$data_thang .= intval($data_ngay[$i]) . ',';
				}
			} else {
				for ($i = 1; $i <= 28; $i++) {
					$data_thang .= intval($data_ngay[$i]) . ',';
				}

			}
		} else if (in_array($thang, array('1', '3', '5', '7', '8', '10', '12')) == true) {
			for ($i = 1; $i <= 31; $i++) {
				$data_thang .= intval($data_ngay[$i]) . ',';
			}
		} else {
			for ($i = 1; $i <= 30; $i++) {
				$data_thang .= intval($data_ngay[$i]) . ',';
			}

		}
		$data_thang = substr($data_thang, 0, -1);
		return $data_thang;
	}
	///////////////////
	function thongke_khach_tuan($conn, $shop, $dau, $cuoi) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$thongtin = mysqli_query($conn, "SELECT * FROM user_info WHERE created>='$dau' AND created<='$cuoi' AND shop='$shop'");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$month = date('m', $r_tt['created']);
			$day = date('d', $r_tt['created']);
			$year = date('Y', $r_tt['created']);
			$wkday = date('l', mktime('0', '0', '0', $month, $day, $year));
			if ($wkday == 'Monday') {
				$mon++;
			} else if ($wkday == 'Tuesday') {
				$tus++;
			} else if ($wkday == 'Wednesday') {
				$web++;
			} else if ($wkday == 'Thursday') {
				$thu++;
			} else if ($wkday == 'Friday') {
				$fri++;
			} else if ($wkday == 'Saturday') {
				$sat++;
			} else if ($wkday == 'Sunday') {
				$sun++;
			}
		}
		return intval($mon) . ',' . intval($tus) . ',' . intval($web) . ',' . intval($thu) . ',' . intval($fri) . ',' . intval($sat) . ',' . intval($sun);
	}
///////////////////
	function thongke_donhang_thanhvien_nam($conn, $user_id, $dau, $cuoi) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$thongtin = mysqli_query($conn, "SELECT * FROM donhang WHERE date_post>='$dau' AND date_post<='$cuoi' AND user_id='$user_id'");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$month = date('m', $r_tt['date_post']);
			$month = intval($month);
			if ($month == 1) {
				$month_1++;
			} else if ($month == 2) {
				$month_2++;
			} else if ($month == 3) {
				$month_3++;
			} else if ($month == 4) {
				$month_4++;
			} else if ($month == 5) {
				$month_5++;
			} else if ($month == 6) {
				$month_6++;
			} else if ($month == 7) {
				$month_7++;
			} else if ($month == 8) {
				$month_8++;
			} else if ($month == 9) {
				$month_9++;
			} else if ($month == 10) {
				$month_10++;
			} else if ($month == 11) {
				$month_11++;

			} else if ($month == 12) {
				$month_12++;
			}
		}
		$thongtin_ctv = mysqli_query($conn, "SELECT * FROM donhang_ctv WHERE date_post>='$dau' AND date_post<='$cuoi' AND user_id='$user_id'");
		while ($r_tt_ctv = mysqli_fetch_assoc($thongtin_ctv)) {
			$month = date('m', $r_tt_ctv['date_post']);
			$month = intval($month);
			if ($month == 1) {
				$month_ctv_1++;
			} else if ($month == 2) {
				$month_ctv_2++;
			} else if ($month == 3) {
				$month_ctv_3++;
			} else if ($month == 4) {
				$month_ctv_4++;
			} else if ($month == 5) {
				$month_ctv_5++;
			} else if ($month == 6) {
				$month_ctv_6++;
			} else if ($month == 7) {
				$month_ctv_7++;
			} else if ($month == 8) {
				$month_ctv_8++;
			} else if ($month == 9) {
				$month_ctv_9++;
			} else if ($month == 10) {
				$month_ctv_10++;
			} else if ($month == 11) {
				$month_ctv_11++;

			} else if ($month == 12) {
				$month_12++;
			}
		}
		$month_1 = $month_1 + $month_ctv_1;
		$month_2 = $month_2 + $month_ctv_2;
		$month_3 = $month_3 + $month_ctv_3;
		$month_4 = $month_4 + $month_ctv_4;
		$month_5 = $month_5 + $month_ctv_5;
		$month_6 = $month_6 + $month_ctv_6;
		$month_7 = $month_7 + $month_ctv_7;
		$month_8 = $month_8 + $month_ctv_8;
		$month_9 = $month_9 + $month_ctv_9;
		$month_10 = $month_10 + $month_ctv_10;
		$month_11 = $month_11 + $month_ctv_11;
		$month_12 = $month_12 + $month_ctv_12;
		return intval($month_1) . ',' . intval($month_2) . ',' . intval($month_3) . ',' . intval($month_4) . ',' . intval($month_5) . ',' . intval($month_6) . ',' . intval($month_7) . ',' . intval($month_8) . ',' . intval($month_9) . ',' . intval($month_10) . ',' . intval($month_11) . ',' . intval($month_12);
	}
	///////////////////
	function thongke_donhang_thanhvien_thang($conn, $user_id, $thang, $nam, $dau, $cuoi) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$thongtin = mysqli_query($conn, "SELECT * FROM donhang WHERE date_post>='$dau' AND date_post<='$cuoi' AND user_id='$user_id'");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$ngay = date('d', $r_tt['date_post']);
			$ngay = intval($ngay);
			if ($thang == 2) {
				if (checkdate(02, 29, $nam) == true) {
					for ($i = 1; $i <= 29; $i++) {
						if ($ngay == $i) {
							$data_ngay[$i]++;
						}
					}
				} else {
					for ($i = 1; $i <= 28; $i++) {
						if ($ngay == $i) {
							$data_ngay[$i]++;
						}
					}

				}
			} else if (in_array($thang, array('1', '3', '5', '7', '8', '10', '12')) == true) {
				for ($i = 1; $i <= 31; $i++) {
					if ($ngay == $i) {
						$data_ngay[$i]++;
					}
				}
			} else {
				for ($i = 1; $i <= 30; $i++) {
					if ($ngay == $i) {
						$data_ngay[$i]++;
					}
				}

			}

		}
		$thongtin_ctv = mysqli_query($conn, "SELECT * FROM donhang_ctv WHERE date_post>='$dau' AND date_post<='$cuoi' AND user_id='$user_id'");
		while ($r_tt_ctv = mysqli_fetch_assoc($thongtin_ctv)) {
			$ngay = date('d', $r_tt_ctv['date_post']);
			$ngay = intval($ngay);
			if ($thang == 2) {
				if (checkdate(02, 29, $nam) == true) {
					for ($i = 1; $i <= 29; $i++) {
						if ($ngay == $i) {
							$data_ngay_ctv[$i]++;
						}
					}
				} else {
					for ($i = 1; $i <= 28; $i++) {
						if ($ngay == $i) {
							$data_ngay_ctv[$i]++;
						}
					}

				}
			} else if (in_array($thang, array('1', '3', '5', '7', '8', '10', '12')) == true) {
				for ($i = 1; $i <= 31; $i++) {
					if ($ngay == $i) {
						$data_ngay_ctv[$i]++;
					}
				}
			} else {
				for ($i = 1; $i <= 30; $i++) {
					if ($ngay == $i) {
						$data_ngay_ctv[$i]++;
					}
				}

			}

		}
		if ($thang == 2) {
			if (checkdate(02, 29, $nam) == true) {
				for ($i = 1; $i <= 29; $i++) {
					$data_thang .= intval($data_ngay[$i] + $data_ngay_ctv[$i]) . ',';
				}
			} else {
				for ($i = 1; $i <= 28; $i++) {
					$data_thang .= intval($data_ngay[$i] + $data_ngay_ctv[$i]) . ',';
				}

			}
		} else if (in_array($thang, array('1', '3', '5', '7', '8', '10', '12')) == true) {
			for ($i = 1; $i <= 31; $i++) {
				$data_thang .= intval($data_ngay[$i] + $data_ngay_ctv[$i]) . ',';
			}
		} else {
			for ($i = 1; $i <= 30; $i++) {
				$data_thang .= intval($data_ngay[$i] + $data_ngay_ctv[$i]) . ',';
			}

		}
		$data_thang = substr($data_thang, 0, -1);
		return $data_thang;
	}
	///////////////////
	function thongke_donhang_thanhvien_tuan($conn, $user_id, $dau, $cuoi) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$thongtin = mysqli_query($conn, "SELECT * FROM donhang WHERE date_post>='$dau' AND date_post<='$cuoi' AND user_id='$user_id'");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$month = date('m', $r_tt['date_post']);
			$day = date('d', $r_tt['date_post']);
			$year = date('Y', $r_tt['date_post']);
			$wkday = date('l', mktime('0', '0', '0', $month, $day, $year));
			if ($wkday == 'Monday') {
				$mon++;
			} else if ($wkday == 'Tuesday') {
				$tus++;
			} else if ($wkday == 'Wednesday') {
				$web++;
			} else if ($wkday == 'Thursday') {
				$thu++;
			} else if ($wkday == 'Friday') {
				$fri++;
			} else if ($wkday == 'Saturday') {
				$sat++;
			} else if ($wkday == 'Sunday') {
				$sun++;
			}
		}
		$thongtin_ctv = mysqli_query($conn, "SELECT * FROM donhang_ctv WHERE date_post>='$dau' AND date_post<='$cuoi' AND user_id='$user_id'");
		while ($r_tt_ctv = mysqli_fetch_assoc($thongtin_ctv)) {
			$month = date('m', $r_tt_ctv['date_post']);
			$day = date('d', $r_tt_ctv['date_post']);
			$year = date('Y', $r_tt_ctv['date_post']);
			$wkday = date('l', mktime('0', '0', '0', $month, $day, $year));
			if ($wkday == 'Monday') {
				$mon_ctv++;
			} else if ($wkday == 'Tuesday') {
				$tus_ctv++;
			} else if ($wkday == 'Wednesday') {
				$web_ctv++;
			} else if ($wkday == 'Thursday') {
				$thu_ctv++;
			} else if ($wkday == 'Friday') {
				$fri_ctv++;
			} else if ($wkday == 'Saturday') {
				$sat_ctv++;
			} else if ($wkday == 'Sunday') {
				$sun_ctv++;
			}
		}
		return intval($mon + $mon_ctv) . ',' . intval($tus + $tus_ctv) . ',' . intval($web + $web_ctv) . ',' . intval($thu + $thu_ctv) . ',' . intval($fri + $fri_ctv) . ',' . intval($sat + $sat_ctv) . ',' . intval($sun + $sun_ctv);
		//return intval($mon) . ',' . intval($tus) . ',' . intval($web) . ',' . intval($thu) . ',' . intval($fri) . ',' . intval($sat) . ',' . intval($sun);
	}
	///////////////////
	function list_kq_timkiem_sanpham_thuonghieu($conn,$list_follow,$leader,$gia_leader,$kieu, $kho, $thuong_hieu) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$tach_key = explode(' ', $key);
		$k = 0;
		$tach_follow=explode(',', $list_follow);
		$thongtin = mysqli_query($conn, "SELECT * FROM sanpham WHERE thuong_hieu='$thuong_hieu' AND (noi_ban LIKE '%drop%' OR noi_ban LIKE '%all%') AND cat_ma='0' ORDER BY tieu_de ASC");
		$i = 0;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$r_tt['date_post'] = date('d/m/Y', $r_tt['date_post']);
			$r_tt['gia_cu'] = number_format($r_tt['gia_cu']);
			$r_tt['gia_moi'] = number_format($r_tt['gia_moi']);
			if($leader==1 OR $gia_leader==1){
				$r_tt['gia_nhap'] = number_format($r_tt['gia_drop']);
			}else{
				$r_tt['gia_nhap'] = number_format($r_tt['gia_ctv']);
			}
			if ($r_tt['drop_min'] == 0) {
				$r_tt['drop_min'] = 'Không quy định';
			} else {
				$r_tt['drop_min'] = number_format($r_tt['drop_min']);
			}
			$r_tt['drop_max'] = number_format($r_tt['drop_max']);
			if ($kho == 'kho_hcm') {
				$r_tt['kho'] = $r_tt['kho_hcm'];
			}
			if(in_array($r_tt['id'], $tach_follow)==true){
				$r_tt['class_follow']='fa-check-square';
			}else{
				$r_tt['class_follow']='fa-square-o';
			}
			if ($r_tt['ma_sanpham'] != '') {
				if (strpos($r_tt['ma_sanpham'], '|') !== false) {
					$tach_ma_sanpham = explode('|', $r_tt['ma_sanpham']);
					foreach ($tach_ma_sanpham as $key => $value) {
						$tach_value = explode('&&', $value);
						$list_ma .= $tach_value[2] . ':' . $tach_value[1] . '<br>';
					}

				} else {
					$tach_ma_sanpham = explode('&&', $r_tt['ma_sanpham']);
					$list_ma = $tach_ma_sanpham[2] . ':' . $tach_ma_sanpham[1];
				}
			} else {
				$list_ma = '';
			}
			$r_tt['list_ma'] = $list_ma;
			unset($list_ma);
			if($kieu=='mobile'){
				$list .= $skin->skin_replace('skin_dropship/box_action/tr_sanpham_drop_mobile', $r_tt);
			}else{
				$list .= $skin->skin_replace('skin_dropship/box_action/tr_sanpham_drop', $r_tt);
			}
		}
		mysqli_free_result($thongtin);
		if ($i == 0) {
			$list = '<center>Không có kết quả</center>';
		}
		return $list;
	}
	///////////////////
	function list_kq_timkiem_sanpham_thuonghieu_add($conn,$leader,$gia_leader,$kieu, $kho, $thuong_hieu) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$tach_key = explode(' ', $key);
		$k = 0;

		$thongtin = mysqli_query($conn, "SELECT * FROM sanpham WHERE thuong_hieu='$thuong_hieu' AND (noi_ban LIKE '%drop%' OR noi_ban LIKE '%all%') AND cat_ma='0' ORDER BY tieu_de ASC");
		$i = 0;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$r_tt['date_post'] = date('d/m/Y', $r_tt['date_post']);
			$r_tt['gia_cu'] = number_format($r_tt['gia_cu']);
			$r_tt['gia_moi'] = number_format($r_tt['gia_moi']);
			if($leader==1 OR $gia_leader==1){
				$r_tt['gia_nhap'] = number_format($r_tt['gia_drop']);
			}else{
				$r_tt['gia_nhap'] = number_format($r_tt['gia_ctv']);
			}
			if ($r_tt['drop_min'] == 0) {
				$r_tt['drop_min'] = 'Không quy định';
			} else {
				$r_tt['drop_min'] = number_format($r_tt['drop_min']);
			}
			$r_tt['drop_max'] = number_format($r_tt['drop_max']);
			if ($kho == 'kho_hcm') {
				$r_tt['kho'] = $r_tt['kho_hcm'];
			}
			if($kieu=='mobile'){
				$list .= $skin->skin_replace('skin_dropship/box_action/tr_sanpham_mobile', $r_tt);
			}else{
				$list .= $skin->skin_replace('skin_dropship/box_action/tr_sanpham', $r_tt);
			}
		}
		mysqli_free_result($thongtin);
		if ($i == 0) {
			$list = '<center>Không có kết quả</center>';
		}
		return $list;
	}
	///////////////////
	function list_kq_timkiem_link_affiliate($conn,$user_id,$leader,$gia_leader,$kieu, $kho, $key) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$tach_key = explode(' ', $key);
		$k = 0;
		foreach ($tach_key as $key => $value) {
			$k++;
			if ($value != '') {
				if ($k == 1) {
					$where .= "sanpham.tieu_de LIKE '%$value%'";
				} else {
					$where .= " AND sanpham.tieu_de LIKE '%$value%'";
				}
			}
		}
		$thongtin = mysqli_query($conn, "SELECT sanpham.*,rut_gon.rut_gon,rut_gon.click FROM sanpham LEFT JOIN rut_gon ON rut_gon.user_id='$user_id' AND rut_gon.sp_id=sanpham.id WHERE $where GROUP BY sanpham.id ORDER BY sanpham.id DESC ");
		$i = $start;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$r_tt['date_post'] = date('d/m/Y', $r_tt['date_post']);
			$cat=$r_tt['cat'];
			$ko_apdung=0;
			if($cat==''){
				$hoa_hong='0';
			}else{
				$thongtin_cat=mysqli_query($conn,"SELECT * FROM category_sanpham WHERE cat_id IN ($cat) ORDER BY cat_id ASC");
				while($r_c=mysqli_fetch_assoc($thongtin_cat)){
					if($r_c['hoa_hong']=='ko' OR $r_c['hoa_hong']=='khong'){
						$ko_apdung=1;
					}else if($r_c['cat_main']>0){
						if($r_c['hoa_hong']!=''){
							$hoa_hong=($r_tt['gia_moi']/100)*$r_c['hoa_hong'];
						}else{

						}
					}else if($r_c['cat_main']==0){
						$hoa_hong=($r_tt['gia_moi']/100)*intval($r_c['hoa_hong']);
					}
				}
			}
			if($ko_apdung==1){
				$r_tt['hoa_hong']='Không Áp dụng';
			}else{
				$r_tt['hoa_hong']=number_format($hoa_hong).' đ';
			}
			if($r_tt['rut_gon']==''){
				$r_tt['rut_gon']='';
			}else{
				$r_tt['rut_gon']='<input type="text" id="link_rutgon_aff_'.$r_tt['id'].'" name="link_rutgon_aff" value="https://socdo.xyz/v/'.$r_tt['rut_gon'].'">
			<button class="copy_rutgon_aff"><i class="icofont-ui-copy"></i> copy</button>';
			}
			$r_tt['gia_cu'] = number_format($r_tt['gia_cu']);
			$r_tt['gia_moi'] = number_format($r_tt['gia_moi']);
			$r_tt['gia_drop'] = number_format($r_tt['gia_drop']);
			if ($r_tt['drop_min'] == 0) {
				$r_tt['drop_min'] = 'Không quy định';
			} else {
				$r_tt['drop_min'] = number_format($r_tt['drop_min']);
			}
			if ($kho == 'kho_hcm') {
				$r_tt['kho'] = $r_tt['kho_hcm'];
			}
			$r_tt['drop_max'] = number_format($r_tt['drop_max']);
			$r_tt['user_id']=$user_id;
			$r_tt['click']=number_format($r_tt['click']);
			if($kieu=='laptop'){
				$list .= $skin->skin_replace('skin_dropship/box_action/tr_link_aff', $r_tt);
			}else if($kieu=='mobile'){
				$list .= $skin->skin_replace('skin_dropship/box_action/tr_link_aff_mobile', $r_tt);
			}			
		}
		return $list;
	}
	///////////////////
	function list_kq_timkiem_link_affiliate_thuonghieu($conn,$user_id,$leader,$gia_leader,$kieu, $kho, $thuong_hieu) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$k = 0;
		$thongtin = mysqli_query($conn, "SELECT sanpham.*,rut_gon.rut_gon,rut_gon.click FROM sanpham LEFT JOIN rut_gon ON rut_gon.user_id='$user_id' AND rut_gon.sp_id=sanpham.id WHERE sanpham.thuong_hieu='$thuong_hieu' GROUP BY sanpham.id ORDER BY sanpham.id DESC ");
		$i = $start;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$r_tt['date_post'] = date('d/m/Y', $r_tt['date_post']);
			$cat=$r_tt['cat'];
			$ko_apdung=0;
			if($cat==''){
				$hoa_hong='0';
			}else{
				$thongtin_cat=mysqli_query($conn,"SELECT * FROM category_sanpham WHERE cat_id IN ($cat) ORDER BY cat_id ASC");
				while($r_c=mysqli_fetch_assoc($thongtin_cat)){
					if($r_c['hoa_hong']=='ko' OR $r_c['hoa_hong']=='khong'){
						$ko_apdung=1;
					}else if($r_c['cat_main']>0){
						if($r_c['hoa_hong']!=''){
							$hoa_hong=($r_tt['gia_moi']/100)*$r_c['hoa_hong'];
						}else{

						}
					}else if($r_c['cat_main']==0){
						$hoa_hong=($r_tt['gia_moi']/100)*intval($r_c['hoa_hong']);
					}
				}
			}
			if($ko_apdung==1){
				$r_tt['hoa_hong']='Không Áp dụng';
			}else{
				$r_tt['hoa_hong']=number_format($hoa_hong).' đ';
			}
			if($r_tt['rut_gon']==''){
				$r_tt['rut_gon']='';
			}else{
				$r_tt['rut_gon']='<input type="text" id="link_rutgon_aff_'.$r_tt['id'].'" name="link_rutgon_aff" value="https://socdo.xyz/v/'.$r_tt['rut_gon'].'">
			<button class="copy_rutgon_aff"><i class="icofont-ui-copy"></i> copy</button>';
			}
			$r_tt['gia_cu'] = number_format($r_tt['gia_cu']);
			$r_tt['gia_moi'] = number_format($r_tt['gia_moi']);
			$r_tt['gia_drop'] = number_format($r_tt['gia_drop']);
			if ($r_tt['drop_min'] == 0) {
				$r_tt['drop_min'] = 'Không quy định';
			} else {
				$r_tt['drop_min'] = number_format($r_tt['drop_min']);
			}
			if ($kho == 'kho_hcm') {
				$r_tt['kho'] = $r_tt['kho_hcm'];
			}
			$r_tt['drop_max'] = number_format($r_tt['drop_max']);
			$r_tt['user_id']=$user_id;
			$r_tt['click']=number_format($r_tt['click']);
			if($kieu=='laptop'){
				$list .= $skin->skin_replace('skin_dropship/box_action/tr_link_aff', $r_tt);
			}else if($kieu=='mobile'){
				$list .= $skin->skin_replace('skin_dropship/box_action/tr_link_aff_mobile', $r_tt);
			}			
		}
		return $list;
	}
	///////////////////
	function list_kq_timkiem_sanpham_thuonghieu_trend($conn,$leader,$gia_leader,$kieu, $kho, $shop, $thuong_hieu) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$tach_key = explode(' ', $key);
		$k = 0;
		//$thongtin = mysqli_query($conn, "SELECT * FROM sanpham sp WHERE sp.thuong_hieu='$thuong_hieu' AND (sp.noi_ban LIKE '%drop%' OR sp.noi_ban LIKE '%all%') AND (SELECT count(*) FROM sanpham_trend st WHERE st.sp_id=sp.id)>'0' ORDER BY sp.tieu_de ASC");
		$thongtin = mysqli_query($conn, "SELECT *,(SELECT count(*) FROM sanpham_shop ss WHERE ss.shop='$shop' AND ss.sp_id=st.sp_id) AS total  FROM sanpham_trend st INNER JOIN sanpham sp ON st.sp_id=sp.id WHERE sp.thuong_hieu='$thuong_hieu' AND (sp.noi_ban LIKE '%drop%' OR sp.noi_ban LIKE '%all%') ORDER BY sp.tieu_de ASC");
		$i = 0;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$r_tt['date_post'] = date('d/m/Y', $r_tt['date_post']);
			$r_tt['gia_cu'] = number_format($r_tt['gia_cu']);
			$r_tt['gia_moi'] = number_format($r_tt['gia_moi']);
			if($leader==1 OR $gia_leader==1){
				$r_tt['gia_nhap'] = number_format($r_tt['gia_drop']);
			}else{
				$r_tt['gia_nhap'] = number_format($r_tt['gia_ctv']);
			}
			if ($r_tt['drop_min'] == 0) {
				$r_tt['drop_min'] = 'Không quy định';
			} else {
				$r_tt['drop_min'] = number_format($r_tt['drop_min']);
			}
			$r_tt['drop_max'] = number_format($r_tt['drop_max']);
			$r_tt['gia'] = number_format($r_tt['gia']);
			if ($kho == 'kho_hcm') {
				$r_tt['kho'] = $r_tt['kho_hcm'];
			}
			if($kieu=='mobile'){
				$list .= $skin->skin_replace('skin_dropship/box_action/tr_sanpham_trend_add_mobile', $r_tt);
			}else{
				$list .= $skin->skin_replace('skin_dropship/box_action/tr_sanpham_trend_add', $r_tt);

			}
		}
		mysqli_free_result($thongtin);
		if ($i == 0) {
			$list = '<center>Không có kết quả</center>';
		}
		return $list;
	}
	///////////////////
	function list_kq_timkiem_sanpham_thuonghieu_tuan($conn,$leader,$gia_leader, $kho, $thuong_hieu) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$tach_key = explode(' ', $key);
		$k = 0;

		//$thongtin = mysqli_query($conn, "SELECT * FROM sanpham sp WHERE sp.thuong_hieu='$thuong_hieu' AND (sp.noi_ban LIKE '%drop%' OR sp.noi_ban LIKE '%all%') AND (SELECT count(*) FROM sanpham_tuan st WHERE st.sp_id=sp.id)>'0' ORDER BY tieu_de ASC");
		$thongtin = mysqli_query($conn, "SELECT * FROM sanpham_tuan LEFT JOIN sanpham ON sanpham_tuan.sp_id=sanpham.id WHERE sanpham.thuong_hieu='$thuong_hieu' AND (sanpham.noi_ban LIKE '%drop%' OR sanpham.noi_ban LIKE '%all%') ORDER BY sanpham.tieu_de ASC");
		$i = 0;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$r_tt['date_post'] = date('d/m/Y', $r_tt['date_post']);
			$r_tt['gia_cu'] = number_format($r_tt['gia_cu']);
			$r_tt['gia_moi'] = number_format($r_tt['gia_moi']);
			if($leader==1 OR $gia_leader==1){
				$r_tt['gia_nhap'] = number_format($r_tt['gia_drop']);
			}else{
				$r_tt['gia_nhap'] = number_format($r_tt['gia_ctv']);
			}
			if ($r_tt['drop_min'] == 0) {
				$r_tt['drop_min'] = 'Không quy định';
			} else {
				$r_tt['drop_min'] = number_format($r_tt['drop_min']);
			}
			$r_tt['drop_max'] = number_format($r_tt['drop_max']);
			if ($r_tt['time_start'] > time()) {
				$r_tt['text_time'] = 'Bắt đầu sau:';
				$r_tt['conlai'] = $r_tt['time_start'] - time();
				$r_tt['status'] = 0;
				$r_tt['thoigian'] = $r_tt['time_end'] - $r_tt['time_start'];
			} else {
				$r_tt['text_time'] = 'Kết thúc sau:';
				$r_tt['conlai'] = $r_tt['time_end'] - time();
				$r_tt['thoigian'] = $r_tt['time_end'] - $r_tt['time_start'];
				$r_tt['status'] = 1;
			}
			if ($kho == 'kho_hcm') {
				$r_tt['kho'] = $r_tt['kho_hcm'];
			}
			$r_tt['gia_truoc'] = number_format($r_tt['gia_truoc']);
			$r_tt['gia_tuan'] = number_format($r_tt['gia_tuan']);
			$list .= $skin->skin_replace('skin_dropship/box_action/tr_sanpham_tuan', $r_tt);
		}
		mysqli_free_result($thongtin);
		if ($i == 0) {
			$list = '<center>Không có kết quả</center>';
		}
		return $list;
	}
	///////////////////
	function list_kq_timkiem_sanpham_shop($conn,$leader,$gia_leader, $shop, $key) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$tach_key = explode(' ', $key);
		$k = 0;
		foreach ($tach_key as $key => $value) {
			$k++;
			if ($value != '') {
				if ($k == 1) {
					$where .= "sanpham_shop.tieu_de LIKE '%$value%'";
				} else {
					$where .= " AND sanpham_shop.tieu_de LIKE '%$value%'";
				}
			}
		}
		$thongtin = mysqli_query($conn, "SELECT sanpham_shop.*,sanpham.kho,sanpham.gia_drop FROM sanpham_shop LEFT JOIN sanpham ON sanpham_shop.sp_id=sanpham.id WHERE $where AND sanpham_shop.shop='$shop' ORDER BY sanpham_shop.tieu_de ASC");
		$i = 0;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$r_tt['date_post'] = date('d/m/Y', $r_tt['date_post']);
			$r_tt['gia_cu'] = number_format($r_tt['gia_cu']);
			$r_tt['gia_moi'] = number_format($r_tt['gia_moi']);
			if($leader==1 OR $gia_leader==1){
				$r_tt['gia_nhap'] = number_format($r_tt['gia_drop']);
			}else{
				$r_tt['gia_nhap'] = number_format($r_tt['gia_ctv']);
			}
			if ($r_tt['drop_min'] == 0) {
				$r_tt['drop_min'] = 'Không quy định';
			} else {
				$r_tt['drop_min'] = number_format($r_tt['drop_min']);
			}
			$r_tt['drop_max'] = number_format($r_tt['drop_max']);
			$list .= $skin->skin_replace('skin_dropship/box_action/tr_sanpham_shop', $r_tt);
		}
		mysqli_free_result($thongtin);
		if ($i == 0) {
			$list = '<center>Không có kết quả</center>';
		}
		return $list;
	}
	///////////////////
	function list_kq_timkiem_sanpham_tuan($conn,$leader,$gia_leader, $kho, $key) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$tach_key = explode(' ', $key);
		$k = 0;
		foreach ($tach_key as $key => $value) {
			$k++;
			if ($value != '') {
				if ($k == 1) {
					$where .= "sp.tieu_de LIKE '%$value%'";
				} else {
					$where .= " AND sp.tieu_de LIKE '%$value%'";
				}
			}
		}
		$thongtin = mysqli_query($conn, "SELECT * FROM sanpham_tuan st INNER JOIN sanpham sp ON st.sp_id=sp.id WHERE $where AND (sp.noi_ban LIKE '%drop%' OR sp.noi_ban LIKE '%all%') ORDER BY sp.tieu_de ASC");
		$i = 0;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$r_tt['date_post'] = date('d/m/Y', $r_tt['date_post']);
			$r_tt['gia_cu'] = number_format($r_tt['gia_cu']);
			$r_tt['gia_moi'] = number_format($r_tt['gia_moi']);
			if($leader==1 OR $gia_leader==1){
				$r_tt['gia_nhap'] = number_format($r_tt['gia_drop']);
			}else{
				$r_tt['gia_nhap'] = number_format($r_tt['gia_ctv']);
			}
			if ($r_tt['drop_min'] == 0) {
				$r_tt['drop_min'] = 'Không quy định';
			} else {
				$r_tt['drop_min'] = number_format($r_tt['drop_min']);
			}
			$r_tt['drop_max'] = number_format($r_tt['drop_max']);
			$r_tt['gia_truoc'] = number_format($r_tt['gia_truoc']);
			$r_tt['gia_tuan'] = number_format($r_tt['gia_tuan']);
			if ($r_tt['time_start'] > time()) {
				$r_tt['text_time'] = 'Bắt đầu sau:';
				$r_tt['conlai'] = $r_tt['time_start'] - time();
				$r_tt['status'] = 0;
				$r_tt['thoigian'] = $r_tt['time_end'] - $r_tt['time_start'];
			} else {
				$r_tt['text_time'] = 'Kết thúc sau:';
				$r_tt['conlai'] = $r_tt['time_end'] - time();
				$r_tt['thoigian'] = $r_tt['time_end'] - $r_tt['time_start'];
				$r_tt['status'] = 1;
			}
			if ($kho == 'kho_hcm') {
				$r_tt['kho'] = $r_tt['kho_hcm'];
			}
			$list .= $skin->skin_replace('skin_dropship/box_action/tr_sanpham_tuan', $r_tt);
		}
		mysqli_free_result($thongtin);
		if ($i == 0) {
			$list = '<center>Không có kết quả</center>';
		}
		return $list;
	}
	///////////////////
	function list_kq_timkiem_sanpham_trend($conn,$leader,$gia_leader,$kieu, $kho, $shop, $key) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$tach_key = explode(' ', $key);
		$k = 0;
		foreach ($tach_key as $key => $value) {
			$k++;
			if ($value != '') {
				if ($k == 1) {
					$where .= "sp.tieu_de LIKE '%$value%'";
				} else {
					$where .= " AND sp.tieu_de LIKE '%$value%'";
				}
			}
		}
		$thongtin = mysqli_query($conn, "SELECT *,(SELECT count(*) FROM sanpham_shop ss WHERE ss.shop='$shop' AND ss.sp_id=st.sp_id) AS total FROM sanpham_trend st INNER JOIN sanpham sp ON st.sp_id=sp.id WHERE $where AND (sp.noi_ban LIKE '%drop%' OR sp.noi_ban LIKE '%all%') ORDER BY sp.tieu_de ASC");
		$i = 0;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$r_tt['date_post'] = date('d/m/Y', $r_tt['date_post']);
			$r_tt['gia_cu'] = number_format($r_tt['gia_cu']);
			$r_tt['gia_moi'] = number_format($r_tt['gia_moi']);
			if($leader==1 OR $gia_leader==1){
				$r_tt['gia_nhap'] = number_format($r_tt['gia_drop']);
			}else{
				$r_tt['gia_nhap'] = number_format($r_tt['gia_ctv']);
			}
			if ($r_tt['drop_min'] == 0) {
				$r_tt['drop_min'] = 'Không quy định';
			} else {
				$r_tt['drop_min'] = number_format($r_tt['drop_min']);
			}
			$r_tt['drop_max'] = number_format($r_tt['drop_max']);
			$r_tt['gia'] = number_format($r_tt['gia']);
			if ($kho == 'kho_hcm') {
				$r_tt['kho'] = $r_tt['kho_hcm'];
			}
			if($kieu=='mobile'){
				$list .= $skin->skin_replace('skin_dropship/box_action/tr_sanpham_trend_add_mobile', $r_tt);
			}else{
				$list .= $skin->skin_replace('skin_dropship/box_action/tr_sanpham_trend_add', $r_tt);
			}
		}
		mysqli_free_result($thongtin);
		if ($i == 0) {
			$list = '<center>Không có kết quả</center>';
		}
		return $list;
	}
	///////////////////
	function list_kq_timkiem_sanpham_drop($conn,$list_follow,$leader,$gia_leader,$kieu, $kho, $key) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$tach_key = explode(' ', $key);
		$k = 0;
		$tach_follow=explode(',', $list_follow);
		foreach ($tach_key as $key => $value) {
			$k++;
			if ($value != '') {
				if ($k == 1) {
					$where .= "tieu_de LIKE '%$value%'";
				} else {
					$where .= " AND tieu_de LIKE '%$value%'";
				}
			}
		}
		$thongtin = mysqli_query($conn, "SELECT * FROM sanpham WHERE $where AND (noi_ban LIKE '%drop%' OR noi_ban LIKE '%all%') AND cat_ma='0' ORDER BY tieu_de ASC");
		$i = 0;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$r_tt['date_post'] = date('d/m/Y', $r_tt['date_post']);
			$r_tt['gia_cu'] = number_format($r_tt['gia_cu']);
			$r_tt['gia_moi'] = number_format($r_tt['gia_moi']);
			if($leader==1 OR $gia_leader==1){
				$r_tt['gia_nhap'] = number_format($r_tt['gia_drop']);
			}else{
				$r_tt['gia_nhap'] = number_format($r_tt['gia_ctv']);
			}
			if ($r_tt['drop_min'] == 0) {
				$r_tt['drop_min'] = 'Không quy định';
			} else {
				$r_tt['drop_min'] = number_format($r_tt['drop_min']);
			}
			if ($r_tt['ma_sanpham'] != '') {
				if (strpos($r_tt['ma_sanpham'], '|') !== false) {
					$tach_ma_sanpham = explode('|', $r_tt['ma_sanpham']);
					foreach ($tach_ma_sanpham as $key => $value) {
						$tach_value = explode('&&', $value);
						$list_ma .= $tach_value[2] . ':' . $tach_value[1] . '<br>';
					}

				} else {
					$tach_ma_sanpham = explode('&&', $r_tt['ma_sanpham']);
					$list_ma = $tach_ma_sanpham[2] . ':' . $tach_ma_sanpham[1];
				}
			} else {
				$list_ma = '';
			}
			$r_tt['list_ma'] = $list_ma;
			unset($list_ma);
			$r_tt['drop_max'] = number_format($r_tt['drop_max']);
			if ($kho == 'kho_hcm') {
				$r_tt['kho'] = $r_tt['kho_hcm'];
			}
			if(in_array($r_tt['id'], $tach_follow)==true){
				$r_tt['class_follow']='fa-check-square';
			}else{
				$r_tt['class_follow']='fa-square-o';
			}
			if($kieu=='mobile'){
				$list .= $skin->skin_replace('skin_dropship/box_action/tr_sanpham_drop_mobile', $r_tt);
			}else{
				$list .= $skin->skin_replace('skin_dropship/box_action/tr_sanpham_drop', $r_tt);

			}
		}
		mysqli_free_result($thongtin);
		if ($i == 0) {
			$list = '<center>Không có kết quả</center>';
		}
		return $list;
	}
	///////////////////
	function list_kq_timkiem_sanpham($conn,$leader,$gia_leader,$kieu, $kho, $key) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$tach_key = explode(' ', $key);
		$k = 0;
		foreach ($tach_key as $key => $value) {
			$k++;
			if ($value != '') {
				if ($k == 1) {
					$where .= "tieu_de LIKE '%$value%'";
				} else {
					$where .= " AND tieu_de LIKE '%$value%'";
				}
			}
		}
		$thongtin = mysqli_query($conn, "SELECT * FROM sanpham WHERE $where AND (noi_ban LIKE '%drop%' OR noi_ban LIKE '%all%') AND cat_ma='0' ORDER BY tieu_de ASC");
		$i = 0;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$r_tt['date_post'] = date('d/m/Y', $r_tt['date_post']);
			$r_tt['gia_cu'] = number_format($r_tt['gia_cu']);
			$r_tt['gia_moi'] = number_format($r_tt['gia_moi']);
			if($leader==1 OR $gia_leader==1){
				$r_tt['gia_nhap'] = number_format($r_tt['gia_drop']);
			}else{
				$r_tt['gia_nhap'] = number_format($r_tt['gia_ctv']);
			}
			if ($r_tt['drop_min'] == 0) {
				$r_tt['drop_min'] = 'Không quy định';
			} else {
				$r_tt['drop_min'] = number_format($r_tt['drop_min']);
			}
			$r_tt['drop_max'] = number_format($r_tt['drop_max']);
			if ($kho == 'kho_hcm') {
				$r_tt['kho'] = $r_tt['kho_hcm'];
			}
			if($kieu=='mobile'){
				$list .= $skin->skin_replace('skin_dropship/box_action/tr_sanpham_mobile', $r_tt);
			}else{
				$list .= $skin->skin_replace('skin_dropship/box_action/tr_sanpham', $r_tt);
			}
		}
		mysqli_free_result($thongtin);
		if ($i == 0) {
			$list = '<center>Không có kết quả</center>';
		}
		return $list;
	}
	///////////////////
	function list_kq_timkiem_thanhvien($conn, $key) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$thongtin = mysqli_query($conn, "SELECT * FROM user_info WHERE username LIKE '%$key%' OR name LIKE '%$key%' OR email LIKE '%$key%' OR user_id='$key' ORDER BY name ASC");
		$i = 0;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$r_tt['user_money'] = number_format($r_tt['user_money']);
			$r_tt['user_donate'] = number_format($r_tt['user_donate']);
			$r_tt['created'] = date('d/m/Y', $r_tt['created']);
			if ($r_tt['active'] == 2) {
				$r_tt['tinh_trang'] = 'Tạm khóa';
			} else if ($r_tt['active'] == 3) {
				$r_tt['tinh_trang'] = '<span class="color_red bold">Khóa vĩnh viễn</span>';
			} else {
				$r_tt['tinh_trang'] = 'Bình thường';
			}
			$list .= $skin->skin_replace('skin_dropship/box_action/tr_thanhvien', $r_tt);
		}
		mysqli_free_result($thongtin);
		if ($i == 0) {
			$list = '<center>Không có kết quả</center>';
		}
		return $list;
	}
	////////////////////
	function list_kq_timkiem_donhang($conn,$user_id, $key) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$i = 0;
		$thongtin = mysqli_query($conn, "SELECT * FROM donhang_shop WHERE (ma_don LIKE '%$key%' OR ho_ten LIKE '%$key%' OR email LIKE '%$key%' OR dien_thoai LIKE '%$key%') AND shop='$user_id' ORDER BY date_post DESC");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$r_tt['tongtien'] = number_format($r_tt['tongtien']) . 'đ';
			$r_tt['date_post'] = date('d/m/Y', $r_tt['date_post']);
			if ($r_tt['status'] == 1) {
				$r_tt['status'] = 'Đã tiếp nhận đơn';
				$r_tt['huy'] = '';
			} else if ($r_tt['status'] == 2) {
				$r_tt['status'] = 'Đã giao đơn vị vận chuyển';
				$r_tt['huy'] = '';
			} else if ($r_tt['status'] == 3) {
				$r_tt['status'] = 'Yêu cầu hủy đơn';
				$r_tt['huy'] = '';
			} else if ($r_tt['status'] == 4) {
				$r_tt['status'] = 'Đã hủy đơn';
				$r_tt['huy'] = '';
			} else if ($r_tt['status'] == 5) {
				$r_tt['status'] = 'Giao thành công';
				$r_tt['huy'] = '';
			} else if ($r_tt['status'] == 6) {
				$r_tt['status'] = 'Đã hoàn đơn';
				$r_tt['huy'] = '';
			} else {
				$r_tt['status'] = 'Chờ xử lý';
			}
			$tach_sanpham = json_decode($r_tt['sanpham'], true);
			foreach ($tach_sanpham as $key => $value) {
				$s++;
				if ($value['size'] != '') {
					$value['size'] = ' - Size: ' . $value['size'];
				}
				if ($value['color'] != '') {
					$value['color'] = ' - Màu: ' . $value['color'];
				}
				$list_sanpham .= '+' . $value['tieu_de'] . '' . $value['color'] . '' . $value['size'] . '<br>';
			}
			$r_tt['list_sanpham'] = $list_sanpham;
			unset($list_sanpham);
			$list .= $skin->skin_replace('skin_dropship/box_action/tr_donhang_shop', $r_tt);
		}
		return $list;
	}
	////////////////////
	function list_kq_timkiem_donhang_dropship($conn,$user_id, $key) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$i=0;
		$thongtin = mysqli_query($conn, "SELECT * FROM donhang WHERE (ma_don LIKE '%$key%' OR ho_ten LIKE '%$key%' OR email LIKE '%$key%' OR dien_thoai LIKE '%$key%') AND dropship='1' AND user_id='$user_id' ORDER BY date_post DESC");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$r_tt['tongtien'] = number_format($r_tt['tongtien']) . 'đ';
			$r_tt['date_post'] = date('d/m/Y', $r_tt['date_post']);
			if ($r_tt['status'] == 1) {
				$r_tt['status'] = 'Đã tiếp nhận đơn';
				$r_tt['huy'] = '';
			} else if ($r_tt['status'] == 2) {
				$r_tt['status'] = 'Đã giao đơn vị vận chuyển';
				$r_tt['huy'] = '';
			} else if ($r_tt['status'] == 3) {
				$r_tt['status'] = 'Yêu cầu hủy đơn';
				$r_tt['huy'] = '';
			} else if ($r_tt['status'] == 4) {
				$r_tt['status'] = 'Đã hủy đơn';
				$r_tt['huy'] = '';
			} else if ($r_tt['status'] == 5) {
				$r_tt['status'] = 'Giao thành công';
				$r_tt['huy'] = '';
			} else if ($r_tt['status'] == 6) {
				$r_tt['status'] = 'Đã hoàn đơn';
				$r_tt['huy'] = '';
			} else {
				$r_tt['huy'] = '<a href="javascript:;" onclick="confirm_action(\'huy_donhang_drop\', \'Hủy đơn hàng drop\', \'' . $r_tt['id'] . '\')" class="del">hủy</a>';
				$r_tt['status'] = 'Chờ xử lý';
			}
			$tach_sanpham = json_decode($r_tt['sanpham'], true);
			foreach ($tach_sanpham as $key => $value) {
				$s++;
				if ($value['size'] != '') {
					$value['size'] = ' - Size: ' . strtoupper($value['size']);
				}
				if ($value['color'] != '') {
					$value['color'] = ' - Màu: ' . $value['color'];
				}
				$list_sanpham .= '+' . $value['tieu_de'] . '' . $value['color'] . '' . $value['size'] . '<br>';
			}
			$r_tt['list_sanpham'] = $list_sanpham;
			unset($list_sanpham);
			$list .= $skin->skin_replace('skin_dropship/box_action/tr_donhang_drop', $r_tt);
		}
		return $list;
	}
	////////////////////
	function list_kq_timkiem_donhang_socdo($conn, $user_id, $key) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$i=0;
		$thongtin = mysqli_query($conn, "SELECT * FROM donhang_ctv WHERE user_id='$user_id' AND (ma_don LIKE '%$key%' OR ho_ten LIKE '%$key%' OR email LIKE '%$key%' OR dien_thoai LIKE '%$key%') ORDER BY date_post DESC");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$r_tt['tongtien'] = number_format($r_tt['tongtien']) . 'đ';
			$r_tt['hoahong'] = number_format($r_tt['hoahong']) . 'đ';
			$r_tt['date_post'] = date('d/m/Y', $r_tt['date_post']);
			if ($r_tt['status'] == 1) {
				$r_tt['status'] = 'Đã tiếp nhận đơn';
				$r_tt['huy'] = '';
			} else if ($r_tt['status'] == 2) {
				$r_tt['status'] = 'Đã giao đơn vị vận chuyển';
				$r_tt['huy'] = '';
			} else if ($r_tt['status'] == 3) {
				$r_tt['status'] = 'Yêu cầu hủy đơn';
				$r_tt['huy'] = '';
			} else if ($r_tt['status'] == 4) {
				$r_tt['status'] = 'Đã hủy đơn';
				$r_tt['huy'] = '';
			} else if ($r_tt['status'] == 5) {
				$r_tt['status'] = 'Giao thành công';
				$r_tt['huy'] = '';
			} else if ($r_tt['status'] == 6) {
				$r_tt['status'] = 'Đã hoàn đơn';
				$r_tt['huy'] = '';
			} else {
				$r_tt['huy'] = '<a href="javascript:;" onclick="confirm_action(\'huy_donhang_socdo\', \'Hủy đơn hàng\', \'' . $r_tt['id'] . '\')" class="del">hủy</a>';
				$r_tt['status'] = 'Chờ xử lý';
			}
			$tach_sanpham = json_decode($r_tt['sanpham'], true);
			foreach ($tach_sanpham as $key => $value) {
				$s++;
				if ($value['size'] != '') {
					$value['size'] = ' - Size: ' . strtoupper($value['size']);
				}
				if ($value['color'] != '') {
					$value['color'] = ' - Màu: ' . $value['color'];
				}
				$list_sanpham .= '+' . $value['tieu_de'] . '' . $value['color'] . '' . $value['size'] . '<br>';
			}
			$r_tt['list_sanpham'] = $list_sanpham;
			unset($list_sanpham);
			$list .= $skin->skin_replace('skin_dropship/box_action/tr_donhang_socdo', $r_tt);
		}
		return $list;
	}
//////////////////////////////////////////////////////////////////
	function list_setting($conn, $shop, $page, $limit) {
		$tlca_skin_dropship = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $start;
		$thongtin = mysqli_query($conn, "SELECT * FROM shop_setting WHERE shop='$shop' AND loai!='an' ORDER BY name DESC LIMIT $start,$limit");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$r_tt['value'] = $check->words($r_tt['value'], 200);
			$list .= $tlca_skin_dropship->skin_replace('skin_dropship/box_action/tr_setting', $r_tt);
		}
		return $list;
	}
	///////////////////////
	function phantrang($page, $total, $link) {
		if ($total <= 1) {
			return '';
		} else {
			if ($total == 2) {
				if ($page < $total) {
					return '<div class=pagination><div class="pagination-custom"><span>1</span><a href="' . $link . '?page=2">2</a><a href="' . $link . '?page=2">Next</a></div></div>';
				} else if ($page == $total) {
					return '<div class=pagination><div class="pagination-custom"><a href="' . $link . '?page=1">Prev</a><a href="' . $link . '?page=1">1</a><span>2</span></div></div>';
				} else {
					return '<div class=pagination><div class="pagination-custom"><a href="' . $link . '?page=1">1</a><a href="' . $link . '?page=2">2</a></div></div>';
				}
			} else if ($total == 3) {
				if ($page == 1) {
					return '<div class=pagination><div class="pagination-custom"><span>1</span><a href="' . $link . '?page=2">2</a><a href="' . $link . '?page=3">3</a><a href="' . $link . '?page=2">Next</a></div></div>';
				} else if ($page == 2) {
					return '<div class=pagination><div class="pagination-custom"><a href="' . $link . '?page=1">Prev</a><a href="' . $link . '?page=1">1</a><span>2</span><a href="' . $link . '?page=3">3</a><a href="' . $link . '?page=3">Next</a></div></div>';
				} else if ($page == 3) {
					return '<div class=pagination><div class="pagination-custom"><a href="' . $link . '?page=2">Prev</a><a href="' . $link . '?page=1">1</a><a href="' . $link . '?page=2">2</a><span>3</span></div></div>';
				} else {
					return '<div class=pagination><div class="pagination-custom"><a href="' . $link . '?page=1">1</a><a href="' . $link . '?page=2">2</a><a href="' . $link . '?page=3">3</a></div></div>';
				}
			} else if ($total == 4) {
				if ($page == 1) {
					return '<div class=pagination><div class="pagination-custom"><span>1</span> . . . <a href="' . $link . '?page=4">4</a><a href="' . $link . '?page=2">Next</a></div></div>';
				} else if ($page == 2) {
					return '<div class=pagination><div class="pagination-custom"><a href="' . $link . '?page=1">Prev</a><a href="' . $link . '?page=1">1</a><span>2</span> . . . <a href="' . $link . '?page=4">4</a><a href="' . $link . '?page=3">Next</a></div></div>';
				} else if ($page == 3) {
					return '<div class=pagination><div class="pagination-custom"><a href="' . $link . '?page=2">Prev</a><a href="' . $link . '?page=1">1</a> . . . <span>3</span><a href="' . $link . '?page=4">4</a><a href="' . $link . '?page=4">Next</a></div></div>';
				} else if ($page == 4) {
					return '<div class=pagination><div class="pagination-custom"><a href="' . $link . '?page=3">Prev</a><a href="' . $link . '?page=1">1</a> . . . <span>4</span></div></div>';
				} else {
					return '<div class=pagination><div class="pagination-custom"><a href="' . $link . '?page=1">1</a><a href="' . $link . '?page=2">2</a><a href="' . $link . '?page=3">3</a><a href="' . $link . '?page=4">4</a></div></div>';
				}
			} else {
				if ($page == 1) {
					return '<div class=pagination><div class="pagination-custom"><span>1</span> . . . <a href="' . $link . '?page=' . $total . '">' . $total . '</a><a href="' . $link . '?page=2">Next</a></div></div>';
				} else if ($page == 2) {
					return '<div class=pagination><div class="pagination-custom"><a href="' . $link . '?page=1">Prev</a><a href="' . $link . '?page=1">1</a><span>2</span> . . . <a href="' . $link . '?page=' . $total . '">' . $total . '</a><a href="' . $link . '?page=3">Next</a></div></div>';
				} else if ($page == 3) {
					return '<div class=pagination><div class="pagination-custom"><a href="' . $link . '?page=2">Prev</a><a href="' . $link . '?page=1">1</a> . . . <span>3</span><a href="' . $link . '?page=' . $total . '">' . $total . '</a><a href="' . $link . '?page=4">Next</a></div></div>';
				} else if ($page <= $total - 2) {
					$back = $page - 1;
					$next = $page + 1;
					return '<div class=pagination><div class="pagination-custom"><a href="' . $link . '?page=' . $back . '">Prev</a><a href="' . $link . '?page=1">1</a> . . . <span>' . $page . '</span> . . . <a href="' . $link . '?page=' . $total . '">' . $total . '</a><a href="' . $link . '?page=' . $next . '">Next</a></div></div>';
				} else if ($page < $total - 1) {
					$back = $page - 1;
					$next = $page + 1;
					return '<div class=pagination><div class="pagination-custom"><a href="' . $link . '?page=' . $back . '">Prev</a><a href="' . $link . '?page=1">1</a> . . . <span>' . $page . '</span><a href="' . $link . '?page=' . $total . '">' . $total . '</a><a href="' . $link . '?page=' . $next . '">Next</a></div></div>';
				} else if ($page == $total - 1) {
					$back = $page - 1;
					$next = $page + 1;
					return '<div class=pagination><div class="pagination-custom"><a href="' . $link . '?page=' . $back . '">Prev</a><a href="' . $link . '?page=1">1</a> . . . <span>' . $page . '</span><a href="' . $link . '?page=' . $total . '">' . $total . '</a><a href="' . $link . '?page=' . $next . '">Next</a></div></div>';
				} else if ($page == $total) {
					$back = $page - 1;
					$next = $page + 1;
					return '<div class=pagination><div class="pagination-custom"><a href="' . $link . '?page=' . $back . '">Prev</a><a href="' . $link . '?page=1">1</a> . . . <a href="' . $link . '?page=' . $back . '">' . $back . '</a><span>' . $page . '</span></div></div>';
				} else {
					$k = $total - 1;
					return '<div class=pagination><div class="pagination-custom"><a href="' . $link . '?page=1">1</a><a href="' . $link . '?page=2">2</a> . . . <a href="' . $link . '?page=' . $k . '">' . $k . '</a><a href="' . $link . '?page=' . $total . '">' . $total . '</a></div></div>';
				}
			}
		}
	}
	///////////////////////
	function phantrang_timkiem($page, $total, $link) {
		if ($total <= 1) {
			return '';
		} else {
			if ($total == 2) {
				if ($page < $total) {
					return '<div class=pagination><div class="pagination-custom"><span>1</span><a href="' . $link . '&page=2">2</a><a href="' . $link . '&page=2">Next</a></div></div>';
				} else if ($page == $total) {
					return '<div class=pagination><div class="pagination-custom"><a href="' . $link . '&page=1">Prev</a><a href="' . $link . '&page=1">1</a><span>2</span></div></div>';
				} else {
					return '<div class=pagination><div class="pagination-custom"><a href="' . $link . '&page=1">1</a><a href="' . $link . '&page=2">2</a></div></div>';
				}
			} else if ($total == 3) {
				if ($page == 1) {
					return '<div class=pagination><div class="pagination-custom"><span>1</span><a href="' . $link . '&page=2">2</a><a href="' . $link . '&page=3">3</a><a href="' . $link . '&page=2">Next</a></div></div>';
				} else if ($page == 2) {
					return '<div class=pagination><div class="pagination-custom"><a href="' . $link . '&page=1">Prev</a><a href="' . $link . '&page=1">1</a><span>2</span><a href="' . $link . '&page=3">3</a><a href="' . $link . '&page=3">Next</a></div></div>';
				} else if ($page == 3) {
					return '<div class=pagination><div class="pagination-custom"><a href="' . $link . '&page=2">Prev</a><a href="' . $link . '&page=1">1</a><a href="' . $link . '&page=2">2</a><span>3</span></div></div>';
				} else {
					return '<div class=pagination><div class="pagination-custom"><a href="' . $link . '&page=1">1</a><a href="' . $link . '&page=2">2</a><a href="' . $link . '&page=3">3</a></div></div>';
				}
			} else if ($total == 4) {
				if ($page == 1) {
					return '<div class=pagination><div class="pagination-custom"><span>1</span> . . . <a href="' . $link . '&page=4">4</a><a href="' . $link . '&page=2">Next</a></div></div>';
				} else if ($page == 2) {
					return '<div class=pagination><div class="pagination-custom"><a href="' . $link . '&page=1">Prev</a><a href="' . $link . '&page=1">1</a><span>2</span> . . . <a href="' . $link . '&page=4">4</a><a href="' . $link . '&page=3">Next</a></div></div>';
				} else if ($page == 3) {
					return '<div class=pagination><div class="pagination-custom"><a href="' . $link . '&page=2">Prev</a><a href="' . $link . '&page=1">1</a> . . . <span>3</span><a href="' . $link . '&page=4">4</a><a href="' . $link . '&page=4">Next</a></div></div>';
				} else if ($page == 4) {
					return '<div class=pagination><div class="pagination-custom"><a href="' . $link . '&page=3">Prev</a><a href="' . $link . '&page=1">1</a> . . . <span>4</span></div></div>';
				} else {
					return '<div class=pagination><div class="pagination-custom"><a href="' . $link . '&page=1">1</a><a href="' . $link . '&page=2">2</a><a href="' . $link . '&page=3">3</a><a href="' . $link . '&page=4">4</a></div></div>';
				}
			} else {
				if ($page == 1) {
					return '<div class=pagination><div class="pagination-custom"><span>1</span> . . . <a href="' . $link . '&page=' . $total . '">' . $total . '</a><a href="' . $link . '&page=2">Next</a></div></div>';
				} else if ($page == 2) {
					return '<div class=pagination><div class="pagination-custom"><a href="' . $link . '&page=1">Prev</a><a href="' . $link . '&page=1">1</a><span>2</span> . . . <a href="' . $link . '&page=' . $total . '">' . $total . '</a><a href="' . $link . '&page=3">Next</a></div></div>';
				} else if ($page == 3) {
					return '<div class=pagination><div class="pagination-custom"><a href="' . $link . '&page=2">Prev</a><a href="' . $link . '&page=1">1</a> . . . <span>3</span><a href="' . $link . '&page=' . $total . '">' . $total . '</a><a href="' . $link . '&page=4">Next</a></div></div>';
				} else if ($page <= $total - 2) {
					$back = $page - 1;
					$next = $page + 1;
					return '<div class=pagination><div class="pagination-custom"><a href="' . $link . '&page=' . $back . '">Prev</a><a href="' . $link . '&page=1">1</a> . . . <span>' . $page . '</span> . . . <a href="' . $link . '&page=' . $total . '">' . $total . '</a><a href="' . $link . '&page=' . $next . '">Next</a></div></div>';
				} else if ($page < $total - 1) {
					$back = $page - 1;
					$next = $page + 1;
					return '<div class=pagination><div class="pagination-custom"><a href="' . $link . '&page=' . $back . '">Prev</a><a href="' . $link . '&page=1">1</a> . . . <span>' . $page . '</span><a href="' . $link . '&page=' . $total . '">' . $total . '</a><a href="' . $link . '&page=' . $next . '">Next</a></div></div>';
				} else if ($page == $total - 1) {
					$back = $page - 1;
					$next = $page + 1;
					return '<div class=pagination><div class="pagination-custom"><a href="' . $link . '&page=' . $back . '">Prev</a><a href="' . $link . '&page=1">1</a> . . . <span>' . $page . '</span><a href="' . $link . '&page=' . $total . '">' . $total . '</a><a href="' . $link . '&page=' . $next . '">Next</a></div></div>';
				} else if ($page == $total) {
					$back = $page - 1;
					$next = $page + 1;
					return '<div class=pagination><div class="pagination-custom"><a href="' . $link . '&page=' . $back . '">Prev</a><a href="' . $link . '&page=1">1</a> . . . <a href="' . $link . '&page=' . $back . '">' . $back . '</a><span>' . $page . '</span></div></div>';
				} else {
					$k = $total - 1;
					return '<div class=pagination><div class="pagination-custom"><a href="' . $link . '&page=1">1</a><a href="' . $link . '&page=2">2</a> . . . <a href="' . $link . '&page=' . $k . '">' . $k . '</a><a href="' . $link . '&page=' . $total . '">' . $total . '</a></div></div>';
				}
			}
		}
	}
//////////////////////////////////////////////////////////////////
	function thanhvien_info($conn, $id) {
		$thongtin = mysqli_query($conn, "SELECT * FROM user_info WHERE user_id='$id'");
		$total = mysqli_num_rows($thongtin);
		if ($total == "0") {
			$r_tt = '';
		} else {
			$r_tt = mysqli_fetch_assoc($thongtin);
		}
		return $r_tt;
	}
//////////////////////////////////////////////////////////////////
	function my_info($conn) {
		$thongtin = mysqli_query($conn, "SELECT * FROM e_min WHERE username='{$_SESSION['e_name']}'");
		$r_tt = mysqli_fetch_assoc($thongtin);
		return $r_tt;
	}
//////////////////////////////////////////////////////////////////
}
?>
