<?php
include('./includes/tlca_world.php');
require_once './PHPExcel/PHPExcel.php';
$file = 'hang-xe.xlsx';
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
$k=0;
/*foreach ($data as $key => $value) {
	$k++;
	$tieu_de=$value[0];
	$thu_tu=$k;
	$thongtin=mysqli_query($conn,"SELECT *,count(*) AS total FROM hang_xe WHERE tieu_de='$tieu_de'");
	$r_tt=mysqli_fetch_assoc($thongtin);
	if($r_tt['total']>0){
		echo 'Hãng '.$tieu_de.' đã có trên hệ thống<br>';
	}else{
		mysqli_query($conn,"INSERT INTO hang_xe(user_id,tieu_de,thu_tu,date_post)VALUES('5','$tieu_de','$thu_tu',".time().")");
		echo 'Đã thêm hãng: '.$tieu_de.'<br>';
	}
}*/
foreach ($data as $key => $value) {
	$k++;
	$tieu_de=$value[0];
	$model=$value[1];
	$thu_tu=$k;
	$thongtin=mysqli_query($conn,"SELECT *,count(*) AS total FROM dong_xe WHERE hang_xe='$tieu_de' AND tieu_de='$model'");
	$r_tt=mysqli_fetch_assoc($thongtin);
	if($r_tt['total']>0){
		echo 'Hãng '.$tieu_de.' - '.$model.' đã có trên hệ thống<br>';
	}else{
		mysqli_query($conn,"INSERT INTO dong_xe(user_id,hang_xe,tieu_de,thu_tu,date_post)VALUES('5','$tieu_de','$model','$thu_tu',".time().")");
		echo 'Đã thêm hãng: '.$tieu_de.' - '.$model.'<br>';
	}
}
?>