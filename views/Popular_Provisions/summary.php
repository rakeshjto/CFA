<div class="container">
<?php include 'navbar.php';?>
	<div class="row">
      <div class="col-sm">
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
					$fdate=$fdate;
					$tdate=$tdate;
					 $sn=1;
					 foreach($popular_provisions as $data)
						{
							echo "<tr>";
							echo "<td>" . $sn. "</td>";
							echo "<td><a href='" .base_url(). "Popular_Provisions/plan_sum_sde/" .$data['SDE']. "/" .$fdate. "/" .$tdate. "' target='_blank'>" . $data['SDE']. "</td>";
							echo "<td><a href='" .base_url(). "Popular_Provisions/plan_det/" .$data['SDE']. "/" .$fdate. "/" .$tdate. "' target='_blank'>" . $data['CNT']. "</td>";
							echo "</tr>";
							$sn++;
						}
				  ?>
				</tbody>
			</table>
	  </div>
      <div class="col-sm">
			
	  </div>
    </div>
</div> 

<!-- Implement Totals in Table-->




