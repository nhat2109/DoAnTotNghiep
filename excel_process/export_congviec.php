<?php
include './includes/tlca_world.php';
require_once './PHPExcel/PHPExcel.php';
$objPHPExcel = new PHPExcel();
$objPHPExcel->setActiveSheetIndex(0)
	->setCellValue('A1', 'Mã CV')
	->setCellValue('B1', 'Bộ Phận')
	->setCellValue('C1', 'Tên CV')
	->setCellValue('D1', 'Giá')
	->setCellValue('E1', 'Giờ công')
	->setCellValue('F1', 'Loại xe')
	->setCellValue('G1', 'Mã loại xe')
	->setCellValue('H1', 'Máy')
	->setCellValue('I1', 'Số xy lanh')
	->setCellValue('J1', 'Số chỗ')
	->setCellValue('K1', 'Đại lý')
	->setCellValue('L1', 'Loại CV');
$thongtin = mysqli_query($conn, "SELECT * FROM cong_viec ORDER BY id ASC");
$i = 1;
while ($r_tt = mysqli_fetch_assoc($thongtin)) {
	$i++;
	$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('A' . $i, $r_tt['ma_cv'])
		->setCellValue('B' . $i, $r_tt['bo_phan'])
		->setCellValue('C' . $i, $r_tt['ten_cv'])
		->setCellValue('D' . $i, $r_tt['gia'])
		->setCellValue('E' . $i, $r_tt['gio_cong'])
		->setCellValue('F' . $i, $r_tt['loai_xe'])
		->setCellValue('G' . $i, $r_tt['ma_loai_xe'])
		->setCellValue('H' . $i, $r_tt['may'])
		->setCellValue('I' . $i, $r_tt['so_xy_lanh'])
		->setCellValue('J' . $i, $r_tt['so_cho'])
		->setCellValue('K' . $i, $r_tt['dai_ly'])
		->setCellValue('L' . $i, $r_tt['loai_cv']);
}
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(false);
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth("10");
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(false);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth("10");
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(false);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth("45");
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(false);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth("10");
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(false);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth("10");
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(false);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth("10");
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(false);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth("10");
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(false);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth("10");
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(false);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth("10");
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(false);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth("10");
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(false);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth("10");
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(false);
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth("10");
//ghi du lieu vao file,định dạng file excel 2007
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
ob_end_clean();
header('Content-type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename="congviec.xlsx"');
$objWriter->save('php://output');
?>