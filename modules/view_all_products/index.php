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
		session_start();
	?>
	<body>
		<div class="wrapper">
			<div class="main">
				<div class="header">
					Ahl's Cakes
				</div>
				
				<div class="mid">
					<div class="mid-left">
						<h2 class="gap-2">Menu</h2>
<<<<<<< HEAD
						<ul class="left-nav">
						  <li><a href="index.html">Home</a></li>
						  <li><a href="modules/view_all_products/">View Products</a></li>
=======
						<ul class="left-nav bmenu">
						  <li class="top"><a href="../../index.html">Home</a></li>
						  <li><a href="../view_all_products/">View Products</a></li>
>>>>>>> origin/v1.03
						  <li><a href="#">Order Online</a></li>
						  <li><a href="#">Contact</a></li>
						  <li class="bottom"><a href="#">About Us</a></li>
						</ul>
<<<<<<< HEAD
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
=======
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
>>>>>>> origin/v1.03
					</div>
					<div class="mid-right">
						<h1 class="gap-1">View All Product</h1>
						
							<table class="viewAllTable">
								<tr>
									<td class="deleteId">Image</td>
									<td class="deleteId">Information</td>
									<?php
										if(isset($_SESSION["role"]))
											echo "<td class=\"deleteId\">Action</td>";
									?>
								</tr>
								<?php //load the list of existing products
									$i=0;
									$result = pg_query($conn, "SELECT * FROM product");
									while ($row = pg_fetch_row($result)) {
										echo "<tr class='TDR'>";
										echo "<td class='TDR'><img id='{$row[1]}' src='../../products/$row[1].jpg' width='200' height='200' onerror='imgError(\"$row[1]\");'/></td> <td class='TDR description'> <b class='green'>Name:</b> $row[1] <br> <b class='green'>Price:</b> $row[4] <br> <b class='green'>Description:</b> $row[2]</td>" ;
										if(isset($_SESSION["role"])){
											echo "<td class='TDR'>
												  <form name='myForm{$i}' method='post' action='../edit_product/index.php'> 
													<input type='hidden' name='id' value='{$row[0]}'/>
													<input type='submit' name='edit' id='submit' value='Edit'/>
												  </form>
												  </td>";
											echo "</tr>";
										}
									}
									pg_close($conn);	//close connection
								?>
							</table>
					</div>
				</div>
				<div class="footer">
					<p class="copyright">� COPYRIGHT 2013 ALL RIGHTS RESERVED</p>
				</div>
			</div>
		</div>
	</body>
</html>
