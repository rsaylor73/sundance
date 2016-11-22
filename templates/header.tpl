{literal}
<!DOCTYPE html>
<html lang="en">

<head>
  
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
            
            
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="HandheldFriendly" content="true">
        
    <title>Sundance</title>
            
    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
            
    <!-- Custom Fonts -->
    <link href="css/logo-nav.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        
    <!-- jQuery -->
    <!--<script src="js/jquery.min.js"></script>-->

   <script src="jquery-ui-1.10.3/jquery-1.9.1.js"></script>
   <script src="js/bootstrap.js"></script>
   <link rel="stylesheet" href="jquery-ui-1.10.3/themes/base/jquery.ui.all.css">
   <script src="jquery-ui-1.10.3/ui/jquery.ui.core.js"></script>
   <script src="jquery-ui-1.10.3/ui/jquery.ui.widget.js"></script>
   <script src="jquery-ui-1.10.3/ui/jquery.ui.datepicker.js"></script>
   <script src="jquery-ui-1.10.3/ui/jquery.ui.menu.js"></script>
   <script src="jquery-ui-1.10.3/ui/jquery.ui.autocomplete.js"></script>
   <script src="jquery-ui-1.10.3/ui/jquery.ui.dialog.js"></script>
   <script src='https://www.google.com/recaptcha/api.js'></script>
          
          
  <script type="text/javascript" src="js/jquery.timepicker.js"></script>
  <link rel="stylesheet" type="text/css" href="css/jquery.timepicker.css" />
  <script type="text/javascript" src="js/tinymce/tinymce.min.js"></script>
  <script type="text/javascript" src="js/plugin.js"></script>

   <script>
   $(function() {
      $( "#date1" ).datepicker({ 
         dateFormat: "yy-mm-dd",
         changeMonth: true,
         changeYear: true,
         minDate: "-99M", 
         maxDate: "-1D"
      });
      $( "#date2" ).datepicker({ 
         dateFormat: "yy/mm/dd",
         changeMonth: true,
         changeYear: true,
         minDate: "-99M", 
         maxDate: "-1D"
      });
      $( "#schedule_date" ).datepicker({ 
         dateFormat: "yy-mm-dd",
         changeMonth: true,
         changeYear: true,
         minDate: '0',
         maxDate: '+1M'
         
      });

   });
   </script>

</head>
{/literal}

<body>

    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">
                    <img src="images/logo/sundance/final1_horizontal2.jpg" alt="">
                </a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">

                    {if $logo ne ""}
			<li>
                        <img src="{$logo}" alt="">
			</li>
                    {/if}
                    <li>
                        <a href="index.php">Home</a>
                    </li>

		{if $userType eq 'Employer'}
			{if $logged eq 'yes'}
				<li><a href="?section=employees">Employees</a></li>
				<li><a href="?section=profile">Profile</a></li>
				<li><a href="?section=logout">Logout</a></li>
			{/if}
		{/if}

		{if $userType eq 'Admin'}
			{if $logged eq 'yes'}
				<li><a href="?section=users">Employer Users</a></li>
				<li><a href="?section=admins">Admin Users</a></li>
                                <li><a href="?section=profilea">Profile</a></li>
                                <li><a href="?section=logout">Logout</a></li>
			{/if}
		{/if}

		{if $userType eq 'Employee'}
			{if $logged eq 'yes'}
				<li><a href="employee.php">Employee Home</a></li>
				<li><a href="employee.php?section=logout">Logout</a></li>
			{/if}
		{/if}

		{if $logged ne 'yes'}
			<li><a href="employee.php">Employee Login</a></li>
			<li><a href="employer.php">Employers Login</a></li>
			<li><a href="admin.php">Admin Login</a></li>
		{/if}


                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>


    <!-- Page Content -->
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
