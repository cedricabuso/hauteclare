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
			$empno = $_POST['empno'];
			$ename = $_POST['ename'];
			$esex = $_POST['esex'];
			$eaddress = $_POST['eaddress'];
                     $hiredate = $_POST['hiredate'];
			//connect
			$conn = pg_connect("host=localhost port=5432 dbname=ahlscake user=postgres password=admin");
			if (!$conn) {
				die("Error in connection: " . pg_last_error());
			}
			//execute query then close connection
			pg_query($conn, "INSERT INTO emp (empnum, name, sex, address, hire_date) VALUES('{$empno}','{$ename}', '{$esex}', '{$eaddress}', '{$hiredate}')");
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
						<h1 class="gap-1">Add Employee</h1>
						
						<form name="addEmployee" onsubmit="return ValidateAddEmployee();" method="post" action="">
							<table class="table">
                                                        <tr>
									<td>Image *File name of image should be same with product name. (E.g. Juan Dela Cruz.jpg)</td>
									<td><?php //initialize phpuploader
											$uploader=new PhpUploader();
											$uploader->MultipleFilesUpload=false;
											$uploader->InsertText="Upload Image( Max:10MB )";
											$uploader->MaxSizeKB=1024000;	
											$uploader->AllowedFileExtensions="jpeg,jpg,png";
											$uploader->SaveDirectory="../../employees/";
											$uploader->Render();?>
											
											<script type='text/javascript'>
												function CuteWebUI_AjaxUploader_OnTaskComplete(task){
													showSuccessToast(task.FileName + " is uploaded!");
												}
											</script>
									</td>
								</tr>
								<tr>
									<td>Emp No</td>
									<td><input type="text" id="empno" name="empno" onchange="isNumber('empno');"/></td>
								</tr>
								</tr>
								<tr>
									<td>Name</td>
									<td><input type="text" id="ename" name="ename" onchange="isLetter('ename');"/></td>
								</tr>
                                                        <tr>
									<td>Sex</td>
									<td><input type="text" id="esex" name="esex" onchange="isLetter('esex');"/></td>
								</tr>
								
                                                        <tr>
									<td>Address</td>
									<td><input type="text" id="eaddress" name="eaddress" onchange="isLetter('eaddress');"/></td>
								</tr>
                                                                                                   
                                                        <tr>
									<td>Hire Date</td>
									<td><input type="date" id="hiredate" name="hiredate"/></td>
								</tr>
								
								
								<tr>
									<td></td>
									<td><input type="submit" name="submit" value="Add Employee"></td>
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
