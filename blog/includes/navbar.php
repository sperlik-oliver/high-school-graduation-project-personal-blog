<?php require_once( ROOT_PATH . '/includes/public-functions.php') ?>
<?php	$topics = getAllTopics(); ?>







<nav class="navbar navbar-expand-md navbar-dark sticky-top background-color">
	<a class="navbar-brand" href="index.php">SportsNews</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar_collapse" aria-controls="navbar_collapse" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>

	<div class="collapse navbar-collapse" id="navbar_collapse">
			<ul class="navbar-nav mr-auto">

					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" id="dropdown_toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Articles</a>
						<div class="dropdown-menu" aria-labelledby="dropdown_toggle">
							<a class="dropdown-item" href="#"><b>All</b></a>
								<?php foreach ($topics as $topic): ?>
							<a class="dropdown-item" href="<?php echo './filtered_posts.php?topic=' . $topic['id'] ?>"><?php echo $topic['name']; ?></a>
									<?php endforeach ?>
													<li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>


						</div>
					</li>
      </ul>
</div>

	<div class="collapse navbar-collapse" id="navbar_collapse">

			<ul class="navbar-nav ml-auto">

				<?php if (isset($_SESSION['user']['username'])) { ?>
					<?php if ($_SESSION['user']['role'] == 'Admin' || $_SESSION['user']['role'] == 'Author'){ ?>
						<li class="nav-item"><a class="nav-link" href="./admin/dashboard.php"><b><?php echo  $_SESSION['user']['username']?></b></a></li>
					<?php }else{ ?>
					<li class="nav-item"><a class="nav-link" href="#"><b><?php echo  $_SESSION['user']['username']?></b></a></li>
					<?php } ?>
					<li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>



				<?php }else{ ?>
				  	<li class="nav-item"><a class="nav-link" href="login.php">Log In</a></li>
				   	<li class="nav-item" ><a class="nav-link" href="register.php">Sign Up</a></li>

				<?php } ?>


						</div>
					</li>
			</ul>
</div>
</nav>
