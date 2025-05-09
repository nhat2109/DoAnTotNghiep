<?php
	$loai = addslashes(strip_tags($_REQUEST['loai']));
	if ($loai == 'confirm_leader') {
		$bien=array();
		$html = $skin->skin_replace('skin_ncc/box_action/pop_confirm_leader', $bien);
		$info = array(
			'html' => $html,
		);
		echo json_encode($info);
	}else if ($loai == 'show_vongquay') {
		if($user_info['doitac']=='knv'){
			$thongtin=mysqli_query($conn,"SELECT * FROM quay_thuong WHERE user_id='$user_id'");
			$total=mysqli_num_rows($thongtin);
			if($total==0){
				$ok=1;
			}else{
				$ok=0;
			}
		}else{
			$ok=0;
		}
		$bien=array();
		$html = $skin->skin_replace('skin_ncc/box_action/vongquay', $bien);
		$info = array(
			'ok'=>$ok,
			'html' => $html,
		);
		echo json_encode($info);
	}
?>