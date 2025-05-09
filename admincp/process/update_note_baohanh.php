<?php
$id=intval($_REQUEST['id']);
$noidung=addslashes($_REQUEST['noidung']);
mysqli_query($conn,"UPDATE kichhoat_baohanh SET note='$noidung' WHERE id='$id'");
