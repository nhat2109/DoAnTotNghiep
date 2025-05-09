<?php
			$congty_ship=addslashes($_REQUEST['congty_ship']);
			if($congty_ship=='ninja_van'){
				$list=$class_index->list_option_tinh_ninja($conn, '');
			}else{
				$list=$class_viettel->option_tinh('');
			}
			echo json_encode(array('list' => $list));
?>