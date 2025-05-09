<?php
session_start();

include '../includes/tlca_world.php';
$check = $tlca_do->load('class_check');
$class_index = $tlca_do->load('class_ncc');
$class_viettel = $tlca_do->load('class_viettel');
$param_url = parse_url($_SERVER['REQUEST_URI']);
parse_str($param_url['query'], $url_query);
$page = addslashes($url_query['page']);
$sort = addslashes($url_query['sort']);
$skin = $tlca_do->load('class_skin_cpanel');
$total_cart = isset($_SESSION['drop_cart']) ? count($_SESSION['drop_cart']) : 0;
$tach_token = json_decode($check->token_login_decode($_COOKIE['user_id']), true);
$user_id = $tach_token['user_id'];
$user_info = $class_member->user_info($conn, $_COOKIE['user_id']);
$query_follow = "SELECT sanpham FROM sanpham_follow WHERE user_id='$user_id' LIMIT 1";
$result_follow = mysqli_query($conn, $query_follow);
if ($user_info['ctv'] != 1) {
    // Không phải CTV cấp 1 - chuyển hướng
    $thongbao = "Tài khoản của bạn không phải ncc...";
    $replace = array(
        'title' => 'Tài khoản của bạn không phải ncc...',
        'description' => $index_setting['description'],
        'thongbao' => $thongbao,
        'link_chuyen' => '/'
    );
    echo $skin->skin_replace('skin_ncc/chuyenhuong', $replace);
    exit();
}
// Thêm mã kiểm tra setup với NCC mới // nhatthem94
if (isset($_COOKIE['user_id'])) {
	$check_supplier = mysqli_query($conn, "SELECT ctv, email, maso_thue, dia_chi FROM user_info WHERE user_id = '$user_id'");
	if (!$check_supplier) {
		die('Lỗi truy vấn user_info: ' . mysqli_error($conn));
	}
	$supplier = mysqli_fetch_assoc($check_supplier);
	
	$check_ncc = mysqli_query($conn, "SELECT email, maso_thue FROM user_ncc WHERE user_id = '$user_id' LIMIT 1");
	if (!$check_ncc) {
		die('Lỗi truy vấn user_ncc: ' . mysqli_error($conn));
	}
	$has_ncc = mysqli_num_rows($check_ncc);
	
	$check_transport = mysqli_query($conn, "SELECT id FROM transport WHERE user_id = '$user_id' LIMIT 1");
	if (!$check_transport) {
		die('Lỗi truy vấn transport: ' . mysqli_error($conn));
	}
	$has_transport = mysqli_num_rows($check_transport);
	
	$check_bank = mysqli_query($conn, "SELECT id FROM bank_accounts WHERE user_id = '$user_id' LIMIT 1");
	if (!$check_bank) {
		die('Lỗi truy vấn bank_accounts: ' . mysqli_error($conn));
	}
	$has_bank = mysqli_num_rows($check_bank);
	
	if ($has_ncc < 1 || $has_transport < 1 || $has_bank < 1) {
		$thongbao = "Bạn chưa hoàn thiện thông tin tài khoản.<br>Đang chuyển hướng tới trang thiết lập thông tin...";
		$replace = array(
			'title' => 'Bạn chưa hoàn thiện thông tin tài khoản...',
			'description' => $index_setting['description'],
			'thongbao' => $thongbao, 
			'link_chuyen' => '/ncc/welcome_setup.php'
		);
		echo $skin->skin_replace('skin_ncc/chuyenhuong', $replace);
		exit();
	}
	
}

if ($result_follow && mysqli_num_rows($result_follow) > 0) {
	$row_follow = mysqli_fetch_assoc($result_follow);
	$list_id = trim($row_follow['sanpham']);
	if ($list_id !== '') {
		$arr_follow = array_filter(explode(',', $list_id));
		$total_follow = count($arr_follow);
	} else {
		$total_follow = 0;
	}
} else {
	$total_follow = 0;
}
if (intval($page) < 1) {
	$page = 1;
} else {
	$page = intval($page);
}
if (isset($_REQUEST['action'])) {
	$action = addslashes($_REQUEST['action']);
} else {
	$action = 'dashboard';
}

