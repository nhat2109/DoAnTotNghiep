<?php
	$thongtin=mysqli_query($conn,"SELECT * FROM notification WHERE admin='0' AND FIND_IN_SET($user_id,doc)<1 AND date_post>'{$user_info['created']}'");
	$total=mysqli_num_rows($thongtin);
	$info=array(
		'ok'=>1,
		'total_notification'=>$total,
	);
	echo json_encode($info);
?>