<?php
	$text = $_GET["text"] ?? "";
	$date = $_GET["date"] ?? "";
				require_once __DIR__ . "/db_connect.php";
				$conn = get_db_connection();
				if (!$conn) 
				{
					echo 1;
					exit;
				}

				$sql = "SELECT 1 FROM `package` WHERE `Vehicle` = ? AND `Date` = ? LIMIT 1";
				$stmt = mysqli_prepare($conn, $sql);
				$isBooked = true;
				if ($stmt)
				{
					mysqli_stmt_bind_param($stmt, "ss", $text, $date);
					mysqli_stmt_execute($stmt);
					mysqli_stmt_store_result($stmt);
					$isBooked = mysqli_stmt_num_rows($stmt) > 0;
					mysqli_stmt_close($stmt);
				}

				if(!$isBooked)
				{
					echo 0;
				}
				else
				{
					echo 1;
				}
				mysqli_close($conn);
?>


