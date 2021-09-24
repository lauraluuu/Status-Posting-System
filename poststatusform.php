<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>Post Status Page</title>
<link rel="stylesheet" href="style.css" type="text/css" />
</head>

<body>
	<h1>Status Posting System</h1>

	<form method="post" action="poststatusprocess.php">
		<p><label for="code">Status Code(required):</label>
			<input type="text" name="code" id="code" /></p>
		<p><label for="status">Status(required):    </label>
			<input type="text" name="status" id="status" /></p>	

		<label>Share:    </label>
		<input type="radio" name="share" value="Public"> 
		<label for="Public">Public</label>
		<input type="radio" name="share" value="Friends"> 
		<label for="Friends">Friends</label>
		<input type="radio" name="share" value="OnlyMe"> 
		<label for="OnlyMe">Only Me</label>

		<p><label for="date">Date:           </label>
		<input type="date" value="<?php echo $currentDate=date('Y-m-d');?>" name="date" id="date"/></p>	
		
		<label>Permission Type: </label>
		<input type="checkbox" name="type1" id="type1" value="Allow Like">
		<label for="type1"> Allow Like</label>
		
		<input type="checkbox" name="type2" id="type2" value="Allow Comment">
		<label for="type2"> Allow Comment</label>
		
		<input type="checkbox" name="type3" id="type3" value="Allow Share">
		<label for="type3"> Allow Share</label><br />
		
		<input type="submit" value="Post" />
		<input type="reset" value="Reset" />
	</form>
	
	<br />
	
<a href="index.html">Return to Home Page </a> <br />
	
</body>
</html>