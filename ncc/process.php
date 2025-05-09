<?php
include '../includes/tlca_world.php';
include_once "../class.phpmailer.php";
$check = $tlca_do->load('class_check');
$class_viettel = $tlca_do->load('class_viettel');
$action = addslashes($_REQUEST['action']);
$class_index = $tlca_do->load('class_ncc');
$skin = $tlca_do->load('class_skin_cpanel');
$hientai = time();
if (!isset($_COOKIE['user_id'])) {
	$ok = 0;
	$thongbao = 'Bạn chưa đăng nhập';
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
	);
	echo json_encode($info);
} else {
	$class_member = $tlca_do->load('class_member');
	$tach_token = json_decode($check->token_login_decode($_COOKIE['user_id']), true);
	$user_id = $tach_token['user_id'];
	$user_info = $class_member->user_info($conn, $_COOKIE['user_id']);
	if ($user_info['ctv'] != 1) {
		$thongbao = "Tài khoản của bạn không phải ncc...";
		$ok = 0;
		$info = array(
			'ok' => $ok,
			'thongbao' => $thongbao,
		);
		echo json_encode($info);
	}

	if ($_POST['action'] == 'filter_date') {
		$from_date = isset($_POST['from_date']) ? mysqli_real_escape_string($conn, $_POST['from_date']) : '';
		$to_date = isset($_POST['to_date']) ? mysqli_real_escape_string($conn, $_POST['to_date']) : '';

		if (!$from_date || !$to_date) {
			echo json_encode(['success' => false, 'message' => 'Vui lòng chọn đầy đủ ngày bắt đầu và ngày kết thúc']);
			exit;
		}

		// Chuyển đổi ngày từ dd/mm/yyyy sang yyyy-mm-dd cho SQL
		$from_date = date('Y-m-d', strtotime(str_replace('/', '-', $from_date)));
		$to_date = date('Y-m-d', strtotime(str_replace('/', '-', $to_date)));

		$query = "SELECT n.id, n.date_post, n.sotien, n.status, l.noidung
				  FROM naptien n
				  LEFT JOIN lichsu_chitieu l ON n.user_id = l.user_id AND n.date_post = l.date_post
				  WHERE n.user_id='$user_id' 
				  AND DATE(FROM_UNIXTIME(n.date_post)) BETWEEN '$from_date' AND '$to_date'
				  ORDER BY n.date_post DESC";

		$result = mysqli_query($conn, $query);
		if (!$result) {
			echo json_encode(['success' => false, 'message' => 'Lỗi truy vấn: ' . mysqli_error($conn)]);
			exit;
		}

		$html = '';
		while ($row = mysqli_fetch_assoc($result)) {
			$date = date('d/m/Y H:i', $row['date_post']);
			$sotien = number_format($row['sotien'], 0, ',', '.') . " VNĐ";
			$noidung = !empty($row['noidung']) ? $row['noidung'] : 'Không có';
			$statusClass = ['status-pending', 'status-approved', 'status-cancelled'][$row['status']] ?? 'status-unknown';
			$statusText = ['Chờ xử lý', 'Đã duyệt', 'Đã hủy'][$row['status']] ?? 'Không xác định';

			$html .= "
			
				<tr>
					<td style='text-align: center;'>{$row['id']}</td>
					<td style='text-align: left;'>{$date}</td>
					<td style='text-align: right;'>{$sotien}</td>
					<td style='text-align: left;'>{$noidung}</td>
					<td style='text-align: center;'><span class='{$statusClass}'>{$statusText}</span></td>
				</tr>
			";
		}

		echo json_encode(['success' => true, 'html' => $html ?: '<tr><td colspan="5" class="text-center">Không có dữ liệu</td></tr>']);
	} else if ($action == 'filter_status' || $action == 'filter_date') {
		// Kiểm tra đăng nhập
		if (!isset($user_id)) {
			echo json_encode(['success' => false, 'message' => 'Chưa đăng nhập']);
			exit;
		}

		// Xây dựng WHERE clause
		$where = "n.user_id='$user_id'";

		// Thêm điều kiện status nếu có
		if (isset($_POST['status']) && $_POST['status'] !== 'all') {
			$status = mysqli_real_escape_string($conn, $_POST['status']);
			$where .= " AND n.status='$status'";
		}

		// Thêm điều kiện date nếu có
		if (!empty($_POST['from_date']) && !empty($_POST['to_date'])) {
			$from_date = mysqli_real_escape_string($conn, $_POST['from_date']);
			$to_date = mysqli_real_escape_string($conn, $_POST['to_date']);
			$where .= " AND DATE(FROM_UNIXTIME(n.date_post)) BETWEEN '$from_date' AND '$to_date'";
		}

		try {
			// Query với LEFT JOIN
			$query = "SELECT n.id, n.date_post, n.sotien, n.status, l.noidung
					 FROM naptien n
					 LEFT JOIN lichsu_chitieu l ON n.user_id = l.user_id 
					 AND n.date_post = l.date_post
					 WHERE $where
					 ORDER BY n.id DESC";

			$result = mysqli_query($conn, $query);
			if (!$result) {
				throw new Exception(mysqli_error($conn));
			}

			$html = '';
			$stt = mysqli_num_rows($result);

			while ($row = mysqli_fetch_assoc($result)) {
				$date = date('d/m/Y H:i', $row['date_post']);
				$sotien = number_format($row['sotien'], 0, ',', '.') . " VNĐ";
				$noidung = !empty($row['noidung']) ? htmlspecialchars($row['noidung']) : 'Không có';

				// Xử lý trạng thái
				switch ($row['status']) {
					case '0':
						$statusClass = 'status-pending';
						$statusText = 'Chờ xử lý';
						break;
					case '1':
						$statusClass = 'status-approved';
						$statusText = 'Đã duyệt';
						break;
					case '2':
						$statusClass = 'status-cancelled';
						$statusText = 'Đã hủy';
						break;
					default:
						$statusClass = 'status-unknown';
						$statusText = 'Không xác định';
				}

				$html .= "<tr>
					<td class='text-center'>{$stt}</td>
					<td>{$date}</td>
					<td class='text-right'>{$sotien}</td>
					<td>{$noidung}</td>
					<td class='text-center'><span class='{$statusClass}'>{$statusText}</span></td>
				</tr>";

				$stt--;
			}

			echo json_encode([
				'success' => true,
				'html' => $html,
				'total' => mysqli_num_rows($result)
			]);
		} catch (Exception $e) {
			error_log("Filter error: " . $e->getMessage());
			echo json_encode([
				'success' => false,
				'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
			]);
		}
		exit;
	} else if ($action == 'sudung_sodu') {
		// Kiểm tra user đã đăng nhập
		if (!isset($user_id)) {
			echo json_encode([
				'ok' => 0,
				'thongbao' => 'Vui lòng đăng nhập để thực hiện thao tác này'
			]);
			exit;
		}

		// Kiểm tra số dư
		$user_money = $class_member->user_money($conn, $user_id);
		$active_price = 2500000; // Giá kích hoạt tài khoản

		if ($user_money < $active_price) {
			echo json_encode([
				'ok' => 0,
				'thongbao' => 'Số dư không đủ để kích hoạt tài khoản',
				'step2' => '<div class="payment_info">
							 <p>Số dư hiện tại: ' . number_format($user_money) . ' VNĐ</p>
							 <p>Số tiền cần nạp thêm: ' . number_format($active_price - $user_money) . ' VNĐ</p>
							 <a href="/ncc/nap-tien" class="btn-naptien">Nạp tiền ngay</a>
						   </div>'
			]);
			exit;
		}

		// Tiến hành kích hoạt tài khoản
		try {
			mysqli_begin_transaction($conn);

			// Trừ tiền
			$new_money = $user_money - $active_price;
			$update_money = mysqli_query($conn, "UPDATE member SET money = '$new_money' WHERE user_id = '$user_id'");

			// Cập nhật trạng thái kích hoạt
			$update_status = mysqli_query($conn, "UPDATE member SET activated = 1, activated_date = '$hientai' WHERE user_id = '$user_id'");

			// Lưu lịch sử chi tiêu
			$noidung = "Kích hoạt tài khoản nhà cung cấp";
			$insert_history = mysqli_query($conn, "INSERT INTO lichsu_chitieu (user_id, sotien, truoc, sau, noidung, date_post) 
												 VALUES ('$user_id', '$active_price', '$user_money', '$new_money', '$noidung', '$hientai')");

			if ($update_money && $update_status && $insert_history) {
				mysqli_commit($conn);
				echo json_encode([
					'ok' => 1,
					'thongbao' => '<div class="success">Kích hoạt tài khoản thành công!</div>'
				]);
			} else {
				throw new Exception("Lỗi cập nhật dữ liệu");
			}
		} catch (Exception $e) {
			mysqli_rollback($conn);
			echo json_encode([
				'ok' => 2,
				'thongbao' => 'Có lỗi xảy ra: ' . $e->getMessage()
			]);
		}
		exit;
	} else if ($action == 'filter_date') {
		$where = "user_id = '$user_id'";

		if ($start_date && $end_date) {
			$start_timestamp = DateTime::createFromFormat('d/m/Y', $start_date)->getTimestamp();
			$end_timestamp = DateTime::createFromFormat('d/m/Y', $end_date)->getTimestamp();
			$where[] = "created BETWEEN $start_timestamp AND $end_timestamp";
		}

		$sql = "SELECT id, sotien, truoc, sau, noidung, date_post 
					FROM lichsu_chitieu 
					WHERE $where
					ORDER BY date_post DESC";

		$list_chitieu_query = mysqli_query($conn, $sql);

		if (!$list_chitieu_query) {
			error_log("SQL Error: " . mysqli_error($conn));
			$info = array('success' => false, 'message' => 'Database error');
			echo json_encode($info);
			exit;
		}

		$html = '';
		$stt = 1;

		while ($row = mysqli_fetch_assoc($list_chitieu_query)) {
			$date = date('d/m/Y', $row['date_post']);
			$html .= '
					<tr>
						<td style="text-align: center;">' . $stt++ . '</td>
						<td>' . $date . '</td>
						<td style="text-align: right;">' . number_format($row['sotien'], 0, ',', '.') . ' VNĐ</td>
						<td>' . htmlspecialchars($row['noidung']) . '</td>
						<td style="text-align: right;">' . number_format($row['truoc'], 0, ',', '.') . ' VNĐ</td>
						<td style="text-align: right;">' . number_format($row['sau'], 0, ',', '.') . ' VNĐ</td>
					</tr>
				';
		}

		$info = array(
			'success' => true,
			'html' => $html ?: '<tr><td colspan="6" style="text-align:center;">Không có dữ liệu</td></tr>'
		);

		echo json_encode($info);
		exit;
	} else if ($action == 'edit_banner') {
		$id = addslashes($_POST['id']);
		$tieu_de = addslashes($_POST['tieu_de']);
		$link = addslashes($_POST['link']);
		$vi_tri = addslashes($_POST['vi_tri']);
		$thu_tu = addslashes($_POST['thu_tu']);
		$target = addslashes($_POST['target']);
		$bg_banner = addslashes($_POST['bg_banner']);
		$shop_id = addslashes($_POST['shop_id']);
		$minh_hoa_cu = addslashes($_POST['minh_hoa_cu']);

		if (isset($_FILES['minh_hoa']) && $_FILES['minh_hoa']['error'] == 0) {
			$target_dir = "../uploads/minh-hoa/";
			$file_extension = pathinfo($_FILES["minh_hoa"]["name"], PATHINFO_EXTENSION);
			$new_filename = uniqid() . '.' . $file_extension;
			$target_file = $target_dir . $new_filename;

			if (move_uploaded_file($_FILES["minh_hoa"]["tmp_name"], $target_file)) {
				$minh_hoa = "/uploads/minh-hoa/" . $new_filename;
				if ($minh_hoa_cu && file_exists(".." . $minh_hoa_cu)) {
					unlink(".." . $minh_hoa_cu);
				}
			} else {
				$minh_hoa = $minh_hoa_cu;
			}
		} else {
			$minh_hoa = $minh_hoa_cu;
		}
		$query = "UPDATE banner SET 
				  tieu_de = '$tieu_de',
				  link = '$link',
				  minh_hoa = '$minh_hoa',
				  bg_banner = '$bg_banner',
				  target = '$target',
				  vi_tri = '$vi_tri',
				  thu_tu = '$thu_tu',
				  shop_id = '$shop_id'
				  WHERE id = '$id'";

		if (mysqli_query($conn, $query)) {
			$thongbao = "Cập nhật banner thành công!";
			$ok = 1;
		} else {
			$thongbao = "Lỗi: " . mysqli_error($conn);
			$ok = 0;
		}

		$info = array(
			'ok' => $ok,
			'thongbao' => $thongbao
		);
		echo json_encode($info);
		exit();
	} else {
		$socdo_setting = mysqli_query($conn, "SELECT * FROM index_setting ORDER BY name ASC");
		while ($r_sd = mysqli_fetch_assoc($socdo_setting)) {
			$ss_setting[$r_sd['name']] = $r_sd['value'];
		}
		$setting = mysqli_query($conn, "SELECT * FROM shop_setting WHERE shop='$user_id' ORDER BY name ASC");
		while ($r_s = mysqli_fetch_assoc($setting)) {
			$index_setting[$r_s['name']] = $r_s['value'];
		}
		$file_action = 'process/' . $action . '.php';
		// var_dump($file_action);
		// die();
		if (file_exists($file_action)) {
			include($file_action);
		} else {
			echo "Không có hành động nào được xử lý";
		}
	}
}
