<?php 
$tieu_de=addslashes(strip_tags($_REQUEST['tieu_de']));
$link=$check->blank($tieu_de);
$thu_tu=intval(strip_tags($_REQUEST['thu_tu']));
if($tieu_de==''){
    $ok=0;
    $thongbao='Vui lòng nhập tiêu đề danh mục';
}else if($thu_tu==''){
    $ok=0;
    $thongbao='Vui lòng nhập thứ tự';
}else{
    mysqli_query($conn,"INSERT INTO category_video(tieu_de,link,thu_tu)VALUES('$tieu_de','$link','$thu_tu')");
    $ok=1;
    $thongbao='Thêm danh mục video thành công';
}
$info = array(
    'ok' => $ok,
    'thongbao' => $thongbao,
);
echo json_encode($info);?>