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
						<h1 class="gap-1">Online Payment</h1>
						
						<strong><?php
							$today = date("Y-m-d");
							PRINT "$today";
						?>
						<?php 
								$db = pg_connect('host=localhost dbname=ahlscake user=postgres password=admin');
								$product = pg_query($db, "select * from product_list order by prod_id");
								$i = 1;
								
								while($myrow = pg_fetch_assoc($product)){
									printf ("<input type=hidden id='%s' value=%d readonly />\n", $myrow['prod_name'],$myrow['prod_price']);
									$i++;
								}
						?>
						</strong>
						
						<br /><br />
						<form name="creditFrom">
							<input type="hidden" id="hiddencounter" value=0 />
							<center><table>
								<tr>
									<td colspan="3"><center><strong>Credit Card Information</strong></td>
								</tr>
								<tr>
									<td><strong></strong></td>
									<td><input type="text" name="fname" id="fname" onblur="isLetter('fname');" size=20/></td>
									<td><input type="text" name="lname" id="lname" onblur="isLetter('lname');" size=20/></td>
								</tr>
								<tr>
									<td></td>
									<td>First Name</td>
									<td>Last Name</td>
								</tr>
								<tr>
									<td></td>
									<td colspan="2"><input type="text" id="CardNumber" name="creditCard" size=47 onblur="testCreditCard();" /></td>
								</tr>
								<tr>
									<td></td>
									<td colspan="2">Credit Card Number</td>
								</tr>
								<tr>
									<td></td>
									<td><input type="date" name="expiry" id="expiryDate" onblur="dateCheck('<?php echo $today ?>')"/></td>
									<td>
										<select id="CardType" onblur="testCreditCard();">
											<option value="AmEx">American Express</option>
											<option value="CarteBlanche">Carte Blanche</option>
											<option value="DinersClub">Diners Club</option>
											<option value="Discover">Discover</option>
											<option value="enRoute">enRoute</option>
											<option value="JCB">JCB</option>
											<option value="Maestro">Maestro</option>
											<option value="MasterCard">MasterCard</option>
											<option value="Solo">Solo</option>
											<option value="Switch">Switch</option>
											<option value="Visa">Visa</option>
											<option value="VisaElectron">Visa Electron</option>
											<option value="LaserCard">Laser</option>
										</select></td>
								</tr>
								<tr>
									<td></td>
									<td>Expiration Date</td>
									<td>
										<label>Card Type</label>
									</td>
								</tr>
								<tr>
									<td colspan="3" class="center"><input type="submit" name="creditSubmit" value="Submit" /></td>
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
