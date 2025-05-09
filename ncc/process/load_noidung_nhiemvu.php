<?php
	$noidung=intval($_REQUEST['noidung']);
	$thongtin=mysqli_query($conn,"SELECT *,count(*) AS total FROM noidung_nhiemvu WHERE id='$noidung'");
	$r_tt=mysqli_fetch_assoc($thongtin);
	$tach_anh=explode(',', $r_tt['hinh_anh']);
	foreach ($tach_anh as $key => $value) {
		if(strlen($value)>0){
			$pt['src']=$value;
			$duoi = $check->duoi_file($value);
			if(in_array($duoi, array('mp4','wmv','mov'))==true){
				$list_anh .= $skin->skin_replace('skin_ncc/box_action/li_video_share', $pt);
			}else{
				$list_anh .= $skin->skin_replace('skin_ncc/box_action/li_anh_share', $pt);

			}
		}
	}
	$noidung_share=preg_replace('/ style="(.*?)"/',"", $r_tt['noi_dung']);
	$noidung_share=str_replace('<br>', "<br>\n", $noidung_share);
	$noidung_share=str_replace('<br />', "<br />\n", $noidung_share);
	$noidung_share=str_replace('</p>', "</p>\n", $noidung_share);
	$noidung_share=strip_tags($noidung_share);
	$info=array(
		'noidung'=>$r_tt['noi_dung'],
		'noidung_share'=>$noidung_share,
		'list_anh'=>$list_anh
	);
	echo json_encode($info);
?>