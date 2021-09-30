<?php  include('config.php'); ?>
<!-- Source code for handling registration and login -->
<?php  include( ROOT_PATH . '/includes/registration_login.php'); ?>
<?php  include('includes/head.php'); ?>
	<title>LifeBlog | Sign in </title>
</head>
<body>
	<!-- Login Form Page -->
	<!-- Navbar -->
	<?php include( ROOT_PATH . '/includes/navbar.php'); ?>



	<div class="container">
     <div class="row">
       <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
         <div class="card card-signin my-5 text-align">
           <div class="card-body">
             <h5 class="card-title text-center">Sign In</h5>

             <form class="form-signin" method="post" action="login.php">
							  		<?php include(ROOT_PATH . '/includes/errors.php') ?>
               <div class="form-label-group">
                 <input type="text" id="inputUsername" class="form-control" placeholder="username" value="<?php echo $username; ?>" name="username"  required autofocus>

               </div>
</br>
               <div class="form-label-group">
                 <input type="password" id="inputPassword" class="form-control" placeholder="password" name="password" required>

               </div>

        </br>
               <button class="btn btn-lg btn-primary btn-block text-uppercase button-margin" type="submit" name="login_btn">Sign in</button>

						Don't have an account yet? <a href="register.php">Register now</a>
               <hr class="my-4">

           </div>
         </div>
       </div>
     </div>
   </div>

<!-- // container -->

<!-- Footer -->
	<?php include( ROOT_PATH . '/includes/footer.php'); ?>

