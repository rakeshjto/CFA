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
					$total=0;
					$fdate=$fdate;
					$tdate=$tdate;
					 $sn=1;
					 foreach($popular_provisions as $data)
						{
							$total = $total+ $data['CNT'];
							echo "<tr>";
							echo "<td>" . $sn. "</td>";
							echo "<td><a href='" .base_url(). "Popular_Provisions/plan_sum_sde/" .$data['SDE']. "/" .$fdate. "/" .$tdate. "' target='_blank'>" . $data['SDE']. "</td>";
							echo "<td><a href='" .base_url(). "Popular_Provisions/plan_det/" .$data['SDE']. "/" .$fdate. "/" .$tdate. "' target='_blank'>" . $data['CNT']. "</td>";
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
			<table id="datatable2" class="table table-bordered table-striped  table-hover table-sm table-success">
				<thead>
				  <tr>
					<th>SNo</th>
					<th>PLAN NAME</th>
					<th>Total</th>
				  </tr>
				</thead>
				<tbody>
				  <?php
					$total=0;
					$fdate=$fdate;
					$tdate=$tdate;
					 $sn=1;
					 foreach($get_groupby_plan as $data)
						{
							$total = $total+ $data['CNT'];
							echo "<tr>";
							echo "<td>" . $sn. "</td>";
							echo "<td><a href='#' target='_blank'>" . $data['PLAN']. "</td>";
							echo "<td><a href='#' target='_blank'>" . $data['CNT']. "</td>";
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

<!-- Implement Totals in Table-->




