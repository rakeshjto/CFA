<style>
/* Add a dark background color with a little bit see-through */ 
.navbar {
    margin-bottom: 0;
    background-color: #2d2d30;
    border: 0;
    font-size: 11px !important;
    letter-spacing: 4px;
    opacity:0.9;
}

/* Add a gray color to all navbar links */
.navbar li a, .navbar .navbar-brand { 
    color: #d5d5d5 !important;
}

/* On hover, the links will turn white */
.navbar-nav li a:hover {
    color: #fff !important;
}

/* The active link */
.navbar-nav li.active a {
    color: #fff !important;
    background-color:#29292c !important;
}

/* Remove border color from the collapsible button */
.navbar-default .navbar-toggle {
    border-color: transparent;
}

/* Dropdown */
.open .dropdown-toggle {
    color: #fff ;
    background-color: #555 !important;
}

/* Dropdown links */
.dropdown-menu li a {
    color: #000 !important;
}

/* On hover, the dropdown links will turn red */
.dropdown-menu li a:hover {
    background-color: red !important;
}
</style>

<nav class="navbar navbar-default">
  <div class="container-fluid">
    
   
   <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <a class="navbar-brand" href="#"><img src="<?php echo base_url(); ?>assets/img/bsnlblue.png" class="img-thumbnail" alt="logo" width="115" height="40"></a>
    </div>
      
	 <div class="collapse navbar-collapse" id="myNavbar">	 
	 <ul class="nav navbar-nav">
		<li class="active"><a href="<?php echo base_url(); ?>CFA_sales_TM_wise/custom_reports_input" target="_blank">TT/JTO Wise Reports</a></li>
    </ul>
  </div>
</nav>
