<?php
$key = addslashes(strip_tags($_REQUEST['key']));
$list = $class_index->list_kq_timkiem_donhang_ctv($conn,$key);
$list = '<tr>
            <th style="text-align: center;width: 50px;" class="hide_mobile">STT</th>
            <th style="text-align: left;">Mã đơn</th>
            <th style="text-align: left;" class="hide_mobile">Ngày</th>
            <th style="text-align: left;">ĐT TV</th>
            <th style="text-align: left;width: 150px;">Tên thành viên</th>
            <th style="text-align: left;">Điện thoại</th>
            <th style="text-align: left;width: 150px;">Họ và tên</th>
            <th style="text-align: center;">Sản phẩm</th>
            <th style="text-align: left;" class="hide_mobile">Giá trị</th>
            <th style="text-align: center;" class="hide_mobile">Tình trạng</th>
            <th style="text-align: center;width:140px;">Hành động</th>
        </tr>'.$list;
$info = array(
    'ok' => 1,
    'list' => $list,
);
echo json_encode($info);
?>