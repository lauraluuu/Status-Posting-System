<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>MySQL Database Post Status Page</title>
<link rel="stylesheet" href="style.css" type="text/css" />
</head>

<body>
<?php
	require_once('../../conf/sqlassign.php');
	
	$conn=@mysqli_connect($sql_host,$sql_user,$sql_pass,$sql_db);
	
	//check if the connection is successful
	if(!conn){
		echo "<p>Fail to connect to the database</p>";
	}else{

		$is_code_format_OK=false;
		$is_code_unique=false;
		$is_status_OK=false;
		$is_table_exist=false;
		
		//check whether status code, status and date entered are not null
		if(empty($_POST['code'])||empty($_POST['status'])||empty($_POST['date'])){
			echo "<p>Invalid Input: The status code, status and date must not be null</p><br />";
			echo '<a href="poststatusform.php">Return to Post Status Page</a><br />';
			echo '<a href="index.html">Return to Home Page </a>';
		}else{
			
			$code_temp=$_POST['code'];
			
			//check whether the stauts code is 5 characters in length
			if(strlen($code_temp)==5){
				
				//check whether the status code start with S followed by 4 numbers
				if(strcmp(substr(($code_temp),0,1), "S")==0){
					$is_code_format_OK=true;
					$str=substr($code_temp,1,4);
					if(preg_match('/^[0-9]+$/', (int)str)){
						$is_code_format_OK=true;
					}
				}
			}
			
			//display error message when the status code entered is invalid
			if(!$is_code_format_OK){
				echo "<p>Invalid Input: The status code must start with S followed by 4 numbers</p><br />";
				echo '<a href="poststatusform.php">Return to Post Status Page</a><br />';
				echo '<a href="index.html">Return to Home Page </a>';
			}
			
			
			//verify status code to be unique
			$code_temp=$_POST["code"];
			$query="SELECT * FROM $sql_table WHERE code='$code_temp'";
			$check_unique=mysqli_query($conn, $query);
			$count=mysqli_num_rows($check_unique);
			if($count>0){
				//code entered exists
				echo "<p>Invalid Input: The status code entered already exists in the database</p><br />";
				echo '<a href="poststatusform.php">Return to Post Status Page</a><br />';
				echo '<a href="index.html">Return to Home Page </a>';

			}else{
				//code entered does not exist
				$is_code_unique=true;
			}
	
			/**
			check if the status entered qonly contains alphanumeric characters including spaces,
			comma, period, exclamation point and question mark. Display error message when the input
			is invalid
			**/
			if(preg_match('/^[a-zA-Z]+[a-zA-Z0-9 ,.!?]+$/',$_POST["status"])){
				$is_status_OK=true;
			}else{
				echo "<p>Invalid Input: The status can only contain alphanumeric characters
						including spaces, comma, period, exclamation potion and question mark.
						Other character or symbols are not allowed.</p><br />";
				echo '<a href="poststatusform.php">Return to Post Status Page</a><br />';
				echo '<a href="index.html">Return to Home Page </a>';
			}
			
			//Check whether the Database table exists or not
			$query="DESCRIBE $sql_table";
			$result=mysqli_query($conn, $query);
			if($result){
				$is_table_exist=true;
			}else{
				echo "<p>Error: The table does not exist!</p><br />";
				echo '<a href="poststatusform.php">Return to Post Status Page</a><br />';
				echo '<a href="index.html">Return to Home Page </a>';
			}
			
			//write the records into the database table after data validation
			if($is_code_format_OK&&$is_status_OK&&$is_table_exist&&$is_code_unique){
				$code=$_POST["code"];		
				$status=$_POST["status"];	
				$share=$_POST["share"];
				$oldDate=$_POST["date"];
				$date=date("Y-m-d", strtotime($oldDate));
		
				if(isset($_POST['type1'])){
					$permission_type=$_POST['type1'];
				}elseif(isset($_POST['type2'])){
					$permission_type=$_POST['type2'];			
				}else{
					$permission_type=$_POST['type3'];	
				}
		
				//SQL query to insert data into the table
				$query="insert into $sql_table"
						."(code,status,share,date,permission_type)"
						."values"
						."('$code','$status','$share','$date','$permission_type')";
		
				$result=mysqli_query($conn,$query);
		
				if(!$result){
					echo "<p>There is something wrong with ",$query,"</p>";
					echo '<a href="poststatusform.php">Return to Post Status Page</a><br />';
					echo '<a href="index.html">Return to Home Page </a>';
			
				}else{

					echo "<p>",$query," operates successfully</p>";
					echo "<p>The record has been written into the database table!</p>";
					echo '<a href="index.html">Return to Home Page </a>';
					
					mysqli_free_result($result);
				}
			}

		}

		
		mysqli_close($conn);
	}

?>

</body>
</html>