if (!isset($_COOKIE['user_id'])) {
    $thongbao = "Bạn chưa đăng nhập.<br>Đang chuyển hướng tới trang đăng nhập...";
    $replace = array(
        'title' => 'Bạn chưa đăng nhập...',
        'description' => $index_setting['description'],
        'thongbao' => $thongbao, 
        'link_chuyen' => '/ncc/login'
    );
    echo $skin->skin_replace('skin_ncc/chuyenhuong', $replace);
    exit();
}

// Lấy thông tin user
$class_member = $tlca_do->load('class_member');
$tach_token = json_decode($check->token_login_decode($_COOKIE['user_id']), true);
$user_id = $tach_token['user_id'];
$user_info = $class_member->user_info($conn, $_COOKIE['user_id']);

// Kiểm tra thông tin bắt buộc nhatthem94
$check_setup = mysqli_query($conn, "SELECT email, maso_thue, dia_chi FROM user_info WHERE user_id = '$user_id'");
$user_setup = mysqli_fetch_assoc($check_setup);
if (empty($user_setup['email']) || empty($user_setup['maso_thue']) || empty($user_setup['dia_chi'])) {
    header('Location: /ncc/welcome_setup.php');
    exit;
}


if ($user_info['ctv'] == 4) {
    $thongbao = "Tài khoản của bạn đang bị tạm khóa...";
    $replace = array(
        'title' => 'Tài khoản của bạn đang bị tạm khóa...',
        'description' => $index_setting['description'],
        'thongbao' => $thongbao,
        'link_chuyen' => '/ncc/login.html'
    );
    echo $skin->skin_replace('skin_ncc/chuyenhuong', $replace);
    exit();
}
	$moc_thoigian = strtotime('2025-03-15');

	$check_user = mysqli_query($conn, "SELECT user_id FROM user_gh WHERE user_id='$user_id'");
	$is_activated = mysqli_num_rows($check_user) > 0;
	if ($user_info['ctv'] == 1) {
		$check_user = mysqli_query($conn, "SELECT user_id, date_active, date_expired FROM user_gh WHERE user_id='$user_id'");
		$is_activated = mysqli_num_rows($check_user) > 0;

		if ($is_activated) {
			$row = mysqli_fetch_assoc($check_user);
			$expire_time = $row['date_expired'];
		} else {
			// Chưa kích hoạt - tính thời gian dùng thử 7 ngày
			$time_start = $user_info['created'];
			if ($time_start < $moc_thoigian) {
				$start_date = $moc_thoigian;
			} else {
				$start_date = $time_start;
			}
			$expire_time = $start_date + (7 * 86400);
		}

		$current_time = time();
		$time_conlai = $expire_time - $current_time;
		$remaining_seconds = max($time_conlai, 0);
		$remaining_days = floor($remaining_seconds / 86400);

		if ($remaining_seconds === 0) {
			
			$display_kh = 'display:block !important';
			$display_close = 'display:none !important';

			$thaythe_box = array(
				'display_kh' => $display_kh,
				'display_close' => $display_close,
				'remaining_days' => '0', 
				'expire_time' => $expire_time,
				'block_interactions' => true
			);

			$box_taikhoan_kh = $skin->skin_replace('skin_ncc/box_action/box_kh_taikhoan', $thaythe_box);

			echo '<style>
        .main-content * {
            pointer-events: none !important;
            opacity: 0.5;
        }
        .box_kichhoat {
            pointer-events: auto !important;
            opacity: 1 !important;
            z-index: 9999;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
        .box_kichhoat * {
            pointer-events: auto !important;
            opacity: 1 !important;
        }
    </style>';
		} else {
			
			$display_kh = 'display:block';
			$display_close = 'display:block';

			$thaythe_box = array(
				'display_kh' => $display_kh,
				'display_close' => $display_close,
				'remaining_days' => number_format($remaining_days),
				'expire_time' => $expire_time
			);

			$box_taikhoan_kh = $skin->skin_replace('skin_ncc/box_action/box_kh_taikhoan', $thaythe_box);
		}

	
		$thaythe['box_taikhoan_kh'] = $box_taikhoan_kh;
	}

	$query = "SELECT tien_kh FROM user_gh WHERE user_id = '$user_id' ORDER BY date_active DESC LIMIT 1";

	$result = mysqli_query($conn, $query);
	$row = mysqli_fetch_assoc($result);
	$tien_kh = $row['tien_kh'];
	$ngay_hientai = strtotime(date('18-09-2024'));
	if ($tien_kh < 500000 and $user_info['nhan_vien'] == 0) {
		$display_kh_ct = 'display:none;';
		if ($user_info['created'] < $ngay_hientai) {
			$display_close = "display:block";
			if (isset($_SESSION['close_kh']) and $_SESSION['close_kh'] == $user_info['user_id']) {
				$display_kh = 'display:none';
			} else {
				$display_kh = 'display:block';
			}
			$thaythe_box = array(
				'display_kh' => $display_kh,
				'display_close' => $display_close
			);
			$box_taikhoan_kh = $skin->skin_replace('skin_ncc/box_action/box_kh_taikhoan', $thaythe_box);
		} else {
			if (number_format($remaining_seconds) === 0) {
				$display_kh = 'display:block; !important'; 
				$display_close = 'display:none;!important'; 

			} else {
				$display_kh = 'display:block;'; 

			}

			$thaythe_box = array(

				'display_kh' => $display_kh,
				'display_close' => $display_close,
				'remaining_days' => number_format($remaining_days),
			);
			$box_taikhoan_kh = $skin->skin_replace('skin_ncc/box_action/box_kh_taikhoan', $thaythe_box);
		}
	} else {
		$display_kh_hi = 'display:none;';
		$display_close_hi = 'display:none;';
		$display_kh_ct = 'display:block;';
		$box_taikhoan_kh = '';
	}

	if ($user_info['leader'] == 1 || $is_activated || $user_info['nhan_vien'] == 1) {
		$display_kh_hi = 'display:none;';
		$display_close_hi = 'display:none;';
		$display_kh_ct = 'display:block;';
		$box_taikhoan_kh = '';
	} else if ($user_info['user_money'] >= 0) {
		$box_danhhieu = '<div class="box_danhhieu"><img src="/skin_ncc/css/images/level-11.PNG" alt="danh hiệu" title="Thành viên chính thức"></div>';
		$time_conlai = 30 * 24 * 3600;
		$menu_thongbao = '';
		mysqli_query($conn, "UPDATE user_info SET chinh_thuc='1' WHERE user_id='$user_id'");
	} else {
		$thongtin_web = mysqli_query($conn, "SELECT *,count(*) AS total FROM domain WHERE user_id='$user_id'");
		$r_web = mysqli_fetch_assoc($thongtin_web);
		if ($r_web['total'] > 0) {
			if ($r_web['free'] == 0 and $r_web['expired'] > time()) {
				$box_danhhieu = '<div class="box_danhhieu"><img src="/skin_ncc/css/images/level-11.PNG" alt="danh hiệu" title="Thành viên chính thức"></div>';
				$menu_thongbao = '';
				mysqli_query($conn, "UPDATE user_info SET chinh_thuc='1' WHERE user_id='$user_id'");
			} else {
				$thongtin_seeding_moi = mysqli_query($conn, "SELECT * FROM mua_seeding_shopee WHERE user_id='$user_id' ORDER BY id DESC LIMIT 1");
				$total_seeding_moi = mysqli_num_rows($thongtin_seeding_moi);
				if ($total_seeding_moi > 0) {
					$r_sd = mysqli_fetch_assoc($thongtin_seeding_moi);
					if ($r_sd['date_post'] + 15 * 24 * 3600 > time()) {
						$box_danhhieu = '<div class="box_danhhieu"><img src="/skin_ncc/css/images/level-11.PNG" alt="danh hiệu" title="Thành viên chính thức"></div>';
						$menu_thongbao = '';
						mysqli_query($conn, "UPDATE user_info SET chinh_thuc='1' WHERE user_id='$user_id'");
					} else {
						$thongtin_donhang_moi = mysqli_query($conn, "SELECT * FROM donhang WHERE user_id='$user_id' ORDER BY id DESC LIMIT 1");
						$total_donhang_moi = mysqli_num_rows($thongtin_donhang_moi);
						if ($total_donhang_moi == 0) {
							$box_danhhieu = '';
							if ($user_info['date_update'] != '') {
								$time_conlai = 15 * 24 * 3600 - (time() - $user_info['date_update']);
							} else {
								$time_conlai = 15 * 24 * 3600 - (time() - $user_info['created']);
							}
							if ($time_conlai <= 0) {
								$thongbao = "Tài khoản của bạn đang bị tạm khóa...";
								$replace = array(
									'title' => 'Tài khoản của bạn đang bị tạm khóa...',
									'description' => $index_setting['description'],
									'thongbao' => $thongbao,
									'link_chuyen' => '/ban-hang.html',
								);
								echo $skin->skin_replace('skin_ncc/chuyenhuong', $replace);
								exit();
							} else {
							}
							if (!isset($_COOKIE['close_menu_thongbao'])) {
								if ($time_conlai <= 0) {
									$time_conlai = 0;
									$menu_thongbao = '';
								} else {
									$menu_thongbao = $skin->skin_normal('skin_ncc/box_action/menu_thongbao');
								}
							}
						} else {
							$r_donhang_moi = mysqli_fetch_assoc($thongtin_donhang_moi);
							if ($r_donhang_moi['date_post'] + 15 * 24 * 3600 < time()) {
								$box_danhhieu = '';
								$time_dh_conlai = 30 * 24 * 3600 - (time() - $r_donhang_moi['date_post']);
								if ($time_dh_conlai <= 0) {
									if ($user_info['date_update'] != '') {
										$time_conlai = 15 * 24 * 3600 - (time() - $user_info['date_update']);
									} else {
										$time_conlai = 15 * 24 * 3600 - (time() - $user_info['created']);
									}
									if ($time_conlai <= 0) {
										$thongbao = "Tài khoản của bạn đang bị tạm khóa...";
										$replace = array(
											'title' => 'Tài khoản của bạn đang bị tạm khóa...',
											'description' => $index_setting['description'],
											'thongbao' => $thongbao,
											'link_chuyen' => '/ban-hang.html',
										);
										echo $skin->skin_replace('skin_ncc/chuyenhuong', $replace);
										exit();
									}
								} else {
									if ($user_info['date_update'] != '') {
										$time_conlai = 15 * 24 * 3600 - (time() - $user_info['date_update']);
									} else {
										$time_conlai = 15 * 24 * 3600 - (time() - $user_info['created']);
									}
									if ($time_dh_conlai > $time_conlai) {
										$time_conlai = $time_dh_conlai;
									}
								}
								if (!isset($_COOKIE['close_menu_thongbao'])) {
									if ($time_conlai <= 0) {
										$time_conlai = 0;
										$menu_thongbao = '';
									} else {
										$menu_thongbao = $skin->skin_normal('skin_ncc/box_action/menu_thongbao');
									}
								}
							} else {
								$box_danhhieu = '<div class="box_danhhieu"><img src="/skin_ncc/css/images/level-11.PNG" alt="danh hiệu" title="Thành viên chính thức"></div>';
								$time_conlai = 30 * 24 * 3600 - (time() - $r_donhang_moi['date_post']);
								$menu_thongbao = '';
								mysqli_query($conn, "UPDATE user_info SET chinh_thuc='1' WHERE user_id='$user_id'");
							}
						}
					}
				} else {
					$thongtin_donhang_moi = mysqli_query($conn, "SELECT * FROM donhang WHERE user_id='$user_id' ORDER BY id DESC LIMIT 1");
					$total_donhang_moi = mysqli_num_rows($thongtin_donhang_moi);
					if ($total_donhang_moi == 0) {
						$box_danhhieu = '';
						if ($user_info['date_update'] != '') {
							$time_conlai = 15 * 24 * 3600 - (time() - $user_info['date_update']);
						} else {
							$time_conlai = 15 * 24 * 3600 - (time() - $user_info['created']);
						}
						if ($time_conlai <= 0) {
							$thongbao = "Tài khoản của bạn đang bị tạm khóa...";
							$replace = array(
								'title' => 'Tài khoản của bạn đang bị tạm khóa...',
								'description' => $index_setting['description'],
								'thongbao' => $thongbao,
								'link_chuyen' => '/ban-hang.html',
							);
							echo $skin->skin_replace('skin_ncc/chuyenhuong', $replace);
							exit();
						} else {
						}
						if (!isset($_COOKIE['close_menu_thongbao'])) {
							if ($time_conlai <= 0) {
								$time_conlai = 0;
								$menu_thongbao = '';
							} else {
								$menu_thongbao = $skin->skin_normal('skin_ncc/box_action/menu_thongbao');
							}
						}
					} else {
						$r_donhang_moi = mysqli_fetch_assoc($thongtin_donhang_moi);
						if ($r_donhang_moi['date_post'] + 15 * 24 * 3600 < time()) {
							$box_danhhieu = '';
							$time_dh_conlai = 30 * 24 * 3600 - (time() - $r_donhang_moi['date_post']);
							if ($time_dh_conlai <= 0) {
								if ($user_info['date_update'] != '') {
									$time_conlai = 15 * 24 * 3600 - (time() - $user_info['date_update']);
								} else {
									$time_conlai = 15 * 24 * 3600 - (time() - $user_info['created']);
								}
								if ($time_conlai <= 0) {
									$thongbao = "Tài khoản của bạn đang bị tạm khóa...";
									$replace = array(
										'title' => 'Tài khoản của bạn đang bị tạm khóa...',
										'description' => $index_setting['description'],
										'thongbao' => $thongbao,
										'link_chuyen' => '/ban-hang.html',
									);
									echo $skin->skin_replace('skin_ncc/chuyenhuong', $replace);
									exit();
								}
							} else {
								if ($user_info['date_update'] != '') {
									$time_conlai = 15 * 24 * 3600 - (time() - $user_info['date_update']);
								} else {
									$time_conlai = 15 * 24 * 3600 - (time() - $user_info['created']);
								}
								if ($time_dh_conlai > $time_conlai) {
									$time_conlai = $time_dh_conlai;
								}
							}
							if (!isset($_COOKIE['close_menu_thongbao'])) {
								if ($time_conlai <= 0) {
									$time_conlai = 0;
									$menu_thongbao = '';
								} else {
									$menu_thongbao = $skin->skin_normal('skin_ncc/box_action/menu_thongbao');
								}
							}
						} else {
							$box_danhhieu = '<div class="box_danhhieu"><img src="/skin_ncc/css/images/level-11.PNG" alt="danh hiệu" title="Thành viên chính thức"></div>';
							$time_conlai = 30 * 24 * 3600 - (time() - $r_donhang_moi['date_post']);
							$menu_thongbao = '';
							mysqli_query($conn, "UPDATE user_info SET chinh_thuc='1' WHERE user_id='$user_id'");
						}
					}
				}
			}
		} else {
			$thongtin_donhang_moi = mysqli_query($conn, "SELECT * FROM donhang WHERE user_id='$user_id' ORDER BY id DESC LIMIT 1");
			$total_donhang_moi = mysqli_num_rows($thongtin_donhang_moi);
			if ($total_donhang_moi == 0) {
				$box_danhhieu = '';
				if ($user_info['date_update'] != '') {
					$time_conlai = 15 * 24 * 3600 - (time() - $user_info['date_update']);
				} else {
					$time_conlai = 15 * 24 * 3600 - (time() - $user_info['created']);
				}
				if ($time_conlai <= 0) {
					$thongbao = "Tài khoản của bạn đang bị tạm khóa...";
					$replace = array(
						'title' => 'Tài khoản của bạn đang bị tạm khóa...',
						'description' => $index_setting['description'],
						'thongbao' => $thongbao,
						'link_chuyen' => '/ban-hang.html',
					);
					echo $skin->skin_replace('skin_ncc/chuyenhuong', $replace);
					exit();
				} else {
				}
				if (!isset($_COOKIE['close_menu_thongbao'])) {
					if ($time_conlai <= 0) {
						$time_conlai = 0;
						$menu_thongbao = '';
					} else {
						$menu_thongbao = $skin->skin_normal('skin_ncc/box_action/menu_thongbao');
					}
				}
			} else {
				$r_donhang_moi = mysqli_fetch_assoc($thongtin_donhang_moi);
				if ($r_donhang_moi['date_post'] + 15 * 24 * 3600 < time()) {
					$box_danhhieu = '';
					$time_dh_conlai = 30 * 24 * 3600 - (time() - $r_donhang_moi['date_post']);
					if ($time_dh_conlai <= 0) {
						if ($user_info['date_update'] != '') {
							$time_conlai = 15 * 24 * 3600 - (time() - $user_info['date_update']);
						} else {
							$time_conlai = 15 * 24 * 3600 - (time() - $user_info['created']);
						}
						if ($time_conlai <= 0) {
							$thongbao = "Tài khoản của bạn đang bị tạm khóa...";
							$replace = array(
								'title' => 'Tài khoản của bạn đang bị tạm khóa...',
								'description' => $index_setting['description'],
								'thongbao' => $thongbao,
								'link_chuyen' => '/ban-hang.html',
							);
							echo $skin->skin_replace('skin_ncc/chuyenhuong', $replace);
							exit();
						}
					} else {
						if ($user_info['date_update'] != '') {
							$time_conlai = 15 * 24 * 3600 - (time() - $user_info['date_update']);
						} else {
							$time_conlai = 15 * 24 * 3600 - (time() - $user_info['created']);
						}
						if ($time_dh_conlai > $time_conlai) {
							$time_conlai = $time_dh_conlai;
						}
					}
					if (!isset($_COOKIE['close_menu_thongbao'])) {
						if ($time_conlai <= 0) {
							$time_conlai = 0;
							$menu_thongbao = '';
						} else {
							$menu_thongbao = $skin->skin_normal('skin_ncc/box_action/menu_thongbao');
						}
					}
				} else {
					$box_danhhieu = '<div class="box_danhhieu"><img src="/skin_ncc/css/images/level-11.PNG" alt="danh hiệu" title="Thành viên chính thức"></div>';
					$time_conlai = 30 * 24 * 3600 - (time() - $r_donhang_moi['date_post']);
					mysqli_query($conn, "UPDATE user_info SET chinh_thuc='1' WHERE user_id='$user_id'");
					$menu_thongbao = '';
				}
			}
		}
	}
$setting = mysqli_query($conn, "SELECT * FROM index_setting ORDER BY name ASC");
while ($r_s = mysqli_fetch_assoc($setting)) {
	$index_setting[$r_s['name']] = $r_s['value'];
}
if ($user_info['domain'] != '') {
	if (strpos('http://', $user_info['domain']) !== false) {
		$domain = $user_info['domain'];
	} else if (strpos('https://', $user_info['domain']) !== false) {
		$domain = $user_info['domain'];
	} else {
		$domain = 'http://' . $user_info['domain'];
	}
} else {
	$domain = $index_setting['link_domain'];
}
if ($user_info['leader'] == 0) {
	$marquee = '<div class="marquee">
        <a href="/ncc/dangky-leader">
        <marquee behavior="scroll" direction="left"
           onmouseover="this.stop();"
           onmouseout="this.start();">Đăng ký trở thành nhà bán hàng chuyên nghiệp cùng Sóc Đỏ để nhận được nhiều ưu đãi - Xem ngay</marquee></a>
      </div>';
} else {
	$marquee = '';
}
$domain_giao_viec ="";
$domain_gv = $class_index->get_domain_giaoviec($conn, $user_id);
if($domain_gv == "" || $domain_gv == null){
	$domain_giao_viec = '/setup-domain.php';
}
else{
	$domain_giao_viec = 'https://'.$domain_gv;
}
$tach_list_slide_donhang = json_decode($class_index->list_donhang_moi($conn, '', 1, 10), true);
$thaythe = array(
	'expire_time' => $expire_time,
	'display_kh' => $display_kh,
	'created_date' => $ngay_tao_taikhoan,
	'remaining_days' => number_format($remaining_days),
	'remaining_hours' => number_format($remaining_hours),
	'remaining_minutes' => number_format($remaining_minutes),
	'remaining_seconds' => number_format($remaining_seconds),
	'header' => $skin->skin_normal('skin_ncc/header'),
	'box_menu' => $skin->skin_normal('skin_ncc/box_menu'),
	'menu_thongbao' => $menu_thongbao,
	'footer' => $skin->skin_normal('skin_ncc/footer'),
	'box_script_footer' => $skin->skin_normal('skin_ncc/box_script_footer'),
	'box_taikhoan_kh' => $box_taikhoan_kh,
	'description' => $index_setting['description'],
	'thanhvien_chat' => $user_id,
	'site_name' => $index_setting['site_name'],
	'gianhang' => $domain,
	'phantrang' => '',
	'fullname' => $user_info['name'],
	'email' => $user_info['email'],
	'username' => $user_info['username'],
	'created' => $user_info['created'],
	'nganhang' => $index_setting['nganhang'],
	'user_money' => number_format($user_info['user_money']),
	'user_money2' => number_format($user_info['user_money2']),
	'list_danhmuc_video' => $class_index->list_danhmuc_video($conn),
	'list_donhang_slide' => $tach_list_slide_donhang['list_slide'],
	'name' => $name,
	'menu_nhom' => $menu_nhom,
	'avatar' => $user_info['avatar'],
	'box_danhhieu' => $box_danhhieu,
	'time_conlai' => $time_conlai,
	'pop_hotro' => $pop_hotro,
	'display_kh_ct' => $display_kh_ct,
	'display_close' => $display_close,
	'display_kh' => $display_kh_hi,
	'current_time' => time(),
	'display_close' => $display_close_hi,
	'marquee' => $marquee,
	'total_cart' => $total_cart,
	'total_follow'    => $total_follow,
	'domain_giaoviec' => $domain_giao_viec,
);

$file_action = 'action/' . $action . '.php';
if (file_exists($file_action)) {
	include($file_action);
} else {
	$thongbao = "Dữ liệu không tồn tại...";
	$replace = array(
		'title' => 'Thiết lập giao diện...',
		'description' => $index_setting['description'],
		'thongbao' => $thongbao,
		'link_chuyen' => '/ncc/',
	);
	echo $skin->skin_replace('skin_ncc/chuyenhuong', $replace);
	exit();
}

$box_menu = $skin->skin_replace('skin_ncc/box_menu', $thaythe);

$thaythe['box_menu'] = $box_menu;

echo $skin->skin_replace('skin_ncc/index', $thaythe);

// nhatthem74: Include welcome setup modal nhatthem94
include_once('skin_ncc/welcome_setup.tpl');

// Thêm sau phần kiểm tra đăng nhập
$check_setup = mysqli_query($conn, "SELECT email, maso_thue, dia_chi FROM user_info WHERE user_id = '$user_id'");
$user_info = mysqli_fetch_assoc($check_setup);

if (empty($user_info['email']) || empty($user_info['maso_thue']) || empty($user_info['dia_chi'])) {
    header('Location: /ncc/welcome_setup.php');
    exit;
}