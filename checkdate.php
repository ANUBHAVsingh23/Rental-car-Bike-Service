<?php
	$text=$_GET["text"];
	$date=$_GET["date"];
				require_once __DIR__ . "/db_connect.php";
				$conn = get_db_connection();
				if (!$conn) 
				{
					echo 1;
					exit;
				}
				
				$sql="SELECT `Vehicle`,`Date` FROM `package`";
				$result=mysqli_query($conn,$sql);
				$rowsnum=mysqli_num_rows($result);
				$i=0;
				if ($rowsnum > 0) 
				{
				  while($row = mysqli_fetch_assoc($result)) 
				  {
						if($row["Vehicle"]==$text && $row["Date"]==$date)
						{
							break;
						}
						$i++;
				  }
				} 
				if($i==$rowsnum)
				{
					echo 0;
				}
				else
				{
					echo 1;
				}
				mysqli_close($conn);
?>


