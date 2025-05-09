<?php
include('./includes/tlca_world.php');
require_once './PHPExcel/PHPExcel.php';
$file = 'go_son.xlsx';
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
	$ma_cv=$value[0];
	$ten_cv=$value[1];
	$gia_cv=$value[2];
	$loai_xe=$value[3];
	$dai_ly=$value[4];
	$loai_cv='go_son';
	mysqli_query($conn,"INSERT INTO cong_viec(ma_cv,ten_cv,gia,loai_xe,dai_ly,loai_cv)VALUES('$ma_cv','$ten_cv','$gia_cv','$loai_xe','$dai_ly','$loai_cv')");
	echo 'Đã thêm: '.$ten_cv.' - '.$loai_xe.'<br>';
}
?>