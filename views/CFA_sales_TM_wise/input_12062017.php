<?php
echo '<div class="container-fluid">';
$user= $this->session->userdata('username');
$designation= $this->session->userdata('designation');
?>
<div class="row">
<br>
<div class="col-md-4 text-center pull-right">
<div class="btn-group ">
<!-- <a href="<?php// echo base_url(); ?>Account/password" class="btn btn-primary"><i class="fa fa-sign-out"></i>Change Password</a> -->
			<a href="<?php echo base_url(); ?>Best_tm_jto/dologout" class="btn btn-success"><i class="fa fa-sign-out"></i>Logout</a>
			</div>							
		</div>
	</div>
<?php	
echo '<div class="page-header">
    <h2 class="bg-primary">Selection of Best TT & Best JTO</h2>
    <h4 class="bg-info">Provisions for the month of May-2017 under the control of ' .$user. ','.$designation. '</h4></div>
		<ul class="nav nav-tabs">
			<li class="active"><a data-toggle="tab" href="#llprov"> <button type="button" class="btn btn-primary"> LL Provisions<span class="badge">5 Points</span></button></a></li>
			<li><a data-toggle="tab" href="#bbrpov" > <button type="button" class="btn btn-success"> BB Provisions<span class="badge">10 Points</span></button></a></li>
			<li><a data-toggle="tab" href="#llbbrpov"> <button type="button" class="btn btn-danger">FollowOn BB Provisions<span class="badge">10 Points</span></button></a></li>
		</ul>';

/*echo '<div class="tab-content">
<div id="llprov" class="tab-pane fade in active">
    		
    		</div>
<div id="bbprov" class="tab-pane fade">
    		<p>ssfsf</p>
    		</div>
<div id="llbbprov" class="tab-pane fade">
    		<p>adad</p>
    		</div>
 </div>';*/

echo "<table class='table table-striped' border='1'>";
echo '<thead>';
echo "<tr>";
echo "<th>SNo</th>";
echo "<th>PHONE_NO</th>";
echo "<th>ORDER_NO</th>";
echo "<th>EXCHANGE<br>CODE</th>";
//echo "<th>ORDER<br>TYPE</th>";
echo "<th>ORDER<br>SUB_TYPE</th>";
echo "<th>ORDER<br>COMP_DATE</th>";
echo "<th>Section TT</th>";
echo "<th>Section TT Name</th>";
echo "<th>CRM CHANNEL</th>";
echo "<th>ACTUAL CHANNEL</th>";
echo "<th>TT HR NUMBER</th>";
echo "<th>Submit Data</th>";
echo "</tr>";
echo '</thead>';
$sn=1;
foreach($provisions as $data)
{
	echo "<tr>";
	echo "<td>" .$sn. "</td>";
	echo "<td>" .$data['PHONE_NO']. "</td>";
	echo "<td>" .$data['ORDER_NO']. "</td>";
	echo "<td>" .$data['EXCHANGE_CODE']. "</td>";
	//echo "<td>" .$data['ORDER_TYPE']. "</td>";
	echo "<td>" .$data['ORDER_SUB_TYPE']. "</td>";
	echo "<td>" .$data['ORDER_COMP_DATE']. "</td>";
	echo "<td>" .$data['LINEMAN_USERID']. "</td>";
	echo "<td>" .$data['LINEMAN_NAME']. "</td>";
	echo "<td>" .$data['CHANNEL']. "</td>";
	echo "<td><select>
		<option value=''>Select a Channel</option>				
		<option value='BSNLEMP'>BSNL Employee</option>
						<option value='CC'>Call Center</option>
						<option value='IVRS'>IVRS</option>
						<option value='Franchisee'>Franchisee</option>
						<option value='Internet'>Internet</option>
						<option value='WalkIn'>Walk-In</option>
					  </select></td>";
	echo "<td><input type='text' class='form-control' readonly></input></td>";
	echo "<td><button type='submit' class='btn btn-primary'>Submit</button></td>";
	echo "</tr>";
	$sn++;
}

echo "</table>";
echo "</div>";
?>
