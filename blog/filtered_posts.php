<?php require_once('config.php')?>
<?php require_once( ROOT_PATH . '/includes/public-functions.php') ?>
<?php $activepoll = GetActivePoll(); ?>
<?php $activepollchoices = GetActivePollChoices(); ?>
<?php $posts = getPublishedPosts(); ?>
<?php $usercheck =  PollUserCheck(); ?>
<?php $activepollanswers = PollAnswers(); ?>
<?php require_once(ROOT_PATH . '/includes/head.php') ?>
<?php

// Get posts under a particular topic
if (isset($_GET['topic'])) 
{
	$topic_id = $_GET['topic'];
	$posts = getPublishedPostsByTopic($topic_id);
}
?>

<title>SportsNews | <?php echo getTopicNameById($topic_id); ?> </title>
</head>
<body>
	
<?php include(ROOT_PATH . '/includes/navbar.php') ?>
		

<div class="container">
	<div class="row">
   		<div class="col-md-8">
		     <h2 class="my-4"><?php echo getTopicNameById($topic_id); ?></h2>

<!-- Blog Post -->

<?php foreach ($posts as $post): ?>
		  
		        <div class="card mb-4">
		          <img class="card-img-top img-max" src="<?php echo BASE_URL . '/static/images/' . $post['image']; ?>" alt="">
		          <div class="card-body">
		            <h2 class="card-title"><?php echo $post['title'] ?></h2>

								<?php $postbody = html_entity_decode($post['body']);?>

		            <p class="card-text"><?php echo echo_limit($postbody, 300); ?></p>
		            <a href="single_post.php?post-slug=<?php echo $post['slug']; ?>" class="btn btn-primary">Read More &rarr;</a>
		          </div>
		          <div class="card-footer text-muted">
		           <?php echo date("F j, Y ", strtotime($post["created_at"])); ?>
		          </div>
		        </div>
<?php endforeach ?>
 				</div>

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

<!-- footer -->
<?php include( ROOT_PATH . '/includes/footer.php') ?>

</div>

