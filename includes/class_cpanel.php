 <?php
class class_cpanel extends class_manage {
	///////////////////
	function list_menu($conn, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $start;
		$thongtin = mysqli_query($conn, "SELECT * FROM menu ORDER BY menu_vitri ASC, menu_thutu ASC LIMIT $start,$limit");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$r_tt['blank'] = $check->blank($r_tt['post_tieude']);
			$i++;
			$r_tt['i'] = $i;
			if ($r_tt['menu_vitri'] == 'left') {
				$r_tt['menu_vitri'] = 'Menu Trái';
			} else if ($r_tt['menu_vitri'] == 'huongdan') {
				$r_tt['menu_vitri'] = 'Menu hướng dẫn';
			} else if ($r_tt['menu_vitri'] == 'chinhsach') {
				$r_tt['menu_vitri'] = 'Menu chính sách';
			}
			$list .= $skin->skin_replace('skin_cpanel/box_action/tr_menu', $r_tt);
		}
		return $list;
	}
	function list_otp($conn,$total, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $start;
		$thongtin = mysqli_query($conn, "SELECT * FROM code_otp ORDER BY id DESC LIMIT $start,$limit");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$r_tt['blank'] = $check->blank($r_tt['post_tieude']);
			$i++;
			$r_tt['date_post'] = date('H:i:s d/m/Y', $r_tt['date_post']);
			$r_tt['i'] = $i;
			$list .= $skin->skin_replace('skin_cpanel/box_action/tr_otp', $r_tt);
		}
		return $list;
	}
	function list_phanloai($conn,$sp_id) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $start;
		$thongtin = mysqli_query($conn, "SELECT * FROM phanloai_sanpham WHERE sp_id='$sp_id' ORDER BY id ASC");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$r_tt['gia_cu']=number_format($r_tt['gia_cu']);
			$r_tt['gia_moi']=number_format($r_tt['gia_moi']);
			$r_tt['gia_drop']=number_format($r_tt['gia_drop']);
			$r_tt['gia_ctv']=number_format($r_tt['gia_ctv']);
			$r_tt['drop_min']=number_format($r_tt['drop_min']);
			$r_tt['can_nang']=intval($r_tt['can_nang']);
			$list .= $skin->skin_replace('skin_cpanel/box_action/li_phanloai', $r_tt);
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
        }
    }
	////////////////////
	function list_yeucau($conn,$user_id,$bo_phan,$thanh_vien){
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		if($bo_phan=='all'){
			$thongtin=mysqli_query($conn,"SELECT chat.*,user_info.name AS ho_ten,user_info.mobile FROM chat INNER JOIN user_info ON chat.thanh_vien=user_info.user_id WHERE (chat.user_in='$user_id' OR chat.user_out='$user_id' OR chat.user_in='0') AND chat.active='1' GROUP BY chat.thanh_vien ORDER BY chat.id DESC");
		}else{
			$thongtin=mysqli_query($conn,"SELECT chat.*,user_info.name AS ho_ten,user_info.mobile FROM chat INNER JOIN user_info ON chat.thanh_vien=user_info.user_id WHERE (chat.user_in='$user_id' OR chat.user_out='$user_id' OR chat.user_in='0') AND chat.active='1' AND chat.bo_phan='$bo_phan' GROUP BY chat.thanh_vien ORDER BY chat.id DESC");
		}
		
		$i=0;
		$total=mysqli_num_rows($thongtin);
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['date_post']=$check->date_update($r_tt['date_post']);
			if($thanh_vien==$r_tt['thanh_vien']){
				$r_tt['active']='active';
			}else{
				$r_tt['active']='';
			}
			$list .= $skin->skin_replace('skin_cpanel/box_action/li_yeucau', $r_tt);
		}
		return $list;
	}
	///////////////////
	function list_hoahong($conn, $thanhvien,$total, $page,$limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $total - $start + 1;
		$thongtin = mysqli_query($conn, "SELECT hoahong_nhom.*,user_info.username FROM hoahong_nhom LEFT JOIN user_info ON hoahong_nhom.user_id=user_info.user_id WHERE hoahong_nhom.nhom='$thanhvien' ORDER BY hoahong_nhom.id DESC LIMIT $start,$limit");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i--;
			$r_tt['i'] = $i;
			$r_tt['total']=number_format($r_tt['total']);
			$r_tt['hoa_hong']=number_format($r_tt['hoa_hong']);
			$r_tt['date_post'] = date('H:i:s d/m/Y', $r_tt['date_post']);
			if($r_tt['status']==1){
				$r_tt['status']='Đã thanh toán';
				$r_tt['update_post'] = date('H:i:s d/m/Y', $r_tt['update_post']);
				$r_tt['button_thanhtoan']='';
			}else{
				$r_tt['status']='Chưa thanh toán';
				$r_tt['update_post'] = '';
				$r_tt['button_thanhtoan']='<a href="javascript:;" class="edit in_line capnhat_hh" hh="'.$r_tt['id'].'">Thanh toán</a>';
			}
			if($r_tt['loai_don']=='ctv'){
				$thongtin_donhang=mysqli_query($conn,"SELECT * FROM donhang_ctv WHERE ma_don='{$r_tt['ma_don']}'");
			}else{
				$thongtin_donhang=mysqli_query($conn,"SELECT * FROM donhang WHERE ma_don='{$r_tt['ma_don']}'");
			}
			$r_dh=mysqli_fetch_assoc($thongtin_donhang);
			$r_tt['ngay_don']=date('d/m/Y',$r_dh['date_post']);
			$list .= $skin->skin_replace('skin_cpanel/box_action/tr_hoahong', $r_tt);
		}
		return $list;
	}
	////////////////////
	function list_chat($conn,$user_id,$name,$avatar,$thanhvien_name,$thanhvien_avatar,$user_end, $phien,$sms_id,$limit){
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
				if($r_tt['user_out']-=$r_tt['thanh_vien']){
					mysqli_query($conn,"UPDATE chat SET doc='1' WHERE id='{$r_tt['id']}'");
				}
			}
			krsort($list_x);
			foreach ($list_x as $key => $value) {
				if($value['user_out']==$user_id){
					$value['name']=$name;
					$value['avatar']=$avatar;
				}else if($value['user_out']==$value['thanh_vien']){
					$value['name']=$thanhvien_name;
					$value['avatar']=$thanhvien_avatar;
				}
				$value['noi_dung']=$check->smile($value['noi_dung']);
				if($value['user_out']==$_SESSION['user_end']){
					if($value['thanh_vien']==$_SESSION['user_end']){
						$list.=$skin->skin_replace('skin_cpanel/box_action/li_chat_left', $value);
					}else{
						$list.=$skin->skin_replace('skin_cpanel/box_action/li_chat_right', $value);
					}
				}else{
					if($value['user_out']==$value['thanh_vien']){
						$list.=$skin->skin_replace('skin_cpanel/box_action/li_chat_left_avatar', $value);
					}else{
						$list.=$skin->skin_replace('skin_cpanel/box_action/li_chat_right_avatar', $value);
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
	////////////////////
	function list_naptien_member($conn, $user_id, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $start;
		$thongtin = mysqli_query($conn, "SELECT naptien.*,user_info.username,user_info.mobile FROM naptien LEFT JOIN user_info ON user_info.user_id=naptien.user_id WHERE naptien.user_id='$user_id' ORDER BY naptien.id DESC LIMIT $start,$limit");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$r_tt['date_post'] = date('H:i:s d/m/Y', $r_tt['date_post']);
			$r_tt['sotien'] = number_format($r_tt['sotien']);
			if ($r_tt['status'] == 1) {
				$r_tt['status'] = 'Hoàn thành';
				$r_tt['hanhdong'] = '';
			} else if ($r_tt['status'] == 2) {
				$r_tt['status'] = 'Đã hủy';
				$r_tt['hanhdong'] = '';
			} else {
				$r_tt['status'] = 'Chờ xử lý';
				$r_tt['hanhdong'] = '<a href="/admincp/edit-naptien?id=' . $r_tt['id'] . '" class="edit">Sửa</a>';
			}
			$r_tt['noidung'] = 'naptien ' . $r_tt['username'] . ' ' . $r_tt['id'];
			$list .= $skin->skin_replace('skin_cpanel/box_action/tr_naptien', $r_tt);
		}
		return $list;
	}
	////////////////////
	function list_chitieu_member($conn, $user_id, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $start;
		$thongtin = mysqli_query($conn, "SELECT lichsu_chitieu.*,user_info.username,user_info.mobile FROM lichsu_chitieu LEFT JOIN user_info ON user_info.user_id=lichsu_chitieu.user_id WHERE lichsu_chitieu.user_id='$user_id' ORDER BY lichsu_chitieu.id DESC LIMIT $start,$limit");
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
			if ($r_tt['truoc'] == 0 AND $r_tt['sau'] == 0) {
				$r_tt['truoc'] = 'Không xác định';
				$r_tt['sau'] = 'Không xác định';
			} else {
				$r_tt['truoc'] = number_format($r_tt['truoc']);
				$r_tt['sau'] = number_format($r_tt['sau']);
			}
			$list .= $skin->skin_replace('skin_cpanel/box_action/tr_chitieu', $r_tt);
		}
		return $list;
	}
	////////////////////
	function list_bom($conn, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $start;
		$thongtin = mysqli_query($conn, "SELECT bom_hang.*,user_info.username FROM bom_hang LEFT JOIN user_info ON bom_hang.user_id=user_info.user_id ORDER BY bom_hang.id DESC LIMIT $start,$limit");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$r_tt['date_post'] = date('H:i:s d/m/Y', $r_tt['date_post']);
			$list .= $skin->skin_replace('skin_cpanel/box_action/tr_bom', $r_tt);
		}
		return $list;
	}
	///////////////////
	function list_tichdiem($conn, $shop, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$thongtin = mysqli_query($conn, "SELECT * FROM tich_diem LEFT JOIN user_info ON user_info.user_id=tich_diem.user_id WHERE tich_diem.shop='$shop' ORDER BY tich_diem.id DESC LIMIT $start,$limit");
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
	function list_notification($conn,$user_id, $bo_phan,$loai,$page,$limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		if($bo_phan=='all'){
			if($loai=='all'){
				$thongtin = mysqli_query($conn, "SELECT * FROM notification WHERE admin='1' ORDER BY id DESC LIMIT $start,$limit");
			}else{
				$thongtin = mysqli_query($conn, "SELECT * FROM notification WHERE admin='1' AND FIND_IN_SET('$user_id', doc) < 1 ORDER BY id DESC LIMIT $start,$limit");
			}
		}else{
			if($loai=='all'){
				$thongtin = mysqli_query($conn, "SELECT * FROM notification WHERE admin='1' AND bo_phan='$bo_phan' ORDER BY id DESC LIMIT $start,$limit");
			}else{
				$thongtin = mysqli_query($conn, "SELECT * FROM notification WHERE admin='1' AND bo_phan='$bo_phan' AND FIND_IN_SET('$user_id', doc) < 1 ORDER BY id DESC LIMIT $start,$limit");
			}
		}
		$i = $start;
		$total=0;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$total++;
			$i++;
			$r_tt['i'] = $i;
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
			$r_tt['date_post'] = $check->chat_update($r_tt['date_post']);
			$list .= $skin->skin_replace('skin_cpanel/box_action/li_notification', $r_tt);
		}
		$info=array(
			'total'=>$total,
			'list'=>$list
		);
		return json_encode($info);
	}
	////////////////////
	function list_ruttien_member($conn, $user_id, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $start;
		$thongtin = mysqli_query($conn, "SELECT rut_tien.*,user_info.username FROM rut_tien LEFT JOIN user_info ON user_info.user_id=rut_tien.user_id WHERE rut_tien.user_id='$user_id' ORDER BY id DESC LIMIT $start,$limit");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$r_tt['date_post'] = date('H:i:s d/m/Y', $r_tt['date_post']);
			$r_tt['sotien'] = number_format($r_tt['so_tien']);
			if ($r_tt['status'] == 1) {
				$r_tt['status'] = 'Hoàn thành';
				$r_tt['hanhdong'] = '';
			} else if ($r_tt['status'] == 2) {
				$r_tt['status'] = 'Đã hủy';
				$r_tt['hanhdong'] = '';
			} else {
				$r_tt['status'] = 'Chờ xử lý';
				$r_tt['hanhdong'] = '<a href="/admincp/edit-ruttien?id=' . $r_tt['id'] . '" class="edit">Sửa</a>';
			}
			$r_tt['noidung'] = 'naptien ' . $r_tt['username'] . ' ' . $r_tt['id'];
			$list .= $skin->skin_replace('skin_cpanel/box_action/tr_ruttien', $r_tt);
		}
		return $list;
	}
	////////////////////
	function list_thanhvien_nhom_chuyennghiep($conn, $user_id, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $start;
		$thongtin = mysqli_query($conn, "SELECT * FROM user_info WHERE aff='$user_id' ORDER BY user_id DESC LIMIT $start,$limit");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$r_tt['created'] = date('H:i:s d/m/Y', $r_tt['created']);
			$r_tt['user_money']=number_format($r_tt['user_money']);
			if($r_tt['leader']==1){
				$r_tt['leader']='Nhà bán chuyên nghiệp';
			}else{
				$r_tt['leader']='Nhà bán';
			}
			$list .= $skin->skin_replace('skin_cpanel/box_action/tr_thanhvien_nhom_chuyennghiep', $r_tt);
		}
		return $list;
	}
	////////////////////
	function list_dangky_hotro($conn, $total, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $total - $start + 1;
		$thongtin = mysqli_query($conn, "SELECT * FROM pop_hotro LEFT JOIN user_info ON pop_hotro.user_id=user_info.user_id ORDER BY pop_hotro.id DESC LIMIT $start,$limit");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i--;
			$r_tt['i'] = $i;
			$r_tt['date_post'] = date('H:i:s d/m/Y', $r_tt['date_post']);
			if($r_tt['thoi_gian']==''){
				$r_tt['thoi_gian']='Không nhận hỗ trợ';
			}
			$list .= $skin->skin_replace('skin_cpanel/box_action/tr_dangky_hotro', $r_tt);
		}
		return $list;
	}
	////////////////////
	function list_nhiemvu($conn, $total, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $total - $start + 1;
		$thongtin = mysqli_query($conn, "SELECT * FROM nhiem_vu ORDER BY id DESC LIMIT $start,$limit");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i--;
			$r_tt['i'] = $i;
			$list .= $skin->skin_replace('skin_cpanel/box_action/tr_nhiemvu', $r_tt);
		}
		return $list;
	}
	////////////////////
	function list_baohanh($conn, $total, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $total - $start + 1;
		$thongtin = mysqli_query($conn, "SELECT * FROM kichhoat_baohanh ORDER BY id DESC LIMIT $start,$limit");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i--;
			$r_tt['i'] = $i;
			$r_tt['date_post'] = date('H:i:s d/m/Y', $r_tt['date_post']);
			$r_tt['expired'] = date('H:i:s d/m/Y', $r_tt['expired']);
			$r_tt['note']=str_replace("\n", "<br>", $r_tt['note']);
			if($r_tt['status']==1){
				$r_tt['status']='Đã sử dụng';
			}else{
				$r_tt['status']='Chưa sử dụng';
			}
			$list .= $skin->skin_replace('skin_cpanel/box_action/tr_baohanh', $r_tt);
		}
		return $list;
	}
	////////////////////
	function list_naptien($conn, $total, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $total - $start + 1;
		$thongtin = mysqli_query($conn, "SELECT naptien.*,user_info.username,user_info.mobile FROM naptien LEFT JOIN user_info ON user_info.user_id=naptien.user_id ORDER BY id DESC LIMIT $start,$limit");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i--;
			$r_tt['i'] = $i;
			$r_tt['date_post'] = date('H:i:s d/m/Y', $r_tt['date_post']);
			$r_tt['sotien'] = number_format($r_tt['sotien']);
			if ($r_tt['status'] == 1) {
				$r_tt['status'] = 'Hoàn thành';
				$r_tt['hanhdong'] = '';
			} else if ($r_tt['status'] == 2) {
				$r_tt['status'] = 'Đã hủy';
				$r_tt['hanhdong'] = '';
			} else if ($r_tt['status'] == 3) {
				$r_tt['status'] = 'Chờ xác nhận';
				$r_tt['hanhdong'] = '<a href="/admincp/edit-naptien?id=' . $r_tt['id'] . '" class="edit">Sửa</a>';
			} else {
				$r_tt['status'] = 'Chờ xử lý';
				$r_tt['hanhdong'] = '<a href="/admincp/edit-naptien?id=' . $r_tt['id'] . '" class="edit">Sửa</a>';
			}
			$r_tt['noidung'] = 'naptien ' . $r_tt['username'] . ' ' . $r_tt['id'];
			$list .= $skin->skin_replace('skin_cpanel/box_action/tr_naptien', $r_tt);
		}
		return $list;
	}
	////////////////////
	function list_chitieu($conn, $total, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $total - $start + 1;
		$thongtin = mysqli_query($conn, "SELECT lichsu_chitieu.*,user_info.username,user_info.mobile FROM lichsu_chitieu LEFT JOIN user_info ON user_info.user_id=lichsu_chitieu.user_id ORDER BY id DESC LIMIT $start,$limit");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i--;
			$r_tt['i'] = $i;
			$r_tt['date_post'] = date('H:i:s d/m/Y', $r_tt['date_post']);
			//$r_tt['sotien']=number_format($r_tt['sotien']);
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
			if ($r_tt['truoc'] == 0 AND $r_tt['sau'] == 0) {
				$r_tt['truoc'] = '';
				$r_tt['sau'] = '';
			} else {
				$r_tt['truoc'] = number_format($r_tt['truoc']);
				$r_tt['sau'] = number_format($r_tt['sau']);
			}
			$list .= $skin->skin_replace('skin_cpanel/box_action/tr_chitieu', $r_tt);
		}
		return $list;
	}
	////////////////////
	function list_ruttien($conn, $total, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $total - $start + 1;
		$thongtin = mysqli_query($conn, "SELECT rut_tien.*,user_info.username FROM rut_tien LEFT JOIN user_info ON user_info.user_id=rut_tien.user_id ORDER BY id DESC LIMIT $start,$limit");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i--;
			$r_tt['i'] = $i;
			$r_tt['date_post'] = date('H:i:s d/m/Y', $r_tt['date_post']);
			$r_tt['sotien'] = number_format($r_tt['so_tien']);
			if ($r_tt['status'] == 1) {
				$r_tt['status'] = 'Hoàn thành';
				$r_tt['hanhdong'] = '';
			} else if ($r_tt['status'] == 2) {
				$r_tt['status'] = 'Đã hủy';
				$r_tt['hanhdong'] = '';
			} else {
				$r_tt['status'] = 'Chờ xử lý';
				$r_tt['hanhdong'] = '<a href="/admincp/edit-ruttien?id=' . $r_tt['id'] . '" class="edit">Sửa</a>';
			}
			$r_tt['noidung'] = 'naptien ' . $r_tt['username'] . ' ' . $r_tt['id'];
			$list .= $skin->skin_replace('skin_cpanel/box_action/tr_ruttien', $r_tt);
		}
		return $list;
	}
	////////////////////
	function list_donhang_socdo($conn, $total, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $total - $start + 1;
		$thongtin = mysqli_query($conn, "SELECT * FROM donhang WHERE dropship='0' ORDER BY date_post DESC LIMIT $start,$limit");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i--;
			$r_tt['i'] = $i;
			$r_tt['tongtien'] = number_format($r_tt['tongtien']) . 'đ';
			$r_tt['date_post'] = date('d/m/Y', $r_tt['date_post']);
			if($r_tt['status']==0){
				$r_tt['color']='color:red;';
			}else{
				$r_tt['color']='';
			}
			if ($r_tt['status'] == 1) {
				$r_tt['status'] = 'Đã tiếp nhận đơn';
			} else if ($r_tt['status'] == 2) {
				$r_tt['status'] = 'Đã giao đơn vị vận chuyển';
			} else if ($r_tt['status'] == 3) {
				$r_tt['status'] = 'Yêu cầu hủy đơn';
			} else if ($r_tt['status'] == 4) {
				$r_tt['status'] = 'Xác nhận hủy đơn';
			} else if ($r_tt['status'] == 5) {
				$r_tt['status'] = 'Giao thành công';
			} else if ($r_tt['status'] == 6) {
				$r_tt['status'] = 'Đã hoàn đơn';
			} else {
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
			$list .= $skin->skin_replace('skin_cpanel/box_action/tr_donhang_socdo', $r_tt);
		}
		return $list;
	}
	////////////////////
	function list_hoandon_drop_member($conn, $user_id, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $start;
		$thongtin = mysqli_query($conn, "SELECT donhang.*,user_info.name,user_info.mobile FROM donhang LEFT JOIN user_info ON donhang.user_id=user_info.user_id WHERE donhang.dropship='1' AND donhang.user_id='$user_id' AND donhang.status='6' ORDER BY donhang.date_post DESC LIMIT $start,$limit");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$r_tt['tongtien'] = number_format($r_tt['tongtien']) . 'đ';
			$r_tt['date_post'] = date('d/m/Y', $r_tt['date_post']);
			if ($r_tt['status'] == 1) {
				$r_tt['status'] = 'Đã tiếp nhận đơn';
			} else if ($r_tt['status'] == 2) {
				$r_tt['status'] = 'Đã giao đơn vị vận chuyển';
			} else if ($r_tt['status'] == 3) {
				$r_tt['status'] = 'Yêu cầu hủy đơn Drop';
			} else if ($r_tt['status'] == 4) {
				$r_tt['status'] = 'Xác nhận hủy đơn';
			} else if ($r_tt['status'] == 5) {
				$r_tt['status'] = 'Giao thành công';
			} else if ($r_tt['status'] == 6) {
				$r_tt['status'] = 'Đã hoàn đơn';
			} else {
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
			$list .= $skin->skin_replace('skin_cpanel/box_action/tr_donhang', $r_tt);
		}
		return $list;
	}
	////////////////////
	function list_donhang_drop_member($conn, $user_id, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $start;
		$thongtin = mysqli_query($conn, "SELECT donhang.*,user_info.name,user_info.mobile FROM donhang LEFT JOIN user_info ON donhang.user_id=user_info.user_id WHERE donhang.dropship='1' AND donhang.user_id='$user_id' ORDER BY donhang.date_post DESC LIMIT $start,$limit");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$r_tt['tongtien'] = number_format($r_tt['tongtien']) . 'đ';
			$r_tt['date_post'] = date('d/m/Y', $r_tt['date_post']);
			if($r_tt['status']==0){
				$r_tt['color']='color:red;';
			}else{
				$r_tt['color']='';
			}
			if ($r_tt['status'] == 1) {
				$r_tt['status'] = 'Đã tiếp nhận đơn';
			} else if ($r_tt['status'] == 2) {
				$r_tt['status'] = 'Đã giao đơn vị vận chuyển';
			} else if ($r_tt['status'] == 3) {
				$r_tt['status'] = 'Yêu cầu hủy đơn Drop';
			} else if ($r_tt['status'] == 4) {
				$r_tt['status'] = 'Xác nhận hủy đơn';
			} else if ($r_tt['status'] == 5) {
				$r_tt['status'] = 'Giao thành công';
			} else if ($r_tt['status'] == 6) {
				$r_tt['status'] = 'Đã hoàn đơn';
			} else {
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
			$list .= $skin->skin_replace('skin_cpanel/box_action/tr_donhang', $r_tt);
		}
		return $list;
	}
	////////////////////
	function list_donhang_nhom_chuyennghiep($conn, $user_id, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $start;
		$list_id='';
		$thongtin_thanhvien=mysqli_query($conn,"SELECT * FROM user_info WHERE aff='$user_id'");
		while($r_tv=mysqli_fetch_assoc($thongtin_thanhvien)){
			$list_id.=$r_tv['user_id'].',';
		}
		if($list_id==''){
			return "";
		}else{
			$list_id=substr($list_id, 0,-1);
			$thongtin = mysqli_query($conn, "SELECT donhang.*,user_info.name,user_info.mobile FROM donhang LEFT JOIN user_info ON donhang.user_id=user_info.user_id WHERE donhang.dropship='1' AND donhang.user_id IN ($list_id) ORDER BY donhang.date_post DESC LIMIT $start,$limit");
			while ($r_tt = mysqli_fetch_assoc($thongtin)) {
				$i++;
				$r_tt['i'] = $i;
				$r_tt['tongtien'] = number_format($r_tt['tongtien']) . 'đ';
				$r_tt['date_post'] = date('d/m/Y', $r_tt['date_post']);
				if($r_tt['status']==0){
					$r_tt['color']='color:red;';
				}else{
					$r_tt['color']='';
				}
				if ($r_tt['status'] == 1) {
					$r_tt['status'] = 'Đã tiếp nhận đơn';
				} else if ($r_tt['status'] == 2) {
					$r_tt['status'] = 'Đã giao đơn vị vận chuyển';
				} else if ($r_tt['status'] == 3) {
					$r_tt['status'] = 'Yêu cầu hủy đơn Drop';
				} else if ($r_tt['status'] == 4) {
					$r_tt['status'] = 'Xác nhận hủy đơn';
				} else if ($r_tt['status'] == 5) {
					$r_tt['status'] = 'Giao thành công';
				} else if ($r_tt['status'] == 6) {
					$r_tt['status'] = 'Đã hoàn đơn';
				} else {
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
				$list .= $skin->skin_replace('skin_cpanel/box_action/tr_donhang_nhom_chuyennghiep', $r_tt);
			}
			return $list;
		}
	}
	////////////////////
	function list_donhang_nhom_socdo_chuyennghiep($conn, $user_id, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $start;
		$list_id='';
		$thongtin_thanhvien=mysqli_query($conn,"SELECT * FROM user_info WHERE aff='$user_id'");
		while($r_tv=mysqli_fetch_assoc($thongtin_thanhvien)){
			$list_id.=$r_tv['user_id'].',';
		}
		if($list_id==''){
			return "";
		}else{
			$list_id=substr($list_id, 0,-1);
			$thongtin = mysqli_query($conn, "SELECT donhang_ctv.*,user_info.name,user_info.mobile FROM donhang_ctv LEFT JOIN user_info ON donhang_ctv.user_id=user_info.user_id WHERE donhang_ctv.user_id IN ($list_id) ORDER BY donhang_ctv.date_post DESC LIMIT $start,$limit");
			while ($r_tt = mysqli_fetch_assoc($thongtin)) {
				$i++;
				$r_tt['i'] = $i;
				$r_tt['tongtien'] = number_format($r_tt['tongtien']) . 'đ';
				$r_tt['date_post'] = date('d/m/Y', $r_tt['date_post']);
				if($r_tt['status']==0){
					$r_tt['color']='color:red;';
				}else{
					$r_tt['color']='';
				}
				if ($r_tt['status'] == 1) {
					$r_tt['status'] = 'Đã tiếp nhận đơn';
				} else if ($r_tt['status'] == 2) {
					$r_tt['status'] = 'Đã giao đơn vị vận chuyển';
				} else if ($r_tt['status'] == 3) {
					$r_tt['status'] = 'Yêu cầu hủy đơn Drop';
				} else if ($r_tt['status'] == 4) {
					$r_tt['status'] = 'Xác nhận hủy đơn';
				} else if ($r_tt['status'] == 5) {
					$r_tt['status'] = 'Giao thành công';
				} else if ($r_tt['status'] == 6) {
					$r_tt['status'] = 'Đã hoàn đơn';
				} else {
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
				$list .= $skin->skin_replace('skin_cpanel/box_action/tr_donhang_nhom_chuyennghiep', $r_tt);
			}
			return $list;
		}
	}
	////////////////////
	function list_donhang($conn, $total, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $total - $start + 1;
		$thongtin = mysqli_query($conn, "SELECT donhang.*,user_info.name,user_info.mobile FROM donhang LEFT JOIN user_info ON donhang.user_id=user_info.user_id WHERE donhang.dropship='1' ORDER BY donhang.date_post DESC LIMIT $start,$limit");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i--;
			$r_tt['i'] = $i;
			$r_tt['tongtien'] = number_format($r_tt['tongtien']) . 'đ';
			$r_tt['date_post'] = date('d/m/Y', $r_tt['date_post']);
			if($r_tt['status']==0){
				$r_tt['color']='color:red;';
			}else{
				$r_tt['color']='';
			}
			if ($r_tt['status'] == 1) {
				$r_tt['status'] = 'Đã tiếp nhận đơn';
			} else if ($r_tt['status'] == 2) {
				$r_tt['status'] = 'Đã giao đơn vị vận chuyển';
			} else if ($r_tt['status'] == 3) {
				$r_tt['status'] = 'Yêu cầu hủy đơn Drop';
			} else if ($r_tt['status'] == 4) {
				$r_tt['status'] = 'Xác nhận hủy đơn';
			} else if ($r_tt['status'] == 5) {
				$r_tt['status'] = 'Giao thành công';
			} else if ($r_tt['status'] == 6) {
				$r_tt['status'] = 'Đã hoàn đơn';
			} else {
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
			$list .= $skin->skin_replace('skin_cpanel/box_action/tr_donhang', $r_tt);
		}
		return $list;
	}
	////////////////////
	function list_donhang_ctv($conn, $total, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $total - $start + 1;
		//$thongtin=mysqli_query($conn,"SELECT * FROM donhang_ctv ORDER BY date_post DESC LIMIT $start,$limit");
		$thongtin = mysqli_query($conn, "SELECT donhang_ctv.*,user_info.name,user_info.mobile FROM donhang_ctv LEFT JOIN user_info ON donhang_ctv.user_id=user_info.user_id ORDER BY donhang_ctv.date_post DESC LIMIT $start,$limit");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i--;
			$r_tt['i'] = $i;
			$r_tt['tongtien'] = number_format($r_tt['tongtien']) . 'đ';
			$r_tt['date_post'] = date('d/m/Y', $r_tt['date_post']);
			$r_tt['date_update'] = date('H:i:s d/m/Y', $r_tt['date_update']);
			if($r_tt['status']==0){
				$r_tt['color']='color:red;';
			}else{
				$r_tt['color']='';
			}
			if ($r_tt['status'] == 1) {
				$r_tt['status'] = 'Đã tiếp nhận đơn';
			} else if ($r_tt['status'] == 2) {
				$r_tt['status'] = 'Đã giao đơn vị vận chuyển';
			} else if ($r_tt['status'] == 3) {
				$r_tt['status'] = 'Yêu cầu hủy đơn';
			} else if ($r_tt['status'] == 4) {
				$r_tt['status'] = 'Xác nhận hủy đơn';
			} else if ($r_tt['status'] == 5) {
				$r_tt['status'] = 'Giao thành công';
			} else if ($r_tt['status'] == 6) {
				$r_tt['status'] = 'Đã hoàn đơn';
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
			$list .= $skin->skin_replace('skin_cpanel/box_action/tr_donhang_ctv', $r_tt);
		}
		return $list;
	}
	////////////////////
	function list_category_video($conn, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $start;
		$thongtin = mysqli_query($conn, "SELECT * FROM category_video ORDER BY thu_tu ASC LIMIT $start,$limit");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$list .= $skin->skin_replace('skin_cpanel/box_action/tr_category_video', $r_tt);
		}
		return $list;
	}
	////////////////////
	function list_quantri($conn, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $start;
		$thongtin = mysqli_query($conn, "SELECT * FROM emin_info ORDER BY id DESC LIMIT $start,$limit");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$r_tt['blank'] = $check->blank($r_tt['post_tieude']);
			$i++;
			$r_tt['i'] = $i;
			$list .= $skin->skin_replace('skin_cpanel/box_action/tr_quantri', $r_tt);
		}
		return $list;
	}
	////////////////////
	function list_nhom($conn, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $start;
		$thongtin = mysqli_query($conn, "SELECT * FROM nhom ORDER BY id DESC LIMIT $start,$limit");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$r_tt['date_post'] = date('H:i:s d/m/Y', $r_tt['date_post']);
			if ($r_tt['thanhvien'] != '') {
				$r_tt['total_member'] = count(explode(',', $r_tt['thanhvien']));
			} else {
				$r_tt['total_member'] = '0';
			}
			$list .= $skin->skin_replace('skin_cpanel/box_action/tr_nhom', $r_tt);
		}
		return $list;
	}
	////////////////////
	function list_thanhvien_nhom($conn, $nhom, $list_id, $list_nhomtruong, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $start;
		$tach_nhomtruong = explode(',', $list_nhomtruong);
		$thongtin = mysqli_query($conn, "SELECT *,(SELECT count(*) FROM donhang d WHERE d.user_id=u.user_id AND d.status!='3' AND d.status!='4') AS total_donhang,(SELECT sum(tongtien) FROM donhang d WHERE d.user_id=u.user_id AND d.status!='3' AND d.status!='4') AS total_doanhso FROM user_info u WHERE user_id IN ($list_id) ORDER BY user_id ASC LIMIT $start,$limit");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			if (in_array($r_tt['user_id'], $tach_nhomtruong) == true) {
				$r_tt['vaitro'] = '<select class="select_vaitro" user_id="' . $r_tt['user_id'] . '" nhom="' . $nhom . '"><option value="1" selected>Trưởng nhóm</option><option value="0">Thành viên</option></select>';
			} else {
				$r_tt['vaitro'] = '<select class="select_vaitro" user_id="' . $r_tt['user_id'] . '" nhom="' . $nhom . '"><option value="1">Trưởng nhóm</option><option value="0" selected>Thành viên</option></select>';
			}
			$r_tt['nhom'] = $nhom;
			$r_tt['total_doanhso'] = number_format($r_tt['total_doanhso']) . ' đ';
			$r_tt['total_donhang'] = number_format($r_tt['total_donhang']);
			$list .= $skin->skin_replace('skin_cpanel/box_action/tr_thanhvien_nhom', $r_tt);
		}
		return $list;
	}
	////////////////////
	function list_doanhthu_thanhvien_nhom($conn, $list_id, $list_nhomtruong, $dau, $cuoi) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$tach_nhomtruong = explode(',', $list_nhomtruong);
		$thongtin = mysqli_query($conn, "SELECT *,(SELECT count(*) FROM donhang d WHERE d.user_id=u.user_id AND d.status!='3' AND d.status!='4' AND d.date_post>='$dau' AND d.date_post<='$cuoi') AS total_donhang,(SELECT sum(tongtien) FROM donhang d WHERE d.user_id=u.user_id AND d.status!='3' AND d.status!='4' AND d.date_post>='$dau' AND d.date_post<='$cuoi') AS total_doanhso FROM user_info u WHERE user_id IN ($list_id) ORDER BY user_id ASC");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			if (in_array($r_tt['user_id'], $tach_nhomtruong) == true) {
				$r_tt['vaitro'] = 'Trưởng nhóm';
			} else {
				$r_tt['vaitro'] = 'Thành viên';
			}
			$r_tt['total_doanhso'] = number_format($r_tt['total_doanhso']) . ' đ';
			$r_tt['total_donhang'] = number_format($r_tt['total_donhang']);
			$list .= $skin->skin_replace('skin_cpanel/box_action/tr_doanhthu_thanhvien_nhom', $r_tt);
		}
		return $list;
	}
	////////////////////
	function list_coupon($conn, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $start;
		$thongtin = mysqli_query($conn, "SELECT * FROM coupon WHERE shop='0' AND loai!='baohanh' ORDER BY id DESC LIMIT $start,$limit");
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
			$list .= $skin->skin_replace('skin_cpanel/box_action/tr_coupon', $r_tt);
		}
		return $list;
	}
	////////////////////
	function list_deal($conn, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $start;
		$thongtin = mysqli_query($conn, "SELECT * FROM deal WHERE shop='0' AND (loai='muakem' OR loai='tang') ORDER BY id DESC LIMIT $start,$limit");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$r_tt['start'] = date('H:i:s d/m/Y', (int)$r_tt['date_start']);
			$r_tt['end'] = date('H:i:s d/m/Y', (int)$r_tt['date_end']);
			if ($r_tt['loai'] == 'muakem') {
				$r_tt['loai'] = 'Mua kèm deal sốc';
			} else if ($r_tt['loai'] == 'tang') {
				$r_tt['loai'] = 'Mua để nhận quà';
			}
			$list .= $skin->skin_replace('skin_cpanel/box_action/tr_deal', $r_tt);
		}
		return $list;
	}
	////////////////////
	function list_flash_sale($conn, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $start;
		$thongtin = mysqli_query($conn, "SELECT * FROM deal WHERE shop='0' AND loai='flash_sale' ORDER BY id DESC LIMIT $start,$limit");
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
			$list .= $skin->skin_replace('skin_cpanel/box_action/tr_flash_sale', $r_tt);
		}
		return $list;
	}
	////////////////////
	function list_color($conn, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $start;
		$thongtin = mysqli_query($conn, "SELECT * FROM mau_sanpham ORDER BY tieu_de ASC LIMIT $start,$limit");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$list .= $skin->skin_replace('skin_cpanel/box_action/tr_color', $r_tt);
		}
		return $list;
	}
	////////////////////
	function list_brand($conn, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $start;
		$thongtin = mysqli_query($conn, "SELECT * FROM thuong_hieu WHERE shop='0' ORDER BY tieu_de ASC LIMIT $start,$limit");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$list .= $skin->skin_replace('skin_cpanel/box_action/tr_brand', $r_tt);
		}
		return $list;
	}
	////////////////////
	function list_price($conn, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $start;
		$thongtin = mysqli_query($conn, "SELECT * FROM khoang_gia ORDER BY thu_tu ASC LIMIT $start,$limit");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			if ($r_tt['kieu'] == 'nho') {
				$r_tt['khoang'] = 'Nhỏ hơn ' . number_format($r_tt['max_price']);
			} else if ($r_tt['kieu'] == 'lon') {
				$r_tt['khoang'] = 'Lớn hơn ' . number_format($r_tt['min_price']);
			} else {
				$r_tt['khoang'] = 'Từ ' . number_format($r_tt['min_price']) . ' - đến ' . number_format($r_tt['max_price']);
			}
			$list .= $skin->skin_replace('skin_cpanel/box_action/tr_price', $r_tt);
		}
		return $list;
	}
	////////////////////
	function list_size($conn, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $start;
		$thongtin = mysqli_query($conn, "SELECT * FROM kich_co WHERE shop='0' ORDER BY thu_tu ASC LIMIT $start,$limit");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$list .= $skin->skin_replace('skin_cpanel/box_action/tr_size', $r_tt);
		}
		return $list;
	}
	////////////////////
	function list_theloai($conn, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $start;
		$thongtin = mysqli_query($conn, "SELECT * FROM category ORDER BY cat_main ASC, cat_thutu ASC LIMIT $start,$limit");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$r_tt['blank'] = $check->blank($r_tt['post_tieude']);
			$i++;
			$r_tt['i'] = $i;
			if ($r_tt['cat_icon'] == '') {
				$r_tt['cat_icon'] = '<span class="icon"><i class="icon icon-movie"></i></span>';
			}
			$list .= $skin->skin_replace('skin_cpanel/box_action/tr_category', $r_tt);
		}
		return $list;
	}
	////////////////////
	function list_category($conn, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $start;
		$thongtin = mysqli_query($conn, "SELECT * FROM category_sanpham ORDER BY cat_main ASC, cat_thutu ASC LIMIT $start,$limit");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$r_tt['blank'] = $check->blank($r_tt['post_tieude']);
			$i++;
			$r_tt['i'] = $i;
			if ($r_tt['cat_icon'] == '') {
				$r_tt['cat_icon'] = '<span class="icon"><i class="icon icon-movie"></i></span>';
			}
			if ($r_tt['cat_main'] == 0) {
				$r_tt['tieude_main'] = 'Danh mục chính';
			} else {
				$thongtin_main = mysqli_query($conn, "SELECT * FROM category_sanpham WHERE cat_id='{$r_tt['cat_main']}'");
				$r_main = mysqli_fetch_assoc($thongtin_main);
				$r_tt['tieude_main'] = $r_main['cat_tieude'];
			}
			$list .= $skin->skin_replace('skin_cpanel/box_action/tr_category_sanpham', $r_tt);
		}
		return $list;
	}
	////////////////////
	function list_slide($conn, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $start;
		$thongtin = mysqli_query($conn, "SELECT * FROM slide WHERE shop='0' ORDER BY thu_tu ASC LIMIT $start,$limit");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$list .= $skin->skin_replace('skin_cpanel/box_action/tr_slide', $r_tt);
		}
		return $list;
	}
	////////////////////
	function list_idol($conn, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $start;
		$thongtin = mysqli_query($conn, "SELECT * FROM idol ORDER BY thu_tu ASC LIMIT $start,$limit");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			if ($r_tt['an'] == 1) {
				$r_tt['an'] = 'Ẩn';
			} else {
				$r_tt['an'] = 'Hiển thị';
			}
			$list .= $skin->skin_replace('skin_cpanel/box_action/tr_idol', $r_tt);
		}
		return $list;
	}
	////////////////////
	function list_quanly_livestream($conn, $total, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $total - $start + 1;
		$thongtin = mysqli_query($conn, "SELECT dat_live.*,user_info.name,user_info.username,user_info.mobile,idol.ho_ten FROM dat_live LEFT JOIN user_info ON dat_live.user_id=user_info.user_id LEFT JOIN idol ON dat_live.idol=idol.id ORDER BY dat_live.id DESC LIMIT $start,$limit");
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
			$r_tt['san_pham'] = str_replace("\n", "<br>", $r_tt['san_pham']);
			$r_tt['ghi_chu'] = str_replace("\n", "<br>", $r_tt['ghi_chu']);
			$r_tt['ngan_sach'] = number_format($r_tt['ngan_sach']);
			$r_tt['khung_gio'] = str_replace(':', 'h', $r_tt['khung_gio']);
			$list .= $skin->skin_replace('skin_cpanel/box_action/tr_quanly_livestream', $r_tt);
		}
		return $list;
	}
	////////////////////
	function list_livestream($conn, $total, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $total - $start + 1;
		$thongtin = mysqli_query($conn, "SELECT dat_live.*,user_info.name,user_info.username,user_info.mobile,idol.ho_ten FROM dat_live LEFT JOIN user_info ON dat_live.user_id=user_info.user_id LEFT JOIN idol ON dat_live.idol=idol.id ORDER BY dat_live.id DESC LIMIT $start,$limit");
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
			$r_tt['san_pham'] = str_replace("\n", "<br>", $r_tt['san_pham']);
			$r_tt['ghi_chu'] = str_replace("\n", "<br>", $r_tt['ghi_chu']);
			$r_tt['ngan_sach'] = number_format($r_tt['ngan_sach']);
			$r_tt['khung_gio'] = str_replace(':', 'h', $r_tt['khung_gio']);
			$list .= $skin->skin_replace('skin_cpanel/box_action/tr_livestream', $r_tt);
		}
		return $list;
	}
	////////////////////
	function list_domain($conn, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $start;
		$thongtin = mysqli_query($conn, "SELECT * FROM domain_price ORDER BY loai ASC,thu_tu ASC LIMIT $start,$limit");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$r_tt['gia'] = number_format($r_tt['gia']);
			$r_tt['phi_caidat'] = number_format($r_tt['phi_caidat']);
			$r_tt['gia_han'] = number_format($r_tt['gia_han']);
			if ($r_tt['loai'] == 'quocte') {
				$r_tt['loai'] = 'Quốc tê';
			} else {
				$r_tt['loai'] = 'Việt Nam';
			}
			$list .= $skin->skin_replace('skin_cpanel/box_action/tr_domain_price', $r_tt);
		}
		return $list;
	}
	////////////////////
	function list_mua_domain($conn, $total, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $total - $start + 1;
		$thongtin = mysqli_query($conn, "SELECT mua_domain.*,user_info.username,user_info.mobile FROM mua_domain LEFT JOIN user_info ON mua_domain.user_id=user_info.user_id ORDER BY mua_domain.date_post DESC LIMIT $start,$limit");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i--;
			$r_tt['i'] = $i;
			$r_tt['gia'] = number_format($r_tt['gia']);
			$r_tt['phi_caidat'] = number_format($r_tt['phi_caidat']);
			$r_tt['gia_han'] = number_format($r_tt['gia_han']);
			if ($r_tt['loai'] == 'quocte') {
				$r_tt['loai'] = 'Quốc tê';
			} else {
				$r_tt['loai'] = 'Việt Nam';
			}
			if ($r_tt['status'] == 1) {
				$r_tt['status'] = 'Đã hoàn thành';
			} else if ($r_tt['status'] == 2) {
				$r_tt['status'] = 'Đã hủy';
			} else {
				$r_tt['status'] = 'Chờ xử lý';
			}
			$r_tt['date_post'] = date('H:i:d d/m/Y', $r_tt['date_post']);
			$list .= $skin->skin_replace('skin_cpanel/box_action/tr_mua_domain', $r_tt);
		}
		return $list;
	}
	////////////////////
	function list_hotro_domain($conn, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $start;
		$thongtin = mysqli_query($conn, "SELECT hotro_domain.*,user_info.username,user_info.mobile FROM hotro_domain LEFT JOIN user_info ON hotro_domain.user_id=user_info.user_id ORDER BY hotro_domain.date_post DESC LIMIT $start,$limit");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$r_tt['price'] = number_format($r_tt['price']);
			if ($r_tt['status'] == 1) {
				$r_tt['status'] = 'Đã hoàn thành';
			} else if ($r_tt['status'] == 2) {
				$r_tt['status'] = 'Đã hủy';
			} else {
				$r_tt['status'] = 'Chờ xử lý';
			}
			$r_tt['date_post'] = date('H:i:d d/m/Y', $r_tt['date_post']);
			$list .= $skin->skin_replace('skin_cpanel/box_action/tr_hotro_domain', $r_tt);
		}
		return $list;
	}
	////////////////////
	function list_giaodien($conn, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $start;
		$thongtin = mysqli_query($conn, "SELECT * FROM giaodien ORDER BY thu_tu ASC LIMIT $start,$limit");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$r_tt['gia_cu'] = number_format($r_tt['gia_cu']);
			$r_tt['gia_moi'] = number_format($r_tt['gia_moi']);
			$list .= $skin->skin_replace('skin_cpanel/box_action/tr_giaodien', $r_tt);
		}
		return $list;
	}
	////////////////////
	function list_goi_seeding($conn, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $start;
		$thongtin = mysqli_query($conn, "SELECT * FROM seeding_shopee ORDER BY loai ASC,thu_tu ASC LIMIT $start,$limit");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$r_tt['gia'] = number_format($r_tt['gia']);
			if ($r_tt['loai'] == 'seeding') {
				$r_tt['loai'] = 'Seeding shopee';
			} else if ($r_tt['loai'] == 'template') {
				$r_tt['loai'] = 'Bộ template';
			} else if ($r_tt['loai'] == 'setup_gianhang') {
				$r_tt['loai'] = 'Setup gian hàng shopee';
			} else if ($r_tt['loai'] == 'copy_sanpham') {
				$r_tt['loai'] = 'Copy sản phẩm shopee';
			}
			$list .= $skin->skin_replace('skin_cpanel/box_action/tr_goi_seeding', $r_tt);
		}
		return $list;
	}
	////////////////////
	function list_mua_seeding($conn, $total, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $total - $start + 1;
		$thongtin = mysqli_query($conn, "SELECT mua_seeding_shopee.*,seeding_shopee.tieu_de,seeding_shopee.loai,user_info.name,user_info.mobile,user_info.username FROM mua_seeding_shopee LEFT JOIN user_info ON user_info.user_id=mua_seeding_shopee.user_id LEFT JOIN seeding_shopee ON seeding_shopee.id=mua_seeding_shopee.goi ORDER BY mua_seeding_shopee.id DESC LIMIT $start,$limit");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i--;
			$r_tt['i'] = $i;
			$r_tt['gia'] = number_format($r_tt['gia']);
			if ($r_tt['loai'] == 'seeding') {
				$r_tt['loai'] = 'Seeding shopee';
			} else if ($r_tt['loai'] == 'template') {
				$r_tt['loai'] = 'Bộ template';
			} else if ($r_tt['loai'] == 'setup_gianhang') {
				$r_tt['loai'] = 'Setup gian hàng shopee';
			} else if ($r_tt['loai'] == 'copy_sanpham') {
				$r_tt['loai'] = 'Copy sản phẩm shopee';
			}
			if ($r_tt['status'] == 0) {
				$r_tt['status'] = 'Chờ xử lý';
			} else if ($r_tt['status'] == 1) {
				$r_tt['status'] = 'Đang chạy';
			} else if ($r_tt['status'] == 2) {
				$r_tt['status'] = 'Hoàn thành';
			} else if ($r_tt['status'] == 3) {
				$r_tt['status'] = 'Đã hủy';
			}
			$r_tt['date_post'] = date('H:i:s d/m/Y', $r_tt['date_post']);
			$list .= $skin->skin_replace('skin_cpanel/box_action/tr_mua_seeding', $r_tt);
		}
		return $list;
	}
	////////////////////
	function list_banner_qc($conn, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $start;
		$thongtin = mysqli_query($conn, "SELECT * FROM banner_qc ORDER BY thu_tu ASC LIMIT $start,$limit");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$list .= $skin->skin_replace('skin_cpanel/box_action/tr_banner_qc', $r_tt);
		}
		return $list;
	}
	////////////////////
	function list_banner($conn, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $start;
		$thongtin = mysqli_query($conn, "SELECT * FROM banner ORDER BY vi_tri ASC, thu_tu ASC LIMIT $start,$limit");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			if ($r_tt['vi_tri'] == 'top') {
				$r_tt['vi_tri'] = 'Banner top';
			} else if ($r_tt['vi_tri'] == 'bottom_slide') {
				$r_tt['vi_tri'] = 'Banner dưới slide';
			} else if ($r_tt['vi_tri'] == 'sanpham_banchay') {
				$r_tt['vi_tri'] = 'Box sản phẩm bán chạy';
			} else if ($r_tt['vi_tri'] == 'sanpham_noibat') {
				$r_tt['vi_tri'] = 'Box sản phẩm nổi bật';
			} else if ($r_tt['vi_tri'] == 'banner_index') {
				$r_tt['vi_tri'] = 'Banner chính trang chủ laptop';
			} else if ($r_tt['vi_tri'] == 'banner_index_mobile') {
				$r_tt['vi_tri'] = 'Banner chính trang chủ mobile';
			} else if ($r_tt['vi_tri'] == 'banner_big') {
				$r_tt['vi_tri'] = 'Banner sau banner chính';
			}
			$list .= $skin->skin_replace('skin_cpanel/box_action/tr_banner', $r_tt);
		}
		return $list;
	}
	///////////////////
	function list_timkiem($conn, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $start;
		$thongtin = mysqli_query($conn, "SELECT * FROM timkiem ORDER BY id ASC LIMIT $start,$limit");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			if (strpos($r_tt['ip_address'], ',') !== false) {
				$tach_ip = explode(',', $r_tt['ip_address']);
				$r_tt['total_ip'] = count($tach_ip);
			} else {
				$r_tt['total_ip'] = 1;
			}
			$list .= $skin->skin_replace('skin_cpanel/box_action/tr_timkiem', $r_tt);
		}
		return $list;
	}
	///////////////////
	function list_option_category($conn, $id) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$thongtin = mysqli_query($conn, "SELECT * FROM category ORDER BY cat_thutu ASC");
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
	function list_option_brand($conn, $id) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$thongtin = mysqli_query($conn, "SELECT * FROM thuong_hieu WHERE shop='0' ORDER BY tieu_de ASC");
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
	function list_div_category_video($conn, $category) {
		$tach_category = explode(',', $category);
		$thongtin = mysqli_query($conn, "SELECT * FROM category_video ORDER BY thu_tu ASC");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			if (in_array($r_tt['id'], $tach_category) == true) {
				$list .= '<div class="li_input" id="input_' . $r_tt['id'] . '"><input type="checkbox" name="category[]" value="' . $r_tt['id'] . '" checked> ' . $r_tt['tieu_de'] . '</div>';
			} else {
				$list .= '<div class="li_input" id="input_' . $r_tt['id'] . '"><input type="checkbox" name="category[]" value="' . $r_tt['id'] . '"> ' . $r_tt['tieu_de'] . '</div>';
			}
		}
		return $list;
	}
	//////////////////////////////////////////////////////////////////
	function list_div_category($conn, $category) {
		$tach_category = explode(',', $category);
		$thongtin = mysqli_query($conn, "SELECT * FROM category ORDER BY cat_thutu ASC");
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
	function list_div_category_sanpham($conn, $category) {
		$tach_category = explode(',', $category);
		$thongtin = mysqli_query($conn, "SELECT * FROM category_sanpham ORDER BY cat_main ASC,cat_tieude ASC,cat_thutu ASC");
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
	function list_div_main_category_sanpham($conn, $category) {
		$tach_category = explode(',', $category);
		$thongtin = mysqli_query($conn, "SELECT * FROM category_sanpham WHERE cat_main='0' ORDER BY cat_main ASC,cat_tieude ASC,cat_thutu ASC");
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
	function list_div_sub_category_sanpham($conn, $main, $category) {
		$tach_category = explode(',', $category);
		$thongtin = mysqli_query($conn, "SELECT * FROM category_sanpham WHERE cat_main IN ($main) ORDER BY cat_main ASC,cat_tieude ASC,cat_thutu ASC");
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
	function list_div_sub_sub_category_sanpham($conn, $main, $category) {
		$tach_category = explode(',', $category);
		$thongtin = mysqli_query($conn, "SELECT *,(SELECT cat_main FROM category_sanpham c WHERE category_sanpham.cat_main=c.cat_id) AS main_main FROM category_sanpham WHERE cat_main IN ($main) ORDER BY cat_main ASC,cat_tieude ASC,cat_thutu ASC");
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
		if(strpos($color, '|')!==false){
			$tach_color=explode('|', $color);
			foreach ($tach_color as $key => $value) {
				$tach_value=explode('&&', $value);
				$list_color[].=$tach_value[0];
			}
		}else{
			$tach_color = explode('&&', $color);
			$list_color[]=$tach_color[0];
		}
		$thongtin = mysqli_query($conn, "SELECT * FROM mau_sanpham ORDER BY tieu_de ASC");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			if (in_array($r_tt['id'], $list_color) == true) {
				$list .= '<div class="li_input" id="input_' . $r_tt['id'] . '"><input type="checkbox" name="color[]" value="' . $r_tt['id'] . '" checked> <span>' . $r_tt['tieu_de'] . '</span></div>';
			} else {
				$list .= '<div class="li_input" id="input_' . $r_tt['id'] . '"><input type="checkbox" name="color[]" value="' . $r_tt['id'] . '"> <span>' . $r_tt['tieu_de'] . '</span></div>';
			}
		}
		return $list;
	}
	//////////////////////////////////////////////////////////////////
	function list_div_size_sanpham($conn, $size) {
		$tach_size = explode(',', $size);
		$thongtin = mysqli_query($conn, "SELECT * FROM kich_co WHERE shop='0' ORDER BY tieu_de ASC");
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
	function list_option_main_menu($conn, $id) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$thongtin = mysqli_query($conn, "SELECT * FROM menu WHERE menu_main='0' AND menu_vitri='top' ORDER BY menu_thutu ASC");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$thongtin_sub = mysqli_query($conn, "SELECT * FROM menu WHERE menu_main='{$r_tt['menu_id']}' ORDER BY menu_thutu ASC");
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
	function list_option_tintuc($conn, $id) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$thongtin = mysqli_query($conn, "SELECT * FROM category_tintuc WHERE cat_main='0' ORDER BY cat_thutu ASC");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$thongtin_sub = mysqli_query($conn, "SELECT * FROM category_tintuc WHERE cat_main='{$r_tt['cat_id']}' ORDER BY cat_thutu ASC");
			$total_sub = mysqli_num_rows($thongtin_sub);
			if ($total_sub == 0) {
				$list_sub = '';
			} else {
				while ($r_s = mysqli_fetch_assoc($thongtin_sub)) {
					$thongtin_sub_sub = mysqli_query($conn, "SELECT * FROM category_tintuc WHERE cat_main='{$r_s['cat_id']}' ORDER BY cat_thutu ASC");
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
	function list_option_main($conn, $id) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$thongtin = mysqli_query($conn, "SELECT * FROM category WHERE cat_main='0' ORDER BY cat_thutu ASC");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$thongtin_sub = mysqli_query($conn, "SELECT * FROM category WHERE cat_main='{$r_tt['cat_id']}' ORDER BY cat_thutu ASC");
			$total_sub = mysqli_num_rows($thongtin_sub);
			if ($total_sub == 0) {
				$list_sub = '';
			} else {
				while ($r_s = mysqli_fetch_assoc($thongtin_sub)) {
					$thongtin_sub_sub = mysqli_query($conn, "SELECT * FROM category WHERE cat_main='{$r_s['cat_id']}' ORDER BY cat_thutu ASC");
					$total_sub_sub = mysqli_num_rows($thongtin_sub_sub);
					if ($total_sub_sub == 0) {
						$list_sub_sub = '';
					} else {
						while ($r_ss = mysqli_fetch_assoc($thongtin_sub_sub)) {
							if ($r_ss['cat_id'] == $id) {
								$list_sub_sub .= '<option value="' . $r_ss['cat_id'] . '" selected disabled>---- ' . $r_ss['cat_tieude'] . '</option>';
							} else {
								$list_sub_sub .= '<option value="' . $r_ss['cat_id'] . '" disabled>---- ' . $r_ss['cat_tieude'] . '</option>';
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
	function list_option_main_sanpham($conn, $id) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$thongtin = mysqli_query($conn, "SELECT * FROM category_sanpham WHERE cat_main='0' ORDER BY cat_thutu ASC");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$thongtin_sub = mysqli_query($conn, "SELECT * FROM category_sanpham WHERE cat_main='{$r_tt['cat_id']}' ORDER BY cat_thutu ASC");
			$total_sub = mysqli_num_rows($thongtin_sub);
			if ($total_sub == 0) {
				$list_sub = '';
			} else {
				while ($r_s = mysqli_fetch_assoc($thongtin_sub)) {
					$thongtin_sub_sub = mysqli_query($conn, "SELECT * FROM category_sanpham WHERE cat_main='{$r_s['cat_id']}' ORDER BY cat_thutu ASC");
					$total_sub_sub = mysqli_num_rows($thongtin_sub_sub);
					if ($total_sub_sub == 0) {
						$list_sub_sub = '';
					} else {
						while ($r_ss = mysqli_fetch_assoc($thongtin_sub_sub)) {
							if ($r_ss['cat_id'] == $id) {
								$list_sub_sub .= '<option value="' . $r_ss['cat_id'] . '" selected disabled>---- ' . $r_ss['cat_tieude'] . '</option>';
							} else {
								$list_sub_sub .= '<option value="' . $r_ss['cat_id'] . '" disabled>---- ' . $r_ss['cat_tieude'] . '</option>';
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
	function list_option_main_auto($conn, $id) {
		$tach_id = explode(',', $id);
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$thongtin = mysqli_query($conn, "SELECT * FROM category WHERE cat_main='0' ORDER BY cat_thutu ASC");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$thongtin_sub = mysqli_query($conn, "SELECT * FROM category WHERE cat_main='{$r_tt['cat_id']}' ORDER BY cat_thutu ASC");
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
					$thongtin_sub_sub = mysqli_query($conn, "SELECT * FROM category WHERE cat_main='{$r_s['cat_id']}' ORDER BY cat_thutu ASC");
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
	function list_option_post($conn, $link) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$thongtin = mysqli_query($conn, "SELECT * FROM post ORDER BY id DESC");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			if ($r_tt['link'] == $link) {
				$list .= '<option value="' . $r_tt['link'] . '" selected>' . $r_tt['tieu_de'] . '</option>';
			} else {
				$list .= '<option value="' . $r_tt['link'] . '">' . $r_tt['tieu_de'] . '</option>';
			}
		}
		return $list;
	}
	///////////////////
	function list_video($conn, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$thongtin = mysqli_query($conn, "SELECT * FROM video ORDER BY id DESC LIMIT $start,$limit");
		$i = $start;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			if (strpos($r_tt['loai'], 'all') !== false) {
				$r_tt['loai'] = 'Tất cả';
			} else if (strpos($r_tt['loai'], 'drop') !== false) {
				$r_tt['loai'] = 'Drop';
			}if (strpos($r_tt['loai'], 'ctv') !== false) {
				$r_tt['loai'] = 'Cộng tác viên';
			}
			$list .= $skin->skin_replace('skin_cpanel/box_action/tr_video', $r_tt);
		}
		return $list;
	}
	///////////////////
	function list_thongbao($conn, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$thongtin = mysqli_query($conn, "SELECT * FROM thongbao ORDER BY id DESC LIMIT $start,$limit");
		$i = $start;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			if ($r_tt['pop'] == 1) {
				$r_tt['pop'] = 'Có';
			} else {
				$r_tt['pop'] = 'Không';
			}
			$list .= $skin->skin_replace('skin_cpanel/box_action/tr_thongbao', $r_tt);
		}
		return $list;
	}
	///////////////////
	function list_remarketing($conn, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$thongtin = mysqli_query($conn, "SELECT * FROM thongbao_shop WHERE shop='0' ORDER BY id DESC LIMIT $start,$limit");
		$i = $start;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			if ($r_tt['pop'] == 1) {
				$r_tt['pop'] = 'Có';
			} else {
				$r_tt['pop'] = 'Không';
			}
			$list .= $skin->skin_replace('skin_cpanel/box_action/tr_remarketing', $r_tt);
		}
		return $list;
	}
	///////////////////
	function list_baiviet($conn, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$thongtin = mysqli_query($conn, "SELECT * FROM post ORDER BY id DESC LIMIT $start,$limit");
		$i = $start;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$list .= $skin->skin_replace('skin_cpanel/box_action/tr_baiviet', $r_tt);
		}
		return $list;
	}
	///////////////////
	function list_thanhvien_kichhoat($conn, $total, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$thongtin = mysqli_query($conn, "SELECT * FROM user_info WHERE dropship='2' ORDER BY user_id DESC LIMIT $start,$limit");
		$i = $total - $start + 1;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i--;
			$r_tt['i'] = $i;
			$r_tt['sodu'] = $r_tt['user_money'] + $r_tt['user_money2'];
			$r_tt['sodu'] = number_format($r_tt['sodu']);
			$r_tt['user_money'] = number_format($r_tt['user_money']);
			$r_tt['user_money2'] = number_format($r_tt['user_money2']);
			$r_tt['created'] = date('d/m/Y', $r_tt['created']);
			$r_tt['style_color'] = '';
			$r_tt['tinh_trang'] = '<input type="radio" name="drop_' . $r_tt['user_id'] . '" value="2"> chờ duyệt <input type="radio" name="drop_' . $r_tt['user_id'] . '" value="3"> Từ chối <input type="radio" value="1" name="drop_' . $r_tt['user_id'] . '">Duyệt <input type="radio" value="4" name="drop_' . $r_tt['user_id'] . '" checked>Tạm khóa ';

			$list .= $skin->skin_replace('skin_cpanel/box_action/tr_thanhvien_drop', $r_tt);
		}
		return $list;
	}
	///////////////////
	function list_thanhvien_tamkhoa($conn, $total, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$thongtin = mysqli_query($conn, "SELECT * FROM user_info WHERE dropship='4' ORDER BY user_id DESC LIMIT $start,$limit");
		$i = $total - $start + 1;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i--;
			$r_tt['i'] = $i;
			$r_tt['sodu'] = $r_tt['user_money'] + $r_tt['user_money2'];
			$r_tt['sodu'] = number_format($r_tt['sodu']);
			$r_tt['user_money'] = number_format($r_tt['user_money']);
			$r_tt['user_money2'] = number_format($r_tt['user_money2']);
			$r_tt['created'] = date('d/m/Y', $r_tt['created']);
			$r_tt['style_color'] = '';
			$r_tt['tinh_trang'] = '<input type="radio" name="drop_' . $r_tt['user_id'] . '" value="2"> chờ duyệt <input type="radio" name="drop_' . $r_tt['user_id'] . '" value="3"> Từ chối <input type="radio" value="1" name="drop_' . $r_tt['user_id'] . '">Duyệt <input type="radio" value="4" name="drop_' . $r_tt['user_id'] . '" checked>Tạm khóa ';

			$list .= $skin->skin_replace('skin_cpanel/box_action/tr_thanhvien_drop', $r_tt);
		}
		return $list;
	}
	///////////////////
	function list_thanhvien_drop($conn, $total, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page* $limit - $limit;
		$thongtin = mysqli_query($conn, "SELECT * FROM user_info WHERE dropship>'0' ORDER BY user_id DESC LIMIT $start,$limit");
		$i = $total - $start + 1;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i--;
			$r_tt['i'] = $i;
			$r_tt['sodu'] = $r_tt['user_money'] + $r_tt['user_money2'];
			$r_tt['sodu'] = number_format($r_tt['sodu']);
			$r_tt['user_money'] = number_format($r_tt['user_money']);
			$r_tt['user_money2'] = number_format($r_tt['user_money2']);
			$r_tt['created'] = date('d/m/Y', $r_tt['created']);
			if ($r_tt['chinh_thuc'] == 1 AND $r_tt['dropship'] == 1) {
				$r_tt['style_color'] = '#f00';
			} else {
				$r_tt['style_color'] = '';
			}
			if($r_tt['aff']>0){
				$thongtin_quanly=mysqli_query($conn,"SELECT * FROM user_info WHERE user_id='{$r_tt['aff']}'");
				$r_ql=mysqli_fetch_assoc($thongtin_quanly);
				$r_tt['nguoi_quanly']=$r_ql['name'];
			}else{
				$r_tt['nguoi_quanly']='<button class="show_quanly" user_id="'.$r_tt['user_id'].'">Thêm quản lý</button>';
			}
			if($r_tt['leader']==1){
				$r_tt['leader']='Có';
			}else{
				$r_tt['leader']='Không';
			}
			if ($r_tt['dropship'] == 2) {
				$r_tt['tinh_trang'] = '<input type="radio" name="drop_' . $r_tt['user_id'] . '" value="2" checked> chờ duyệt <input type="radio" name="drop_' . $r_tt['user_id'] . '" value="3"> Từ chối <input type="radio" value="1" name="drop_' . $r_tt['user_id'] . '">Duyệt <input type="radio" value="4" name="drop_' . $r_tt['user_id'] . '">Tạm khóa';
			} else if ($r_tt['dropship'] == 3) {
				$r_tt['tinh_trang'] = '<input type="radio" name="drop_' . $r_tt['user_id'] . '" value="2"> chờ duyệt <input type="radio" name="drop_' . $r_tt['user_id'] . '" value="3" checked> Từ chối <input type="radio" value="1" name="drop_' . $r_tt['user_id'] . '">Duyệt <input type="radio" value="4" name="drop_' . $r_tt['user_id'] . '">Tạm khóa ';
			} else if ($r_tt['dropship'] == 4) {
				$r_tt['tinh_trang'] = '<input type="radio" name="drop_' . $r_tt['user_id'] . '" value="2"> chờ duyệt <input type="radio" name="drop_' . $r_tt['user_id'] . '" value="3"> Từ chối <input type="radio" value="1" name="drop_' . $r_tt['user_id'] . '">Duyệt <input type="radio" value="4" name="drop_' . $r_tt['user_id'] . '" checked>Tạm khóa ';
			} else if ($r_tt['dropship'] == 1) {
				$r_tt['tinh_trang'] = '<input type="radio" name="drop_' . $r_tt['user_id'] . '" value="2"> chờ duyệt <input type="radio" name="drop_' . $r_tt['user_id'] . '" value="3"> Từ chối <input type="radio" value="1" name="drop_' . $r_tt['user_id'] . '" checked>Duyệt <input type="radio" value="4" name="drop_' . $r_tt['user_id'] . '">Tạm khóa';
			} else {
			}
			$list .= $skin->skin_replace('skin_cpanel/box_action/tr_thanhvien_drop', $r_tt);
		}
		return $list;
	}
	///////////////////
	function list_thanhvien_ctv($conn, $total, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$thongtin = mysqli_query($conn, "SELECT * FROM user_info WHERE ctv>'0' ORDER BY user_id DESC LIMIT $start,$limit");
		$i = $total - $start + 1;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i--;
			$r_tt['i'] = $i;
			$r_tt['user_money'] = number_format($r_tt['user_money']);
			$r_tt['user_donate'] = number_format($r_tt['user_donate']);
			$r_tt['created'] = date('d/m/Y', $r_tt['created']);
			if ($r_tt['ctv'] == 2) {
				$r_tt['tinh_trang'] = '<input type="radio" name="ctv_' . $r_tt['user_id'] . '" value="2" checked> chờ duyệt <input type="radio" name="ctv_' . $r_tt['user_id'] . '" value="3"> Từ chối <input type="radio" value="1" name="ctv_' . $r_tt['user_id'] . '">Duyệt ';
			} else if ($r_tt['ctv'] == 3) {
				$r_tt['tinh_trang'] = '<input type="radio" name="ctv_' . $r_tt['user_id'] . '" value="2"> chờ duyệt <input type="radio" name="ctv_' . $r_tt['user_id'] . '" value="3" checked> Từ chối <input type="radio" value="1" name="ctv_' . $r_tt['user_id'] . '">Duyệt ';
			} else if ($r_tt['ctv'] == 1) {
				$r_tt['tinh_trang'] = '<input type="radio" name="ctv_' . $r_tt['user_id'] . '" value="2"> chờ duyệt <input type="radio" name="ctv_' . $r_tt['user_id'] . '" value="3"> Từ chối <input type="radio" value="1" name="ctv_' . $r_tt['user_id'] . '" checked>Duyệt ';
			} else {
			}
			$list .= $skin->skin_replace('skin_cpanel/box_action/tr_thanhvien_ctv', $r_tt);
		}
		return $list;
	}
	///////////////////
	function list_thanhvien_chuyennghiep($conn, $total, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$thongtin = mysqli_query($conn, "SELECT * FROM user_info WHERE leader='1' ORDER BY user_id DESC LIMIT $start,$limit");
		$i = $total - $start + 1;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i--;
			$r_tt['i'] = $i;
			$r_tt['user_money'] = number_format($r_tt['user_money']);
			$r_tt['user_donate'] = number_format($r_tt['user_donate']);
			$r_tt['created'] = date('d/m/Y', $r_tt['created']);
			$thongtin_nhom=mysqli_query($conn,"SELECT count(*) AS total FROM user_info WHERE aff='{$r_tt['user_id']}'");
			$r_n=mysqli_fetch_assoc($thongtin_nhom);
			$r_tt['total_thanhvien']=number_format($r_n['total']);
			$list .= $skin->skin_replace('skin_cpanel/box_action/tr_thanhvien_chuyennghiep', $r_tt);
		}
		return $list;
	}
	///////////////////
	function list_quanly($conn) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$thongtin = mysqli_query($conn, "SELECT * FROM user_info WHERE leader='1' ORDER BY user_id DESC");
		$i=0;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$r_tt['created'] = date('d/m/Y', $r_tt['created']);
			$thongtin_quanly=mysqli_query($conn,"SELECT count(*) AS total FROM user_info WHERE aff='{$r_tt['user_id']}'");
			$r_ql=mysqli_fetch_assoc($thongtin_quanly);
			$r_tt['total']=$r_ql['total'];
			$list .= $skin->skin_replace('skin_cpanel/box_action/li_quanly', $r_tt);
		}
		return $list;
	}
	///////////////////
	function list_thanhvien($conn, $active, $total, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		if ($active == 'all') {
			$thongtin = mysqli_query($conn, "SELECT * FROM user_info ORDER BY user_id DESC LIMIT $start,$limit");
		} else {
			$thongtin = mysqli_query($conn, "SELECT * FROM user_info WHERE active='$active' ORDER BY user_id DESC LIMIT $start,$limit");
		}
		$i = $total - $start + 1;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i--;
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
				$list .= $skin->skin_replace('skin_cpanel/box_action/tr_thanhvien_khoa', $r_tt);
			} else if ($active == 3) {
				$list .= $skin->skin_replace('skin_cpanel/box_action/tr_thanhvien_khoa_vinhvien', $r_tt);
			} else {
				$list .= $skin->skin_replace('skin_cpanel/box_action/tr_thanhvien', $r_tt);
			}
		}
		return $list;
	}
	///////////////////
	function list_noidung_nhiemvu($conn, $id, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$thongtin = mysqli_query($conn, "SELECT * FROM noidung_nhiemvu WHERE nhiem_vu='$id' ORDER BY id DESC LIMIT $start,$limit");
		$i = $start;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$r_tt['date_post'] = date('d/m/Y', $r_tt['date_post']);
			$r_tt['noi_dung']=$check->words($r_tt['noi_dung'],30);
			$tach_anh=explode(',', $r_tt['hinh_anh']);
			$r_tt['minh_hoa']=$tach_anh[0];
			$list .= $skin->skin_replace('skin_cpanel/box_action/tr_noidung_nhiemvu', $r_tt);
		}
		return $list;
	}
	///////////////////
	function list_share_sanpham($conn, $id, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$thongtin = mysqli_query($conn, "SELECT * FROM list_share_sanpham WHERE sp_id='$id' ORDER BY id DESC LIMIT $start,$limit");
		$i = $start;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$r_tt['date_post'] = date('d/m/Y', $r_tt['date_post']);
			$r_tt['noi_dung']=$check->words($r_tt['noi_dung'],30);
			$tach_anh=explode(',', $r_tt['minh_hoa']);
			$r_tt['minh_hoa']=$tach_anh[0];
			$duoi = $check->duoi_file($r_tt['minh_hoa']);
			if(in_array($duoi, array('mp4','wmv','mov'))==true){
				$r_tt['minh_hoa']='/images/video.jpg';
			}
			$list .= $skin->skin_replace('skin_cpanel/box_action/tr_share_sanpham', $r_tt);
		}
		return $list;
	}
	///////////////////
	function list_sanpham($conn, $kho, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$thongtin = mysqli_query($conn, "SELECT * FROM sanpham ORDER BY id DESC LIMIT $start,$limit");
		$i = $start;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$r_tt['date_post'] = date('d/m/Y', $r_tt['date_post']);
			$r_tt['gia_cu'] = number_format($r_tt['gia_cu']);
			$r_tt['gia_moi'] = number_format($r_tt['gia_moi']);
			$r_tt['gia_drop'] = number_format($r_tt['gia_drop']);
			$r_tt['gia_ctv'] = number_format($r_tt['gia_ctv']);
			$r_tt['drop_min'] = number_format($r_tt['drop_min']);
			if ($r_tt['drop_min'] == 0) {
				$r_tt['drop_min'] = 'Không quy định';
			}
			if ($kho == 'kho') {
				$r_tt['kho'] = $r_tt['kho'];
			} else if ($kho == 'kho_hcm') {
				$r_tt['kho'] = $r_tt['kho_hcm'];
			}
			$r_tt['drop_max'] = number_format($r_tt['drop_max']);
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
			$thongtin_share=mysqli_query($conn,"SELECT count(*) AS total FROM list_share_sanpham WHERE sp_id='{$r_tt['id']}'");
			$r_share=mysqli_fetch_assoc($thongtin_share);
			if($r_share['total']>0){
				$r_tt['bg_noidung']='bg_orange';
			}else{
				$r_tt['bg_noidung']='bg_violet';
			}
			$list .= $skin->skin_replace('skin_cpanel/box_action/tr_sanpham', $r_tt);
		}
		return $list;
	}
	///////////////////
	function list_sanpham_hethang($conn, $kho, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		if ($kho == 'kho_hcm') {
			$thongtin = mysqli_query($conn, "SELECT * FROM sanpham WHERE kho_hcm<='10' ORDER BY id DESC LIMIT $start,$limit");
		} else {
			$thongtin = mysqli_query($conn, "SELECT * FROM sanpham WHERE kho<='10' ORDER BY id DESC LIMIT $start,$limit");
		}
		$i = $start;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$r_tt['date_post'] = date('d/m/Y', $r_tt['date_post']);
			$r_tt['gia_cu'] = number_format($r_tt['gia_cu']);
			$r_tt['gia_moi'] = number_format($r_tt['gia_moi']);
			$r_tt['gia_drop'] = number_format($r_tt['gia_drop']);
			$r_tt['gia_ctv'] = number_format($r_tt['gia_ctv']);
			$r_tt['drop_min'] = number_format($r_tt['drop_min']);
			if ($kho == 'kho') {
				$r_tt['kho'] = $r_tt['kho'];
			} else if ($kho == 'kho_hcm') {
				$r_tt['kho'] = $r_tt['kho_hcm'];
			}
			if ($r_tt['drop_min'] == 0) {
				$r_tt['drop_min'] = 'Không quy định';
			}
			$r_tt['drop_max'] = number_format($r_tt['drop_max']);
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
			$list .= $skin->skin_replace('skin_cpanel/box_action/tr_sanpham', $r_tt);
		}
		return $list;
	}
	///////////////////
	function list_sanpham_trend($conn, $kho, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$thongtin = mysqli_query($conn, "SELECT sanpham.*,sanpham_trend.id AS id,sanpham_trend.gia FROM sanpham_trend INNER JOIN sanpham ON sanpham_trend.sp_id=sanpham.id ORDER BY sanpham_trend.id DESC LIMIT $start,$limit");
		$i = $start;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$r_tt['date_post'] = date('d/m/Y', $r_tt['date_post']);
			$r_tt['gia_cu'] = number_format($r_tt['gia_cu']);
			$r_tt['gia_moi'] = number_format($r_tt['gia_moi']);
			$r_tt['gia_drop'] = number_format($r_tt['gia_drop']);
			$r_tt['drop_min'] = number_format($r_tt['drop_min']);
			if ($r_tt['drop_min'] == 0) {
				$r_tt['drop_min'] = 'Không quy định';
			}
			if ($kho == 'kho') {
				$r_tt['kho'] = $r_tt['kho'];
			} else if ($kho == 'kho_hcm') {
				$r_tt['kho'] = $r_tt['kho_hcm'];
			}
			$r_tt['drop_max'] = number_format($r_tt['drop_max']);
			$r_tt['gia'] = number_format($r_tt['gia']);
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
			$list .= $skin->skin_replace('skin_cpanel/box_action/tr_sanpham_trend', $r_tt);
		}
		return $list;
	}
	///////////////////
	function list_sanpham_tuan($conn, $kho, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$hientai = time();
		$thongtin = mysqli_query($conn, "SELECT sanpham.*,sanpham_tuan.id AS id,sanpham_tuan.time_start,sanpham_tuan.time_end, sanpham_tuan.gia_truoc,sanpham_tuan.gia_tuan,sanpham_tuan.gia_ctv_truoc,sanpham_tuan.gia_ctv_tuan FROM sanpham_tuan INNER JOIN sanpham ON sanpham_tuan.sp_id=sanpham.id ORDER BY sanpham_tuan.id DESC LIMIT $start,$limit");
		$i = $start;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$r_tt['date_post'] = date('d/m/Y', $r_tt['date_post']);
			if($r_tt['gia_ctv_tuan']==0){
				$gia_ctv= $r_tt['gia_tuan'] + (($r_tt['drop_min'] - $r_tt['gia_tuan'])*0.3);
			}else{
				$gia_ctv= $r_tt['gia_ctv_tuan'];
			}
			if($r_tt['gia_ctv_truoc']==0){
				$gia_ctv_truoc= $r_tt['gia_truoc'] + (($r_tt['drop_min'] - $r_tt['gia_truoc'])*0.3);
			}else{
				$gia_ctv_truoc= $r_tt['gia_ctv_truoc'];
			}
			$r_tt['gia_cu'] = number_format($r_tt['gia_cu']);
			$r_tt['gia_moi'] = number_format($r_tt['gia_moi']);
			$r_tt['gia_drop'] = number_format($r_tt['gia_drop']);
			$r_tt['drop_min'] = number_format($r_tt['drop_min']);
			if ($r_tt['drop_min'] == 0) {
				$r_tt['drop_min'] = 'Không quy định';
			}
			if ($kho == 'kho') {
				$r_tt['kho'] = $r_tt['kho'];
			} else if ($kho == 'kho_hcm') {
				$r_tt['kho'] = $r_tt['kho_hcm'];
			}
			$r_tt['gia_ctv_truoc']=number_format($gia_ctv_truoc);
			$r_tt['gia_ctv_tuan']=number_format($gia_ctv);
			$r_tt['drop_max'] = number_format($r_tt['drop_max']);
			$r_tt['gia_truoc'] = number_format($r_tt['gia_truoc']);
			$r_tt['gia_tuan'] = number_format($r_tt['gia_tuan']);
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
			unset($list_ma);
			$list .= $skin->skin_replace('skin_cpanel/box_action/tr_sanpham_tuan', $r_tt);
		}
		return $list;
	}
	///////////////////
	function list_lienhe($conn, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$thongtin = mysqli_query($conn, "SELECT * FROM contact ORDER BY id DESC LIMIT $start,$limit");
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
			$list .= $skin->skin_replace('skin_cpanel/box_action/tr_lienhe', $r_tt);
		}
		return $list;
	}
	///////////////////
	function list_nhantin($conn, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$thongtin = mysqli_query($conn, "SELECT * FROM dangky_nhantin WHERE shop='0' ORDER BY id DESC LIMIT $start,$limit");
		$i = $start;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$r_tt['date_post'] = date('d/m/Y', $r_tt['date_post']);
			$list .= $skin->skin_replace('skin_cpanel/box_action/tr_nhantin', $r_tt);
		}
		return $list;
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
		return intval($mon) . ',' . intval($tus) . ',' . intval($web) . ',' . intval($thu) . ',' . intval($fri) . ',' . intval($sat) . ',' . intval($sun);
	}
	///////////////////
	function thongke_thanhvien_nam($conn, $dau, $cuoi) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$thongtin = mysqli_query($conn, "SELECT * FROM user_info WHERE created>='$dau' AND created<='$cuoi'");
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
	function thongke_thanhvien_thang($conn, $thang, $nam, $dau, $cuoi) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$thongtin = mysqli_query($conn, "SELECT * FROM user_info WHERE created>='$dau' AND created<='$cuoi'");
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
	function thongke_thanhvien_tuan($conn, $dau, $cuoi) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$thongtin = mysqli_query($conn, "SELECT * FROM user_info WHERE created>='$dau' AND created<='$cuoi'");
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
	function thongke_donhang($conn, $dau, $cuoi) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$month_1 = 0;
		$month_2 = 0;
		$month_3 = 0;
		$month_4 = 0;
		$month_5 = 0;
		$month_6 = 0;
		$month_7 = 0;
		$month_8 = 0;
		$month_9 = 0;
		$month_10 = 0;
		$month_11 = 0;
		$month_12 = 0;
		$daydon = 0;
		$tiepnhan = 0;
		$sanxuat = 0;
		$hoanthanh = 0;
		$hoandon = 0;
		$danggiao = 0;
		$thongtin = mysqli_query($conn, "SELECT * FROM donhang WHERE date_post>='$dau' AND date_post<='$cuoi'");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$month = date('m', $r_tt['date_post']);
			$month = intval($month);
			if ($month == 1) {
				$month_1++;
				if ($r_tt['status'] == 0) {
					$cho_1++;
				} else if ($r_tt['status'] == 1) {
					$tiepnhan_1++;
				} else if ($r_tt['status'] == 2) {
					$vanchuyen_1++;
				} else if ($r_tt['status'] == 3) {
					$yeucau_huy_1++;
				} else if ($r_tt['status'] == 4) {
					$huy_1++;
				} else if ($r_tt['status'] == 5) {
					$hoanthanh_1++;
				} else if ($r_tt['status'] == 6) {
					$hoan_1++;
				}
			} else if ($month == 2) {
				$month_2++;
				if ($r_tt['status'] == 0) {
					$cho_2++;
				} else if ($r_tt['status'] == 1) {
					$tiepnhan_2++;
				} else if ($r_tt['status'] == 2) {
					$vanchuyen_2++;
				} else if ($r_tt['status'] == 3) {
					$yeucau_huy_2++;
				} else if ($r_tt['status'] == 4) {
					$huy_2++;
				} else if ($r_tt['status'] == 5) {
					$hoanthanh_2++;
				} else if ($r_tt['status'] == 6) {
					$hoan_2++;
				}
			} else if ($month == 3) {
				$month_3++;
				if ($r_tt['status'] == 0) {
					$cho_3++;
				} else if ($r_tt['status'] == 1) {
					$tiepnhan_3++;
				} else if ($r_tt['status'] == 2) {
					$vanchuyen_3++;
				} else if ($r_tt['status'] == 3) {
					$yeucau_huy_3++;
				} else if ($r_tt['status'] == 4) {
					$huy_3++;
				} else if ($r_tt['status'] == 5) {
					$hoanthanh_3++;
				} else if ($r_tt['status'] == 6) {
					$hoan_3++;
				}
			} else if ($month == 4) {
				$month_4++;
				if ($r_tt['status'] == 0) {
					$cho_4++;
				} else if ($r_tt['status'] == 1) {
					$tiepnhan_4++;
				} else if ($r_tt['status'] == 2) {
					$vanchuyen_4++;
				} else if ($r_tt['status'] == 3) {
					$yeucau_huy_4++;
				} else if ($r_tt['status'] == 4) {
					$huy_4++;
				} else if ($r_tt['status'] == 5) {
					$hoanthanh_4++;
				} else if ($r_tt['status'] == 6) {
					$hoan_4++;
				}
			} else if ($month == 5) {
				$month_5++;
				if ($r_tt['status'] == 0) {
					$cho_5++;
				} else if ($r_tt['status'] == 1) {
					$tiepnhan_5++;
				} else if ($r_tt['status'] == 2) {
					$vanchuyen_5++;
				} else if ($r_tt['status'] == 3) {
					$yeucau_huy_5++;
				} else if ($r_tt['status'] == 4) {
					$huy_5++;
				} else if ($r_tt['status'] == 5) {
					$hoanthanh_5++;
				} else if ($r_tt['status'] == 6) {
					$hoan_5++;
				}
			} else if ($month == 6) {
				$month_6++;
				if ($r_tt['status'] == 0) {
					$cho_6++;
				} else if ($r_tt['status'] == 1) {
					$tiepnhan_6++;
				} else if ($r_tt['status'] == 2) {
					$vanchuyen_6++;
				} else if ($r_tt['status'] == 3) {
					$yeucau_huy_6++;
				} else if ($r_tt['status'] == 4) {
					$huy_6++;
				} else if ($r_tt['status'] == 5) {
					$hoanthanh_6++;
				} else if ($r_tt['status'] == 6) {
					$hoan_6++;
				}
			} else if ($month == 7) {
				$month_7++;
				if ($r_tt['status'] == 0) {
					$cho_7++;
				} else if ($r_tt['status'] == 1) {
					$tiepnhan_7++;
				} else if ($r_tt['status'] == 2) {
					$vanchuyen_7++;
				} else if ($r_tt['status'] == 3) {
					$yeucau_huy_7++;
				} else if ($r_tt['status'] == 4) {
					$huy_7++;
				} else if ($r_tt['status'] == 5) {
					$hoanthanh_7++;
				} else if ($r_tt['status'] == 6) {
					$hoan_7++;
				}
			} else if ($month == 8) {
				$month_8++;
				if ($r_tt['status'] == 0) {
					$cho_8++;
				} else if ($r_tt['status'] == 1) {
					$tiepnhan_8++;
				} else if ($r_tt['status'] == 2) {
					$vanchuyen_8++;
				} else if ($r_tt['status'] == 3) {
					$yeucau_huy_8++;
				} else if ($r_tt['status'] == 4) {
					$huy_8++;
				} else if ($r_tt['status'] == 5) {
					$hoanthanh_8++;
				} else if ($r_tt['status'] == 6) {
					$hoan_8++;
				}
			} else if ($month == 9) {
				$month_9++;
				if ($r_tt['status'] == 0) {
					$cho_9++;
				} else if ($r_tt['status'] == 1) {
					$tiepnhan_9++;
				} else if ($r_tt['status'] == 2) {
					$vanchuyen_9++;
				} else if ($r_tt['status'] == 3) {
					$yeucau_huy_9++;
				} else if ($r_tt['status'] == 4) {
					$huy_9++;
				} else if ($r_tt['status'] == 5) {
					$hoanthanh_9++;
				} else if ($r_tt['status'] == 6) {
					$hoan_9++;
				}
			} else if ($month == 10) {
				$month_10++;
				if ($r_tt['status'] == 0) {
					$cho_10++;
				} else if ($r_tt['status'] == 1) {
					$tiepnhan_10++;
				} else if ($r_tt['status'] == 2) {
					$vanchuyen_10++;
				} else if ($r_tt['status'] == 3) {
					$yeucau_huy_10++;
				} else if ($r_tt['status'] == 4) {
					$huy_10++;
				} else if ($r_tt['status'] == 5) {
					$hoanthanh_10++;
				} else if ($r_tt['status'] == 6) {
					$hoan_10++;
				}
			} else if ($month == 11) {
				$month_11++;
				if ($r_tt['status'] == 0) {
					$cho_11++;
				} else if ($r_tt['status'] == 1) {
					$tiepnhan_11++;
				} else if ($r_tt['status'] == 2) {
					$vanchuyen_11++;
				} else if ($r_tt['status'] == 3) {
					$yeucau_huy_11++;
				} else if ($r_tt['status'] == 4) {
					$huy_11++;
				} else if ($r_tt['status'] == 5) {
					$hoanthanh_11++;
				} else if ($r_tt['status'] == 6) {
					$hoan_11++;
				}
			} else if ($month == 12) {
				$month_12++;
				if ($r_tt['status'] == 0) {
					$cho_12++;
				} else if ($r_tt['status'] == 1) {
					$tiepnhan_12++;
				} else if ($r_tt['status'] == 2) {
					$vanchuyen_12++;
				} else if ($r_tt['status'] == 3) {
					$yeucau_huy_12++;
				} else if ($r_tt['status'] == 4) {
					$huy_12++;
				} else if ($r_tt['status'] == 5) {
					$hoanthanh_12++;
				} else if ($r_tt['status'] == 6) {
					$hoan_12++;
				}
			}
		}
		$info = array(
			'data_donhang' => $month_1 . ',' . $month_2 . ',' . $month_3 . ',' . $month_4 . ',' . $month_5 . ',' . $month_6 . ',' . $month_7 . ',' . $month_8 . ',' . $month_9 . ',' . $month_10 . ',' . $month_11 . ',' . $month_12,
			'data_cho' => intval($cho_1) . ',' . intval($cho_2) . ',' . intval($cho_3) . ',' . intval($cho_4) . ',' . intval($cho_5) . ',' . intval($cho_6) . ',' . intval($cho_7) . ',' . intval($cho_8) . ',' . intval($cho_9) . ',' . intval($cho_10) . ',' . intval($cho_11) . ',' . intval($cho_12),
			'data_vanchuyen' => intval($vanchuyen_1) . ',' . intval($vanchuyen_2) . ',' . intval($vanchuyen_3) . ',' . intval($vanchuyen_4) . ',' . intval($vanchuyen_5) . ',' . intval($vanchuyen_6) . ',' . intval($vanchuyen_7) . ',' . intval($vanchuyen_8) . ',' . intval($vanchuyen_9) . ',' . intval($vanchuyen_10) . ',' . intval($vanchuyen_11) . ',' . intval($vanchuyen_12),
			'data_huy' => intval($huy_1) . ',' . intval($huy_2) . ',' . intval($huy_3) . ',' . intval($huy_4) . ',' . intval($huy_5) . ',' . intval($huy_6) . ',' . intval($huy_7) . ',' . intval($huy_8) . ',' . intval($huy_9) . ',' . intval($huy_10) . ',' . intval($huy_11) . ',' . intval($huy_12),
			'data_hoan' => intval($hoan_1) . ',' . intval($hoan_2) . ',' . intval($hoan_3) . ',' . intval($hoan_4) . ',' . intval($hoan_5) . ',' . intval($hoan_6) . ',' . intval($hoan_7) . ',' . intval($hoan_8) . ',' . intval($hoan_9) . ',' . intval($hoan_10) . ',' . intval($hoan_11) . ',' . intval($hoan_12),
			'data_tiepnhan' => intval($tiepnhan_1) . ',' . intval($tiepnhan_2) . ',' . intval($tiepnhan_3) . ',' . intval($tiepnhan_4) . ',' . intval($tiepnhan_5) . ',' . intval($tiepnhan_6) . ',' . intval($tiepnhan_7) . ',' . intval($tiepnhan_8) . ',' . intval($tiepnhan_9) . ',' . intval($tiepnhan_10) . ',' . intval($tiepnhan_11) . ',' . intval($tiepnhan_12),
			'data_yeucau_huy' => intval($yeucau_huy_1) . ',' . intval($yeucau_huy_2) . ',' . intval($yeucau_huy_3) . ',' . intval($yeucau_huy_4) . ',' . intval($yeucau_huy_5) . ',' . intval($yeucau_huy_6) . ',' . intval($yeucau_huy_7) . ',' . intval($yeucau_huy_8) . ',' . intval($yeucau_huy_9) . ',' . intval($yeucau_huy_10) . ',' . intval($yeucau_huy_11) . ',' . intval($yeucau_huy_12),
			'data_hoanthanh' => intval($hoanthanh_1) . ',' . intval($hoanthanh_2) . ',' . intval($hoanthanh_3) . ',' . intval($hoanthanh_4) . ',' . intval($hoanthanh_5) . ',' . intval($hoanthanh_6) . ',' . intval($hoanthanh_7) . ',' . intval($hoanthanh_8) . ',' . intval($hoanthanh_9) . ',' . intval($hoanthanh_10) . ',' . intval($hoanthanh_11) . ',' . intval($hoanthanh_12),
		);
		return json_encode($info);
	}
	///////////////////
	function thongke_donhang_thang($conn, $thang, $nam, $dau, $cuoi) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$thongtin = mysqli_query($conn, "SELECT * FROM donhang WHERE date_post>='$dau' AND date_post<='$cuoi'");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$ngay = date('d', $r_tt['date_post']);
			$ngay = intval($ngay);
			if ($thang == 2) {
				if (checkdate(02, 29, $nam) == true) {
					for ($i = 1; $i <= 29; $i++) {
						if ($ngay == $i) {
							$data_ngay[$i]++;
							if ($r_tt['status'] == 0) {
								$cho[$i]++;
							} else if ($r_tt['status'] == 1) {
								$tiepnhan[$i]++;
							} else if ($r_tt['status'] == 2) {
								$vanchuyen[$i]++;
							} else if ($r_tt['status'] == 3) {
								$yeucau_huy[$i]++;
							} else if ($r_tt['status'] == 4) {
								$huy[$i]++;
							} else if ($r_tt['status'] == 4) {
								$hoanthanh[$i]++;
							} else if ($r_tt['status'] == 6) {
								$hoan[$i]++;
							}
						}
					}
				} else {
					for ($i = 1; $i <= 28; $i++) {
						if ($ngay == $i) {
							$data_ngay[$i]++;
							if ($r_tt['status'] == 0) {
								$cho[$i]++;
							} else if ($r_tt['status'] == 1) {
								$tiepnhan[$i]++;
							} else if ($r_tt['status'] == 2) {
								$vanchuyen[$i]++;
							} else if ($r_tt['status'] == 3) {
								$yeucau_huy[$i]++;
							} else if ($r_tt['status'] == 4) {
								$huy[$i]++;
							} else if ($r_tt['status'] == 4) {
								$hoanthanh[$i]++;
							} else if ($r_tt['status'] == 6) {
								$hoan[$i]++;
							}
						}
					}

				}
			} else if (in_array($thang, array('1', '3', '5', '7', '8', '10', '12')) == true) {
				for ($i = 1; $i <= 31; $i++) {
					if ($ngay == $i) {
						$data_ngay[$i]++;
						if ($r_tt['status'] == 0) {
							$cho[$i]++;
						} else if ($r_tt['status'] == 1) {
							$tiepnhan[$i]++;
						} else if ($r_tt['status'] == 2) {
							$vanchuyen[$i]++;
						} else if ($r_tt['status'] == 3) {
							$yeucau_huy[$i]++;
						} else if ($r_tt['status'] == 4) {
							$huy[$i]++;
						} else if ($r_tt['status'] == 4) {
							$hoanthanh[$i]++;
						} else if ($r_tt['status'] == 6) {
							$hoan[$i]++;
						}
					}
				}
			} else {
				for ($i = 1; $i <= 30; $i++) {
					if ($ngay == $i) {
						$data_ngay[$i]++;
						if ($r_tt['status'] == 0) {
							$cho[$i]++;
						} else if ($r_tt['status'] == 1) {
							$tiepnhan[$i]++;
						} else if ($r_tt['status'] == 2) {
							$vanchuyen[$i]++;
						} else if ($r_tt['status'] == 3) {
							$yeucau_huy[$i]++;
						} else if ($r_tt['status'] == 4) {
							$huy[$i]++;
						} else if ($r_tt['status'] == 4) {
							$hoanthanh[$i]++;
						} else if ($r_tt['status'] == 6) {
							$hoan[$i]++;
						}
					}
				}

			}

		}
		if ($thang == 2) {
			if (checkdate(02, 29, $nam) == true) {
				for ($i = 1; $i <= 29; $i++) {
					$data_thang .= intval($data_ngay[$i]) . ',';
					$data_hoanthanh_thang .= intval($hoanthanh[$i]) . ',';
					$data_vanchuyen_thang .= intval($vanchuyen[$i]) . ',';
					$data_huy_thang .= intval($huy[$i]) . ',';
					$data_yeucau_huy_thang .= intval($yeucau_huy[$i]) . ',';
					$data_tiepnhan_thang .= intval($tiepnhan[$i]) . ',';
					$data_hoan_thang .= intval($hoan[$i]) . ',';
					$data_cho_thang .= intval($cho[$i]) . ',';
				}
			} else {
				for ($i = 1; $i <= 28; $i++) {
					$data_thang .= intval($data_ngay[$i]) . ',';
					$data_hoanthanh_thang .= intval($hoanthanh[$i]) . ',';
					$data_vanchuyen_thang .= intval($vanchuyen[$i]) . ',';
					$data_yeucau_huy_thang .= intval($yeucau_huy[$i]) . ',';
					$data_tiepnhan_thang .= intval($tiepnhan[$i]) . ',';
					$data_huy_thang .= intval($huy[$i]) . ',';
					$data_hoan_thang .= intval($hoan[$i]) . ',';
					$data_cho_thang .= intval($cho[$i]) . ',';
				}

			}
		} else if (in_array($thang, array('1', '3', '5', '7', '8', '10', '12')) == true) {
			for ($i = 1; $i <= 31; $i++) {
				$data_thang .= intval($data_ngay[$i]) . ',';
				$data_hoanthanh_thang .= intval($hoanthanh[$i]) . ',';
				$data_vanchuyen_thang .= intval($vanchuyen[$i]) . ',';
				$data_yeucau_huy_thang .= intval($yeucau_huy[$i]) . ',';
				$data_tiepnhan_thang .= intval($tiepnhan[$i]) . ',';
				$data_huy_thang .= intval($huy[$i]) . ',';
				$data_hoan_thang .= intval($hoan[$i]) . ',';
				$data_cho_thang .= intval($cho[$i]) . ',';
			}
		} else {
			for ($i = 1; $i <= 30; $i++) {
				$data_thang .= intval($data_ngay[$i]) . ',';
				$data_hoanthanh_thang .= intval($hoanthanh[$i]) . ',';
				$data_vanchuyen_thang .= intval($vanchuyen[$i]) . ',';
				$data_yeucau_huy_thang .= intval($yeucau_huy[$i]) . ',';
				$data_tiepnhan_thang .= intval($tiepnhan[$i]) . ',';
				$data_huy_thang .= intval($huy[$i]) . ',';
				$data_hoan_thang .= intval($hoan[$i]) . ',';
				$data_cho_thang .= intval($cho[$i]) . ',';
			}

		}
		$data_thang = substr($data_thang, 0, -1);
		$data_hoanthanh_thang = substr($data_hoanthanh_thang, 0, -1);
		$data_vanchuyen_thang = substr($data_vanchuyen_thang, 0, -1);
		$data_huy_thang = substr($data_huy_thang, 0, -1);
		$data_yeucau_huy_thang = substr($data_yeucau_huy_thang, 0, -1);
		$data_tiepnhan_thang = substr($data_tiepnhan_thang, 0, -1);
		$data_hoan_thang = substr($data_hoan_thang, 0, -1);
		$data_cho_thang = substr($data_cho_thang, 0, -1);
		$info = array(
			'data_thang' => $data_thang,
			'data_hoanthanh_thang' => $data_hoanthanh_thang,
			'data_vanchuyen_thang' => $data_vanchuyen_thang,
			'data_huy_thang' => $data_huy_thang,
			'data_yeucau_huy_thang' => $data_yeucau_huy_thang,
			'data_tiepnhan_thang' => $data_tiepnhan_thang,
			'data_hoan_thang' => $data_hoan_thang,
			'data_cho_thang' => $data_cho_thang,
		);
		return json_encode($info);
	}
	///////////////////
	function thongke_doanhthu_nhom($conn, $thanhvien, $dau, $cuoi) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$thongtin = mysqli_query($conn, "SELECT * FROM donhang WHERE user_id IN ($thanhvien) AND date_post>='$dau' AND date_post<='$cuoi'");
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
			'donhang_cho' => $cho,
			'donhang_tiepnhan' => $tiepnhan,
			'doanhthu_vanchuyen' => $doanhthu_vanchuyen,
			'donhang_huy' => $huy,
			'doanhthu_huy' => $doanhthu_huy,
			'donhang_hoan' => $hoan,
			'doanhthu_hoan' => $doanhthu_hoan,
			'doanhthu_cho' => $doanhthu_cho,
			'doanhthu_tiepnhan' => $doanhthu_tiepnhan,
		);
		return json_encode($info);
	}
	///////////////////
	function thongke_doanhthu($conn, $dau, $cuoi) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$thongtin = mysqli_query($conn, "SELECT * FROM donhang WHERE date_post>='$dau' AND date_post<='$cuoi'");
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
	function thongke_drop($conn, $dau, $cuoi) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$thongtin = mysqli_query($conn, "SELECT donhang.*,user_info.name,user_info.username,user_info.mobile,user_info.user_money,user_info.user_money2 FROM donhang INNER JOIN user_info ON user_info.user_id=donhang.user_id WHERE donhang.date_post>='$dau' AND donhang.date_post<='$cuoi'");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$user_id = $r_tt['user_id'];
			$list[$user_id]['name'] = $r_tt['name'];
			$list[$user_id]['username'] = $r_tt['username'];
			$list[$user_id]['user_id'] = $r_tt['user_id'];
			$list[$user_id]['mobile'] = $r_tt['mobile'];
			$list[$user_id]['total_donhang']++;
			if ($r_tt['status'] == 0 OR $r_tt['status'] == 1 OR $r_tt['status'] == 2 OR $r_tt['status'] == 5) {
				$list[$user_id]['total_doanhso'] += $r_tt['tongtien'];
			} else {
				$list[$user_id]['total_doanhso'] += 0;
			}
		}
		//arsort($list);
		$i = count((array)$list);
		foreach ($list as $key => $value) {
			$value['i'] = $i;
			$i--;
			$value['total_doanhso'] = number_format($value['total_doanhso']);
			$list_thanhvien .= $skin->skin_replace('skin_cpanel/box_action/tr_thongke_drop', $value);
		}
		return $list_thanhvien;
	}
	///////////////////
	function thongke_ctv($conn, $dau, $cuoi) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $total + 1;
		$thongtin = mysqli_query($conn, "SELECT donhang_ctv.*,user_info.name,user_info.username,user_info.mobile,user_info.user_money,user_info.user_money2 FROM donhang_ctv INNER JOIN user_info ON user_info.user_id=donhang_ctv.user_id WHERE donhang_ctv.date_post>='$dau' AND donhang_ctv.date_post<='$cuoi'");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$user_id = $r_tt['user_id'];
			$list[$user_id]['name'] = $r_tt['name'];
			$list[$user_id]['username'] = $r_tt['username'];
			$list[$user_id]['user_id'] = $r_tt['user_id'];
			$list[$user_id]['mobile'] = $r_tt['mobile'];
			$list[$user_id]['total_donhang']++;
			if ($r_tt['status'] == 0 OR $r_tt['status'] == 1 OR $r_tt['status'] == 2 OR $r_tt['status'] == 5) {
				$list[$user_id]['total_doanhso'] += $r_tt['tongtien'];
			} else {
				$list[$user_id]['total_doanhso'] += 0;
			}
		}
		$i = count((array)$list);
		foreach ($list as $key => $value) {
			$value['i'] = $i;
			$i--;
			$value['total_doanhso'] = number_format($value['total_doanhso']);
			$list_thanhvien .= $skin->skin_replace('skin_cpanel/box_action/tr_thongke_drop', $value);
		}
		return $list_thanhvien;
	}
	///////////////////
	function thongke_muaweb($conn, $dau, $cuoi) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$thongtin = mysqli_query($conn, "SELECT lichsu_chitieu.*,user_info.name,user_info.username,user_info.mobile FROM lichsu_chitieu INNER JOIN user_info ON user_info.user_id=lichsu_chitieu.user_id WHERE lichsu_chitieu.date_post>='$dau' AND lichsu_chitieu.date_post<='$cuoi' AND noidung LIKE '%Cài đặt giao diện%' ORDER BY lichsu_chitieu.date_post DESC");
		$total = mysqli_num_rows($thongtin);
		$i = $total;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$tongtien += $r_tt['sotien'];
			$r_tt['i'] = $i;
			$i--;
			$r_tt['date_post'] = date('H:i:s d/m/Y', $r_tt['date_post']);
			$r_tt['so_tien'] = number_format($r_tt['sotien']) . 'đ';
			$list_thanhvien .= $skin->skin_replace('skin_cpanel/box_action/tr_thongke_muaweb', $r_tt);
		}
		$info = array(
			'total' => $total,
			'tongtien' => $tongtien,
			'list' => $list_thanhvien,
		);
		return json_encode($info);
	}
	///////////////////
	function thongke_seeding($conn, $dau, $cuoi) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$thongtin = mysqli_query($conn, "SELECT * FROM mua_seeding_shopee WHERE date_post>='$dau' AND date_post<='$cuoi'");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$ngay = date('d', $r_tt['date_post']);
			$ngay = intval($ngay);
			if ($r_tt['status'] == 2) {
				$finish++;
				$doanhthu_finish += $r_tt['gia'];
			} else if ($r_tt['status'] == 1) {
				$run++;
				$doanhthu_run += $r_tt['gia'];
			} else if ($r_tt['status'] == 0) {
				$wait++;
				$doanhthu_wait += $r_tt['gia'];
			}
		}
		$info = array(
			'donhang_finish' => $finish,
			'doanhthu_finish' => $doanhthu_finish,
			'donhang_wait' => $wait,
			'doanhthu_wait' => $doanhthu_wait,
			'donhang_run' => $run,
			'doanhthu_run' => $doanhthu_run,
		);
		return json_encode($info);
	}
	///////////////////
	function list_kq_timkiem_sanpham($conn, $kho, $key) {
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
		$thongtin = mysqli_query($conn, "SELECT * FROM sanpham WHERE $where ORDER BY tieu_de ASC");
		$i = 0;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$r_tt['date_post'] = date('d/m/Y', $r_tt['date_post']);
			$r_tt['gia_cu'] = number_format($r_tt['gia_cu']);
			$r_tt['gia_moi'] = number_format($r_tt['gia_moi']);
			$r_tt['gia_drop'] = number_format($r_tt['gia_drop']);
			$r_tt['gia_ctv'] = number_format($r_tt['gia_ctv']);
			$r_tt['drop_min'] = number_format($r_tt['drop_min']);
			$r_tt['drop_max'] = number_format($r_tt['drop_max']);
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
			if ($kho == 'kho') {
				$r_tt['kho'] = $r_tt['kho'];
			} else if ($kho == 'kho_hcm') {
				$r_tt['kho'] = $r_tt['kho_hcm'];
			}
			$thongtin_share=mysqli_query($conn,"SELECT count(*) AS total FROM list_share_sanpham WHERE sp_id='{$r_tt['id']}'");
			$r_share=mysqli_fetch_assoc($thongtin_share);
			if($r_share['total']>0){
				$r_tt['bg_noidung']='bg_orange';
			}else{
				$r_tt['bg_noidung']='bg_violet';
			}
			$list .= $skin->skin_replace('skin_cpanel/box_action/tr_sanpham', $r_tt);
		}
		mysqli_free_result($thongtin);
		if ($i == 0) {
			$list = '<center>Không có kết quả</center>';
		}
		return $list;
	}
	///////////////////
	function list_kq_timkiem_sanpham_thuonghieu($conn, $kho, $thuong_hieu) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$thongtin = mysqli_query($conn, "SELECT * FROM sanpham WHERE thuong_hieu='$thuong_hieu' ORDER BY tieu_de ASC");
		$i = 0;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$r_tt['date_post'] = date('d/m/Y', $r_tt['date_post']);
			$r_tt['gia_cu'] = number_format($r_tt['gia_cu']);
			$r_tt['gia_moi'] = number_format($r_tt['gia_moi']);
			$r_tt['gia_drop'] = number_format($r_tt['gia_drop']);
			$r_tt['gia_ctv'] = number_format($r_tt['gia_ctv']);
			$r_tt['drop_min'] = number_format($r_tt['drop_min']);
			$r_tt['drop_max'] = number_format($r_tt['drop_max']);
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
			$thongtin_share=mysqli_query($conn,"SELECT count(*) AS total FROM list_share_sanpham WHERE sp_id='{$r_tt['id']}'");
			$r_share=mysqli_fetch_assoc($thongtin_share);
			if($r_share['total']>0){
				$r_tt['bg_noidung']='bg_orange';
			}else{
				$r_tt['bg_noidung']='bg_violet';
			}
			if ($kho == 'kho') {
				$r_tt['kho'] = $r_tt['kho'];
			} else if ($kho == 'kho_hcm') {
				$r_tt['kho'] = $r_tt['kho_hcm'];
			}
			$list .= $skin->skin_replace('skin_cpanel/box_action/tr_sanpham', $r_tt);
		}
		mysqli_free_result($thongtin);
		if ($i == 0) {
			$list = '<center>Không có kết quả</center>';
		}
		return $list;
	}
	///////////////////
	function list_kq_timkiem_sanpham_trend($conn, $kho, $key) {
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
		$thongtin = mysqli_query($conn, "SELECT sanpham.*,sanpham_trend.id AS id,sanpham_trend.gia FROM sanpham_trend INNER JOIN sanpham ON sanpham_trend.sp_id=sanpham.id WHERE $where ORDER BY sanpham_trend.id DESC");
		$i = 0;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$r_tt['date_post'] = date('d/m/Y', $r_tt['date_post']);
			$r_tt['gia_cu'] = number_format($r_tt['gia_cu']);
			$r_tt['gia_moi'] = number_format($r_tt['gia_moi']);
			$r_tt['gia_drop'] = number_format($r_tt['gia_drop']);
			$r_tt['drop_min'] = number_format($r_tt['drop_min']);
			$r_tt['drop_max'] = number_format($r_tt['drop_max']);
			$r_tt['gia'] = number_format($r_tt['gia']);
			if ($kho == 'kho') {
				$r_tt['kho'] = $r_tt['kho'];
			} else if ($kho == 'kho_hcm') {
				$r_tt['kho'] = $r_tt['kho_hcm'];
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
			$thongtin_share=mysqli_query($conn,"SELECT count(*) AS total FROM list_share_sanpham WHERE sp_id='{$r_tt['id']}'");
			$r_share=mysqli_fetch_assoc($thongtin_share);
			if($r_share['total']>0){
				$r_tt['bg_noidung']='bg_orange';
			}else{
				$r_tt['bg_noidung']='bg_violet';
			}
			$list .= $skin->skin_replace('skin_cpanel/box_action/tr_sanpham_trend', $r_tt);
		}
		mysqli_free_result($thongtin);
		if ($i == 0) {
			$list = '<center>Không có kết quả</center>';
		}
		return $list;
	}
	///////////////////
	function list_kq_timkiem_sanpham_tuan($conn, $kho, $key) {
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
		$thongtin = mysqli_query($conn, "SELECT sanpham.*,sanpham_tuan.id AS id,sanpham_tuan.gia_truoc,sanpham_tuan.gia_tuan,sanpham_tuan.gia_ctv_truoc,sanpham_tuan.gia_ctv_tuan,sanpham_tuan.time_start,sanpham_tuan.time_end FROM sanpham_tuan INNER JOIN sanpham ON sanpham_tuan.sp_id=sanpham.id WHERE $where ORDER BY sanpham_tuan.id DESC");
		$i = 0;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$r_tt['date_post'] = date('d/m/Y', $r_tt['date_post']);
			if($r_tt['gia_ctv_tuan']==0){
				$gia_ctv= $r_tt['gia_tuan'] + (($r_tt['drop_min'] - $r_tt['gia_tuan'])*0.3);
			}else{
				$gia_ctv= $r_tt['gia_ctv_tuan'];
			}
			if($r_tt['gia_ctv_truoc']==0){
				$gia_ctv_truoc= $r_tt['gia_truoc'] + (($r_tt['drop_min'] - $r_tt['gia_truoc'])*0.3);
			}else{
				$gia_ctv_truoc= $r_tt['gia_ctv_truoc'];
			}
			$r_tt['gia_cu'] = number_format($r_tt['gia_cu']);
			$r_tt['gia_moi'] = number_format($r_tt['gia_moi']);
			$r_tt['gia_drop'] = number_format($r_tt['gia_drop']);
			$r_tt['drop_min'] = number_format($r_tt['drop_min']);
			$r_tt['drop_max'] = number_format($r_tt['drop_max']);
			$r_tt['gia_ctv_truoc']=number_format($gia_ctv_truoc);
			$r_tt['gia_ctv_tuan']=number_format($gia_ctv);
			$r_tt['gia_truoc'] = number_format($r_tt['gia_truoc']);
			$r_tt['gia_tuan'] = number_format($r_tt['gia_tuan']);
			if ($kho == 'kho') {
				$r_tt['kho'] = $r_tt['kho'];
			} else if ($kho == 'kho_hcm') {
				$r_tt['kho'] = $r_tt['kho_hcm'];
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
			$thongtin_share=mysqli_query($conn,"SELECT count(*) AS total FROM list_share_sanpham WHERE sp_id='{$r_tt['id']}'");
			$r_share=mysqli_fetch_assoc($thongtin_share);
			if($r_share['total']>0){
				$r_tt['bg_noidung']='bg_orange';
			}else{
				$r_tt['bg_noidung']='bg_violet';
			}
			$list .= $skin->skin_replace('skin_cpanel/box_action/tr_sanpham_tuan', $r_tt);
		}
		mysqli_free_result($thongtin);
		if ($i == 0) {
			$list = '<center>Không có kết quả</center>';
		}
		return $list;
	}
	///////////////////
	function list_kq_timkiem_thanhvien_drop($conn, $key) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$thongtin = mysqli_query($conn, "SELECT * FROM user_info WHERE (username LIKE '%$key%' OR name LIKE '%$key%' OR email LIKE '%$key%' OR user_id='$key') AND dropship>'0' ORDER BY name ASC");
		$i = 0;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$r_tt['sodu'] = $r_tt['user_money'] + $r_tt['user_money2'];
			$r_tt['sodu'] = number_format($r_tt['sodu']);
			$r_tt['user_money'] = number_format($r_tt['user_money']);
			$r_tt['user_money2'] = number_format($r_tt['user_money2']);
			$r_tt['created'] = date('d/m/Y', $r_tt['created']);
			if($r_tt['aff']>0){
				$thongtin_quanly=mysqli_query($conn,"SELECT * FROM user_info WHERE user_id='{$r_tt['aff']}'");
				$r_ql=mysqli_fetch_assoc($thongtin_quanly);
				$r_tt['nguoi_quanly']=$r_ql['name'];
			}else{
				$r_tt['nguoi_quanly']='<button class="show_quanly" user_id="'.$r_tt['user_id'].'">Thêm quản lý</button>';
			}
			if($r_tt['leader']==1){
				$r_tt['leader']='Có';
			}else{
				$r_tt['leader']='Không';
			}
			if ($r_tt['dropship'] == 2) {
				$r_tt['tinh_trang'] = '<input type="radio" name="drop_' . $r_tt['user_id'] . '" value="2" checked> chờ duyệt <input type="radio" name="drop_' . $r_tt['user_id'] . '" value="3"> Từ chối <input type="radio" value="1" name="drop_' . $r_tt['user_id'] . '">Duyệt <input type="radio" value="4" name="drop_' . $r_tt['user_id'] . '">Tạm khóa';
			} else if ($r_tt['dropship'] == 3) {
				$r_tt['tinh_trang'] = '<input type="radio" name="drop_' . $r_tt['user_id'] . '" value="2"> chờ duyệt <input type="radio" name="drop_' . $r_tt['user_id'] . '" value="3" checked> Từ chối <input type="radio" value="1" name="drop_' . $r_tt['user_id'] . '">Duyệt <input type="radio" value="4" name="drop_' . $r_tt['user_id'] . '">Tạm khóa ';
			} else if ($r_tt['dropship'] == 4) {
				$r_tt['tinh_trang'] = '<input type="radio" name="drop_' . $r_tt['user_id'] . '" value="2"> chờ duyệt <input type="radio" name="drop_' . $r_tt['user_id'] . '" value="3"> Từ chối <input type="radio" value="1" name="drop_' . $r_tt['user_id'] . '">Duyệt <input type="radio" value="4" name="drop_' . $r_tt['user_id'] . '" checked>Tạm khóa ';
			} else if ($r_tt['dropship'] == 1) {
				$r_tt['tinh_trang'] = '<input type="radio" name="drop_' . $r_tt['user_id'] . '" value="2"> chờ duyệt <input type="radio" name="drop_' . $r_tt['user_id'] . '" value="3"> Từ chối <input type="radio" value="1" name="drop_' . $r_tt['user_id'] . '" checked>Duyệt <input type="radio" value="4" name="drop_' . $r_tt['user_id'] . '">Tạm khóa';
			} else {
			}
			$list .= $skin->skin_replace('skin_cpanel/box_action/tr_thanhvien_drop', $r_tt);
		}
		mysqli_free_result($thongtin);
		if ($i == 0) {
			$list = '<center>Không có kết quả</center>';
		}
		return $list;
	}
	////////////////////
	function list_kq_timkiem_bom($conn, $key) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $start;
		$thongtin = mysqli_query($conn, "SELECT bom_hang.*,user_info.username FROM bom_hang LEFT JOIN user_info ON bom_hang.user_id=user_info.user_id WHERE bom_hang.ho_ten LIKE '%$key%' OR bom_hang.dien_thoai LIKE '%$key%' OR bom_hang.dia_chi LIKE '%$key%' ORDER BY bom_hang.id DESC");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$r_tt['date_post'] = date('H:i:s d/m/Y', $r_tt['date_post']);
			$list .= $skin->skin_replace('skin_cpanel/box_action/tr_bom', $r_tt);
		}
		return $list;
	}
	///////////////////
	function list_kq_timkiem_thanhvien($conn, $key) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$thongtin = mysqli_query($conn, "SELECT * FROM user_info WHERE username LIKE '%$key%' OR name LIKE '%$key%' OR email LIKE '%$key%' OR user_id='$key' OR mobile LIKE '%$key%' ORDER BY name ASC");
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
			$list .= $skin->skin_replace('skin_cpanel/box_action/tr_thanhvien', $r_tt);
		}
		mysqli_free_result($thongtin);
		if ($i == 0) {
			$list = '<center>Không có kết quả</center>';
		}
		return $list;
	}
	///////////////////
	function list_kq_timkiem_thanhvien_nhom($conn, $nhomtruong, $nhom, $key) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$tach_nhomtruong = explode(',', $nhomtruong);
		$thongtin = mysqli_query($conn, "SELECT *,(SELECT count(*) FROM donhang d WHERE d.user_id=u.user_id AND d.status!='3' AND d.status!='4') AS total_donhang,(SELECT sum(tongtien) FROM donhang d WHERE d.user_id=u.user_id AND d.status!='3' AND d.status!='4') AS total_doanhso FROM user_info u WHERE (username LIKE '%$key%' OR name LIKE '%$key%' OR email LIKE '%$key%' OR user_id='$key' OR mobile LIKE '%$key%') AND nhom='$nhom' ORDER BY user_id ASC");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			if (in_array($r_tt['user_id'], $tach_nhomtruong) == true) {
				$r_tt['vaitro'] = '<select class="select_vaitro" user_id="' . $r_tt['user_id'] . '" nhom="' . $nhom . '"><option value="1" selected>Trưởng nhóm</option><option value="0">Thành viên</option></select>';
			} else {
				$r_tt['vaitro'] = '<select class="select_vaitro" user_id="' . $r_tt['user_id'] . '" nhom="' . $nhom . '"><option value="1">Trưởng nhóm</option><option value="0" selected>Thành viên</option></select>';
			}
			$r_tt['nhom'] = $nhom;
			$r_tt['total_doanhso'] = number_format($r_tt['total_doanhso']) . ' đ';
			$r_tt['total_donhang'] = number_format($r_tt['total_donhang']);
			$list .= $skin->skin_replace('skin_cpanel/box_action/tr_thanhvien_nhom', $r_tt);
		}
		mysqli_free_result($thongtin);
		if ($i == 0) {
			$list = '<center>Không có kết quả</center>';
		}
		return $list;
	}
	////////////////////
	function list_kq_timkiem_donhang($conn, $key) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $start;
		$thongtin = mysqli_query($conn, "SELECT donhang.*,user_info.name,user_info.mobile FROM donhang LEFT JOIN user_info ON donhang.user_id=user_info.user_id WHERE donhang.ma_don LIKE '%$key%' OR donhang.ho_ten LIKE '%$key%' OR donhang.email LIKE '%$key%' OR donhang.dien_thoai LIKE '%$key%' ORDER BY date_post DESC");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$r_tt['tongtien'] = number_format($r_tt['tongtien']) . 'đ';
			$r_tt['date_post'] = date('d/m/Y', $r_tt['date_post']);
			if ($r_tt['status'] == 1) {
				$r_tt['status'] = 'Đã tiếp nhận đơn';
			} else if ($r_tt['status'] == 2) {
				$r_tt['status'] = 'Đã giao đơn vị vận chuyển';
			} else if ($r_tt['status'] == 3) {
				$r_tt['status'] = 'Yêu cầu hủy đơn Drop';
			} else if ($r_tt['status'] == 4) {
				$r_tt['status'] = 'Xác nhận hủy đơn';
			} else if ($r_tt['status'] == 5) {
				$r_tt['status'] = 'Giao thành công';
			} else if ($r_tt['status'] == 6) {
				$r_tt['status'] = 'Đã hoàn đơn';
			} else {
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
			$list .= $skin->skin_replace('skin_cpanel/box_action/tr_donhang', $r_tt);
		}
		return $list;
	}
	////////////////////
	function list_kq_timkiem_donhang_ctv($conn, $key) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $start;
		$thongtin = mysqli_query($conn, "SELECT donhang_ctv.*,user_info.name,user_info.mobile FROM donhang_ctv LEFT JOIN user_info ON donhang_ctv.user_id=user_info.user_id WHERE donhang_ctv.ma_don LIKE '%$key%' OR donhang_ctv.ho_ten LIKE '%$key%' OR donhang_ctv.email LIKE '%$key%' OR donhang_ctv.dien_thoai LIKE '%$key%' ORDER BY date_post DESC");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$r_tt['tongtien'] = number_format($r_tt['tongtien']) . 'đ';
			$r_tt['date_post'] = date('d/m/Y', $r_tt['date_post']);
			if ($r_tt['status'] == 1) {
				$r_tt['status'] = 'Đã tiếp nhận đơn';
			} else if ($r_tt['status'] == 2) {
				$r_tt['status'] = 'Đã giao đơn vị vận chuyển';
			} else if ($r_tt['status'] == 3) {
				$r_tt['status'] = 'Yêu cầu hủy đơn Drop';
			} else if ($r_tt['status'] == 4) {
				$r_tt['status'] = 'Xác nhận hủy đơn';
			} else if ($r_tt['status'] == 5) {
				$r_tt['status'] = 'Giao thành công';
			} else if ($r_tt['status'] == 6) {
				$r_tt['status'] = 'Đã hoàn đơn';
			} else {
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
			$list .= $skin->skin_replace('skin_cpanel/box_action/tr_donhang_ctv', $r_tt);
		}
		return $list;
	}
//////////////////////////////////////////////////////////////////
	function list_setting($conn, $page, $limit) {
		$tlca_skin_cpanel = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $start;
		$thongtin = mysqli_query($conn, "SELECT * FROM index_setting ORDER BY name DESC LIMIT $start,$limit");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$r_tt['value'] = $check->words($r_tt['value'], 200);
			$list .= $tlca_skin_cpanel->skin_replace('skin_cpanel/box_action/tr_setting', $r_tt);
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
