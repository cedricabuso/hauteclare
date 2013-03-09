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
		/*//id submit is executed
		if(isset($_POST['submit'])){
			$id = $_POST['id'];
			//connect
			$conn = pg_connect("host=localhost port=5432 dbname=ahlscake user=postgres password=admin");
			if (!$conn) {
				die("Error in connection: " . pg_last_error());
			}
			//execute query then close connection
			pg_query($conn, "INSERT INTO product (prod_id, prod_name, prod_desc, prod_img, prod_price) VALUES('{$id}','{$name}', '{$description}', '{$name}', '{$price}')");
			pg_close($conn);
		}*/
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
						  <li><a href="../add_product/">Add Product</a></li>
						  <li><a href="../delete_product/">Delete Product</a></li>
						</ul>
					</div>
					<div class="mid-right">
						<h1 class="gap-1">Bulk Order</h1>
						<form name="bulkForm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
						<strong><?php
							$today = date("Y-m-d");
							PRINT "$today";
						?>
						<?php 
								$db = pg_connect('host=localhost dbname=ahlscake user=postgres password=admin');
								$product = pg_query($db, "select * from product_list order by prod_id");
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
										<option> Brownies a la Mode </option>
										<option> Cheezy Bar </option>
										<option> Chocolate Cake </option>
										<option> Crazy Caramel </option>
										<option> Cream Cheese Swirl </option>
										<option> Double Fudge Espresso Brownies </option>
										<option> Food for the Gods </option>
										<option> Revel Bars </option>
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
									
									echo "<script type='text/javascript'>showSuccessToast('Order Successful');</script>";
								}
							}
							
							pg_close($db);
						?>
						
						<input type="hidden" id="hiddenCounter" name="hiddenCounter" value="0" />
						<table id="order">
							
						</table>
						
						<center><input type="submit" name="bulkSubmit" value="Submit" /></center>
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
