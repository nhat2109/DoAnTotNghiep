<?php
			// $status = intval($_REQUEST['status']);
			// $id = intval($_REQUEST['id']);
			// $thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM donhang_shop WHERE id='$id' AND shop='$user_id'");
			// $r_tt = mysqli_fetch_assoc($thongtin);
			// if ($r_tt['total'] == 0) {
			// 	$ok = 0;
			// 	$thongbao = 'Thất bại! Đơn hàng không tồn tại';
			// } else {
			// 	if ($status == 0) {
			// 		if ($r_tt['status'] == 0) {
			// 			mysqli_query($conn, "UPDATE donhang_shop SET status='$status' WHERE id='$id' AND shop='$user_id'");
			// 			$thongbao = 'Lưu thay đổi thành công';
			// 			$ok = 1;
			// 		} else {
			// 			$ok = 0;
			// 			$thongbao = 'Thất bại! Không thể lưu trạng thái này';
			// 		}

			// 	} else if ($status == 1) {
			// 		if ($r_tt['status'] == 0) {
			// 			mysqli_query($conn, "UPDATE donhang_shop SET status='$status' WHERE id='$id' AND shop='$user_id'");
			// 			$thongbao = 'Lưu thay đổi thành công';
			// 			$ok = 1;
			// 		} else {
			// 			$ok = 0;
			// 			$thongbao = 'Thất bại! Không thể lưu trạng thái này';
			// 		}

			// 	} else if ($status == 2) {
			// 		if ($r_tt['status'] == 0 OR $r_tt['status'] == 1) {
			// 			mysqli_query($conn, "UPDATE donhang_shop SET status='$status' WHERE id='$id' AND shop='$user_id'");
			// 			$thongbao = 'Lưu thay đổi thành công';
			// 			$ok = 1;
			// 		} else {
			// 			$ok = 0;
			// 			$thongbao = 'Thất bại! Không thể lưu trạng thái này';
			// 		}
			// 	} else if ($status == 3) {
			// 		if ($r_tt['status'] == 0) {
			// 			mysqli_query($conn, "UPDATE donhang_shop SET status='$status' WHERE id='$id' AND shop='$user_id'");
			// 			$thongbao = 'Lưu thay đổi thành công';
			// 			$ok = 1;
			// 		} else {
			// 			$ok = 0;
			// 			$thongbao = 'Thất bại! Không thể lưu thay đổi';
			// 		}
			// 	} else if ($status == 4) {
			// 		if ($r_tt['status'] == 3) {
			// 			mysqli_query($conn, "UPDATE donhang_shop SET status='$status' WHERE id='$id' AND shop='$user_id'");
			// 			$thongbao = 'Lưu thay đổi thành công';
			// 			$ok = 1;
			// 		} else {
			// 			$ok = 0;
			// 			$thongbao = 'Thất bại! Không thể lưu trạng thái này';
			// 		}
			// 	} else if ($status == 5) {
			// 		if ($r_tt['status'] != 3 AND $r_tt['status'] != 4 AND $r_tt['status'] != 7 AND $r_tt['status'] != 6 AND $r_tt['status'] != 0) {
			// 			mysqli_query($conn, "UPDATE donhang_shop SET status='$status' WHERE id='$id' AND shop='$user_id'");
			// 			if ($r_tt['status'] != 5) {
						
			// 			}
			// 			$thongbao = 'Lưu thay đổi thành công';
			// 			$ok = 1;
			// 		} else {
			// 			$ok = 0;
			// 			$thongbao = 'Thất bại! Không thể lưu trạng thái này';
			// 		}
			// 	} else if ($status == 6) {
			// 		if ($r_tt['status'] == 5) {
			// 			mysqli_query($conn, "UPDATE donhang_shop SET status='$status' WHERE id='$id' AND shop='$user_id'");
			// 			$thongbao = 'Lưu thay đổi thành công';
			// 			$ok = 1;
			// 		} 
			// 		else {
			// 			$ok = 0;
			// 			$thongbao = 'Thất bại! Không thể lưu trạng thái này';
			// 		}
			// 	} 
			// 	else if ($status == 7) {
			// 		if ($r_tt['status'] == 6) {
			// 			mysqli_query($conn, "UPDATE donhang_shop SET status='$status' WHERE id='$id' AND shop='$user_id'");
			// 			$thongbao = 'Lưu thay đổi thành công';
			// 			$ok = 1;
			// 		} else {
			// 			$ok = 0;
			// 			$thongbao = 'Thất bại! Không thể lưu trạng thái này';
			// 		}
			// 	}
			// }
			// $info = array(
			// 	'ok' => $ok,
			// 	'thongbao' => $thongbao,
			// );
			// echo json_encode($info);

			
$status = intval($_REQUEST['status']);
$id = intval($_REQUEST['id']);
$thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM donhang_shop WHERE id='$id' AND shop='$user_id'");
$r_tt = mysqli_fetch_assoc($thongtin);

