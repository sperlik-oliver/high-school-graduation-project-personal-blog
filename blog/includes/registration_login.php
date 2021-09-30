<?php  include('includes/public-functions.php'); ?>
<?php

	// variable declaration
	$username = "";
	$email    = "";
	$errors = array();

	// REGISTER USER
	if (isset($_POST['reg_user'])) {
		// receive all input values from the form
		$username = esc($_POST['username']);
		$email = esc($_POST['email']);
		$password_1 = esc($_POST['password_1']);
		$password_2 = esc($_POST['password_2']);

		// form validation: ensure that the form is correctly filled
		if (empty($username)) {  array_push($errors, "<div class=errortext>Uhmm...We gonna need your username</div>"); }
		if (empty($email)) { array_push($errors, "<div class=errortext>Oops.. Email is missing</div>"); }
		if (empty($password_1)) { array_push($errors, "<div class=errortext>uh-oh you forgot the password</div>"); }
		if ($password_1 != $password_2) { array_push($errors, "<div class=errortext>The two passwords do not match</div>");}

		// Ensure that no user is registered twice.
		// the email and usernames should be unique
		$user_check_query = "SELECT * FROM users WHERE username='$username'
								OR email='$email' LIMIT 1";

		$result = mysqli_query($conn, $user_check_query);
		$user = mysqli_fetch_assoc($result);

		if ($user) { // if user exists
			if ($user['username'] === $username) {
			  array_push($errors, "<div class=errortext>Username already exists</div>");
			}
			if ($user['email'] === $email) {
			  array_push($errors, "<div class=errortext>Email already exists</div>");
			}
		}
		// register user if there are no errors in the form
		if (count($errors) == 0) {
			$password = md5($password_1);//encrypt the password before saving in the database
			$query = "INSERT INTO users (username, email, password, created_at, updated_at)
					  VALUES('$username', '$email', '$password', now(), now())";
			mysqli_query($conn, $query);

			// get id of created user
			$reg_user_id = mysqli_insert_id($conn);

			// put logged in user into session array
			$_SESSION['user'] = getUserById($reg_user_id);

			// if user is admin, redirect to admin area
			if ( in_array($_SESSION['user']['role'], ["Admin", "Author"])) {
			
				// redirect to admin area
				header('location: ' . BASE_URL . 'admin/dashboard.php');
				exit(0);
			} else {
			
				// redirect to public area
				header('location: index.php');
				exit(0);
			}
		}
	}

	// LOG USER IN
	if (isset($_POST['login_btn'])) {
		$username = esc($_POST['username']);
		$password = esc($_POST['password']);
		if($username == 'Guest'){ array_push($errors, "<div class=errortext>Missing permission</div>"); }
		if (empty($username)) { array_push($errors, "<div class=errortext>Username required</div>"); }
		if (empty($password)) { array_push($errors, "<div class=errortext>Password required</div>"); }
		if (empty($errors)) {
			$password = md5($password); // encrypt password
			$sql = "SELECT * FROM users WHERE username='$username' AND password='$password' LIMIT 1";

			$result = mysqli_query($conn, $sql);
			if (mysqli_num_rows($result) > 0) {
				// get id of created user
				$reg_user_id = mysqli_fetch_assoc($result)['id'];

				// put logged in user into session array
				$_SESSION['user'] = getUserById($reg_user_id);

				// if user is admin, redirect to admin area
				if ( in_array($_SESSION['user']['role'], ["Admin", "Author"])) {
					
					// redirect to admin area
					header('location: admin/dashboard.php');
					exit(0);
				} else {
					
					// redirect to public area
					header('location: index.php');
					exit(0);
				}
			} else {
				array_push($errors, '<div class=errortext>Wrong credentials</div>');
			}
		}
	}
	// escape value from form

	// Get user info from user id
	function getUserById($id)
	{
		global $conn;
		$sql = "SELECT * FROM users WHERE id=$id LIMIT 1";

		$result = mysqli_query($conn, $sql);
		$user = mysqli_fetch_assoc($result);

		// returns user in an array format:
		// ['id'=>1 'username' => 'Awa', 'email'=>'a@a.com', 'password'=> 'mypass']
		return $user;
	}
?>
