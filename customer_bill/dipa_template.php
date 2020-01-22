<?php 
session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="../css/bootstrap.min.css">
	<script src="../js/jquery.min.js"></script>
	<script src="../js/popper.min.js"></script>
	<script src="../js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="../css/guj_input.css">
	<style type="text/css">
	.guj{
		font-size: 18px;
	}
	.sf{
		font-size: 18px;
	}
	table{
		page-break-after: always;
		border-spacing: 0px;
	}
	th, td {
		border-spacing: 0px;
		border: 1px solid black;
		text-align: center;
	}
	/*@media{
		@page{
			size: 15.24cm;
			margin:0px;
		}
	}*/
</style>
</head>

<body>
	<center>
	<div class="">
	<?php
	foreach ($_SESSION['data'] as $key => $value) {
		$total = 0;
		?>
		<table class=" guj" style="min-width: 10.5cm;max-width:10.5cm;min-height: 15cm;max-height: 15cm; margin: 40px;">
			<tr class="sf" >
				<td height="5" colspan="5" style="font-size:16px;text-align: center;border-bottom:0px;font-family: 'Times New Roman', Times, serif;">Bhagwati Fruits & Vegetables</td>
			</tr>
			<tr class="sf">
				<td colspan="5" style="font-size:16px;text-align:center;border-top:0px;border-bottom:0px;font-family: 'Times New Roman', Times, serif;">"APMC" Sardar Patel Market Yard, Bhuj</td>
			</tr>
			<tr class="sf">
				<td colspan="5" style="font-size:16px;text-align:center;border-top:0px;border-bottom:0px;font-family: 'Times New Roman', Times, serif;">Kewalbhai - 9925966985</td>
			</tr>
			<tr>
				<td height="5" style="border-right: 0px;">naama</td>
				<td height="5" style="border-left: 0px;border-right: 0px;"><?php echo $value['name'] ?></td>
				<td height="5">taarIKa</td>
				<td height="5" style="border-left: 0px;"colspan="2"><?php echo str_replace('-', '.', $value['date']) ?></td>
			</tr>
			<tr>
				<td height="5">Aa[Tma</td>
				<td height="5">dagaInaa</td>
				<td height="5">vaJna</td>
				<td height="5">Baava</td>
				<td height="5">TaoTla</td>
			</tr>
			<!-- dynamic item rows -->
			<?php 
			$i;
			for ($i=0; $i < sizeof($value['items']['i_name']) ; $i++) {	
				?>
				<tr>
					<td height="5" style="border-right: 1px solid black;border-left: 1px solid black; border-bottom: 0px;border-top: 0px;"><?php echo $value['items']['i_name'][$i] ?></td>
					<td height="5" style="border-right: 1px solid black;border-left: 1px solid black; border-bottom: 0px;border-top: 0px;"><?php echo $value['items']['qty'][$i] ?></td>
					<td height="5" style="border-right: 1px solid black;border-left: 1px solid black; border-bottom: 0px;border-top: 0px;"><?php echo $value['items']['weight'][$i] ?></td>
					<td height="5" style="border-right: 1px solid black;border-left: 1px solid black; border-bottom: 0px;border-top: 0px;"><?php echo $value['items']['rate'][$i] ?></td>
					<td height="5" style="border-right: 1px solid black;border-left: 1px solid black; border-bottom: 0px;border-top: 0px;"><?php echo $value['items']['rate'][$i] * $value['items']['weight'][$i]; ?></td>
					<?php $total += round($value['items']['rate'][$i] * $value['items']['weight'][$i]) ;?>
				</tr>
				<?php	
			}
			for($j=$i;$j<10;$j++){	
					?>
					<tr>
						<td height="5" class="nb" style="border-right: 1px solid black;border-left: 1px solid black; border-bottom: 0px;border-top: 0px;">&nbsp;</td>
						<td height="5" class="nb" style="border-right: 1px solid black;border-left: 1px solid black; border-bottom: 0px;border-top: 0px;">&nbsp;</td>
						<td height="5" class="nb" style="border-right: 1px solid black;border-left: 1px solid black; border-bottom: 0px;border-top: 0px;">&nbsp;</td>
						<td height="5" class="nb" style="border-right: 1px solid black;border-left: 1px solid black; border-bottom: 0px;border-top: 0px;">&nbsp;</td>
						<td height="5" class="nb" style="border-right: 1px solid black;border-left: 1px solid black; border-bottom: 0px;border-top: 0px;">&nbsp;</td>
					</tr>
					<?php
				}
				?>
			<!-- END dynamic item rows  -->
			<tr class="nb sf" style="border-bottom: 0px; border-top: 0px;">
				<td height="5" style="border-right: 0px;border-bottom: 0px;">AagaLanaa baakI</td>
				<td height="5" style="border-left: 0px;border-bottom: 0px;border-right: 0px;" colspan="2"><?php echo number_format((float)$value['pending'],2,'.','')?></td>
				<td height="5" style="border-bottom: 0px;">TaoTla</td>
				<td height="5" style="border-bottom: 0px;"><?php echo $total; ?></td>
			</tr>
			<tr class="sf" style="border-top: 0px; border-bottom: 0px;">
				<td height="5" style="border-bottom: 0px;border-right: 0px;border-top: 0px;">AaJnau baIla</td>
				<td height="5" style="border-left: 0px;border-bottom: 0px;border-right: 0px;border-top: 0px;" colspan="2"><?php echo $total + $value['o_e'] + $value['wage'] + $value['com'] ?></td>
				<td height="5" style="border-bottom: 0px;border-top: 0px;">Anya Kaca-</td>
				<td height="5" style="border-bottom: 0px;border-top: 0px;"><?php echo $value['o_e'] ?></td>
			</tr>
			<tr class="sf" style="border-bottom: 0px;border-top: 0px;">
				<td height="5" style="border-bottom: 0px;border-right: 0px;border-top: 0px;">paaClaa Jmaa</td>
				<td height="5" style="border-left: 0px;border-bottom: 0px;border-right: 0px;border-top: 0px;" colspan="2"><?php echo $value['last_paid_amount'] ?>#.&nbsp;taa. <?php echo $value['last_paid_date']?></td>
				<td height="5" style="border-bottom: 0px;border-top: 0px;">maJurI</td>
				<td height="5" style="border-bottom: 0px;border-top: 0px;"><?php echo $value['wage'] ?></td>
			</tr>
			<tr class="sf" style="border-bottom: 0px;border-top: 0px;">
				<td height="5" style="border-bottom: 0px;border-right: 0px;border-top: 0px;">kula baakI</td>
				<td height="5" style="border-left: 0px;border-bottom: 0px;border-right: 0px;border-top: 0px;" colspan="2"><?php echo number_format((float)$total + $value['caret_total'] + $value['o_e'] + $value['wage'] + $value['com'] + $value['pending'],2,'.','') ?></td>
				<td height="5" style="border-bottom: 0px;border-top: 0px;">kimaSana</td>
				<td height="5" style="border-bottom: 0px;border-top: 0px;"><?php echo $value['com'] ?></td>
			</tr>
			<tr class="sf">
			<td style="border-right: 0px;border-top: 0px;">koroT baakI&nbsp;&nbsp;&nbsp;<?php echo $value['caret']?></td>
				<td style="border-right: 0px;border-top: 0px;border-left: 0px;">koroT TaoTla</td>
				<td style="border-right: 0px;border-top: 0px;border-left: 0px;"><?php echo $value['caret_total']?></td>
				<td height="5" style="border-top: 0px;">naoT TaoTla</td>
				<td height="5" style="border-top: 0px;"><?php echo $total + $value['caret_total'] + $value['o_e'] + $value['com'] + $value['wage'] ?></td>
			</tr>
			<tr>
				<td height="5" style="font-size: 10px;font-family: 'Times New Roman', Times, serif;border-bottom:0px;" colspan="5">Jurisdiction to Bhuj Court</td>
			</tr>
			<tr>
				<td height="5" style="font-size: 10px;font-family: 'Times New Roman', Times, serif; border-top:0px;" colspan="5">Designed and developed by Vatsal Gor: 9408203201</td>
			</tr>
		</table>
		<?php 
		// unset($_SESSION['data']);
		// print_r($_SESSION['msg_response']);
	}?>
</div>
</center>
	<script type="text/javascript" src="../js/printThis.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			var msg = <?php echo $_SESSION['msg_response'] ?>;
			var prompt = msg['text'] + " Do you want to see the details of messages?";
			if(confirm(prompt)){
				alert("See Console for details. Press F12 to open console.");
				for(var i = 0; i<msg['count']; i++){
					console.log('Contact: ' + msg[i]['contact'] + 'Error Message: '+ msg[i]['message']);
				}
			}else{
				window.print();
			}
		})
	</script>
</body>
</html>