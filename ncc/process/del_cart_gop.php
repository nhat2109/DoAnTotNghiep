<?php
			unset($_SESSION['drop_cart']);
			unset($_SESSION['don']);
			echo json_encode(array('ok' => 1, 'thongbao' => 'Hoàn thành xử lý'));
?>