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
		
		//if submit is executed
		if(isset($_POST['submit'])){
			$empno = $_POST['id'];
			echo $empno;
			//execute query
			pg_query($conn, "DELETE FROM emp WHERE empnum={$empno}");
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
						<h1 class="gap-1">Delete Employee</h1>
						
							<table class="deleteTable">
								<tr>
									<td class="deleteId">Emp No</td>
									<td class="deleteId">Name</td>
									<td class="deleteId">Action</td>
								</tr>
								<?php //load the list of existing products
									$i=0;
									$result = pg_query($conn, "SELECT * FROM emp");
									while ($row = pg_fetch_row($result)) {
										echo "<tr>";
										echo "<td class='deleteId'>$row[0]</td> <td>$row[1]</td>" ;
										echo "<td>
											  <form name='myForm{$i}' method='post' action=''> 
												<input type='hidden' name='id' value='{$row[0]}'/>
												<input type='submit' name='submit' id='submit' value='Delete'/>
											  </form>
											  </td>";
										echo "</tr>";
									}
									pg_close($conn);	//close connection
								?>
							</table>
					</div>
				</div>
				<div class="footer">
					<p class="copyright">� COPYRIGHT 2013 ALL RIGHTS RESERVED</p>
				</div>
				<?php if(isset($_POST['submit'])) echo "<script type='text/javascript'>showSuccessToast('Successfully Saved');</script>";?>
			</div>
		</div>
	</body>
</html>
