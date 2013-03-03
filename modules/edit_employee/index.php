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
	<?php //include for phpuploader class
		require_once "../../phpuploader/include_phpuploader.php";
		session_start();
		//id submit is executed
		if(isset($_POST['submit'])){
                     
			$empno = $_POST['id'];
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
			pg_query($conn, "UPDATE emp SET empnum='{$empno}', name='{$ename}', sex='{$esex}', address='{$eaddress}', hire_date='{$hiredate}' WHERE empnum={$empno}");
			pg_close($conn);
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
						<h1 class="gap-1">Edit Employee</h1>
						
						<form name="addEmployee" onsubmit="return ValidateAddEmployee();" method="post" action="">
							<?php //connect
								if(isset($_POST['edit'])){
									$id = $_POST['id'];
									$conn = pg_connect("host=localhost port=5432 dbname=ahlscake user=postgres password=admin");
									if (!$conn) {
										die("Error in connection: " . pg_last_error());
									}
									$result = pg_query($conn, "SELECT * FROM emp WHERE empnum={$id};");
									while ($row = pg_fetch_row($result)) {
										$ename=$row[1];
										$esex=$row[2];
                                                                      $eaddress=$row[3];
										$hiredate=$row[4];
									}
								}
							?>
							<table class="table">
								<tr>
									<td>Emp No</td>
									<td>
										<input type="text" disabled="disabled" value="<?php if(isset($_POST['edit'])) echo $id; ?>"/>
										<input type="hidden" id="id" name="id" value="<?php if(isset($_POST['edit'])) echo $id; ?>"/>
									</td>
								</tr>
								</tr>
								<tr>
									<td>Name</td>
									<td><input type="text" id="ename" name="ename" onchange="isLetter('ename');" value="<?php if(isset($_POST['edit'])) echo $ename; ?>"/></td>
								</tr>
								<tr>
									<td>Sex</td>
									<td><input type="text" id="esex" name="esex" onchange="isNumber('esex');" value="<?php if(isset($_POST['edit'])) echo $esex; ?>"/></td>
								</tr>
								<tr>
									<td>Address</td>
									<td><input type="text" id="eaddress" name="eaddress" onchange="isLetter('eaddress');" value="<?php if(isset($_POST['edit'])) echo $eaddress; ?>"/></td>
								</tr>
                                                        
                                                        <tr>
									<td>Hire Date</td>
									<td><input type="date" id="hiredate" name="hiredate" onchange="isLetter('hiredate');" value="<?php if(isset($_POST['edit'])) echo $hiredate; ?>"/></td>
								</tr>
								<tr>
									<td>Image</td>
									<td><?php //initialize phpuploader
											$uploader=new PhpUploader();
											$uploader->MultipleFilesUpload=false;
											$uploader->InsertText="Upload Image( Max:10MB )";
											$uploader->MaxSizeKB=1024000;	
											$uploader->AllowedFileExtensions="jpeg,jpg,png";
											$uploader->SaveDirectory="../../employees/";
											$uploader->Render();?>
											<br/>File name of image should be same with employee name. (E.g. Juan Dela Cruz.jpg)<br> Accepts <b class="red">*.jpeg, *.jpg and *.png</b> images only.
											<script type='text/javascript'>
												function CuteWebUI_AjaxUploader_OnTaskComplete(task){
													showSuccessToast(task.FileName + " is uploaded!");
												}
											</script>
									</td>
								</tr>
								<tr>
									<td></td>
									<td><input type="submit" name="submit" value="Edit Employee"></td>
								</tr>
							</table>
						</form>
					</div>
				</div>
				<div class="footer">
					<p class="copyright">© COPYRIGHT 2013 ALL RIGHTS RESERVED</p>
				</div>
				<?php if(isset($_POST['submit'])) echo "<script type='text/javascript'>showSuccessToast('Successfully Updated');</script>";?>
			</div>
		</div>
	</body>
</html>
