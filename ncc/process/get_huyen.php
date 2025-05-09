<?php
$tinh = intval($_POST['tinh']);
$list = $class_index->list_option_huyen($conn, $tinh, 0);
echo $list;
exit();
?> 