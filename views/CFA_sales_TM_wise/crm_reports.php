<?php
echo '<div class="container">';

echo '<div class="page-header">
    <h3>Provisions Report from CRM ORDERS</h3></div>';
$sn=1;
echo '<div class="table-responsive">';
echo "<table id='rep_table' class='rep_table table-condensed table-bordered table-striped centered' style='margin:auto'>";
echo '<thead>';
echo "<tr>";
echo "<th>Name</th>";
echo "<th>HR No</th>";
echo "<th>Designation</th>";
echo "<th>Exchange</th>";
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
	echo "<td>" . $data['DESIGNATION']. "</td>";
	echo "<td>" . $data['LOCATION']. "</td>";
	$LLPROV= $data['LLPROV'];
	$BBPROV= $data['BBPROV'];
	$LLBBPROV= $data['LLBBPROV'];
	echo "<td><a href='" .base_url(). "CFA_sales_TM_wise/crm_prov_details/" .$data['HR_NO']. "/LLPROV' target='_blank'>" . $LLPROV. "</a></td>";
	echo "<td><a href='" .base_url(). "CFA_sales_TM_wise/crm_prov_details/" .$data['HR_NO']. "/BBPROV' target='_blank'>" . $BBPROV. "</a></td>";
	echo "<td><a href='" .base_url(). "CFA_sales_TM_wise/crm_prov_details/" .$data['HR_NO']. "/LLBBPROV' target='_blank'>" .$LLBBPROV. "</a></td>";
	
	$total= $LLPROV+ $BBPROV + $LLBBPROV;
		echo "<td>" .$total. "</td>";
	echo "</tr>";
}

echo "</table>";
echo '</div>';

echo "</div>";

?>

