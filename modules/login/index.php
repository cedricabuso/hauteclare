<!DOCTYPE>
<html>
	<?php //if submit is executed
		error_reporting(0);
		if(isset($_POST['login'])){
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
						<td><input size="15" type="text" name="uname"/></td>
					</tr>
					<tr>
						<td>Password</td>
						<td><input size="15" type="password" name="pword" /></td>
					</tr>
					<tr>
						<td></td>
						<td><input type="submit" name="login" value="Login"></td>
					</tr>
				</table>
			</form>

	<?php if(isset($_POST['login'])) {
			// if username is not in database
			if($unameflag==0) echo "<script>showErrorToast('Invalid username or password');</script>";
			//else if username is in database check if passwords match
			else{
				if ($pword==$match_pw) header("");
				else echo "<script>showErrorToast('Invalid username or password');</script>";
			}
		  }
		  /*$res = pg_query($conn, "select * from doesnotexist");
		  $invalid_characters = array('"');
		  $error = str_replace($invalid_characters, "", pg_last_error());
		  $error = explode("LINE", $error);
		  echo $error[0];*/
		  pg_close($conn);
	?>
	</body>
</html>
