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
		if(isset($_POST['submit'])){
			// connect
			$conn = pg_connect("host=localhost port=5432 dbname=ahlscake user=postgres password=admin");
			if (!$conn) {
				die("Error in connection: " . pg_last_error());
			}
			session_start();
			
			// get values
			$role=$_POST["role"];
			$pword=md5($_POST["newpwd"]);
			$fname=strtolower($_POST["fname"]);
			$lname=strtolower($_POST["lname"]);
			$name=$fname." ".$lname;
			$uname=$_POST["uname"];
			if ($role=="employee"){
				$address=$_POST["address"];
				$empnum=$_POST["empno"];
				$address=$_POST["address"];
				$sex=$_POST["sex"];
				$month=$_POST["month"];
				$day=$_POST["day"];
				$year=$_POST["year"];
				$hire_date=$year.'-'.$month.'-'.$day;
			}
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
			
			// if usename is taken, prompt message
			if ($unameflag==1){
				?><script>showErrorToast("Username is not available");</script>	<?php
			}
			
			// username is available
			else{
				// for owner
				if ($role=="owner"){
					$user_result=pg_exec($conn,"INSERT INTO __user(id,user_role,uname,pword) VALUES (default,'$role','$uname','$pword')" );
					$owner_result=pg_exec($conn,"INSERT INTO owner VALUES ('$name','$uname','$pword')");
					echo "<script>showSuccessToast(Successfully created account.')</script>";
					
				}
				// for employee
				if ($role=="employee"){
					if ($empnumflag==0){
						$user_result=pg_exec($conn,"INSERT INTO __user(id,user_role,uname,pword) VALUES (default,'$role','$uname','$pword')" );
				//		$emp_result=pg_exec($conn,"INSERT INTO emp VALUES ('$empnum','$name','$sex','$address','$hire_date')" );
						echo "<script>showSuccessToast(Successfully created account.')</script>";
					}
					else{
						?><script>showErrorToast("Employee number already taken");</script>	<?php
					}
				}
			}	
		}
	?>
	<body>
		<div class="wrapper">
			<div class="main">
				<div class="header">
					<div class="banner-1">&nbsp;</div>
				</div>
				
				<div class="mid">
					<div class="mid-left">
						<h2 class="gap-2">Menu</h2>
						<ul class="left-nav">
						  <li><a href="index.html">Home</a></li>
						  <li><a href="modules/view_all_products/">View Products</a></li>
						  <li><a href="#">Order Online</a></li>
						  <li><a href="#">Contact</a></li>
						  <li><a href="#">About Us</a></li>
						</ul>
<<<<<<< HEAD
						<h2 class="gap-2">Employee</h2>
						<ul class="left-nav">
						  <li><a href="../login/">Login</a></li>
						  <li><a href="../sign_up/">Sign Up</a></li>
						  <li><a href="../add_employee/">Add Employee</a></li>
						  <li><a href="../delete_employee/">Add Employee</a></li>
						  <li><a href="../search_employee/">Search Employee</a></li>
						  <li><a href="../view_all_employee/">View All Employee</a></li>
						  <li><a href="../income_graphs/">Income Graphs</a></li>
						  <li><a href="../income_reports/">Income Reports</a></li>
						  <li><a href="../inventory_system/">Inventory System</a></li>
						  <li><a href="../add_product/">Add Product</a></li>
						  <li><a href="../delete_product/">Delete Product</a></li>
						</ul>
=======
						<?php
							if(!isset($_SESSION["role"])){
								echo "<h2 class=\"gap-2\">Login</h2>
									<ul class=\"left-nav\">
									<li>";
								include("../login/index.php");
								echo "<li><a href=\"modules/sign_up/\">Sign Up</a></li>";
								echo "</li>
									</ul>";
							}
							else{
								echo "<h2 class=\"gap-2\">Employee</h2>
								<ul class=\"left-nav\">";
								if($_SESSION["role"]=="owner"){
									echo "<li><a href=\"modules/add_employee/\">Add Employee</a></li>";
								}
								if($_SESSION["role"]=="employee" || $_SESSION["role"]=="owner"){
										echo "<li><a href=\"modules/income_graphs/\">Income Graphs</a></li>
										  <li><a href=\"modules/income_reports/\">Income Reports</a></li>
										  <li><a href=\"modules/inventory_system/\">Inventory System</a></li>
										  <li><a href=\"modules/add_product\">Add Product</a></li>
										  <li><a href=\"modules/delete_product\">Delete Product</a></li>";
								}
								echo "</ul>";
								echo "<ul class=\"left-nav\"><li><a href=\"modules/logout/index.php\">Logout</a></li></ul>";
							}
						?>

