<?php
	$link=addslashes(strip_tags($_REQUEST['link']));
	$sp_id=intval($_REQUEST['sp_id']);
	$rut_gon=$class_index->creat_random($conn,'rut_gon');
	$hientai=time();
	$thongtin_link=mysqli_query($conn,"SELECT * FROM rut_gon WHERE link='$link' AND rut_gon=''");
	$total=mysqli_num_rows($thongtin_link);
	if($total>0){
		$r_tt=mysqli_fetch_assoc($thongtin_link);
		mysqli_query($conn,"UPDATE rut_gon SET rut_gon='$rut_gon' WHERE id='{$r_tt['id']}'");
		$html='<input type="text" id="link_rutgon_aff_'.$sp_id.'" name="link_rutgon_aff" value="https://socdo.xyz/v/'.$rut_gon.'">
		<button class="copy_rutgon_aff"><i class="icofont-ui-copy"></i> copy</button>';
	}else{
		mysqli_query($conn,"INSERT INTO rut_gon(sp_id,link,rut_gon,user_id,click,date_post)VALUES('$sp_id','$link','$rut_gon','$user_id','0','$hientai')");
		$html='<input type="text" id="link_rutgon_aff_'.$sp_id.'" name="link_rutgon_aff" value="https://socdo.xyz/v/'.$rut_gon.'">
		<button class="copy_rutgon_aff"><i class="icofont-ui-copy"></i> copy</button>';
	}
	$info=array(
		'ok'=>1,
		'thongbao'=>'Tạo link rút gọn thành công',
		'html'=>$html
	);
	echo json_encode($info);
?>