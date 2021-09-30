<?php  include('config.php'); ?>
<?php  include('includes/public-functions.php'); ?>
<?php $activepoll = GetActivePoll(); ?>
<?php $activepollchoices = GetActivePollChoices(); ?>
<?php $usercheck =  PollUserCheck(); ?>
<?php $activepollanswers = PollAnswers(); ?>
<?php
	if (isset($_GET['post-slug'])) {
		$post = getPost($_GET['post-slug']);
	}
	$topics = getAllTopics();
?>
<?php  $post_id = $post['id']; ?>
<?php VisitCount($post_id); ?>
<?php UniqueVisitCount($post_id); ?>
<?php include('includes/head.php'); ?>
<title> <?php echo $post['title'] ?> | SportsNews</title>
</head>
<body>
<?php include(ROOT_PATH . '/includes/navbar.php') ?>


<!-- Page Content -->
	  <div class="container margin-bottom">

	    <div class="row">

	      <!-- Post Content Column -->
	      <div class="col-lg-8">

	        <!-- Title -->
	        <h1 class="mt-4"> <?php echo $post['title'] ?> </h1>

	        <!-- Author -->
	        <p class="lead">
	          by
	          <a href="#"> <?php echo GetUsernameById($post['user_id']); ?> </a>
	        </p>

	        <hr>

	        <!-- Date/Time -->
	        <p> Posted At <?php echo $post['created_at'] ?> </p>

	        <hr>

	        <!-- Preview Image -->
	 		 <img class="img-fluid rounded" src="<?php echo './static/images/' . $post['image']; ?>" alt="">

	        <hr>

	        <!-- Post Content -->


					<p><?php echo html_entity_decode($post['body']); ?></p>
<?php $post_id = $post['id'];	?>					

<i class="fa fa-star" data-index="0"></i>
<i class="fa fa-star" data-index="1"></i>
<i class="fa fa-star" data-index="2"></i>
<i class="fa fa-star" data-index="3"></i>
<i class="fa fa-star" data-index="4"></i>


</br>
<b><?php echo GetRatingByPostId($post_id); ?></br></b>
</br>

<?php $_SESSION['post_id'] = $post['id'];  ?>
	
<?php $comments = GetAllComments($post_id); ?>	   

<?php if(!empty($_SESSION['user']['id'])){ ?>			
	<form class="clearfix" action="single_post.php" method="post" id="comment_form">
		<textarea name="comment_text" id="comment_text" class="form-control" cols="30" rows="3"></textarea>
			<button class="btn btn-primary btn-sm pull-right" id="submit_comment">Submit comment</button>
		</form>
<?php }else{ ?>
		<div class="card"><h4>Please login to comment<h4></div>
		<?php } ?>	

<hr>
	
   


<hr>
	
<div id="comments-wrapper">
		<?php if (isset($comments)){ ?>
			<?php foreach ($comments as $comment): ?>
				<div class="comment clearfix">
					<div class="comment-details">
						<span class="comment-name"><?php echo getUsernameById($comment['user_id']) ?></span>
						<span class="comment-date"><?php echo date("F j, Y ", strtotime($comment["created_at"])); ?></span>
						<p><?php echo $comment['body']; ?></p>
						
					</div>
				</div>
			
	
			<?php endforeach ?>
			<?php }else{ ?>	
			<h2>Be the first to comment on this post</h2>
			<?php } ?>	
		

			
		


			</div>

			</div>

		
<script src="scripts.js"></script>
		<!-- Sidebar Widgets Column -->
		
	      <div class="col-md-4">

	

					<?php if (isset($_SESSION['user']['username'])){ ?>


								<?php     if(!empty($activepoll)){      ?>


											<?php     if(empty($usercheck)){      ?>
							<!-- Poll -->
										<div class="card my-4">

											<h5 class="card-header"><?php echo $activepoll['question']; ?></h5>
											<div class="card-body">
					<form action="vote.php" method="post">
					<?php 	foreach($activepollchoices as $activepollchoice): ?>

					<div class="form-check">
					<?php $x = 1; ?>
					<input class="form-check-input" type="radio"   id="<?php $activepollchoice['id']; ?>"  value="<?php echo $activepollchoice['id']; ?>"  name="choice">
					<label class="form-check-label" for="<?php $activepollchoice['id']; ?>"><?php echo $activepollchoice['choice']; ?> </label>
					</div>
					<?php endforeach ?>
					</br>
					<input class="btn btn-secondary" type="submit" class="btn btn-secondary" value="Submit" name="submit">
					</form>
											</div>
											<div class="card-footer text-muted">
												Thank you for your vote
											</div>
											</div>
					<?php }else{ ?>
						<div class="card my-4">

							<h5 class="card-header"><?php echo $activepoll['question']; ?></h5>
							<div class="card-body">


								<?php 	foreach($activepollchoices as $activepollchoice): ?>
									<?php $choice_id = $activepollchoice['id'];	?>
									<?php $votecounter = CountPollAnswers($choice_id); ?>
									<?php 	foreach($votecounter as $votecount): ?>
									<?php echo $activepollchoice['choice'] . "<span class=text-muted voteposition> (" .  $votecount . " Votes)</span> </br>";?>
									<?php endforeach ?>
								<?php endforeach ?>
							</div>
							<div class="card-footer text-muted">
								Thank you for your vote
							</div>
							</div>
					<?php } ?>
					<?php }else{ ?>


												<?php } ?>


					<?php }else{ ?>

					<?php     if(!empty($activepoll)){      ?>
				
							<div class="card my-4">

								<h5 class="card-header"><?php echo $activepoll['question']; ?></h5>
								<div class="card-body">
									<form action="vote.php" method="post">
									<?php 	foreach($activepollchoices as $activepollchoice): ?>

										<div class="form-check">
									<?php $x = 1; ?>
									<input class="form-check-input" type="radio"   id="<?php $activepollchoice['id']; ?>"  value="<?php echo $activepollchoice['id']; ?>"  name="choice">
									<label class="form-check-label" for="<?php $activepollchoice['id']; ?>"><?php echo $activepollchoice['choice']; ?> </label>
										</div>
									<?php endforeach ?>
									</br>
					Please log in to vote
								</div>

								</div>
					<?php }else{ ?>

					<?php } ?>

					<?php } ?>








	        <!-- Side Widget -->
					<div class="card my-4">
	 				 <h5 class="card-header">About Us</h5>
	 				 <div class="card-body">
	 					 We try to bring you the best and most actual news from the world of sport every day. Accurate facts from our hasty authors will always keep you informed. We sincerely hope that you enjoy our content and will stay tuned for more to come. Good rest of the day to you!
	 				 </div>
	 				 <div class="card-footer text-muted">
	 					 <?php echo "Today is " . date("d.m.y") . "<br>";?>
	 				 </div>
	 			 </div>

	      </div>

	    </div>
	    <!-- /.row -->

	  </div>
	  <!-- /.container -->

	

<?php include( ROOT_PATH . '/includes/footer.php'); ?>