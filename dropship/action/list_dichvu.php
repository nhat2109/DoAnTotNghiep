<?php
$thaythe['title'] = 'Dịch vụ Sóc Đỏ';
$thaythe['title_action'] = 'Dịch vụ Sóc Đỏ';
$r_tt['list_goi_template'] = $class_index->list_goi_seeding($conn, 'template');
$r_tt['list_goi_setup_shopee'] = $class_index->list_goi_seeding($conn, 'setup_gianhang');
$r_tt['list_goi_copy_sanpham'] = $class_index->list_goi_seeding($conn, 'copy_sanpham');
$r_tt['list_goi_seeding_shopee'] = $class_index->list_goi_seeding($conn, 'seeding');
$thaythe['box_right'] = $skin->skin_replace('skin_dropship/box_action/list_dichvu', $r_tt);
?>