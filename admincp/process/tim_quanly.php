<?php
$key=addslashes(strip_tags($_REQUEST['key']));
$thongtin=mysqli_query($conn,"SELECT * FROM user_info WHERE leader='1' AND (name LIKE '%$key%' OR mobile LIKE '%$key%') ORDER BY name ASC");
$total=mysqli_num_rows($thongtin);
if($total==0){
    $list='';
}else{
    $i=0;
    while ($r_tt = mysqli_fetch_assoc($thongtin)) {
        $i++;
        $r_tt['i'] = $i;
        $r_tt['created'] = date('d/m/Y', $r_tt['created']);
        $thongtin_quanly=mysqli_query($conn,"SELECT count(*) AS total FROM user_info WHERE aff='{$r_tt['user_id']}'");
        $r_ql=mysqli_fetch_assoc($thongtin_quanly);
        $r_tt['total']=$r_ql['total'];
        $list .= $skin->skin_replace('skin_cpanel/box_action/li_quanly', $r_tt);
    }
}
$info = array(
    'list' => $list,
);
echo json_encode($info);	
