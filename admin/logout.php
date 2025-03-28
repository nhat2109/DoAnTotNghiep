<?php
include('../includes/tlca_world.php');


setcookie('admin_id', '', time() - 3600, '/');
header('Content-Type: application/json');
echo json_encode(['ok' => 1, 'redirect' => '/admin/login.php']);
exit();
?>