<!DOCTYPE>
<html>
	<head>
	  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	  <title>Ahl's Cake</title>
	  <link href="../../css/jquery.toastmessage.css" rel="stylesheet" type="text/css">
	  <link href="../../css/style.css" rel="stylesheet" type="text/css">
	</head>
	<?php //if submit is executed
		if(isset($_POST['submit'])){
			// connect
			$conn = pg_connect("host=localhost port=5432 dbname=ahlscake user=postgres password=admin");
			if (!$conn) {
				die("Error in connection: " . pg_last_error());
			}
		
			// get values
			$uname=$_POST["uname"];
			$pword=md5($_POST["pword"]);
			$unameflag=0;
		
			// check if username is in database
			$user_array=pg_query("SELECT uname,pword,user_role from __user");
			while ($row=pg_fetch_assoc($user_array)){
				if ($row['uname']==$uname){
					$unameflag=1;
					$match_pw=$row['pword'];
					$_SESSION["role"]=$row['user_role'];
				}
			}
		}
	?>
	<body>
		<form name="login" onSubmit=" return ValidateLogin()" method="POST" action="">
			<table class="table">
				<tr>
					<td>Username</td>
					<td><input type="text" name="uname" size=15/></td>
				</tr>
				<tr>
					<td>Password</td>
					<td><input type="password" name="pword" size=15/></td>
				</tr>
				<tr>
					<td></td>
					<td><input type="submit" name="submit" value="Login"></td>
				</tr>
			</table>
		</form>
		<?php if(isset($_POST['submit'])) {
				// if username is not in database
				if($unameflag==0) echo "<script>showErrorToast('Invalid username or password');</script>";
				//else if username is in database check if passwords match
				else{
					if ($pword==$match_pw) header("Location: index.php");
					else echo "<script>showErrorToast('Invalid username or password');</script>";
				}
			  }
		?>
	</body>
	<script type="text/javascript" src="../../js/script.js"></script>
	<script type="text/javascript" src="../../js/jquery.min.js"></script>
	<script src="../../js/jquery.toastmessage.js" type="text/javascript"></script>
</html>
