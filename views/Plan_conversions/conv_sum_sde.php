<div class="container">
<?php include 'navbar.php';
$conv1 = (($conv_type == 'l2h') ? "LOWER_PLAN" : "HIGHER_PLAN");
$conv2 = (($conv_type == 'h2l') ? "LOWER_PLAN" : "HIGHER_PLAN");
?>

	<table id="datatable" class="table table-bordered table-striped  table-hover table-sm table-success">
				<thead>
				  <tr>
					<th>SNo</th>
					<?php
					echo "<th>" .$conv1 ."</th>";
					echo "<th>" .$conv2 ."</th>";
					?>
					<th>TOTAL</th>					
				  </tr>
				</thead>
				<tbody>
				  <?php
					 $sn=1;
					 foreach($conv_sum_sde as $data)
						{
							$data_conv1 = (($conv_type == 'l2h') ? $data['LOWER_PLAN'] : $data['HIGHER_PLAN']);
							$data_conv2 = (($conv_type == 'h2l') ? $data['LOWER_PLAN'] : $data['HIGHER_PLAN']);
							echo "<tr>";
							echo "<td>" . $sn. "</td>";
							echo "<td>" . $data_conv1. "</td>";
							echo "<td>" . $data_conv2. "</td>";
							echo "<td>" . $data['CNT']. "</td>";
							echo "</tr>";
							$sn++;
						}
				  ?>
				</tbody>
	</table>
</div> 



