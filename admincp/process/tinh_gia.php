<?php  
$gia_drop=intval(preg_replace('/[^0-9]/', '', $_REQUEST['gia_drop']));
$drop_min=intval(preg_replace('/[^0-9]/', '', $_REQUEST['drop_min']));
$gia_ctv= $gia_drop + (($drop_min - $gia_drop)*0.3);
//$gia_ctv= ($gia_drop + $drop_min)/2;
$info = array(
    'ok' => 1,
    'gia_ctv' => number_format($gia_ctv),
);
echo json_encode($info);?>