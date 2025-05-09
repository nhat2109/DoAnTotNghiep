<?php 
$key = addslashes(strip_tags($_REQUEST['key']));
if(isset($_COOKIE['admin_kho'])){
    $kho=$_COOKIE['admin_kho'];
}else{
    $kho='kho';
}
$list = $class_index->list_kq_timkiem_sanpham_tuan($conn,$kho, $key);
$list = '<tr>
            <th style="text-align: center;width: 50px;" class="hide_mobile">STT</th>
            <th style="text-align: center;width: 80px;" class="hide_mobile">Minh họa</th>
            <th style="text-align: left;">Tên sản phẩm</th>
            <th style="text-align: left;width: 160px;">Thời gian còn lại</th>
            <th style="text-align: center;width: 50px;" class="hide_mobile">Kho</th>
            <th style="text-align: center;width: 100px;" class="hide_mobile">Giá Drop</th>
            <th style="text-align: center;width: 160px;" class="hide_mobile">Giá chương trình tuần</th>
            <th style="text-align: center;width: 100px;" class="hide_mobile">Giá CTV</th>
            <th style="text-align: center;width: 160px;" class="hide_mobile">Giá CTV tuần</th>
            <th style="text-align: center;width: 160px;">Hành động</th>
        </tr>'.$list;
$info = array(
    'ok' => 1,
    'list' => $list,
);
echo json_encode($info);
?>