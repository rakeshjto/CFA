<div class="container">
<?php include 'navbar.php';?>
<table id="datatable" class="table table-bordered table-striped  table-hover table-sm table-success">
				<thead>
				  <tr>
					<th>SNo</th>
					<th>PLAN NAME</th>
					<th>TOTAL</th>				
				  </tr>
				</thead>
				<tbody>
				  <?php
					 $sn=1;
					 foreach($plan_sum_sde as $data)
						{
							echo "<tr>";
							echo "<td>" . $sn. "</td>";
							echo "<td>" . $data['PLAN']. "</td>";
							echo "<td>" . $data['CNT']. "</td>";
							echo "</tr>";
							$sn++;
						}
				  ?>
				</tbody>
	</table>
</div> 



