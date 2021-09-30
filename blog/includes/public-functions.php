<?php

/* * * * * * * * * * * * * * *
* Returns all published posts
* * * * * * * * * * * * * * */
function getPublishedPosts() {
	// use global $conn object in function
	global $conn;
	$sql = "SELECT * FROM posts WHERE published=true";
  $result = mysqli_query($conn, $sql);
	// fetch all posts as an associative array called $posts
	//$posts = mysqli_fetch_all($result, MYSQLI_ASSOC);
	$posts = mysqli_fetch_array($result);


	$final_posts = array();
	foreach ($posts as $post) {
		$post['topic'] = getPostTopic($post['id']);
		array_push($final_posts, $post);
	}
	return $final_posts;
}

/* * * * * * * * * * * * * * *
* Returns all recent posts
* * * * * * * * * * * * * * */
function getRecentPosts() {
	// use global $conn object in function
	global $conn;
	$sql = "SELECT * FROM posts WHERE published=true ORDER BY created_at DESC LIMIT 4";
  $result = mysqli_query($conn, $sql);
	// fetch all posts as an associative array called $posts
	//$posts_recent = mysqli_fetch_all($result, MYSQLI_ASSOC);
	$posts_recent = mysqli_fetch_array($result);
  $final_posts_recent = array();
	foreach ($posts_recent as $post_recent) {
		$post_recent['topic'] = getPostTopic($post_recent['id']);
		array_push($final_posts_recent, $post_recent);
	}
	return $final_posts_recent;
}



/* * * * * * * * * * * * * * *
* Receives a post id and
* Returns topic of the post
* * * * * * * * * * * * * * */
function getPostTopic($post_id){
	global $conn;
	$sql = "SELECT * FROM topics WHERE id=
			(SELECT topic_id FROM post_topic WHERE post_id=$post_id) LIMIT 1";
	$result = mysqli_query($conn, $sql);
	$topic = mysqli_fetch_assoc($result);
	return $topic;
}


/* * * * * * * * * * * * * * * *
* Returns all posts under a topic
* * * * * * * * * * * * * * * * */
function getPublishedPostsByTopic($topic_id) {
	global $conn;
	$sql = "SELECT * FROM posts ps
			WHERE ps.id IN
			(SELECT pt.post_id FROM post_topic pt
				WHERE pt.topic_id=$topic_id AND ps.published = true GROUP BY pt.post_id
				HAVING COUNT(1) = 1)";
	$result = mysqli_query($conn, $sql);
	// fetch all posts as an associative array called $posts
	$posts = mysqli_fetch_all($result, MYSQLI_ASSOC);

	$final_posts = array();
	foreach ($posts as $post) {
		$post['topic'] = getPostTopic($post['id']);
		array_push($final_posts, $post);
	}
	return $final_posts;
}
/* * * * * * * * * * * * * * * *
* Returns topic name by topic id
* * * * * * * * * * * * * * * * */
function getTopicNameById($id)
{
	global $conn;
	$sql = "SELECT name FROM topics WHERE id=$id";
	$result = mysqli_query($conn, $sql);
	$topic = mysqli_fetch_assoc($result);
	return $topic['name'];
}



/* * * * * * * * * * * * * * *
* Returns a single post
* * * * * * * * * * * * * * */
function getPost($slug){
	global $conn;
	// Get single post slug
	$post_slug = $_GET['post-slug'];
	$sql = "SELECT * FROM posts WHERE slug='$post_slug' AND published=true";
	$result = mysqli_query($conn, $sql);

	// fetch query results as associative array.
	$post = mysqli_fetch_assoc($result);
	if ($post) {
		// get the topic to which this post belongs
		$post['topic'] = getPostTopic($post['id']);
	}
	return $post;
}
/* * * * * * * * * * * *
*  Returns all topics
* * * * * * * * * * * * */
function getAllTopics()
{
	global $conn;
	$sql = "SELECT * FROM topics";
	$result = mysqli_query($conn, $sql);
	//$topics = mysqli_fetch_all($result, MYSQLI_ASSOC);
	$topics = mysqli_fetch_array($result);
	return $topics;
}


