<?php
$huyen = intval($_POST['huyen']);
$list = $class_index->list_option_xa($conn, $huyen, 0);
echo $list;
exit();
?> 