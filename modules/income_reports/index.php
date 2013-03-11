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
	<?php //connect
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
						<h1 class="gap-1">Income Report</h1>
						<form name="viewby" method="post">
						<table class="viewBy"><tr>
							<td>View by:</td>
							</tr>
							<tr>
							<td>Year</td>		
						    <td><select name="year">
								<option value="0">Year</option>
							    <option value="2013">2013</option>
								<option value="2012">2012</option>
								<option value="2011">2011</option>
								<option value="2010">2010</option>
								<option value="2009">2009</option>
								<option value="2008">2008</option>
								<option value="2007">2007</option>
								<option value="2006">2006</option>
								</select>
							</td>
							<td>Month</td>
						    <td><select name="month">
								<option value="0">Month</option>
								<option value="01">Jan</option>
								<option value="02">Feb</option>
								<option value="03">Mar</option>
								<option value="04">Apr</option>
								<option value="05">May</option>
								<option value="06">Jun</option>
								<option value="07">Jul</option>
								<option value="08">Aug</option>
								<option value="09">Sep</option>
								<option value="10">Oct</option>
								<option value="11">Nov</option>
								<option value="12">Dec</option>
								</select>
							</td>
							<td>Day</td>
							<td><select name="day">
								<option value="0">Day</option>
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5">5</option>
								<option value="6">6</option>
								<option value="7">7</option>
								<option value="8">8</option>
								<option value="2">9</option>
								<option value="10">10</option>
								<option value="11">11</option>
								<option value="12">12</option>
								<option value="13">13</option>
								<option value="14">14</option>
								<option value="15">15</option>
								<option value="16">16</option>
								<option value="17">17</option>
								<option value="18">18</option>
								<option value="19">19</option>
								<option value="20">20</option>
								<option value="21">21</option>
								<option value="22">22</option>
								<option value="23">23</option>
								<option value="24">24</option>
								<option value="25">25</option>
								<option value="26">26</option>
								<option value="27">27</option>
								<option value="28">28</option>
								<option value="29">29</option>
								<option value="30">30</option>
								<option value="31">31</option>
								</select>
							</td>
							<td><input type="submit" name="view" value="View"></td>
						</tr></table>
						</form>
							<table class="viewAllTable">
								<tr>
									<td class="deleteId">Name</td>
									<td class="deleteId">Price</td>
									<td class="deleteId">Quantity</td>
									<td class="deleteId">Date</td>
									<td class="deleteId">Income</td>
								</tr>
								<?php //load the list of existing products
								if(isset($_POST['view'])){
								if (($_POST["year"]!=0) && ($_POST["month"]==0) &&($_POST["day"]==0)){
									$year=$_POST["year"];
									echo "<br/><h3>Displaying income report of $year</h3><br/>";
									$result = pg_query($conn, "SELECT prod_id, prod_name, prod_price, prod_quantity, cash_date, date_part('year', cash_date) FROM CASHIER WHERE date_part('year', cash_date)='$year' GROUP BY prod_id, prod_name, prod_price, prod_quantity, cash_date, date_part('year', cash_date)");
								}
								else if (($_POST["year"]!=0) && ($_POST["month"]!=0) &&($_POST["day"]==0)){
									$year=$_POST["year"];
									$month=$_POST["month"];
									echo "<br/><h3>Displaying income report of $month-$year</h3><br/>";
									$result = pg_query($conn, "SELECT prod_id, prod_name, prod_price, prod_quantity, cash_date, date_part('year', cash_date), date_part('month',cash_date) FROM CASHIER WHERE date_part('year', cash_date)='$year' AND  date_part('month', cashdate)='$month' GROUP BY prod_id, prod_name, prod_price, prod_quantity, cash_date, date_part('year', cash_date), date_part('month',cash_date)");
								}
								else if (($_POST["year"]!=0) && ($_POST["month"]!=0) &&($_POST["day"]!=0)){
									$year=$_POST["year"];
									$month=$_POST["month"];
									$day=$_POST["day"];
									echo "<br/><h3>Displaying income report of $day-$month-$year</h3><br/>";
									$result = pg_query($conn, "SELECT prod_id, prod_name, prod_price, prod_quantity, cash_date, date_part('year', cash_date), date_part('month',cash_date), date_part('day',cash_date) FROM CASHIER WHERE date_part('year', cashdate)='$year' AND  date_part('month', cash_date)='$month' AND date_part('day',cash_date)='$day' GROUP BY prod_id, prod_name, prod_price, quantity, cashdate, date_part('year', cash_date), date_part('month',cash_date), date_part('day',cash_date)");
								}
								
								else{
									echo "<br/><h3>Displaying all</h3><br/>";
									$result = pg_query($conn, "SELECT * FROM CASHIER");
								}	
								}
								else{
									echo "<br/><h3>Displaying all</h3><br/>";
									$result = pg_query($conn, "SELECT * FROM CASHIER");
								}	
								$i=0;
								$total=0;
									
								while ($row = pg_fetch_row($result)) {
										$income=$row[2]*$row[3];
										$total+=$income;
										echo "<tr class='TDR'>";
										echo "<td class='TDR'>$row[1]</td> <td class='TDR'>$row[2]</td> <td class='TDR'>$row[3]</td> <td class='TDR'>$row[4]</td><td class='TDR'>$income</td>" ;
										echo "</tr>";
								}
									echo "<tr>";
									echo "<td colspan=4>";
									echo "<td>$total</td>";	
									echo "</tr>";
									pg_close($conn);	//close connection
								?>		
							</table>
					</div>
				</div>
				<div class="footer">
					<p class="copyright">� COPYRIGHT 2013 ALL RIGHTS RESERVED</p>
				</div>
			</div>
		</div>
	</body>
</html>
