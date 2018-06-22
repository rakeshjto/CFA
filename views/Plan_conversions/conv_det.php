<div class="container">
<?php include 'navbar.php';
$conv1 = (($conv_type == 'l2h') ? "LOWER_PLAN" : "HIGHER_PLAN");
$conv2 = (($conv_type == 'h2l') ? "LOWER_PLAN" : "HIGHER_PLAN");
?>
	
	<table id="datatable" class="table table-bordered table-striped  table-hover table-sm table-success table-responsive">
				<thead>
				  <tr>
					<th>SNo</th>
					<th>SDE</th>
					<th>STATION_CODE</th>
					<th>EXCHANGE_CODE</th>
					<?php 
					echo "<th>" .$conv1. "</th>";
					echo "<th>" .$conv2. "</th>";
					?>
					<th>PHONE_NO</th>
					<th>ORDER_NO</th>
					<th>ORDER_TYPE</th>
					<th>ORDER_SUB_TYPE</th>
					
				  </tr>
				</thead>
				<tbody>
				  <?php
					 $sn=1;
					 foreach($conv_det as $data)
						{
							$data_conv1 = (($conv_type == 'l2h') ? $data['LOWER_PLAN'] : $data['HIGHER_PLAN']);
							$data_conv2 = (($conv_type == 'h2l') ? $data['LOWER_PLAN'] : $data['HIGHER_PLAN']);
							echo "<tr>";
							echo "<td>" . $sn. "</td>";
							echo "<td>" . $data['SDE']. "</td>";
							echo "<td>" . $data['STATION_CODE']. "</td>";
							echo "<td>" . $data['EXCHANGE_CODE']. "</td>";
							echo "<td>" . $data_conv1. "</td>";
							echo "<td>" . $data_conv2. "</td>";
							echo "<td>" . $data['PHONE_NO']. "</td>";
							echo "<td>" . $data['ORDER_NO']. "</td>";
							echo "<td>" . $data['ORDER_TYPE']. "</td>";
							echo "<td>" . $data['ORDER_SUB_TYPE']. "</td>";
							
							
							echo "</tr>";
							$sn++;
						}
				  ?>
				</tbody>
			</table>
</div> 



