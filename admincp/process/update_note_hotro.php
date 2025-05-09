<?php

$id = intval($_REQUEST['id']);
$noidung = addslashes($_REQUEST['noidung']);
mysqli_query($conn, "UPDATE pop_hotro SET note='$noidung' WHERE id='$id'");
