<?php
	$loai = addslashes(strip_tags($_REQUEST['loai']));
	if ($loai == 'add_yeucau_lienhe') {
		$thanh_vien=intval($_REQUEST['thanh_vien']);
		$bien = array(
			'thanh_vien'=>$thanh_vien
		);
		$html = $skin->skin_replace('skin_dropship/box_action/pop_add_yeucau', $bien);
	}
	$info = array(
		'html' => $html,
	);
	echo json_encode($info);
?>