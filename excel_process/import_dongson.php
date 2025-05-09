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
for ($i = 0; $i <= $Totalrow; $i++) {
    //----Lặp cột
    for ($j = 0; $j < $TotalCol; $j++) {
        // Tiến hành lấy giá trị của từng ô đổ vào mảng
        $data[$i - 2][$j] = $sheet->getCellByColumnAndRow($j, $i)->getValue();
    }
}
//print_r($data);
foreach ($data as $key => $value) {
	if($key>1){
		if($value[0]!=''){
			$hang_muc=str_replace("\n", " ", $value[0]);
			$_SESSION['hang_muc']=$hang_muc;
		}else{
			$hang_muc=$_SESSION['hang_muc'];
		}
		if($value[1]!=''){
			$tien_cong=$value[1];
			$_SESSION['tien_cong'][$hang_muc]=$tien_cong;
		}else{

		}
		$muc_do=$value[2];
		for ($k=3; $k <= 11; $k++) { 
			$loai_xe=$data[1][$k];
			$phi=preg_replace('/[^0-9]/', '', $value[$k]);
			if( strpos($hang_muc, 'Ghi chú')!==false){
			}else{
				//echo 'Hạng mục: '.$hang_muc.' - Mức độ: '.$muc_do.' - Loại xe: '.$loai_xe.' - Phí: '.$phi.'<br>';
				//mysqli_query($conn,"INSERT INTO gia_son(hang_muc,muc_do,cong,loai_xe,phi)VALUES('$hang_muc','$muc_do','','$loai_xe','$phi')");
			}
		}
	}
}
foreach ($_SESSION['tien_cong'] as $key => $value) {
	//mysqli_query($conn,"UPDATE gia_son SET cong='$value' WHERE hang_muc='$key'");
}
//Hiển thị mảng dữ liệu
/*foreach ($data as $key => $value) {
	mysqli_query($conn,"INSERT INTO vat_tu(ma_vattu,ten_vattu,donvi_tinh,gia_ton,ton_kho,tk_vattu,tk_giavon,tk_doanhthu,tk_doanhthu_noibo,tk_tralai,tk_spdd,nhom_1,nhom_2,nhom_3,nhom_5,sl_min,sl_max,ma_kho,loai_vattu,ghi_chu,gia_mua,gia_ban,ma_thue,thue_suat,action,update_post,date_post)VALUES('$value[0]','$value[1]','$value[2]','$value[3]','$value[4]','$value[5]','$value[6]','$value[7]','$value[8]','$value[9]','$value[10]','$value[11]','$value[12]','$value[13]','$value[14]','$value[15]','$value[16]','$value[17]','$value[18]','$value[19]','$value[20]','$value[21]','$value[22]','$value[23]','$value[24]','$hientai','$hientai')");
	print_r($value);
}*/
?>