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
	<?php
		$conn = pg_connect("host=localhost port=5432 dbname=ahlscake user=postgres password=admin");
		if (!$conn) {
			die("Error in connection: " . pg_last_error());
		}
		$date = date("Y-m-d");
		$existing=false;
		$result = pg_query($conn, "SELECT * FROM inventory");
		while ($row = pg_fetch_row($result)){ if($row[2]==$date){ $existing=true; break;} }
		if(!$existing){
			$result = pg_query($conn, "SELECT prod_id FROM product");
			while ($row = pg_fetch_row($result)){
				pg_query($conn, "INSERT INTO inventory (prod_id, prod_quantity, inv_date) VALUES({$row[0]},1, '{$date}')");
			}
		}
		//id submit is executed
		if(isset($_POST['submit'])){
			$array=array();
			$array_id=array();
			$numOfProd = pg_query($conn, "SELECT * FROM product");
			$count=pg_num_rows($numOfProd);
			
			for($i=0;$i<$count;$i++){
				$array[$i]=$_POST["prod{$i}"];
				$array_id[$i]=$_POST["prod_id{$i}"];
			}
			//execute query then close connection
			for($i=0;$i<$count;$i++){ pg_query($conn, "UPDATE inventory SET prod_quantity='{$array[$i]}' WHERE prod_id={$array_id[$i]} AND inv_date='{$date}'"); }
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
						  <li><a href="../edit_employee/">Edit Employee</a></li>
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
						<h1 class="gap-1">Inventory System <br> <span class="date"><?php echo date("F j, Y - l"); ?></span></h1>
						
						<form name="editQuantity" method="post" action="">
							<table class="viewAllTable">
								<tr>
									<th>ID</th>
									<th>Name</th>
									<th>Stock Quantity</th>
								</tr>
								<?php //load the list of existing products
									$i=0;
									$result = pg_query($conn, "SELECT * FROM product");
									$stock = pg_query($conn, "SELECT * FROM inventory WHERE inv_date='{$date}'");
									while ($row = pg_fetch_row($result)) {
										while($quan = pg_fetch_row($stock)){
											if($quan[0]==$row[0]) break;
										}
										echo "<tr class='TDR'>";
										echo "<td class='TDR'>{$row[0]}</td><td class='TDR'>{$row[1]}</td> <td class='TDR'><input class='deleteId' id='prod{$i}' name='prod{$i}' type='text' value='{$quan[1]}' onchange=\"isNumber('prod{$i}')\"/></td>" ;
										echo "<input type='hidden' name='prod_id{$i}' value='{$row[0]}';>";
										echo "</tr>";
										$i++;
									}
									pg_close($conn);	//close connection
								?>
							</table>
							<input type="submit" name="submit" value="Edit">
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
