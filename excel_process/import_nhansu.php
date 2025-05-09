<?php
include('./includes/tlca_world.php');
require_once './PHPExcel/PHPExcel.php';
$file = './nhan-su/xuong_truong.xls';
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
$check=$tlca_do->load('class_check');
//print_r($data);
foreach ($data as $key => $value) {
	$username=strtolower($value[1]);
	$ho_ten=addslashes($value[2]);
	$ngay_vao=addslashes($value[3]);
	$chuc_danh=addslashes($value[4]);
	$vi_tri=addslashes($value[5]);
	$phong=addslashes($value[6]);
	$gioi_tinh=addslashes($value[7]);
	$ngay_sinh=addslashes($value[8]);
	$dien_thoai=addslashes($value[9]);
	$email=addslashes($value[10]);
	$nhom='xuong_truong';
	$phan_loai='';
	$salt=$check->random_string(6);
	$password=md5('123123'.$salt);
	if($username!=''){
		mysqli_query($conn,"INSERT INTO nhan_su(username,password,salt,email,name,avatar,mobile,ngaysinh,gioi_tinh,dia_chi,ngay_vao,chuc_danh,vi_tri,phong_ban,active,nhom,phan_loai,busy,end_online,created,date_update)VALUES('$username','$password','$salt','$email','$ho_ten','','$dien_thoai','$ngay_sinh','$gioi_tinh','','$ngay_vao','$chuc_danh','$vi_tri','$phong','1','$nhom','$phan_loai','0','',".time().",".time().")");
	}
	print_r($value);

}
?>