<?php
$list = $class_index->list_quanly($conn);
$info = array(
    'list' => $list,
);
echo json_encode($info);
