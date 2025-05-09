<?php 
$thuong_hieu=intval($_REQUEST['thuong_hieu']);
if(isset($_COOKIE['admin_kho'])){
    $kho=$_COOKIE['admin_kho'];
}else{
    $kho='kho';
}
$list = $class_index->list_kq_timkiem_sanpham_thuonghieu($conn,$kho, $thuong_hieu);
$list = '<tr>
            <th style="text-align: center;width: 50px;" class="hide_mobile">STT</th>
            <th style="text-align: left;width: 150px;" class="hide_mobile">Mã Sản Phẩm</th>
            <th style="text-align: center;width: 120px;" class="hide_mobile">Minh họa</th>
            <th style="text-align: left;">Tên sản phẩm</th>
            <th style="text-align: center;width: 50px;" class="hide_mobile">Kho</th>
            <th style="text-align: center;width: 100px;" class="hide_mobile">Giá niêm yết</th>
            <th style="text-align: center;width: 100px;" class="hide_mobile">Giá bán</th>
            <th style="text-align: center;width: 100px;" class="hide_mobile">Giá drop</th>
            <th style="text-align: center;width: 100px;" class="hide_mobile">Giá CTV</th>
            <th style="text-align: center;width: 140px;" class="hide_mobile">Giá bán tối thiểu</th>
            <th style="text-align: center;width: 80px;" class="hide_mobile">View</th>
            <th style="text-align: center;width: 160px;">Hành động</th>
        </tr>'.$list;
$info = array(
    'ok' => 1,
    'list' => $list,
);
echo json_encode($info);?>