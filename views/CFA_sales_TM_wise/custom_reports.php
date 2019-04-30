 <?php
 	echo '<div class="container">';
 	
 	echo '<div class="page-header">
    <h3>' .$designation. ' wise Provisions Report for the month of ' .$monyy. '</h3></div>';
 	$sn=1;
 	echo '<div class="table-responsive">';
 	echo "<table id='rep_table' class='rep_table table-condensed table-bordered table-striped centered' style='margin:auto'>";
 	echo '<thead>';
 	echo "<tr>";
 	echo "<th>Name</th>";
 	echo "<th>HR No</th>";
 	if ($designation == 'TM'){ echo "<th>Exchange</th>";}
 	else if ($designation == 'JTO'){ echo "<th>Designation</th>";}
 	echo "<th>SDCA</th>";
 	echo "<th>LL Points</th>";
 	echo "<th>BB Points</th>";
 	echo "<th>FTTH Points</th>";
 	echo "<th>Total</th>";
 	echo "</tr>";
 	echo '</thead>';
 	
 	$sn=1;
 	$tot_llprov= 0;
 	$tot_bbprov= 0;
 	$tot_ftthprov= 0;
 	$tot_prov = 0;
 	
 	foreach($result as $data)
 	{
 		echo "<tr>";
 		echo "<td>" . $data['EMP_NAME']. "</td>";
 		echo "<td>" . $data['HR_NO']. "</td>";
 		if ($designation == 'TM'){ echo "<td>" . $data['EXCH_CODE']. "</td>";}
 		else if ($designation == 'JTO'){ echo "<td>" . $data['JTO']. "</td>";}
 		echo "<td>" . $data['STATION_CODE']. "</td>";
 		$LLPROV= $data['LL5']+$data['LL10'];
 		$BBPROV= $data['BB5']+$data['BB10'];
 		$FTTHPROV= $data['FTTH5']+$data['FTTH10'];
 		echo "<td><a href='" .base_url(). "CFA_sales_TM_wise/prov_details/" .$designation. "/" .$data['HR_NO']. "/LLPROV/" .$monyy. "' target='_blank'>" . $LLPROV. "</a></td>";
 		echo "<td><a href='" .base_url(). "CFA_sales_TM_wise/prov_details/" .$designation. "/" .$data['HR_NO']. "/BBPROV/" .$monyy. "' target='_blank'>" . $BBPROV. "</a></td>";
 		echo "<td><a href='" .base_url(). "CFA_sales_TM_wise/prov_details/" .$designation. "/" .$data['HR_NO']. "/FTTHPROV/" .$monyy. "' target='_blank'>" .$FTTHPROV. "</a></td>";
 	
 		$total= $LLPROV+ $BBPROV + $FTTHPROV;
 		echo "<td>" .$total. "</td>";
 		echo "</tr>";
 	}
 	
 	echo "</table>";
 	echo '</div>';
 	
 	echo "</div>";



?>

