<?php 
//4-4
$selected_ncc = isset($_REQUEST['selected_ncc']) ? trim($_REQUEST['selected_ncc']) : '';
$selected_status = isset($_REQUEST['selected_status']) ? trim($_REQUEST['selected_status']) : '';
$search = isset($_REQUEST['search']) ? trim($_REQUEST['search']) : '';

$selected_ncc = ($selected_ncc !== '') ? intval($selected_ncc) : '';
$selected_status = ($selected_status !== '') ? intval($selected_status) : '';

$result = $class_index->get_list_ncc_or_status($conn, $selected_ncc, $selected_status, $search);
$list = '<tr>
           <th style="text-align: center;width: 50px;" class="hide_mobile">STT</th>
			<th style="text-align: left;width: 150px;" class="hide_mobile">Mã Sản Phẩm</th>
			<th style="text-align: center;width: 80px;" class="hide_mobile">Minh họa</th>
			<th style="text-align: left;">Tên sản phẩm</th>
			<th style="text-align: center;width: 80px;" class="hide_mobile">Nhà cung cấp</th>  <!--//3-4-->
			<th style="text-align: center;width: 50px;" class="hide_mobile">Kho</th>
			<th style="text-align: center;width: 100px;" class="hide_mobile">Giá niêm yết</th>
			<th style="text-align: center;width: 100px;" class="hide_mobile">Giá bán Sóc Đỏ</th>
			<th style="text-align: center;width: 100px;" class="hide_mobile">Giá drop</th>
			<th style="text-align: center;width: 100px;" class="hide_mobile">Giá CTV</th>
			<th style="text-align: center;width: 140px;" class="hide_mobile">Giá bán tối thiểu</th>
			<th style="text-align: center;width: 160px;">Hành động</th>
        </tr>'.$result['list'];
$info = array(
    'ok' => $result['ok'],
    'list' => $list,
    'thongbao' => $result['thongbao']
);
echo json_encode($info);?>