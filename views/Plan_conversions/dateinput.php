<div class="container">
<?php include 'navbar.php';?>


 <form  class="form-horizontal" target="_blank" method="post" id="ipform" action="Plan_conversions/summary">
		
		<div class="form-group">
		<label class="control-label col-sm-2" for="fdate">Select From Date :</label>
		<div class="col-sm-8">
		<input class="picker form-control" id="fdate" name="fdate" type="text"/>
		</div>
		</div>
		
		<div class="form-group">
		<label class="control-label col-sm-2" for="tdate">Select To Date :</label>
		<div class="col-sm-8">
		<input class="picker form-control" id="tdate" name="tdate" type="text"/>
		</div>
		</div>
		
		<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
		<input type="submit" id="formsubmit" class="btn btn-success" name="formsubmit" value="Submit" />
		</div>
		</div>
 </form>
</div>
        