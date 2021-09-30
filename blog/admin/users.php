<?php  include('../config.php'); ?>
<?php  include(ROOT_PATH . '/admin/includes/admin_functions.php'); ?>

<?php if(isset($_SESSION['user'])){ ?>
<?php if ($_SESSION['user']['role'] == 'Admin'){ ?>

<?php
	// Get all admin users from DB
	$admins = getAdminUsers();
	$roles = ['Admin', 'Author'];
	$users = getAllUsers();
?>
<?php include(ROOT_PATH . '/admin/includes/head_section.php'); ?>
	<title>Admin | Users</title>
</head>
<body>
	<!-- admin navbar -->
	<?php include(ROOT_PATH . '/admin/includes/navbar.php') ?>
	<div class="container-content-users">
		<!-- Left side menu -->

		<!-- Middle form - to create and edit  -->
		<div class="action">
			<h1 class="page-title">Admin Users</h1>

			<form method="post" action="<?php echo './users.php'; ?>" >

				<!-- validation errors for the form -->
				<?php include(ROOT_PATH . '/includes/errors.php') ?>

				<!-- if editing user, the id is required to identify that user -->
				<?php if ($isEditingUser === true): ?>
					<input type="hidden" name="admin_id" value="<?php echo $admin_id; ?>">
				<?php endif ?>

				<input type="text" name="username" value="<?php echo $username; ?>" placeholder="Username">
				<input type="email" name="email" value="<?php echo $email ?>" placeholder="Email">
				<input type="password" name="password" placeholder="Password">
				<input type="password" name="passwordConfirmation" placeholder="Password confirmation">
				<select name="role">
		<?php if ($isEditingUser === true): ?>
					<option value="<?php echo $adminrole ?>"selected><?php echo $adminrole ?></option>
			<?php foreach ($roles as $key => $role): ?>
				<?php if($adminrole != $role): ?>
						<option value="<?php echo $role; ?>"><?php echo $role; ?></option>
				<?php endif ?>		
			<?php endforeach ?>
		<?php else: ?>
			<option value=""selected disabled>Choose role</option>
			<?php foreach ($roles as $key => $role): ?>
				
						<option value="<?php echo $role; ?>"><?php echo $role; ?></option>
						
			<?php endforeach ?>
		<?php endif ?>	
				</select>

				<!-- if editing user, display the update button instead of create button -->
				<?php if ($isEditingUser === true): ?>
					<button type="submit" class="btn" name="update_admin">UPDATE</button>
				<?php else: ?>
					<button type="submit" class="btn" name="create_admin">Save User</button>
				<?php endif ?>
			</form>
		</div>
		<!-- // Middle form - to create and edit -->

		<!-- Display records from DB-->
		<div class="table-div-users-admin">
			<!-- Display notification message -->
			<?php include(ROOT_PATH . '/includes/messages.php') ?>

			<?php if (empty($admins)): ?>
				<h1>No admins in the database.</h1>
			<?php else: ?>
				<table class="table">
					<thead>
						<th>ID</th>
						<th>Name</th>
						<th>Email</th>
						<th>Role</th>
						<th colspan="2">Action</th>
					</thead>
					<tbody>
					<?php foreach ($admins as $key => $admin): ?>
						<tr>
							<td><?php echo $admin['id']; ?></td>
							<td>
								<?php echo $admin['username']; ?> &nbsp;
									</td>
									<td>
								<?php echo $admin['email']; ?>
							</td>
							<td><?php echo $admin['role']; ?></td>
							<td>
								<a class="fa fa-pencil btn edit"
									href="users.php?edit-admin=<?php echo $admin['id'] ?>">
								</a>
							</td>
							<td>
							<?php if($key != 0): ?>
								<a class="fa fa-trash btn delete"
								    href="users.php?delete-admin=<?php echo $admin['id'] ?>">
								</a>
								<?php endif ?>	
							</td>
						</tr>
					<?php endforeach ?>
					</tbody>
				</table>
			<?php endif ?>
		</div>
	</div>







	<div class="container-content-users">


	
		<div class="action">
			<h1 class="page-title">Guests</h1>
    </div>


	<!-- Display records from DB-->
	<div class="table-div-users">
		<!-- Display notification message -->
		<?php include(ROOT_PATH . '/includes/messages.php') ?>

		<?php if (empty($users)): ?>
			<h1>No users in the database.</h1>
		<?php else: ?>
			<table class="table">
				<thead>
					<th>ID</th>
					<th>Name</th>
					<th>Email</th>

					<th>Action</th>
				</thead>
				<tbody>
				<?php foreach ($users as $key => $user): ?>
				<?php if($user['id'] != '2'):?>
					<tr>
						<td><?php echo $user['id']; ?></td>
						<td>
							<?php echo $user['username']; ?> &nbsp;
								</td>
								<td>
							<?php echo $user['email']; ?>
						</td>


						<td>
							<a class="fa fa-trash btn delete"
									href="users.php?delete-admin=<?php echo $user['id'] ?>">
							</a>
						</td>
					</tr>
				<?php endif; ?>
				<?php endforeach ?>
				</tbody>
			</table>
		<?php endif ?>
	</div>
</div>
	<!-- // Display records from DB -->
</body>
</html>

<?php }else{ ?>
	Missing permission
<?php } ?>
		<?php }else{ ?>
			Missing permission

		<?php } ?>
