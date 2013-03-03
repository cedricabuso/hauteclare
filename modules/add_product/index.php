<!DOCTYPE>
<html>
	<head>
	  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	  <title>Ahl's Cake</title>
	  <link href="../../css/jquery.toastmessage.css" rel="stylesheet" type="text/css">
	  <link href="../../css/style.css" rel="stylesheet" type="text/css">
	</head>
	<?php //include for phpuploader class
		require_once "../../phpuploader/include_phpuploader.php";
		session_start();
		//id submit is executed
		if(isset($_POST['submit'])){
			$id = $_POST['id'];
			$name = $_POST['name'];
			$description = $_POST['desc'];
			$price = $_POST['price'];
			//connect
			$conn = pg_connect("host=localhost port=5432 dbname=ahlscake user=postgres password=admin");
			if (!$conn) {
				die("Error in connection: " . pg_last_error());
			}
			//execute query then close connection
			pg_query($conn, "INSERT INTO product (prod_id, prod_name, prod_desc, prod_img, prod_price) VALUES('{$id}','{$name}', '{$description}', '{$name}', '{$price}')");
			pg_close($conn);
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

					</div>
					<div class="mid-right">
						<h1 class="gap-1">Add Product</h1>
						
						<form name="addProduct" onsubmit="return ValidateAddProduct();" method="post" action="">
							<table class="table">
								<tr>
									<td>ID</td>
									<td><input type="text" id="id" name="id" onchange="isNumber('id');"/></td>
								</tr>
								</tr>
								<tr>
									<td>Name</td>
									<td><input type="text" id="name" name="name" onchange="isLetter('name');"/></td>
								</tr>
								<tr>
									<td>Price</td>
									<td><input type="text" id="price" name="price" onchange="isNumber('price');"/></td>
								</tr>
								<tr>
									<td>Description</td>
									<td><textarea name="desc" id="desc" rows="5" cols="30" placeholder="Put description here ... "></textarea></td>
								</tr>
								<tr>
									<td>Image</td>
									<td><?php //initialize phpuploader
											$uploader=new PhpUploader();
											$uploader->MultipleFilesUpload=false;
											$uploader->InsertText="Upload Image( Max:10MB )";
											$uploader->MaxSizeKB=1024000;	
											$uploader->AllowedFileExtensions="jpeg,jpg,png";
											$uploader->SaveDirectory="../../products/";
											$uploader->Render();?>
											<br/>File name of image should be same with product name. (E.g. Better Than Sex Cake.jpg)<br> Accepts <b class="red">*.jpeg, *.jpg and *.png</b> images only.
											<script type='text/javascript'>
												function CuteWebUI_AjaxUploader_OnTaskComplete(task){
													showSuccessToast(task.FileName + " is uploaded!");
												}
											</script>
									</td>
								</tr>
								<tr>
									<td></td>
									<td><input type="submit" name="submit" value="Add Product"></td>
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
	<script type="text/javascript" src="../../js/script.js"></script>
	<script type="text/javascript" src="../../js/jquery.min.js"></script>
	<script src="../../js/jquery.toastmessage.js" type="text/javascript"></script>
</html>
