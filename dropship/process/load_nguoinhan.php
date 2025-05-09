<?php
	$page = intval($_REQUEST['page']);
	$limit = 25;
	$start = $page * $limit - $limit;
	$key = addslashes(strip_tags($_REQUEST['key']));
	$list_id = addslashes(strip_tags($_REQUEST['list_id']));
	if ($key != '') {
		if ($list_id != '') {
			$list_id = substr(addslashes(strip_tags($_REQUEST['list_id'])), 0, -1);
			$thongtin = mysqli_query($conn, "SELECT * FROM user_info WHERE user_id NOT IN ($list_id) AND (username LIKE '%$key%' OR name LIKE '%$key%' OR email LIKE '%$key%') AND shop='$user_id' ORDER BY user_id DESC LIMIT $start,$limit");
		} else {
			$thongtin = mysqli_query($conn, "SELECT * FROM user_info WHERE (username LIKE '%$key%' OR name LIKE '%$key%' OR email LIKE '%$key%') AND shop='$user_id' ORDER BY user_id DESC LIMIT $start,$limit");
		}

	} else {
		if ($list_id != '') {
			$list_id = substr(addslashes(strip_tags($_REQUEST['list_id'])), 0, -1);
			$thongtin = mysqli_query($conn, "SELECT * FROM user_info WHERE user_id NOT IN ($list_id) AND shop='$user_id' ORDER BY user_id DESC LIMIT $start,$limit");
		} else {
			$thongtin = mysqli_query($conn, "SELECT * FROM user_info WHERE shop='$user_id' ORDER BY user_id DESC LIMIT $start,$limit");
		}
	}
	$i = 0;
	while ($r_tt = mysqli_fetch_assoc($thongtin)) {
		$i++;
		$list .= $skin->skin_replace('skin_dropship/box_action/li_select_nguoinhan', $r_tt);
	}
	if ($i < $limit) {
		$tiep = 0;
	} else {
		$tiep = 1;
	}
	$page++;
	$info = array(
		'page' => $page,
		'tiep' => $tiep,
		'list' => $list,
	);
	echo json_encode($info);
?>