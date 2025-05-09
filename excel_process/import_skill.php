<?php
include('./includes/tlca_world.php');
require_once './PHPExcel/PHPExcel.php';
$file = 'skill/son.xls';
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
        $data_x[$i - 2][$j] = $sheet->getCellByColumnAndRow($j, $i)->getValue();
        $data[$i - 2][$j] = $sheet->getCellByColumnAndRow($j, $i)->getCalculatedValue();
    }
}
$check=$tlca_do->load('class_check');
//print_r($data);
$username='tbg168';
$ten='Ngô Văn Phương';
foreach ($data as $key => $value) {
	//print_r($value);
	$congviec=$value[1];
	$diem=$value[14];
	if(strpos($data_x[$key][14], 'AVERAGE')!==false){
		$main=1;
	}else{
		$main=0;
	}
	if(strlen($congviec)>1){
		mysqli_query($conn,"INSERT INTO skill_set(username,ten,main,cong_viec,diem,phan_loai)VALUES('$username','$ten','$main','$congviec','$diem','son')");
		echo $congviec.': '.$diem.'<br>';
	}
}
?>