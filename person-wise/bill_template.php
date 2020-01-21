<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="../css/guj_input.css">
	<link rel="stylesheet" href="../css/bootstrap.min.css">
	<style type="text/css">
	.guj{
		font-size: 22px;
	}
	table{
		page-break-after: always;
	}
	th,td {
		border: 1px solid black;
		text-align: center;
	}
	.nb{
		border: none;
	}
	.rb{
		border-right: 1px solid black;
	}
</style>
</head>
<body>
	<table class="guj" style="max-width:11cm;margin-left: 20px;">
		<tr>
			<td class="nb" colspan="3" style="text-align: center;font-size: 25px;font-family: 'Times New Roman', Times, serif;">VFly Soft Solutions Fruit market Customer Solution Demo		</tr>
		<!-- <tr style="border: 1px solid black;">
			<td colspan="3" style="text-align: center;font-size:18px;">Jnarla f`uT marcanT AonD vaoJITobala kmaISana AoJnT. navaI Saak maak-oT, BauJ kcC.</td>
		</tr> -->
		<tr>
			<?php session_start(); 
			?>
			<td>naama</td>
			<td colspan="2"><?php echo $_SESSION['data']['name'] ?></td>
		</tr>
		<tr>
			<td>AagaLanaa baakI:</td>
			<td colspan="2"><?php echo $_SESSION['data']['pending'] ?></td>
		</tr>
		<tr>
			<th>taarIKa</th>
			<th>Javak</th>
			<th>Aavak</th>
		</tr>
		<!-- Dynamic Rows -->
		<?php 
		$total=$_SESSION['data']['pending'];
		$avak = 0;
		$javak = 0;
		// for($i=0;$i<sizeof($_SESSION['data']['table']);$i++) {
		// 	$total = $total + $_SESSION['data']['table']['debit'][$i] - $_SESSION['data']['table']['credit'][$i];
		foreach ($_SESSION['data']['table'] as $key => $value) {
			$total = $total - $value[0] + $value[1];
			$avak += $value[0];
			$javak += $value[1];
			if($value[0] != 0 || $value[1] !=0){
			?>
				<tr>
					<td><?php echo str_replace('-', '.', $key) ?></td>
					<td><?php echo $value[0] ?></td>
					<td><?php echo $value[1] ?></td>
				</tr>
			<?php
			}
		}
		?>
		<tr>
			<td>TaoTla</td>
			<td><?php echo $avak ?></td>
			<td><?php echo $javak ?></td>
		</tr>
		<!-- //Dynamic Rows -->
		<tr>
			<td></td>
			<td>naooT TaoTla</td>
			<td><?php echo $total; ?></td>
		</tr>
	</table>
</body>
</html>
