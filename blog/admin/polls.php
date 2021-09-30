<?php  include('../config.php'); ?>
<?php  include(ROOT_PATH . '/admin/includes/admin_functions.php'); ?>
<?php include(ROOT_PATH . '/admin/includes/head_section.php'); ?>


<?php if(isset($_SESSION['user'])){ ?>
<?php if ($_SESSION['user']['role'] == 'Admin'){ ?>



<!-- Get all topics from DB -->
<?php $polls = getAllPolls();	?>
	<title>Admin | Manage Polls</title>
</head>
<body>
	<!-- admin navbar -->
	<?php include(ROOT_PATH . '/admin/includes/navbar.php') ?>
	<div class="container-content-topics">

		<!-- Middle form - to create and edit -->
		<div class="action">
			<h1 class="page-title">Create/Edit Polls</h1>
			<form method="post" action="<?php echo 'polls.php'; ?>" >
				<!-- validation errors for the form -->
				<?php include(ROOT_PATH . '/includes/errors.php') ?>
				<!-- if editing topic, the id is required to identify that topic -->
				<?php if ($isEditingTopic === true): ?>
					<input type="hidden" name="topic_id" value="<?php echo $topic_id; ?>">
				<?php endif ?>
				<input type="text" name="topic_name" value="<?php echo $topic_name; ?>" placeholder="Topic">
				<!-- if editing topic, display the update button instead of create button -->
				<?php if ($isEditingTopic === true): ?>
					<button type="submit" class="btn" name="update_topic">UPDATE</button>
				<?php else: ?>
					<button type="submit" class="btn" name="create_topic">Save Topic</button>
				<?php endif ?>
			</form>
		</div>
		<!-- // Middle form - to create and edit -->

		<!-- Display records from DB-->
		<div class="table-div-topics">
			<!-- Display notification message -->
			<?php include(ROOT_PATH . '/includes/messages.php') ?>
			<?php if (empty($polls)): ?>
				<h1>No polls in the database.</h1>
			<?php else: ?>
				<table class="table">
					<thead>
						<th>ID</th>
						<th>Question</th>
                        <th>Active</th>
						<th colspan="2">Action</th>
					</thead>
					<tbody>
                    
                    <?php 
                    
                    foreach ($polls as $key => $poll): ?>
						<tr>
							<td><?php echo $key + 1; ?></td>
							<td><?php echo $poll['question']; ?></td>
                            <td><?php echo $poll['active']; ?></td>
							<td>
								<a class="fa fa-pencil btn edit"
									href="topics.php?edit-topic=<?php echo $topic['id'] ?>">
								</a>
							</td>
							<td>
								<a class="fa fa-trash btn delete"
									href="topics.php?delete-topic=<?php echo $topic['id'] ?>">
								</a>
							</td>
						</tr>
					<?php endforeach ?>
					</tbody>
				</table>
			<?php endif ?>
		</div>
		<!-- // Display records from DB -->
	</div>
</body>
</html>

<?php }else{ ?>
Missing permission
<?php } ?>
		<?php }else{ ?>
			Missing permission

		<?php } ?>
