<?php
	$name = preg_replace('/[^0-9a-zA-Z_-]/', '', $_REQUEST['name']);
	$background = addslashes(strip_tags($_REQUEST['background']));
	$topbar = addslashes(strip_tags($_REQUEST['topbar']));
	$header = addslashes(strip_tags($_REQUEST['header']));
	$hotline = addslashes(strip_tags($_REQUEST['hotline']));
	$menu = addslashes(strip_tags($_REQUEST['menu']));
	$title_menu = addslashes(strip_tags($_REQUEST['title_menu']));
	$title_box = addslashes(strip_tags($_REQUEST['title_box']));
	$button_top = addslashes(strip_tags($_REQUEST['button_top']));
	$subcribe = addslashes(strip_tags($_REQUEST['subcribe']));
	$top_menu_mobile = addslashes(strip_tags($_REQUEST['top_menu_mobile']));
	$label_sale = addslashes(strip_tags($_REQUEST['label_sale']));
	$ma_giamgia = addslashes(strip_tags($_REQUEST['ma_giamgia']));
	$top_footer = addslashes(strip_tags($_REQUEST['top_footer']));
	$bottom_footer = addslashes(strip_tags($_REQUEST['bottom_footer']));
	$text_top_footer = addslashes(strip_tags($_REQUEST['text_top_footer']));
	$text_bottom_footer = addslashes(strip_tags($_REQUEST['text_bottom_footer']));
	$timkiem = addslashes(strip_tags($_REQUEST['timkiem']));
	$nhantin = addslashes(strip_tags($_REQUEST['nhantin']));
	$text_title_top_footer = addslashes(strip_tags($_REQUEST['text_title_top_footer']));
	$description = addslashes(strip_tags($_REQUEST['description'])); //5-4
	$noidung = array(
		'background' => $background,
		'topbar' => $topbar,
		'header' => $header,
		'hotline' => $hotline,
		'menu' => $menu,
		'title_menu' => $title_menu,
		'title_box' => $title_box,
		'button_top' => $button_top,
		'subcribe' => $subcribe,
		'top_menu_mobile' => $top_menu_mobile,
		'label_sale' => $label_sale,
		'ma_giamgia' => $ma_giamgia,
		'top_footer' => $top_footer,
		'bottom_footer' => $bottom_footer,
		'text_top_footer' => $text_top_footer,
		'text_bottom_footer' => $text_bottom_footer,
		'text_title_top_footer' => $text_title_top_footer,
		'timkiem' => $timkiem,
		'nhantin' => $nhantin,
	);
	$noidung = json_encode($noidung);
	mysqli_query($conn, "UPDATE shop_setting SET value='$noidung' ,description='$description' WHERE name='$name' AND shop='$user_id'");//5-4
	$ok = 1;
	$thongbao = 'Sửa cài đặt thành công!';
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
	);
	echo json_encode($info);
?>