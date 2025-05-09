<?php
			$sp_id = intval($_REQUEST['sp_id']);
			$color = addslashes(strip_tags($_REQUEST['color']));
			$size = addslashes(strip_tags($_REQUEST['size']));
			$pl = intval($_REQUEST['pl']);
			$_SESSION['drop_cart'][$sp_id]['size'] = $size;
			$_SESSION['drop_cart'][$sp_id]['color'] = $color;
			$_SESSION['drop_cart'][$sp_id]['kho'] = $kho;
			$_SESSION['drop_cart'][$sp_id]['pl'] = $pl;
?>