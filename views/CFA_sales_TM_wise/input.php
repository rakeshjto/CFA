<?php
include 'navbar.php';
echo '<div class="container">';
$user= $this->session->userdata('username');
$designation= $this->session->userdata('designation');

echo '<div class="page-header">
    <h3>Provisions under the control of ' .$user. ','.$designation. '</h3></div>';
$sn=1;
echo '<div class="table-responsive">';
echo "<table class='table table-condensed table-bordered table-striped centered' style='margin:auto'>";
echo '<thead>';
echo "<tr>";
echo "<th>SNo</th>";
echo "<th>TT Name</th>";
echo "<th>TT HRNo</th>";
//echo "<th>TT WorkGroup</th>";
echo "<th>LL Provisions </th>";
echo "<th>BB  Provisions</th>";
echo "<th>FTTH  Provisions</th>";
echo "</tr>";
echo '</thead>';

$sn=1;
foreach($linemen as $data)
{
	echo "<tr>";
	echo "<td>" .$sn. "</td>";
	echo "<td>" .$data['LINEMAN_NAME']. "</td>";
	echo "<td>" . $data['LINEMAN_USERID']. "</td>";
	//echo "<td>" .$data['WORKGRP']. "</td>";
	
	echo '<td><div class="form-group">
	<select class="form-control" name="llprov" id="llprov">';
	for ($x = 0; $x < 10; $x++) {
		echo '<option>' .$x. '</option>';
	}
	echo '</select></div></td>';
	
	echo '<td><div class="form-group">
	<select class="form-control" name="bbprov" id="bbprov">';
      		for ($x = 0; $x < 10; $x++) { 
    		echo '<option>' .$x. '</option>';
		} 					
	echo '</select></div></td>';
	
	echo '<td><div class="form-group">
	<select class="form-control" name="ftthprov" id="ftthprov">';
	for ($x = 0; $x < 10; $x++) {
		echo '<option>' .$x. '</option>';
	}
	echo '</select></div></td>';
	
	echo "</tr>";
	$sn++;
}
echo "</table>";
echo '</div>';
echo '<div id="results"></div>';
echo '<form class="form-inline" >
		<div class="form-group"  id="prov_form"></div>
		
    	<input type="submit" class="btn btn-primary" id="SubmitBtn" value="Submit" disabled></input>
		</form>';
echo "</div>";


?>
