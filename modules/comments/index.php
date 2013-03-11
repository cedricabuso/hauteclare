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
		
		//id submit is executed
		if(isset($_POST['submit'])){
			//$comment_id = $_POST['comment_id'];
			$comment_name = $_POST['comment_name'];
			$comment_email = $_POST['comment_email'];
            $comment_text = $_POST['comment_text'];
            $time= date('l jS \of F Y h:i:s A');
                 
			//connect
			$conn = pg_connect("host=localhost port=5432 dbname=ahlscake user=postgres password=admin");
			if (!$conn) {
				die("Error in connection: " . pg_last_error());
			}
			//execute query then close connection
			pg_query($conn, "INSERT INTO comments (comment_name, comment_email, comment_text, comment_date) VALUES('{$comment_name}', '{$comment_email}', '{$comment_text}', '{$time}')");
			pg_close($conn);
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
						<h1 class="gap-1">Leave a comment</h1>
						<form name="addComment" onsubmit="return ValidateAddComment();" method="post" action="">
							<table class="table">
								<tr>
									<td>Name</td>
									<td><input type="text" id="comment_name" name="comment_name" onchange="isLetter('name');"/></td>
								</tr>
                                <tr>
									<td>E-mail(optional)</td>
									<td><input type="text" id="comment_email" name="comment_email" onchange="isLetter('name');"/></td>
								</tr>

									<td>Comment</td>
									<td><textarea name="comment_text" id="comment_text" rows="5" cols="35" placeholder="Add your comment/suggestion here ... "></textarea></td>
								</tr>
								<tr>
									<td></td>
									<td><input type="submit" name="submit" value="Add Comment"></td>
								</tr>
							</table>
							<br>
                            <h1 class="gap-1">View All Comments</h1>
							<table class="viewAllComments">								
								<?php //load the list of existing comments
									$i=0;
                                    $conn = pg_connect("host=localhost port=5432 dbname=ahlscake user=postgres password=admin");
									$result = pg_query($conn, "SELECT * FROM comments ORDER BY comment_date DESC");
									while ($row = pg_fetch_row($result)) {
										echo "<tr class='TDR'>";
										echo "<td class='TDR'><b class='green'>Name:</b> $row[0] <br> <b class='green'>Email:</b> $row[1] <br> <b class='green'>Comment:</b> $row[2] <br><b class='green'>Date:</b> $row[3] </td>";
                                        echo "</tr>";
									}
									pg_close($conn);	//close connection
								?>
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
