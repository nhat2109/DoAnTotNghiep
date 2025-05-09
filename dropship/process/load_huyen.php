<?php
			$tinh = intval($_REQUEST['tinh']);
			$congty_ship=addslashes($_REQUEST['congty_ship']);
			if($congty_ship=='ninja_van'){
				$list=$class_index->list_option_huyen_ninja($conn,$tinh,'');
			}else{
				$list=$class_viettel->option_huyen($tinh,'');
			}
			echo json_encode(array('list' => $list));
?>