/*******************************
POLL FUNCTIONS
********************************/


/* * * * * * * * * * * *
*  Returns all polls
* * * * * * * * * * * * */
function GetAllPolls(){
	global $conn;
	$sql = "SELECT * FROM polls";
	$result = mysqli_query($conn, $sql);
	$allpolls = mysqli_fetch_all($result, MYSQLI_ASSOC);
	return $allpolls;
}

/* * * * * * * * * * * *
*  Returns active poll
* * * * * * * * * * * * */
function GetActivePoll(){
	global $conn;
	$sql = "SELECT * FROM polls WHERE active = 1";
	$result = mysqli_query($conn, $sql);
	$activepoll = mysqli_fetch_assoc($result);
	return $activepoll;
}

/* * * * * * * * * * * *
*  Returns choices of active poll
* * * * * * * * * * * * */
function GetActivePollChoices(){
global $conn;
$sql = "SELECT * FROM polls LEFT JOIN polls_choices ON polls.id = polls_choices.poll_id where polls.active = 1";
$result = mysqli_query($conn, $sql);
//$allpolls = mysqli_fetch_all($result, MYSQLI_ASSOC);
$allpolls = mysqli_fetch_array($result);
return $allpolls;
}

/* * * * * * * * * * * *
*  Inserts users choice into DB
* * * * * * * * * * * * */
function VotePoll(){
	global $conn;
 $userid = $_SESSION['user']['id'];
	$pollchoice = $_POST['choice'];
	$poll_var = GetActivePoll();
	$poll = $poll_var['id'];
	if (isset($_SESSION['user']['username'])) {
		if (isset($_POST['choice'])){
			if(empty($usercheck)){

	$query = "INSERT INTO polls_answers (user_id, poll_id, choice_id)
	VALUES('$userid', '$poll', '$pollchoice')";
	mysqli_query($conn, $query);
	header('location: index.php');
}
}
}
}
/* * * * * * * * * * * *
*  Gets all answers of active poll
* * * * * * * * * * * * */
function PollAnswers(){
global $conn;
$sql = "SELECT * FROM polls_answers JOIN polls ON polls_answers.poll_id = polls.id WHERE polls.active = 1";
$result = mysqli_query($conn, $sql);
$activepollanswers = $result;
return $activepollanswers;
}
/* * * * * * * * * * * *
*  Counts answers of poll
* * * * * * * * * * * * */
function CountPollAnswers($choice_id){
global $conn;
$sql = "SELECT count(choice_id) FROM polls_answers WHERE choice_id = '$choice_id'" ;
$result = mysqli_query($conn, $sql);
$answercounter = mysqli_fetch_assoc($result);
return $answercounter;
}


/* * * * * * * * * * * *
*  Checks whether the user has already voted on the poll
* * * * * * * * * * * * */
function PollUserCheck(){
global $conn;
if(isset($_SESSION['user'])){


$userid = $_SESSION['user']['id'];
$sql = "SELECT user_id FROM polls_answers WHERE user_id = '$userid'";
$result = mysqli_query($conn, $sql);
$usercheck = mysqli_fetch_assoc($result);
return $usercheck;
}else{

}

}





/* * * * * * * * * * * *
*  Returns a shortened version of post body for preview
* * * * * * * * * * * * */
	function echo_limit($string, $length){
	if(strlen($string)<=$length){
	return $string;
	}
	else{
	$y=substr($string,0,$length) . '...';
	return $y;
	}
}

/* * * * * * * * * * * *
*  Counts visit on a post
* * * * * * * * * * * * */
function VisitCount($post_id){
global $conn;
$sql = "UPDATE posts SET visits=visits+1 WHERE id = '$post_id'";
mysqli_query($conn, $sql);
}

