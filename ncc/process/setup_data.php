<?php
			$log_file = '../uploads/log-user-' . $user_id . '.txt';
			$log_text = file_get_contents($log_file);
			$tach_log = explode("\n", $log_text);
			$thongtin_domain = mysqli_query($conn, "SELECT *,(SELECT demo FROM giaodien WHERE giaodien.id=domain.skin) AS tenmien FROM domain WHERE user_id='$user_id' ORDER BY id DESC LIMIT 1");
			$r_domain = mysqli_fetch_assoc($thongtin_domain);
			$parse = parse_url($r_domain['tenmien']);
			$domain = $parse['host'];
			$thongtin_thanhvien = mysqli_query($conn, "SELECT * FROM user_info WHERE domain='$domain' ORDER BY user_id DESC LIMIT 1");
			$r_tv = mysqli_fetch_assoc($thongtin_thanhvien);
			$step = addslashes(strip_tags($_REQUEST['step']));
			$post_id = addslashes(strip_tags($_REQUEST['post_id']));
			if ($step == 'caidat') {
				foreach ($tach_log as $key => $value) {
					$tach_value = explode(':', $value);
					if ($tach_value[0] == 'caidat') {
						$status = $tach_value[1];
					}
				}
				$status = intval($status);
				if ($status == 1) {
					$tieptuc = 1;
					$next_step = 'menu';
					$post_id = '';
					$success = 1;
					$thongtin = mysqli_query($conn, "SELECT * FROM shop_setting WHERE shop='{$r_tv['user_id']}' AND name='skin_folder'");
					$r_tt = mysqli_fetch_assoc($thongtin);
					mysqli_query($conn, "UPDATE shop_setting SET value='{$r_tt['value']}',tieu_de='{$r_tt['tieu_de']}' WHERE name='skin_folder' AND shop='$user_id'");
					$text_success = '<div class="li_success success"><i class="fa fa-check-circle fa-2x"></i> <span>Hoàn thành thiết lập cài đặt.</span></div>';
					$text_tieptuc = '<div class="li_success"><i class="fa fa-cog fa-spin fa-2x"></i> <span>Đang thiết lập menu...</span></div>';

				} else {
					$thongtin = mysqli_query($conn, "SELECT * FROM shop_setting WHERE shop='{$r_tv['user_id']}'");
					while ($r_tt = mysqli_fetch_assoc($thongtin)) {
						$thongtin_caidat = mysqli_query($conn, "SELECT *,count(*) AS total FROM shop_setting WHERE name='{$r_tt['name']}' AND shop='$user_id'");
						$r_caidat = mysqli_fetch_assoc($thongtin_caidat);
						$value = addslashes($r_tt['value']);
						if ($r_tt['name'] == 'logo') {
							if ($r_caidat['total'] == 0) {
								$duoi = $check->duoi_file($r_tt['value']);
								$minh_hoa = '/uploads/minh-hoa/logo-' . time() . '.' . $duoi;
								copy('..' . $r_tt['value'], '..' . $minh_hoa);
								mysqli_query($conn, "INSERT INTO shop_setting(shop,tieu_de,name,value,loai,giao_dien,description)VALUES('$user_id','{$r_tt['tieu_de']}','{$r_tt['name']}','$minh_hoa','{$r_tt['loai']}','','{$r_tt['description']}')");
							} else {
								//mysqli_query($conn, "UPDATE shop_setting SET value='$minh_hoa',tieu_de='{$r_tt['tieu_de']}' WHERE id='{$r_caidat['id']}'");
							}

						}else if ($r_tt['name'] == 'giaodien') {
							if ($r_caidat['total'] == 0) {
								mysqli_query($conn, "INSERT INTO shop_setting(shop,tieu_de,name,value,loai,giao_dien,description)VALUES('$user_id','{$r_tt['tieu_de']}','{$r_tt['name']}','$value','{$r_tt['loai']}','','{$r_tt['description']}')");
							} else {
								mysqli_query($conn, "UPDATE shop_setting SET value='$value',tieu_de='{$r_tt['tieu_de']}' WHERE id='{$r_caidat['id']}'");
							}

						}else if ($r_tt['name'] == 'skin_folder') {
							if ($r_caidat['total'] == 0) {
								mysqli_query($conn, "INSERT INTO shop_setting(shop,tieu_de,name,value,loai,giao_dien,description)VALUES('$user_id','{$r_tt['tieu_de']}','{$r_tt['name']}','$value','{$r_tt['loai']}','','{$r_tt['description']}')");
							} else {
								mysqli_query($conn, "UPDATE shop_setting SET value='$value',tieu_de='{$r_tt['tieu_de']}' WHERE id='{$r_caidat['id']}'");
							}

						} else {
							if ($r_caidat['total'] == 0) {
								mysqli_query($conn, "INSERT INTO shop_setting(shop,tieu_de,name,value,loai,giao_dien,description)VALUES('$user_id','{$r_tt['tieu_de']}','{$r_tt['name']}','$value','{$r_tt['loai']}','','{$r_tt['description']}')");
							} else {
								//mysqli_query($conn, "UPDATE shop_setting SET value='$value',tieu_de='{$r_tt['tieu_de']}' WHERE id='{$r_caidat['id']}'");
							}
						}
						$list .= 'Đã thêm cài đặt ' . $r_tt['name'] . '<br>';
					}
					$tieptuc = 1;
					$next_step = 'menu';
					$post_id = '';
					$success = 1;
					$text_success = '<div class="li_success success"><i class="fa fa-check-circle fa-2x"></i> <span>Hoàn thành thiết lập cài đặt.</span></div>';
					$text_tieptuc = '<div class="li_success"><i class="fa fa-cog fa-spin fa-2x"></i> <span>Đang thiết lập menu...</span></div>';
					if (strpos($log_text, 'caidat:') !== false) {
						foreach ($tach_log as $key => $value) {
							$tach_value = explode(':', $value);
							if ($tach_value[0] == 'caidat') {
								$log_text_new .= "caidat:1\n";
							} else {
								$log_text_new .= $value . "\n";
							}
						}
					} else {
						$log_text_new .= $log_text . "caidat:1\n";

					}
					$fh = fopen($log_file, "w");
					fwrite($fh, $log_text_new);
					fclose($fh);

				}
			} else if ($step == 'menu') {
				foreach ($tach_log as $key => $value) {
					$tach_value = explode(':', $value);
					if ($tach_value[0] == 'menu') {
						$status = $tach_value[1];
					}
				}
				$status = intval($status);
				if ($status == 1) {
					$tieptuc = 1;
					$next_step = 'slide';
					$post_id = '';
					$success = 1;
					$text_success = '<div class="li_success success"><i class="fa fa-check-circle fa-2x"></i> <span>Hoàn thành thiết lập menu.</span></div>';
					$text_tieptuc = '<div class="li_success"><i class="fa fa-cog fa-spin fa-2x"></i> <span>Đang thiết lập slide...</span></div>';
				} else {
					$thongtin = mysqli_query($conn, "SELECT * FROM menu_shop WHERE shop='{$r_tv['user_id']}'");
					while ($r_tt = mysqli_fetch_assoc($thongtin)) {
						$thongtin_menu = mysqli_query($conn, "SELECT *,count(*) AS total FROM menu_shop WHERE menu_link='{$r_tt['menu_link']}' AND menu_vitri='{$r_tt['menu_vitri']}' AND shop='$user_id'");
						$r_mn = mysqli_fetch_assoc($thongtin_menu);
						if ($r_mn['total'] == 0) {
							mysqli_query($conn, "INSERT INTO menu_shop(shop,menu_tieude,menu_cat,menu_link,menu_target,menu_thutu,menu_loai,menu_vitri)VALUES('$user_id','{$r_tt['menu_tieude']}','{$r_tt['menu_cat']}','{$r_tt['menu_link']}','{$r_tt['menu_target']}','{$r_tt['menu_thutu']}','{$r_tt['menu_loai']}','{$r_tt['menu_vitri']}')");
						} else {
							//mysqli_query($conn, "UPDATE menu_shop SET menu_tieude='{$r_tt['menu_tieude']}',menu_thutu='{$r_tt['menu_thutu']}',menu_loai='{$r_tt['menu_loai']}' WHERE menu_id='{$r_mn['menu_id']}'");
						}
						$list .= 'Đã thêm menu ' . $r_tt['menu_tieude'] . '<br>';
					}
					$tieptuc = 1;
					$next_step = 'slide';
					$post_id = '';
					$success = 1;
					$text_success = '<div class="li_success success"><i class="fa fa-check-circle fa-2x"></i> <span>Hoàn thành thiết lập menu.</span></div>';
					$text_tieptuc = '<div class="li_success"><i class="fa fa-cog fa-spin fa-2x"></i> <span>Đang thiết lập slide...</span></div>';
					if (strpos($log_text, 'menu:') !== false) {
						foreach ($tach_log as $key => $value) {
							$tach_value = explode(':', $value);
							if ($tach_value[0] == 'menu') {
								$log_text_new .= "menu:1\n";
							} else {
								$log_text_new .= $value . "\n";
							}
						}
					} else {
						$log_text_new .= $log_text . "menu:1\n";

					}
					$fh = fopen($log_file, "w");
					fwrite($fh, $log_text_new);
					fclose($fh);

				}

			} else if ($step == 'slide') {
				foreach ($tach_log as $key => $value) {
					$tach_value = explode(':', $value);
					if ($tach_value[0] == 'slide') {
						$status = $tach_value[1];
					}
				}
				$status = intval($status);
				if ($status == 1) {
					$tieptuc = 1;
					$next_step = 'danhmuc_baiviet';
					$post_id = '';
					$success = 1;
					$text_success = '<div class="li_success success"><i class="fa fa-check-circle fa-2x"></i> <span>Hoàn thành thiết lập slide.</span></div>';
					$text_tieptuc = '<div class="li_success"><i class="fa fa-cog fa-spin fa-2x"></i> <span>Đang thiết lập danh mục bài viết...</span></div>';
				} else {
					$thongtin = mysqli_query($conn, "SELECT * FROM slide WHERE shop='{$r_tv['user_id']}'");
					while ($r_tt = mysqli_fetch_assoc($thongtin)) {
						$duoi = $check->duoi_file($r_tt['minh_hoa']);
						$minh_hoa = '/uploads/minh-hoa/' . $check->blank($r_tt['tieu_de']) . '-' . time() . '.' . $duoi;
						copy('..' . $r_tt['minh_hoa'], '..' . $minh_hoa);
						mysqli_query($conn, "INSERT INTO slide(shop,tieu_de,minh_hoa,link,target,thu_tu)VALUES('$user_id','{$r_tt['tieu_de']}','$minh_hoa','{$r_tt['link']}','{$r_tt['target']}','{$r_tt['thu_tu']}')");
						$list .= 'Đã thêm slide: ' . $r_tt['tieu_de'] . '<br>';
					}
					$data_banner = mysqli_query($conn, "SELECT * FROM banner WHERE shop_id=0");
					while ($r_banner = mysqli_fetch_assoc($data_banner)) {
						$duoi = $check->duoi_file($r_banner['minh_hoa']);
						$minh_hoa = '/uploads/minh-hoa/' . $check->blank($r_banner['tieu_de']) . '-' . time() . '.' . $duoi;
						copy('..' . $r_banner['minh_hoa'], '..' . $minh_hoa);
						mysqli_query($conn, "INSERT INTO banner(tieu_de,minh_hoa,link,bg_banner,target,thu_tu,vi_tri,shop_id)VALUES('{$r_banner['tieu_de']}','$minh_hoa','#','#fff','_blank','{$r_banner['thu_tu']}','{$r_banner['vi_tri']}','$user_id')");
						$list .= 'Đã thêm banner: ' . $r_banner['tieu_de'] . '<br>';
					}
					$tieptuc = 1;
					$next_step = 'danhmuc_baiviet';
					$post_id = '';
					$success = 1;
					$text_success = '<div class="li_success success"><i class="fa fa-check-circle fa-2x"></i> <span>Hoàn thành thiết lập slide.</span></div>';
					$text_tieptuc = '<div class="li_success"><i class="fa fa-cog fa-spin fa-2x"></i> <span>Đang thiết lập danh mục bài viết...</span></div>';
					if (strpos($log_text, 'slide:') !== false) {
						foreach ($tach_log as $key => $value) {
							$tach_value = explode(':', $value);
							if ($tach_value[0] == 'slide') {
								$log_text_new .= "slide:1\n";
							} else {
								$log_text_new .= $value . "\n";
							}
						}
					} else {
						$log_text_new .= $log_text . "slide:1\n";

					}
					$fh = fopen($log_file, "w");
					fwrite($fh, $log_text_new);
					fclose($fh);
				}

			} else if ($step == 'danhmuc_baiviet') {
				foreach ($tach_log as $key => $value) {
					$tach_value = explode(':', $value);
					if ($tach_value[0] == 'danhmuc_baiviet') {
						$status = $tach_value[1];
					}
				}
				$status = intval($status);
				if ($status == 1) {
					$tieptuc = 1;
					$next_step = 'danhmuc_sanpham';
					$post_id = '';
					$success = 1;
					$text_success = '<div class="li_success success"><i class="fa fa-check-circle fa-2x"></i> <span>Hoàn thành thiết lập danh mục bài viết.</span></div>';
					$text_tieptuc = '<div class="li_success"><i class="fa fa-cog fa-spin fa-2x"></i> <span>Đang thiết lập danh mục sản phẩm...</span></div>';
				} else {
					$thongtin = mysqli_query($conn, "SELECT * FROM category_shop WHERE shop='{$r_tv['user_id']}'");
					while ($r_tt = mysqli_fetch_assoc($thongtin)) {
						$thongtin_seo = mysqli_query($conn, "SELECT *,count(*) AS total FROM seo_shop WHERE loai='theloai' AND link='{$r_tt['cat_blank']}' AND shop='$user_id'");
						$r_seo = mysqli_fetch_assoc($thongtin_seo);
						if ($r_seo['total'] == 0) {
							mysqli_query($conn, "INSERT INTO category_shop(shop,cat_tieude,cat_icon,cat_blank,cat_noidung,cat_main,cat_index,cat_title,cat_description,cat_thutu)VALUES('$user_id','{$r_tt['cat_tieude']}','{$r_tt['cat_icon']}','{$r_tt['cat_blank']}','{$r_tt['cat_noidung']}','{$r_tt['cat_main']}','{$r_tt['cat_index']}','{$r_tt['cat_title']}','{$r_tt['cat_description']}','{$r_tt['cat_thutu']}')");
							mysqli_query($conn, "INSERT INTO seo_shop(shop,loai,link)VALUES('$user_id','theloai','{$r_tt['cat_blank']}')");
						} else {
							mysqli_query($conn, "UPDATE category_shop SET cat_tieude='{$r_tt['cat_tieude']}',cat_index='{$r_tt['cat_index']}',cat_main='{$r_tt['cat_main']}',cat_thutu='{$r_tt['cat_thutu']}',cat_title='{$r_tt['cat_title']}',cat_description='{$r_tt['cat_description']}' WHERE cat_blank='{$r_tt['cat_blank']}' AND shop='$user_id'");
						}
						$list .= 'Đã thêm danh mục: ' . $r_tt['cat_tieude'] . '<br>';
					}
					$tieptuc = 1;
					$next_step = 'danhmuc_sanpham';
					$post_id = '';
					$success = 1;
					$text_success = '<div class="li_success success"><i class="fa fa-check-circle fa-2x"></i> <span>Hoàn thành thiết lập danh mục bài viết.</span></div>';
					$text_tieptuc = '<div class="li_success"><i class="fa fa-cog fa-spin fa-2x"></i> <span>Đang thiết lập danh mục sản phẩm...</span></div>';
					if (strpos($log_text, 'danhmuc_baiviet:') !== false) {
						foreach ($tach_log as $key => $value) {
							$tach_value = explode(':', $value);
							if ($tach_value[0] == 'danhmuc_baiviet') {
								$log_text_new .= "danhmuc_baiviet:1\n";
							} else {
								$log_text_new .= $value . "\n";
							}
						}
					} else {
						$log_text_new .= $log_text . "danhmuc_baiviet:1\n";

					}
					$fh = fopen($log_file, "w");
					fwrite($fh, $log_text_new);
					fclose($fh);

				}

			} else if ($step == 'danhmuc_sanpham') {
				foreach ($tach_log as $key => $value) {
					$tach_value = explode(':', $value);
					if ($tach_value[0] == 'danhmuc_sanpham') {
						$status = $tach_value[1];
					}
				}
				$status = intval($status);
				if ($status == 1) {
					$tieptuc = 1;
					$next_step = 'bai_viet';
					$post_id = '';
					$success = 1;
					$text_success = '<div class="li_success success"><i class="fa fa-check-circle fa-2x"></i> <span>Hoàn thành thiết lập danh mục sản phẩm.</span></div>';
					$text_tieptuc = '<div class="li_success"><i class="fa fa-cog fa-spin fa-2x"></i> <span>Đang thiết lập bài viết...</span></div>';
				} else {
					$thongtin = mysqli_query($conn, "SELECT * FROM category_sanpham_shop WHERE shop='{$r_tv['user_id']}'");
					while ($r_tt = mysqli_fetch_assoc($thongtin)) {
						$thongtin_seo = mysqli_query($conn, "SELECT *,count(*) AS total FROM seo_shop WHERE loai='category' AND link='{$r_tt['cat_blank']}' AND shop='$user_id'");
						$r_seo = mysqli_fetch_assoc($thongtin_seo);
						if ($r_seo['total'] == 0) {
							$duoi = $check->duoi_file($r_tt['cat_img']);
							if (in_array($duoi, array('jpg', 'jpeg', 'png', 'gif', 'webp')) == true) {
								$minh_hoa = '/uploads/minh-hoa/' . $check->blank($r_tt['cat_tieude']) . '-' . time() . '.' . $duoi;
								copy('..' . $r_tt['cat_img'], '..' . $minh_hoa);
							} else {
								$minh_hoa = '';
							}
							mysqli_query($conn, "INSERT INTO category_sanpham_shop(shop,cat_tieude,cat_icon,cat_blank,cat_link,cat_img,cat_noidung,cat_main,cat_index,cat_title,cat_description,cat_thutu)VALUES('$user_id','{$r_tt['cat_tieude']}','{$r_tt['cat_icon']}','{$r_tt['cat_blank']}','{$r_tt['cat_link']}','$minh_hoa','{$r_tt['cat_noidung']}','{$r_tt['cat_main']}','{$r_tt['cat_index']}','{$r_tt['cat_title']}','{$r_tt['cat_description']}','{$r_tt['cat_thutu']}')");
							mysqli_query($conn, "INSERT INTO seo_shop(shop,loai,link)VALUES('$user_id','category','{$r_tt['cat_blank']}')");
						} else {
							$duoi = $check->duoi_file($r_tt['cat_img']);
							if (in_array($duoi, array('jpg', 'jpeg', 'png', 'gif', 'webp')) == true) {
								$minh_hoa = '/uploads/minh-hoa/' . $check->blank($r_tt['cat_tieude']) . '-' . time() . '.' . $duoi;
								copy('..' . $r_tt['cat_img'], '..' . $minh_hoa);
								mysqli_query($conn, "UPDATE category_sanpham_shop SET cat_tieude='{$r_tt['cat_tieude']}',cat_index='{$r_tt['cat_index']}',cat_main='{$r_tt['cat_main']}',cat_thutu='{$r_tt['cat_thutu']}',cat_link='{$r_tt['cat_link']}',cat_img='$minh_hoa',cat_title='{$r_tt['cat_title']}',cat_description='{$r_tt['cat_description']}' WHERE cat_blank='{$r_tt['cat_blank']}' AND shop='$user_id'");
							} else {
								mysqli_query($conn, "UPDATE category_sanpham_shop SET cat_tieude='{$r_tt['cat_tieude']}',cat_index='{$r_tt['cat_index']}',cat_main='{$r_tt['cat_main']}',cat_thutu='{$r_tt['cat_thutu']}',cat_link='{$r_tt['cat_link']}',cat_title='{$r_tt['cat_title']}',cat_description='{$r_tt['cat_description']}' WHERE cat_blank='{$r_tt['cat_blank']}' AND shop='$user_id'");
							}
						}
						$list .= 'Đã thêm danh mục sản phẩm: ' . $r_tt['cat_tieude'] . '<br>';
					}
					$tieptuc = 1;
					$next_step = 'bai_viet';
					$post_id = '';
					$success = 1;
					$text_success = '<div class="li_success success"><i class="fa fa-check-circle fa-2x"></i> <span>Hoàn thành thiết lập danh mục sản phẩm.</span></div>';
					$text_tieptuc = '<div class="li_success"><i class="fa fa-cog fa-spin fa-2x"></i> <span>Đang thiết lập bài viết...</span></div>';
					if (strpos($log_text, 'danhmuc_sanpham:') !== false) {
						foreach ($tach_log as $key => $value) {
							$tach_value = explode(':', $value);
							if ($tach_value[0] == 'danhmuc_sanpham') {
								$log_text_new .= "danhmuc_sanpham:1\n";
							} else {
								$log_text_new .= $value . "\n";
							}
						}
					} else {
						$log_text_new .= $log_text . "danhmuc_sanpham:1\n";

					}
					$fh = fopen($log_file, "w");
					fwrite($fh, $log_text_new);
					fclose($fh);

				}

			} else if ($step == 'bai_viet') {
				foreach ($tach_log as $key => $value) {
					$tach_value = explode(':', $value);
					if ($tach_value[0] == 'bai_viet') {
						$status = $tach_value[1];
					}
				}
				$status = intval($status);
				if ($status == 1) {
					$tieptuc = 1;
					$next_step = 'san_pham';
					$post_id = '';
					$success = 1;
					$text_success = '<div class="li_success success"><i class="fa fa-check-circle fa-2x"></i> <span>Hoàn thành thiết lập bài viết.</span></div>';
					$text_tieptuc = '<div class="li_success"><i class="fa fa-cog fa-spin fa-2x"></i> <span>Đang thiết lập sản phẩm...</span></div>';
				} else {
					$thongtin = mysqli_query($conn, "SELECT * FROM post_shop WHERE shop='{$r_tv['user_id']}'");
					while ($r_tt = mysqli_fetch_assoc($thongtin)) {
						//$cat=$r_tt['cat'];
						$tach_cat = explode(',', $r_tt['cat']);
						$k = 0;
						if($r_tt['cat']==''){
							$list_id_cat='';
						}else{
							foreach ($tach_cat as $key => $value) {
								if (intval($value) > 0) {
									$k++;
									if ($k == 1) {
										$where .= "cat_id='" . $value . "'";
									} else {
										$where .= " OR cat_id='" . $value . "'";
									}
								} else {

								}
							}
							$thongtin_cat = mysqli_query($conn, "SELECT * FROM category_shop WHERE $where ORDER BY cat_id ASC");
							unset($where);
							while ($r_cat = mysqli_fetch_assoc($thongtin_cat)) {
								$thongtin_cat_Shop = mysqli_query($conn, "SELECT * FROM category_shop WHERE shop='$user_id' AND cat_blank='{$r_cat['cat_blank']}'");
								$r_cs = mysqli_fetch_assoc($thongtin_cat_Shop);
								$list_id_cat .= $r_cs['cat_id'] . ',';
							}
							$list_id_cat = substr($list_id_cat, 0, -1);
						}
						$noidung = addslashes($r_tt['noidung']);
						$thongtin_seo = mysqli_query($conn, "SELECT *,count(*) AS total FROM seo_shop WHERE loai='baiviet' AND link='{$r_tt['link']}' AND shop='$user_id'");
						$r_seo = mysqli_fetch_assoc($thongtin_seo);
						if ($r_seo['total'] == 0) {
							$duoi = $check->duoi_file($r_tt['minh_hoa']);
							if (in_array($duoi, array('jpg', 'jpeg', 'png', 'gif', 'webp')) == true) {
								$minh_hoa = '/uploads/minh-hoa/' . $check->blank($r_tt['tieu_de']) . '-' . time() . '.' . $duoi;
								copy('..' . $r_tt['minh_hoa'], '..' . $minh_hoa);
							} else {
								$minh_hoa = '';
							}
							mysqli_query($conn, "INSERT INTO post_shop(shop,tieu_de,minh_hoa,link,cat,noidung,title,description,view,date_post)VALUES('$user_id','{$r_tt['tieu_de']}','$minh_hoa','{$r_tt['link']}','$list_id_cat','$noidung','{$r_tt['title']}','{$r_tt['description']}','0'," . time() . ")");
							mysqli_query($conn, "INSERT INTO seo_shop(shop,loai,link)VALUES('$user_id','baiviet','{$r_tt['link']}')");
						} else {
							$duoi = $check->duoi_file($r_tt['minh_hoa']);
							if (in_array($duoi, array('jpg', 'jpeg', 'png', 'gif', 'webp')) == true) {
								$minh_hoa = '/uploads/minh-hoa/' . $check->blank($r_tt['tieu_de']) . '-' . time() . '.' . $duoi;
								copy('..' . $r_tt['minh_hoa'], '..' . $minh_hoa);
								mysqli_query($conn, "UPDATE post_shop SET tieu_de='{$r_tt['tieu_de']}',link='{$r_tt['link']}',minh_hoa='$minh_hoa',noidung='$noidung',title='{$r_tt['title']}',description='{$r_tt['description']}' WHERE link='{$r_tt['link']}' AND shop='$user_id'");
							} else {
								mysqli_query($conn, "UPDATE post_shop SET tieu_de='{$r_tt['tieu_de']}',link='{$r_tt['link']}',title='{$r_tt['title']}',noidung='$noidung',description='{$r_tt['description']}' WHERE link='{$r_tt['link']}' AND shop='$user_id'");
							}
						}
						unset($list_id_cat);
						$list .= 'Đã thêm bài viết: ' . $r_tt['tieu_de'] . '<br>';
					}
					$tieptuc = 1;
					$next_step = 'san_pham';
					$post_id = '';
					$success = 1;
					$text_success = '<div class="li_success success"><i class="fa fa-check-circle fa-2x"></i> <span>Hoàn thành thiết lập bài viết.</span></div>';
					$text_tieptuc = '<div class="li_success"><i class="fa fa-cog fa-spin fa-2x"></i> <span>Đang thiết lập sản phẩm...</span></div>';
					if (strpos($log_text, 'bai_viet:') !== false) {
						foreach ($tach_log as $key => $value) {
							$tach_value = explode(':', $value);
							if ($tach_value[0] == 'bai_viet') {
								$log_text_new .= "bai_viet:1\n";
							} else {
								$log_text_new .= $value . "\n";
							}
						}
					} else {
						$log_text_new .= $log_text . "bai_viet:1\n";

					}
					$fh = fopen($log_file, "w");
					fwrite($fh, $log_text_new);
					fclose($fh);

				}

			} else if ($step == 'san_pham') {
				foreach ($tach_log as $key => $value) {
					$tach_value = explode(':', $value);
					if ($tach_value[0] == 'san_pham') {
						$status = $tach_value[1];
					}
				}
				$status = intval($status);
				if ($status == 1) {
					$tieptuc = 1;
					$next_step = 'hoantat';
					$post_id = '';
					$success = 1;
					$text_success = '<div class="li_success success"><i class="fa fa-check-circle fa-2x"></i> <span>Hoàn thành thiết lập sản phẩm.</span></div>';
					$text_tieptuc = '<div class="li_success"><i class="fa fa-cog fa-spin fa-2x"></i> <span>Đang hoàn tất thiết lập giao diện...</span></div>';
				} else {
					$thongtin = mysqli_query($conn, "SELECT * FROM sanpham_shop WHERE shop='{$r_tv['user_id']}'");
					while ($r_tt = mysqli_fetch_assoc($thongtin)) {
						if($r_tt['cat']==''){
							$list_id_cat='';
						}else{
							$tach_cat = explode(',', $r_tt['cat']);
							$k = 0;
							foreach ($tach_cat as $key => $value) {
								if (intval($value) > 0) {
									$k++;
									if ($k == 1) {
										$where .= "cat_id='" . $value . "'";
									} else {
										$where .= " OR cat_id='" . $value . "'";
									}
								} else {

								}
							}
							$thongtin_cat = mysqli_query($conn, "SELECT * FROM category_sanpham_shop WHERE $where ORDER BY cat_id ASC");
							unset($where);
							while ($r_cat = mysqli_fetch_assoc($thongtin_cat)) {
								$thongtin_cat_Shop = mysqli_query($conn, "SELECT * FROM category_sanpham_shop WHERE shop='$user_id' AND cat_blank='{$r_cat['cat_blank']}'");
								$r_cs = mysqli_fetch_assoc($thongtin_cat_Shop);
								$list_id_cat .= $r_cs['cat_id'] . ',';
							}
							$list_id_cat = substr($list_id_cat, 0, -1);
						}
						$noi_dung = addslashes($r_tt['noi_dung']);
						$noi_bat = addslashes($r_tt['noi_bat']);
						$description = addslashes($r_tt['description']);
						$tieu_de = addslashes($r_tt['tieu_de']);
						$minh_hoa = addslashes($r_tt['minh_hoa']);
						$gia_cu = addslashes($r_tt['gia_cu']);
						$gia_moi = addslashes($r_tt['gia_moi']);
						$mau = addslashes($r_tt['mau']);
						$thuong_hieu = addslashes($r_tt['thuong_hieu']);
						$size = addslashes($r_tt['size']);
						$info = addslashes($r_tt['thongtin']);
						$anh = addslashes($r_tt['anh']);
						$title = addslashes($r_tt['title']);
						$description = addslashes($r_tt['description']);
						$can_nang = addslashes($r_tt['can_nang']);
						$thongtin_seo = mysqli_query($conn, "SELECT *,count(*) AS total FROM seo_shop WHERE loai='sanpham' AND link='{$r_tt['link']}' AND shop='$user_id'");
						$r_seo = mysqli_fetch_assoc($thongtin_seo);
						if ($r_seo['total'] == 0) {
							mysqli_query($conn, "INSERT INTO sanpham_shop(sp_id,shop,tieu_de,minh_hoa,link,link_aff,cat,kho_hang,gia_cu,gia_moi,noi_bat,noi_dung,mau,thuong_hieu,size,thongtin,can_nang,anh,ban,title,description,view,date_post)VALUES('{$r_tt['sp_id']}','$user_id','{$r_tt['tieu_de']}','{$r_tt['minh_hoa']}','{$r_tt['link']}','{$r_tt['link_aff']}','$list_id_cat','0','{$r_tt['gia_cu']}','{$r_tt['gia_moi']}','$noi_bat','$noi_dung','{$r_tt['mau']}','{$r_tt['thuong_hieu']}','{$r_tt['size']}','{$r_tt['thongtin']}','$can_nang','{$r_tt['anh']}','0','$title','$description','0'," . time() . ")");
							mysqli_query($conn, "INSERT INTO seo_shop(shop,loai,link)VALUES('$user_id','sanpham','{$r_tt['link']}')");
						} else {
							mysqli_query($conn, "UPDATE sanpham_shop SET tieu_de='$tieu_de',minh_hoa='$minh_hoa',cat='$list_id_cat',gia_cu='$gia_cu',gia_moi='$gia_moi',noi_bat='$noi_bat',noi_dung='$noi_dung',mau='$mau',thuong_hieu='$thuong_hieu',size='$size',thongtin='$info',can_nang='$can_nang',anh='$anh',title='$title',description='$description' WHERE link='{$r_tt['link']}' AND shop='$user_id'");
						}
						unset($list_id_cat);
						$list .= 'Đã thêm sản phẩm: ' . $r_tt['tieu_de'] . '<br>';
					}
					$tieptuc = 1;
					$next_step = 'hoantat';
					$post_id = '';
					$success = 1;
					$text_success = '<div class="li_success success"><i class="fa fa-check-circle fa-2x"></i> <span>Hoàn thành thiết lập sản phẩm.</span></div>';
					$text_tieptuc = '<div class="li_success"><i class="fa fa-cog fa-spin fa-2x"></i> <span>Đang hoàn tất thiết lập giao diện...</span></div>';
					if (strpos($log_text, 'san_pham:') !== false) {
						foreach ($tach_log as $key => $value) {
							$tach_value = explode(':', $value);
							if ($tach_value[0] == 'san_pham') {
								$log_text_new .= "san_pham:1\n";
							} else {
								$log_text_new .= $value . "\n";
							}
						}
					} else {
						$log_text_new .= $log_text . "san_pham:1";

					}
					$fh = fopen($log_file, "w");
					fwrite($fh, $log_text_new);
					fclose($fh);

				}

			} else {
				$tieptuc = 0;
				$text_success = '<div class="li_success success"><i class="fa fa-check-circle fa-2x"></i> <span>Kết thúc toàn bộ thiết lập.</span></div>';
				$text_tieptuc = '';
				$list = 'Kết thúc toàn bộ thiết lập<br>';
				$post_id = '';
				$success = 1;
			}
			if ($user_info['domain'] != '') {
				$to = 0;
			} else {
				$to = 1;
			}
			$info = array(
				'step' => $next_step,
				'tieptuc' => $tieptuc,
				'post_id' => $post_id,
				'list' => $list,
				'success' => $success,
				'text_success' => $text_success,
				'text_tieptuc' => $text_tieptuc,
				'to' => $to,
			);
			echo json_encode($info);
?>