>>>>>>> origin/master
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
									<td>First Name:</td>
									<td><input type="text" id="fname" name="fname" onchange="isLetter('fname')"/></td>
								</tr>
								<tr>
									<td>Last Name:</td>
									<td><input type="text" id="lname" name="lname" onchange="isLetter('lname')"/></td>
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
									<td>Employee number:</td>
									<td><input type="text" id="empno" name="empno" onchange="isNumber('empno')"/></td>
								</tr>
								<tr>
									<td>Address:</td>
									<td><input type="text" name="address"/></td>
								</tr>
								<tr>
									<td>Sex:</td>
									<td><select name="sex">
										<option value="0">Select Sex:</option>
										<option value="f">Female</option>
										<option value="m">Male</option>
										</select>
									</td>
								</tr>
								<tr>
									<td>Hire date:</td>
									
									<td><select name="month">
										<option value="0">Month:</option>
										<option value="01">Jan</option>
										<option value="02">Feb</option>
										<option value="03">Mar</option>
										<option value="04">Apr</option>
										<option value="05">May</option>
										<option value="06">Jun</option>
										<option value="07">Jul</option>
										<option value="08">Aug</option>
										<option value="09">Sep</option>
										<option value="10">Oct</option>
										<option value="11">Nov</option>
										<option value="12">Dec</option>
									</select>
								
										<select name="day">
										<option value="0">Day:</option>
										<option value="1">1</option>
										<option value="2">2</option>
										<option value="3">3</option>
										<option value="4">4</option>
										<option value="5">5</option>
										<option value="6">6</option>
										<option value="7">7</option>
										<option value="8">8</option>
										<option value="2">9</option>
										<option value="10">10</option>
										<option value="11">11</option>
										<option value="12">12</option>
										<option value="13">13</option>
										<option value="14">14</option>
										<option value="15">15</option>
										<option value="16">16</option>
										<option value="17">17</option>
										<option value="18">18</option>
										<option value="19">19</option>
										<option value="20">20</option>
										<option value="21">21</option>
										<option value="22">22</option>
										<option value="23">23</option>
										<option value="24">24</option>
										<option value="25">25</option>
										<option value="26">26</option>
										<option value="27">27</option>
										<option value="28">28</option>
										<option value="29">29</option>
										<option value="30">30</option>
										<option value="31">31</option>
									</select>
										<select name="year">
										<option value="0">Year:</option>
										<option value="2012">2012</option><option value="2011">2011</option><option value="2010">2010</option><option value="2009">2009</option><option value="2008">2008</option><option value="2007">2007</option><option value="2006">2006</option><option value="2005">2005</option><option value="2004">2004</option><option value="2003">2003</option><option value="2002">2002</option><option value="2001">2001</option><option value="2000">2000</option><option value="1999">1999</option><option value="1998">1998</option><option value="1997">1997</option><option value="1996">1996</option><option value="1995">1995</option><option value="1994">1994</option><option value="1993">1993</option><option value="1992">1992</option><option value="1991">1991</option><option value="1990">1990</option><option value="1989">1989</option><option value="1988">1988</option><option value="1987">1987</option><option value="1986">1986</option><option value="1985">1985</option><option value="1984">1984</option><option value="1983">1983</option><option value="1982">1982</option><option value="1981">1981</option><option value="1980">1980</option><option value="1979">1979</option><option value="1978">1978</option><option value="1977">1977</option><option value="1976">1976</option><option value="1975">1975</option><option value="1974">1974</option><option value="1973">1973</option><option value="1972">1972</option><option value="1971">1971</option><option value="1970">1970</option><option value="1969">1969</option><option value="1968">1968</option><option value="1967">1967</option><option value="1966">1966</option><option value="1965">1965</option><option value="1964">1964</option><option value="1963">1963</option><option value="1962">1962</option><option value="1961">1961</option><option value="1960">1960</option><option value="1959">1959</option><option value="1958">1958</option><option value="1957">1957</option><option value="1956">1956</option><option value="1955">1955</option><option value="1954">1954</option><option value="1953">1953</option><option value="1952">1952</option><option value="1951">1951</option><option value="1950">1950</option><option value="1949">1949</option><option value="1948">1948</option><option value="1947">1947</option><option value="1946">1946</option><option value="1945">1945</option><option value="1944">1944</option><option value="1943">1943</option><option value="1942">1942</option><option value="1941">1941</option><option value="1940">1940</option><option value="1939">1939</option><option value="1938">1938</option><option value="1937">1937</option><option value="1936">1936</option><option value="1935">1935</option><option value="1934">1934</option><option value="1933">1933</option><option value="1932">1932</option><option value="1931">1931</option><option value="1930">1930</option><option value="1929">1929</option><option value="1928">1928</option><option value="1927">1927</option><option value="1926">1926</option><option value="1925">1925</option><option value="1924">1924</option><option value="1923">1923</option><option value="1922">1922</option><option value="1921">1921</option><option value="1920">1920</option><option value="1919">1919</option><option value="1918">1918</option><option value="1917">1917</option><option value="1916">1916</option><option value="1915">1915</option><option value="1914">1914</option><option value="1913">1913</option><option value="1912">1912</option><option value="1911">1911</option><option value="1910">1910</option><option value="1909">1909</option><option value="1908">1908</option><option value="1907">1907</option><option value="1906">1906</option><option value="1905">1905</option>
										</select>
									</td>
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
				<?php if(isset($_POST['submit'])) echo "<script type='text/javascript'>showSuccessToast('Successfully Saved');</script>";?>
			</div>
		</div>
	</body>
</html>
