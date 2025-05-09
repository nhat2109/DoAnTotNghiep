<?php
session_start();

if (!isset($_SESSION['created'])) {
    $_SESSION['created'] = time(); // lưu thời điểm tạo session
}

$session_lifetime = ini_get('session.gc_maxlifetime');
$elapsed = time() - $_SESSION['created'];
$remaining = $session_lifetime - $elapsed;

echo "Session started at: " . date("H:i:s", $_SESSION['created']) . "<br>";
echo "Elapsed: $elapsed seconds<br>";
echo "Remaining: $remaining seconds<br>";
?>