<!DOCTYPE>
<html>
	<head>
	  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	  <title>Ahl's Cake</title>
	  <script type="text/javascript" src="../../js/script.js"></script>
	  <script type="text/javascript" src="../../js/jquery.min.js"></script>
	  <script src="../../js/jquery.toastmessage.js" type="text/javascript"></script>
	  <link href="../../css/jquery.toastmessage.css" rel="stylesheet" type="text/css">
	  <link href="../../css/style.css" rel="stylesheet" type="text/css">
	</head>
	<?php //if submit is executed
		error_reporting(0);
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
<<<<<<< HEAD
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
=======
		<div class="wrapper">
			<div class="main">
				<div class="header">
					Ahl's Cakes
				</div>
				
				<div class="mid">
					<div class="mid-left">
						<h2 class="gap-2">Menu</h2>
						<ul class="left-nav bmenu">
						  <li class="top"><a href="../../index.html">Home</a></li>
						  <li><a href="../view_all_products/">View Products</a></li>
						  <li><a href="#">Order Online</a></li>
						  <li><a href="#">Contact</a></li>
						  <li class="bottom"><a href="#">About Us</a></li>
						</ul>
						<h2 class="gap-2">Employee</h2>
						<ul class="left-nav bmenu">
						  <li class="top"><a href="../login/">Login</a></li>
						  <li><a href="../sign_up/">Sign Up</a></li>
						  <li><a href="../add_employee/">Add Employee</a></li>
						  <li><a href="../delete_employee/">Delete Employee</a></li>
						  <li><a href="../search_employee/">Search Employee</a></li>
						  <li><a href="../view_all_employee/">View All Employee</a></li>
						  <li><a href="../income_graphs/">Income Graphs</a></li>
						  <li><a href="../income_reports/">Income Reports</a></li>
						  <li><a href="../inventory_system/">Inventory System</a></li>
						  <li><a href="../add_product/">Add Product</a></li>
						  <li class="bottom"><a href="../delete_product/">Delete Product</a></li>
						</ul>
					</div>
					<div class="mid-right">
						<h1 class="gap-1">Login</h1>
						
						<form name="login" onSubmit=" return ValidateLogin()" method="POST" action="">
							<table class="table">
								<tr>
									<td>Username</td>
									<td><input type="text" name="uname"/></td>
								</tr>
								<tr>
									<td>Password</td>
									<td><input type="password" name="pword" /></td>
								</tr>
								<tr>
									<td></td>
									<td><input type="submit" name="submit" value="Login"></td>
								</tr>
							</table>
						</form>
					</div>
				</div>
				<div class="footer">
					<p class="copyright">� COPYRIGHT 2013 ALL RIGHTS RESERVED</p>
				</div>
				<?php if(isset($_POST['submit'])) {
						// if username is not in database
						if($unameflag==0) echo "<script>showErrorToast('Invalid username or password');</script>";
						//else if username is in database check if passwords match
						else{
							if ($pword==$match_pw) header("Location: ../../index.html");
							else echo "<script>showErrorToast('Invalid username or password');</script>";
						}
					  }
					  $res = pg_query($conn, "select * from doesnotexist");
					  $invalid_characters = array('"');
					  $error = str_replace($invalid_characters, "", pg_last_error());
					  $error = explode("LINE", $error);
					  echo $error[0];
					  pg_close($conn);
				?>
			</div>
		</div>
>>>>>>> origin/v1.03
	</body>
</html>
