<?php
include 'navbar.php';
echo '<div class="container">';
$user= $this->session->userdata('username');
$designation= $this->session->userdata('designation');

if($designation == 'LEV1_JTO_SDE_ID'){
	$sub_staff_designation= "LINEMAN_USERID";
	$sub_staff_cadre= "TM";
}
else if($designation == 'LEV2_SDE_DE_ID'){
	$sub_staff_designation= "LEV1_JTO_SDE_ID";
	$sub_staff_cadre= "JTO";
}
else if($designation == 'LEV3_SDE_DE_ID'){
	//$sub_staff_designation= "LEV2_SDE_DE_ID";
	$sub_staff_cadre= "SDE";
}

echo '<div class="page-header">
    <h3>Provisions Report under the control of ' .$user. ','.$designation. '</h3></div>';
$sn=1;
echo '<div class="table-responsive">';
echo "<table id='rep_table' class='rep_table table table-condensed table-bordered table-striped centered' style='margin:auto'>";
echo '<thead>';
echo "<tr>";
echo "<th>" .$sub_staff_designation. "</th>";
echo "<th>Name</th>";
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
$this->load->model('CFA_sales_TM_wise_model', 'btj');
foreach($subOrdinates as $data)
{
	echo "<tr>";
	echo "<td>" . $data['SUB_STAFF']. "</td>";
	echo "<td>" . $data['EMP_NAME']. "</td>";
	$reports = $this->btj->get_reports($data['SUB_STAFF'],$sub_staff_designation);
	
	$LLPROV= ($reports->LLPROV)*5;
	$BBPROV= ($reports->BBPROV)*10;
	$LLBBPROV= ($reports->LLBBPROV)*10;
	
		echo "<td><a href='" .base_url(). "CFA_sales_TM_wise/prov_details/" .$sub_staff_cadre. "/" .$data['SUB_STAFF']. "/LLPROV' target='_blank'>" . $LLPROV. "</td>";
		echo "<td><a href='" .base_url(). "CFA_sales_TM_wise/prov_details/" .$sub_staff_cadre. "/" .$data['SUB_STAFF']. "/BBPROV' target='_blank'>" . $BBPROV. "</td>";
		echo "<td><a href='" .base_url(). "CFA_sales_TM_wise/prov_details/" .$sub_staff_cadre. "/" .$data['SUB_STAFF']. "/LLBBPROV' target='_blank'>" .$LLBBPROV. "</td>";
		$total= $LLPROV+ $BBPROV + $LLBBPROV;
		echo "<td>" .$total. "</td>";
	echo "</tr>";
	$tot_llprov= $tot_llprov+ $LLPROV;
	$tot_bbprov= $tot_bbprov+ $BBPROV;
	$tot_llbbprov= $tot_llbbprov+ $LLBBPROV;
	$tot_prov= $tot_prov + $total;
}

echo '<tfoot>';
echo "<tr>";
echo "<th colspan='2'>Total</th>";
echo "<th>" .$tot_llprov. "</th>";
echo "<th>" .$tot_bbprov. "</th>";
echo "<th>" .$tot_llbbprov. "</th>";
echo "<th>" .$tot_prov. "</th>";
echo "</tr>";
echo '</tfoot>';


echo "</table>";
echo '</div>';

echo "</div>";

?>

