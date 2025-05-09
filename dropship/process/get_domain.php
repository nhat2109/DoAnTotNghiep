<?php
			$key_domain = addslashes(strip_tags($_REQUEST['key_domain']));
			$list_loai = addslashes(strip_tags($_REQUEST['list_loai']));
			if (strpos($list_loai, ',') !== false) {
				$tach_loai = explode(',', $list_loai);
				$i = 0;
				foreach ($tach_loai as $key => $value) {
					$i++;
					if ($i == 1) {
						$where .= "domain='$value'";

					} else {
						$where .= " OR domain='$value'";
					}
				}
			} else {
				$where = "domain='$list_loai'";
			}
			$tach_key = explode("\n", $key_domain);
			$thongtin = mysqli_query($conn, "SELECT * FROM domain_price WHERE $where ORDER BY loai ASC, thu_tu ASC");
			while ($r_tt = mysqli_fetch_assoc($thongtin)) {
				foreach ($tach_key as $key => $value) {
					if ($value != '') {
						$tenmien = trim($value).'.'.trim($r_tt['domain']);
						if ($r_tt['phi_caidat'] == 0) {
							$phi_caidat = 'Miễn phí';
						} else {
							$phi_caidat = number_format($r_tt['phi_caidat']) . 'đ';
						}
						$list .= '<tr>
									<td class="dt-gray domain" domain="' . $tenmien . '">' . $tenmien . '</td>
									<td class="dt-light dt-center">' . number_format($r_tt['gia']) . 'đ</td>
									<td class="dt-gray dt-center">' . $phi_caidat . '</td>
									<td class="dt-light dt-center">' . number_format($r_tt['gia_han']) . 'đ</td>
									<td class="dt-center dt-gray"><div class="btn-domain"><div class="loading-small"></div></div></td>
								</tr>';
					}
				}

			}
			$list = '<table cellpadding="0" cellspacing="1" class="domain-items">
						<tbody>
							<tr>
								<th>Tên miền</th>
								<th>Giá năm đầu</th>
								<th>Phí cài đặt</th>
								<th>Giá gia hạn</th>
								<th>Đặt mua</th>
							</tr>
							' . $list . '
							</tbody>
					</table>';
			echo json_encode(array('ok' => 1, 'list' => $list, 'thongbao' => $thongbao));
?>