/* * * * * * * * * * * *
*  Counts unique visits on a post
* * * * * * * * * * * * */
function UniqueVisitCount($post_id){
global $conn;
$client_ip = $_SERVER['REMOTE_ADDR'];
$SQL = "SELECT * FROM unique_visits WHERE ip_address = '$client_ip' AND post_id = '$post_id' ";
$result = mysqli_query($conn, $SQL);
$unique_visit_check = mysqli_fetch_assoc($result);
if(empty($unique_visit_check)){
$SQL_2 = "INSERT INTO unique_visits (ip_address, post_id) VALUES ('$client_ip', '$post_id')";
		mysqli_query($conn, $SQL_2);
$SQL_3 = "UPDATE posts SET unique_visits=unique_visits+1 WHERE id = '$post_id'";
		mysqli_query($conn, $SQL_3);
}
}


/* * * * * * * * * * * *
*  Returns username of user ID
* * * * * * * * * * * * */

function GetUsernameById($user_id){
global $conn;
$SQL = "SELECT username FROM users WHERE id = '$user_id'";
$result = mysqli_query($conn, $SQL);
$username = mysqli_fetch_assoc();
return $result['username'];
}

/* * * * * * * * * * * *
*  Returns rating of a post
* * * * * * * * * * * * */

function GetRatingByPostId($post_id){
global $conn;
$SQL = "SELECT rating FROM ratings WHERE post_id  = '$post_id'";
$result = mysqli_query($conn, $SQL);
$ratings = mysqli_fetch_all($result, MYSQLI_ASSOC);
if(!empty($ratings)){
$x = 0;
$count = 0;
foreach($ratings as $row){
$x = $x + $row['rating'];
$count++;	
}
$average_rating  = $x / $count;
$average_rating = round($average_rating,2);
$message = 'The average rating is ' . $average_rating;
}else{
$message = "Nobody has rated this post yet";	
}
return $message;


}



/* * * * * * * * * * * *
*  Returns all comments of a post
* * * * * * * * * * * * */
function GetAllComments($post_id){
   
    global $conn;
	$comments_query_result = mysqli_query($conn, "SELECT * FROM comments WHERE post_id=" . $post_id . " ORDER BY created_at DESC");
    $comments = mysqli_fetch_all($comments_query_result, MYSQLI_ASSOC);
    return $comments;
}



/* * * * * * * * * * * *
*  Inserts comment into DB
* * * * * * * * * * * * */

	if (isset($_POST['comment_posted'])) {
		$post_id = $_SESSION['post_id'];
		$user_id = $_SESSION['user']['id'];

		global $conn;
		// grab the comment that was submitted through Ajax call
		$comment_text = $_POST['comment_text'];
		$comment_text = esc($comment_text);
		// insert comment into database
		$sql = "INSERT INTO comments (user_id, post_id, body, created_at, updated_at) VALUES ('$user_id', '$post_id', '$comment_text', now(), null)";
		$result = mysqli_query($conn, $sql);
		// Query same comment from database to send back to be displayed
		$inserted_id = $conn->insert_id;
		$res = mysqli_query($conn, "SELECT * FROM comments WHERE id=$inserted_id");
		$inserted_comment = mysqli_fetch_assoc($res);
		// if insert was successful, get that same comment from the database and return it
		if ($result) {
			$comment = "<div class='comment clearfix'>
					
						<div class='comment-details'>
							<span class='comment-name'>" . getUsernameById($inserted_comment['user_id']) . "</span>
							<span class='comment-date'>" . date('F j, Y ', strtotime($inserted_comment['created_at'])) . "</span>
							<p>" . $inserted_comment['body'] . "</p>
							
						</div>
						
					</div>";
			$comment_info = array(
				'comment' => $comment,
			
			);
			echo json_encode($comment_info);
			exit();
		} else {
			echo "error";
			exit();
		}
	}


if(isset($_POST['save'])){
global $conn;
$post_id  = $_SESSION['post_id'];
$ratedIndex = $_POST['ratedIndex'];
$ratedIndex++;
$sql = "INSERT INTO ratings (post_id, rating) VALUES ('$post_id', '$ratedIndex')";
$result = mysqli_query($conn,$sql);

}	
/* * * * * * * * * * * *
*  Escape
* * * * * * * * * * * * */

function esc($value){
	// bring the global db connect object into function
	global $conn;
	// remove empty space sorrounding string
	$val = trim($value);
	$val = mysqli_real_escape_string($conn, $value);
	return $val;
}

?>
