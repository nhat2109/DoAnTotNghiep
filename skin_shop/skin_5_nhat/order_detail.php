	<?php
	$class_index=$tlca_do->load_skin($s,'class_shop');
	$check = $tlca_do->load('class_check');
	$giaodien=json_decode($index_setting['giaodien'],true);
	$limit=10;
	if(!isset($_COOKIE['user_id'])){
		$thongbao="Bạn hiện chưa đăng nhập.";
		$replace=array(
			'title'=>'Bạn chưa đăng nhập tài khoản',
			'thongbao'=>$thongbao,
			'link'=>'/dang-nhap.html'
		);
		echo $skin->skin_replace('skin_shop/'.$s.'/tpl/chuyenhuong',$replace);
		exit();
	}else{
		$box_header=$skin->skin_normal('skin_shop/'.$s.'/tpl/box_header_login');
		$header_menu_mobile=$skin->skin_normal('skin_shop/'.$s.'/tpl/header_menu_mobile_login');
		$class_member=$tlca_do->load('class_member');
		$tach_token=json_decode($check->token_login_decode($_COOKIE['user_id']),true);
		$user_id=$tach_token['user_id'];
		$user_info=$class_member->user_info($conn,$_COOKIE['user_id']);
	}
	$order=preg_replace('/[^0-9]/', '',$url_query['id']);
	$thongtin=mysqli_query($conn,"SELECT *,count(*) AS total FROM donhang_shop WHERE ma_don='$order' AND user_id='$user_id'");
	$r_tt=mysqli_fetch_assoc($thongtin);
	if($r_tt['total']==0){
		$thongbao="Đơn hàng không tồn tại.";
		$replace=array(
			'title'=>'Đơn hàng không tồn tại',
			'thongbao'=>$thongbao,
			'link'=>'/don-hang.html'
		);
		echo $skin->skin_replace('skin_shop/'.$s.'/tpl/chuyenhuong',$replace);
		exit();
	}
	$order_time_raw = $r_tt['date_post']; // có thể là chuỗi '2024-05-15 14:00:00'
	$order_time = is_numeric($order_time_raw) ? (int)$order_time_raw : strtotime($order_time_raw);
	$current_time = time();
	$time_diff = $current_time - $order_time;
	$show_cancel_button = false;
	$show_refund_button = false;
	if($r_tt['status'] == 1){
		$trang_thai = 'Đã tiếp nhận đơn hàng';
		$trang_thai_class = 'status-received';
	} else if($r_tt['status'] == 2){
		$trang_thai = 'Đang vận chuyển';
		$trang_thai_class = 'status-shipping';
	}
	else if($r_tt['status'] == 3){
		$trang_thai = 'Yêu cầu hủy đơn';
		$trang_thai_class = 'status-request-cancel';
		$cancel_message = 'Yêu cầu hủy đơn của bạn đang được xử lý. Chúng tôi sẽ phản hồi sớm nhất.';
	}
	else if($r_tt['status'] == 4){
		$trang_thai = 'Đã hủy đơn';
		$trang_thai_class = 'status-cancelled';
	} 
	else if($r_tt['status'] == 5){
		$trang_thai = 'Giao hàng thành công';
		$trang_thai_class = 'status-success';
		$show_refund_button = true;
		if($time_diff <= 7*24*60*60) {
		} else {
			$show_refund_button = false; 
			$error_message = "Chỉ có thể yêu cầu hoàn đơn trong vòng 7 ngày kể từ khi nhận hàng.";
		}
	}
	 else if($r_tt['status'] == 6){
		$trang_thai = 'Yêu cầu hoàn đơn';
		$trang_thai_class = 'status-request-refunded';
		$refund_message = 'Yêu cầu hoàn đơn của bạn đang được xử lý. Chúng tôi sẽ phản hồi sớm nhất.';
	 }
	 else if($r_tt['status'] == 7){
		$trang_thai = 'Đã hoàn đơn';
		$trang_thai_class = 'status-refunded';
	} else {
		$trang_thai = 'Chờ xử lý';
		$trang_thai_class = 'status-pending';
		$show_cancel_button = true; 
		if($time_diff <= 24*60*60) {
		} else {
			$show_cancel_button = false; 
			$error_message = "Chỉ có thể yêu cầu hủy đơn trong vòng 24h kể từ khi đặt hàng.";
		}
	}

	

