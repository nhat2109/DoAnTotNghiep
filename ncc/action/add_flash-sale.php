<?php
	$thaythe['title'] = 'Thêm flash sale';
	$thaythe['title_action'] = 'Thêm flash sale';
	if (isset($_SESSION['selected_products'])) {
		unset($_SESSION['selected_products']);
	}
	$thaythe['box_right'] = $skin->skin_replace('skin_ncc/box_action/add_flash_sale', $r_tt);
?>