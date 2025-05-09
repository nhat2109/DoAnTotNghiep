<?php
$sql = "SELECT id, code, name, logo FROM banks WHERE status = 1 ORDER BY name ASC";
		$result = mysqli_query($conn, $sql);
		
		$banks = [];
		while ($row = mysqli_fetch_assoc($result)) {
			$banks[] = $row;
		}
		
		echo json_encode(['status' => 'success', 'data' => $banks]);

?>