// var_dump($order_time);
// var_dump($current_time);
// var_dump($time_diff);
	// die;
	
	if (isset($_POST['request_cancel']) && $r_tt['status'] == 0) {
		
		$lydo = isset($_POST['lydo']) ? trim($_POST['lydo']) : '';
		if($time_diff <= 24*60*60) {
			$update_query = mysqli_query($conn, "UPDATE donhang_shop SET status=3 WHERE ma_don='$order' AND user_id='$user_id'");
			if ($update_query) {
				
				// Gửi notification với lý do
				$noidung_notification = "Yêu cầu hủy đơn hàng: #$user_id - " . $lydo . " - " . $order;
				$date_post = time();
				mysqli_query($conn, "INSERT INTO notification (user_id, sp_id, noi_dung, doc, bo_phan, admin, date_post) VALUES ('$user_id', '$order', '$noidung_notification', '', 'donhang', '0', '$date_post')");
				$_SESSION['success_message'] = "Yêu cầu hủy đơn hàng đã được gửi thành công!";
				header("Location: /order-detail.html?id=$order");
				exit();
			} else {
				$_SESSION['error_message'] = "Có lỗi xảy ra. Vui lòng thử lại sau.";
			}
		} else {
			$show_cancel_button = false; 
			$error_message = "Chỉ có thể yêu cầu hủy đơn trong vòng 24h kể từ khi đặt hàng.";
		}
	}
	if (isset($_POST['request_refund']) && $r_tt['status'] == 5) {
		
		$lydo = isset($_POST['lydo']) ? trim($_POST['lydo']) : '';
		if($time_diff <= 7*24*60*60) {
			$update_query = mysqli_query($conn, "UPDATE donhang_shop SET status=6 WHERE ma_don='$order' AND user_id='$user_id'");
			if ($update_query) {
				
				// Gửi notification với lý do
				$noidung_notification = "Yêu cầu hoàn đơn hàng: #$user_id - " . $lydo . " - " . $order;
				$date_post = time();
				mysqli_query($conn, "INSERT INTO notification (user_id, sp_id, noi_dung, doc, bo_phan, admin, date_post) VALUES ('$user_id', '$order', '$noidung_notification', '', 'donhang', '0', '$date_post')");
				$_SESSION['success_message'] = "Yêu cầu hoàn đơn hàng đã được gửi thành công!";
				header("Location: /order-detail.html?id=$order");
				exit();
			} else {
				$_SESSION['error_message'] = "Có lỗi xảy ra. Vui lòng thử lại sau.";
			}
		} else {
			$show_cancel_button = false; 
			$error_message = "Chỉ có thể yêu cầu hoàn đơn trong vòng 7 ngày kể từ khi nhận hàng.";
		}
	}
	

	$tach_sanpham=json_decode($r_tt['sanpham'],true);
	foreach ($tach_sanpham as $key => $value) {
		if($value['size']!=''){
			$value['size']=' - Size: '.strtoupper($value['size']);
		}
		if($value['color']!=''){
			$value['color']=' - Màu: '.$value['color'];
		}
		$value['link'] = $value['link'] ?? '';
		$value['minh_hoa'] = $value['minh_hoa'] ?? '';
		$list_sanpham.=$skin->skin_replace('skin_shop/skin_5_nhat/tpl/box_li/li_sanpham_order',$value);
	}
	if($r_tt['id']<11){
		$thontin_huyen=mysqli_query($conn,"SELECT huyen.*,tinh.tieu_de AS ten_tinh FROM huyen INNER JOIN tinh ON tinh.id=huyen.tinh WHERE huyen.id='{$r_tt['huyen']}'");
	}else{
		$thontin_huyen=mysqli_query($conn,"SELECT huyen_moi.*,tinh_moi.tieu_de AS ten_tinh FROM huyen_moi INNER JOIN tinh_moi ON tinh_moi.id=huyen_moi.tinh WHERE huyen_moi.id='{$r_tt['huyen']}'");
	}
	$r_h=mysqli_fetch_assoc($thontin_huyen);
	$r_tt['tinh']=$r_h['ten_tinh'];
	$r_tt['huyen']=$r_h['tieu_de'];
	// Lấy thông tin thanh toán
	$thongtin_payments = mysqli_query($conn, "SELECT * FROM order_payments WHERE order_id='$order'");
	$r_payments = mysqli_fetch_assoc($thongtin_payments);
	if ($r_payments['payment_status'] == 'completed') {
		$tinhtrang = 'Đã thanh toán';
		$tinhtrang_class = 'status-completed';
	} elseif ($r_payments['payment_status'] == 'failed') {
		$tinhtrang = 'Thanh toán thất bại';
		$tinhtrang_class = 'status-failed';
	} else {
		$tinhtrang = 'Chưa thanh toán';
		$tinhtrang_class = 'status-pending';
	}
	$transaction_id = $r_payments['transaction_id'];
	$ngaythanhtoan=$r_payments['created_at'];
	$cancel_message_html = '';
	if (!empty($cancel_message)) {
		$cancel_message_html = '<div class="cancel-message alert alert-warning">
			<i class="fa fa-info-circle"></i> ' . $cancel_message . '
		</div>';
	}
	$refund_message_html = '';
	if (!empty($refund_message)) {
		$refund_message_html = '<div class="cancel-message alert alert-warning">
			<i class="fa fa-info-circle"></i> ' . $refund_message . '
		</div>';
	}

	// Xử lý success message 
	$success_message_html = '';
	if (!empty($_SESSION['success_message'])) {
		$success_message_html = '<div class="alert alert-success">
			<i class="fa fa-check-circle"></i> ' . $_SESSION['success_message'] . '
		</div>';
	}

	// Xử lý error message
	$error_message_html = '';
	if (!empty($error_message)) {
		$error_message_html = '<div class="alert alert-danger">
			<i class="fa fa-exclamation-circle"></i> ' . $error_message . '
		</div>';
	}
	$cancel_button_html = '';
	if ($show_cancel_button) {
		$cancel_button_html = '
			<form method="POST" style="margin-top: 20px; text-align: center;">
				<input type="hidden" name="request_cancel" value="1">
				<button type="submit" class="btn-cancel">
					<i class="fa fa-times-circle"></i> Yêu cầu hủy đơn hàng
				</button>
			</form>
		';
	}
	$refund_button_html = '';
	if ($show_refund_button) {
		$refund_button_html = '
			<form method="POST" style="margin-top: 20px; text-align: center;">
				<input type="hidden" name="request_refund" value="1">
				<button type="submit" class="btn-cancel">
					<i class="fa fa-undo"></i> Yêu cầu hoàn đơn hàng
				</button>
			</form>
		';
	}


	$tach_menu=json_decode($class_index->list_menu($conn,$s,$r_shop['user_id']),true);
	$tach_category=json_decode($class_index->list_category($conn,$r_shop['user_id']),true);
	$link_xem=(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	$google_analytics=str_replace('<script>// <![CDATA[', '<script>', $index_setting['google_analytics']);
	$google_analytics=str_replace('// ]]>', '', $google_analytics);
	$script_chat=str_replace('<script>// <![CDATA[', '<script>', $index_setting['script_footer']);
	$script_chat=str_replace('// ]]>', '', $script_chat);
	$replace=array(
		'header'=>$skin->skin_normal('skin_shop/'.$s.'/tpl/header'),
		'box_header'=>$box_header,
		'footer'=>$skin->skin_normal('skin_shop/'.$s.'/tpl/footer'),
		'script_footer'=>$skin->skin_normal('skin_shop/'.$s.'/tpl/script_footer'),
		'header_menu_mobile'=>$header_menu_mobile,
		'title'=>'Chi tiết đơn hàng #'.$order,
		'description'=>$index_setting['description'],
		'site_name'=>$index_setting['site_name'],
		'limit'=>$limit,
		'logo'=>$index_setting['logo'],
		'text_footer'=>$index_setting['text_footer'],
		'email' => $index_setting['email'], 
		'google_analytics'=>$google_analytics,
		'script_chat'=>$script_chat,
		'text_contact_footer'=>$index_setting['text_contact_footer'],
		'text_about'=>$index_setting['text_about'],
		'link_xem'=>$link_xem,
		'hotline'=>$index_setting['hotline'],
		'hotline_number'=>preg_replace('/[^0-9]/', '',$index_setting['hotline']),
		'text_hotline'=>$index_setting['text_hotline'],
		'link_facebook'=>$index_setting['link_facebook'],
		'link_google'=>$index_setting['link_google'],
		'link_youtube'=>$index_setting['link_youtube'],
		'link_twitter'=>$index_setting['link_twitter'],
		'link_instagram'=>$index_setting['link_instagram'],
		'bg_backgroud'=>$giaodien['background'],
		'bg_header'=>$giaodien['header'],
		'bg_topbar'=>$giaodien['topbar'],
		'bg_hotline'=>$giaodien['hotline'],
		'bg_menu'=>$giaodien['menu'],
		'bg_title_menu'=>$giaodien['title_menu'],
		'bg_title_box'=>$giaodien['title_box'],
		'bg_button_top'=>$giaodien['button_top'],
		'bg_subcribe'=>$giaodien['subcribe'],
		'bg_top_menu_mobile'=>$giaodien['top_menu_mobile'],
		'bg_label_sale'=>$giaodien['label_sale'],
		'bg_ma_giamgia'=>$giaodien['ma_giamgia'],
		'bg_top_footer'=>$giaodien['top_footer'],
		'bg_bottom_footer'=>$giaodien['bottom_footer'],
		'color_text_top_footer'=>$giaodien['text_top_footer'],
		'color_text_bottom_footer'=>$giaodien['text_bottom_footer'],
		'bg_timkiem'=>$giaodien['timkiem'],
		'bg_nhantin'=>$giaodien['nhantin'],
		'color_text_title_top_footer'=>$giaodien['text_title_top_footer'],
		'menu_chinhsach'=>$tach_menu['chinhsach'],
		'menu_huongdan'=>$tach_menu['huongdan'],
		'menu_top'=>$tach_menu['top'],
		'menu_mobile'=>$tach_menu['menu_mobile'],
		'category_mobile'=>$class_index->list_category_sanpham_mobile($conn,$r_shop['user_id']),
		'list_category_nav'=>$tach_category['list'],
		'list_category_left'=>$tach_category['list_left'],
		'photo'=>$index_setting['photo'],
		'phantrang'=>$phantrang,
		'fanpage'=>$index_setting['fanpage'],
		'ma_don'=>$r_tt['ma_don'],
		'ho_ten'=>$r_tt['ho_ten'],
		'dia_chi'=>$r_tt['dia_chi'],
		'dien_thoai'=>$r_tt['dien_thoai'],
		'date_post'=>date('H:i:s d/m/Y',$r_tt['date_post']),
		'trang_thai'=>$trang_thai,
		'trang_thai_class' => $trang_thai_class,
		'tamtinh'=>number_format($r_tt['tamtinh']),
		'giam'=>number_format($r_tt['giam']),
		'tongtien'=>number_format($r_tt['tongtien']),
		'list_sanpham'=>$list_sanpham,
		'huyen'=>$r_tt['huyen'],
		'tinh'=>$r_tt['tinh'],
		'shop'=>$r_shop['user_id'],
		// 'list_menu_header'=>$class_index->list_menu_header($conn, $s, $r_shop['user_id']),
		'phiship'=>number_format($r_tt['phi_ship']),
		'phuongthuc'=>$r_tt['thanhtoan'],
		'tinhtrang' => $tinhtrang,
		'tinhtrang_class' => $tinhtrang_class,
		'transaction_id'=>$transaction_id,
		'ngaythanhtoan'=>$ngaythanhtoan,
		// 'show_cancel_button' => $show_cancel_button,
		'cancel_message_html' => $cancel_message_html,
		'success_message_html' => $success_message_html, 
		'error_message_html' => $error_message_html,
		'cancel_button_html' => $cancel_button_html,
		'refund_button_html' => $refund_button_html,
		'refund_message_html'=> $refund_message_html,
		);
		unset($_SESSION['success_message']);
	echo $skin->skin_replace('skin_shop/'.$s.'/tpl/order_detail',$replace);
	?>