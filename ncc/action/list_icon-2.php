<?php
	$thaythe['title'] = 'Danh sách icon 2';
	$thaythe['title_action'] = 'Danh sách icon 2';
	$x = file_get_contents('../skin_ncc/css/icomoon.min.css');
	preg_match_all('/\.icon-(.*?):before/', $x, $tach_icon);
	foreach ($tach_icon[1] as $key => $value) {
		$r_tt['icon'] = 'icon icon-' . $value;
		$list .= $skin->skin_replace('skin_ncc/box_action/li_icon', $r_tt);
	}
	$bien = array(
		'tieu_de' => 'Danh sách icon 2',
		'list_icon' => $list,
	);
	$thaythe['box_right'] = $skin->skin_replace('skin_ncc/box_action/list_icon', $bien);
?>