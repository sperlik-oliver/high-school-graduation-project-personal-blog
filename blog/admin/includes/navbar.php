<div class="header">
		<a href="<?php echo 'dashboard.php' ?>">
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
