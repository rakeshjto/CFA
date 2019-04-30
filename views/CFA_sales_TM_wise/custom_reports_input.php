<div class='container-fluid'>
<div class='row'>

	<h2 class='text-primary text-center' >Monthly Provision Reports of TT/JTO</h2>
		<div class="col-sm-6">
		<form method="post" action="<?php echo base_url(); ?>CFA_sales_TM_wise/custom_reports">
		<div class="form-group">
		<label for="monyy">Select Month:</label>
		<input type="text" class="form-control" id="monyy" name="monyy">
		</div>

		<div class="form-group">
		<label for="sel1">Select TT/JTO:</label>
		<select class="form-control" id="designation" name="designation">
		<option value=''>Select TT/JTO</option>
		<option value='TM'>TT</option>
		<option value='JTO'>JTO</option>
		</select>
		</div>
		<div class="col-sm-offset-4 col-sm-4">
		<input type="submit" class="btn-lg btn-primary" name="formsubmit" id="formsubmit" value="submit"/>
		</div>
		</form>
		</div>


</div>
</div>