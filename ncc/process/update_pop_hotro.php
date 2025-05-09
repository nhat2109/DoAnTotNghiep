<?php
	$thongtin_pop_hotro=mysqli_query($conn,"SELECT * FROM pop_hotro WHERE user_id='$user_id'");
	$total_hotro=mysqli_num_rows($thongtin_pop_hotro);
	if($total_hotro==0){
		mysqli_query($conn,"INSERT INTO pop_hotro(user_id,thoi_gian,note,lan,date_post)VALUES('$user_id','','','1','$hientai')");
	}else{
		$r_ht=mysqli_fetch_assoc($thongtin_pop_hotro);
		if($r_ht['thoi_gian']=='' AND $r_ht['lan']<3){
			$lan_moi = $r_ht['lan'] + 1;
			mysqli_query($conn,"UPDATE pop_hotro SET lan='$lan_moi' WHERE user_id='$user_id'");
		}else{
		}

	}
	$info = array(
		'ok' => 1,
	);
	echo json_encode($info);
?>