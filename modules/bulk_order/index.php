<!DOCTYPE>
<html>
	<head>
	  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	  <title>Ahl's Cake</title>
	  <script type="text/javascript" src="../../js/jquery.min.js"></script>
	  <script type="text/javascript" src="../../js/script.js"></script>
	  <script src="../../js/jquery.toastmessage.js" type="text/javascript"></script>
	  <link href="../../css/jquery.toastmessage.css" rel="stylesheet" type="text/css">
	  <link href="../../css/style.css" rel="stylesheet" type="text/css">
	</head>
	<?php
		$conn = pg_connect("host=localhost port=5432 dbname=ahlscake user=postgres password=admin");
		if (!$conn) {
			die("Error in connection: " . pg_last_error());
		}
	?>
	<body>
		<div class="wrapper">
			<div class="main">
				<div class="header">Ahl's Cakes</div>

				<div class="mid">
					<div class="mid-left">
						<h2 class="gap-2">MENU</h2>
						<ul class="left-nav bmenu">
						  <li class="top"><a href="../../">Home</a></li>
						  <li><a href="../customer_view_products/?offset=0&pgnum=0">View Products</a></li>
						  <li><a href="../bulk_order/">Order Online</a></li>
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
						<h1 class="gap-1">Bulk Order</h1>
						<form name="bulkForm" method="post" action="">
						<strong><?php echo date("F j, Y - l"); $today=date("Y-m-d")?>
						<?php 
								$db = pg_connect('host=localhost dbname=ahlscake user=postgres password=admin');
								$product = pg_query($db, "select * from product order by prod_id");
								$i = 1;
								while($myrow = pg_fetch_assoc($product)){
									$value = str_replace(" ","_",$myrow['prod_name']);
									printf ("<input name='%s' type=hidden value=%d readonly />\n", $value,$myrow['prod_id']);
									printf ("<input type=hidden id='%s' value=%d readonly />\n", $myrow['prod_name'],$myrow['prod_price']);
									$i++;
								}
						?>
						</strong>
						<br /><br />
						<table>
							<tr>
								<th> Product </th>
								<th> </th>
							</tr>
							<tr>
								<td> 
									<select id="prodList">
										<?php
											$product = pg_query($db, "select * from product order by prod_id");
											while($myrow = pg_fetch_assoc($product)){
												$value = str_replace(" ","_",$myrow['prod_name']);
												printf ("<option>%s</option>", $myrow['prod_name']);
											}
										?>
									</select>
								</td>
								<td><input type="button" id="productButton" value="Order" onclick="bulkorder(document.getElementById('prodList').value);" /></td>
							</tr>
						</table>
						<?php
							if(isset($_POST['bulkSubmit'])){ 
								$counter = $_POST['hiddenCounter'];
								if($counter == 0) echo "<script>showErrorToast(\"Must order a product\")</script>";
								else{						
									$result = $_POST['bulkProdName'];
									$quanProd = $_POST['bulkProdQuan'];
									$nameProd = array_values(array_unique($_POST['bulkProdName']));
									$priceProd = $_POST['bulkProdAmount'];
									$j = 0;
									
									foreach($nameProd as $value){
										$totalQuantity = 0;
										$totalAmount = 0;
										
										$i = 0;
										foreach($result as $v){
											if($v == $value){
												$totalQuantity += $quanProd[$i];
												$totalAmount += $priceProd[$i];
											}
											$i++;
										}
										$value = str_replace(" ","_",$value);
										$id = $_POST[$value];
										$res = pg_query($db, "INSERT INTO bulkorder VALUES ($id,'$nameProd[$j]',$totalQuantity,$totalAmount,'$today')");
										if (!$res) pg_query($db, "ROLLBACK"); 
										else pg_query($db, "COMMIT"); 
										$j++;
									}
									echo "<script type='text/javascript'>showSuccessToast('Order Successful <br> Redirecting to payment page ...'); setTimeout('redirect()', 4000);</script>";
								}
							}
							pg_close($db);
						?>
						<input type="hidden" id="hiddenCounter" name="hiddenCounter" value="0" />
						<table id="order"></table>
						<center><input type="submit" name="bulkSubmit" value="Submit" /></center>
						</form>
					</div>
				</div>
				<div class="footer">
					<p class="copyright">© COPYRIGHT 2013 ALL RIGHTS RESERVED</p>
				</div>
			</div>
		</div>
	</body>
</html>
