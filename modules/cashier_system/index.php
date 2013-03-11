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
						<h1 class="gap-1">Cashier System</h1>
						
						<strong><?php
							$today = date("Y-m-d");
							PRINT "$today";
						?>
						</strong>
						
						<br /><br />
						<table id="itemDiv">
							<tr class="centerBorder0" >
								<th class=borderLess> Product ID </th>
								<th class=borderLess> Product Name </th>
								<th class=borderLess> Quantity </th>
								<th class=borderLess> Price </th>
								<th class=borderLess> </th>
							</tr>
							<?php 
								$db = pg_connect('host=localhost dbname=ahlscake user=postgres password=admin');
								$product = pg_query($db, "select * from product");
								$i = 0;
								
								while($myrow = pg_fetch_assoc($product)){
									$inventory = pg_query($db, "select * from inventory where inv_date='$today'");
									while($myrow2 = pg_fetch_assoc($inventory)){
										if($myrow2['prod_id'] == $myrow['prod_id']){
											echo "<tr class=centerBorder0>\n";
											printf ("<td class=borderLess><input class=center type=text id=id%d value=%d readonly /></td>\n", $i,$myrow['prod_id']);
											printf ("<td class=borderLess><input class=centerBorder0 type=text id=name%d value='%s' readonly /></td>\n", $i,htmlspecialchars($myrow['prod_name']));
											printf ("<td class=borderLess><input class=center id=price%d type=number value=0 min=0 max=%d /></td>\n",$i,$myrow2['prod_quantity']);
											printf ("<td class=borderLess><input class=center type=text id=prod%d value=%d readonly /></td>\n", $i,$myrow['prod_price']);
											printf ("<td class=borderLess><input type=submit value=Add onclick=addProd(document.getElementById('id%d').value,document.getElementById('name%d').value,document.getElementById('price%d'),document.getElementById('prod%d').value); /></td>",$i,$i,$i,$i);
											echo "</tr>";
											$i++;
										}
									}
								}
							?>
						</table>		
						
						<br />
						<?php
							if(isset($_POST['checkout'])){ 
								
								$id = $_POST['prodId'];
								$quanProd = $_POST['quantity'];
								$result = array_values(array_unique($_POST['prodId']));
								$nameProd = array_values(array_unique($_POST['prodName']));
								$priceProd = array_values(array_unique($_POST['prodPrice']));
								
								$j = 0;
								
								foreach($result as $value){
									$totalQuantity = 0;
									
									$i = 0;
									foreach($id as $v){
										if($v == $value){
											$totalQuantity += $quanProd[$i];
										}
										$i++;
									}
									$res = pg_query($db, "INSERT INTO cashier VALUES ($value,'$nameProd[$j]',$totalQuantity,$priceProd[$j],'$today')");
									$inventVal = pg_query($db, "select prod_quantity from inventory where prod_id=$value and inv_date='$today'");
									while($myrow = pg_fetch_assoc($inventVal)){
										$update = $myrow['prod_quantity'] - $totalQuantity;
										$invent = pg_query($db, "update inventory set prod_quantity=$update where prod_id='$value' and inv_date='$today'");
										if (!$res) pg_query($db, "ROLLBACK"); 
										else pg_query($db, "COMMIT"); 
									}
									$j++;
								}
							}
							
							pg_close($db);
						?>
						<form name="cashierItems" id="cashierForm" method="post" onsubmit="return ValidateCheckout();" action="<?php echo $_SERVER['PHP_SELF']; ?>" >
						<table id="toBuy">
							<tr>
								<th class="borderLess" > Product ID </th>
								<th class="borderLess"> Product Name </th>
								<th class="borderLess"> Quantity </th>
								<th class="borderLess" > Total Price </th>
							</tr>
						</table>
						<center>
						<table id="totalAmount">
							<tr>
								<th colspan=3>Total Amount to Pay: </td>
								<th colspan=1><input type="text" class="center" id="totalPayment" value="0" readonly /></td>
							</tr>
							<tr>
								<th colspan=4><input type="submit" name="checkout" id="checkOut" value="Checkout"/></td>
						</table>
						</form>
					</div>
				</div>
				<div class="footer">
					<p class="copyright">© COPYRIGHT 2013 ALL RIGHTS RESERVED</p>
				</div>
				<?php if(isset($_POST['checkout'])) echo "<script type='text/javascript'>showSuccessToast('Successfully checked out.');</script>";?>
			</div>
		</div>
	</body>
</html>
