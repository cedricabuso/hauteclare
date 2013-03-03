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
		
		$year = date("Y");
		$result = pg_query($conn, "SELECT SUM(prod_price*prod_quantity), date_part('month',cash_date) FROM cashier WHERE date_part('year',cash_date)='{$year}' GROUP BY date_part('month',cash_date) ORDER BY date_part('month',cash_date)");
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
						<h1 class="gap-1">Income Graphs</h1>
						<div id="chart_div"></div>
					</div>
				</div>
				<div class="footer">
					<p class="copyright">© COPYRIGHT 2013 ALL RIGHTS RESERVED</p>
				</div>
			</div>
		</div>
	</body>
	<script type="text/javascript" src="https://www.google.com/jsapi"></script>
	<?php
	echo "
	<script>	
		/*script for drawing charts of Income Graphs*/
		function initiateGoogle(){
			google.load(\"visualization\", \"1\", {packages:[\"corechart\"]});
			google.setOnLoadCallback(drawChart);
		}
		function drawChart() {
			var data = google.visualization.arrayToDataTable([
				['Month', 'Sales'],";
					$i=0;
					while ($row = pg_fetch_row($result)) {
						if($row[1]=='1') $month='January';		else if($row[1]=='2') $month='February';
						else if($row[1]=='3') $month='March';	else if($row[1]=='4') $month='April';
						else if($row[1]=='5') $month='May';		else if($row[1]=='6') $month='June';
						else if($row[1]=='7') $month='July';	else if($row[1]=='8') $month='August';
						else if($row[1]=='9') $month='September';	else if($row[1]=='10') $month='October';
						else if($row[1]=='11') $month='November';	else if($row[1]=='12') $month='December';
						
						if(pg_num_rows($result)==$i+1) echo "['{$month}', {$row[0]}]";
						else echo "['{$month}', {$row[0]}],";
						$i++;
					}
				/*['November',  1000],
				['December',  1170],
				['January',  660],
				['February',  1030]*/
		echo "]) 	;

			var options = {
				title: 'Company Performance'
			};

			var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
			chart.draw(data, options);
		}
		/*End of Income Graphs*/
	</script>";
	pg_close($conn);	//close connection
	?>
	<script>initiateGoogle();</script>
</html>