if ($r_tt['total'] == 0) {
    $ok = 0;
    $thongbao = 'Thất bại! Đơn hàng không tồn tại';
} else {
    // Start transaction
    mysqli_query($conn, "START TRANSACTION");

    $current_status = $r_tt['status'];
    $stock_deducted = $r_tt['stock_deducted'];
    $sanpham = json_decode($r_tt['sanpham'], true);
    $hientai = time();

    // Validate status transitions
    $valid_transition = false;
    $update_stock = false;
    $restore_stock = false;
    $increment_sales = false;

    switch ($status) {
        case 0: // Chờ xử lý
            if ($current_status == 0) {
                $valid_transition = true;
            }
            break;
        case 1: // Đã tiếp nhận đơn
            if ($current_status == 0) {
                $valid_transition = true;
            }
            break;
        case 2: // Đã giao đơn vị vận chuyển
            if ($current_status == 0 || $current_status == 1) {
                $valid_transition = true;
            }
            break;
        case 3: // Yêu cầu hủy đơn
            if ($current_status == 0) {
                $valid_transition = true;
            }
            break;
        case 4: // Xác nhận hủy đơn
            if ($current_status == 3) {
                $valid_transition = true;
                if ($stock_deducted) {
                    $restore_stock = true;
                }
            }
            break;
        case 5: // Giao thành công
            if ($current_status != 3 && $current_status != 4 && $current_status != 6 && $current_status != 7 && $current_status != 0) {
                $valid_transition = true;
                if ($current_status != 5) {
                    $increment_sales = true;
                }
            }
            break;
        case 6: // Yêu cầu hoàn đơn
            if ($current_status == 5) {
                $valid_transition = true;
            }
            break;
        case 7: // Đã hoàn đơn
            if ($current_status == 6) {
                $valid_transition = true;
                if ($stock_deducted) {
                    $restore_stock = true;
                }
            }
            break;
        default:
            $valid_transition = false;
            break;
    }

    if (!$valid_transition) {
        mysqli_query($conn, "ROLLBACK");
        $ok = 0;
        $thongbao = 'Thất bại! Không thể chuyển sang trạng thái này';
    } else {
        // Update stock if needed
        if ($restore_stock) {
            foreach ($sanpham as $item) {
                $sp_id = intval($item['sp_id']);
                $variant_id = intval($item['variant_id'] ?? 0);
                $quantity = intval($item['soluong']);

                // Restore sanpham_shop.kho_hang
                mysqli_query($conn, "UPDATE sanpham_shop SET kho_hang = kho_hang + $quantity WHERE id='$sp_id' AND shop='$user_id'");
				// emysqli_query($conn, "UPDATE sanpham_shop SET ban = GREATEST(ban - $quantity, 0) WHERE id = '$sp_id' AND shop = '$user_id'");
                if ($variant_id) {
                    // Check if it's a flash sale product
                    $deal_query = mysqli_query($conn, "SELECT id, sub_product FROM deal WHERE date_start <= '$hientai' AND date_end >= '$hientai' AND FIND_IN_SET('$sp_id', main_product) AND shop='$user_id' AND loai='flash_sale' FOR UPDATE");
                    $deal = mysqli_fetch_assoc($deal_query);
                    if ($deal) {
                        $sub_product = json_decode($deal['sub_product'], true);
                        foreach ($sub_product[$sp_id] as &$variant) {
                            if ($variant['variant_id'] == $variant_id) {
                                $variant['so_luong'] += $quantity;
                            }
                        }
                        $new_sub_product = json_encode($sub_product, JSON_UNESCAPED_UNICODE);
                        mysqli_query($conn, "UPDATE deal SET sub_product = '$new_sub_product' WHERE id='{$deal['id']}'");
                    }

                    // Restore phanloai_sanpham_shop.kho_sanpham_shop
                    mysqli_query($conn, "UPDATE phanloai_sanpham_shop SET kho_sanpham_shop = kho_sanpham_shop + $quantity WHERE id='$variant_id' AND sp_id='$sp_id'");
                }
            }
            // Update stock_deducted flag
            mysqli_query($conn, "UPDATE donhang_shop SET stock_deducted = 0 WHERE id='$id' AND shop='$user_id'");
        }

        // Increment sales for "Giao thành công"
        if ($increment_sales) {
            foreach ($sanpham as $item) {
                $sp_id = intval($item['sp_id']);
                $quantity = intval($item['soluong']);
                mysqli_query($conn, "UPDATE sanpham_shop SET ban = ban + $quantity WHERE id='$sp_id' AND shop='$user_id'");
            }
        }

        // Update order status
        mysqli_query($conn, "UPDATE donhang_shop SET status='$status' WHERE id='$id' AND shop='$user_id'");

        // Commit transaction
        mysqli_query($conn, "COMMIT");

        $ok = 1;
        $thongbao = 'Lưu thay đổi thành công';
    }

    $info = array(
        'ok' => $ok,
        'thongbao' => $thongbao,
    );
    echo json_encode($info);
}
?>