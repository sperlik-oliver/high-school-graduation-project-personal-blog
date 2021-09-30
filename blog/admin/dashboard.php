<?php  include('../config.php'); ?>
	<?php include(ROOT_PATH . '/admin/includes/admin_functions.php'); ?>
	<?php include(ROOT_PATH . '/admin/includes/head_section.php'); ?>

	
<?php if(isset($_SESSION['user'])){ ?>
<?php if ($_SESSION['user']['role'] == 'Admin' || $_SESSION['user']['role'] == 'Author'){ ?>


	<title>Admin | Dashboard</title>
</head>
<body>
	<div class="header">
			<a href="<?php 'dashboard.php' ?>">
			Admin
			</a>
		</div>
		<?php if (isset($_SESSION['user'])): ?>
			<div class="userinfo">
				<span><?php echo "Welcome <b>" . $_SESSION['user']['username'] . "</b>"?></span> &nbsp; &nbsp;
				<a href="<?php echo '../logout.php'; ?>" class="logout-btn">Logout</a>
				<a href="<?php echo '../index.php'; ?>" class="home-btn">Home Page</a>
			</div>
		<?php endif ?>




		<div class="buttons">
			<a href="users.php">Users</a>
			<a href="posts.php">Posts</a>
			<a href="topics.php">Topics</a>
			<a href="images.php">Images</a>
		</div>

</body>
</html>


<?php }else{ ?>
	Missing permission
<?php } ?>
		<?php }else{ ?>
			Missing permission

		<?php } ?>
