<?php session_start(); 
?>



<!DOCTYPE html>

<html>

<head>

	<title></title>

	<link rel="stylesheet" href="../css/bootstrap.min.css">

	<script src="../js/jquery.min.js"></script>

	<script src="../js/popper.min.js"></script>

	<script src="../js/bootstrap.min.js"></script>

	<link rel="stylesheet" type="text/css" href="../css/guj_input.css">

	<style type="text/css">

		#tablePrint{

			width:960px;

			text-align: center;

		}

		th,td{

			border:1px solid black;

		}

		thead{

			margin-top: 10px;

		}

		@media print{

			@page{

				margin-top: 30px;

			}

		}

	</style>

</head>

<body>

	<!-- <div class="container-fluid"> -->

		<!-- <div class="row"> -->

			<!-- <div class="col-md-12"> -->

				<table class="guj" id="tablePrint" style="font-size:24px; margin: 20px 0px 0px 30px;">

					<thead>

						<tr>

							<th colspan="8">

								taarIKa: <?php echo $_SESSION['dailyReport']['d']; ?>

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

							<th>koroT TaoTla</th>

						</tr>

					</thead>

					<tbody>

						<?php

						$previous_total = 0;

						$grand_total = 0;

						$today_total = 0;



						foreach ($_SESSION['dailyReport']['table'] as $key => $value) {

							?>

							<tr>

								<td style="text-align:left;"><?php echo $value['name'] ?></td>

								<td><?php echo round($value['total']) ?></td>

								<?php $grand_total += round($value['total']); ?>

								<td></td>

								<td><?php echo round($value['pending']) ?></td>

								<?php $previous_total += round($value['pending']) ?>

								<td><?php echo round($value['today']) ?></td>

								<?php $today_total += round($value['today']) ?>

								<td><?php echo round($value['previous']) ?></td>

								<td><?php echo $value['days'] ?></td>

								<td><?php echo $value['caret_total'] ?></td>

							</tr>

							<?php

						}

						?>

						<tr>

							<td></td>

							<td><?php echo $grand_total; ?></td>

							<td></td>

							<td><?php echo $previous_total; ?></td>

							<td><?php echo $today_total ;?></td>

						</tr>

					</tbody>

				</table>

		<!-- 	</div>

		</div>

	</div> -->

</body>

</html>