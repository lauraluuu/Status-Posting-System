<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>MySQL Database Search Status with PHP</title>
<link rel="stylesheet" href="style.css" type="text/css" />
</head>

<body>
<h1>Status Information</h1>
<?php
	require_once('../../conf/sqlassign.php');
	
	$conn=@mysqli_connect($sql_host,$sql_user,$sql_pass,$sql_db);
	
	$is_table_exist=false;
	$is_input_valid=false;
	
	if(!conn){
		echo "<p>Fail to connect to the database</p>";
	}else{
		
		//Validate the search string existence
		if(empty($_GET['status'])){
			echo "<p>Error: The status search string should not be empty!</p><br />";
		}else{
			$is_input_valid=true;
			
			//Check whether the Database table exists or not
			$query="DESCRIBE $sql_table";
			$result=mysqli_query($conn, $query);
			
			if($result){
				$is_table_exist=true;
			}else{
				echo "<p>Error: The table does not exist!</p><br />";
			}
		}
	
		/**
		*Display the search result when the database table and the search string exist
		**/
		if($is_table_exist&&$is_input_valid){
			$status=$_GET["status"];

			//set up the sql query to search the data according to the input status
			$query="select * from $sql_table where status like '$status%'";
		
			$result=mysqli_query($conn,$query);
		
			//validate if the sql query has been executed successfully
			if(!$result){
				echo "<p>There is something wrong with ",$query,"</p>";
			}else{
				//retrieve and print out the data from database table
				while($row=mysqli_fetch_assoc($result)){
					echo "<p>Status: ", $row["status"],"</p>";
					echo "<p>Status Code: ", $row["code"],"</p>";
					echo "<p>Share: ", $row["share"], "</p>";
					echo "<p>Date Posted: ", $row["date"], "</p>";
					echo "<p>Permission: ", $row["permission_type"],"</p><br /><br />";
					
				}
			
				mysql_free_result($result);
			}
		}


		//close the datebase connection
		mysqli_close($conn);
	}

?>

<a href="searchstatusform.html" style="display:inline-block; margin-right:20px;">Search for another status </a>
<a href="index.html" style="display:inline-block;float:right">Return to Home Page</a>
</body>
</html>
