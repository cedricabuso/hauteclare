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
	<?php //connect
		$conn = pg_connect("host=localhost port=5432 dbname=ahlscake user=postgres password=admin");
		if (!$conn) {
			die("Error in connection: " . pg_last_error());
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
						  <li><a href="../../index.html">Home</a></li>
						  <li><a href="../view_all_products/">View Products</a></li>
						  <li><a href="#">Order Online</a></li>
						  <li><a href="#">Contact</a></li>
						  <li><a href="#">About Us</a></li>
						</ul>
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
					</div>
					<div class="mid-right">
						<h1 class="gap-1">Search Employee</h1>
                        <form name="searchEmp" onsubmit="return ValidateAddEmployee();" method="post" action="">						
							<tr>
								<td><b>Emp No</b></td>
								<td><input type="text" id="empno" name="empno" onchange="isNumber('empnum');"/></td>
							</tr>
							<tr>
								<td></td>
								<td><input type="submit" name="submit" value="Search"></td>						   
							</tr>
                   </form>
              <?php //load the list of existing products
				if(isset($_POST['submit'])){                     
					$empno = $_POST['empno'];
					$conn = pg_connect("host=localhost port=5432 dbname=ahlscake user=postgres password=admin");
							 if (!$conn) {
						die("Error in connection: " . pg_last_error());
					}
					//execute query then close connection
                    $i=0;
                    $result = pg_query($conn, "SELECT * FROM emp WHERE empnum={$empno}");
                    while ($row = pg_fetch_row($result)) {
                           echo "<tr class='TDR'>";
                           echo "<td class='TDR'><img id='{$row[1]}' src='../../employees/$row[1].jpg' width='150' height='150' onerror='imgError(\"$row[1]\");'/></td> <td class='TDR description'><br> <b class='green'>Emp No:</b> $row[0] <br> <b class='green'>Name:</b> $row[1] <br> <b class='green'>Sex:</b> $row[2] <br> 
                           <b class= 'green'> Address:</b> $row[3] <br> <b class= 'green'> Hire Date:</b> $row[4]</td>" ;
                           echo "</tr>";
                    }
                    pg_close($conn);	//close connection
                    echo "<b>Employee does not exist.</b>";
				}
       ?>
					</div>
				</div>
				<div class="footer">
					<p class="copyright">© COPYRIGHT 2013 ALL RIGHTS RESERVED</p>
				</div>
			</div>
		</div>
	</body>
</html>
