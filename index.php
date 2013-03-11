<!DOCTYPE>
<html>
	<head>
	  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	  <title>Ahl's Cake</title>
	  <script type="text/javascript" src="js/script.js"></script>
	  <script type="text/javascript" src="js/jquery.min.js"></script>
	  <script src="js/jquery.toastmessage.js" type="text/javascript"></script>
	  <link href="css/jquery.toastmessage.css" rel="stylesheet" type="text/css">
	  <link href="css/style.css" rel="stylesheet" type="text/css">
	</head>
	<body>
		<div class="wrapper">
			<div class="main">
				<div class="header">Ahl's Cakes</div>

				<div class="mid">
					<div class="mid-left">
						<h2 class="gap-2">MENU</h2>
						<ul class="left-nav bmenu">
						  <li class="top"><a href="">Home</a></li>
						  <li><a href="modules/customer_view_products/?offset=0&pgnum=0">View Products</a></li>
						  <li><a href="modules/bulk_order/">Order Online</a></li>
						  <li><a href="modules/comments/">Comment</a></li>
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
								include("modules/login/index.php");
								echo "<li class='bottom'><a href=\"modules/sign_up/\">Sign Up</a></li>";
								echo "</li>
									</ul>";
							}
							else{
								$role=strtoupper($_SESSION["role"]); 
								echo "<h2 class=\"gap-2\">{$role}</h2>
								<ul class=\"left-nav bmenu\">";
								if($_SESSION["role"]=="owner"){
									echo "<li class='top'><a href=\"modules/add_employee/\">Add Employee</a></li>
										  <li><a href='modules/delete_employee/'>Delete Employee</a></li>
										  <li><a href='modules/search_employee/'>Search Employee</a></li>
										  <li><a href='modules/view_all_employee/'>View All Employee</a></li>";
									$top=1;
								}
								if($_SESSION["role"]=="employee" || $_SESSION["role"]=="owner"){
										if($top==1) echo "<li><a href='modules/cashier_system/'>Cashier System</a></li>";
										else echo "<li class='top'><a href='modules/cashier_system/'>Cashier System</a></li>";
										echo "<li><a href='modules/inventory_system/'>Inventory System</a></li>
											  <li><a href='modules/income_reports/'>Income Reports</a></li>
											  <li><a href='modules/income_graphs/'>Income Graphs</a></li>
											  <li><a href='modules/add_product/'>Add Product</a></li>
											  <li><a href='modules/delete_product/'>Delete Product</a></li>
											  <li class='bottom'><a href=\"modules/logout/index.php\">Logout</a></li>";
								}
							}
						?>
					</div>
					<div class="mid-right">
						<h1 class="gap-1">Welcome to our website</h1>
						<p class="txt-1"> <strong>Lorem ipsum</strong> dolor sit amet,
						consectetur adipiscing elit. Nam eget tellus eget mauris varius
						facilisis. Sed neque erat, ultrices id ultricies at, viverra a ante.
						Class aptent taciti sociosqu ad litora torquent per conubia nostra, per
						inceptos himenaeos. Pellentesque id est blandit ante feugiat dignissim
						ac eu neque. Suspendisse quis aliquam urna. Morbi eget augue ac libero
						tempus consequat. Sed et enim erat. In hac habitasse platea dictumst.
						Cras elit velit, fringilla vel fermentum nec, ullamcorper quis tortor. </p>
						<p class="txt-1"> <strong>Praesent adipiscing</strong> ipsum eget
						metus tempus nec porttitor felis sollicitudin. Cras scelerisque metus
						in elit tincidunt interdum. Aenean placerat justo eu sem gravida vel
						placerat enim commodo. Integer condimentum venenatis orci, tincidunt
						venenatis arcu rutrum vel. Donec nibh eros, commodo eu dapibus vel,
						aliquet convallis sapien. Aliquam erat volutpat. Suspendisse vestibulum
						adipiscing blandit. Vestibulum ullamcorper condimentum erat, eu
						dignissim risus elementum vel. Maecenas elementum aliquam accumsan.
						Nunc pellentesque facilisis est eget commodo. Integer sagittis mi a
						lacus scelerisque eget rhoncus nisi vehicula. </p>
						<p class="txt-1"> <strong>Vestibulum ut neque</strong> lorem, vitae
						luctus leo. Praesent interdum sapien sed lectus vehicula id auctor
						dolor vulputate. Curabitur ut lectus est, molestie vestibulum mi. Cum
						sociis natoque penatibus et magnis dis parturient montes, nascetur
						ridiculus mus. Ut metus metus, varius sed dictum eget, lacinia nec dui.
						Etiam interdum volutpat nisl, nec semper tortor interdum et. Curabitur
						lacus ipsum, laoreet porttitor iaculis pharetra, dictum sit amet purus.
						Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent et
						nulla a diam pharetra laoreet. Etiam purus mi, fermentum nec varius a,
						vulputate sit amet erat. Vivamus rutrum nunc eget arcu vehicula semper.
						</p>
					</div>
				</div>
				<div class="footer">
					<p class="copyright">© COPYRIGHT 2013 ALL RIGHTS RESERVED</p>
				</div>
			</div>
		</div>
	</body>
</html>