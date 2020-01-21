<div class="loader">

	

</div>

<style type="text/css">

	.loader {

		position: absolute;

		top:50%;

		left:50%;

		border: 16px solid #f3f3f3; /* Light grey */

		border-top: 16px solid #3498db; /* Blue */

		border-radius: 50%;

		width: 120px;

		height: 120px;

		animation: spin 2s linear infinite;

		background: rgba(189, 195, 199, 1);

		z-index: 10;

	}



	@keyframes spin {

		0% { transform: rotate(0deg); }

		100% { transform: rotate(360deg); }

	}

</style>

<nav class="navbar navbar-expand-sm bg-dark navbar-dark">

	<!-- Brand -->

	<a class="navbar-brand" href="dashboard.php">HOME</a>

	<!-- Toogler -->

	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">

		<span class="navbar-toggler-icon"></span>

	</button>

	<!-- Links -->

	<div class="collapse navbar-collapse" id="collapsibleNavbar">

		<ul class="navbar-nav">

			<li class="nav-item dropdown">

				<a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">

					Addition

				</a>

				<div class="dropdown-menu">

					<a class="dropdown-item" href="new_party.php">Party</a>

					<a class="dropdown-item" href="new_group.php">Item Group</a>

					<a class="dropdown-item" href="new_item.php">Item Name</a>

				</div>

			</li>

			<li class="nav-item dropdown">

				<a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">

					Voucher

				</a>

				<div class="dropdown-menu">

					<a class="dropdown-item" href="new_sell.php">Sell</a>

					<a class="dropdown-item" href="new_payment.php">Payment Entry</a>

					<a class="dropdown-item" href="new_caret.php">Caret Entry</a>


				</div>

			</li>



			<!-- Dropdown -->

			<li class="nav-item dropdown">

				<a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">

					Reports

				</a>

				<div class="dropdown-menu">

					<a class="dropdown-item" href="customer_bill_report.php">Customer Bill Reports</a>

					<a class="dropdown-item" href="daily_report.php">Daily Reports</a>

					<a class="dropdown-item" href="person_wise_report.php">Person Wise Reports</a>

					<a class="dropdown-item" href="caret_report.php">Caret Reports</a>


					<a class="dropdown-item" href="account_info.php">Account Information</a>

				</div>

			</li>

			<?php

			if($_SESSION['u_type'] == 2){

				?>

				<li class="nav-item dropdown">

					<a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">

						Logs

					</a>

					<div class="dropdown-menu">

						<a class="dropdown-item" href="log_payment.php">Payment</a>

					</div>

				</li>

				<?php	

			}

			?>

			<li class="nav-item">

				<a class="nav-link" href="change_pass.php">Change My Password</a>

			</li>



			<li class="nav-item pull-right">

				<a class="nav-link" href="logout.php">Logout</a>

			</li>

		</ul>

	</div>

	<!-- <script type="text/javascript">

		$("#check_balance").click(function(e){

			e.preventDefault();

			$.ajax({

				type:"POST",

				headers: "Access-Control-Allow-Origin:*",

				url:"http://bulksms.bizzarch.com/api/balance.php?authkey=252881ATFfuhrlP5c1c933e&type=4",

				success:function(data){

					alert(data);

				}

			})

		})

	</script> -->

</nav>