<?php
include('./includes/tlca_world.php');
require_once './PHPExcel/PHPExcel.php';
$file = 'scc.xlsx';
//Tiến hành xác thực file
$objFile = PHPExcel_IOFactory::identify($file);
$objData = PHPExcel_IOFactory::createReader($objFile);

//Chỉ đọc dữ liệu
$objData->setReadDataOnly(true);

// Load dữ liệu sang dạng đối tượng
$objPHPExcel = $objData->load($file);

//Lấy ra số trang sử dụng phương thức getSheetCount();
// Lấy Ra tên trang sử dụng getSheetNames();

//Chọn trang cần truy xuất
$sheet = $objPHPExcel->setActiveSheetIndex(0);

//Lấy ra số dòng cuối cùng
$Totalrow = $sheet->getHighestRow();
//Lấy ra tên cột cuối cùng
$LastColumn = $sheet->getHighestColumn();

//Chuyển đổi tên cột đó về vị trí thứ, VD: C là 3,D là 4
$TotalCol = PHPExcel_Cell::columnIndexFromString($LastColumn);

//Tạo mảng chứa dữ liệu
$data = [];

//Tiến hành lặp qua từng ô dữ liệu
//----Lặp dòng, Vì dòng đầu là tiêu đề cột nên chúng ta sẽ lặp giá trị từ dòng 2
$hientai=time();
for ($i = 2; $i <= $Totalrow; $i++) {
    //----Lặp cột
    for ($j = 0; $j < $TotalCol; $j++) {
        // Tiến hành lấy giá trị của từng ô đổ vào mảng
        $data[$i - 2][$j] = $sheet->getCellByColumnAndRow($j, $i)->getValue();
    }
}
//print_r($data);
foreach ($data as $key => $value) {
	print_r($value);
	$ma_cv=$value[0];
	$bo_phan=$value[1];
	$ten_cv=$value[2];
	$gia_cv=(float)$value[3];
	$gio_cong=(float)$value[4];
	$loai_xe=$value[5];
	$dai_ly='';
	$loai_cv='scc';
	mysqli_query($conn,"INSERT INTO cong_viec(ma_cv,bo_phan,ten_cv,gia,gio_cong,loai_xe,ma_loai_xe,may,so_xy_lanh,so_cho,dai_ly,loai_cv)VALUES('$ma_cv','$bo_phan','$ten_cv','$gia_cv','$gio_cong','$loai_xe','$ma_loai_xe','$may','$so_xy_lanh','$so_cho','$dai_ly','$loai_cv')");
	echo 'Đã thêm: '.$ten_cv.' - '.$loai_xe.'<br>';
}
?>