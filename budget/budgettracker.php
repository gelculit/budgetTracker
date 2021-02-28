<?php include "db.php"; ?>



<?php 
	if (isset($_POST['sbmtamt'])) {
		
		$desc = $_POST['desc'];
		$chosen = $_POST['chosen'];
		$amt = $_POST['amt'];
		
		$start_day = date('d');
		$start_month = date('M');
		$start_year = date('Y');
		
		
		$query = "SELECT budget_tracker";
		$query = "INSERT INTO budget_tracker (date_month, date_year, acct_entry_date, acct_description, acct_status, acct_amount) VALUES ('{$start_month}', '{$start_year}', now(), '{$desc}', '{$chosen}', '{$amt}')";
		$select_query = mysqli_query($conn, $query);
		
		if(!$select_query) {
			
			die("QUERY FAILED ." . mysqli_error($conn));
		}
		
		header("Location: budgettracker.php");
	}
	
	
	
	
	
	
	/*
	$calcquery = "SELECT * FROM budget_tracker";
	$select_calcquery = mysqli_query($conn, $calcquery);
	
	$budgettotal = 51000;
	while($row = mysqli_fetch_assoc($select_calcquery)) {

		
		$tstatus = $row['acct_status'];
		$tamt = $row['acct_amount'];
		
		if ($tstatus == "Debit") {
			$budgettotal = $budgettotal - $tamt;
		} else {
			$budgettotal = $budgettotal + $tamt;
		}
		
	}*/
	

?>


<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		
		<link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="css/fontAwesome.css">
		<link rel="stylesheet" href="css/all.min.css">
		<link rel="stylesheet" href="css/fontawesome.min.css">
		<script src="css/jquery-1.11.2.min.js"></script>
		<script src="css/popper.min.js"></script>
		<script src="css/bootstrap.min.js"></script>
		
		<style>
			table {
			  font-family: arial, sans-serif;
			  border-collapse: collapse;
			  width: 100%;
			}

			td, th {
			  border: 1px solid #dddddd;
			  text-align: left;
			  padding: 8px;
			}

			tr:nth-child(even) {
			  background-color: #dddddd;
			}
		</style>
		
	</head>
	<body>
	
		<nav class="navbar navbar-expand-sm bg-info navbar-light  sticky-top">
			<div class="container">
			
				<a class="navbar-brand" href="#"><strong>Shop Eezy Expenses Tracker</strong></a>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse  justify-content-end" id="collapsibleNavbar">
					<ul class="navbar-nav">
						<li class="nav-item">
							<?php
								$start_day = date('d');
								$start_month = date('M');
								$start_year = date('Y');
								echo "<strong>$start_month $start_day, $start_year</strong>";
							?>
						</li>
						
					</ul>
					
					
				 </div>  
			 </div>
		</nav>
		<br><br>
		
		
		<div class="container">
			<div class="row">
				<h4>Initial Capital: Php51,000.00</h4>
			</div>
			
		</div>
		
		<br><br>
		
		<div class="container">
			<table>
			<thead>
				  <tr>
						<th><center>Description</center></th>
						<th><center>Amount</center></th>
						<th><center>Debit/Credit</center></th>
						<th><center>Total Amount</center></th>
						<th><center>Date</center></th>
						<!--<th><center>Review</center></th>-->
				  </tr>
			</thead>
			<tbody>
				 
					
					<?php
						$dispquery = "SELECT * FROM budget_tracker";
						$select_dispquery = mysqli_query($conn, $dispquery);
						
						$initbudget = 51000;
						while($row = mysqli_fetch_assoc($select_dispquery)) {

							
							$dstatus = $row['acct_status'];
							$damt = $row['acct_amount'];
							$ddesc = $row['acct_description'];
							$ddate = $row['acct_entry_date'];
							
							if ($dstatus == "Debit") {
								$initbudget = $initbudget - $damt;
							} else {
								$initbudget = $initbudget + $damt;
							}
							
							
							$ddate = strtotime($ddate);
							$start_day = date('d', $ddate);
							$start_month = date('M', $ddate);
							$start_year = date('Y', $ddate);
																	
							$initbudget2 = number_format($initbudget, 2);
							$damt2 = number_format($damt, 2);
							
							echo " <tr>";
							echo "<td>$ddesc</td>";
							echo "<td><center>$damt2</center></td>";
							echo "<td><center>$dstatus</center></td>";
							echo "<td><center>$initbudget2</center></td>";
							echo "<td><center>$start_month $start_day, $start_year</center></td>";
							//echo "<td><center><button type='button' class='btn btn-outline-info btn-sm'>Review</button></center></td>";
							echo " </tr>";
						}
					?>
				  
				  </tr>
				 
			</tbody>	  
			</table>
			<br>
			<button type="button" class="btn btn-outline-info btn-sm"  data-toggle="modal" data-target="#myModal">
				Add Entry
			</button>
		</div>
		
		<!-- The Modal -->
		<div class="modal" id="myModal">
			  <div class="modal-dialog">
					<div class="modal-content">

						  <!-- Modal Header -->
						  <div class="modal-header">
							<h4 class="modal-title text-center"><center><?php echo "<strong>$start_month $start_day, $start_year</strong>"; ?></h4>
							<button type="button" class="close" data-dismiss="modal">&times;</button>
						  </div>

						  <!-- Modal body -->
						  <div class="modal-body">
							  <form  method="post" action="budgettracker.php">
								  <div class="form-group">
									<label for="uname">Description</label>
									<input type="text" class="form-control" id="uname" placeholder="Enter description" name="desc">
									
								  </div>
								  <div class="form-group">
									<label for="pwd">Debit / Credit</label>
									<select class="form-control" id="sel1" name="chosen">
										<option value=" ">Select an Option</option>
										<option value="Debit">Debit (Deduct from account)</option>
										<option value="Credit">Credit (Add to account)</option>   
									  </select>
								  </div>
								  
								  
								  <div class="form-group">
									<label for="pwd">Amount</label>
									<input type="number" class="form-control" id="pwd" placeholder="Enter amount" name="amt">
									
								  </div>
								  
								  <hr />
									<button type="submit" class="btn btn-outline-info btn-sm" name="sbmtamt">Submit</button>
								  
								</form>
						  </div>
						 
					</div>
			  </div>
		</div>
		<br><br>
		<div class="footer">
		<div class="container">
				
				
				<small> <a style="text-decoration: none; color: white;" href="#">&copy; </a><?php echo date('Y'); ?>  GelCulit Creative Concepts</small>
				
		</div><!--footer-->
	</div>
	
	</body>
</html>