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
		//error_reporting(0);
		if(isset($_POST['submit'])){
			// connect
			$conn = pg_connect("host=localhost port=5432 dbname=ahlscake user=postgres password=admin");
			if (!$conn) {
				die("Error in connection: " . pg_last_error());
			}
			
			// get values
			$role=$_POST["role"];
			$pword=md5($_POST["newpwd"]);
			$fname=strtolower($_POST["fname"]);
			$lname=strtolower($_POST["lname"]);
			$name=$fname." ".$lname;
			$uname=$_POST["uname"];
			if ($role=="employee") $empnum=$_POST["empno"];
			
			$empnumflag=0;
			$unameflag=0;
			
			// for all users
			// if username is taken, set unameflag to 1
			$user_array=pg_query("SELECT uname from __user");
			while ($row=pg_fetch_assoc($user_array)){
				if ($row['uname']==$uname) $unameflag=1;
			}

			// for employees
			// if employe number is taken, set empnumflag to 1
			if ($role=="employee"){
				$emp_array=pg_query("SELECT empnum from emp");
				while ($row=pg_fetch_assoc($emp_array)){
					if ($row['empnum']==$empnum) $empnumflag=1;
				}
			}
			
			if ($role=="owner" && $unameflag==0){
				$user_result=pg_exec($conn,"INSERT INTO __user(id,user_role,uname,pword) VALUES (default,'$role','$uname','$pword')" );
				$owner_result=pg_exec($conn,"INSERT INTO owner VALUES ('$name','$uname','$pword')");
			}
			// for employee
			if ($role=="employee" && $unameflag==0){
				if ($empnumflag==1){
					$user_result=pg_exec($conn,"INSERT INTO __user(id,user_role,uname,pword) VALUES (default,'$role','$uname','$pword')" );
				}
			}
				
		}
	?>
	<body>
		<div class="wrapper">
			<div class="main">
				<div class="header">
					Ahl's Cakes
				</div>

				<div class="mid">
					<div class="mid-left">
						<h2 class="gap-2">MENU</h2>
						<ul class="left-nav bmenu">
						  <li class="top"><a href="">Home</a></li>
						  <li><a href="../view_all_products/">View Products</a></li>
						  <li><a href="#">Order Online</a></li>
						  <li><a href="../comments/">Comment</a></li>
						  <li><a href="#">Contact</a></li>
						  <li class="bottom"><a href="#">About Us</a></li>
						</ul>
						<?php
							session_start();
							$top=0;
							if(!isset($_SESSION["role"])){
								echo "<h2 class=\"gap-2\">LOGIN</h2>
									<ul class=\"left-nav bmenu\">
									<li class='login top'>";
								include("../login/index.php");
								echo "<li class='bottom'><a href=\"../sign_up/\">Sign Up</a></li>";
								echo "</li>
									</ul>";
							}
							else{
								$role=strtoupper($_SESSION["role"]); 
								echo "<h2 class=\"gap-2\">{$role}</h2>
								<ul class=\"left-nav bmenu\">";
								if($_SESSION["role"]=="owner"){
									echo "<li class='top'><a href=\"../add_employee/\">Add Employee</a></li>
										  <li><a href='../delete_employee/'>Delete Employee</a></li>
										  <li><a href='../search_employee/'>Search Employee</a></li>
										  <li><a href='../view_all_employee/'>View All Employee</a></li>";
									$top=1;
								}
								if($_SESSION["role"]=="employee" || $_SESSION["role"]=="owner"){
										if($top==1) echo "<li><a href='../cashier_system/'>Cashier System</a></li>";
										else echo "<li class='top'><a href='../cashier_system/'>Cashier System</a></li>";
										echo "<li><a href='../inventory_system/'>Inventory System</a></li>
											  <li><a href='../income_reports/'>Income Reports</a></li>
											  <li><a href='../income_graphs/'>Income Graphs</a></li>
											  <li><a href='../add_product/'>Add Product</a></li>
											  <li><a href='../delete_product/'>Delete Product</a></li>
											  <li class='bottom'><a href=\"../logout/index.php\">Logout</a></li>";
								}
							}
						?>
					</div>
					<div class="mid-right">
						<h1 class="gap-1">Sign Up</h1>
						
						<form name="signup" onsubmit="return ValidateSignup()" method="post" action="">
							<table class="table">
								<tr>
									<td>Role:</td>
									<td>
										<input type="radio" id="employee" name="role" value="employee" onClick="Disable()"><label for="employee">Employee</label> &nbsp;&nbsp;
										<input type="radio" id="owner" name="role" value="owner" onClick="Disable()"><label for="owner">Owner</label>
									</td>
								</tr>
								<tr>
									<td>Employee No.</td>
									<td><input type="text" id="empno" name="empno" onchange="empNoValidate('empno');"/></td>
								</tr>
								<tr>
									<td>First Name:</td>
									<td><input type="text" id="fname" name="fname" onchange="isLetter('fname')"/></td>
									<input type="hidden" id="fnameHidden" name="fname" value=""/>
								</tr>
								<tr>
									<td>Last Name:</td>
									<td><input type="text" id="lname" name="lname" onchange="isLetter('lname')"/></td>
									<input type="hidden" id="lnameHidden" name="lname" value=""/>
								</tr>
								<tr>
									<td>Username:</td>
									<td><input type="text" name="uname"/></td>
								</tr>
								<tr>
									<td>Password:</td>
									<td><input type="password" name="newpwd" /></td>
								</tr>
								<tr>
									<td>Re-enter password:</td>
									<td><input type="password" name="newpwd2" onchange="pwordMatch();"/></td>
								</tr>
								<tr>
									<td></td>
									<td><input type="submit" name="submit" value="Submit"></td>
								</tr>
							</table>
						</form>
					</div>
				</div>
				<div class="footer">
					<p class="copyright">© COPYRIGHT 2013 ALL RIGHTS RESERVED</p>
				</div>
				<?php
					if(isset($_POST['submit'])){
						if ($role=="owner" && $unameflag==0) echo "<script>showSuccessToast('Successfully created account.')</script>";
						else if($unameflag==1) echo "<script>showErrorToast('Username is not available')</script>";
						else if($role=="employee" && $empnumflag==0) echo "<script>showErrorToast('Employee number not found')</script>";
						else if($role=="employee" && $empnumflag==1) echo "<script>showSuccessToast('Successfully employee created account.')</script>";
					}
				?>
			</div>
		</div>
	</body>
</html>
