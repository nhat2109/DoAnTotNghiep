<?php
include './includes/tlca_world.php';
require_once './PHPExcel/PHPExcel.php';
$objPHPExcel = new PHPExcel();
$objPHPExcel->setActiveSheetIndex(0)
	->setCellValue('A1', 'Tên sản phẩm')
	->setCellValue('B1', 'Kho')
	->setCellValue('C1', 'Giá niêm yết')
	->setCellValue('D1', 'Giá bán lẻ')
	->setCellValue('E1', 'Giá bán tối thiểu')
	->setCellValue('F1', 'Link sản phẩm');
$thongtin = mysqli_query($conn, "SELECT * FROM sanpham  ORDER BY id DESC, kho DESC ");
$i = 1;
while ($r_tt = mysqli_fetch_assoc($thongtin)) {
	$i++;
	if($r_tt['drop_min']==0){
		$r_tt['drop_min']='Không quy định';
	}
	$link='https://socdo.vn/product/'.$r_tt['link'].'.html';
	$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('A' . $i, $r_tt['tieu_de'])
		->setCellValue('B' . $i, $r_tt['kho'])
		->setCellValue('C' . $i, $r_tt['gia_cu'])
		->setCellValue('D' . $i, $r_tt['gia_moi'])
		->setCellValue('E' . $i, $r_tt['drop_min'])
		->setCellValue('F' . $i, $link);
}
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(false);
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth("45");
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(false);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth("10");
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(false);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth("10");
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(false);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth("10");
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(false);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth("10");
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(false);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth("30");
//ghi du lieu vao file,định dạng file excel 2007
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
ob_end_clean();
header('Content-type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename="sanpham.xlsx"');
$objWriter->save('php://output');
?>