<?php 
	include '../database/Database.php';
	$db = new Database();
	$conn = $db->connect();
	$date = date('Y-m-d',strtotime($_POST['date']));
	$sql = "select party.p_name, date, caret, caret*settings.value as total from caret join party on party.p_id=caret.party join settings where settings.type='rs' and date='$date' order by party.p_name DESC";
	$res = $conn->query($sql);
	while ($row = $res->fetch_assoc()) {
		?>
		<tr>
			<th class="guj"><?php echo $row['p_name'] ?></th>
			<th class="guj"><?php echo date('d.m.Y',strtotime($row['date'])) ?></th>
			<th><?php echo $row['caret'] ?></th>
			<th><?php echo $row['total'] ?></th>

		</tr>
		<?php
	}
?>