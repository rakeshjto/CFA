<style type="text/css">
/*input[type=text], input[type=password] {
 width: 100%;
padding: 12px 20px;
margin: 8px 0;
display: inline-block;
border: 1px solid #ccc;
box-sizing: border-box;
}*/
/* Set a style for all buttons */
button[type="submit"] {
	background-color: #4CAF50;
	color: white;
	padding: 14px 20px;
	margin: 8px 0;
	border: none;
	cursor: pointer;
	width: 100%;
}
/* Center the image and position the close button */
.imgcontainer {
	text-align: center;
	margin: 24px 0 12px 0;
	position: relative;
}

img.avatar {
	border-radius: 50%;
}

.container {
	padding: 16px;
}

span.psw {
	float: right;
	padding-top: 16px;
}

</style>
<div class="container">
<?php include 'reports_navbar.php';?>
<div class="row">
<div class="col-lg-12">
<h3 class="title"><?php echo $title; ?></h3>
<marquee>
<a href="#" ><button type="button" class="btn btn-danger"> <span class="glyphicon glyphicon-asterisk"></span><span class="glyphicon glyphicon-asterisk"></span><span class="glyphicon glyphicon-asterisk"></span> <span class="label label-info">Note:</span>Provisions under  LL Plan-49 are taken into account as usual. However provisions under BBG RUSOF 99, BBG RUSOF 150 plans will not be considered from FEB-2018 for deciding Best TT/JTO <span class="glyphicon glyphicon-asterisk"></span><span class="glyphicon glyphicon-asterisk"></span><span class="glyphicon glyphicon-asterisk"></span></button></a><br>
<!--<a href="#" ><button type="button" class="btn btn-primary"> <span class="glyphicon glyphicon-asterisk"></span><span class="glyphicon glyphicon-asterisk"></span><span class="glyphicon glyphicon-asterisk"></span> <span class="label label-info">Note1:</span>Orders completed with in 15 days can be entered Now.<span class="glyphicon glyphicon-asterisk"></span><span class="glyphicon glyphicon-asterisk"></span><span class="glyphicon glyphicon-asterisk"></span></button></a><br>
<a href="#" ><button type="button" class="btn btn-primary"> <span class="glyphicon glyphicon-asterisk"></span><span class="glyphicon glyphicon-asterisk"></span><span class="glyphicon glyphicon-asterisk"></span> <span class="label label-info">Note1:</span>Provisions are to be entered with in 5 days of completion of the Order.<span class="glyphicon glyphicon-asterisk"></span><span class="glyphicon glyphicon-asterisk"></span><span class="glyphicon glyphicon-asterisk"></span></button></a><br>
<a href="#" ><button type="button" class="btn btn-success"> <span class="glyphicon glyphicon-asterisk"></span><span class="glyphicon glyphicon-asterisk"></span><span class="glyphicon glyphicon-asterisk"></span> <span class="label label-danger">Note1:</span>Reconnections from Disconnection Due to NP are allowed to enter with in 5 days of completion of RC Order<span class="glyphicon glyphicon-asterisk"></span><span class="glyphicon glyphicon-asterisk"></span><span class="glyphicon glyphicon-asterisk"></span></button></a><br>
<a href="#" ><button type="button" class="btn btn-danger"> <span class="glyphicon glyphicon-asterisk"></span><span class="glyphicon glyphicon-asterisk"></span><span class="glyphicon glyphicon-asterisk"></span> <span class="label label-success">Note2:</span>Reconnections from Voluntary Closure are allowed only after 30 days of Closure and to be entered with in 5 days of completion of RC Order<span class="glyphicon glyphicon-asterisk"></span><span class="glyphicon glyphicon-asterisk"></span><span class="glyphicon glyphicon-asterisk"></span></button></a><br>-->
<br>

</marquee>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<div id="response"></div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<form class="form-horizontal" role="form" method="post" action="<?php echo base_url(); ?>Best_tm_jto/dologin">
			<div class="container">
				<div class="imgcontainer">
     		 	<i class="fa fa-user-circle fa-5x"></i> 
    			</div>
				
				
				<div class="form-group">
					<label class="control-label col-sm-offset-3 col-sm-3 col-md-offset-2 col-md-2 col-lg-offset-2 col-lg-2" for="username"><i class="fa fa-user"></i>Username:</label>
					<div class="col-xs-5 col-sm-5 col-md-4 col-lg-4">
						<input type="text" class="form-control" id="username" name="username" placeholder="Enter your Clarity Userid Eg: B200701420" >
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-offset-3 col-sm-3 col-md-offset-2 col-md-2 col-lg-offset-2 col-lg-2" for="password"><i class="fa fa-eye"></i>Password:</label>
					<div class="col-xs-5 col-sm-5 col-md-4 col-lg-4"> 
						<input type="password" class="form-control" id="password" name="password" placeholder="Edak password">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-offset-3 col-sm-3 col-md-offset-2 col-md-2 col-lg-offset-2 col-lg-2" for="designation"><i class="fa fa-sitemap"></i>Designation:</label>
					<div class="col-xs-5 col-sm-5 col-md-4 col-lg-4"> 
						  <select class="form-control" id="designation" name="designation">
							    <option value='LEV1_JTO_SDE_ID'>JTO</option>
							    <option value='LEV2_SDE_DE_ID'>SDE</option>
							    <option value='LEV3_SDE_DE_ID'>DE</option>
							  </select>
					</div>
				</div>
				<div class="form-group"> 
					<div class="col-sm-offset-3 col-sm-3 col-md-offset-2 col-md-2 col-lg-offset-4 col-lg-4">
						<button type="submit" class="btn btn-default btn-primary" id="loginBtn">Login</button>
					</div>
				</div>
				</div>
			</form>
		</div>
	</div>
</div>
