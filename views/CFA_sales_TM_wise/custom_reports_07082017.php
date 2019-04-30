<?php

echo '<div class="container">';
echo '<div class="page-header">
    <h3>' .$designation. ' wise Provisions Report</h3></div>';
$sn=1;
echo '<div class="table-responsive">';
echo "<table id='rep_table' class='rep_table table-condensed table-bordered table-striped centered' style='margin:auto'>";
echo '<thead>';
echo "<tr>";
echo "<th>Name</th>";
echo "<th>HR No</th>";
if ($designation == 'TM'){ echo "<th>Exchange</th>";}
else if ($designation == 'JTO'){ echo "<th>Designation</th>";}
echo "<th>LL Points</th>";
echo "<th>BB Points</th>";
echo "<th>FollowOn BB Points</th>";
echo "<th>Total</th>";
echo "</tr>";
echo '</thead>';

$sn=1;
$tot_llprov= 0;
$tot_bbprov= 0;
$tot_llbbprov= 0;
$tot_prov = 0;

foreach($result as $data)
{
	echo "<tr>";
	echo "<td>" . $data['EMP_NAME']. "</td>";
	echo "<td>" . $data['HR_NO']. "</td>";
	if ($designation == 'TM'){ echo "<td>" . $data['EXCH_CODE']. "</td>";}
	else if ($designation == 'JTO'){ echo "<td>" . $data['JTO']. "</td>";}
	$LLPROV= $data['LLPROV']*5;
	$BBPROV= $data['BBPROV']*10;
	$LLBBPROV= $data['LLBBPROV']*10;
	echo "<td><a href='" .base_url(). "CFA_sales_TM_wise/prov_details/" .$designation. "/" .$data['HR_NO']. "/LLPROV' target='_blank'>" . $LLPROV. "</a></td>";
	echo "<td><a href='" .base_url(). "CFA_sales_TM_wise/prov_details/" .$designation. "/" .$data['HR_NO']. "/BBPROV' target='_blank'>" . $BBPROV. "</a></td>";
	echo "<td><a href='" .base_url(). "CFA_sales_TM_wise/prov_details/" .$designation. "/" .$data['HR_NO']. "/LLBBPROV' target='_blank'>" .$LLBBPROV. "</a></td>";
	
	$total= $LLPROV+ $BBPROV + $LLBBPROV;
		echo "<td>" .$total. "</td>";
	echo "</tr>";
}

echo "</table>";
echo '</div>';
echo "</div>";

?>

