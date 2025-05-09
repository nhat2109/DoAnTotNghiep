<?php
			if(isset($_SESSION['close_kh']) AND $_SESSION['close_kh']==$user_info['user_id']){
			}else{
				$_SESSION['close_kh']=$user_info['user_id'];
			}
?>