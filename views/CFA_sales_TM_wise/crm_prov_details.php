<?php
echo '<div class="container">';

echo '<div class="page-header">
    <h3>Provisions Report</h3></div>';

echo '<div class="table-responsive">';
echo "<table id='rep_table' class='rep_table table-condensed table-bordered table-striped centered' style='margin:auto'>";
echo '<thead>';
echo "<tr>";
echo "<th>SNo</th>";
echo "<th>EXCHANGE_CODE</th>";
echo "<th>PHONE_NO</th>";
echo "<th>ORDER_NO</th>";
echo "<th>ORDER_COMP_DATE</th>";
echo "<th>ORDER_STATUS</th>";
echo "<th>CUSTOMER_NAME</th>";
echo "<th>MOBILE_NO</th>";
echo "<th>CHANNEL</th>";
echo "<th>HRMS_ID</th>";
echo "</tr>";
echo '</thead>';

$sn=1;
foreach($result as $data)
{
	echo "<tr>";
	echo "<td>" . $sn. "</td>";
	echo "<td>" . $data['EXCHANGE_CODE']. "</td>";
	echo "<td>" . $data['PHONE_NO']. "</td>";
	echo "<td>" . $data['ORDER_NO']. "</td>";
	echo "<td>" . $data['ORDER_COMP_DATE']. "</td>";
	echo "<td>" . $data['ORDER_STATUS']. "</td>";
	echo "<td>" . $data['CUSTOMER_NAME']. "</td>";
	echo "<td>" . $data['MOBILE_NO']. "</td>";
	echo "<td>" . $data['CHANNEL']. "</td>";
	echo "<td>" . $data['HRMS_ID']. "</td>";
	
	echo "</tr>";
	$sn++;
}

echo "</table>";
echo '</div>';

echo "</div>";

?>

