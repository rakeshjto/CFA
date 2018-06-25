<div class="container">
<?php include 'navbar.php';?>
	<div class="row">
      <div class="col-sm">
			<h5>Lower-> Higher Plan Conversions</h5>
			<table id="datatable1" class="table table-bordered table-striped  table-hover table-sm table-success">
				<thead>
				  <tr>
					<th>SNo</th>
					<th>SDE</th>
					<th>Total</th>
				  </tr>
				</thead>
				<tbody>
				  <?php
					$total=0;
					$conv_type= "l2h";
					 $sn=1;
					 foreach($lower_planconversions as $data)
						{
							$total = $total+ $data['CNT'];
							echo "<tr>";
							echo "<td>" . $sn. "</td>";
							echo "<td><a href='" .base_url(). "Plan_conversions/conv_sum_sde/" .$data['SDE']. "/" .$fdate. "/" .$tdate. "/" .$conv_type. "' target='_blank'>" . $data['SDE']. "</td>";
							echo "<td><a href='" .base_url(). "Plan_conversions/conv_det/" .$data['SDE']. "/" .$fdate. "/" .$tdate. "/" .$conv_type. "' target='_blank'>" . $data['CNT']. "</td>";
							echo "</tr>";
							$sn++;
						}
				  ?>
				</tbody>
				
				<tfoot>
				  <tr>
					<th colspan="2">Total</th>
					<?php echo "<th>" .$total. "</th>";?>
				  </tr>
				</tfoot>
				
			</table>
	  </div>
      <div class="col-sm">
			<h5>Higher-> Lower Plan Conversions</h5>
			<table id="datatable2" class="table table-bordered table-striped  table-hover table-sm table-success">
				<thead>
				  <tr>
					<th>SNo</th>
					<th>SDE</th>
					<th>Total</th>
				  </tr>
				</thead>
				<tbody>
				  <?php
					$total=0;
					$conv_type= "h2l";	
					$sn=1;
					 foreach($higher_planconversions as $data)
						{
							$total = $total+ $data['CNT'];
							echo "<tr>";
							echo "<td>" . $sn. "</td>";
							echo "<td><a href='" .base_url(). "Plan_conversions/conv_sum_sde/" .$data['SDE']. "/" .$fdate. "/" .$tdate. "/" .$conv_type. "' target='_blank'>" . $data['SDE']. "</td>";
							echo "<td><a href='" .base_url(). "Plan_conversions/conv_det/" .$data['SDE']. "/" .$fdate. "/" .$tdate. "/" .$conv_type. "' target='_blank'>" . $data['CNT']. "</td>";
							echo "</tr>";
							$sn++;
						}
				  ?>
				</tbody>
				<tfoot>
				  <tr>
					<th colspan="2">Total</th>
					<?php echo "<th>" .$total. "</th>";?>
				  </tr>
				</tfoot>
			</table>
	  </div>
    </div>
</div> 






