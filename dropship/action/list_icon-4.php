<?php
	$thaythe['title'] = 'Danh sách icon 4';
	$thaythe['title_action'] = 'Danh sách icon 4';
	$x = file_get_contents('../skin_dropship/css/font-glyphicon.css');
	preg_match_all('/\.glyphicon-(.*?):before/', $x, $tach_icon);
	foreach ($tach_icon[1] as $key => $value) {
		$r_tt['icon'] = 'glyphicon glyphicon-' . $value;
		$list .= $skin->skin_replace('skin_dropship/box_action/li_icon', $r_tt);
	}
	$bien = array(
		'tieu_de' => 'Danh sách icon 4',
		'list_icon' => $list,
	);
	$thaythe['box_right'] = $skin->skin_replace('skin_dropship/box_action/list_icon', $bien);
?>