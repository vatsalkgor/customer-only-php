<?php 

session_start();

if(!isset($_SESSION['u_id'])){

	header('location:index.php');

}else{

	?>

	<!DOCTYPE html>

	<html>

	<head>

		<title>Daily Report</title>

		<meta name="viewport" content="width=device-width, initial-scale=1">

		<link rel="stylesheet" href="css/bootstrap.min.css">

		<script src="js/jquery.min.js"></script>

		<script src="js/popper.min.js"></script>

		<script src="js/bootstrap.min.js"></script>

		<link rel="stylesheet" type="text/css" href="css/guj_input.css">

		<link rel="stylesheet" href="css/jquery-ui.min.css">

		<script src="js/jquery-ui.min.js"></script>

		<style type="text/css">

		#tablePrint{

			width:1200px;

			text-align: center;

		}	

		.col-md-12{

			padding-left: 0px;

		}

		th,td{

			border:1px solid black;

		}

		@media print{

			#report,#print{

				/*visibility: hidden;*/

				display: none;

			}

			#tablePrint{

				visibility: visible;

				/*width: 900px;*/

				text-align: center;;

			}

			th,td{

				border:1px solid black;

			}

		}

	</style>

</head>

<body>

	<?php include "include/navbar.php"; ?>

	<br>

	<div class="container-fluid">

		<div class="row">

			<div class="col-md-2">

				<label class="control-label" id="date_text">Date</label>

				<input type="text" name="date" id="date" class="form-control guj datepicker">

			</div>

			<div class="col-md-2">

				<br>					

				<button class="btn btn-primary" id="report">Daily Report</button>

			</div>

		</div>

		<br>

		<div class="row">

			<div class="col-md-12">

			<!-- TABLE NOT IN USE -->

			<!-- 	<table class="guj" id="tablePrint" style="font-size:28px;">

					<thead>

						<tr>

							<th colspan="7">

								taarIKa: <span id="tarikh"></span>

							</th>

						</tr>

						<tr>

							<th style="text-align:left;" width="20%";>naama</th>

							<th>kula baakI</th>

							<th width="10%">Jmaa</th>

							<th>AagaLanaa baakI</th>

							<th>AaJnau baIla</th>

							<th>paaClaa Jmaa</th>

							<th>idvasa</th>

						</tr>

					</thead>

					<tbody id="body"></tbody>

				</table> -->

			</div>

		</div>

	</div>

	<script type="text/javascript">

		$(document).ready(function(){

			$(".loader").css('display','none');

			$('.datepicker').datepicker({

				dateFormat:'dd.mm.yy'

			}).datepicker('setDate',new Date);



			$("#report").click(function(e){

				$(".loader").css('display','block');

				var date= $("#date").val();

				e.preventDefault();

				$.ajax({

					type:"post",

					url:"daily_report/get_table.php",

					data:{d:date},

					success:function(data){

						$(".loader").css('display','none');

						// console.log(data)

						window.location="daily_report/daily_report_template.php";

					}

				});

			})

		})

	</script>

</body>

</html>

<?php 

}

?>