 <?php
class class_ctv extends class_manage {
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
			$list .= $skin->skin_replace('skin_ctv/box_action/tr_menu', $r_tt);
		}
		return $list;
	}
    ////////////////////
    function list_dat_live($conn,$user_id,$total,$page,$limit){
        $skin=$this->load('class_skin_cpanel');
        $check=$this->load('class_check');
        $start=$page*$limit - $limit;
        $i=$total - $start + 1;
        $thongtin=mysqli_query($conn,"SELECT dat_live.*,idol.ho_ten FROM dat_live LEFT JOIN idol ON dat_live.idol=idol.id WHERE dat_live.user_id='$user_id' ORDER BY dat_live.id DESC LIMIT $start,$limit");
        while($r_tt=mysqli_fetch_assoc($thongtin)){
            $i--;
            $r_tt['i']=$i;
            $r_tt['date_post']=date('H:i:s d/m/Y',$r_tt['date_post']);
            if($r_tt['status']==1){
                $r_tt['status']='Hoàn thành';
            }else if($r_tt['status']==2){
                $r_tt['status']='Đã hủy';
            }else if($r_tt['status']==3){
                $r_tt['status']='Đã xác nhận';
            }else{
                $r_tt['status']='Chờ xử lý';
            }
            $r_tt['ngan_sach']=number_format($r_tt['ngan_sach']);
            $r_tt['khung_gio']=str_replace(':', 'h', $r_tt['khung_gio']);
            $list.=$skin->skin_replace('skin_ctv/box_action/tr_livestream',$r_tt);
        }
        return $list;
    }
    ////////////////////
    function list_bom($conn,$user_id,$page,$limit){
        $skin=$this->load('class_skin_cpanel');
        $check=$this->load('class_check');
        $start=$page*$limit - $limit;
        $i=$start;
        $thongtin=mysqli_query($conn,"SELECT bom_hang.*,user_info.username FROM bom_hang LEFT JOIN user_info ON bom_hang.user_id=user_info.user_id ORDER BY bom_hang.id DESC LIMIT $start,$limit");
        while($r_tt=mysqli_fetch_assoc($thongtin)){
            $i++;
            $r_tt['i']=$i;
            $r_tt['date_post']=date('H:i:s d/m/Y',$r_tt['date_post']);
            if($r_tt['user_id']==0){
            	$r_tt['username']='Quản trị';
            	$r_tt['action']='';
            }else if($r_tt['user_id']==$user_id){
            	$r_tt['action']='<a href="/ctv/edit-bom?id='.$r_tt['id'].'" class="edit">Sửa</a><a href="javascript:;" onclick="confirm_del(\'del\',\'bom\', \'Xác nhận xóa bom hàng\', \''.$r_tt['id'].'\');" class="del">Xóa</a>';
            }else{
            	$r_tt['action']='';
            }
            $list.=$skin->skin_replace('skin_ctv/box_action/tr_bom',$r_tt);
        }
        return $list;
    }
    ////////////////////
    function list_kq_timkiem_bom($conn,$user_id,$key){
        $skin=$this->load('class_skin_cpanel');
        $check=$this->load('class_check');
        $start=$page*$limit - $limit;
        $i=$start;
        $thongtin=mysqli_query($conn,"SELECT bom_hang.*,user_info.username FROM bom_hang LEFT JOIN user_info ON bom_hang.user_id=user_info.user_id WHERE bom_hang.ho_ten LIKE '%$key%' OR bom_hang.dien_thoai LIKE '%$key%' OR bom_hang.dia_chi LIKE '%$key%' ORDER BY bom_hang.id DESC");
        while($r_tt=mysqli_fetch_assoc($thongtin)){
            $i++;
            $r_tt['i']=$i;
            $r_tt['date_post']=date('H:i:s d/m/Y',$r_tt['date_post']);
            if($r_tt['user_id']==0){
            	$r_tt['username']='Quản trị';
            	$r_tt['action']='';
            }else if($r_tt['user_id']==$user_id){
            	$r_tt['action']='<a href="/ctv/edit-bom?id='.$r_tt['id'].'" class="edit">Sửa</a><a href="javascript:;" onclick="confirm_del(\'del\',\'bom\', \'Xác nhận xóa bom hàng\', \''.$r_tt['id'].'\');" class="del">Xóa</a>';
            }
            $list.=$skin->skin_replace('skin_ctv/box_action/tr_bom',$r_tt);
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
			$list .= $skin->skin_replace('skin_ctv/box_action/tr_thanhvien_nhom', $r_tt);
		}
		return $list;
	}
    ///////////////////
    function thongke_doanhthu($conn,$user_id,$dau,$cuoi){
        $skin=$this->load('class_skin_cpanel');
        $check=$this->load('class_check');
        $start=$page*$limit - $limit;
        $thongtin=mysqli_query($conn,"SELECT * FROM donhang_ctv WHERE user_id='$user_id' AND date_post>='$dau' AND date_post<='$cuoi'");
        while ($r_tt=mysqli_fetch_assoc($thongtin)) {
            $ngay=date('d',$r_tt['date_post']);
            $ngay=intval($ngay);
            if($r_tt['status']==6){
                $hoan++;
                $doanhthu_hoan+=$r_tt['cod'];
            }else if($r_tt['status']==5){
                $hoanthanh++;
                $doanhthu_hoanthanh+=$r_tt['cod'];
            }else if($r_tt['status']==4){
                $huy++;
                $doanhthu_huy+=$r_tt['cod'];
            }else if($r_tt['status']==3){
                $yeucau_huy++;
                $doanhthu_yeucau_huy+=$r_tt['cod'];
            }else if($r_tt['status']==2){
                $vanchuyen++;
                $doanhthu_vanchuyen+=$r_tt['cod'];
            }else if($r_tt['status']==1){
                $tiepnhan++;
                $doanhthu_tiepnhan+=$r_tt['cod'];
            }else if($r_tt['status']==0){
                $cho++;
                $doanhthu_cho+=$r_tt['cod'];
            }
        }
        $info=array(
            'donhang_hoanthanh'=>$hoanthanh,
            'doanhthu_hoanthanh'=>$doanhthu_hoanthanh,
            'donhang_vanchuyen'=>$vanchuyen,
            'doanhthu_vanchuyen'=>$doanhthu_vanchuyen,
            'donhang_huy'=>$huy,
            'doanhthu_huy'=>$doanhthu_huy,
            'donhang_hoan'=>$hoan,
            'doanhthu_hoan'=>$doanhthu_hoan,
            'donhang_cho'=>$cho,
            'doanhthu_cho'=>$doanhthu_cho,
            'donhang_yeucau_huy'=>$yeucau_huy,
            'doanhthu_yeucau_huy'=>$doanhthu_yeucau_huy,
            'donhang_tiepnhan'=>$tiepnhan,
            'doanhthu_tiepnhan'=>$doanhthu_tiepnhan
        );
        return json_encode($info);
    }
    ///////////////////
    function thongke_hoahong($conn,$user_id,$dau,$cuoi){
        $skin=$this->load('class_skin_cpanel');
        $check=$this->load('class_check');
        $start=$page*$limit - $limit;
        $thongtin=mysqli_query($conn,"SELECT * FROM donhang_ctv WHERE user_id='$user_id' AND date_post>='$dau' AND date_post<='$cuoi'");
        while ($r_tt=mysqli_fetch_assoc($thongtin)) {
            $ngay=date('d',$r_tt['date_post']);
            $ngay=intval($ngay);
            if($r_tt['status']==6){
                $hoan++;
                $doanhthu_hoan+=$r_tt['hoahong'];
            }else if($r_tt['status']==5){
                $hoanthanh++;
                $doanhthu_hoanthanh+=$r_tt['hoahong'];
            }else if($r_tt['status']==4){
                $huy++;
                $doanhthu_huy+=$r_tt['hoahong'];
            }else if($r_tt['status']==3){
                $yeucau_huy++;
                $doanhthu_yeucau_huy+=$r_tt['hoahong'];
            }else if($r_tt['status']==2){
                $vanchuyen++;
                $doanhthu_vanchuyen+=$r_tt['hoahong'];
            }else if($r_tt['status']==1){
                $tiepnhan++;
                $doanhthu_tiepnhan+=$r_tt['hoahong'];
            }else if($r_tt['status']==0){
                $cho++;
                $doanhthu_cho+=$r_tt['hoahong'];
            }
        }
        $info=array(
            'donhang_hoanthanh'=>$hoanthanh,
            'doanhthu_hoanthanh'=>$doanhthu_hoanthanh,
            'donhang_vanchuyen'=>$vanchuyen,
            'doanhthu_vanchuyen'=>$doanhthu_vanchuyen,
            'donhang_huy'=>$huy,
            'doanhthu_huy'=>$doanhthu_huy,
            'donhang_hoan'=>$hoan,
            'doanhthu_hoan'=>$doanhthu_hoan,
            'donhang_cho'=>$cho,
            'doanhthu_cho'=>$doanhthu_cho,
            'donhang_yeucau_huy'=>$yeucau_huy,
            'doanhthu_yeucau_huy'=>$doanhthu_yeucau_huy,
            'donhang_tiepnhan'=>$tiepnhan,
            'doanhthu_tiepnhan'=>$doanhthu_tiepnhan
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
			$list .= $skin->skin_replace('skin_ctv/box_action/tr_slide', $r_tt);
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
			$r_tt['blank'] = $check->blank($r_tt['post_tieude']);
			$i++;
			$r_tt['i'] = $i;
			if($r_tt['gia_cu']>$r_tt['gia_moi']){
				$r_tt['gia_cu']=number_format($r_tt['gia_cu']).'đ';
			}else{
				$r_tt['gia_cu']='';
			}
			if($r_tt['gia_moi']==0){
				$r_tt['gia_moi']='Miễn phí';
			}else{
				$r_tt['gia_moi']=number_format($r_tt['gia_moi']).'đ';
			}
			$list .= $skin->skin_replace('skin_ctv/box_action/tr_giaodien', $r_tt);
		}
		return $list;
	}
	////////////////////
	function list_video($conn, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $start;
		$thongtin = mysqli_query($conn, "SELECT * FROM video WHERE loai LIKE '%all%' OR loai LIKE '%ctv%' ORDER BY id DESC LIMIT $start,$limit");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$list .= $skin->skin_replace('skin_ctv/box_action/tr_video', $r_tt);
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
            $list .= $skin->skin_replace('skin_ctv/box_action/tr_idol', $r_tt);
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
			$list .= $skin->skin_replace('skin_ctv/box_action/tr_video', $r_tt);
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
            if(strpos($r_tt['sotien'], '-')!==false){
                $r_tt['sotien']=number_format($r_tt['sotien']);
            }else if($r_tt['truoc']<$r_tt['sau']){
                $r_tt['sotien']='<span class="color_red">+'.number_format($r_tt['sotien']).'</span>';
            }else if($r_tt['truoc']>$r_tt['sau']){
                $r_tt['sotien']='-'.number_format($r_tt['sotien']);
            }else{
                if(strpos($r_tt['noidung'], 'Đặt hàng drop')!==false){
                    $r_tt['sotien']='-'.number_format($r_tt['sotien']);
                }else if(strpos($r_tt['noidung'], 'Mua')!==false){
                    $r_tt['sotien']='-'.number_format($r_tt['sotien']);
                }else if(strpos($r_tt['noidung'], 'Cài đặt giao diện')!==false){
                    $r_tt['sotien']='-'.number_format($r_tt['sotien']);
                }else if(strpos($r_tt['noidung'], 'Đặt mua tên miền')!==false){
                    $r_tt['sotien']='-'.number_format($r_tt['sotien']);
                }else if(strpos($r_tt['noidung'], 'Yêu cầu hỗ trợ cài đặt tên miền')!==false){
                    $r_tt['sotien']='-'.number_format($r_tt['sotien']);
                }else if(strpos($r_tt['noidung'], 'hoàn')!==false){
                    $r_tt['sotien']='<span class="color_red">+'.number_format($r_tt['sotien']).'</span>';
                }else if(strpos($r_tt['noidung'], 'Hoàn')!==false){
                    $r_tt['sotien']='<span class="color_red">+'.number_format($r_tt['sotien']).'</span>';
                }else if(strpos($r_tt['noidung'], 'tặng')!==false){
                    $r_tt['sotien']='<span class="color_red">+'.number_format($r_tt['sotien']).'</span>';
                }else if(strpos($r_tt['noidung'], 'Tặng')!==false){
                    $r_tt['sotien']='<span class="color_red">+'.number_format($r_tt['sotien']).'</span>';
                }else if(strpos($r_tt['noidung'], 'thưởng')!==false){
                    $r_tt['sotien']='<span class="color_red">+'.number_format($r_tt['sotien']).'</span>';
                }else if(strpos($r_tt['noidung'], 'Thưởng')!==false){
                    $r_tt['sotien']='<span class="color_red">+'.number_format($r_tt['sotien']).'</span>';
                }else{
                    $r_tt['sotien']=number_format($r_tt['sotien']);
                }
            }
			//$r_tt['sotien'] = number_format($r_tt['sotien']) . ' đ';
			$list .= $skin->skin_replace('skin_ctv/box_action/tr_chitieu', $r_tt);
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
			} else {
				$r_tt['status'] = 'Chờ xử lý';
				$r_tt['hanhdong'] = '<a href="/ctv/edit-naptien?id=' . $r_tt['id'] . '" class="edit">chi tiết</a>';
			}
			$r_tt['noidung'] = 'naptien ' . $r_tt['username'] . ' ' . $r_tt['id'];
			$list .= $skin->skin_replace('skin_ctv/box_action/tr_naptien', $r_tt);
		}
		return $list;
	}
	////////////////////
	function list_domain($conn,$loai) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $start;
		$thongtin = mysqli_query($conn, "SELECT * FROM domain_price ORDER BY thu_tu ASC");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			if($loai=='all'){
				if($r_tt['loai']=='quocte'){
					$list .= '<div class="li_domain li_domain_quocte active"><input type="checkbox" name="loai_domain[]" value="'.$r_tt['domain'].'"> '.$r_tt['domain'].'</div>';
				}else{
					$list .= '<div class="li_domain li_domain_vietnam active"><input type="checkbox" name="loai_domain[]" value="'.$r_tt['domain'].'"> '.$r_tt['domain'].'</div>';
				}
			}else if($loai=='quocte'){
				if($r_tt['loai']=='quocte'){
					$list .= '<div class="li_domain li_domain_quocte active"><input type="checkbox" name="loai_domain[]" value="'.$r_tt['domain'].'"> '.$r_tt['domain'].'</div>';
				}else{
					$list .= '<div class="li_domain li_domain_vietnam"><input type="checkbox" name="loai_domain[]" value="'.$r_tt['domain'].'"> '.$r_tt['domain'].'</div>';
				}
			}else if($loai=='vietnam'){
				if($r_tt['loai']=='vietnam'){
					$list .= '<div class="li_domain li_domain_vietnam active"><input type="checkbox" name="loai_domain[]" value="'.$r_tt['domain'].'"> '.$r_tt['domain'].'</div>';
				}else{
					$list .= '<div class="li_domain li_domain_quocte"><input type="checkbox" name="loai_domain[]" value="'.$r_tt['domain'].'"> '.$r_tt['domain'].'</div>';
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
			$list .= $skin->skin_replace('skin_ctv/box_action/tr_ruttien', $r_tt);
		}
		return $list;
	}
    ////////////////////
    function list_goi_seeding($conn,$loai) {
        $skin = $this->load('class_skin_cpanel');
        $check = $this->load('class_check');
        $start = $page * $limit - $limit;
        $i = $start;
        $thongtin = mysqli_query($conn, "SELECT * FROM seeding_shopee WHERE loai='$loai' ORDER BY thu_tu ASC");
        while ($r_tt = mysqli_fetch_assoc($thongtin)) {
            $i++;
            if ($i % 2 == 0){
                $r_tt['class']='dt-light dt-center';
            }
            else {
                $r_tt['class']='dt-gray dt-center';
            }
            $tach_uudai=explode("\n", $r_tt['uu_dai']);
            foreach ($tach_uudai as $key => $value) {
                $list_uudai.='<tr><td>'.$value.'</td></tr>';
            }
            $r_tt['list_uudai']=$list_uudai;
            unset($list_uudai);
            $r_tt['i'] = $i;
            $r_tt['gia']=number_format($r_tt['gia']);
            if ($r_tt['loai'] == 'danh_gia') {
                $list .= $skin->skin_replace('skin_ctv/box_action/tr_goi_danhgia_shopee', $r_tt);
            } else {
                $list .= $skin->skin_replace('skin_ctv/box_action/tr_goi_follow_shopee', $r_tt);
            }
            
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
			$list .= $skin->skin_replace('skin_ctv/box_action/tr_coupon', $r_tt);
		}
		return $list;
	}
    ////////////////////
    function list_deal($conn,$shop,$page,$limit){
        $skin=$this->load('class_skin_cpanel');
        $check=$this->load('class_check');
        $start=$page*$limit - $limit;
        $i=$start;
        $thongtin=mysqli_query($conn,"SELECT * FROM deal WHERE shop='$shop' AND (loai='muakem' OR loai='tang') ORDER BY id DESC LIMIT $start,$limit");
        while($r_tt=mysqli_fetch_assoc($thongtin)){
            $i++;
            $r_tt['i']=$i;
            $r_tt['start']=date('H:i:s d/m/Y',$r_tt['date_start']);
            $r_tt['end']=date('H:i:s d/m/Y',$r_tt['date_end']);
            if($r_tt['loai']=='muakem'){
                $r_tt['loai']='Mua kèm deal sốc';
            }else if($r_tt['loai']=='tang'){
                $r_tt['loai']='Mua để nhận quà';
            }
            $list.=$skin->skin_replace('skin_ctv/box_action/tr_deal',$r_tt);
        }
        return $list;
    }
    ////////////////////
    function list_flash_sale($conn,$shop,$page,$limit){
        $skin=$this->load('class_skin_cpanel');
        $check=$this->load('class_check');
        $start=$page*$limit - $limit;
        $i=$start;
        $thongtin=mysqli_query($conn,"SELECT * FROM deal WHERE shop='$shop' AND loai='flash_sale' ORDER BY id DESC LIMIT $start,$limit");
        while($r_tt=mysqli_fetch_assoc($thongtin)){
            $i++;
            $r_tt['i']=$i;
            $r_tt['start']=date('H:i:s d/m/Y',$r_tt['date_start']);
            $r_tt['end']=date('H:i:s d/m/Y',$r_tt['date_end']);
            if($r_tt['loai']=='muakem'){
                $r_tt['loai']='Mua kèm deal sốc';
            }else if($r_tt['loai']=='tang'){
                $r_tt['loai']='Mua để nhận quà';
            }
            $list.=$skin->skin_replace('skin_ctv/box_action/tr_flash_sale',$r_tt);
        }
        return $list;
    }
	////////////////////
	function list_donhang_ctv($conn, $user_id, $page, $limit) {
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
				$r_tt['huy'] = '<a href="javascript:;" onclick="confirm_action(\'huy_donhang_ctv\', \'Hủy đơn hàng cộng tác viên\', \'' . $r_tt['id'] . '\')" class="del">hủy</a>';
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
			$list .= $skin->skin_replace('skin_ctv/box_action/tr_donhang_ctv', $r_tt);
		}
		return $list;
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
			$list .= $skin->skin_replace('skin_ctv/box_action/tr_donhang_shop', $r_tt);
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
			$list .= $skin->skin_replace('skin_ctv/box_action/tr_category', $r_tt);
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
			$list .= $skin->skin_replace('skin_ctv/box_action/tr_category_sanpham', $r_tt);
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
	function list_option_brand($conn,$shop, $id) {
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
    function list_option_size($conn,$shop, $id) {
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
    function list_div_main_category_sanpham($conn,$shop,$category){
        $tach_category=explode(',', $category);
        $thongtin=mysqli_query($conn,"SELECT * FROM category_sanpham_shop WHERE cat_main='0' AND shop='$shop' ORDER BY cat_main ASC,cat_thutu ASC");
        $total=0;
        while($r_tt=mysqli_fetch_assoc($thongtin)){
            $total++;
            if(in_array($r_tt['cat_id'], $tach_category)==true){
                $list.='<div class="li_input" id="input_'.$r_tt['cat_id'].'"><input type="checkbox" name="category[]" value="'.$r_tt['cat_id'].'" checked> '.$r_tt['cat_tieude'].'</div>';
                $list_id.=$r_tt['cat_id'].',';
            }else{
                $list.='<div class="li_input" id="input_'.$r_tt['cat_id'].'"><input type="checkbox" name="category[]" value="'.$r_tt['cat_id'].'"> '.$r_tt['cat_tieude'].'</div>';
            }
            
        }
        $list_id=substr($list_id, 0,-1);
        return json_encode(array('list'=>$list,'list_id'=>$list_id,'total'=>$total));
    }
    //////////////////////////////////////////////////////////////////
    function list_div_sub_category_sanpham($conn,$shop,$main,$category){
        $tach_category=explode(',', $category);
        $thongtin=mysqli_query($conn,"SELECT * FROM category_sanpham_shop WHERE cat_main IN ($main) AND shop='$shop' ORDER BY cat_main ASC,cat_thutu ASC");
        $total=0;
        while($r_tt=mysqli_fetch_assoc($thongtin)){
            $total++;
            if(in_array($r_tt['cat_id'], $tach_category)==true){
                $list_id.=$r_tt['cat_id'].',';
                $list.='<div class="li_input li_input_'.$r_tt['cat_main'].'" id="input_'.$r_tt['cat_id'].'"><input type="checkbox" name="category[]" main_id="'.$r_tt['cat_main'].'" value="'.$r_tt['cat_id'].'" checked> '.$r_tt['cat_tieude'].'</div>';
            }else{
                $list.='<div class="li_input li_input_'.$r_tt['cat_main'].'" id="input_'.$r_tt['cat_id'].'"><input type="checkbox" name="category[]" main_id="'.$r_tt['cat_main'].'" value="'.$r_tt['cat_id'].'"> '.$r_tt['cat_tieude'].'</div>';
            }
        }
        $list_id=substr($list_id, 0,-1);
        return json_encode(array('list'=>$list,'list_id'=>$list_id,'total'=>$total));
    }
    //////////////////////////////////////////////////////////////////
    function list_div_sub_sub_category_sanpham($conn,$shop,$main,$category){
        $tach_category=explode(',', $category);
        $thongtin=mysqli_query($conn,"SELECT *,(SELECT cat_main FROM category_sanpham_shop c WHERE category_sanpham.cat_main=c.cat_id) AS main_main FROM category_sanpham_shop WHERE cat_main IN ($main) AND shop='$shop' ORDER BY cat_main ASC,cat_thutu ASC");
        $total=0;
        while($r_tt=mysqli_fetch_assoc($thongtin)){
            $total++;
            if(in_array($r_tt['cat_id'], $tach_category)==true){
                $list_id.=$r_tt['cat_id'].',';
                $list.='<div class="li_input li_input_'.$r_tt['cat_main'].' li_input_main_'.$r_tt['main_main'].'" id="input_'.$r_tt['cat_id'].'"><input type="checkbox" name="category[]" value="'.$r_tt['cat_id'].'" checked> '.$r_tt['cat_tieude'].'</div>';
            }else{
                $list.='<div class="li_input li_input_'.$r_tt['cat_main'].' li_input_main_'.$r_tt['main_main'].'" id="input_'.$r_tt['cat_id'].'"><input type="checkbox" name="category[]" value="'.$r_tt['cat_id'].'"> '.$r_tt['cat_tieude'].'</div>';
            }
        }
        $list_id=substr($list_id, 0,-1);
        return json_encode(array('list'=>$list,'list_id'=>$list_id,'total'=>$total));
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
	function list_div_size_sanpham($conn,$shop, $size) {
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
	///////////////////
	function list_baiviet($conn, $shop, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$thongtin = mysqli_query($conn, "SELECT * FROM post_shop WHERE shop='$shop' ORDER BY id DESC LIMIT $start,$limit");
		$i = $start;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$list .= $skin->skin_replace('skin_ctv/box_action/tr_baiviet', $r_tt);
		}
		return $list;
	}
	///////////////////
	function list_thongbao($conn, $user_id, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$thongtin = mysqli_query($conn, "SELECT * FROM thongbao WHERE noi_dang LIKE '%all%' OR noi_dang LIKE '%ctv%' ORDER BY id DESC LIMIT $start,$limit");
		$i = $start;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$tach_doc=explode(',', $r_tt['doc']);
			if (in_array($user_id, $tach_doc)==true) {
				$r_tt['status'] = 'Đã đọc';
			} else {
				$r_tt['status'] = 'Chưa đọc';
			}
			$r_tt['date_post'] = date('d/m/Y', $r_tt['date_post']);
			$list .= $skin->skin_replace('skin_ctv/box_action/tr_thongbao', $r_tt);
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
            $tach_doc=explode(',', $r_tt['doc']);
            if (in_array($user_id, $tach_doc)==true) {
                $r_tt['status'] = 'Đã đọc';
            } else {
                $r_tt['status'] = 'Chưa đọc';
            }
            $r_tt['date_post'] = date('d/m/Y', $r_tt['date_post']);
            $list .= $skin->skin_replace('skin_ctv/box_action/tr_remarketing', $r_tt);
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
			$tach_doc=explode(',', $r_tt['doc']);
			if (in_array($user_id, $tach_doc)==true) {
				$r_tt['status'] = 'Đã đọc';
			} else {
				$r_tt['status'] = 'Chưa đọc';
			}
			$r_tt['date_post'] = date('d/m/Y', $r_tt['date_post']);
			$list .= $skin->skin_replace('skin_ctv/box_action/tr_thongbao_right', $r_tt);
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
			$list .= $skin->skin_replace('skin_ctv/box_action/tr_lienhe', $r_tt);
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
			$list .= $skin->skin_replace('skin_ctv/box_action/tr_nhantin', $r_tt);
		}
		return $list;
	}
    ///////////////////
    function list_sanpham_tuan($conn, $shop, $page, $limit) {
        $skin = $this->load('class_skin_cpanel');
        $check = $this->load('class_check');
        $start = $page * $limit - $limit;
        $hientai=time();
        $thongtin = mysqli_query($conn, "SELECT * FROM sanpham_tuan INNER JOIN sanpham ON sanpham_tuan.sp_id=sanpham.id WHERE sanpham.noi_ban LIKE '%ctv%' OR sanpham.noi_ban LIKE '%all%'  ORDER BY sanpham_tuan.id DESC LIMIT $start,$limit");
        $i = $start;
        while ($r_tt = mysqli_fetch_assoc($thongtin)) {
            $i++;
            $r_tt['i'] = $i;
            $r_tt['date_post'] = date('d/m/Y', $r_tt['date_post']);
            $r_tt['gia_cu'] = number_format($r_tt['gia_cu']);
            $r_tt['gia_moi'] = number_format($r_tt['gia_moi']);
            $r_tt['gia_drop'] = number_format($r_tt['gia_drop']);
            $r_tt['drop_max'] = number_format($r_tt['drop_max']);

            $gia_ctv= $r_tt['gia_truoc'] + (($r_tt['drop_min'] - $r_tt['gia_truoc'])*0.3);
            $gia_tuan= $r_tt['gia_tuan'] + (($r_tt['drop_min'] - $r_tt['gia_tuan'])*0.3);
            if($r_tt['time_start']>time()){
                $r_tt['text_time']='Bắt đầu sau:';
                $r_tt['conlai']=$r_tt['time_start'] - time();
                $r_tt['status']=0;
                $r_tt['thoigian']=$r_tt['time_end'] - $r_tt['time_start'];
            }else{
                $r_tt['text_time']='Kết thúc sau:';
                $r_tt['conlai']=$r_tt['time_end'] - time();
                $r_tt['thoigian']=$r_tt['time_end'] - $r_tt['time_start'];
                $r_tt['status']=1;
            }
            $r_tt['gia_ctv']=number_format($gia_ctv);
            $r_tt['gia_tuan']=number_format($gia_tuan);
            $list .= $skin->skin_replace('skin_ctv/box_action/tr_sanpham_tuan', $r_tt);

        }
        return $list;
    }
    ///////////////////
    function list_kq_timkiem_sanpham_thuonghieu_tuan($conn, $thuong_hieu) {
        $skin = $this->load('class_skin_cpanel');
        $check = $this->load('class_check');
        $tach_key=explode(' ', $key);
        $k=0;

        //$thongtin = mysqli_query($conn, "SELECT * FROM sanpham sp WHERE sp.thuong_hieu='$thuong_hieu' AND (sp.noi_ban LIKE '%drop%' OR sp.noi_ban LIKE '%all%') AND (SELECT count(*) FROM sanpham_tuan st WHERE st.sp_id=sp.id)>'0' ORDER BY tieu_de ASC");
        $thongtin = mysqli_query($conn, "SELECT * FROM sanpham_tuan LEFT JOIN sanpham ON sanpham_tuan.sp_id=sanpham.id WHERE sanpham.thuong_hieu='$thuong_hieu' AND (sanpham.noi_ban LIKE '%ctv%' OR sanpham.noi_ban LIKE '%all%') ORDER BY sanpham.tieu_de ASC");
        $i = 0;
        while ($r_tt = mysqli_fetch_assoc($thongtin)) {
            $i++;
            $r_tt['i'] = $i;
            $r_tt['date_post'] = date('d/m/Y', $r_tt['date_post']);
            $r_tt['gia_cu'] = number_format($r_tt['gia_cu']);
            $r_tt['gia_moi'] = number_format($r_tt['gia_moi']);
            $r_tt['drop_max'] = number_format($r_tt['drop_max']);
            if($r_tt['time_start']>time()){
                $r_tt['text_time']='Bắt đầu sau:';
                $r_tt['conlai']=$r_tt['time_start'] - time();
                $r_tt['status']=0;
                $r_tt['thoigian']=$r_tt['time_end'] - $r_tt['time_start'];
            }else{
                $r_tt['text_time']='Kết thúc sau:';
                $r_tt['conlai']=$r_tt['time_end'] - time();
                $r_tt['thoigian']=$r_tt['time_end'] - $r_tt['time_start'];
                $r_tt['status']=1;
            }
            if($kho=='kho_hcm'){
                $r_tt['kho']=$r_tt['kho_hcm'];
            }
            $gia_ctv= $r_tt['gia_truoc'] + (($r_tt['drop_min'] - $r_tt['gia_truoc'])*0.3);
            $gia_tuan= $r_tt['gia_tuan'] + (($r_tt['drop_min'] - $r_tt['gia_tuan'])*0.3);
            $r_tt['gia_ctv']=number_format($gia_ctv);
            $r_tt['gia_tuan']=number_format($gia_tuan);
            $list .= $skin->skin_replace('skin_ctv/box_action/tr_sanpham_tuan', $r_tt);
        }
        mysqli_free_result($thongtin);
        if ($i == 0) {
            $list = '<center>Không có kết quả</center>';
        }
        return $list;
    }
    ///////////////////
    function list_kq_timkiem_sanpham_tuan($conn, $key) {
        $skin = $this->load('class_skin_cpanel');
        $check = $this->load('class_check');
        $tach_key=explode(' ', $key);
        $k=0;
        foreach ($tach_key as $key => $value) {
            $k++;
            if($value!=''){
                if($k==1){
                    $where.="sp.tieu_de LIKE '%$value%'";               
                }else{
                    $where.=" AND sp.tieu_de LIKE '%$value%'";
                }
            }
        }
        $thongtin = mysqli_query($conn, "SELECT * FROM sanpham_tuan st INNER JOIN sanpham sp ON st.sp_id=sp.id WHERE $where AND (sp.noi_ban LIKE '%ctv%' OR sp.noi_ban LIKE '%all%') ORDER BY sp.tieu_de ASC");
        $i = 0;
        while ($r_tt = mysqli_fetch_assoc($thongtin)) {
            $i++;
            $r_tt['i'] = $i;
            $r_tt['date_post'] = date('d/m/Y', $r_tt['date_post']);
            $r_tt['gia_cu'] = number_format($r_tt['gia_cu']);
            $r_tt['gia_moi'] = number_format($r_tt['gia_moi']);
            $r_tt['gia_drop'] = number_format($r_tt['gia_drop']);
            $r_tt['drop_max'] = number_format($r_tt['drop_max']);
            $gia_ctv= $r_tt['gia_truoc'] + (($r_tt['drop_min'] - $r_tt['gia_truoc'])*0.3);
            $gia_tuan= $r_tt['gia_tuan'] + (($r_tt['drop_min'] - $r_tt['gia_tuan'])*0.3);
            $r_tt['gia_ctv']=number_format($gia_ctv);
            $r_tt['gia_tuan']=number_format($gia_tuan);
            if($r_tt['time_start']>time()){
                $r_tt['text_time']='Bắt đầu sau:';
                $r_tt['conlai']=$r_tt['time_start'] - time();
                $r_tt['status']=0;
                $r_tt['thoigian']=$r_tt['time_end'] - $r_tt['time_start'];
            }else{
                $r_tt['text_time']='Kết thúc sau:';
                $r_tt['conlai']=$r_tt['time_end'] - time();
                $r_tt['thoigian']=$r_tt['time_end'] - $r_tt['time_start'];
                $r_tt['status']=1;
            }
            if($kho=='kho_hcm'){
                $r_tt['kho']=$r_tt['kho_hcm'];
            }
            $list .= $skin->skin_replace('skin_ctv/box_action/tr_sanpham_tuan', $r_tt);
        }
        mysqli_free_result($thongtin);
        if ($i == 0) {
            $list = '<center>Không có kết quả</center>';
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
            $list .= $skin->skin_replace('skin_ctv/box_action/tr_tichdiem', $r_tt);
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
				$list .= $skin->skin_replace('skin_ctv/box_action/tr_thanhvien_khoa', $r_tt);
			} else if ($active == 3) {
				$list .= $skin->skin_replace('skin_ctv/box_action/tr_thanhvien_khoa_vinhvien', $r_tt);
			} else {
				$list .= $skin->skin_replace('skin_ctv/box_action/tr_thanhvien', $r_tt);
			}
		}
		return $list;
	}
	///////////////////
	function list_sanpham_ctv($conn, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$thongtin = mysqli_query($conn, "SELECT * FROM sanpham WHERE noi_ban LIKE '%ctv%' OR noi_ban LIKE '%all%' ORDER BY id DESC LIMIT $start,$limit");
		$i = $start;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$r_tt['date_post'] = date('d/m/Y', $r_tt['date_post']);
			$r_tt['gia_cu'] = number_format($r_tt['gia_cu']);
			$r_tt['gia_moi'] = number_format($r_tt['gia_moi']);
			$r_tt['gia_ctv'] = number_format($r_tt['gia_ctv']);
			if($r_tt['drop_min']==0){
				$r_tt['ctv_min'] = 'Không quy định';
			}else{
				$r_tt['ctv_min'] = number_format($r_tt['drop_min']);
			}
			$list .= $skin->skin_replace('skin_ctv/box_action/tr_sanpham_ctv', $r_tt);
		}
		return $list;
	}
	///////////////////
	function list_sanpham($conn, $shop, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$thongtin = mysqli_query($conn, "SELECT * FROM sanpham s WHERE /*(SELECT count(*) FROM sanpham_shop ss WHERE ss.shop='$shop' AND ss.sp_id=s.id)<'1' AND (*/noi_ban LIKE '%ctv%' OR noi_ban LIKE '%all%'/*)*/ ORDER BY id DESC LIMIT $start,$limit");
		$i = $start;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$r_tt['date_post'] = date('d/m/Y', $r_tt['date_post']);
			$r_tt['gia_cu'] = number_format($r_tt['gia_cu']);
			$r_tt['gia_moi'] = number_format($r_tt['gia_moi']);
			$r_tt['gia_ctv'] = number_format($r_tt['gia_ctv']);
            if($r_tt['drop_min']==0){
                $r_tt['ctv_min'] = 'Không quy định';
            }else{
                $r_tt['ctv_min'] = number_format($r_tt['drop_min']);
            }
			$r_tt['drop_max'] = number_format($r_tt['drop_max']);
			$list .= $skin->skin_replace('skin_ctv/box_action/tr_sanpham', $r_tt);
		}
		return $list;
	}
	///////////////////
	function list_sanpham_trend($conn, $shop, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$thongtin = mysqli_query($conn, "SELECT * FROM sanpham_trend INNER JOIN sanpham ON sanpham_trend.sp_id=sanpham.id WHERE sanpham.noi_ban LIKE '%ctv%' OR sanpham.noi_ban LIKE '%all%'  ORDER BY sanpham_trend.id DESC LIMIT $start,$limit");
		$i = $start;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$r_tt['date_post'] = date('d/m/Y', $r_tt['date_post']);
			$r_tt['gia_cu'] = number_format($r_tt['gia_cu']);
			$r_tt['gia_moi'] = number_format($r_tt['gia_moi']);
			$r_tt['gia_ctv'] = number_format($r_tt['gia_ctv']);
            if($r_tt['drop_min']==0){
                $r_tt['ctv_min'] = 'Không quy định';
            }else{
                $r_tt['ctv_min'] = number_format($r_tt['drop_min']);
            }
			$r_tt['drop_max'] = number_format($r_tt['drop_max']);
			$r_tt['gia'] = number_format($r_tt['gia']);
			$list .= $skin->skin_replace('skin_ctv/box_action/tr_sanpham_trend_add', $r_tt);

		}
		return $list;
	}
	///////////////////
	function list_sanpham_shop($conn,$domain, $shop, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$thongtin = mysqli_query($conn, "SELECT sanpham_shop.*,sanpham.gia_ctv,sanpham.kho FROM sanpham_shop LEFT JOIN sanpham ON sanpham_shop.sp_id=sanpham.id WHERE sanpham_shop.shop='$shop' ORDER BY sanpham_shop.id DESC LIMIT $start,$limit");
		$i = $start;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$r_tt['date_post'] = date('d/m/Y', $r_tt['date_post']);
			$r_tt['gia_cu'] = number_format($r_tt['gia_cu']);
			$r_tt['gia_moi'] = number_format($r_tt['gia_moi']);
			$r_tt['gia_ctv'] = number_format($r_tt['gia_ctv']);
			$r_tt['domain']=$domain;
			$list .= $skin->skin_replace('skin_ctv/box_action/tr_sanpham_shop', $r_tt);
		}
		return $list;
	}
	///////////////////
	function list_sanpham_hethang($conn, $page, $limit) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$thongtin = mysqli_query($conn, "SELECT * FROM sanpham WHERE kho<='10' AND (noi_ban LIKE '%ctv%' OR noi_ban LIKE '%all%') ORDER BY id DESC LIMIT $start,$limit");
		$i = $start;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$r_tt['date_post'] = date('d/m/Y', $r_tt['date_post']);
			$r_tt['gia_cu'] = number_format($r_tt['gia_cu']);
			$r_tt['gia_moi'] = number_format($r_tt['gia_moi']);
			$r_tt['gia_ctv'] = number_format($r_tt['gia_ctv']);
			$list .= $skin->skin_replace('skin_ctv/box_action/tr_sanpham_hethang', $r_tt);
		}
		return $list;
	}
	///////////////////
	function thongke_khach_nam($conn,$shop, $dau, $cuoi) {
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
	function thongke_khach_thang($conn,$shop, $thang, $nam, $dau, $cuoi) {
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
	function thongke_khach_tuan($conn,$shop, $dau, $cuoi) {
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
    function thongke_donhang_thanhvien_nam($conn,$user_id,$dau,$cuoi){
        $skin=$this->load('class_skin_cpanel');
        $check=$this->load('class_check');
        $start=$page*$limit - $limit;
        $thongtin=mysqli_query($conn,"SELECT * FROM donhang WHERE date_post>='$dau' AND date_post<='$cuoi' AND user_id='$user_id'");
        while ($r_tt=mysqli_fetch_assoc($thongtin)) {
            $month=date('m',$r_tt['date_post']);
            $month=intval($month);
            if($month==1){
                $month_1++;
            }else if($month==2){
                $month_2++;
            }else if($month==3){
                $month_3++;
            }else if($month==4){
                $month_4++;
            }else if($month==5){
                $month_5++;
            }else if($month==6){
                $month_6++;
            }else if($month==7){
                $month_7++;
            }else if($month==8){
                $month_8++;
            }else if($month==9){
                $month_9++;
            }else if($month==10){
                $month_10++; 
            }else if($month==11){
                $month_11++;

            }else if($month==12){
                $month_12++;
            }   
        }
        return intval($month_1).','.intval($month_2).','.intval($month_3).','.intval($month_4).','.intval($month_5).','.intval($month_6).','.intval($month_7).','.intval($month_8).','.intval($month_9).','.intval($month_10).','.intval($month_11).','.intval($month_12);
    }
    ///////////////////
    function thongke_donhang_thanhvien_thang($conn,$user_id,$thang,$nam,$dau,$cuoi){
        $skin=$this->load('class_skin_cpanel');
        $check=$this->load('class_check');
        $start=$page*$limit - $limit;
        $thongtin=mysqli_query($conn,"SELECT * FROM donhang WHERE date_post>='$dau' AND date_post<='$cuoi' AND user_id='$user_id'");
        while ($r_tt=mysqli_fetch_assoc($thongtin)) {
            $ngay=date('d',$r_tt['date_post']);
            $ngay=intval($ngay);
            if($thang==2){
                if(checkdate(02,29,$nam)==true){
                    for ($i=1; $i <=29 ; $i++) { 
                        if($ngay==$i){
                            $data_ngay[$i]++;
                        }   
                    }
                }else{
                    for ($i=1; $i <=28 ; $i++) { 
                        if($ngay==$i){
                            $data_ngay[$i]++;
                        } 
                    }

                }
            }else if(in_array($thang, array('1','3','5','7','8','10','12'))==true){
                for ($i=1; $i <=31 ; $i++) { 
                    if($ngay==$i){
                        $data_ngay[$i]++;
                    } 
                }
            }else{
                for ($i=1; $i <=30 ; $i++) { 
                    if($ngay==$i){
                        $data_ngay[$i]++;
                    } 
                }

            }
   
        }
        if($thang==2){
            if(checkdate(02,29,$nam)==true){
                for ($i=1; $i <=29 ; $i++) { 
                    $data_thang.=intval($data_ngay[$i]).',';  
                }
            }else{
                for ($i=1; $i <=28 ; $i++) { 
                    $data_thang.=intval($data_ngay[$i]).',';
                }

            }
        }else if(in_array($thang, array('1','3','5','7','8','10','12'))==true){
            for ($i=1; $i <=31 ; $i++) { 
                $data_thang.=intval($data_ngay[$i]).',';
            }
        }else{
            for ($i=1; $i <=30 ; $i++) { 
                $data_thang.=intval($data_ngay[$i]).',';
            }

        }
        $data_thang=substr($data_thang, 0,-1);
        return $data_thang;
    }
    ///////////////////
    function thongke_donhang_thanhvien_tuan($conn,$user_id,$dau,$cuoi){
        $skin=$this->load('class_skin_cpanel');
        $check=$this->load('class_check');
        $start=$page*$limit - $limit;
        $thongtin=mysqli_query($conn,"SELECT * FROM donhang WHERE date_post>='$dau' AND date_post<='$cuoi' AND user_id='$user_id'");
        while ($r_tt=mysqli_fetch_assoc($thongtin)) {
            $month=date('m',$r_tt['date_post']);
            $day=date('d',$r_tt['date_post']);
            $year=date('Y',$r_tt['date_post']);
            $wkday = date('l',mktime('0','0','0', $month, $day, $year));
            if($wkday=='Monday'){
                $mon++;
            }else if($wkday=='Tuesday'){
                $tus++;
            }else if($wkday=='Wednesday'){
                $web++;
            }else if($wkday=='Thursday'){
                $thu++;               
            }else if($wkday=='Friday'){
                $fri++;                
            }else if($wkday=='Saturday'){
                $sat++;                
            }else if($wkday=='Sunday'){
                $sun++;
            }  
        }
        return intval($mon).','.intval($tus).','.intval($web).','.intval($thu).','.intval($fri).','.intval($sat).','.intval($sun);
    }
	///////////////////
	function list_kq_timkiem_sanpham_thuonghieu($conn, $thuong_hieu) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$tach_key=explode(' ', $key);
		$k=0;

		$thongtin = mysqli_query($conn, "SELECT * FROM sanpham WHERE thuong_hieu='$thuong_hieu' AND (noi_ban LIKE '%ctv%' OR noi_ban LIKE '%all%') ORDER BY tieu_de ASC");
		$i = 0;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$r_tt['date_post'] = date('d/m/Y', $r_tt['date_post']);
			$r_tt['gia_cu'] = number_format($r_tt['gia_cu']);
			$r_tt['gia_moi'] = number_format($r_tt['gia_moi']);
			$r_tt['gia_ctv'] = number_format($r_tt['gia_ctv']);
            if($r_tt['drop_min']==0){
                $r_tt['ctv_min'] = 'Không quy định';
            }else{
                $r_tt['ctv_min'] = number_format($r_tt['drop_min']);
            }
			$r_tt['drop_max'] = number_format($r_tt['drop_max']);
			$list .= $skin->skin_replace('skin_ctv/box_action/tr_sanpham_ctv', $r_tt);
		}
		mysqli_free_result($thongtin);
		if ($i == 0) {
			$list = '<center>Không có kết quả</center>';
		}
		return $list;
	}
	///////////////////
	function list_kq_timkiem_sanpham_thuonghieu_add($conn, $thuong_hieu) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$tach_key=explode(' ', $key);
		$k=0;

		$thongtin = mysqli_query($conn, "SELECT * FROM sanpham WHERE thuong_hieu='$thuong_hieu' AND (noi_ban LIKE '%ctv%' OR noi_ban LIKE '%all%') ORDER BY tieu_de ASC");
		$i = 0;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$r_tt['date_post'] = date('d/m/Y', $r_tt['date_post']);
			$r_tt['gia_cu'] = number_format($r_tt['gia_cu']);
			$r_tt['gia_moi'] = number_format($r_tt['gia_moi']);
			$r_tt['gia_ctv'] = number_format($r_tt['gia_ctv']);
            if($r_tt['drop_min']==0){
                $r_tt['ctv_min'] = 'Không quy định';
            }else{
                $r_tt['ctv_min'] = number_format($r_tt['drop_min']);
            }
			$r_tt['drop_max'] = number_format($r_tt['drop_max']);
			$list .= $skin->skin_replace('skin_ctv/box_action/tr_sanpham', $r_tt);
		}
		mysqli_free_result($thongtin);
		if ($i == 0) {
			$list = '<center>Không có kết quả</center>';
		}
		return $list;
	}
	///////////////////
	function list_kq_timkiem_sanpham_thuonghieu_trend($conn,$shop, $thuong_hieu) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$tach_key=explode(' ', $key);
		$k=0;
		//$thongtin = mysqli_query($conn, "SELECT * FROM sanpham sp WHERE sp.thuong_hieu='$thuong_hieu' AND (sp.noi_ban LIKE '%ctv%' OR sp.noi_ban LIKE '%all%') AND (SELECT count(*) FROM sanpham_trend st WHERE st.sp_id=sp.id)>'0' ORDER BY sp.tieu_de ASC");
		$thongtin = mysqli_query($conn, "SELECT *,(SELECT count(*) FROM sanpham_shop ss WHERE ss.shop='$shop' AND ss.sp_id=st.sp_id) AS total  FROM sanpham_trend st INNER JOIN sanpham sp ON st.sp_id=sp.id WHERE sp.thuong_hieu='$thuong_hieu' AND (sp.noi_ban LIKE '%ctv%' OR sp.noi_ban LIKE '%all%') ORDER BY sp.tieu_de ASC");
		$i = 0;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$r_tt['date_post'] = date('d/m/Y', $r_tt['date_post']);
			$r_tt['gia_cu'] = number_format($r_tt['gia_cu']);
			$r_tt['gia_moi'] = number_format($r_tt['gia_moi']);
			$r_tt['gia_ctv'] = number_format($r_tt['gia_ctv']);
            if($r_tt['drop_min']==0){
                $r_tt['ctv_min'] = 'Không quy định';
            }else{
                $r_tt['ctv_min'] = number_format($r_tt['drop_min']);
            }
			$r_tt['drop_max'] = number_format($r_tt['drop_max']);
			$r_tt['gia'] = number_format($r_tt['gia']);
			if($r_tt['total']==0){
				$list .= $skin->skin_replace('skin_ctv/box_action/tr_sanpham_trend_add', $r_tt);
			}else{
				$list .= $skin->skin_replace('skin_ctv/box_action/tr_sanpham_trend', $r_tt);
			}
		}
		mysqli_free_result($thongtin);
		if ($i == 0) {
			$list = '<center>Không có kết quả</center>';
		}
		return $list;
	}
    ///////////////////
    function list_kq_timkiem_sanpham_shop($conn,$domain, $shop, $key) {
        $skin = $this->load('class_skin_cpanel');
        $check = $this->load('class_check');
        $tach_key=explode(' ', $key);
        $k=0;
        foreach ($tach_key as $key => $value) {
            $k++;
            if($value!=''){
                if($k==1){
                    $where.="sanpham_shop.tieu_de LIKE '%$value%'";              
                }else{
                    $where.=" AND sanpham_shop.tieu_de LIKE '%$value%'";
                }
            }
        }
        $thongtin = mysqli_query($conn, "SELECT sanpham_shop.*,sanpham.gia_ctv,sanpham.kho FROM sanpham_shop LEFT JOIN sanpham ON sanpham_shop.sp_id=sanpham.id WHERE sanpham_shop.shop='$shop' AND $where ORDER BY sanpham_shop.id DESC");
        $i = $start;
        while ($r_tt = mysqli_fetch_assoc($thongtin)) {
            $i++;
            $r_tt['i'] = $i;
            $r_tt['date_post'] = date('d/m/Y', $r_tt['date_post']);
            $r_tt['gia_cu'] = number_format($r_tt['gia_cu']);
            $r_tt['gia_moi'] = number_format($r_tt['gia_moi']);
            $r_tt['gia_ctv'] = number_format($r_tt['gia_ctv']);
            $r_tt['domain']=$domain;
            $list .= $skin->skin_replace('skin_ctv/box_action/tr_sanpham_shop', $r_tt);
        }
        return $list;
    }
	///////////////////
	function list_kq_timkiem_sanpham_trend($conn,$shop, $key) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$tach_key=explode(' ', $key);
		$k=0;
		foreach ($tach_key as $key => $value) {
			$k++;
			if($value!=''){
				if($k==1){
					$where.="sp.tieu_de LIKE '%$value%'";				
				}else{
					$where.=" AND sp.tieu_de LIKE '%$value%'";
				}
			}
		}
		$thongtin = mysqli_query($conn, "SELECT *,(SELECT count(*) FROM sanpham_shop ss WHERE ss.shop='$shop' AND ss.sp_id=st.sp_id) AS total FROM sanpham_trend st INNER JOIN sanpham sp ON st.sp_id=sp.id WHERE $where AND (sp.noi_ban LIKE '%ctv%' OR sp.noi_ban LIKE '%all%') ORDER BY sp.tieu_de ASC");
		$i = 0;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$r_tt['date_post'] = date('d/m/Y', $r_tt['date_post']);
			$r_tt['gia_cu'] = number_format($r_tt['gia_cu']);
			$r_tt['gia_moi'] = number_format($r_tt['gia_moi']);
			$r_tt['gia_ctv'] = number_format($r_tt['gia_ctv']);
            if($r_tt['drop_min']==0){
                $r_tt['ctv_min'] = 'Không quy định';
            }else{
                $r_tt['ctv_min'] = number_format($r_tt['drop_min']);
            }
			$r_tt['drop_max'] = number_format($r_tt['drop_max']);
			$r_tt['gia'] = number_format($r_tt['gia']);
			if($r_tt['total']==0){
				$list .= $skin->skin_replace('skin_ctv/box_action/tr_sanpham_trend_add', $r_tt);
			}else{
				$list .= $skin->skin_replace('skin_ctv/box_action/tr_sanpham_trend', $r_tt);
			}
		}
		mysqli_free_result($thongtin);
		if ($i == 0) {
			$list = '<center>Không có kết quả</center>';
		}
		return $list;
	}
	///////////////////
	function list_kq_timkiem_sanpham_ctv($conn, $key) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$tach_key=explode(' ', $key);
		$k=0;
		foreach ($tach_key as $key => $value) {
			$k++;
			if($value!=''){
				if($k==1){
					$where.="tieu_de LIKE '%$value%'";				
				}else{
					$where.=" AND tieu_de LIKE '%$value%'";
				}
			}
		}
		$thongtin = mysqli_query($conn, "SELECT * FROM sanpham WHERE $where AND (noi_ban LIKE '%ctv%' OR noi_ban LIKE '%all%') ORDER BY tieu_de ASC");
		$i = 0;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$r_tt['date_post'] = date('d/m/Y', $r_tt['date_post']);
			$r_tt['gia_cu'] = number_format($r_tt['gia_cu']);
			$r_tt['gia_moi'] = number_format($r_tt['gia_moi']);
			$r_tt['gia_ctv'] = number_format($r_tt['gia_ctv']);
            if($r_tt['drop_min']==0){
                $r_tt['ctv_min'] = 'Không quy định';
            }else{
                $r_tt['ctv_min'] = number_format($r_tt['drop_min']);
            }
			$r_tt['drop_max'] = number_format($r_tt['drop_max']);
			$list .= $skin->skin_replace('skin_ctv/box_action/tr_sanpham_ctv', $r_tt);
		}
		mysqli_free_result($thongtin);
		if ($i == 0) {
			$list = '<center>Không có kết quả</center>';
		}
		return $list;
	}
	///////////////////
	function list_kq_timkiem_sanpham($conn, $key) {
		$skin = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$tach_key=explode(' ', $key);
		$k=0;
		foreach ($tach_key as $key => $value) {
			$k++;
			if($value!=''){
				if($k==1){
					$where.="tieu_de LIKE '%$value%'";				
				}else{
					$where.=" AND tieu_de LIKE '%$value%'";
				}
			}
		}
		$thongtin = mysqli_query($conn, "SELECT * FROM sanpham WHERE $where AND (noi_ban LIKE '%ctv%' OR noi_ban LIKE '%all%') ORDER BY tieu_de ASC");
		$i = 0;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$r_tt['date_post'] = date('d/m/Y', $r_tt['date_post']);
			$r_tt['gia_cu'] = number_format($r_tt['gia_cu']);
			$r_tt['gia_moi'] = number_format($r_tt['gia_moi']);
			$r_tt['gia_ctv'] = number_format($r_tt['gia_ctv']);
            if($r_tt['drop_min']==0){
                $r_tt['ctv_min'] = 'Không quy định';
            }else{
                $r_tt['ctv_min'] = number_format($r_tt['drop_min']);
            }
			$r_tt['drop_max'] = number_format($r_tt['drop_max']);
			$list .= $skin->skin_replace('skin_ctv/box_action/tr_sanpham', $r_tt);
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
			$list .= $skin->skin_replace('skin_ctv/box_action/tr_thanhvien', $r_tt);
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
		$thongtin = mysqli_query($conn, "SELECT * FROM donhang WHERE ma_don LIKE '%$key%' OR ho_ten LIKE '%$key%' OR email LIKE '%$key%' OR dien_thoai LIKE '%$key%' ORDER BY date_post DESC");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$r_tt['tongtien'] = number_format($r_tt['tongtien']) . 'đ';
			$r_tt['date_post'] = date('d/m/Y', $r_tt['date_post']);
			if ($r_tt['status'] == 1) {
				$r_tt['status'] = 'Đã nhận hàng';
			} else if ($r_tt['status'] == 2) {
				$r_tt['status'] = 'Đang vận chuyển';
			} else if ($r_tt['status'] == 3) {
				$r_tt['status'] = 'Đã hủy đơn';
			} else if ($r_tt['status'] == 4) {
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
			$list .= $skin->skin_replace('skin_ctv/box_action/tr_donhang', $r_tt);
		}
		return $list;
	}
//////////////////////////////////////////////////////////////////
	function list_setting($conn, $shop, $page, $limit) {
		$tlca_skin_cpanel = $this->load('class_skin_cpanel');
		$check = $this->load('class_check');
		$start = $page * $limit - $limit;
		$i = $start;
		$thongtin = mysqli_query($conn, "SELECT * FROM shop_setting WHERE shop='$shop' AND loai!='an' ORDER BY name DESC LIMIT $start,$limit");
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['i'] = $i;
			$r_tt['value'] = $check->words($r_tt['value'], 200);
			$list .= $tlca_skin_cpanel->skin_replace('skin_ctv/box_action/tr_setting', $r_tt);
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
